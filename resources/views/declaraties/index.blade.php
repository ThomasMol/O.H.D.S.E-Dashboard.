@extends('layout')
@section('title','Declaraties')
@section('content')

<header>
    <h3 class="d-inline">Declaraties</h3>
    <a href="/declaraties/toevoegen" class="btn btn-outline-primary float-right"><span
            data-feather="plus-circle"></span>
        Declaratie toevoegen</a>
</header>

<table class="table table-hover table-sm table-responsive ">
    <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">(Totaal) Bedrag</th>
            <th scope="col">Aangemaakt door</th>
            <th scope="col"></th>
            <th scope="col"></th>

        </tr>
    </thead>
    <tbody>
        @foreach($declaraties as $declaratie)
        <tr>
            <th>{{ date('d F Y - l', strtotime($declaratie->datum)) }}</th>
            <td>{{ $declaratie->omschrijving }}</td>
            <td>&euro; {{ format_currency($declaratie->bedrag) }}</td>
            <td>{{ $declaratie->roepnaam }} {{ $declaratie->achternaam }}</td>
            <td>
                <a class="btn btn-link" href="/declaratie/{{$declaratie->declaratie_id}}"><span data-feather="eye"></span> Bekijk</a>
                @if(Auth::user()->admin == 1)
                <a class="btn btn-link" href="/declaraties/{{$declaratie->declaratie_id}}/wijzig"><span data-feather="edit"></span> Wijzig</a>
                @endif
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
<div class="text-center">

</div>
@endsection
