<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uitgave;
use App\UitgaveDeelname;
use App\Lid;
use DB;

class UitgavenController extends Controller
{
    public function index(){
        $uitgaven = Uitgave::orderBy('datum','desc')->paginate(10);
        return view('uitgaven/uitgaven',['uitgaven' => $uitgaven]);
    }

    public function uitgave($id){
        $uitgave = Uitgave::find($id);
        $leden_deelname = Lid::join('uitgave_deelname','lid.lid_id','=','uitgave_deelname.lid_id')->where('uitgave_deelname.uitgave_id','=',$id)->get();

        return view('uitgaven/uitgave',['uitgave' => $uitgave, 'leden_deelname' => $leden_deelname]);
    }

    public function toevoegen(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('uitgaven/uitgave_toevoegen',['leden' => $leden]);
    }

    public function wijzigen($id){
        $uitgave = Uitgave::find($id);
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','uitgave_deelname.lid_id as deelname','type_lid')->leftJoin('uitgave_deelname', function($join) use ($id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('uitgaven/uitgave_wijzigen', ['uitgave' => $uitgave, 'leden_deelname' => $leden_deelname, 'leden'=>$leden]);
    }

    public function insert_update_uitgave(Request $request){
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|min:0.00',
            'uitgave' => 'required|numeric|min:0.00',
            'categorie' => 'required',
            'omschrijving' => 'required|max:100000']);

        if(isset($request->uitgave_id)){
            $uitgave = Uitgave::find($request->uitgave_id);
            $this->remove_uitgave_deelname($uitgave);
        }else{
            $uitgave = new Uitgave;
        }
        $uitgave->datum = $request->datum;
        $uitgave->budget = $request->budget;
        $uitgave->uitgave = $request->uitgave;
        $uitgave->naheffing = $request->uitgave - $request->budget;
        $uitgave->categorie = $request->categorie;
        $uitgave->omschrijving = $request->omschrijving;
        $uitgave->save();

        $this->add_uitgave_deelname($request->deelnemers, $uitgave);


        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }


    public function add_uitgave_deelname($deelnemers, $uitgave){
        $bedragen = divide_money($uitgave->naheffing, count($deelnemers));
        $i = 1;
        foreach ($deelnemers as $lid) {
            add_verschuldigd($lid, $bedragen[$i]);
            $uitgave_deelname = new UitgaveDeelname();
            $uitgave_deelname->lid_id = $lid;
            $uitgave_deelname->uitgave_id = $uitgave->uitgave_id;
            $uitgave_deelname->naheffing = $bedragen[$i];
            $uitgave_deelname->save();
            $i++;
        }
    }

    public function remove_uitgave_deelname($uitgave){
        $uitgave_id = $uitgave->uitgave_id;
        $deelnemers = Lid::select('lid.lid_id','uitgave_deelname.naheffing as naheffing')->join('uitgave_deelname', function($join) use ($uitgave_id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$uitgave_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $deelnemer->naheffing);
            UitgaveDeelname::where('lid_id',$deelnemer->lid_id)->where('uitgave_id',$uitgave_id)->delete();
        }
    }

    public function verwijderen($id){
        $uitgave = Uitgave::find($id);
        $this->remove_declaratie_deelname($uitgave);
        $uitgave->delete();
        return redirect('/uitgaven');
    }
}
