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
            'budget' => 'required|numeric',
            'naheffing' => 'required|numeric',
            'contributie_soort' => 'required|max:255',
            'omschrijving' => 'max:100000']);

        $contributie = new Contributie;
        $contributie->datum = $request->datum;
        $contributie->budget = $request->budget;
        $contributie->naheffing = $request->naheffing;
        $contributie->contributie_soort = $request->contributie_soort;
        if($request->omschrijving){
            $contributie->omschrijving = $request->omschrijving;
        }
        $contributie->save();
        $leden = Lid::all();

        $naheffing_leden = [];
        $boete_leden = [];
        $extra_kosten_leden = [];

        foreach($leden as $lid){
            $id = $lid->lid_id;
            if($request->has($id)){
                $contributie_participatie = new ContributieDeelname;
                $contributie_participatie->lid_id = $id;
                $contributie_participatie->contributie_id = $contributie->contributie_id;
                $participatie = $request->$id;

                foreach($participatie as $value){
                    switch ($value){
                        case 'aanwezig':
                            $contributie_participatie->aanwezig = 1;
                            break;
                        case 'afgemeld':
                            $contributie_participatie->afgemeld = 1;
                            break;
                        case 'te_laat':
                            $contributie_participatie->te_laat = 1;
                            break;
                        case 'naheffing_aanwezig':
                            $contributie_participatie->naheffing_aanwezig = 1;
                            array_push($naheffing_leden,$lid);
                            break;

                    }
                }

                if($contributie->soort == "Dinsdagborrel"){
                    if($lid->type_lid == "Actief"){
                        if($contributie_participatie->afgemeld != 1){

                        }

                    }elseif($lid->typ_lid != "Actief"){
                        array_push($extra_kosten_leden, $lid);
                    }
                }



                $contributie_participatie->save();
            }

        }

        if(count($naheffing_leden) > 0){
            $this->add_naheffing($naheffing_leden, $contributie->naheffing);
        }
        if(count($boete_leden) > 0){

        }
        if(count($extra_kosten_leden) > 0)


        return redirect('/contributies');
    }

    public function wijzig_contributie($id, Request $request){

    }

    public function add_naheffing($naheffing_leden, $naheffing){
        $naheffingen = divide_money($naheffing, count($naheffing_leden));
        $i = 1;
        foreach($naheffing_leden as $naheffing_lid){
            $lid = Lid::find($naheffing_lid->lid_id);
            $lid->verschuldigd = $lid->verschuldigd + $naheffingen[$i];
            $lid->save();
            $i++;
        }
    }

    public function add_boete($id, $participatie){

    }

    public function remove_naheffing(){

    }

    public function remove_boete($lid, $participatie){

    }


}
