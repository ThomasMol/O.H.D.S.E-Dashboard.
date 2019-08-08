@extends('layout')
@section('title','Index')
@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="card">
            <h1>Welkom {{ Auth::user()->roepnaam }}</h1>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
            <h2>Financi&euml;n:</h2>
            <hr>
            <h6>Verschuldigd</h6>
            <h3>&euro; {{format_currency($financien->verschuldigd)}}</h3>
            <hr>
            <h6>Verschuldigd</h6>
            <h3>&euro; {{format_currency($financien->overgemaakt)}}</h3>
            <hr>
            <h4>Actuele schuld</h4>
            <h2>&euro; {{format_currency($financien->schuld)}}</h2>
            </div>
        </div>
    </div>

@endsection