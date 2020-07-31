@extends('layout')
@section('title','Overige kosten')
@section('content')
<header>
    <h2>Overige kosten wijzigen</h2>
</header>
<div class="card">
    <form class="card-body" method="POST" action="/kosten/{{$kosten->kosten_id}}">
        @csrf
        @method('PATCH')
        @include('kosten.form')
    </form>
</div>

@endsection
