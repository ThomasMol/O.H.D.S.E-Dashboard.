@extends('layout')
@section('title','Transacties')
@section('content')
    <h2>Transacties</h2>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/">Upload transacties</a>
        <a class="btn btn-success" href="/transacties/toevoegen"><span data-feather="plus-circle"></span> Transactie</a>
    @endif

    <table>

    </table>
@endsection