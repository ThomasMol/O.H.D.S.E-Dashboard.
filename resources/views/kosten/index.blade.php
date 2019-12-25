@extends('layout')
@section('title','Overige kosten')
@section('content')
    <h3>Overige kosten</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/kosten/toevoegen">Kosten toevoegen</a>
    @endif
    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Reden</th>
            <th scope="col">Wie</th>
            @if(Auth::user()->admin == 1 )
                <th scope="col"></th>
                <th scope="col"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($kosten as $koste)
        <tr>
            <td>{{ $koste->datum }}</td>
            <td>&euro; {{ format_currency($koste->bedrag) }}</td>
            <td>{{ $koste->reden }}</td>
            <td>{{ $koste->roepnaam }} {{ $koste->achternaam }}</td>

            @if(Auth::user()->admin == 1 )
                <td>
                    <a class="btn btn-light" href="/kosten/{{$koste->kosten_id}}/wijzig">wijzig</a>
                </td>
                <td>
                    <form action="/kosten/{{$koste->kosten_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>

@endsection
