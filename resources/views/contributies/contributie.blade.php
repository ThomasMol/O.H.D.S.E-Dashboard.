@extends('layout')
@section('title','Contributie')
@section('content')
    <h3>Contributie</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/contributies/wijzig/{{$contributie->contributie_id}}">Contributie wijzigen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Soort</th>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Budget</th>
            <th scope="col">Naheffing</th>
            @if(Auth::user()->admin == 1)
                <th scope="col">Betaald door</th>
            @endif
        </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $contributie->contributie_soort }}</th>
                <td>{{ $contributie->datum }}</td>
                <td>{{ $contributie->omschrijving }}</td>
                <td>&euro;{{ $contributie->budget }}</td>
                <td>&euro;{{ $contributie->naheffing }}</td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $contributie->betaald_door_id }}</td>
                @endif
            </tr>

        </tbody>
    </table>

    <ul>
        @foreach($leden_participatie as $lid)
            <li>{{$lid->roepnaam}} aanwezig: {{$lid->aanwezig}}</li>
        @endforeach
    </ul>
@endsection