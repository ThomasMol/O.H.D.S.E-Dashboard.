@extends('layout')
@section('title','Wijzig gegevens')
@section('content')
<header>
    <h2>Wijzig je gegevens</h2>
</header>
<div class="card">
    <form class="card-body mb-4" method="POST" action="/gegevens">
        @csrf
        @method('PATCH')
        <h3>Persoonlijke gevevens</h3>
        <label for="roepnaam">Roepnaam</label>
        <input type="text" class="form-control mb-3" id="roepnaam" name="roepnaam" required
            value="{{Auth::user()->roepnaam}}">
        <label for="voornamen">Voornamen</label>
        <input type="text" class="form-control mb-3" id="voornamen" name="voornamen" required
            value="{{Auth::user()->voornamen}}">
        <label for="achternaam">Achternaam</label>
        <input type="text" class="form-control mb-3" id="achternaam" name="achternaam" required
            value="{{Auth::user()->achternaam}}">

        <label for="geboortedatum">Geboortedatum</label>
        <input type="date" class="form-control mb-3" id="geboortedatum" name="geboortedatum" required
            value="{{$lid_gegevens->geboortedatum}}">
        <label for="geboorteplaats">Geboorteplaats</label>
        <input type="text" class="form-control mb-3" id="geboorteplaats" name="geboorteplaats" required
            value="{{$lid_gegevens->geboorteplaats}}">
        <label for="telefoonnummer">Telefoonnummer</label>
        <input type="text" class="form-control mb-3" id="telefoonnummer" name="telefoonnummer" required
            value="{{$lid_gegevens->telefoonnummer}}">

        <h3>Adres</h3>
        <label for="straatnaam">Straatnaam, nummer en toevoeging</label>
        <input type="text" class="form-control mb-3" id="straatnaam" name="straatnaam" required
            value="{{$lid_gegevens->straatnaam}}">
        <label for="postcode">Postcode</label>
        <input type="text" class="form-control mb-3" id="postcode" name="postcode" required
            value="{{$lid_gegevens->postcode}}">
        <label for="stad">Stad</label>
        <input type="text" class="form-control mb-3" id="stad" name="stad" required value="{{$lid_gegevens->stad}}">
        <label for="land">Land</label>
        <input type="text" class="form-control mb-3" id="land" name="land" required value="{{$lid_gegevens->land}}">

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Opslaan</button>
    </form>
</div>
@endsection
