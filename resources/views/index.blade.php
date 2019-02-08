@extends('layout')
@section('title','Index')
@section('content')
    <h1>Welkom {{ Auth::user()->roepnaam }}!</h1>
    <h4>Je hebt nog een schuld van &euro;{{Auth::user()->schuld}}</h4>
    @if(Auth::user()->schuld > 0)
        <h4>Ga overmaken lul.</h4>
    @endif

    <?php

    $total = 8.63;
    $divisor = 5;
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

    print_r( $splitTotals);
    echo $splitTotals[1];

    ?>
@endsection