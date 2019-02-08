<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class GegevensController extends Controller
{
    public function index(){
        return view('gegevens/gegevens');
    }
    public function wijzigform(){
        return view('gegevens/wijzig_gegevens');
    }

    public function wijzig(Request $request){
        $validatedData = $request->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255',
            'dob' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'adres' => 'required|max:255',
            'postcode' => 'required|max:255',
            'woonplaats' => 'required|max:255'/*,
            'rekeningnummer' => 'required|max:255',
            'rekeningnummer_2' => 'required|max:255',
            'verschuldigd' => 'required|numeric',
            'overgemaakt' => 'required|numeric',
            'gespaard' => 'required|numeric',
            'type_lid' => 'required|max:255',
            'admin' => 'required|min:0|max:1',
            'lichting' => 'numeric'*/]);

        DB::table('lid')->where('lid_id', Auth::user()->lid_id)->update(
            ['roepnaam' => $request->input('roepnaam'),
                'voornamen' => $request->input('voornamen'),
                'achternaam' => $request->input('achternaam'),
                'dob' => $request->input('dob'),
                'geboorteplaats' => $request->input('geboorteplaats'),
                'telefoonnummer' => $request->input('telefoonnummer'),
                'adres' => $request->input('adres'),
                'postcode' => $request->input('postcode'),
                'woonplaats' => $request->input('woonplaats')/*,
                'rekeningnummer' => $request->input('rekeningnummer'),
                'rekeningnummer_2' => $request->input('rekeningnummer2'),
                'verschuldigd' => $request->input('verschuldigd'),
                'overgemaakt' => $request->input('overgemaakt'),
                'gespaard' => $request->input('gespaard'),
                'schuld' => $request->input('verschuldigd') - $request->input('overgemaakt'),
                'type_lid' => $request->input('type_lid'),
                'admin' => $request->input('admin'),
                'lichting' => $request->input('lichting'),
                'pasfoto' => $request->input('profiel_foto')*/]
        );
        return redirect('/gegevens');
    }
}
