@extends('layout')
@section('title','Boetes')
@section('content')
<div class="mb-4">
    <h3 class="d-inline">Overige kosten</h3>
    @if(Auth::user()->admin == 1)
    <a href="/boetes/{{$kosten->kosten_id}}/wijzig" class="btn btn-outline-primary float-right"><span
            data-feather="edit"></span> Wijzig</a>
    @endif
</div>
<table class="table table-hover table-sm table-responsive ">
    <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Bedrag</th>
            <th scope="col">Reden</th>
            <th scope="col">Wie</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $borrel->datum }}</td>
            <td>&euro; {{ format_currency($borrel->bedrag) }}</td>
            <td>{{ $borrel->reden }}</td>
            <td>{{ $lid->roepnaam }} {{ $lid->achternaam }}</td>
        </tr>
    </tbody>
</table>

@endsection
