<?php

namespace App\Http\Controllers;

use App\Lid;
use App\Rekeningnummer;
use App\SErekening;
use App\Transactie;
use Illuminate\Http\Request;

class TransactiesController extends Controller
{

    public function index()
    {
        $transacties = Transactie::all();
        return view('transacties/index', compact('transacties'));
    }

    public function create()
    {
        $leden = Lid::ledenGesorteerd()->get();
        return view('transacties/create', compact('leden'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'datum' => 'required|date',
            'naam' => 'required',
            'lid_id' => 'required_without:tegenrekening',
            'tegenrekening' => 'required_without:lid_id',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'code' => 'required',
            'af_bij' => 'required',
            'mededelingen' => 'required',
            'spaarplan' => ''
        ]);
        $rekening = SErekening::first();


        $afbij = $data['af_bij'];
        $lid_id = $data['lid_id'];
        $bedrag = $data['bedrag'];

        if($afbij == "Bij" && isset($lid_id)){
            $rekening->saldo = $rekening->saldo + $bedrag;

            if(isset($data->spaarplan)){
                add_gespaard($lid_id, $bedrag);
            }else{
                add_overgemaakt($lid_id, $bedrag);
            }
            $rekeningnummer = Rekeningnummer::first($lid_id);
            $data->tegenrekening = $rekeningnummer;

        }elseif($afbij == "Bij"){
            $rekening->saldo = $rekening->saldo + $bedrag;

        }elseif($afbij == "Af" && isset($lid_id)){
            $rekening->saldo = $rekening->saldo - $bedrag;

        }elseif($afbij == "Af"){
            $rekening->saldo = $rekening->saldo - $bedrag;

        }

        $transactie = Transactie::create($data);
        return redirect('/transactie'.$transactie->transactie_id);
    }


    public function show(Transactie $transactie)
    {
        $lid = Lid::find($transactie->lid_id);
        return view('transactie/show', compact('transactie','lid'));
    }


    public function edit(Transactie $transactie)
    {
        $leden = Lid::ledenGesorteerd()->get();
        $lid = Lid::find($transactie->lid_id);
        return view('transacties/create', compact('transactie','leden','lid'));
    }


    public function update(Request $request, Transactie $transactie)
    {
        $transactie->update();
        redirect('/transactie'.$transactie->transactie_id);
    }

    public function destroy(Transactie $transactie)
    {
        //
    }
}
