<?php

namespace App\Http\Controllers;

use App\DeclaratieDeelname;
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
        $leden_participatie = Lid::join('contributie_participatie','lid.lid_id','=','contributie_participatie.lid_id')->where('contributie_participatie.contributie_id','=',$id)->get();

        return view('contributies/contributie',['contributie' => $contributie, 'leden_participatie' => $leden_participatie]);
    }

    public function toevoegen(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('contributies/contributie_toevoegen',['leden' => $leden]);
    }

    public function wijzigen($id){
        $contributie = Contributie::where('contributie_id', $id)->first();
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();

        return view('contributies/contributie_wijzigen',['contributie' => $contributie, 'leden' => $leden]);
    }

    public function voeg_contributie_toe(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric',
            'contributie_soort' => 'required|max:255']);

        $contributie = new Contributie;
        $contributie->datum = $request->datum;
        $contributie->bedrag = $request->bedrag;
        $contributie->omschrijving = $request->contributie_soort;
        $contributie->save();

        $leden = Lid::all();
        $deelnemers = [];

        //todo moet dit wel? request->deelnemers is al array
        foreach($request->deelnemers as $id){
            array_push($deelnemers, $id);
        }

        if($deelnemers == 0){
            //TODO reject declaratie!
        }else if($deelnemers > 0){
            $this->add_contributie_deelname($deelnemers, $contributie);
        }

        return redirect('/contributies');
    }

    public function wijzig_contributie($id, Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric',
            'contributie_soort' => 'required|max:255']);

        $contributie = Contributie::find($id);

        $this->remove_contributie_deelname($contributie);

        $contributie->datum = $request->datum;
        $contributie->bedrag = $request->bedrag;
        $contributie->omschrijving = $request->contributie_soort;
        $contributie->save();

        $deelnemers = [];

        //todo moet dit wel? request->deelnemers is al array
        foreach($request->deelnemers as $id){
            array_push($deelnemers, $id);
        }

        if($deelnemers == 0){
            //TODO reject declaratie!
        }else if($deelnemers > 0){
            $this->add_contributie_deelname($deelnemers, $contributie);
        }

        return redirect('/contributies');
    }

    public function add_contributie_deelname($deelnemers, $contributie){
        foreach ($deelnemers as $lid){
            add_verschuldigd($lid, $contributie->bedrag);
            $contributie_deelname = new DeclaratieDeelname;
            $contributie_deelname->lid_id = $lid;
            $contributie_deelname->contributie_id = $contributie->contributie_id;
            $contributie_deelname->save();
        }
    }

    public function remove_contributie_deelname($contributie){
        $contributie_id = $contributie->contributie_id;
        $deelnemers = Lid::select('lid.lid_id as lid_id', 'contributie_deelname.lid_id as deelname')->leftJoin('contributie_deelname', function($join) use ($contributie_id){
            $join->on('lid.lid_id', 'contributie_deelname.lid_id');
            $join->where('contributie_deelname.declaratie_id', $contributie_id);
        })->get();
        foreach($deelnemers as $deelnemer){
            remove_verschuldigd($deelnemer->lid_id, $contributie->bedrag);
            ContributieDeelname::where('lid_id', $deelnemer->lid_id)->where('contributie_id', $contributie_id)->delete();
        }
    }


}
