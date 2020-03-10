@extends('layout')
@section('title','Borrels')
@section('content')
    <h3>Borrels</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/borrels/toevoegen">Borrel toevoegen</a>
    @endif
    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Budget</th>
            <th scope="col">Uitgave</th>
            <th scope="col">(Totale) Naheffing</th>
            <th scope="col">Omschrijving</th>
            <th scope="col"></th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        @foreach($borrels as $borrel)
            <tr>
                <th>{{ Carbon\Carbon::parse($borrel->datum)->translatedFormat('d F Y - l') }}</th>
                <td>&euro; {{ format_currency($borrel->budget) }}</td>
                <td>&euro; {{ format_currency($borrel->uitgave) }}</td>
                <td>&euro; {{ format_currency($borrel->naheffing) }}</td>
                <td>{{ $borrel->omschrijving }}</td>

                <td>
                    <a class="btn btn-light" href="/borrel/{{$borrel->borrel_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-light" href="/borrels/{{$borrel->borrel_id}}/wijzig">Wijzig</a>
                    @endif
                </td>
                <td>
                    <form action="/borrels/{{$borrel->borrel_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="text-center">

    </div>
@endsection
