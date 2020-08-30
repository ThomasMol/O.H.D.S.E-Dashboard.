@extends('layout')
@section('title','Uitgave')
@section('content')
<header>
    <h1 class="d-lg-inline">Uitgave</h1>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-lg-right" data-href="/uitgaven/{{$uitgave->uitgave_id}}"
        data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a class="btn btn-outline-primary float-lg-right mr-2"
        href="/uitgaven/{{$uitgave->uitgave_id}}/wijzig/{{$uitgave->jaargang}}"><span data-feather="edit"></span>
        Wijzig</a>
    @endif
</header>

<div class="row">
    <div class="col-lg-4">
        <div class="card card-sticky">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <small class="text-muted">Datum</small>
                        <h4>{{Carbon\Carbon::parse($uitgave->datum)->translatedFormat('d F Y - l')}}</h4>
                    </div>
                    <div class="col-lg-12">
                        <small class="text-muted">Soort</small>
                        <p>{{ $uitgave->soort }}</p>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted">Budget</small>
                        <p>&euro;{{ format_currency($uitgave->budget) }}</p>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted">Uitgave</small>
                        <p>&euro;{{ format_currency($uitgave->uitgave) }}</p>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted">Naheffing</small>
                        <p>&euro;{{ format_currency($uitgave->naheffing) }}</p>
                    </div>
                    <div class="col-sm-12">
                        <small class="text-muted">Omschrijving</small>
                        <p>{{ $uitgave->omschrijving }}</p>
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
                            <th scope="col">Aanwezig</th>
                            <th scope="col">Afgemeld</th>
                            <th scope="col">Naheffing</th>
                            <th scope="col">Boete</th>
                            <th scope="col">Extra kosten</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leden_deelname as $lid)
                        <tr>
                            <th><strong>{{$lid->roepnaam}} {{$lid->achternaam}}</strong></th>
                            <td>@if($lid->aanwezig)<span data-feather="check"></span>@endif</td>
                            <td>@if($lid->afgemeld)<span data-feather="check"></span>@endif</td>
                            <td>@if($lid->naheffing)&euro;{{format_currency($lid->naheffing)}}@endif</td>
                            <td>@if($lid->boete)<span data-feather="check"></span>@endif</td>
                            <td>@if($lid->extra_kosten)<span data-feather="check"></span>@endif</td>
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
