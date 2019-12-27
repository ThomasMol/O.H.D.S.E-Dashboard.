@extends('layout')
@section('title','Contributie')
@section('content')
<div class="mb-4">
    <h3 class="d-inline">Contributie</h3>
    @if(Auth::user()->admin == 1)
    <a href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}" class="btn btn-link float-right"><span data-feather="edit"></span> Wijzig</a>
    @endif
</div>

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
            <li>{{$lid->roepnaam}} deelname </li>
        @endforeach
    </ul>
@endsection
