<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Bestuursjaar;
use App\Models\Inkomsten;
use App\Models\Uitgaven;
use Illuminate\Http\Request;
use App\Models\Uitgave;
use App\Models\UitgaveDeelname;
use App\Models\Lid;
use App\Models\Kosten;
use Illuminate\Support\Facades\DB;

class UitgavenController extends Controller
{
    public function index(Request $request){
        $uitgaven = Uitgave::select('*','uitgave.budget as budget','uitgaven.budget as uitgaven_budget')->join('uitgaven','uitgave.uitgaven_id','=','uitgaven.uitgaven_id')->
        orderBy('uitgave.created_at','desc')->paginate(10);

        $leden_deelname = Uitgave::leftJoin('uitgave_deelname', function ($join) {
            $join->on('uitgave_deelname.uitgave_id', '=', 'uitgave.uitgave_id')
                ->where('uitgave_deelname.lid_id', Auth::user()->lid_id);
        })
        ->select('uitgave.uitgave_id', DB::raw('COALESCE(uitgave_deelname.naheffing, 0) AS naheffing'))
        ->orderBy('uitgave.created_at', 'desc')
        ->paginate(10);

        if($request->wantsJson()){
            return response()->json(['uitgaven' => $uitgaven]);
        }else{
            return view('uitgaven/index',compact('uitgaven', 'leden_deelname'));
        }
    }

    public function create(Bestuursjaar $bestuursjaar){

        $actieve_leden = Lid::actieveLeden()->get();
        $passieve_leden = Lid::passieveLeden()->get();
        $reunisten = Lid::reunisten()->get();
        $geen_lid = Lid::geenLeden()->get();

        $uitgave = new Uitgave();
        $bestuursjaren = Bestuursjaar::all();

        $categorieen = Uitgaven::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        $inkomsten_boete_id = Inkomsten::select('inkomsten_id')->where('jaargang', $bestuursjaar->jaargang)->where(DB::raw('upper(soort)'),'like','%BOETE%')->firstOrFail()['inkomsten_id'];
        $inkomsten_extra_kosten_id = Inkomsten::select('inkomsten_id')->where('jaargang', $bestuursjaar->jaargang)->where(DB::raw('upper(soort)'),'like','%EXTRA%')->firstOrFail()['inkomsten_id'];

        return view('uitgaven/create',compact('bestuursjaren', 'categorieen','bestuursjaar','inkomsten_boete_id','inkomsten_extra_kosten_id','uitgave','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:-99999999|lt:99999999',
            'naheffing' => 'required|numeric',
            'uitgaven_id' => 'required',
            'omschrijving' => 'required|max:100000'
        ]);
        $deelnemers = $request->validate([
            'aanwezigheid' => ''
        ]);
        $uitgave = Uitgave::create($data);
        add_uitgaven_realisatie($uitgave->uitgaven_id, $uitgave->budget);
        if(count($deelnemers) > 0){
            $this->add_uitgave_deelname($uitgave, $deelnemers['aanwezigheid']);
        }
        return redirect('/uitgave/' . $uitgave->uitgave_id);
    }

    public function show(Request $request, Uitgave $uitgave){
        $leden_deelname = Lid::join('uitgave_deelname','lid.lid_id','=','uitgave_deelname.lid_id')->where('uitgave_deelname.uitgave_id',$uitgave->uitgave_id)->get();
        $uitgave = Uitgave::select('*','uitgave.budget as budget','uitgaven.budget as uitgaven_budget')->join('uitgaven','uitgave.uitgaven_id','=','uitgaven.uitgaven_id')->where('uitgave.uitgave_id',$uitgave->uitgave_id)->first();

        if($request->wantsJson()){
            return response()->json(['uitgave' => $uitgave,'deelname' => $leden_deelname]);
        }else{
            return view('uitgaven/show',compact('uitgave' , 'leden_deelname'));
        }
    }

    public function edit(Uitgave $uitgave, Bestuursjaar $bestuursjaar){
        $id = $uitgave->uitgave_id;
        $leden = Lid::ledenGesorteerd()->get();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Uitgaven::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        $actieve_leden = Lid::lidDeelnameUitgave('uitgave_deelname','uitgave_id',$id)->actieveLeden()->get();
        $passieve_leden = Lid::lidDeelnameUitgave('uitgave_deelname','uitgave_id',$id)->passieveLeden()->get();
        $reunisten = Lid::lidDeelnameUitgave('uitgave_deelname','uitgave_id',$id)->reunisten()->get();
        $geen_lid = Lid::lidDeelnameUitgave('uitgave_deelname','uitgave_id',$id)->geenLeden()->get();


        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam',
        'uitgave_deelname.lid_id as deelname',
        'uitgave_deelname.aanwezig as aanwezig',
        'uitgave_deelname.afgemeld as afgemeld',
        'uitgave_deelname.naheffing as naheffing',
        'uitgave_deelname.boete_id as boete_id',
        'uitgave_deelname.extra_kosten_id as extra_kosten_id',
        'type_lid')->leftJoin('uitgave_deelname', function($join) use ($id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$id);
        })->ledenGesorteerd()->get();

        //$leden_test = array('actief'=>$actieve_leden,$passieve_leden,$reunisten, $geen_lid);

        $inkomsten_boete_id = Inkomsten::select('inkomsten_id')->where('jaargang', $bestuursjaar->jaargang)->where(DB::raw('upper(soort)'),'like','%BOETE%')->firstOrFail()['inkomsten_id'];
        $inkomsten_extra_kosten_id = Inkomsten::select('inkomsten_id')->where('jaargang', $bestuursjaar->jaargang)->where(DB::raw('upper(soort)'),'like','%EXTRA%')->firstOrFail()['inkomsten_id'];
        //dd($actieve_leden);
        return view('uitgaven/edit', compact('uitgave', 'leden_deelname' , 'leden','bestuursjaren','categorieen','inkomsten_boete_id','inkomsten_extra_kosten_id','actieve_leden','passieve_leden','reunisten','geen_lid'));
    }

    public function update(Uitgave $uitgave){
        $data = request()->validate([
            'datum' => 'required|date',
            'budget' => 'required|numeric|gte:0|lt:99999999',
            'uitgave' => 'required|numeric|gte:-99999999|lt:99999999',
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
        if(count($deelnemers) > 0){
            $this->add_uitgave_deelname($uitgave,$deelnemers['aanwezigheid']);
        }
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
                $uitgave_deelname->boete_id = add_kosten($key, 10.00, $uitgave->datum, $lid['boete']);
            }
            if(isset($lid['extra_kosten'])){
                $uitgave_deelname->extra_kosten_id = add_kosten($key, 10.00, $uitgave->datum, $lid['extra_kosten']);
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
        $deelnemers = Lid::select('lid.lid_id','uitgave_deelname.naheffing as naheffing','uitgave_deelname.boete_id as boete_id','uitgave_deelname.extra_kosten_id as extra_kosten_id')->join('uitgave_deelname', function($join) use ($uitgave_id){
            $join->on('lid.lid_id','uitgave_deelname.lid_id');
            $join->where('uitgave_deelname.uitgave_id',$uitgave_id);
        })->get();
        foreach ($deelnemers as $deelnemer){
            if(isset($deelnemer->naheffing)){
                subtract_verschuldigd($deelnemer->lid_id, $deelnemer->naheffing);
            }
            if(isset($deelnemer->boete_id)){
                remove_kosten($deelnemer->boete_id);
            }
            if(isset($deelnemer->extra_kosten_id)){
                remove_kosten($deelnemer->extra_kosten_id);
            }

            UitgaveDeelname::where('lid_id',$deelnemer->lid_id)->where('uitgave_id',$uitgave_id)->delete();
        }
    }

}
