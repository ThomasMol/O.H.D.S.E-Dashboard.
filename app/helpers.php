<?php

use App\Boete;

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

    function add_boete($lid_id, $bedrag, $reden, $datum){
        $boete = new App\Boete;
        $boete->lid_id = $lid_id;
        $boete->datum = $datum;
        $boete->bedrag = $bedrag;
        $boete->reden = $reden;
        $boete->save();
        add_verschuldigd($lid_id, $bedrag);
        return $boete->boete_id;
    }

    function remove_boete($lid_id, $boete_id, $bedrag){
        $boete = App\Boete::destroy($boete_id);
        subtract_verschuldigd($lid_id,$bedrag);
    }

    function add_verschuldigd($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->verschuldigd = $lid->verschuldigd + $bedrag;
        $lid->save();
    }

    function subtract_verschuldigd($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->verschuldigd = $lid->verschuldigd - $bedrag;
        $lid->save();
    }

    function format_currency($number){
        return number_format($number, 2, ',', '.');
    }
