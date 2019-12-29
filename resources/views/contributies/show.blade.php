@extends('layout')
@section('title','Contributie')
@section('content')
<header>
    <h3 class="d-inline">Contributie</h3>
    @if(Auth::user()->admin == 1)
    <button class="btn btn-outline-danger float-right" data-href="/contributies/{{$contributie->contributie_id}}" data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span> Verwijder</button>

    <a href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}" class="btn btn-outline-primary float-right mr-2"><span data-feather="edit"></span> Wijzig</a>
    @endif
</header>

    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $contributie->datum }}</th>
                <td>{{ $contributie->contributie_soort }}</td>
                <td>{{ format_currency($contributie->bedrag) }}</td>
            </tr>
        </tbody>
    </table>

    <ul>
        @foreach($leden_deelname as $lid)
            <li>{{$lid->roepnaam}}  </li>
        @endforeach
    </ul>

    @include('confirm_dialog')
@endsection
