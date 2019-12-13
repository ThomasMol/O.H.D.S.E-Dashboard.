<?php

namespace App\Http\Controllers;

use App\Boete;
use App\Lid;
use Illuminate\Http\Request;

class BoetesController extends Controller
{

    public function index()
    {
        $boetes = Boete::leftJoin('lid', 'lid.lid_id', '=', 'boete.lid_id')->get();
        return view('boetes/index',compact('boetes'));
    }


    public function create()
    {
        $leden = Lid::ledenGesorteerd()->get();
        return view('boetes/create',compact('leden'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'reden' => 'required',
            'lid_id' => 'required'
        ]);
        $boete = Boete::create($data);
        add_verschuldigd($boete->lid_id, $boete->bedrag);

        return redirect('/boetes');
    }


    public function show(Boete $boete)
    {
        //
    }


    public function edit(Boete $boete)
    {
        $leden = Lid::ledenGesorteerd()->get();
        return view('boetes/edit',compact('boete','leden'));
    }


    public function update(Request $request, Boete $boete)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'reden' => 'required',
            'lid_id' => 'required'
        ]);
        subtract_verschuldigd($boete->lid_id,$boete->bedrag);
        $boete->update($data);
        add_verschuldigd($boete->lid_id, $boete->bedrag);
        return redirect('/boetes');
    }


    public function destroy(Boete $boete)
    {
        subtract_verschuldigd($boete->lid_id, $boete->bedrag);
        $boete->delete();
        return redirect('/boetes');
    }
}
