@extends('layout')
@section('title','Contributie')
@section('content')
    <h2 class="mb-4">Contributie toevoegen</h2>

    <form class="card" method="POST" action="/contributies/toevoegen">
        @csrf
        <h3>Contributie</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ date('Y-m-d') }}" required>
        <label for="budget">Budget</label>
        <input type="number" class="form-control mb-3" id="budget" name="budget" step=".01" required>
        <label for="naheffing">Naheffing</label>
        <input type="number" class="form-control mb-3" id="naheffing" name="naheffing" step=".01" value="0.00" required>
        <label for="contributie_soort">Contributie soort</label>
        <select class="form-control mb-3"id="contributie_soort" name="contributie_soort" required>
            <option selected value="Dinsdagborrel">Dinsdagborrel</option>
            <option value="AkCie">AkCie contributie</option>
            <option value="XtCie">XtCie contributie</option>
            <option value="TripCie">TripCie weekend</option>
            <option value="BrokCie">BrokCie feest</option>
            <option value="Kerstdiner">BrokCie feest</option>
            <option value="Bierbikkel">Bierbikkel</option>
            <option value="Dies">Dies feest</option>
            <option value="SERgift">SER gift</option>
            <option value="UITweek">UIT week</option>
            <option value="Overig">Overige contributie</option>
        </select>

        <label for="betaald_door">Betaald door:</label>
        <select class="form-control mb-3"id="betaald_door" name="betaald_door_id" >
            <option selected value="se">SE</option>

        </select>



        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving"></textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
                <th scope="col">Afgemeld</th>
                <th scope="col">Te laat</th>
                <th scope="col">Naheffing</th>

            </tr>
            </thead>
            <tbody>
            @foreach($leden as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="aanwezig"></td>
                    <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="afgemeld"></td>
                    <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="te_laat"></td>
                    <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="naheffing_aanwezig"></td>
            @endforeach

            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Voeg contributie toe</button>
    </form>
@endsection