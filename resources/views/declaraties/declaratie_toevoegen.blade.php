@extends('layout')
@section('title','Declaratie toevoegen')
@section('content')
    <h2 class="mb-4">Declaratie toevoegen</h2>

    <form class="card" method="POST" action="/declaraties">
        @csrf
        <input type="hidden" name="created_by_id" value="{{Auth::user()->lid_id}}">
        <h3>Declaratie</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ old('datum') ?? date('Y-m-d') }}"required>
        <label for="bedrag">Totaal bedrag</label>
        <input type="number" class="form-control mb-3" id="bedrag" name="bedrag" step=".01" min="0" max="99999999" value="{{ old('bedrag')  }}" required>
        <label for="betaald_door">Betaald door:</label>
        <select class="form-control mb-3"id="betaald_door" name="betaald_door_id" >
            @foreach($leden as $lid)
                <option @if($lid->lid_id == Auth::user()->lid_id) selected @endif value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" required>{{ old('omschrijving')  }}</textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Deelname</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leden as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}" @if($lid->lid_id == Auth::user()->lid_id) checked @endif ></td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg declaratie toe</button>
    </form>
@endsection