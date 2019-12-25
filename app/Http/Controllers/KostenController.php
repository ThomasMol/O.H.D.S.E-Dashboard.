<?php

namespace App\Http\Controllers;

use App\Kosten;
use App\Lid;
use Illuminate\Http\Request;

class KostenController extends Controller
{

    public function index()
    {
        $kosten = Kosten::leftJoin('lid', 'lid.lid_id', '=', 'kosten.lid_id')->get();
        return view('kosten/index',compact('kosten'));
    }


    public function create()
    {
        $leden = Lid::ledenGesorteerd()->get();
        $kosten = new Kosten();
        return view('kosten/create',compact('leden','kosten'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'soort' => 'required',
            'lid_id' => 'required',
            'omschrijving' => ''
        ]);
        $kosten = Kosten::create($data);
        add_verschuldigd($kosten->lid_id, $kosten->bedrag);

        return redirect('/kosten');
    }


    public function show(Kosten $kosten)
    {
        //
    }


    public function edit(Kosten $kosten)
    {
        $leden = Lid::ledenGesorteerd()->get();
        return view('kosten/edit',compact('kosten','leden'));
    }


    public function update(Request $request, Kosten $kosten)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'soort' => 'required',
            'lid_id' => 'required',
            'omschrijving' => ''
        ]);
        subtract_verschuldigd($kosten->lid_id,$kosten->bedrag);
        $kosten->update($data);
        add_verschuldigd($kosten->lid_id, $kosten->bedrag);
        return redirect('/kosten');
    }


    public function destroy(Kosten $kosten)
    {
        subtract_verschuldigd($kosten->lid_id, $kosten->bedrag);
        $kosten->delete();
        return redirect('/kosten');
    }
}
