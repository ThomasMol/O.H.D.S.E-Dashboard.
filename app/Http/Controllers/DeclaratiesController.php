<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Declaratie;
use App\DeclaratieDeelname;
use App\Lid;
use App\Boete;
use App\SErekening;
use DB;
use Illuminate\Support\Facades\Auth;


class DeclaratiesController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->lid_id;
        $declaraties = Declaratie::join('declaratie_deelname', function($join) use ($user_id){
            $join->on('declaratie.declaratie_id','declaratie_deelname.declaratie_id');
        })->orWhere(function ($query) use ($user_id){
        $query->orWhere('declaratie.created_by_id', '=', $user_id)
            ->orWhere('declaratie.betaald_door_id', '=', $user_id)
            ->orWhere('declaratie_deelname.lid_id', '=', $user_id);
        })->groupBy('declaratie.declaratie_id')->orderBy('datum', 'desc')->paginate(10);
        return view('declaraties/declaraties', ['declaraties' => $declaraties]);
    }

    public function declaratie($id)
    {
        $declaratie = Declaratie::find($id);
        $leden_deelname = Lid::join('declaratie_deelname', 'lid.lid_id', '=', 'declaratie_deelname.lid_id')->where('declaratie_deelname.declaratie_id', '=', $id)->get();

        return view('declaraties/declaratie', ['declaratie' => $declaratie, 'leden_deelname' => $leden_deelname]);
    }

    public function toevoegen()
    {
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();
        return view('declaraties/declaratie_toevoegen', ['leden' => $leden]);
    }

    public function wijzigen($id)
    {
        $declaratie = Declaratie::find($id);
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();

        $leden_deelname = Lid::leftJoin('declaratie_deelname', function($join) use ($id){
            $join->on('lid.lid_id','declaratie_deelname.lid_id');
            $join->where('declaratie_deelname.declaratie_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('declaraties/declaratie_wijzigen', ['declaratie' => $declaratie, 'leden_deelname' => $leden_deelname, 'leden'=>$leden]);
    }

    public function voeg_declaratie_toe(Request $request)
    {
        $validatedData = $request->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|min:0.00',
            'betaald_door_id' => 'required|numeric',
            'omschrijving' => 'required|max:100000']);

        $declaratie = new Declaratie;
        $declaratie->datum = $request->datum;
        $declaratie->bedrag = $request->bedrag;
        $declaratie->betaald_door_id = $request->betaald_door_id;
        $declaratie->omschrijving = $request->omschrijving;
        $declaratie->created_by_id = Auth::user()->lid_id;
        $declaratie->save();

        $deelnemers = [];
        foreach ($request->deelnemers as $id) {

            $declaratie_deelname = new DeclaratieDeelname;
            $declaratie_deelname->lid_id = $id;
            $declaratie_deelname->declaratie_id = $declaratie->declaratie_id;
            $declaratie_deelname->save();
            array_push($deelnemers, $id);
            if ($id == $declaratie->betaald_door_id) {
                remove_verschuldigd($id, $declaratie->bedrag);
            }

        }

        if ($deelnemers > 0) {
            $this->add_kosten_declaratie($deelnemers, $declaratie->bedrag);
        }

        return redirect('/declaraties');
    }


    public function add_kosten_declaratie($deelnemers, $bedrag)
    {
        $bedragen = divide_money($bedrag, count($deelnemers));
        $i = 1;
        foreach ($deelnemers as $naheffing_lid) {
            add_verschuldigd($naheffing_lid, $bedragen[$i]);
            $i++;
        }
    }
}
