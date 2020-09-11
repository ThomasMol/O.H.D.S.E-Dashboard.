<?php

namespace App\Http\Controllers;

use App\Financien;
use App\LidGegevens;
use App\Declaratie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index (Request $request){
        $user_id = Auth::user()->lid_id;
        $financien = Financien::find($user_id);
        $lid_gegevens = LidGegevens::find($user_id);
        $declaraties = Declaratie::select('declaratie.declaratie_id','betaald_door_id','datum','declaratie.bedrag','omschrijving','created_by_id')->join('declaratie_deelname', function($join) use ($user_id){
            $join->on('declaratie.declaratie_id','declaratie_deelname.declaratie_id');
        })->orWhere(function ($query) use ($user_id){
        $query->orWhere('declaratie.created_by_id', '=', $user_id)
            ->orWhere('declaratie.betaald_door_id', '=', $user_id)
            ->orWhere('declaratie_deelname.lid_id', '=', $user_id);
        })->groupBy('declaratie.declaratie_id')->orderBy('datum', 'desc')->take(5)->get();

        if ($request->wantsJson()) {
            return response()->json(['data' => $lid_gegevens]);
        }
        return view('index',compact('financien','lid_gegevens','declaraties'));
    }

    public function test(Request $request){
        $lid_gegevens = LidGegevens::find(49);
        if ($request->wantsJson()) {
            return response()->json($lid_gegevens);
        }
        return redirect('/');
    }

}
