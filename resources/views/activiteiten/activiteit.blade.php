@extends('layout')
@section('title','Activiteit')
@section('content')
    <h3>Activiteit</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/activiteiten/wijzig/{{$activiteit->activiteit_id}}">Activiteit wijzigen</a>
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
                <th scope="row">{{ $activiteit->activiteit_soort }}</th>
                <td>{{ $activiteit->datum }}</td>
                <td>{{ $activiteit->omschrijving }}</td>
                <td>&euro;{{ $activiteit->budget }}</td>
                <td>&euro;{{ $activiteit->naheffing }}</td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $activiteit->betaald_door_id }}</td>
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