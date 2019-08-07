<?php

namespace App\Http\Controllers;

use App\Financien;
use App\LidGegevens;
use App\Rekeningnummer;
use Illuminate\Support\Facades\Hash;
use App\Lid;

class LedenController extends Controller
{
    public function index(){
        $leden = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','email','telefoonnummer','type_lid','schuld','gespaard','financien.lid_id')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->paginate(20);
        return view('leden/leden',compact('leden'));
    }

    public function create(){
        return view('leden/lid_toevoegen');
    }

    public function store(){

        //todo password confirmation
        $password_data = request()->validate([
            'password' => 'max:255'
        ]);

        $lid_data = request()->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255',
            'email' => 'required|email|max:255|unique:lid,email,'.request()->lid_id.',lid_id',
            'type_lid' => 'required|max:255',
            'admin' => 'required|min:0|max:1',
            'lichting' => 'required|numeric']);

        $financien_data = request()->validate([
            'verschuldigd' => 'required|numeric',
            'overgemaakt' => 'required|numeric',
            'gespaard' => 'required|numeric'
        ]);

        $lid_gegevens_data = request()->validate([
            'geboortedatum' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'straatnaam' => 'required|max:255',
            'postcode' => 'required|max:255',
            'stad' => 'required|max:255',
            'land' => 'required|max:255',
        ]);

        $rekeningnummers_data = request()->validate([
            'rekeningnummers' => 'required|max:255|unique:rekeningnummer,rekeningnummer',
        ]);


        $lid = Lid::create($lid_data);
        $lid->password = Hash::make($password_data['password']);
        $lid->save();

        $lid_gegevens = new LidGegevens;
        $lid_gegevens->lid_id = $lid->lid_id;
        $lid_gegevens->fill($lid_gegevens_data);
        $lid_gegevens->save();

        $financien = new Financien;
        $financien->lid_id = $lid->lid_id;
        $financien->fill($financien_data);
        $financien->save();

        foreach($rekeningnummers_data['rekeningnummers'] as $nummer){
            $rekeningnummer = new Rekeningnummer;
            $rekeningnummer->lid_id = $lid->lid_id;
            $rekeningnummer->rekeningnummer = $nummer;
            $rekeningnummer->save();
        }

        return redirect('/leden');
    }

    public function show(Lid $lid){
        $id = $lid->lid_id;
        $lid = Lid::select('*')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->where('lid.lid_id',$id)->first();
        $rekeningnummers = Rekeningnummer::findMany($id);

        return view('leden/lid',compact('lid','rekeningnummers'));
    }

    public function edit(Lid $lid){
        $id = $lid->lid_id;
        $lid = Lid::select('*')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->where('lid.lid_id',$id)->first();
        $rekeningnummers = Rekeningnummer::findMany($id);
        return view('leden/lid_wijzigen', compact('lid','rekeningnummers' ));
    }

    public function update(Lid $lid){
        $lid_id = $lid->lid_id;

        //todo password confirmation
        $password_data = request()->validate([
            'password' => 'max:255'
        ]);

        $lid_data = request()->validate([
            'roepnaam' => 'required|max:255',
            'voornamen' => 'required|max:255',
            'achternaam' => 'required|max:255',
            'email' => 'required|email|max:255|unique:lid,email,'.$lid_id.',lid_id',
            'type_lid' => 'required|max:255',
            'admin' => 'required|min:0|max:1',
            'lichting' => 'required|numeric']);

        $financien_data = request()->validate([
            'verschuldigd' => 'required|numeric',
            'overgemaakt' => 'required|numeric',
            'gespaard' => 'required|numeric'
        ]);

        $lid_gegevens_data = request()->validate([
            'geboortedatum' => 'required|date',
            'geboorteplaats' => 'required|max:255',
            'telefoonnummer'=> 'required|max:255',
            'straatnaam' => 'required|max:255',
            'postcode' => 'required|max:255',
            'stad' => 'required|max:255',
            'land' => 'required|max:255',
        ]);

        $rekeningnummers_data = request()->validate([
            'rekeningnummers' => 'required|max:255|unique:rekeningnummer,rekeningnummer,'.$lid_id.',lid_id',
        ]);

        $lid->update($lid_data);
        //$lid->password = Hash::make($password_data['password']);

        $lid_gegevens = LidGegevens::find($lid_id);
        $lid_gegevens->update($lid_gegevens_data);

        $financien = Financien::find($lid_id);
        $financien->update($financien_data);

        $this->remove_rekeningnummers($lid_id);

        foreach($rekeningnummers_data['rekeningnummers'] as $nummer){
            $rekeningnummer = new Rekeningnummer;
            $rekeningnummer->lid_id = $lid->lid_id;
            $rekeningnummer->rekeningnummer = $nummer;
            $rekeningnummer->save();
        }

        return redirect('/lid/' . $lid->lid_id);
    }

    public function delete(Lid $lid){
        $lid->delete();
        return redirect('/leden');
    }

    public function remove_rekeningnummers($id){
        Rekeningnummer::destroy($id);
    }

}
