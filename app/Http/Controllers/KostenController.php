<?php

namespace App\Http\Controllers;

use App\Bestuursjaar;
use App\Kosten;
use App\Lid;
use App\UitgaveDeelname;
use App\Inkomsten;
use Illuminate\Http\Request;

class KostenController extends Controller
{

    public function index()
    {
        $kosten = Kosten::select('kosten.kosten_id','kosten.lid_id','kosten.datum',
        'kosten.inkomsten_id','inkomsten.jaargang','inkomsten.soort','lid.roepnaam','lid.achternaam','kosten.bedrag','ud_1.uitgave_id as uitgave_id_boete','ud_2.uitgave_id as uitgave_id_extra')
        ->leftJoin('lid', 'lid.lid_id', '=', 'kosten.lid_id')
        ->leftJoin('inkomsten', 'kosten.inkomsten_id', '=', 'inkomsten.inkomsten_id')
        ->leftJoin('uitgave_deelname as ud_1','ud_1.boete_id','=','kosten.kosten_id')
        ->leftJoin('uitgave_deelname as ud_2','ud_2.extra_kosten_id','=','kosten.kosten_id')
        ->orderBy('datum','desc')->get();


        //dd($kosten);
        return view('kosten/index',compact('kosten'));
    }


    public function create(Bestuursjaar $bestuursjaar)
    {
        $leden = Lid::ledenGesorteerd()->get();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        return view('kosten/create',compact('leden','bestuursjaren','bestuursjaar','categorieen'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'inkomsten_id' => 'required',
            'lid_id' => 'required',
        ]);
        $kosten = Kosten::create($data);
        add_verschuldigd($kosten->lid_id, $kosten->bedrag);

        return redirect('/kosten');
    }


    public function show(Kosten $kosten)
    {
        //
    }


    public function edit(Kosten $kosten, Bestuursjaar $bestuursjaar)
    {
        $leden = Lid::ledenGesorteerd()->get();
        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        return view('kosten/edit',compact('kosten','leden','categorieen'));
    }

    //TODO verander uitgave kolom bij veranderen van kosten!!
    public function update(Request $request, Kosten $kosten)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'inkomsten_id' => 'required',
            'lid_id' => 'required',
        ]);
        subtract_verschuldigd($kosten->lid_id,$kosten->bedrag);
        $kosten->update($data);
        add_verschuldigd($kosten->lid_id, $kosten->bedrag);
        return redirect('/kosten');
    }


    public function destroy(Kosten $kosten)
    {
        subtract_verschuldigd($kosten->lid_id, $kosten->bedrag);
        $boete_deelname = UitgaveDeelname::where('boete_id',$kosten->kosten_id)->first();
        if(isset($boete_deelname)){
            $boete_deelname->boete_id = null;
            $boete_deelname->save();
        }
        $extra_kosten_deelname = UitgaveDeelname::where('extra_kosten_id',$kosten->kosten_id)->first();
        if(isset($extra_kosten_deelname)){
            $extra_kosten_deelname->extra_kosten_id = null;
            $extra_kosten_deelname->save();
        }

        $kosten->delete();
        return redirect('/kosten');
    }
}
