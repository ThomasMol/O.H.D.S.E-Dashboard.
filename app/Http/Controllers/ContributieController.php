<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contributie;
use App\ContributieDeelname;
use App\Lid;
use App\SErekening;

class ContributieController extends Controller
{
    public function index(){
        $contributies = Contributie::all();
        return view('contributies/contributies',compact('contributies'));
    }

    public function create(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('contributies/contributie_toevoegen',compact('leden'));
    }

    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'contributie_soort' => 'required|max:255'

        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);
        $contributie = Contributie::create($data);
        $this->add_contributie_deelname($deelnemers['deelnemers'], $contributie);
        return redirect('/contributie/' . $contributie->contributie_id);

    }

    public function show(Contributie $contributie){
        $leden_deelname = Lid::join('contributie_deelname','lid.lid_id','=','contributie_deelname.lid_id')->where('contributie_deelname.contributie_id','=',$contributie->contributie_id)->get();
        return view('contributies/contributie',compact('contributie','leden_deelname'));
    }

    public function edit(Contributie $contributie){
        $id = $contributie->contributie_id;
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','contributie_deelname.lid_id as deelname','type_lid')->leftJoin('contributie_deelname', function($join) use ($id){
            $join->on('lid.lid_id','contributie_deelname.lid_id');
            $join->where('contributie_deelname.contributie_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('contributies/contributie_wijzigen', compact('contributie','leden_deelname','leden'));
    }

    public function update(Contributie $contributie){
        $id = $contributie->contributie_id;
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'contributie_soort' => 'required|max:255'

        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);

        $this->remove_contributie_deelname($contributie);
        $contributie->update($data);
        $this->add_contributie_deelname($deelnemers['deelnemers'],$contributie);
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
        echo $deelnemers;
        foreach($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $contributie->bedrag);
            ContributieDeelname::where('lid_id', $deelnemer->lid_id)->where('contributie_id', $contributie_id)->delete();
        }
    }
}
