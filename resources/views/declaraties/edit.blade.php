@extends('layout')
@section('title','Declaratie wijzigen')
@section('content')
<header>
    <h2>Declaratie wijzigen</h2>
</header>
<div class="card">
    <form class="card-body" method="POST" action="/declaraties/{{$declaratie->declaratie_id}}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="created_by_id" value="{{$declaratie->created_by_id}}">
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $declaratie->datum }}" required>
        <label for="bedrag">Totaal bedrag</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">&euro;</div>
            </div>
            <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                value="{{ $declaratie->bedrag}}" min="0" max="99999999" placeholder="0.00" required>
        </div>
        <label for="betaald_door">Betaald door:</label>
        <select class="form-control mb-3" id="betaald_door" name="betaald_door_id">
            @foreach($leden as $lid)
            <option @if($lid->lid_id == $declaratie->betaald_door_id) selected @endif
                value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving"
            required>{{ $declaratie->omschrijving }}</textarea>

        <h3>Deelnemers</h3>
        <table class="table table-hover table-sm table-responsive ">
            <thead>
                <tr>
                    <th scope="col">Naam</th>
                    <th scope="col">Deelname</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leden_deelname as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}" @if(isset($lid->deelname))
                        checked @endif ></td>
                </tr>
                @endforeach

            </tbody>
        </table>


        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig declaratie</button>
    </form>
</div>
@endsection
