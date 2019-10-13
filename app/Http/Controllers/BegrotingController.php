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
        //$boetes = Boete::leftJoin('lid', 'lid.lid_id', '=', 'boete.lid_id')->get();
        //return view('boetes/index',compact('boetes'));
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

        //dd($request);
        $inkomsten = $request->validate([
            'inkomsten.*.id' => '',
            'inkomsten.*.soort' => 'required',
            'inkomsten.*.bedrag' => 'required|numeric|gte:0|lt:99999999'
        ]);
        //dd($inkomsten);
        $uitgaven = $request->validate([
            'uitgave_soort.*' => 'required',
            'uitgave_budget.*' => 'required|numeric|gte:0|lt:99999999'
        ]);
        foreach($inkomsten["inkomsten"] as $rij){
            //dd($rij);
            $inkomsten_rij = Inkomsten::find($rij['id']);
            if($inkomsten_rij != null){
                $inkomsten_rij->soort = $rij['soort'];
                $inkomsten_rij->bedrag = $rij['bedrag'];
                $inkomsten_rij->save();
            }else{
                $new = new Inkomsten;
                $new->jaargang = $bestuursjaar->jaargang;
                $new->soort = $rij['soort'];
                $new->bedrag = $rij['bedrag'];
                $new->save();
            }
        }


        return redirect('/begroting/'. $bestuursjaar->jaargang);
    }

    public function destroy($id)
    {
        //
    }
}
