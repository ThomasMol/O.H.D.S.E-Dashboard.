@extends('layout')
@section('title','Gegevens')
@section('content')
<header>
    <h1 class="d-inline">Gegevens van {{$lid->roepnaam}}</h1>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-right" data-href="/leden/{{$lid->lid_id}}" data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a href="/leden/{{$lid->lid_id}}/wijzig" class="btn btn-outline-primary float-right mr-2"><span data-feather="edit"></span> Wijzig</a>
    @endif
</header>

    <div class="row">
        <div class="col-md-4 card">
            <h3>Accountgegevens</h3>
            <label for="email">Email (en inlogcode)</label>
            <h4>{{$lid->email}}</h4>
        </div>

        <div class="col-md-4 card">
            <h3>Persoonlijke gegevens</h3>

            <label for="roepnaam">Roepnaam</label>
            <h4>{{$lid->roepnaam}}</h4>

            <label for="voornamen">Voornamen</label>
            <h4>{{$lid->voornamen}}</h4>

            <label for="achternaam">Achternaam</label>
            <h4>{{$lid->achternaam}}</h4>

            <label for="telefoonnummer">Telefoonnummer</label>
            <h4>{{$lid->telefoonnummer}}</h4>

            <label for="geboorteplaats">Geboorteplaats</label>
            <h4>{{$lid->geboorteplaats}}</h4>

            <label for="geboortedatum">Geboortedatum</label>
            <h4>{{$lid->geboortedatum}}</h4>
        </div>

        <div class="col-md-4 card">
            <h3>Adres</h3>
            <label for="straatnaam">Straatnaam, nummer en toevoeging</label>
            <h4>{{$lid->straatnaam}}</h4>

            <label for="postcode">Postcode</label>
            <h4>{{$lid->postcode}}</h4>

            <label for="stad">Stad</label>
            <h4>{{$lid->stad}}</h4>

            <label for="land">Land</label>
            <h4>{{$lid->land}}</h4>
        </div>

        <div class="col-md-4 card">
            <h3>Finance</h3>
            @foreach($rekeningnummers as $rekeningnummer)
                <label for="rekeningnummer">Rekeningnummer {{$loop->index + 1}}</label>
                <h4>{{$rekeningnummer->rekeningnummer}}</h4>
            @endforeach
            <label for="verschuldigd">Verschuldigd</label>
            <h4>&euro; {{ format_currency($lid->verschuldigd)}}</h4>
            <label for="overgemaakt">Overgemaakt</label>
            <h4>&euro; {{format_currency($lid->overgemaakt)}}</h4>
            <label for="gespaard">Gespaard</label>
            <h4>&euro; {{format_currency($lid->gespaard)}}</h4>
            <label for="gespaard">Schuld</label>
            <h4>&euro; {{format_currency($lid->schuld)}}</h4>
        </div>

        <div class="col-md-4 card">
            <h3>Overige gegevens</h3>
            <label for="admin">Admin?</label>
            <h4>{{$lid->admin}}</h4>

            <label for="type_lid">Type lid</label>
            <h4>{{$lid->type_lid}}</h4>

            <label for="lichting">Lichting</label>
            <h4>{{$lid->lichting}}</h4>

            <label for="profiel_foto">Profiel foto</label>
            <img/>
        </div>
    </div>
    @include('confirm_dialog')

@endsection
