<?php

namespace App\Http\Controllers;

use App\Declaratie;
use App\DeclaratieDeelname;
use App\Lid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeclaratiesController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->lid_id;

        //$declaraties = Declaratie::select('*')->leftJoin('lid','lid.lid_id','declaratie.created_by_id')->groupBy('declaratie.declaratie_id')->orderBy('datum', 'desc')->paginate(10);
        $declaraties = Declaratie::select('declaratie.declaratie_id','betaald_door_id','datum','declaratie.bedrag','omschrijving','created_by_id')->join('declaratie_deelname', function($join) use ($user_id){
            $join->on('declaratie.declaratie_id','declaratie_deelname.declaratie_id');
        })->orWhere(function ($query) use ($user_id){
        $query->orWhere('declaratie.created_by_id', '=', $user_id)
            ->orWhere('declaratie.betaald_door_id', '=', $user_id)
            ->orWhere('declaratie_deelname.lid_id', '=', $user_id);
        })->groupBy('declaratie.declaratie_id')->orderBy('datum', 'desc')->paginate(10);


        return view('declaraties/index', compact('declaraties'));
    }

    public function create()
    {
        $leden = Lid::ledenGesorteerd()->get();
        $actieve_leden = Lid::actieveLeden()->get();
        $passieve_leden = Lid::passieveLeden()->get();
        $reunisten = Lid::reunisten()->get();
        $geen_lid = Lid::geenLeden()->get();
        $declaratie = new Declaratie();
        return view('declaraties/create', compact('declaratie','leden','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function store()
    {
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'betaald_door_id' => 'required|numeric',
            'omschrijving' => 'required|max:100000',
            'created_by_id' => 'required'
            ]);

        $deelnemers = request()->validate([
            'deelnemers'=> 'required'
        ]);
        $declaratie = Declaratie::create($data);

        subtract_verschuldigd($declaratie->betaald_door_id, $declaratie->bedrag);

        $this->add_declaratie_deelname($deelnemers['deelnemers'], $declaratie);

        return redirect('/declaratie/' . $declaratie->declaratie_id);
    }

    public function show(Declaratie $declaratie)    {
        $leden_deelname = Lid::join('declaratie_deelname', 'lid.lid_id', '=', 'declaratie_deelname.lid_id')->where('declaratie_deelname.declaratie_id', $declaratie->declaratie_id)->ledenGesorteerd()->get();
        $declaratie = Declaratie::select('declaratie_id','betaald_door_id','created_by_id','bedrag','datum','omschrijving','lid1.roepnaam as lid1_roepnaam','lid1.achternaam as lid1_achternaam','lid2.roepnaam as lid2_roepnaam','lid2.achternaam as lid2_achternaam')
        ->leftJoin('lid as lid1','lid1.lid_id','declaratie.betaald_door_id')
        ->leftJoin('lid as lid2','lid2.lid_id','declaratie.created_by_id')
        ->where('declaratie.declaratie_id', $declaratie->declaratie_id)->first();
        //dd($declaratie);
        return view('declaraties/show', compact('declaratie' , 'leden_deelname'));
    }

    public function edit(Declaratie $declaratie)
    {
        $id = $declaratie->declaratie_id;
        $leden = Lid::ledenGesorteerd()->get();

        $actieve_leden = Lid::lidDeelname('declaratie_deelname','declaratie_id',$id)->actieveLeden()->get();
        $passieve_leden = Lid::lidDeelname('declaratie_deelname','declaratie_id',$id)->passieveLeden()->get();
        $reunisten = Lid::lidDeelname('declaratie_deelname','declaratie_id',$id)->reunisten()->get();
        $geen_lid = Lid::lidDeelname('declaratie_deelname','declaratie_id',$id)->geenLeden()->get();

        return view('declaraties/edit', compact('declaratie', 'leden','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function update(Declaratie $declaratie)    {
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'betaald_door_id' => 'required|numeric',
            'omschrijving' => 'required|max:100000',
            'created_by_id' => 'required'
        ]);
        $deelnemers = request()->validate([
            'deelnemers'=> 'required'
        ]);

        $this->remove_declaratie_deelname($declaratie);
        $declaratie->update($data);

        subtract_verschuldigd($declaratie->betaald_door_id, $declaratie->bedrag);
        $this->add_declaratie_deelname($deelnemers['deelnemers'], $declaratie);

        return redirect('/declaratie/' . $declaratie->declaratie_id);
    }


    public function destroy(Declaratie $declaratie){
        $this->remove_declaratie_deelname($declaratie);
        $declaratie->delete();
        return redirect('/declaraties');
    }

    public function add_declaratie_deelname($deelnemers, $declaratie){
        $bedragen = divide_money($declaratie->bedrag, count($deelnemers));
        $i = 1;
        foreach ($deelnemers as $lid) {
            add_verschuldigd($lid, $bedragen[$i]);
            $declaratie_deelname = new DeclaratieDeelname;
            $declaratie_deelname->lid_id = $lid;
            $declaratie_deelname->declaratie_id = $declaratie->declaratie_id;
            $declaratie_deelname->bedrag = $bedragen[$i];
            $declaratie_deelname->save();
            $i++;
        }
    }

    public function remove_declaratie_deelname($declaratie){
        add_verschuldigd($declaratie->betaald_door_id, $declaratie->bedrag);
        $declaratie_id = $declaratie->declaratie_id;
        $deelnemers = Lid::select('lid.lid_id','declaratie_deelname.bedrag as bedrag')->join('declaratie_deelname', function($join) use ($declaratie_id){
            $join->on('lid.lid_id','declaratie_deelname.lid_id');
            $join->where('declaratie_deelname.declaratie_id',$declaratie_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $deelnemer->bedrag);
            DeclaratieDeelname::where('lid_id',$deelnemer->lid_id)->where('declaratie_id',$declaratie_id)->delete();
        }
    }

}
