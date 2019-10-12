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
            'inkomsten.*.soort' => 'required',
            'inkomsten.*.bedrag' => 'required|numeric|gte:0|lt:99999999'
        ]);
        //dd($inkomsten);
        $uitgaven = $request->validate([
            'uitgave_soort.*' => 'required',
            'uitgave_budget.*' => 'required|numeric|gte:0|lt:99999999'
        ]);
        dd($inkomsten);
        foreach($inkomsten as $rij){
            Inkomsten::updateOrCreate(['inkomsten_id'=>key($rij)],['soort'=>$rij[key($rij)]['soort'],'bedrag'=>$rij[key($rij)]['bedrag']]);
            //
        }


        return redirect('/begroting/'. $bestuursjaar->jaargang);
    }

    public function destroy($id)
    {
        //
    }
}
