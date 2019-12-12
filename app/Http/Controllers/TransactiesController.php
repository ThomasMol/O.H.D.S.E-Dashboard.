<?php

namespace App\Http\Controllers;

use App\Imports\TransactieImport;
use App\Lid;
use App\Rekeningnummer;
use App\SErekening;
use App\Transactie;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDO;

class TransactiesController extends Controller
{

    public function index()
    {
        $transacties = Transactie::leftJoin('lid','lid.lid_id','transactie.lid_id')->get();
        return view('transacties/index', compact('transacties'));
    }

    public function create()
    {
        $leden = Lid::ledenGesorteerd()->get();
        $transactie = new Transactie();
        return view('transacties/create', compact('leden', 'transactie'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'naam' => 'required',
            'lid_id' => 'required_without:tegenrekening',
            'tegenrekening' => 'required_without:lid_id',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'mutatie_soort' => 'required',
            'af_bij' => 'required',
            'mededelingen' => 'required',
            'spaarplan' => 'required_with:lid_id|numeric|gte:-1|lte:1'
        ]);
        $afbij = $data['af_bij'];
        $lid_id = $data['lid_id'];
        $bedrag = $data['bedrag'];
        $spaarplan = $data['spaarplan'];
        if (isset($lid_id)) {
            $rekeningnummer = Rekeningnummer::find($lid_id);
            $data['tegenrekening'] = $rekeningnummer->rekeningnummer;
        }
        $this->checkAfBij($afbij, $bedrag, $lid_id, $spaarplan);
        $transactie = Transactie::create($data);

        return redirect('/transactie/' . $transactie->transactie_id);
    }

    public function show(Transactie $transactie)
    {
        $lid = Lid::find($transactie->lid_id);
        return view('transacties/show', compact('transactie', 'lid'));
    }

    public function edit(Transactie $transactie)
    {
        $leden = Lid::ledenGesorteerd()->get();
        return view('transacties/edit', compact('transactie', 'leden'));
    }

    public function update(Request $request, Transactie $transactie)
    {
        $data = $request->validate([
            'datum' => 'required|date',
            'naam' => 'required',
            'lid_id' => 'required_without:tegenrekening',
            'tegenrekening' => 'required_without:lid_id',
            'bedrag' => 'required|numeric|gte:0|lt:99999999',
            'mutatie_soort' => 'required',
            'af_bij' => 'required',
            'mededelingen' => 'required',
            'spaarplan' => 'required_with:lid_id|numeric|gte:-1|lte:1'
        ]);
        $this->removeTransactie($transactie);

        $afbij = $data['af_bij'];
        $lid_id = $data['lid_id'];
        $bedrag = $data['bedrag'];
        $spaarplan = $data['spaarplan'];
        if (isset($lid_id)) {
            $rekeningnummer = Rekeningnummer::find($lid_id);
            $data['tegenrekening'] = $rekeningnummer->rekeningnummer;
        }
        $this->checkAfBij($afbij, $bedrag, $lid_id, $spaarplan);
        $transactie->update($data);

        return redirect('/transactie/' . $transactie->transactie_id);
    }

    public function destroy(Transactie $transactie)
    {
        $this->removeTransactie($transactie);
        $transactie->delete();
        return redirect('/transacties');
    }

    //Get function, showing view of upload csv screen
    public function upload()
    {
        return view('transacties/upload');
    }

    //Post function, parses csv sheet and returns values to user to check and make changes if needed
    public function parse(Request $request)
    {
        $transactie_model = new Transactie();
        $leden = Lid::ledenGesorteerd()->get();

        if ($request->file('csv_file')->isValid()) {
            $file = $request->file('csv_file');
            $transacties = Excel::toArray(null, $file)[0];
            array_shift($transacties);
            foreach ($transacties as $key => $transactie) {
                $transacties[$key][0] = Carbon::parse(strval($transactie[0]))->format("Y-m-d");
                $transacties[$key][6] = str_replace(',', '.', $transactie[6]);
                $transacties[$key][9] = $this->getLidId($transactie[3]);
                $transacties[$key][11] = $this->getSpaarplan($transactie[8], $transacties[$key][9]);
                $transacties[$key][12] = $this->checkBetaalverzoek($transactie[1]);
            }
        }
        return view('/transacties/check', compact('transacties', 'transactie_model', 'leden'));
    }

    //Post function, processes imported csv sheet
    public function process(Request $request)
    {
        $data = $request->validate([
            'transacties.*.datum' => 'required|date',
            'transacties.*.naam' => 'required',
            'transacties.*.lid_id' => '',
            'transacties.*.tegenrekening' => '',
            'transacties.*.bedrag' => 'required|numeric|gte:0|lt:99999999',
            'transacties.*.mutatie_soort' => 'required',
            'transacties.*.af_bij' => 'required',
            'transacties.*.mededelingen' => 'required',
            'transacties.*.spaarplan' => 'required_with:transacties.*.lid_id'
        ]);

        foreach ($data['transacties'] as $key => $transactie) {
            $this->checkAfBij($transactie['af_bij'], $transactie['bedrag'], $transactie['lid_id'], $transactie['spaarplan']);
            Transactie::create($transactie);
        }

        return redirect('/transacties');
    }

    //Get lid id based on rekeningnummer
    public function getLidId($tegenrekening)
    {
        $rekeningnummer = Rekeningnummer::where('rekeningnummer', $tegenrekening)->first();
        if (isset($rekeningnummer)) {
            return $rekeningnummer->lid_id;
        } else {
            return null;
        }
    }

    //Get spaarplan based on mededeling, return 1 if lid is set and spaarplan, otherwise 0. Return nothing if no spaarplan and no lid_id
    public function getSpaarplan($mededeling, $lid_id)
    {
        if (strpos(strtolower($mededeling), 'spaarplan') !== false) {
            return 1;
        } elseif (isset($lid_id)) {
            return 0;
        } else {
            return -1;
        }
    }

    //Check if transaction is possible betaalverzoek or Tikkie based on naam
    public function checkBetaalverzoek($naam)
    {
        if (strpos(strtolower($naam), 'betaalverzoek') !== false || strpos(strtolower($naam), 'amro') !== false) {
            return 1;
        } else {
            return null;
        }
    }

    //Check if transaction is Af or Bij, handle addition or substraction from lid financien and SE rekening afterwards
    public function checkAfBij($afbij, $bedrag, $lid_id, $spaarplan)
    {

        if ($afbij == "Af") {
            $this->af($bedrag, $lid_id, $spaarplan);
        } elseif ($afbij == "Bij") {
            $this->bij($bedrag, $lid_id, $spaarplan);
        }
    }

    //Handle Af transaction
    public function af($bedrag, $lid_id, $spaarplan)
    {
        subtract_from_se_rekening($bedrag);

        if (isset($lid_id) && $spaarplan == 1) {
            subtract_gespaard($lid_id, $bedrag);
            return;
        } elseif (isset($lid_id) && $spaarplan == 0) {
            add_verschuldigd($lid_id, $bedrag);
            return;
        } else {
            return;
        }
    }

    //Handle Bij transaction
    public function bij($bedrag, $lid_id, $spaarplan)
    {
        add_to_se_rekening($bedrag);

        if (isset($lid_id) && $spaarplan == 1) {
            add_gespaard($lid_id, $bedrag);
            return;
        } elseif (isset($lid_id) && $spaarplan == 0) {
            add_overgemaakt($lid_id, $bedrag);
            return;
        } else {
            return;
        }
    }

    //Revert transactie transactions: subtract/add to rekening, lid, spaarplan
    public function removeTransactie($transactie)
    {
        if ($transactie->afbij == "Af") {
            add_to_se_rekening($transactie->bedrag);

            if (isset($transactie->lid_id) && $transactie->spaarplan == 1) {
                add_gespaard($transactie->lid_id, $transactie->bedrag);
                return;
            } elseif (isset($transactie->lid_id) && $transactie->spaarplan == 0) {
                subtract_verschuldigd($transactie->lid_id, $transactie->bedrag);
                return;
            } else {
                return;
            }
        } elseif ($transactie->afbij == "Bij") {
            subtract_from_se_rekening($transactie->bedrag);

            if (isset($transactie->lid_id) && $transactie->spaarplan == 1) {
                subtract_gespaard($transactie->lid_id, $transactie->bedrag);
                return;
            } elseif (isset($transactie->lid_id) && $transactie->spaarplan == 0) {
                subtract_overgemaakt($transactie->lid_id, $transactie->bedrag);
                return;
            } else {
                return;
            }
        }
    }
}
