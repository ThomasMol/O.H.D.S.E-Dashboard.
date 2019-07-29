@extends('layout')
@section('title','Uitgave')
@section('content')
    <h3>Uitgave</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/uitgaven/wijzig/{{$uitgave->uitgave_id}}">Uitgave wijzigen</a>
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

        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $uitgave->datum }}</td>
                <td>{{ $uitgave->categorie }}</td>
                <td>{{ $uitgave->omschrijving }}</td>
                <td>&euro;{{ $uitgave->budget }}</td>
                <td>&euro;{{ $uitgave->uitgave }}</td>
                <td>&euro;{{ $uitgave->naheffing }}</td>

            </tr>

        </tbody>
    </table>

    <ul>
        @foreach($leden_deelname as $lid)
            <li>{{$lid->roepnaam}} aanwezig: ja </li>
        @endforeach
    </ul>
@endsection