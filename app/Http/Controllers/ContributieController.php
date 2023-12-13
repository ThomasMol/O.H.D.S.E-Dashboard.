<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Contributie;
use App\Models\ContributieDeelname;
use App\Models\Lid;
use App\Models\Bestuursjaar;
use App\Models\Inkomsten;


class ContributieController extends Controller
{
    public function index(){
        $contributies = Contributie::select('*','contributie.bedrag as bedrag')->join('inkomsten','inkomsten.inkomsten_id','=','contributie.inkomsten_id')->
        orderBy('datum','desc')->paginate(10);
        
        $deelname = Contributie::leftJoin('contributie_deelname', function ($join) {
            $join->on('contributie_deelname.contributie_id', '=', 'contributie.contributie_id')
                ->where('contributie_deelname.lid_id', Auth::user()->lid_id);
        })
        ->select('contributie.contributie_id', DB::raw('CASE WHEN contributie_deelname.contributie_id IS NOT NULL THEN contributie.bedrag ELSE 0 END AS naheffing'))
        ->orderBy('contributie.datum', 'desc')
        ->paginate(10);



        return view('contributies/index',compact('contributies', 'deelname'));
    }

    public function create(Bestuursjaar $bestuursjaar){
        $actieve_leden = Lid::actieveLeden()->get();
        $passieve_leden = Lid::passieveLeden()->get();
        $reunisten = Lid::reunisten()->get();
        $geen_lid = Lid::geenLeden()->get();

        $contributie = new Contributie();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();
        return view('contributies/create',compact('contributie','bestuursjaren','categorieen','bestuursjaar','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'inkomsten_id' => 'required|max:255'
        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);
        $contributie = Contributie::create($data);
        add_inkomsten_realisatie($contributie->inkomsten_id,$contributie->bedrag * count($deelnemers['deelnemers']));
        $this->add_contributie_deelname($deelnemers['deelnemers'], $contributie);
        return redirect('/contributie/' . $contributie->contributie_id);
    }

    public function show(Contributie $contributie){
        $leden_deelname = Lid::join('contributie_deelname','lid.lid_id','=','contributie_deelname.lid_id')->where('contributie_deelname.contributie_id','=',$contributie->contributie_id)->get();
        $contributie = Contributie::select('*','contributie.bedrag as bedrag')->join('inkomsten','inkomsten.inkomsten_id','=','contributie.inkomsten_id')->where('contributie.contributie_id',$contributie->contributie_id)->first();

        return view('contributies/show',compact('contributie','leden_deelname'));
    }

    public function edit(Contributie $contributie, Bestuursjaar $bestuursjaar){
        $id = $contributie->contributie_id;

        $actieve_leden = Lid::lidDeelname('contributie_deelname','contributie_id',$id)->actieveLeden()->get();
        $passieve_leden = Lid::lidDeelname('contributie_deelname','contributie_id',$id)->passieveLeden()->get();
        $reunisten = Lid::lidDeelname('contributie_deelname','contributie_id',$id)->reunisten()->get();
        $geen_lid = Lid::lidDeelname('contributie_deelname','contributie_id',$id)->geenLeden()->get();

        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        return view('contributies/edit', compact('contributie','categorieen','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function update(Contributie $contributie){
        $id = $contributie->contributie_id;
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'inkomsten_id' => 'required|max:255'
        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);
        $this->remove_contributie_deelname($contributie);
        $contributie->update($data);
        $this->add_contributie_deelname($deelnemers['deelnemers'],$contributie);
        add_inkomsten_realisatie($contributie->inkomsten_id, $contributie->bedrag * count($deelnemers['deelnemers']));
        return redirect('/contributie/' . $id);

    }

    public function destroy(Contributie $contributie){
        $this->remove_contributie_deelname($contributie);
        $contributie->delete();
        return redirect('/contributies');
    }

    public function add_contributie_deelname($deelnemers, $contributie){
        foreach ($deelnemers as $lid){
            add_verschuldigd($lid, $contributie->bedrag);
            $contributie_deelname = new ContributieDeelname;
            $contributie_deelname->lid_id = $lid;
            $contributie_deelname->contributie_id = $contributie->contributie_id;
            $contributie_deelname->save();
        }
    }

    public function remove_contributie_deelname($contributie){
        $contributie_id = $contributie->contributie_id;
        $deelnemers = Lid::join('contributie_deelname', function($join) use ($contributie_id){
            $join->on('lid.lid_id', 'contributie_deelname.lid_id');
            $join->where('contributie_deelname.contributie_id', $contributie_id);
        })->get();
        subtract_inkomsten_realisatie($contributie->inkomsten_id, $contributie->bedrag * count($deelnemers));

        foreach($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $contributie->bedrag);
            ContributieDeelname::where('lid_id', $deelnemer->lid_id)->where('contributie_id', $contributie_id)->delete();
        }
    }
}
