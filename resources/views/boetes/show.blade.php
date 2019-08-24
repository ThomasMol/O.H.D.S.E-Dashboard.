@extends('layout')
@section('title','Boetes')
@section('content')
    <h3>Boets</h3>
    @if(Auth::user()->admin == 1 )
        <a class="btn btn-primary" href="/boetes/{{$boete->boete_id}}/wijzig">Boete wijzigen</a>
    @endif
    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Reden</th>
            <th scope="col">Wie</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $borrel->datum }}</td>
            <td>&euro; {{ format_currency($borrel->bedrag) }}</td>
            <td>{{ $borrel->reden }}</td>
            <td>{{ $lid->roepnaam }} {{ $lid->achternaam }}</td>
        </tr>
        </tbody>
    </table>

@endsection