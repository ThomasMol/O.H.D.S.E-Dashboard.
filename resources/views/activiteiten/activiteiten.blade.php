@extends('layout')
@section('title','Activiteiten')
@section('content')
    <h3>Activiteiten</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/activiteiten/toevoegen">Activiteit toevoegen</a>
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
        @foreach($activiteiten as $activiteit)
            <tr>
                <th scope="row">{{ $activiteit->activiteit_soort }}</th>
                <td>{{ $activiteit->datum }}</td>
                <td>{{ $activiteit->omschrijving }}</td>
                <td>&euro;{{ $activiteit->budget }}</td>
                <td>&euro;{{ $activiteit->naheffing }}</td>
                <td><a class="btn btn-success" href="/activiteit/{{$activiteit->activiteit_id}}">Bekijk</a></td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $activiteit->betaald_door_id }}</td>
                    <td scope="col"><a class="btn btn-primary" href="/activiteiten/wijzig/{{$activiteit->activiteit_id}}">Wijzig</a></td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection