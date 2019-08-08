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
            @if(Auth::user()->admin == 1)
                <th scope="col"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($contributies as $contributie)
            <tr>
                <th scope="row">{{ date('d F Y - l', strtotime($contributie->datum))  }}</th>
                <td>{{ $contributie->omschrijving }}</td>
                <td>&euro; {{ format_currency($contributie->bedrag) }}</td>
                <td><a class="btn btn-light" href="/contributie/{{$contributie->contributie_id}}">Bekijk</a>
                @if(Auth::user()->admin == 1)
                    <a class="btn btn-light" href="/contributies/{{$contributie->contributie_id}}/wijzig">Wijzig</a>
                    </td>
                    <td>
                    <form action="/contributies/{{$contributie->contributie_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection