<?php

function divide_money($total, $divisor)
{
    $total = (float)round($total, 2);

    $splitTotals = array_fill(1, $divisor, round($total / $divisor, 2));

    $newTotal = $splitTotals[1] * $divisor;

    $difference = abs(round($newTotal - $total, 2));

    $index = $divisor;
    while ($difference > 0) {
        $index = $index > 0 ? $index : $divisor;

        $difference -= 0.01;

        $splitTotals[$index--] += $newTotal < $total ? 0.01 : -0.01;
    }

    return $splitTotals;
}

function add_kosten($lid_id, $bedrag, $datum, $inkomsten_id)
{
    $kosten = new App\Models\Kosten;
    $kosten->lid_id = $lid_id;
    $kosten->datum = $datum;
    $kosten->bedrag = $bedrag;
    $kosten->inkomsten_id = $inkomsten_id;
    $kosten->save();
    add_verschuldigd($lid_id, $bedrag);
    add_inkomsten_budget($inkomsten_id, $bedrag);
    add_inkomsten_realisatie($inkomsten_id, $bedrag);
    return $kosten->kosten_id;
}

function remove_kosten($kosten_id)
{
    $kosten = App\Models\Kosten::find($kosten_id);
    if (isset($kosten)) {
        subtract_verschuldigd($kosten->lid_id, $kosten->bedrag);
        subtract_inkomsten_budget($kosten->inkomsten_id, $kosten->bedrag);
        subtract_inkomsten_realisatie($kosten->inkomsten_id, $kosten->bedrag);
        $kosten->delete();
    }
}

// Verschuldigd
function add_verschuldigd($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->verschuldigd = $lid->verschuldigd + $bedrag;
    $lid->save();
}

function subtract_verschuldigd($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->verschuldigd = $lid->verschuldigd - $bedrag;
    $lid->save();
}

// Overgemaakt
function add_overgemaakt($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->overgemaakt = $lid->overgemaakt + $bedrag;
    $lid->save();
}

function subtract_overgemaakt($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->overgemaakt = $lid->overgemaakt - $bedrag;
    $lid->save();
}

// Gespaard
function add_gespaard($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->gespaard = $lid->gespaard + $bedrag;
    $lid->save();
}

function subtract_gespaard($lid_id, $bedrag)
{
    $lid = App\Models\Financien::find($lid_id);
    $lid->gespaard = $lid->gespaard - $bedrag;
    $lid->save();
}

// Uitgaven balans realisatie
function add_uitgaven_realisatie($uitgaven_id, $bedrag)
{
    $uitgaven = App\Models\Uitgaven::find($uitgaven_id);
    $uitgaven->realisatie = $uitgaven->realisatie + $bedrag;
    $uitgaven->save();
}

function subtract_uitgaven_realisatie($uitgaven_id, $bedrag)
{
    $uitgaven = App\Models\Uitgaven::find($uitgaven_id);
    $uitgaven->realisatie = $uitgaven->realisatie - $bedrag;
    $uitgaven->save();
}

// Inkomsten balans realisatie
function add_inkomsten_realisatie($inkomsten_id, $bedrag)
{
    $inkomsten = App\Models\Inkomsten::find($inkomsten_id);
    $inkomsten->realisatie = $inkomsten->realisatie + $bedrag;
    $inkomsten->save();
}

function subtract_inkomsten_realisatie($inkomsten_id, $bedrag)
{
    $inkomsten = App\Models\Inkomsten::find($inkomsten_id);
    $inkomsten->realisatie = $inkomsten->realisatie - $bedrag;
    $inkomsten->save();
}

// Inkomsten balans budget
function add_inkomsten_budget($inkomsten_id, $bedrag)
{
    $inkomsten = App\Models\Inkomsten::find($inkomsten_id);
    $inkomsten->budget = $inkomsten->budget + $bedrag;
    $inkomsten->save();
}

function subtract_inkomsten_budget($inkomsten_id, $bedrag)
{
    $inkomsten = App\Models\Inkomsten::find($inkomsten_id);
    $inkomsten->budget = $inkomsten->budget - $bedrag;
    $inkomsten->save();
}

// SE rekening
function add_to_se_rekening($bedrag)
{
    $rekening = App\Models\SErekening::find(1);
    $rekening->saldo = $rekening->saldo + $bedrag;
    $rekening->save();
}

function subtract_from_se_rekening($bedrag)
{
    $rekening = App\Models\SErekening::find(1);
    $rekening->saldo = $rekening->saldo - $bedrag;
    $rekening->save();
}

// Totale verschuldigd van lid
function verschuldigd($lid_id)
{
    $kosten = App\Models\Kosten::where('kosten.lid_id', $lid_id)->sum('bedrag');
    //$borrels = App\Models\BorrelAanwezigheid::where('borrel_aanwezigheid.lid_id',$lid_id)->sum('naheffing');
    //$contributies = App\Models\ContributieDeelname::where('contributie_deelname.lid_id',$lid_id)->sum('bedrag');
    $declaraties = App\Models\DeclaratieDeelname::where('declaratie_deelname.lid_id', $lid_id)->sum('bedrag');
    $declaraties_betaald = App\Models\Declaratie::where('declaratie.betaald_door_id', $lid_id)->sum('bedrag');
    $uitgaven = App\Models\UitgaveDeelname::where('uitgave_deelname.lid_id', $lid_id)->sum('naheffing');
    $total = $kosten + /*$contributies +*/ $declaraties - $declaraties_betaald + $uitgaven;
    return $total;
}

// Totale overgemaakt van lid
function overgemaakt($lid_id)
{
    $transacties_bij = App\Models\Transactie::where('transactie.lid_id', $lid_id)
        ->where('transactie.af_bij', 'bij')
        ->where('transactie.spaarplan', 0)
        ->sum('bedrag');
    $transacties_af = App\Models\Transactie::where('transactie.lid_id', $lid_id)
        ->where('transactie.af_bij', 'af')
        ->where('transactie.spaarplan', 0)
        ->sum('bedrag');
    $total = $transacties_bij - $transacties_af;
    return $total;
}

// Totale gespaard van lid
function gespaard($lid_id)
{
    $transacties_bij = App\Models\Transactie::where('transactie.lid_id', $lid_id)
        ->where('transactie.af_bij', 'bij')
        ->where('transactie.spaarplan', 1)
        ->sum('bedrag');
    $transacties_af = App\Models\Transactie::where('transactie.lid_id', $lid_id)
        ->where('transactie.af_bij', 'af')
        ->where('transactie.spaarplan', 1)
        ->sum('bedrag');
    $total = $transacties_bij - $transacties_af;
    return $total;
}

//TODO put in scope
function cumulatief_af()
{
    $transacties = App\Models\Transactie::where('transactie.af_bij', 'af')
        ->where('transactie.spaarplan', 1)
        ->sum('bedrag');
    return $transacties;
}

// Format currency
function format_currency($number)
{
    return number_format($number, 2, ',', '.');
}
