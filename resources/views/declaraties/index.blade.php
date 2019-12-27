@extends('layout')
@section('title','Declaraties')
@section('content')

<div class="mb-4">
    <h3 class="d-inline">Declaraties</h3>
    <a href="/declaraties/toevoegen" class="btn btn-outline-primary float-right"><span data-feather="plus-circle"></span>
        Declaratie toevoegen</a>
</div>

<table class="table table-hover table-sm table-responsive ">
    <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">(Totaal) Bedrag</th>
            <th scope="col">Betaald door</th>
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
            <td>{{ $declaratie->betaald_door_id }}</td>
            <td>{{ $declaratie->created_by_id }}</td>
            <td>
                <a class="btn btn-light" href="/declaratie/{{$declaratie->declaratie_id}}">Bekijk</a>
                @if(Auth::user()->admin == 1)
                <a class="btn btn-light" href="/declaraties/{{$declaratie->declaratie_id}}/wijzig">Wijzig</a>
                @endif
            </td>
            <td>
                <form action="/declaraties/{{$declaratie->declaratie_id}}" method="POST">
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
