@extends('layout')
@section('title','Lid toevoegen')
@section('content')
    <h2 class="mb-4">Lid toevoegen</h2>

    <form class="card" method="POST" action="/leden/toevoegen">
        @csrf
        <h3>Persoonsgevevens</h3>
        <label for="roepnaam">Roepnaam</label>
        <input type="text" class="form-control mb-3" id="roepnaam" name="roepnaam" autofocus required>
        <label for="voornamen">Voornamen</label>
        <input type="text" class="form-control mb-3" id="voornamen" name="voornamen" required>
        <label for="achternaam">Achternaam</label>
        <input type="text" class="form-control mb-3" id="achternaam" name="achternaam" required>
        <label for="dob">Geboortedatum</label>
        <input type="date" class="form-control mb-3" id="dob" name="dob" required>
        <label for="geboorteplaats">Geboorteplaats</label>
        <input type="text" class="form-control mb-3" id="geboorteplaats" name="geboorteplaats" required>
        <label for="telefoonnummer">Telefoonnummer</label>
        <input type="text" class="form-control mb-3" id="telefoonnummer" name="telefoonnummer" required>

        <h3>Accountgegevens</h3>
        <label for="email">Email</label>
        <input type="email" class="form-control mb-3" id="email" name="email" required>
        <label for="wacthwoord">Wachtwoord</label>
        <input type="text" class="form-control mb-3" id="wacthwoord" name="password" required>

        <h3>Adres</h3>
        <label for="adres">Straatnaam, nummer en toevoeging</label>
        <input type="text" class="form-control mb-3" id="adres" name="adres" required>
        <label for="postcode">Postcode</label>
        <input type="text" class="form-control mb-3" id="postcode" name="postcode" required>
        <label for="woonplaats">Woonplaats</label>
        <input type="text" class="form-control mb-3" id="woonplaats" name="woonplaats" required>

        <h3>Finance</h3>
        <label for="rekeningnummer">Rekeningnummer 1</label>
        <input type="text" class="form-control mb-3" id="rekeningnummer" name="rekeningnummer" required>
        <label for="rekeningnummer2">Rekeningnummer 2 (optioneel)</label>
        <input type="text" class="form-control mb-3" id="rekeningnummer2" name="rekeningnummer2">
        <label for="verschuldigd">Verschuldigd</label>
        <input type="number" class="form-control mb-3" id="verschuldigd" name="verschuldigd" value="0" step=".01" required>
        <label for="overgemaakt">Overgemaakt</label>
        <input type="number" class="form-control mb-3" id="overgemaakt" name="overgemaakt" value="0" step=".01" required>
        <label for="gespaard">Gespaard</label>
        <input type="number" class="form-control mb-3" id="gespaard" name="gespaard" value="0" step=".01" required>

        <h3>Overige gegevens</h3>
        <label for="admin">Admin?</label>
        <select class="form-control mb-3" id="admin" name="admin" required>
            <option value="1">Ja</option>
            <option selected value="0">Nee</option>
        </select>
        <label for="type_lid">Type lid</label>
        <select class="form-control mb-3" id="type_lid" name="type_lid" required>
            <option selected value="Actief">Actief</option>
            <option value="Passief">Passief</option>
            <option value="Reünist">Re&uuml;nist</option>
            <option value="Geen">Geen</option>
        </select>

        <label for="lichting">Lichting</label>
        <input type="number" class="form-control mb-3" id="lichting" name="lichting" min="1" required>

        <label for="profiel_foto">Profiel foto</label>
        <input type="file" class="form-control mb-3" id="profiel_foto" name="profiel_foto" accept="image/" >

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Voeg lid toe</button>
    </form>

@endsection