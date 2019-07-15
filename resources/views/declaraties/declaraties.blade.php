@extends('layout')
@section('title','Declaraties')
@section('content')
    <h3>Declaraties</h3>
    <a class="btn btn-primary" href="/declaratie/toevoegen">Declaratie toevoegen</a>
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Betaald door</th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        @foreach($declaraties as $declaratie)
            <tr>
                <td>{{ $declaratie->datum }}</td>
                <td>{{ $declaratie->omschrijving }}</td>
                <td>&euro;{{ $declaratie->bedrag }}</td>
                <td>{{ $declaratie->betaald_door_id }}</td>
                <td>
                    <a class="btn btn-outline-primary" href="/declaratie/{{$declaratie->declaratie_id}}">Bekijk</a>
                    <a class="btn btn-outline-primary" href="/declaratie/wijzig/{{$declaratie->declaratie_id}}">Wijzig</a>
                    <a class="btn btn-outline-danger" href="/declaratie/verwijder/{{$declaratie->declaratie_id}}">Verwijder</a>
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="text-center">

    </div>
@endsection