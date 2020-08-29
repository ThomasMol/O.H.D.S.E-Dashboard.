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
                <h5>{{Carbon\Carbon::parse($uitgave->datum)->translatedFormat('l d F Y')}}</h5>
                <p>{{ $uitgave->soort }}<br>
                    &euro; {{ format_currency($uitgave->budget) }}<br>
                    &euro; {{ format_currency($uitgave->uitgave) }}<br>
                    &euro; {{ format_currency($uitgave->naheffing) }}<br>
                </p>
                <p>
                    {{ $uitgave->omschrijving }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Leden:</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($leden_deelname as $lid)
                    <li class="list-group-item"><strong>{{$lid->roepnaam}} {{$lid->achternaam}}</strong> @if($lid->aanwezig) Aanwezig
                        @endif @if($lid->naheffing)Naheffing: {{format_currency($lid->naheffing)}} @endif @if($lid->boete_id) Boete
                        @endif</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@include('confirm_dialog')

@endsection
