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
        $borrels = Borrel::orderBy('datum','desc')->paginate(10);
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
        $test = DB::select('select * from `lid` left join `borrel_aanwezigheid` on `lid`.`lid_id` = `borrel_aanwezigheid`.`lid_id` and `borrel_aanwezigheid`.`borrel_id` = ? where `type_lid` != \'Geen\' order by `type_lid` asc',[$id]);
        return view('borrels/borrel_wijzigen',['borrel' => $borrel, 'leden_aanwezigheid' =>  $test]);
    }

    public function voeg_borrel_toe(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|min:0.00',
            'naheffing' => 'required|numeric|min:0.00',
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
                        add_boete($lid->lid_id,10.00,"Afwezig zonder af te melden", $borrel->datum);
                    }else if($borrel_aanwezigheid->te_laat == 1){
                        add_boete($lid->lid_id,10.00,"Te laat zonder af te melden", $borrel->datum);
                    }
                }
                if($lid->type_lid != "Actief" && $borrel_aanwezigheid->aanwezig == 1){
                    add_verschuldigd($lid->lid_id,10.00);
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
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|min:0.00',
            'naheffing' => 'required|numeric|min:0.00',
            'omschrijving' => 'max:100000']);

        $borrel = Borrel::find($id);
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
                $borrel_aanwezigheid = BorrelAanwezigheid::where();
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
                        add_boete($lid->lid_id,10.00,"Afwezig zonder af te melden", $borrel->datum);
                    }else if($borrel_aanwezigheid->te_laat == 1){
                        add_boete($lid->lid_id,10.00,"Te laat zonder af te melden", $borrel->datum);
                    }
                }
                if($lid->type_lid != "Actief" && $borrel_aanwezigheid->aanwezig == 1){
                    add_verschuldigd($lid->lid_id,10.00);
                }
                $borrel_aanwezigheid->save();
            }

        }
        if(count($naheffing_leden) > 0){
            $this->add_naheffing($naheffing_leden, $borrel->naheffing);
        }



        return redirect('/borrel/' + $id);


    }

    public function add_naheffing($naheffing_leden, $naheffing){
        $naheffingen = divide_money($naheffing, count($naheffing_leden));
        $i = 1;
        foreach($naheffing_leden as $naheffing_lid){
            add_verschuldigd($naheffing_lid->lid_id, $naheffingen[$i]);
            $i++;
        }
    }
    public function remove_naheffing(){

    }


}
