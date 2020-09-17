<?php

namespace App\Http\Controllers;

use App\Models\Borrel;
use App\Models\BorrelAanwezigheid;
use App\Models\Lid;
use Illuminate\Http\Request;

class BorrelsController extends Controller
{

    public function index(){
        $borrels = Borrel::all();
        return view('borrels/index', compact('borrels'));
    }


    public function create(){
        $leden = Lid::where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('borrels/create', compact('leden'));
    }


    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric',
            'omschrijving' => 'max:100000',

        ]);
        $data_overig = request()->validate([
            'naheffing_leden_aantal' => 'required|gte:0|lt:9999999|numeric',
            'aanwezigheid' => 'required'
        ]);

        dd(request());
        $borrel = Borrel::create($data);
        $aanwezigheid = request()->aanwezigheid;
        $naheffing_leden_aantal = request()->naheffing_leden_aantal;
        $this->add_borrel_aanwezigheid($borrel, $aanwezigheid,$naheffing_leden_aantal);

        return redirect('/borrel/'. $borrel->borrel_id);
    }


    public function show(Borrel $borrel){
        $leden_deelname = Lid::join('borrel_aanwezigheid', 'lid.lid_id', '=', 'borrel_aanwezigheid.lid_id')
            ->where('borrel_aanwezigheid.borrel_id', $borrel->borrel_id)
            ->get();

        return view('borrels/show', compact('borrel','leden_deelname'));
    }


    public function edit(Borrel $borrel){
        $id = $borrel->borrel_id;
        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','borrel_aanwezigheid.aanwezig','borrel_aanwezigheid.afgemeld','borrel_aanwezigheid.naheffing','borrel_aanwezigheid.boete','type_lid')->leftJoin('borrel_aanwezigheid', function($join) use ($id){
            $join->on('lid.lid_id','borrel_aanwezigheid.lid_id');
            $join->where('borrel_aanwezigheid.borrel_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('borrels/edit', compact('borrel' , 'leden_deelname'));
    }


    public function update(Borrel $borrel){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric',
            'omschrijving' => 'max:100000',

        ]);
        $data_overig = request()->validate([
            'naheffing_leden_aantal' => 'required|gte:0|lt:9999999|numeric',
            'aanwezigheid' => 'required'
        ]);
        dd(request());
        $borrel->update($data);
        $this->remove_borrel_aanwezigheid($borrel);
        $aanwezigheid = request()->aanwezigheid;
        $naheffing_leden_aantal = request()->naheffing_leden_aantal;
        $this->add_borrel_aanwezigheid($borrel, $aanwezigheid,$naheffing_leden_aantal);
        return redirect('/borrel/'. $borrel->borrel_id);
    }


    public function destroy(Borrel $borrel){
        $this->remove_borrel_aanwezigheid($borrel);
        $borrel->delete();
        return redirect('/borrels');
    }

    //hack//
    public function add_borrel_aanwezigheid($borrel,$aanwezigheid,$naheffing_leden_aantal){
        if($naheffing_leden_aantal > 0){
            $bedragen = divide_money($borrel->naheffing,$naheffing_leden_aantal);
        }
        $i = 1;
        foreach($aanwezigheid as $lid){

            $borrel_aanwezigheid = new BorrelAanwezigheid;
            $borrel_aanwezigheid->borrel_id = $borrel->borrel_id;
            $borrel_aanwezigheid->lid_id = key($aanwezigheid);
            $borrel_aanwezigheid->aanwezig = isset($lid['aanwezig']);
            $borrel_aanwezigheid->afgemeld = isset($lid['afgemeld']);
            if(isset($lid['boete'])){
                $borrel_aanwezigheid->boete = add_boete(key($aanwezigheid),10.00, "Te laat/niet aanwezig en niet afgemeld voor borrel.",$borrel->datum);
            }
            if(isset($lid['naheffing'])){
                $borrel_aanwezigheid->naheffing = $bedragen[$i];
                add_verschuldigd(key($aanwezigheid),$bedragen[$i]);
                $i++;
            }
            $borrel_aanwezigheid->save();

            next($aanwezigheid);
        }

    }

    public function  remove_borrel_aanwezigheid($borrel){
        $borrel_id = $borrel->borrel_id;
        $deelnemers = Lid::select('lid.lid_id as lid_id','borrel_aanwezigheid.naheffing','borrel_aanwezigheid.boete')->join('borrel_aanwezigheid', function($join) use ($borrel_id){
            $join->on('lid.lid_id','borrel_aanwezigheid.lid_id');
            $join->where('borrel_aanwezigheid.borrel_id',$borrel_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            if(isset($deelnemer->naheffing)){
                subtract_verschuldigd($deelnemer->lid_id, $deelnemer->naheffing);
            }
            if(isset($deelnemer->boete)){
                remove_boete($deelnemer->boete);
            }
            BorrelAanwezigheid::where('lid_id',$deelnemer->lid_id)->where('borrel_id',$borrel_id)->delete();
        }
    }
}
