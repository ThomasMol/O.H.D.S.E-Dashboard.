@extends('layout')
@section('title','Contributie')
@section('content')
    <h3>Contributie</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/contributies/{{$contributie->contributie_id}}/wijzig">Contributie wijzigen</a>
    @endif
    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $contributie->datum }}</th>
                <td>{{ $contributie->contributie_soort }}</td>
                <td>{{ format_currency($contributie->bedrag) }}</td>
            </tr>

        </tbody>
    </table>

    <ul>
        @foreach($leden_deelname as $lid)
            <li>{{$lid->roepnaam}} deelname </li>
        @endforeach
    </ul>
@endsection