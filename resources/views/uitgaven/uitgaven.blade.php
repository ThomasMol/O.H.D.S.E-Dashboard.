@extends('layout')
@section('title','Uitgaven')
@section('content')
    <h3>Uitgaven</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/uitgaven/toevoegen">Uitgave toevoegen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Categorie</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Budget</th>
            <th scope="col">Uitgave</th>
            <th scope="col">(Totale) Naheffing</th>
            <th scope="col"></th>
            @if(Auth::user()->admin == 1)
                <th scope="col"></th>
            @endif

        </tr>
        </thead>
        <tbody>
        @foreach($uitgaven as $uitgave)
            <tr>
                <th>{{ date('d F Y - l', strtotime($uitgave->datum))}}</th>
                <td>{{ $uitgave->categorie }}</td>
                <td>{{ $uitgave->omschrijving }}</td>
                <td>&euro; {{ format_currency($uitgave->budget) }}</td>
                <td>&euro; {{ format_currency($uitgave->uitgave) }}</td>
                <td>&euro; {{ format_currency($uitgave->naheffing) }}</td>
                <td><a class="btn btn-light" href="/uitgave/{{$uitgave->uitgave_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-light" href="/uitgaven/{{$uitgave->uitgave_id}}/wijzig">Wijzig</a>
                </td><td>
                    <form action="/uitgaven/{{$uitgave->uitgave_id}}" method="POST">
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
    <div class="text-center">
        {!! $uitgaven->links(); !!}
    </div>
@endsection