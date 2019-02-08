@extends('layout')
@section('title','Mijn gegevens')
@section('content')
    <h3 class="mb-4">Mijn gegevens</h3>

    <a class="btn btn-primary mb-5" href="/gegevens/wijzig">Wijzig gegevens</a>

    <div>
        <h3>Persoonsgevevens</h3>
        <label for="roepnaam">Roepnaam</label>
        <h4>{{Auth::user()->roepnaam}}</h4>
        <label for="voornamen">Voornamen</label>
        <h4>{{Auth::user()->voornamen}}</h4>
        <label for="achternaam">Achternaam</label>
        <h4>{{Auth::user()->achternaam}}</h4>
        <label for="dob">Geboortedatum</label>
        <h4>{{Auth::user()->dob}}</h4>
        <label for="geboorteplaats">Geboorteplaats</label>
        <h4>{{Auth::user()->geboorteplaats}}</h4>
        <label for="telefoonnummer">Telefoonnummer</label>
        <h4>{{Auth::user()->telefoonnummer}}</h4>
<hr>
        <h3>Accountgegevens</h3>
        <label for="email">Email</label>
        <h4>{{Auth::user()->email}}</h4>
        <hr>

        <h3>Adres</h3>
        <label for="adres">Straatnaam, nummer en toevoeging</label>
        <h4>{{Auth::user()->adres}}</h4>
        <label for="postcode">Postcode</label>
        <h4>{{Auth::user()->postcode}}</h4>
        <label for="woonplaats">Woonplaats</label>
        <h4>{{Auth::user()->woonplaats}}</h4>
        <hr>

        <h3>Finance</h3>
        <label for="rekeningnummer">Rekeningnummer 1</label>
        <h4>{{Auth::user()->rekeningnummer}}</h4>
        <label for="rekeningnummer2">Rekeningnummer 2 (optioneel)</label>
        <h4>{{Auth::user()->rekeningnummer_2}}</h4>
        <label for="verschuldigd">Verschuldigd</label>
        <h4>{{Auth::user()->verschuldigd}}</h4>
        <label for="overgemaakt">Overgemaakt</label>
        <h4>{{Auth::user()->overgemaakt}}</h4>
        <label for="gespaard">Gespaard</label>
        <h4>{{Auth::user()->gespaard}}</h4>
        <label for="gespaard">Schuld</label>
        <h4>{{Auth::user()->verschuldigd - Auth::user()->overgemaakt}}</h4>
        <hr>

        <h3>Overige gegevens</h3>
        <label for="admin">Admin?</label>
        <h4>{{Auth::user()->admin}}</h4>

        <label for="type_lid">Type lid</label>
        <h4>{{Auth::user()->type_lid}}</h4>

        <label for="lichting">Lichting</label>
        <h4>{{Auth::user()->lichting}}</h4>

        <label for="profiel_foto">Profiel foto</label>
        <img/>
    </div>
@endsection