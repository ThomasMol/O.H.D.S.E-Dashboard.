<?php

namespace App\Http\Controllers;

use App\Models\Financien;
use App\Models\LidGegevens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index (Request $request){
        $user_id = Auth::user()->lid_id;
        $financien = Financien::find($user_id);
        if ($request->wantsJson()) {
            return response()->json(['financien' => $financien, 'lid' => Auth::user()]);
        }
        return view('index',compact('financien'));
    }

    public function test(Request $request){
        $lid_gegevens = LidGegevens::find(49);
        if ($request->wantsJson()) {
            return response()->json($lid_gegevens);
        }
        return redirect('/');
    }

}
