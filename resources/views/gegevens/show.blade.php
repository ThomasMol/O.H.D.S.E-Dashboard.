@extends('layout')
@section('title','Mijn gegevens')
@section('content')
<header>
    <h1 class="d-lg-inline">Mijn gegevens</h1>
    <a href="/gegevens/wijzig" class="btn btn-outline-primary float-lg-right"><span data-feather="edit"></span>
        Wijzig</a>
</header>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Accountgegevens
            </div>
            <div class="card-body">
                <small class="text-muted">Emailadres</small>
                <p>{{Auth::user()->email}}</p>

                <hr>
                <h4>Wachtwoord veranderen</h4>
                <form action="" method="post">
                    @csrf
                    <input id="email" type="email" name="email" value="{{ Auth::user()->email }}" required hidden>
                    <label for="inputPassword" class="">Huidig wachtwoord</label>
                    <input type="password" id="inputPassword" class="form-control mb-4" placeholder="wachtwoord"
                        name="password" required>
                    <label for="inputPassword" class="">Nieuw wachtwoord</label>
                    <input type="password" id="inputPassword" class="form-control mb-4" placeholder="nieuw wachtwoord"
                        name="new_password" required>
                    <button class="btn btn-outline-primary btn-block" type="submit"
                        onclick="return confirm('Weet je zeker dat je je wachtwoord wilt veranderen?')">Verander
                        wachtwoord</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Persoonlijke gegevens
            </div>
            <div class="card-body">
                <small class="text-muted">Roepnaam</small>
                <p>{{Auth::user()->roepnaam}}</p>

                <small class="text-muted">Voornamen</small>
                <p>{{Auth::user()->voornamen}}</p>

                <small class="text-muted">Achternaam</small>
                <p>{{Auth::user()->achternaam}}</p>

                <small class="text-muted">Telefoonnummer</small>
                <p>{{$lid_gegevens->telefoonnummer}}</p>

                <small class="text-muted">Geboorteplaats</small>
                <p>{{$lid_gegevens->geboorteplaats}}</p>

                <small class="text-muted">Geboortedatum</small>
                <p>{{$lid_gegevens->geboortedatum}}</p>

            </div>
        </div>


    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Adres
            </div>
            <div class="card-body">
                <small class="text-muted">Straatnaam, nummer en toevoeging</small>
                <p>{{$lid_gegevens->straatnaam}}</p>

                <small class="text-muted">Postcode</small>
                <p>{{$lid_gegevens->postcode}}</p>

                <small class="text-muted">Stad</small>
                <p>{{$lid_gegevens->stad}}</p>

                <small class="text-muted">Land</small>
                <p>{{$lid_gegevens->land}}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Finance
            </div>
            <div class="card-body">
                @foreach($rekeningnummers as $rekeningnummer)
                <small class="text-muted">Rekeningnummer {{$loop->index + 1}}</small>
                <p>{{$rekeningnummer->rekeningnummer}}</p>
                @endforeach
                <small class="text-muted">Verschuldigd</small>
                <p>&euro; {{ format_currency($financien->verschuldigd)}}</p>
                <small class="text-muted">Overgemaakt</small>
                <p>&euro; {{format_currency($financien->overgemaakt)}}</p>
                <small class="text-muted">Gespaard</small>
                <p>&euro; {{format_currency($financien->gespaard)}}</p>
                <small class="text-muted">Schuld</small>
                <p>&euro; {{format_currency($financien->schuld)}}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Overige gegevens
            </div>
            <div class="card-body">
                <small class="text-muted">Admin?</small>
                <p>{{Auth::user()->admin}}</p>

                <small class="text-muted">Type lid</small>
                <p>{{Auth::user()->type_lid}}</p>

                <small class="text-muted">Lichting</small>
                <p>{{Auth::user()->lichting}}</p>

                <small class="text-muted">Profiel foto</small>
                <img />
            </div>
        </div>
    </div>
</div>
@endsection
