@extends('layout')
@section('title','Index')
@section('content')

    <div class="row">
        <div class="col-md-4 card">
            <h1>Welkom {{ Auth::user()->roepnaam }}!</h1>
            <h4>Je hebt nog een schuld van &euro;{{Auth::user()->verschuldigd - Auth::user()->overgemaakt}}</h4>
            @if(Auth::user()->verschuldigd - Auth::user()->overgemaakt > 0)
                <h4>Ga overmaken lul.</h4>
            @endif
        </div>
        <div class="col-md-4 card">
            <h2>Je financi&euml;n:</h2>
        </div>
    </div>

@endsection