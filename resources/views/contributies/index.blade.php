@extends('layout')
@section('title','Contributies')
@section('content')
<header>
    <h1 class="d-lg-inline">Contributies</h1>
    @if(Auth::user()->admin == 1)
    <a href="/contributies/toevoegen/{{$huidig_jaar->jaargang}}" class="btn btn-outline-primary float-lg-right"><span
            data-feather="plus-circle"></span> Contributie toevoegen</a>
    @endif
</header>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Bedrag</th>
                <th scope="col">Soort</th>
                <th scope="col"></th>
                @if(Auth::user()->admin == 1)
                <th scope="col"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($contributies as $contributie)
            <tr>
                <th scope="row">{{ Carbon\Carbon::parse($contributie->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                <td>&euro; {{ format_currency($contributie->bedrag) }}</td>
                <td>{{ $contributie->soort }}</td>
                <td><a class="btn btn-link" href="/contributie/{{$contributie->contributie_id}}"><span
                            data-feather="eye"></span> Bekijk</a>
                    @if(Auth::user()->admin == 1)
                    <a class="btn btn-link"
                        href="/contributies/{{$contributie->contributie_id}}/wijzig/{{$contributie->jaargang}}"><span
                            data-feather="edit"></span> Wijzig</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



@endsection
