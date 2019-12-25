@extends('layout')
@section('title','Overige kosten')
@section('content')
    <h2 class="mb-4">Overige kosten wijzigen</h2>

    <form class="card" method="POST" action="/kosten/{{$kosten->kosten_id}}">
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
                <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01" value="{{ $kosten->bedrag }}" min="0" max="99999999" required>
            </div>
        </div>

        <label for="omschrijving">omschrijving</label>
        <input type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" value="{{ $kosten->omschrijving }}" required>

        <label for="soort">Soort</label>
        <select class="form-control mb-3" id="soort" name="soort" required>
            @foreach($kosten->kostenOptions() as $key => $soort)
                <option @if($key == $kosten->soort) selected @endif value="{{$key}}">{{ $soort }}</option>
            @endforeach
        </select>

        <label for="lid_id">Wie</label>
        <select class="form-control mb-3"id="lid_id" name="lid_id" required>
            @foreach($leden as $lid)
                <option value="{{$lid->lid_id}}" @if($kosten->lid_id == $lid->lid_id) selected @endif >{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig boete</button>
    </form>


@endsection
