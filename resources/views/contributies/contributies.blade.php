@extends('layout')
@section('title','Contributies')
@section('content')
    <h3>Contributies</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/contributies/toevoegen">Contributie toevoegen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Soort</th>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Budget</th>
            <th scope="col">Naheffing</th>
            <th scope="col">Bekijk</th>
            @if(Auth::user()->admin == 1)
                <th scope="col">Betaald door</th>
                <th scope="col">Wijzig</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($contributies as $contributie)
            <tr>
                <th scope="row">{{ $contributie->contributie_soort }}</th>
                <td>{{ $contributie->datum }}</td>
                <td>{{ $contributie->omschrijving }}</td>
                <td>&euro;{{ $contributie->budget }}</td>
                <td>&euro;{{ $contributie->naheffing }}</td>
                <td><a class="btn btn-success" href="/contributie/{{$contributie->contributie_id}}">Bekijk</a></td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $contributie->betaald_door_id }}</td>
                    <td scope="col"><a class="btn btn-primary" href="/contributies/wijzig/{{$contributie->contributie_id}}">Wijzig</a></td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection