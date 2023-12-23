<?php

namespace App\Http\Controllers;

use App\Models\Bestuursjaar;
use App\Models\Inkomsten;
use App\Models\SErekening;
use App\Models\Transactie;
use App\Models\Financien;
use App\Models\Uitgave;
use App\Models\Uitgaven;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InkomstenUitgavenExport;
use Illuminate\Support\Carbon;

class BegrotingController extends Controller
{
    public function index()
    {
        $begrotingen = Bestuursjaar::orderBy('jaargang','desc')->get();
        $test = Bestuursjaar::huidigJaar();
        return view('begroting/index',compact('begrotingen','test'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Bestuursjaar $bestuursjaar)
    {
        $inkomsten_list = Inkomsten::where('jaargang', $bestuursjaar->jaargang)->orderBy('soort', 'asc')->get();
        $uitgaven_list = Uitgaven::where('jaargang', $bestuursjaar->jaargang)->orderBy('soort', 'asc')->get();
        $se_rekening = SErekening::find(1);
        $transacties_af_aggregate = Transactie::where('af_bij','Af')->sum('bedrag');
        $transacties_bij_aggregate = Transactie::where('af_bij','Bij')->sum('bedrag');
        $uitgaven_aggregate = Uitgave::where('uitgave','>=',0)->sum('uitgave');
        $liquiditeit = (float) Financien::sum('schuld') - Financien::sum('gespaard')  + (float) $se_rekening->saldo;

        return view('begroting/show',compact('inkomsten_list','uitgaven_list','bestuursjaar','se_rekening','transacties_bij_aggregate','transacties_af_aggregate','uitgaven_aggregate','liquiditeit'));
    }

    public function edit(Bestuursjaar $bestuursjaar)
    {
        $inkomsten_list = Inkomsten::where('jaargang', $bestuursjaar->jaargang)->orderBy('soort', 'asc')->get();
        $uitgaven_list = Uitgaven::where('jaargang', $bestuursjaar->jaargang)->orderBy('soort', 'asc')->get();
        return view('begroting/edit',compact('inkomsten_list','uitgaven_list','bestuursjaar'));
    }

    public function update(Request $request, Bestuursjaar $bestuursjaar)
    {
        $inkomsten = $request->validate([
            'inkomsten.*.id' => '',
            'inkomsten.*.soort' => 'required|distinct',
            'inkomsten.*.budget' => 'required|numeric|gte:0|lt:99999999'
        ]);
        $uitgaven = $request->validate([
            'uitgaven.*.id' => '',
            'uitgaven.*.soort' => 'required|distinct',
            'uitgaven.*.budget' => 'required|numeric|gte:0|lt:99999999'
        ]);

        if(isset($inkomsten["inkomsten"])){
            foreach($inkomsten["inkomsten"] as $rij){
                $inkomsten_rij = Inkomsten::find($rij['id']);
                if($inkomsten_rij != null){
                    $inkomsten_rij->update(['soort'=>$rij['soort'],'budget'=>$rij['budget']]);
                }else{
                    $new = new Inkomsten;
                    $new->jaargang = $bestuursjaar->jaargang;
                    $new->soort = $rij['soort'];
                    $new->budget = $rij['budget'];
                    $new->save();
                }
            }
        }
        if(isset($uitgaven["uitgaven"])){
            foreach($uitgaven["uitgaven"] as $rij){
                $uitgaven_rij = Uitgaven::find($rij['id']);
                if($uitgaven_rij != null){
                    $uitgaven_rij->update(['soort'=>$rij['soort'],'budget'=>$rij['budget']]);
                }else{
                    $new = new Uitgaven();
                    $new->jaargang = $bestuursjaar->jaargang;
                    $new->soort = $rij['soort'];
                    $new->budget = $rij['budget'];
                    $new->realisatie = 0;
                    $new->save();
                }
            }
        }

        return redirect('/begroting/'. $bestuursjaar->jaargang);
    }

    public function destroy($id)
    {
        //
    }

    public function download_financien(Bestuursjaar $bestuursjaar){

        $additionalInfo = [
            'serekening' => SErekening::find(1),
            'af' => Transactie::where('af_bij', 'Af')->sum('bedrag'),
            'bij' => Transactie::where('af_bij', 'Bij')->sum('bedrag'),
            'uit' => Uitgave::where('uitgave', '>=', 0)->sum('uitgave'),
            'liquiditeit' => (float) Financien::sum('schuld') - (float) Financien::sum('gespaard') + (float) SErekening::find(1)->saldo,
        ];
        
        $inkomsten_list = Inkomsten::where('jaargang', Bestuursjaar::huidigJaar()->jaargang)->orderBy('soort', 'asc')->get();
        $uitgaven_list = Uitgaven::where('jaargang', Bestuursjaar::huidigJaar()->jaargang)->orderBy('soort', 'asc')->get();

        $inkomstenUitgavenExport = new InkomstenUitgavenExport($inkomsten_list, $uitgaven_list, $additionalInfo);

        return Excel::download(new InkomstenUitgavenExport($inkomsten_list, $uitgaven_list, $additionalInfo), 'ohd_se_begroting_' . Carbon::now()->format('d_m_Y') . '.xlsx'); // Add the title row to the beginning of the export
    }

}
