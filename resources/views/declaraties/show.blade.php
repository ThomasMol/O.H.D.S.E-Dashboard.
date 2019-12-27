@extends('layout')
@section('title','Declaratie')
@section('content')


<div class="mb-4">
    <h3 class="d-inline">Declaratie</h3>
    @if(Auth::user()->lid_id == $declaratie->betaald_door_id || Auth::user()->lid_id == $declaratie->created_by_id )
    <a href="/declaraties/{{$declaratie->declaratie_id}}/wijzig" class="btn btn-link float-right"><span
            data-feather="edit"></span> Wijzig</a>
    @endif

</div>


<table class="table table-hover table-sm table-responsive ">
    <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Betaald door</th>
            <th scope="col">Aangemaakt door</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $declaratie->datum }}</td>
            <td>{{ $declaratie->omschrijving }}</td>
            <td>&euro; {{ format_currency($declaratie->bedrag) }}</td>
            <td>{{ $declaratie->betaald_door_id }}</td>
            <td>{{ $declaratie->created_by_id }}</td>
        </tr>

    </tbody>
</table>

<ul>
    @foreach($leden_deelname as $lid)
    <li>{{$lid->roepnaam}} kosten: &euro; {{format_currency($lid->bedrag)}}</li>
    @endforeach
</ul>
@endsection
