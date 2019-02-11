@extends('layout')
@section('title','Declaraties')
@section('content')
    <h3>Declaraties</h3>
    <a class="btn btn-primary" href="/declaraties/toevoegen">Declaratie toevoegen</a>
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
                <td>&euro;{{ $declaratie->betaald_door_id }}</td>
                <td><a class="btn btn-success" href="/declaratie/{{$declaratie->declaratie_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-primary" href="/declaraties/wijzig/{{$declaratie->declaratie_id}}">Wijzig</a>
                    @endif
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="text-center">

    </div>
@endsection