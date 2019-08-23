@extends('layout')
@section('title','Boete')
@section('content')
    <h2 class="mb-4">Boete wijzigen</h2>

    <form class="card" method="POST" action="/boetes/{{$boete->boete_id}}">
        @csrf
        @method('PATCH')
        <h3>Boete</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $boete->datum }}" required>

        <div class="form-row">
            <label for="budget">Bedrag</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">&euro;</div>
                </div>
                <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01" value="{{ $boete->bedrag }}" min="0" max="99999999" required>
            </div>
        </div>

        <label for="omschrijving">Reden</label>
        <input type="text" class="form-control mb-3" id="reden" name="reden" value="{{ $boete->reden }}" required>

        <label for="lid_id">Wie</label>
        <select class="form-control mb-3"id="lid_id" name="lid_id" required>
            @foreach($leden as $lid)
                <option value="{{$lid->lid_id}}" @if($boete->lid_id == $lid->lid_id) selected @endif >{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig boete</button>
    </form>


@endsection