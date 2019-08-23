@extends('layout')
@section('title','Boetes')
@section('content')
    <h3>Boetes</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/boetes/toevoegen">Boete toevoegen</a>
    @endif
    <table class="table table-hover table-responsive table-sm ">
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
        @foreach($boetes as $boete)
        <tr>
            <td>{{ $boete->datum }}</td>
            <td>&euro; {{ format_currency($boete->bedrag) }}</td>
            <td>{{ $boete->reden }}</td>
            <td>{{ $boete->roepnaam }} {{ $boete->achternaam }}</td>

            @if(Auth::user()->admin == 1 )
                <td>
                    <a class="btn btn-light" href="/boetes/{{$boete->boete_id}}/wijzig">wijzig</a>
                </td>
                <td>
                    <form action="/boetes/{{$boete->boete_id}}" method="POST">
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