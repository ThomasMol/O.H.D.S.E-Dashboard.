@extends('layout')
@section('title','Contributies')
@section('content')
    <h2 class="mb-4">Contributie wijzigen</h2>

    <form class="card" method="POST" action="/contributies/{{$contributie->contributie_id}}">
        @csrf
        @method('PATCH')

        <div class="form-row">
            <div class="col-md-4">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $contributie->datum }}" required>
            </div>
            <div class="col-md-4">
                <label for="budget">Bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="budget" step=".01" value="{{ $contributie->bedrag }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="contributie_soort">Contributie soort</label>
                <select class="form-control mb-3" id="contributie_soort" name="contributie_soort" required>
                    @foreach($contributie->contributieSoortOptions() as $key => $soort)
                        <option value="{{ $key }}" >{{ $soort }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm table-responsive">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leden_deelname as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}" @if(isset($lid->deelname)) checked @endif></td>
            @endforeach

            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Wijzig contributie</button>
    </form>
@endsection
