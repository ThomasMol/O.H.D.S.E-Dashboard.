@extends('layout')
@section('title','Wijzig gegevens')
@section('content')

        <h2 class="mb-4">Wijzig je gegevens</h2>

        <form class="form mb-4" method="POST" action="/gegevens/wijziglogin">
            @csrf
            <h3>Inlog gegevens</h3>
            <label for="email">Email</label>
            <input type="email" class="form-control mb-3" id="email" name="email" required value="{{Auth::user()->email}}">
            <label for="wacthwoord">Wachtwoord</label>
            <input type="text" class="form-control mb-3" id="wacthwoord" name="password" value="">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Opslaan</button>
        </form>

        <form class="form mb-4" method="POST" action="/gegevens/wijzig">
            @csrf
            <h3>Persoonsgevevens</h3>
            <label for="roepnaam">Roepnaam</label>
            <input type="text" class="form-control mb-3" id="roepnaam" name="roepnaam" required value="{{Auth::user()->roepnaam}}">
            <label for="voornamen">Voornamen</label>
            <input type="text" class="form-control mb-3" id="voornamen" name="voornamen" required value="{{Auth::user()->voornamen}}">
            <label for="achternaam">Achternaam</label>
            <input type="text" class="form-control mb-3" id="achternaam" name="achternaam" required value="{{Auth::user()->achternaam}}">
            <label for="dob">Geboortedatum</label>
            <input type="date" class="form-control mb-3" id="dob" name="dob" required value="{{Auth::user()->dob}}">
            <label for="geboorteplaats">Geboorteplaats</label>
            <input type="text" class="form-control mb-3" id="geboorteplaats" name="geboorteplaats" required value="{{Auth::user()->geboorteplaats}}">
            <label for="telefoonnummer">Telefoonnummer</label>
            <input type="text" class="form-control mb-3" id="telefoonnummer" name="telefoonnummer" required value="{{Auth::user()->telefoonnummer}}">

            <h3>Adres</h3>
            <label for="adres">Straatnaam, nummer en toevoeging</label>
            <input type="text" class="form-control mb-3" id="adres" name="adres" required value="{{Auth::user()->adres}}">
            <label for="postcode">Postcode</label>
            <input type="text" class="form-control mb-3" id="postcode" name="postcode" required value="{{Auth::user()->postcode}}">
            <label for="woonplaats">Woonplaats</label>
            <input type="text" class="form-control mb-3" id="woonplaats" name="woonplaats" required value="{{Auth::user()->woonplaats}}">

            <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Opslaan</button>
        </form>

@endsection