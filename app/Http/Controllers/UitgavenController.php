<?php

namespace App\Http\Controllers;

use App\Bestuursjaar;
use App\Uitgaven;
use Illuminate\Http\Request;
use App\Uitgave;
use App\UitgaveDeelname;
use App\Lid;

class UitgavenController extends Controller
{
    public function index(){
        $uitgaven = Uitgave::select('*','uitgave.budget as budget','uitgaven.budget as uitgaven_budget')->join('uitgaven','uitgave.uitgaven_id','=','uitgaven.uitgaven_id')->
        orderBy('datum','desc')->paginate(10);
        return view('uitgaven/index',compact('uitgaven'));
    }

    public function create(Bestuursjaar $bestuursjaar){
        $leden = Lid::ledenGesorteerd()->get();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Uitgaven::where('jaargang',$bestuursjaar->jaargang)->get();
        return view('uitgaven/create',compact('leden', 'bestuursjaren', 'categorieen'));
    }

    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric',
            'uitgaven_id' => 'required',
            'omschrijving' => 'required|max:100000'
        ]);
        $deelnemers = request()->validate([
            'aanwezigheid' => ''
        ]);
        $uitgave = Uitgave::create($data);
        add_uitgaven_realisatie($uitgave->uitgaven_id, $uitgave->budget);
        $this->add_uitgave_deelname($uitgave, $deelnemers['aanwezigheid']);
        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }

    public function show(Uitgave $uitgave){
        $leden_deelname = Lid::join('uitgave_deelname','lid.lid_id','=','uitgave_deelname.lid_id')->where('uitgave_deelname.uitgave_id',$uitgave->uitgave_id)->get();
        $uitgave = Uitgave::select('*','uitgave.budget as budget','uitgaven.budget as uitgaven_budget')->join('uitgaven','uitgave.uitgaven_id','=','uitgaven.uitgaven_id')->where('uitgave.uitgave_id',$uitgave->uitgave_id)->first();
        return view('uitgaven/show',compact('uitgave' , 'leden_deelname'));
    }

    public function edit(Uitgave $uitgave, Bestuursjaar $bestuursjaar){
        $id = $uitgave->uitgave_id;
        $leden = Lid::ledenGesorteerd()->get();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Uitgaven::where('jaargang',$bestuursjaar->jaargang)->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam',
        'uitgave_deelname.lid_id as deelname',
        'uitgave_deelname.aanwezig as aanwezig',
        'uitgave_deelname.afgemeld as afgemeld',
        'uitgave_deelname.naheffing as naheffing',
        'uitgave_deelname.boete_id as boete_id',
        'type_lid')->leftJoin('uitgave_deelname', function($join) use ($id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$id);
        })->ledenGesorteerd()->get();
        return view('uitgaven/edit', compact('uitgave', 'leden_deelname' , 'leden','bestuursjaren','categorieen'));
    }

    public function update(Uitgave $uitgave){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:0|lt:99999999',
            'naheffing' => 'required|numeric|lt:99999999',
            'uitgaven_id' => 'required',
            'omschrijving' => 'required|max:100000'
        ]);
        $deelnemers = request()->validate([
                'aanwezigheid' => '']
        );
        subtract_uitgaven_realisatie($uitgave->uitgaven_id, $uitgave->budget);
        $this->remove_uitgave_deelname($uitgave);

        $uitgave->update($data);

        add_uitgaven_realisatie($uitgave->uitgaven_id, $uitgave->budget);
        $this->add_uitgave_deelname($uitgave,$deelnemers['aanwezigheid']);
        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }

    public function destroy(Uitgave $uitgave){
        subtract_uitgaven_realisatie($uitgave->uitgaven_id, $uitgave->budget);
        $this->remove_uitgave_deelname($uitgave);
        $uitgave->delete();
        return redirect('/uitgaven');
    }


    //hack//
    public function add_uitgave_deelname($uitgave, $deelnemers){
        $count_naheffingen = 0;
        foreach($deelnemers as $deelnemer){
            if(isset($deelnemer['naheffing'])){
                $count_naheffingen++;
            }
        }
        if($count_naheffingen > 0){
            $bedragen = divide_money($uitgave->naheffing, $count_naheffingen);
        }

        $i = 1;
        foreach ($deelnemers as $key => $lid) {
            $uitgave_deelname = new UitgaveDeelname();
            $uitgave_deelname->lid_id = $key;
            $uitgave_deelname->uitgave_id = $uitgave->uitgave_id;
            $uitgave_deelname->aanwezig = isset($lid['aanwezig']);
            $uitgave_deelname->afgemeld = isset($lid['afgemeld']);
            if(isset($lid['boete'])){
                $uitgave_deelname->boete_id = add_boete($key,10.00, "Te laat/niet aanwezig en niet afgemeld voor activiteit.",$uitgave->datum);
            }
            if(isset($lid['naheffing'])){
                $uitgave_deelname->naheffing = $bedragen[$i];
                add_verschuldigd($key,$bedragen[$i]);
                $i++;
            }
            $uitgave_deelname->save();

        }
    }

    public function remove_uitgave_deelname($uitgave){
        $uitgave_id = $uitgave->uitgave_id;
        $deelnemers = Lid::select('lid.lid_id','uitgave_deelname.naheffing as naheffing','uitgave_deelname.boete_id as boete_id')->join('uitgave_deelname', function($join) use ($uitgave_id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$uitgave_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            if(isset($deelnemer->naheffing)){
                subtract_verschuldigd($deelnemer->lid_id, $deelnemer->naheffing);
            }
            if(isset($deelnemer->boete_id)){
                remove_boete($deelnemer->boete_id);
            }

            UitgaveDeelname::where('lid_id',$deelnemer->lid_id)->where('uitgave_id',$uitgave_id)->delete();
        }
    }

}
