@extends('layout')
@section('title','Declaratie wijzigen')
@section('content')
<header>
    <h2>Declaratie wijzigen</h2>
</header>
<form method="POST" action="/declaraties/{{$declaratie->declaratie_id}}">
    @csrf
    @method('PATCH')
    @include('declaraties.form')
</form>
@endsection
