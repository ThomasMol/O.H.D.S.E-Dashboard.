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
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $kosten->datum }}" required>

        <div class="form-row">
            <label for="budget">Bedrag</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">&euro;</div>
                </div>
                <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                    value="{{ $kosten->bedrag }}" min="0" max="99999999" required>
            </div>
        </div>

        {{-- <label for="omschrijving">omschrijving</label>
        <input type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" value="{{ $kosten->omschrijving }}"
        required> --}}
        <label for="inkomsten_id">Soort</label>
        <select class="form-control mb-3" id="inkomsten_id" name="inkomsten_id" required>
            @foreach($categorieen as $categorie)
            <option @if($categorie->inkomsten_id == $kosten->inkomsten_id) selected @endif
                value="{{$categorie->inkomsten_id}}">{{ $categorie->soort }}</option>
            @endforeach
        </select>

        <label for="lid_id">Wie</label>
        <select class="form-control mb-3" id="lid_id" name="lid_id" required>
            @foreach($leden as $lid)
            <option value="{{$lid->lid_id}}" @if($kosten->lid_id == $lid->lid_id) selected @endif >{{$lid->roepnaam}}
                {{$lid->achternaam}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig boete</button>
    </form>
</div>

@endsection
