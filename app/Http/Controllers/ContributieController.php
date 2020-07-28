<?php

namespace App\Http\Controllers;

use App\Contributie;
use App\ContributieDeelname;
use App\Lid;
use App\Bestuursjaar;
use App\Inkomsten;


class ContributieController extends Controller
{
    public function index(){
        $contributies = Contributie::select('*','contributie.bedrag as bedrag')->join('inkomsten','inkomsten.inkomsten_id','=','contributie.inkomsten_id')->
        orderBy('datum','desc')->paginate(10);
        return view('contributies/index',compact('contributies'));
    }

    public function create(Bestuursjaar $bestuursjaar){
        $leden = Lid::ledenGesorteerd()->get();
        $actieve_leden = Lid::actieveLeden()->get();
        $contributie = new Contributie();
        $bestuursjaren = Bestuursjaar::all();
        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();
        return view('contributies/create',compact('leden','contributie','bestuursjaren','categorieen','bestuursjaar','actieve_leden'));
    }

    public function store(){
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'inkomsten_id' => 'required|max:255'
        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);
        $contributie = Contributie::create($data);
        add_inkomsten_realisatie($contributie->inkomsten_id,$contributie->bedrag * count($deelnemers['deelnemers']));
        $this->add_contributie_deelname($deelnemers['deelnemers'], $contributie);
        return redirect('/contributie/' . $contributie->contributie_id);
    }

    public function show(Contributie $contributie){
        $leden_deelname = Lid::join('contributie_deelname','lid.lid_id','=','contributie_deelname.lid_id')->where('contributie_deelname.contributie_id','=',$contributie->contributie_id)->get();
        $contributie = Contributie::select('*','contributie.bedrag as bedrag')->join('inkomsten','inkomsten.inkomsten_id','=','contributie.inkomsten_id')->where('contributie.contributie_id',$contributie->contributie_id)->first();

        return view('contributies/show',compact('contributie','leden_deelname'));
    }

    public function edit(Contributie $contributie, Bestuursjaar $bestuursjaar){
        $id = $contributie->contributie_id;
        $leden = Lid::ledenGesorteerd()->get();
        $categorieen = Inkomsten::where('jaargang',$bestuursjaar->jaargang)->orderBy('soort','asc')->get();

        $leden_deelname = Lid::select('lid.lid_id', 'roepnaam', 'achternaam','contributie_deelname.lid_id as deelname','type_lid')->leftJoin('contributie_deelname', function($join) use ($id){
            $join->on('lid.lid_id','contributie_deelname.lid_id');
            $join->where('contributie_deelname.contributie_id',$id);
        })->ledenGesorteerd()->get();
        return view('contributies/edit', compact('contributie','leden_deelname','leden','categorieen'));
    }

    public function update(Contributie $contributie){
        $id = $contributie->contributie_id;
        $data = request()->validate([
            'datum' => 'required|date',
            'bedrag' => 'required|numeric|gt:0|lt:99999999',
            'inkomsten_id' => 'required|max:255'
        ]);
        $deelnemers = request()->validate(['deelnemers'=>'required']);
        $this->remove_contributie_deelname($contributie);
        $contributie->update($data);
        $this->add_contributie_deelname($deelnemers['deelnemers'],$contributie);
        add_inkomsten_realisatie($contributie->inkomsten_id, $contributie->bedrag * count($deelnemers['deelnemers']));
        return redirect('/contributie/' . $id);

    }

    public function destroy(Contributie $contributie){
        $this->remove_contributie_deelname($contributie);
        $contributie->delete();
        return redirect('/contributies');
    }

    public function add_contributie_deelname($deelnemers, $contributie){
        foreach ($deelnemers as $lid){
            add_verschuldigd($lid, $contributie->bedrag);
            $contributie_deelname = new ContributieDeelname;
            $contributie_deelname->lid_id = $lid;
            $contributie_deelname->contributie_id = $contributie->contributie_id;
            $contributie_deelname->save();
        }
    }

    public function remove_contributie_deelname($contributie){
        $contributie_id = $contributie->contributie_id;
        $deelnemers = Lid::join('contributie_deelname', function($join) use ($contributie_id){
            $join->on('lid.lid_id', 'contributie_deelname.lid_id');
            $join->where('contributie_deelname.contributie_id', $contributie_id);
        })->get();
        subtract_inkomsten_realisatie($contributie->inkomsten_id, $contributie->bedrag * count($deelnemers));

        foreach($deelnemers as $deelnemer){
            subtract_verschuldigd($deelnemer->lid_id, $contributie->bedrag);
            ContributieDeelname::where('lid_id', $deelnemer->lid_id)->where('contributie_id', $contributie_id)->delete();
        }
    }
}
