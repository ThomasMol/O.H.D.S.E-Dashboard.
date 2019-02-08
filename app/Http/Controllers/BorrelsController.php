<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borrel;
use App\BorrelAanwezigheid;
use App\Lid;
use App\Boete;
use App\SErekening;
use DB;

class BorrelsController extends Controller
{
    public function index(){
        $borrels = Borrel::all();
        return view('borrels/borrels',['borrels' => $borrels]);
    }
    public function borrel($id){
        $borrel = Borrel::find($id);
        $leden_aanwezigheid = Lid::join('borrel_aanwezigheid','lid.lid_id','=','borrel_aanwezigheid.lid_id')->where('borrel_aanwezigheid.borrel_id','=',$id)->get();

        return view('borrels/borrel',['borrel' => $borrel, 'leden_aanwezigheid' => $leden_aanwezigheid]);
    }

    public function toevoegen(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('borrels/borrel_toevoegen',['leden' => $leden]);
    }
    public function wijzigen($id){
        $borrel = Borrel::find($id);
        $leden_aanwezigheid = Lid::leftJoin('borrel_aanwezigheid', function($join) use ($id) {
            $join->on('lid.lid_id','borrel_aanwezigheid.lid_id');
            $join->on('borrel_aanwezigheid.borrel_id','=',DB::raw('?',[1]));
        })/*->where('type_lid', '!=','Geen')*/->orderBy('type_lid','asc')->get();
        return view('borrels/borrel_wijzigen',['borrel' => $borrel, 'leden_aanwezigheid' => $leden_aanwezigheid,'overige_leden' => $leden_aanwezigheid]);
    }

    public function voeg_borrel_toe(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric',
            'naheffing' => 'required|numeric',
            'omschrijving' => 'max:100000']);

        $borrel = new Borrel;
        $borrel->datum = $request->datum;
        $borrel->budget = $request->budget;
        $borrel->naheffing = $request->naheffing;
        if($request->omschrijving){
            $borrel->omschrijving = $request->omschrijving;
        }
        $borrel->save();
        $leden = Lid::all();

        $naheffing_leden = [];

        foreach($leden as $lid){
            $id = $lid->lid_id;
            if($request->has($id)){
                $borrel_aanwezigheid = new BorrelAanwezigheid;
                $borrel_aanwezigheid->lid_id = $id;
                $borrel_aanwezigheid->borrel_id = $borrel->borrel_id;
                $aanwezigheid = $request->$id;

                foreach($aanwezigheid as $value){
                    switch ($value){
                        case 'aanwezig':
                            $borrel_aanwezigheid->aanwezig = 1;
                            break;
                        case 'afgemeld':
                            $borrel_aanwezigheid->afgemeld = 1;
                            break;
                        case 'te_laat':
                            $borrel_aanwezigheid->te_laat = 1;
                            break;
                        case 'naheffing_aanwezig':
                            $borrel_aanwezigheid->naheffing_aanwezig = 1;
                            array_push($naheffing_leden,$lid);
                            break;
                        case 'afwezig':
                            $borrel_aanwezigheid->afwezig = 1;
                            break;

                    }
                }
                if($borrel_aanwezigheid->afgemeld != 1){
                    if($borrel_aanwezigheid->afwezig == 1){
                        $this->add_boete($lid->lid_id,"Afwezig zonder af te melden", $borrel->datum);
                    }else if($borrel_aanwezigheid->te_laat == 1){
                        $this->add_boete($lid->lid_id,"Te laat zonder af te melden", $borrel->datum);
                    }
                }
                if($lid->type_lid != "Actief" && $borrel_aanwezigheid->aanwezig == 1){
                    $this->add_extra_kosten($lid->lid_id);
                }
                $borrel_aanwezigheid->save();
            }

        }
        if(count($naheffing_leden) > 0){
            $this->add_naheffing($naheffing_leden, $borrel->naheffing);
        }



        return redirect('/borrels');
    }

    public function wijzig_borrel($id, Request $request){

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

    public function add_boete($lid_id, $reden, $datum){
        $boete = new Boete;
        $boete->lid_id = $lid_id;
        $boete->datum = $datum;
        $boete->bedrag = 10.00;
        $boete->reden = $reden;
        $boete->save();
    }

    public function add_extra_kosten($lid_id){
        $lid = Lid::find($lid_id);
        $lid->verschuldigd = $lid->verschuldigd + 10.00;
        $lid->save();
    }

    public function remove_naheffing(){

    }

    public function remove_boete($lid, $aanwezigheid){

    }
    public function remove_extra_kosten(){

    }
}
