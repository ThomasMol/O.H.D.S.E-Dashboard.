<?php

function divide_money($total, $divisor){
    $total = (float) round($total, 2);

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