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
            'mutatie_soort' => 'required',
            'af_bij' => 'required',
            'mededelingen' => 'required',
            'spaarplan' => 'required_with:lid_id'
        ]);
        $afbij = $data['af_bij'];
        $lid_id = $data['lid_id'];
        $bedrag = $data['bedrag'];
        $spaarplan = $data['spaarplan'];

        if(isset($lid_id)){
            $rekeningnummer = Rekeningnummer::find($lid_id);
            $data['tegenrekening'] = $rekeningnummer->rekeningnummer;
        }
        if($afbij == "Af"){
            $this->af($bedrag,$lid_id,$spaarplan);
        }elseif($afbij == "Bij"){
            $this->bij($bedrag,$lid_id,$spaarplan);
        }

        $transactie = Transactie::create($data);
        return redirect('/transactie/'.$transactie->transactie_id);
    }


    public function show(Transactie $transactie)
    {
        $lid = Lid::find($transactie->lid_id);
        return view('transacties/show', compact('transactie','lid'));
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


    public function af($bedrag, $lid_id,$spaarplan){
        $rekening = SErekening::find(1);
        $rekening->saldo = $rekening->saldo - $bedrag;
        $rekening->save();

        if(isset($lid_id) && $spaarplan == 1){
            add_gespaard($lid_id,$bedrag);
            return;
        }elseif(isset($lid_id) && $spaarplan != 1){
            subtract_overgemaakt($lid_id,$bedrag);
            return;
        }else{
            return;
        }
    }

    public function bij($bedrag, $lid_id,$spaarplan){
        $rekening = SErekening::find(1);
        $rekening->saldo = $rekening->saldo + $bedrag;
        $rekening->save();

        if(isset($lid_id) && $spaarplan == 1){
            subtract_gespaard($lid_id,$bedrag);
            return;
        }elseif(isset($lid_id) && $spaarplan != 1){
            add_overgemaakt($lid_id,$bedrag);
            return;
        }else{
            return;
        }
    }
}
