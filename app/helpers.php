<?php


use App\Financien;

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

    function remove_boete($boete_id){
        $boete = App\Boete::find($boete_id);
        subtract_verschuldigd($boete_id->lid_id,$boete->bedrag);
        $boete->delete();
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

    function add_overgemaakt($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->overgemaakt = $lid->overgemaakt + $bedrag;
        $lid->save();
    }

    function subtract_overgemaakt($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->overgemaakt = $lid->overgemaakt - $bedrag;
        $lid->save();
    }
    function add_gespaard($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->gespaard = $lid->gespaard + $bedrag;
        $lid->save();
    }

    function subtract_gespaard($lid_id, $bedrag){
        $lid = App\Financien::find($lid_id);
        $lid->gespaard = $lid->gespaard - $bedrag;
        $lid->save();
    }

    function format_currency($number){
        return number_format($number, 2, ',', '.');
    }
