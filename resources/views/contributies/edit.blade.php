@extends('layout')
@section('title','Contributies')
@section('content')
<header>
    <h2>Contributie wijzigen</h2>
</header>
    <form method="POST" action="/contributies/{{$contributie->contributie_id}}">
        @csrf
        @method('PATCH')
        @include('contributies.form')
    </form>
@endsection
