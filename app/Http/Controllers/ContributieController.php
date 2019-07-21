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
        return view('contributies/contributies',['contributies' => $contributies]);
    }

    public function contributie($id){
        $contributie = Contributie::find($id);
        $leden_deelname = Lid::join('contributie_deelname','lid.lid_id','=','contributie_deelname.lid_id')->where('contributie_deelname.contributie_id','=',$id)->get();

        return view('contributies/contributie',['contributie' => $contributie, 'leden_deelname' => $leden_deelname]);
    }

    public function toevoegen(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('contributies/contributie_toevoegen',['leden' => $leden]);
    }

    public function wijzigen($id){
        $contributie = Contributie::find($id);
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','contributie_deelname.lid_id as deelname','type_lid')->leftJoin('contributie_deelname', function($join) use ($id){
            $join->on('lid.lid_id','contributie_deelname.lid_id');
            $join->where('contributie_deelname.contributie_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('contributies/contributie_wijzigen', ['contributie' => $contributie, 'leden_deelname' => $leden_deelname, 'leden'=>$leden]);
    }

    public function insert_update_contributie(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric',
            'contributie_soort' => 'required|max:255',
            'deelnemers'=>'required']);

        if(isset($request->contributie_id)){
            $contributie = Contributie::find($request->contributie_id);
            $this->remove_contributie_deelname($contributie);
        }else{
            $contributie = new Contributie;
        }

        $contributie->datum = $request->datum;
        $contributie->bedrag = $request->bedrag;
        $contributie->omschrijving = $request->contributie_soort;
        $contributie->save();

        $this->add_contributie_deelname($request->deelnemers, $contributie);

        return redirect('/contributie/' . $contributie->contributie_id);
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


    //todo verwijder functie

}
