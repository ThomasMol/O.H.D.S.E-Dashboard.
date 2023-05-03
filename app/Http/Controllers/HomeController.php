<?php

namespace App\Http\Controllers;

use App\Models\Financien;
use App\Models\LidGegevens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lid;
use App\Models\Uitgave;


class HomeController extends Controller
{
    public function index (Request $request){
        $user_id = Auth::user()->lid_id;
        $financien = Financien::find($user_id);
        if ($request->wantsJson()) {
            return response()->json(['financien' => $financien, 'lid' => Auth::user()]);
        }
        $leden = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','email','telefoonnummer','type_lid','schuld','gespaard','financien.lid_id')
            ->leftJoin('financien', 'lid.lid_id','financien.lid_id')
            ->leftJoin('lid_gegevens', 'lid.lid_id','lid_gegevens.lid_id')
            ->orderBy('schuld','desc')->limit(5)->get();
        $leden_nahef = Lid::select('lid.lid_id', 'roepnaam')
                    ->join('uitgave_deelname','lid.lid_id','=','uitgave_deelname.lid_id')
                    ->selectRaw('uitgave_deelname.lid_id, SUM(naheffing) as total_amount')
                    ->groupBy('uitgave_deelname.lid_id')->orderBy('total_amount','desc')->limit(5)->get();
        $leden_afwezig = Lid::select('lid.lid_id','roepnaam')
            ->join('uitgave_deelname', 'lid.lid_id', '=', 'uitgave_deelname.lid_id')
            ->join('uitgave', 'uitgave_deelname.uitgave_id', '=', 'uitgave.uitgave_id')
            ->where('uitgave.uitgaven_id', '=', 64)
            ->where('uitgave.budget', '>', 0)
            ->where('uitgave_deelname.aanwezig', '=', 0)
            ->selectRaw('lid.lid_id, COUNT(*) as total_afwezig')
            ->groupBy('lid.lid_id')->orderBy('total_afwezig','desc')->limit(5)
            ->get();
        return view('index',compact('financien','leden','leden_nahef','leden_afwezig'));
    }

    public function test(Request $request){
        $lid_gegevens = LidGegevens::find(49);
        if ($request->wantsJson()) {
            return response()->json($lid_gegevens);
        }
        return redirect('/');
    }

}
