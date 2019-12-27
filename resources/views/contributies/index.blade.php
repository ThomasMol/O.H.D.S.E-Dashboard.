@extends('layout')
@section('title','Contributies')
@section('content')
<div class="mb-4">
    <h3 class="d-inline">Contributies</h3>
    @if(Auth::user()->admin == 1)
        <a href="/contributies/toevoegen/{{$huidig_jaar->jaargang}}" class="btn btn-outline-primary float-right"><span data-feather="plus-circle"></span> Contributie toevoegen</a>
    @endif
</div>
    <table class="table table-hover table-sm table-responsive ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Bedrag</th>
            <th scope="col"></th>
            @if(Auth::user()->admin == 1)
                <th scope="col"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($contributies as $contributie)
            <tr>
                <th scope="row">{{ date('d F Y - l', strtotime($contributie->datum))  }}</th>
                <td>{{ $contributie->omschrijving }}</td>
                <td>&euro; {{ format_currency($contributie->bedrag) }}</td>
                <td><a class="btn btn-light" href="/contributie/{{$contributie->contributie_id}}">Bekijk</a>
                @if(Auth::user()->admin == 1)
                <a class="btn btn-light" href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}">Wijzig</a>
                    </td>
                    <td>
                    <form action="/contributies/{{$contributie->contributie_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
