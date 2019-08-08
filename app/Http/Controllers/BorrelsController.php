<?php

namespace App\Http\Controllers;

use App\Borrel;
use App\BorrelAanwezigheid;
use App\Lid;
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
            'omschrijving' => 'max:100000'
        ]);
        $borrel = Borrel::create($data);

        $aanwezigheid = request()->aanwezigheid;
        $this->add_borrel_aanwezigheid($borrel, $aanwezigheid);

        return redirect('/borrel/'. $borrel->borrel_id);
    }


    public function show(Borrel $borrel){
        //
    }


    public function edit(Borrel $borrel){
        //
    }


    public function update(Borrel $borrel){
        //
    }


    public function destroy(Borrel $borrel){
        //
    }

    //Nice hack :)
    public function add_borrel_aanwezigheid($borrel,$aanwezigheid){
        foreach($aanwezigheid as $lid){

           $borrel_aanwezigheid = new BorrelAanwezigheid;
           $borrel_aanwezigheid->borrel_id = $borrel->borrel_id;
           $borrel_aanwezigheid->lid_id = key($aanwezigheid);
           $borrel_aanwezigheid->aanwezig = isset($lid['aanwezig']);
           $borrel_aanwezigheid->afgemeld = isset($lid['afgemeld']);
           if(isset($lid['boete'])){
               $borrel_aanwezigheid->boete = add_boete(key($aanwezigheid),10.00, "Niet afgemeld voor borrel.",$borrel->datum);
           }

           $borrel_aanwezigheid->save();

           next($aanwezigheid);
        }

    }
}
