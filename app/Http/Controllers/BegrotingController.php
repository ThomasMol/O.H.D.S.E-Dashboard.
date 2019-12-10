<?php

namespace App\Http\Controllers;

use App\Bestuursjaar;
use App\Inkomsten;
use App\Uitgaven;
use Illuminate\Http\Request;

class BegrotingController extends Controller
{
    public function index()
    {
        $begrotingen = Bestuursjaar::orderBy('jaargang','desc')->get();
        $test = Bestuursjaar::huidigJaar();
        return view('begroting/index',compact('begrotingen','test'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Bestuursjaar $bestuursjaar)
    {
        $inkomsten_list = Inkomsten::where('jaargang', $bestuursjaar->jaargang)->get();
        $uitgaven_list = Uitgaven::where('jaargang', $bestuursjaar->jaargang)->get();
        return view('begroting/show',compact('inkomsten_list','uitgaven_list','bestuursjaar'));
    }

    public function edit(Bestuursjaar $bestuursjaar)
    {
        $inkomsten_list = Inkomsten::where('jaargang', $bestuursjaar->jaargang)->get();
        $uitgaven_list = Uitgaven::where('jaargang', $bestuursjaar->jaargang)->get();
        return view('begroting/edit',compact('inkomsten_list','uitgaven_list','bestuursjaar'));
    }

    public function update(Request $request, Bestuursjaar $bestuursjaar)
    {
        $inkomsten = $request->validate([
            'inkomsten.*.id' => '',
            'inkomsten.*.soort' => 'required',
            'inkomsten.*.bedrag' => 'required|numeric|gte:0|lt:99999999'
        ]);
        $uitgaven = $request->validate([
            'uitgaven.*.id' => '',
            'uitgaven.*.soort' => 'required',
            'uitgaven.*.budget' => 'required|numeric|gte:0|lt:99999999'
        ]);

        if(isset($inkomsten["inkomsten"])){
            foreach($inkomsten["inkomsten"] as $rij){
                $inkomsten_rij = Inkomsten::find($rij['id']);
                if($inkomsten_rij != null){
                    $inkomsten_rij->update(['soort'=>$rij['soort'],'bedrag'=>$rij['bedrag']]);
                }else{
                    $new = new Inkomsten;
                    $new->jaargang = $bestuursjaar->jaargang;
                    $new->soort = $rij['soort'];
                    $new->bedrag = $rij['bedrag'];
                    $new->save();
                }
            }
        }
        if(isset($uitgaven["uitgaven"])){
            foreach($uitgaven["uitgaven"] as $rij){
                $uitgaven_rij = Uitgaven::find($rij['id']);
                if($uitgaven_rij != null){
                    $uitgaven_rij->update(['soort'=>$rij['soort'],'budget'=>$rij['budget']]);
                }else{
                    $new = new Uitgaven();
                    $new->jaargang = $bestuursjaar->jaargang;
                    $new->soort = $rij['soort'];
                    $new->budget = $rij['budget'];
                    $new->realisatie = 0;
                    $new->save();
                }
            }
        }

        return redirect('/begroting/'. $bestuursjaar->jaargang);
    }

    public function destroy($id)
    {
        //
    }
}
