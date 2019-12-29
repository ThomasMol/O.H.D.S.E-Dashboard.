<?php

namespace App\Http\Controllers;

use App\Bestuursjaar;
use App\Inkomsten;
use App\Lid;
use App\Uitgaven;

class InstellingenController extends Controller
{
    public function index (){

        $verwijderdeLeden = Lid::onlyTrashed()->get();
        $bestuursjaren = Bestuursjaar::get();
        return view('instellingen',compact('verwijderdeLeden','bestuursjaren'));
    }

    public function maakBegroting(){
        $last_bestuursjaar = Bestuursjaar::latest('tot')->first();
        $bestuursjaar = new Bestuursjaar();
        $bestuursjaar->jaargang =  $last_bestuursjaar->jaargang + 1;
        $bestuursjaar->van = $last_bestuursjaar->van->addYears(1);
        $bestuursjaar->tot = $last_bestuursjaar->tot->addYears(1);
        $bestuursjaar->save();

        Inkomsten::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Boetes'
        ]);
        Inkomsten::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Borrel kosten reunisten/passief'
        ]);
        Uitgaven::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Dinsdagborrel'
        ]);

        return redirect('/instellingen');
    }

    public function undeleteLid($lid){
        Lid::withTrashed()->find($lid)->restore();
        return redirect('/instellingen');
    }
}
