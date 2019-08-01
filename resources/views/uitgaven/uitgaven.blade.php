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

        </tr>
        </thead>
        <tbody>
        @foreach($uitgaven as $uitgave)
            <tr>
                <th>{{ date('d F Y - l', strtotime($uitgave->datum))}}</th>
                <td>{{ $uitgave->categorie }}</td>
                <td>{{ $uitgave->omschrijving }}</td>
                <td>&euro;{{ $uitgave->budget }}</td>
                <td>&euro;{{ $uitgave->uitgave }}</td>
                <td>&euro;{{ $uitgave->naheffing }}</td>
                <td><a class="btn btn-light" href="/uitgave/{{$uitgave->uitgave_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-light" href="/uitgaven/wijzig/{{$uitgave->uitgave_id}}">Wijzig</a>
                        <a class="btn btn-outline-danger" href="/uitgaven/verwijder/{{$uitgave->uitgave_id}}">Verwijder</a>
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