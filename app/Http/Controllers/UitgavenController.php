<?php

namespace App\Http\Controllers;

use App\Bestuursjaar;
use App\Uitgaven;
use Illuminate\Http\Request;
use App\Uitgave;
use App\UitgaveDeelname;
use App\Lid;
use DB;

class UitgavenController extends Controller
{
    public function index(){
        $uitgaven = Uitgave::orderBy('datum','desc')->paginate(10);
        return view('uitgaven/uitgaven',compact('uitgaven'));
    }

    public function create(Bestuursjaar $bestuursjaar){
        $leden = Lid::ledenGesorteerd()->get();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Uitgaven::where('jaargang',$bestuursjaar->jaargang)->get();
        return view('uitgaven/uitgave_toevoegen',compact('leden', 'bestuursjaren', 'categorieen'));
    }

    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric',
            'categorie' => 'required',
            'omschrijving' => 'required|max:100000'
        ]);


        $deelnemers = request()->validate([
            'deelnemers' => 'required']
        );
        $uitgave = Uitgave::create($data);

        $this->add_uitgave_deelname($deelnemers['deelnemers'], $uitgave);


        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }

    public function show(Uitgave $uitgave){
        $leden_deelname = Lid::join('uitgave_deelname','lid.lid_id','=','uitgave_deelname.lid_id')->where('uitgave_deelname.uitgave_id',$uitgave->uitgave_id)->get();

        return view('uitgaven/uitgave',compact('uitgave' , 'leden_deelname'));
    }

    public function edit(Uitgave $uitgave){
        $id = $uitgave->uitgave_id;
        $leden = Lid::select('lid_id', 'roepnaam', 'achternaam')->where('type_lid', '!=', 'Geen')->orderBy('type_lid', 'asc')->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','uitgave_deelname.lid_id as deelname','type_lid')->leftJoin('uitgave_deelname', function($join) use ($id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$id);
        })->where('type_lid','!=','Geen')->orderBy('type_lid','asc')->get();
        return view('uitgaven/uitgave_wijzigen', compact('uitgave', 'leden_deelname' , 'leden'));
    }

    public function update(Uitgave $uitgave){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric|lt:99999999',
            'categorie' => 'required',
            'omschrijving' => 'required|max:100000'
        ]);
        $deelnemers = request()->validate([
                'deelnemers' => 'required']
        );
        $this->remove_uitgave_deelname($uitgave);
        $uitgave->update($data);
        $this->add_uitgave_deelname($deelnemers['deelnemers'], $uitgave);
        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }

    public function destroy(Uitgave $uitgave){
        $this->remove_uitgave_deelname($uitgave);
        $uitgave->delete();
        return redirect('/uitgaven');
    }

    public function add_uitgave_deelname($deelnemers, $uitgave){
        $bedragen = divide_money($uitgave->naheffing, count($deelnemers));
        $i = 1;
        foreach ($deelnemers as $lid) {
            add_verschuldigd($lid, $bedragen[$i]);
            $uitgave_deelname = new UitgaveDeelname();
            $uitgave_deelname->lid_id = $lid;
            $uitgave_deelname->uitgave_id = $uitgave->uitgave_id;
            $uitgave_deelname->naheffing = $bedragen[$i];
            $uitgave_deelname->save();
            $i++;
        }
    }

    public function remove_uitgave_deelname($uitgave){
        $uitgave_id = $uitgave->uitgave_id;
        $deelnemers = Lid::select('lid.lid_id','uitgave_deelname.naheffing as naheffing')->join('uitgave_deelname', function($join) use ($uitgave_id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$uitgave_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $deelnemer->naheffing);
            UitgaveDeelname::where('lid_id',$deelnemer->lid_id)->where('uitgave_id',$uitgave_id)->delete();
        }
    }

}
