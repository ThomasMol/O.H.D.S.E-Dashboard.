@extends('layout')
@section('title','Declaratie toevoegen')
@section('content')
<header>
    <h2>Declaratie toevoegen</h2>
</header>
<form method="POST" action="/declaraties">
    @csrf
    @include('declaraties.form')
</form>
@endsection
