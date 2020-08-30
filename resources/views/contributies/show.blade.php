@extends('layout')
@section('title','Contributie')
@section('content')
<header>
    <h1 class="d-lg-inline">Contributie</h1>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-lg-right" data-href="/contributies/{{$contributie->contributie_id}}"
        data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}"
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
                        <h4>{{Carbon\Carbon::parse($contributie->datum)->translatedFormat('d F Y - l')}}</h4>
                    </div>
                    <div class="col-lg-12">
                        <small class="text-muted">Omschrijving</small>
                        <p>{{ $contributie->soort }}</p>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted">Bedrag</small>
                        <p><strong>&euro;{{ format_currency($contributie->bedrag) }}</strong></p>
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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leden_deelname as $lid)
                        <tr>
                            <th><strong>{{$lid->roepnaam}} {{$lid->achternaam}}</strong></th>
                            <td><span data-feather="check"></span></td>
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
