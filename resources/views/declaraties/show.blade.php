@extends('layout')
@section('title','Declaratie')
@section('content')

<header>
    <h1 class="d-lg-inline">Declaratie</h1>
    @if(Auth::user()->lid_id == $declaratie->betaald_door_id || Auth::user()->lid_id == $declaratie->created_by_id )
    <button data-href="/declaraties/{{$declaratie->declaratie_id}}" data-toggle="modal" data-target="#confirm-delete"
        class="btn btn-outline-danger float-lg-right"><span data-feather="trash"></span> Verwijder</button>
    <a href="/declaraties/{{$declaratie->declaratie_id}}/wijzig"
        class="btn btn-outline-primary float-lg-right mr-2"><span data-feather="edit"></span> Wijzig</a>

    @endif

</header>

<div class="row">
    <div class="col-lg-4">
        <div class="card card-sticky">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <small class="text-muted">Datum</small>
                        <h4>{{Carbon\Carbon::parse($declaratie->datum)->translatedFormat('d F Y - l')}}</h4>
                    </div>
                    <div class="col-lg-12">
                        <small class="text-muted">Omschrijving</small>
                        <p>{{ $declaratie->omschrijving }}</p>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted">Bedrag</small>
                        <p><strong>&euro;{{ format_currency($declaratie->bedrag) }}</strong></p>
                    </div>
                    <div class="col-sm-12">
                        <small class="text-muted">Betaald door</small>
                        <p>{{ $declaratie->lid1_roepnaam }} {{ $declaratie->lid1_achternaam }}</p>
                    </div>
                    <div class="col-sm-12">
                        <small class="text-muted">Aangemaakt door</small>
                        <p>{{ $declaratie->lid2_roepnaam }} {{ $declaratie->lid2_achternaam }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Leden</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Naam</th>
                            <th scope="col">Bedrag</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leden_deelname as $lid)
                        <tr>
                            <th><strong>{{$lid->roepnaam}} {{$lid->achternaam}}</strong></th>
                            <td>&euro;{{ format_currency($lid->bedrag) }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('confirm_dialog')
@endsection
