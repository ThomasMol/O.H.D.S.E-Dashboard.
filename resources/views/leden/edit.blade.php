@extends('layout')
@section('title','Lid wijzigen')
@section('content')
<header>
    <h2>Lid wijzigen</h2>
</header>

<form class="card" method="POST" action="/leden/{{$lid->lid_id}}">
    @csrf
    @method('patch')
    <h3>Persoonsgevevens</h3>
    <label for="roepnaam">Roepnaam</label>
    <input type="text" class="form-control mb-3" id="roepnaam" name="roepnaam" autofocus required
        value="{{$lid->roepnaam}}">
    <label for="voornamen">Voornamen</label>
    <input type="text" class="form-control mb-3" id="voornamen" name="voornamen" required value="{{$lid->voornamen}}">
    <label for="achternaam">Achternaam</label>
    <input type="text" class="form-control mb-3" id="achternaam" name="achternaam" required
        value="{{$lid->achternaam}}">
    <label for="geboortedatum">Geboortedatum</label>
    <input type="date" class="form-control mb-3" id="geboortedatum" name="geboortedatum" required
        value="{{$lid->geboortedatum}}">
    <label for="geboorteplaats">Geboorteplaats</label>
    <input type="text" class="form-control mb-3" id="geboorteplaats" name="geboorteplaats" required
        value="{{$lid->geboorteplaats}}">
    <label for="telefoonnummer">Telefoonnummer</label>
    <input type="text" class="form-control mb-3" id="telefoonnummer" name="telefoonnummer" required
        value="{{$lid->telefoonnummer}}">

    <h3>Accountgegevens</h3>
    <label for="email">Email</label>
    <input type="email" class="form-control mb-3" id="email" name="email" required value="{{$lid->email}}">

    <h3>Adres</h3>
    <label for="straatnaam">Straatnaam, nummer en toevoeging</label>
    <input type="text" class="form-control mb-3" id="straatnaam" name="straatnaam" required
        value="{{$lid->straatnaam}}">
    <label for="postcode">Postcode</label>
    <input type="text" class="form-control mb-3" id="postcode" name="postcode" required value="{{$lid->postcode}}">
    <label for="stad">Stad</label>
    <input type="text" class="form-control mb-3" id="stad" name="stad" required value="{{$lid->stad}}">
    <label for="land">Land</label>
    <input type="text" class="form-control mb-3" id="land" name="land" required value="{{$lid->land}}">

    <h3>Finance</h3>
    @foreach($rekeningnummers as $rekeningnummer)
    @if($loop->index == 0)
    <label for="rekeningnummer">Rekeningnummer {{$loop->index + 1}}</label>
    <input type="text" class="form-control mb-3" id="rekeningnummer" name="rekeningnummers[]"
        data-id="{{$loop->index + 1}}" required value="{{$rekeningnummer->rekeningnummer}}">
    @else
    <div id="extra_rekeningnummer">
        <label for="rekeningnummer">Rekeningnummer {{$loop->index + 1}}</label>
        <button type="button" class="btn btn-link" id="remove_rekeningnummer">verwijder</button>
        <input type="text" class="form-control mb-3" id="rekeningnummer" name="rekeningnummers[]"
            value="{{$rekeningnummer->rekeningnummer}}">
    </div>
    @endif
    @endforeach

    <div id="rekeningnummers"></div>
    <button type="button" id="add_rekeningnummer" class="btn btn-light mb-2">Voeg nog een rekeniningnummer toe</button>

    <label for="verschuldigd">Verschuldigd</label>
    <input type="number" class="form-control mb-3" id="verschuldigd" name="verschuldigd" value="0" step=".01" required
        value="{{$lid->verschuldigd}}">
    <label for="overgemaakt">Overgemaakt</label>
    <input type="number" class="form-control mb-3" id="overgemaakt" name="overgemaakt" value="0" step=".01" required
        value="{{$lid->overgemaakt}}">
    <label for="gespaard">Gespaard</label>
    <input type="number" class="form-control mb-3" id="gespaard" name="gespaard" value="0" step=".01" required
        value="{{$lid->gespaard}}">

    <h3>Overige gegevens</h3>
    <label for="admin">Admin?</label>
    <select class="form-control mb-3" id="admin" name="admin" required>
            @foreach($lid->adminOptions() as $key => $admin)
            <option {{$lid->admin == $key ? 'selected' : ''}} value="{{ $key }}">{{ $admin }}
            </option>
            @endforeach
    </select>
    <label for="type_lid">Type lid</label>
    <select class="form-control mb-3" id="type_lid" name="type_lid" required>
        @foreach($lid->lidTypeOptions() as $key => $lid_type)
        <option {{$lid->type_lid == $key ? 'selected' : ''}} value="{{ $key }}">{{ $lid_type }}
        </option>
        @endforeach
    </select>

    <label for="lichting">Lichting</label>
    <input type="number" class="form-control mb-3" id="lichting" name="lichting" min="1" required
        value="{{$lid->lichting}}">

    <label for="profiel_foto">Profiel foto</label>
    <input type="file" class="form-control mb-3" id="profiel_foto" name="profiel_foto" accept="image/">

    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 ">Wijzig lid</button>
</form>
@endsection
