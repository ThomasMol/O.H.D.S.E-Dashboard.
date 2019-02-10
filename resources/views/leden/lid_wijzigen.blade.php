@extends('layout')
@section('title','Wijzig lid gegevens')
@section('content')

    <h2 class="mb-4">Wijzig gegevens van {{$lid->roepnaam}} {{$lid->achternaam}}</h2>

    {{--<form class="form mb-4" method="POST" action="/leden/wijzig/{{$lid->lid_id}}">
        @csrf
        <h3>Inlog gegevens</h3>
        <label for="email">Email</label>
        <input type="email" class="form-control mb-3" id="email" name="email" required value="{{$lid->email}}">
        <label for="wacthwoord">Wachtwoord</label>
        <input type="text" class="form-control mb-3" id="wacthwoord" name="password" value="">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Opslaan</button>
    </form>--}}

    <form class="card mb-4" method="POST" action="/leden/wijzig/{{$lid->lid_id}}">
        @csrf
        <h3>Persoonsgevevens</h3>
        <label for="roepnaam">Roepnaam</label>
        <input type="text" class="form-control mb-3" id="roepnaam" name="roepnaam" required value="{{$lid->roepnaam}}">
        <label for="voornamen">Voornamen</label>
        <input type="text" class="form-control mb-3" id="voornamen" name="voornamen" required value="{{$lid->voornamen}}">
        <label for="achternaam">Achternaam</label>
        <input type="text" class="form-control mb-3" id="achternaam" name="achternaam" required value="{{$lid->achternaam}}">
        <label for="dob">Geboortedatum</label>
        <input type="date" class="form-control mb-3" id="dob" name="dob" required value="{{$lid->dob}}">
        <label for="geboorteplaats">Geboorteplaats</label>
        <input type="text" class="form-control mb-3" id="geboorteplaats" name="geboorteplaats" required value="{{$lid->geboorteplaats}}">
        <label for="telefoonnummer">Telefoonnummer</label>
        <input type="text" class="form-control mb-3" id="telefoonnummer" name="telefoonnummer" required value="{{$lid->telefoonnummer}}">

        <h3>Adres</h3>
        <label for="adres">Straatnaam, nummer en toevoeging</label>
        <input type="text" class="form-control mb-3" id="adres" name="adres" required value="{{$lid->adres}}">
        <label for="postcode">Postcode</label>
        <input type="text" class="form-control mb-3" id="postcode" name="postcode" required value="{{$lid->postcode}}">
        <label for="woonplaats">Woonplaats</label>
        <input type="text" class="form-control mb-3" id="woonplaats" name="woonplaats" required value="{{$lid->woonplaats}}">

        <h3>Finance</h3>
        <label for="rekeningnummer">Rekeningnummer 1</label>
        <input type="text" class="form-control mb-3" id="rekeningnummer" name="rekeningnummer" required value="{{$lid->rekeningnummer}}">
        <label for="rekeningnummer2">Rekeningnummer 2 (optioneel)</label>
        <input type="text" class="form-control mb-3" id="rekeningnummer2" name="rekeningnummer2" value="{{$lid->rekeningnummer_2}}">
        <label for="verschuldigd">Verschuldigd</label>
        <input type="number" class="form-control mb-3" id="verschuldigd" name="verschuldigd" required step=".01" value="{{$lid->verschuldigd}}">
        <label for="overgemaakt">Overgemaakt</label>
        <input type="number" class="form-control mb-3" id="overgemaakt" name="overgemaakt" required step=".01" value="{{$lid->overgemaakt}}">
        <label for="gespaard">Gespaard</label>
        <input type="number" class="form-control mb-3" id="gespaard" name="gespaard" required step=".01" value="{{$lid->gespaard}}">

        <h3>Overige gegevens</h3>
        <label for="admin">Admin?</label>
        <select class="form-control mb-3" id="admin" name="admin" required value="{{$lid->admin}}">
            <option selected value="1">Ja</option>
            <option value="0">Nee</option>
        </select>
        <label for="type_lid">Type lid</label>
        <select class="form-control mb-3" id="type_lid" name="type_lid" required value="{{$lid->type_lid}}">
            <option selected value="Actief">Actief</option>
            <option value="Passief">Passief</option>
            <option value="Reünist">Re&uuml;nist</option>
            <option value="Geen">Geen</option>
        </select>

        <label for="lichting">Lichting</label>
        <input type="number" class="form-control mb-3" id="lichting" name="lichting" min="1" required value="{{$lid->lichting}}">

        <label for="profiel_foto">Profiel foto</label>
        <input type="file" class="form-control mb-3" id="profiel_foto" name="profiel_foto" accept="image/"  {{--value="{{$lid->profiel_foto}}"--}}>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Opslaan</button>
    </form>

@endsection