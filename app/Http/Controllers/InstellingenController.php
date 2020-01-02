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

        $bestuursjaar = Bestuursjaar::create([
            'jaargang' => $last_bestuursjaar->jaargang + 1,
            'van' =>  $last_bestuursjaar->van->addYears(1),
            'tot' => $last_bestuursjaar->tot->addYears(1)

        ]);
        Inkomsten::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Maandcontributie',
            'readonly' => 1
        ]);
        Inkomsten::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Boetes',
            'readonly' => 1
        ]);
        Inkomsten::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Borrel kosten reunisten/passief',
            'readonly' => 1
        ]);
        Uitgaven::create([
            'jaargang' => $bestuursjaar->jaargang,
            'soort' => 'Dinsdagborrel',
            'readonly' => 1
        ]);

        return redirect('/begroting/' . $bestuursjaar->jaargang);
    }

    public function undeleteLid($lid){
        Lid::withTrashed()->find($lid)->restore();
        return redirect('/instellingen');
    }
}
