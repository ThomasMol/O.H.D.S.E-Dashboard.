@extends('layout')
@section('title','Uitgave')
@section('content')
<header>
    <h3 class="d-inline">Uitgave</h3>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-right" data-href="/uitgaven/{{$uitgave->uitgave_id}}"
        data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a class="btn btn-outline-primary float-right mr-2" href="/uitgaven/{{$uitgave->uitgave_id}}/wijzig/{{$uitgave->jaargang}}"><span
            data-feather="edit"></span> Wijzig</a>
    @endif
</header>

<table class="table table-hover table-sm table-responsive ">
    <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Categorie</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Budget</th>
            <th scope="col">Uitgave</th>
            <th scope="col">(Totale) Naheffing</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{date('d F Y - l', strtotime($uitgave->datum)) }}</td>
            <td>{{ $uitgave->soort }}</td>
            <td>{{ $uitgave->omschrijving }}</td>
            <td>&euro; {{ format_currency($uitgave->budget) }}</td>
            <td>&euro; {{ format_currency($uitgave->uitgave) }}</td>
            <td>&euro; {{ format_currency($uitgave->naheffing) }}</td>

        </tr>

    </tbody>
</table>

<ul class="list-group">
    @foreach($leden_deelname as $lid)
    <li class="list-group-item"><strong>{{$lid->roepnaam}} {{$lid->achternaam}}</strong> @if($lid->aanwezig) Aanwezig @endif @if($lid->naheffing)Naheffing: {{format_currency($lid->naheffing)}} @endif @if($lid->boete_id) Boete @endif</li>
    @endforeach
</ul>
@include('confirm_dialog')

@endsection
