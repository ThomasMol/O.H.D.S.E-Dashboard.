<?php

namespace App\Http\Controllers;

use App\Financien;
use App\Lid;
use App\LidGegevens;
use App\Rekeningnummer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class GegevensController extends Controller
{
    public function index(){
        $financien = Financien::find(Auth::user()->lid_id);
        $rekeningnummers = Rekeningnummer::findMany( Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        return view('gegevens/gegevens',compact('financien','rekeningnummers' ,'lid_gegevens'));
    }
    public function edit(){
        $rekeningnummers = Rekeningnummer::findMany( Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        return view('gegevens/wijzig_gegevens',compact('rekeningnummers','lid_gegevens'));
    }

    public function update(){
        $lid_data = request()->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255'
            ]);

        $lid_gegevens_data = request()->validate([
            'geboortedatum' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'straatnaam' => 'required|max:255',
            'postcode' => 'required|max:255',
            'stad' => 'required|max:255',
            'land' => 'required|max:255']);

        $lid = Lid::find(Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find($lid->lid_id);

        $lid->update($lid_data);


        $lid_gegevens->update($lid_gegevens_data);

        return redirect('/gegevens');
    }
}
