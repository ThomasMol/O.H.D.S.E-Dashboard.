<?php

namespace App\Http\Controllers;

use App\Financien;
use App\Lid;
use App\LidGegevens;
use App\Rekeningnummer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class GegevensController extends Controller
{
    public function index(){
        $financien = Financien::find(Auth::user()->lid_id);
        $rekeningnummers = Rekeningnummer::findMany( Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        $verschuldigd = verschuldigd(Auth::user()->lid_id);
        $overgemaakt = overgemaakt(Auth::user()->lid_id);
        $gespaard = gespaard(Auth::user()->lid_id);
        $lid = new Lid();
        return view('gegevens/show',compact('financien','rekeningnummers' ,'lid_gegevens','lid'));
    }
    public function edit(){
        $rekeningnummers = Rekeningnummer::findMany( Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        return view('gegevens/edit',compact('rekeningnummers','lid_gegevens'));
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

    public function wijzig_wachtwoord(Request $request){
        $passwords = $request->validate([
            'password' => 'required|max:255',
            'new_password' => 'required|max:255'
        ]);
        $current_password = Auth::user()->getAuthPassword();
        if (Hash::check($passwords['password'], $current_password)) {
            $user = Lid::find(Auth::user()->lid_id);
            $user->password = Hash::make($passwords['new_password']);
            $user->save();
            return redirect('/gegevens')->with('status', 'Wachtwoord succesvol veranderd.');
        }else{
            return redirect('/gegevens')->with('error', 'Wachtwoord kwam niet overeen met huidig wachtwoord.');
        }

    }
}
