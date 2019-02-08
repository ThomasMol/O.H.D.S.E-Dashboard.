<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activiteit;
use App\ActiviteitAanwezigheid;
use App\Lid;
use App\SErekening;

class ActiviteitenController extends Controller
{
    public function index(){
        $activiteiten = Activiteit::all();
        return view('activiteiten/activiteiten',['activiteiten' => $activiteiten]);
    }
    public function activiteit($id){
        $activiteit = Activiteit::find($id);
        $leden_participatie = Lid::join('activiteit_participatie','lid.lid_id','=','activiteit_participatie.lid_id')->where('activiteit_participatie.activiteit_id','=',$id)->get();

        return view('activiteiten/activiteit',['activiteit' => $activiteit, 'leden_participatie' => $leden_participatie]);
    }


    public function toevoegen(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('activiteiten/activiteit_toevoegen',['leden' => $leden]);
    }
    public function wijzigen($id){
        $activiteit = Activiteit::where('activiteit_id', $id)->first();
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();

        return view('activiteiten/activiteit_wijzigen',['activiteit' => $activiteit, 'leden' => $leden]);
    }

    public function voeg_activiteit_toe(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric',
            'naheffing' => 'required|numeric',
            'activiteit_soort' => 'required|max:255',
            'omschrijving' => 'max:100000']);

        $activiteit = new Activiteit;
        $activiteit->datum = $request->datum;
        $activiteit->budget = $request->budget;
        $activiteit->naheffing = $request->naheffing;
        $activiteit->activiteit_soort = $request->activiteit_soort;
        if($request->omschrijving){
            $activiteit->omschrijving = $request->omschrijving;
        }
        $activiteit->save();
        $leden = Lid::all();

        $naheffing_leden = [];
        $boete_leden = [];
        $extra_kosten_leden = [];

        foreach($leden as $lid){
            $id = $lid->lid_id;
            if($request->has($id)){
                $activiteit_participatie = new ActiviteitAanwezigheid;
                $activiteit_participatie->lid_id = $id;
                $activiteit_participatie->activiteit_id = $activiteit->activiteit_id;
                $participatie = $request->$id;

                foreach($participatie as $value){
                    switch ($value){
                        case 'aanwezig':
                            $activiteit_participatie->aanwezig = 1;
                            break;
                        case 'afgemeld':
                            $activiteit_participatie->afgemeld = 1;
                            break;
                        case 'te_laat':
                            $activiteit_participatie->te_laat = 1;
                            break;
                        case 'naheffing_aanwezig':
                            $activiteit_participatie->naheffing_aanwezig = 1;
                            array_push($naheffing_leden,$lid);
                            break;

                    }
                }

                if($activiteit->soort == "Dinsdagborrel"){
                    if($lid->type_lid == "Actief"){
                        if($activiteit_participatie->afgemeld != 1){

                        }

                    }elseif($lid->typ_lid != "Actief"){
                        array_push($extra_kosten_leden, $lid);
                    }
                }



                $activiteit_participatie->save();
            }

        }

        if(count($naheffing_leden) > 0){
            $this->add_naheffing($naheffing_leden, $activiteit->naheffing);
        }
        if(count($boete_leden) > 0){

        }
        if(count($extra_kosten_leden) > 0)


        return redirect('/activiteiten');
    }

    public function wijzig_activiteit($id, Request $request){

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
