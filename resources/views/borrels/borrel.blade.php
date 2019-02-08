@extends('layout')
@section('title','Borrel')
@section('content')
    <h3>Borrel</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/borrels/wijzig/{{$borrel->borrel_id}}">Borrel wijzigen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
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
                <td>{{ $borrel->datum }}</td>
                <td>{{ $borrel->omschrijving }}</td>
                <td>&euro;{{ $borrel->budget }}</td>
                <td>&euro;{{ $borrel->naheffing }}</td>
                @if(Auth::user()->admin == 1)
                    <td>{{ $borrel->betaald_door_id }}</td>
                @endif
            </tr>

        </tbody>
    </table>

    <ul>
        @foreach($leden_aanwezigheid as $lid)
            <li>{{$lid->roepnaam}} aanwezig: {{$lid->aanwezig}}</li>
        @endforeach
    </ul>
@endsection