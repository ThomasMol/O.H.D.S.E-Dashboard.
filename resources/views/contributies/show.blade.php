@extends('layout')
@section('title','Contributie')
@section('content')
<header>
    <h3 class="d-inline">Contributie</h3>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-right" data-href="/contributies/{{$contributie->contributie_id}}"
        data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}"
        class="btn btn-outline-primary float-right mr-2"><span data-feather="edit"></span> Wijzig</a>
    @endif
</header>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Omschrijving</th>
                <th scope="col">Bedrag</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ Carbon\Carbon::parse($contributie->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                <td>{{ $contributie->soort }}</td>
                <td>{{ format_currency($contributie->bedrag) }}</td>
            </tr>
        </tbody>
    </table>
</div>
<ul>
    @foreach($leden_deelname as $lid)
    <li>{{$lid->roepnaam}} </li>
    @endforeach
</ul>

@include('confirm_dialog')
@endsection
