@extends('layout')
@section('title','Declaratie wijzigen')
@section('content')
    <h2 class="mb-4">Declaratie wijzgien</h2>

    <form class="card" method="POST" action="/declaraties/wijzig">
        @csrf
        <input type="hidden" name="declaratie_id" value="{{$declaratie->declaratie_id}}">
        <h3>Declaratie</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $declaratie->datum }}"required>
        <label for="bedrag">Totaal bedrag</label>
        <input type="number" class="form-control mb-3" id="bedrag" name="bedrag" step=".01" value="{{$declaratie->bedrag}}" required>
        <label for="betaald_door">Betaald door:</label>
        <select class="form-control mb-3"id="betaald_door" name="betaald_door_id" >
            @foreach($leden as $lid)
                <option @if($lid->lid_id == $declaratie->betaald_door_id) selected @endif value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" required>{{ $declaratie->omschrijving }}</textarea>

        <h3>Deelnemers</h3>
        <table class="table table-hover table-sm ">
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
                    <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}" @if(isset($lid->deelname)) checked @endif ></td>
                </tr>
            @endforeach

            </tbody>
        </table>


        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig declaratie</button>
    </form>
@endsection