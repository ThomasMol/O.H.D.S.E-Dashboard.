<?php

namespace App\Http\Controllers;

use App\Financien;
use App\LidGegevens;
use App\Rekeningnummer;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index (){
        $financien = Financien::find(Auth::user()->lid_id);
        $lid_gegevens = LidGegevens::find(Auth::user()->lid_id);
        return view('index',compact('financien','lid_gegevens'));
    }

}
