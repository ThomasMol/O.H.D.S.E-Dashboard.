@extends('layout')
@section('title','Mijn gegevens')
@section('content')
<header>
    <h3 class="d-inline">Mijn gegevens</h3>
    <a href="/gegevens/wijzig" class="btn btn-outline-primary float-right"><span data-feather="edit"></span> Wijzig</a>
</header>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Accountgegevens
            </div>
            <div class="card-body">
                <label for="email">Email (en inlogcode)</label>
                <h4>{{Auth::user()->email}}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Persoonlijke gegevens
            </div>
            <div class="card-body">
                <label for="roepnaam">Roepnaam</label>
                <h4>{{Auth::user()->roepnaam}}</h4>

                <label for="voornamen">Voornamen</label>
                <h4>{{Auth::user()->voornamen}}</h4>

                <label for="achternaam">Achternaam</label>
                <h4>{{Auth::user()->achternaam}}</h4>

                <label for="telefoonnummer">Telefoonnummer</label>
                <h4>{{$lid_gegevens->telefoonnummer}}</h4>

                <label for="geboorteplaats">Geboorteplaats</label>
                <h4>{{$lid_gegevens->geboorteplaats}}</h4>

                <label for="geboortedatum">Geboortedatum</label>
                <h4>{{$lid_gegevens->geboortedatum}}</h4>

            </div>
        </div>


    </div>
    <div class="col-md-4 card">
        <h3>Adres</h3>
        <label for="straatnaam">Straatnaam, nummer en toevoeging</label>
        <h4>{{$lid_gegevens->straatnaam}}</h4>

        <label for="postcode">Postcode</label>
        <h4>{{$lid_gegevens->postcode}}</h4>

        <label for="stad">Stad</label>
        <h4>{{$lid_gegevens->stad}}</h4>

        <label for="land">Land</label>
        <h4>{{$lid_gegevens->land}}</h4>

    </div>

    <div class="col-md-4 card">
        <h3>Finance</h3>
        @foreach($rekeningnummers as $rekeningnummer)
        <label for="rekeningnummer">Rekeningnummer {{$loop->index + 1}}</label>
        <h4>{{$rekeningnummer->rekeningnummer}}</h4>
        @endforeach
        <label for="verschuldigd">Verschuldigd</label>
        <h4>&euro; {{ format_currency($financien->verschuldigd)}}</h4>
        <label for="overgemaakt">Overgemaakt</label>
        <h4>&euro; {{format_currency($financien->overgemaakt)}}</h4>
        <label for="gespaard">Gespaard</label>
        <h4>&euro; {{format_currency($financien->gespaard)}}</h4>
        <label for="gespaard">Schuld</label>
        <h4>&euro; {{format_currency($financien->schuld)}}</h4>
    </div>

    <div class="col-md-4 card">
        <h3>Overige gegevens</h3>
        <label for="admin">Admin?</label>
        <h4>{{Auth::user()->admin}}</h4>

        <label for="type_lid">Type lid</label>
        <h4>{{Auth::user()->type_lid}}</h4>

        <label for="lichting">Lichting</label>
        <h4>{{Auth::user()->lichting}}</h4>

        <label for="profiel_foto">Profiel foto</label>
        <img />
    </div>
</div>
@endsection
