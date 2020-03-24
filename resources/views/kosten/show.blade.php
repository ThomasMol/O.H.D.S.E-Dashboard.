@extends('layout')
@section('title','Boetes')
@section('content')
<header>
    <h3 class="d-inline">Overige kosten</h3>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-right" data-href="/kosten/{{$kosten->kosten_id}}" data-toggle="modal"
        data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a href="/boetes/{{$kosten->kosten_id}}/wijzig/{{$bestuursjaar->jaargang}}"
        class="btn btn-outline-primary float-right"><span data-feather="edit"></span> Wijzig</a>
    @endif
</header>
<div class="table-responsive">
    <table class="table table-hover table-sm">
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
                <td>{{ Carbon\Carbon::parse($kosten->datum)->translatedFormat('d F Y - \(l\)') }}</td>
                <td>&euro; {{ format_currency($borrel->bedrag) }}</td>
                <td>{{ $borrel->reden }}</td>
                <td>{{ $lid->roepnaam }} {{ $lid->achternaam }}</td>
            </tr>
        </tbody>
    </table>
</div>
@include('confirm_dialog')
@endsection
