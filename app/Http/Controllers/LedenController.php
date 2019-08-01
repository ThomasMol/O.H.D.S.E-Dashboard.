<?php

namespace App\Http\Controllers;

use App\Financien;
use App\LidGegevens;
use App\Rekeningnummer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Lid;

class LedenController extends Controller
{
    public function index(){
        $leden = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','email','telefoonnummer','type_lid','schuld','gespaard','financien.lid_id')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->paginate(20);
        return view('leden/leden',['leden' => $leden]);
    }

    public function lid($id){
        $lid = Lid::select('*')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->where('lid.lid_id',$id)->first();
        $rekeningnummers = Rekeningnummer::findMany($id);

        //dd($lid);
        return view('leden/lid',['lid' => $lid,'rekeningnummers'=>$rekeningnummers]);
    }

    public function toevoegen(){
        return view('leden/lid_toevoegen');
    }
    public function wijzig($id){
        $financien = Financien::find($id);
        $rekeningnummers = Rekeningnummer::findMany($id);
        $lid_gegevens = LidGegevens::find($id);
        $lid = Lid::find($id);
        return view('leden/lid_wijzigen', ['lid' => $lid]);
    }


    public function insert_update_lid(Request $request){

        $validatedData = $request->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255',
            'geboortedatum' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'email' => 'required|email|max:255|unique:lid',
            'password' => 'required|max:255',
            'straatnaam' => 'required|max:255',
            'postcode' => 'required|max:255',
            'stad' => 'required|max:255',
            'land' => 'required|max:255',
            'rekeningnummers' => 'required|max:255',
            'verschuldigd' => 'required|numeric',
            'overgemaakt' => 'required|numeric',
            'gespaard' => 'required|numeric',
            'type_lid' => 'required|max:255',
            'admin' => 'required|min:0|max:1',
            'lichting' => 'required|numeric']);

        if(isset($request->lid_id)){
            $lid = Lid::find($request->lid_id);
            $lid_gegevens = LidGegevens::find($request->lid_id);
            $financien = Financien::find($request->lid_id);
        }else{
            $lid = new Lid;
            $lid_gegevens = new LidGegevens;
            $financien = new Financien;
        }

        $lid->type_lid = $request->type_lid;
        $lid->admin = $request->admin;
        $lid->lichting = $request->lichting;
        $lid->roepnaam = $request->roepnaam;
        $lid->voornamen = $request->voornamen;
        $lid->achternaam = $request->achternaam;
        $lid->email = $request->email;
        $lid->password = Hash::make($request->password);
        //$lid->profiel_foto = $request->profiel_foto;
        $lid->save();

        $lid_gegevens->lid_id = $lid->lid_id;
        $lid_gegevens->straatnaam = $request->straatnaam;
        $lid_gegevens->postcode = $request->postcode;
        $lid_gegevens->stad = $request->stad;
        $lid_gegevens->land = $request->land;
        $lid_gegevens->geboortedatum = $request->geboortedatum;
        $lid_gegevens->geboorteplaats = $request->geboorteplaats;
        $lid_gegevens->telefoonnummer = $request->telefoonnummer;

        $financien->lid_id = $lid->lid_id;
        $financien->overgemaakt = $request->overgemaakt;
        $financien->verschuldigd = $request->verschuldigd;
        $financien->gespaard = $request->gespaard;

        $lid_gegevens->save();
        $financien->save();

        foreach($request->rekeningnummers as $rekeningnummer){
            $rekeningnummer = Rekeningnummer::firstOrCreate(['rekeningnummer' => $rekeningnummer]);
            $rekeningnummer->lid_id = $lid->lid_id;
            $rekeningnummer->rekeningnummer = $request->rekeningnummer;
            $rekeningnummer->save();
        }

        return redirect('/leden');
    }
}
