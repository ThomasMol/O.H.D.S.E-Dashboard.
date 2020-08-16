@extends('layout')
@section('title','Uitgave')
@section('content')
<header>
    <h2>Uitgave wijzigen</h2>
</header>

<form method="POST" action="/uitgaven/{{$uitgave->uitgave_id}}">
    @csrf
    @method('PATCH')
    @include('uitgaven.form')
</form>
@endsection
