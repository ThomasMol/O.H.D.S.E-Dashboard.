@extends('layout')
@section('title','Borrels')
@section('content')
    <h3>Borrels</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/borrels/toevoegen">Borrel toevoegen</a>
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
        @foreach($borrels as $borrel)
            <tr>
                <th scope="row">{{ $borrel->borrel_soort }}</th>
                <td>{{ $borrel->datum }}</td>
                <td>{{ $borrel->omschrijving }}</td>
                <td>&euro;{{ $borrel->budget }}</td>
                <td>&euro;{{ $borrel->naheffing }}</td>
                <td><a class="btn btn-success" href="/borrel/{{$borrel->borrel_id}}">Bekijk</a></td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $borrel->betaald_door_id }}</td>
                    <td scope="col"><a class="btn btn-primary" href="/borrels/wijzig/{{$borrel->borrel_id}}">Wijzig</a></td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection