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
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($contributies as $contributie)
            <tr>
                <th scope="row">{{ date('d F Y - l', strtotime($contributie->datum))  }}</th>
                <td>{{ $contributie->omschrijving }}</td>
                <td>&euro;{{ $contributie->bedrag }}</td>
                <td><a class="btn btn-light" href="/contributie/{{$contributie->contributie_id}}">Bekijk</a>
                @if(Auth::user()->admin == 1)
                    <a class="btn btn-light" href="/contributies/wijzig/{{$contributie->contributie_id}}">Wijzig</a>
                    <a class="btn btn-outline-danger" href="/contributies/verwijder/{{$contributie->contributie_id}}">Verwijder</a>
                @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection