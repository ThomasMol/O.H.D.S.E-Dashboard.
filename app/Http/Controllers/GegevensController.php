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
        return view('gegevens/gegevens',['financien'=>$financien,'rekeningnummers' => $rekeningnummers,'lid_gegevens'=>$lid_gegevens]);
    }
    public function wijzigform(){
        $rekeningnummers = Rekeningnummer::findMany( Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        return view('gegevens/wijzig_gegevens',['rekeningnummers' => $rekeningnummers,'lid_gegevens'=>$lid_gegevens]);
    }

    public function wijzig(Request $request){
        $validatedData = $request->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255',
            'geboortedatum' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'straatnaam' => 'required|max:255',
            'postcode' => 'required|max:255',
            'stad' => 'required|max:255',
            'land' => 'required|max:255']);

        $lid = Auth::user();
        $lid_gegevens = LidGegevens::find($lid->lid_id);

        $lid->roepnaam = $request->roepnaam;
        $lid->voornamen = $request->voornamen;
        $lid->achternaam = $request->roepnaam;

        $lid_gegevens->geboortedatum = $request->geboortedatum;
        $lid_gegevens->geboorteplaats = $request->geboorteplaats;
        $lid_gegevens->telefoonnummer = $request->telefoonnummer;
        $lid_gegevens->straatnaam = $request->straatnaam;
        $lid_gegevens->postcode = $request->postcode;
        $lid_gegevens->stad = $request->stad;
        $lid_gegevens->land = $request->land;

        $lid->save();
        $lid_gegevens->save();

        return redirect('/gegevens');
    }
}
