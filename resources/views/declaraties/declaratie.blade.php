@extends('layout')
@section('title','Declaratie')
@section('content')
    <h3>Declaratie</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/declaratie/wijzig/{{$declaratie->declaratie_id}}">Declaratie wijzigen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Betaald door</th>
            <th scope="col">Aangemaakt door</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $declaratie->datum }}</td>
            <td>{{ $declaratie->omschrijving }}</td>
            <td>&euro; {{ $declaratie->bedrag }}</td>
            <td>{{ $declaratie->betaald_door_id }}</td>
            <td>{{ $declaratie->created_by_id }}</td>
        </tr>

        </tbody>
    </table>

    <ul>
        @foreach($leden_deelname as $lid)
            <li>{{$lid->roepnaam}} kosten: &euro; {{$lid->bedrag}}</li>
        @endforeach
    </ul>
@endsection