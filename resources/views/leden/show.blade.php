@extends('layout')
@section('title','Gegevens')
@section('content')
<header>
    <h1 class="d-lg-inline">Gegevens van {{$lid->roepnaam}}</h1>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-lg-right" data-href="/leden/{{$lid->lid_id}}" data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Royeer {{$lid->roepnaam}}</button>

    <a href="/leden/{{$lid->lid_id}}/wijzig" class="btn btn-outline-primary float-lg-right mr-2"><span data-feather="edit"></span> Wijzig</a>
    @endif
</header>

    <div class="row">

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Persoonlijke gegevens
                </div>
                <div class="card-body">
                    <small class="text-muted">Roepnaam</small>
                    <p>{{$lid->roepnaam}}</p>

                    <small class="text-muted">Voornamen</small>
                    <p>{{$lid->voornamen}}</p>

                    <small class="text-muted">Achternaam</small>
                    <p>{{$lid->achternaam}}</p>

                    <small class="text-muted">Emailadres</small>
                    <p>{{$lid->email}}</p>


                    <small class="text-muted">Telefoonnummer</small>
                    <p>{{$lid->telefoonnummer}}</p>

                    <small class="text-muted">Geboorteplaats</small>
                    <p>{{$lid->geboorteplaats}}</p>

                    <small class="text-muted">Geboortedatum</small>
                    <p>{{$lid->geboortedatum}}</p>

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
                    <p>{{$lid->straatnaam}}</p>

                    <small class="text-muted">Postcode</small>
                    <p>{{$lid->postcode}}</p>

                    <small class="text-muted">Stad</small>
                    <p>{{$lid->stad}}</p>

                    <small class="text-muted">Land</small>
                    <p>{{$lid->land}}</p>
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
                    <p>&euro; {{ format_currency($lid->verschuldigd)}}</p>
                    <small class="text-muted">Overgemaakt</small>
                    <p>&euro; {{format_currency($lid->overgemaakt)}}</p>
                    <small class="text-muted">Gespaard</small>
                    <p>&euro; {{format_currency($lid->gespaard)}}</p>
                    <small class="text-muted">Schuld</small>
                    <p>&euro; {{format_currency($lid->schuld)}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Overige gegevens
                </div>
                <div class="card-body">
                    <small class="text-muted">Bestuur</small>
                    <p>{{$lid->adminOptions()[$lid->admin]}}</p>

                    <small class="text-muted">Type lid</small>
                    <p>{{$lid->type_lid}}</p>

                    <small class="text-muted">Lichting</small>
                    <p>{{$lid->lichting}}</p>

                    {{-- <small class="text-muted">Profiel foto</small>
                    <img /> --}}
                </div>
            </div>
        </div>
    </div>
    @include('confirm_dialog')

@endsection
