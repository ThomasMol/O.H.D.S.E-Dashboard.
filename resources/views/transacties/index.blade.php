@extends('layout')
@section('title','Transacties')
@section('content')
<header>
    <h1 class="d-lg-inline">Transacties</h1>
    @if(Auth::user()->admin == 1)
    <a class="btn btn-outline-secondary float-lg-right" href="/transacties/upload"><span
            data-feather="upload"></span>Upload transacties</a>
    <a class="btn btn-outline-primary float-lg-right mr-2" href="/transacties/toevoegen"><span
            data-feather="plus-circle"></span> Transactie toevoegen</a>
    @endif
</header>

<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Naam/Omschrijving</th>
                <th scope="col">Tegenrekening</th>
                <th scope="col">Af/Bij</th>
                <th scope="col">Bedrag</th>
                <th scope="col">Mutatie Soort</th>
                <th scope="col">Lid</th>
                <th scope="col">Spaarplan</th>
                <th scope="col">Mededelingen</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($transacties as $transactie)
            <tr>
                <th>{{ Carbon\Carbon::parse($transactie->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                <td>{{ $transactie->naam }}</td>
                <td>{{ $transactie->tegenrekening }}</td>
                <td>{{ $transactie->af_bij }}</td>
                <td>&euro; {{ format_currency($transactie->bedrag) }}</td>
                <td>{{ $transactie->mutatieOptions()[$transactie->mutatie_soort] }}</td>
                <td>{{ $transactie->roepnaam . ' ' . $transactie->achternaam }}</td>
                <td>{{ $transactie->spaarplanOptions()[$transactie->spaarplan] }}</td>
                <td>{{ $transactie->mededelingen }}</td>

                <td>
                    <a class="btn btn-link" href="/transactie/{{$transactie->transactie_id}}"><span
                            data-feather="eye"></span> Bekijk</a>
                    @if(Auth::user()->admin == 1)
                    <a class="btn btn-link" href="/transacties/{{$transactie->transactie_id}}/wijzig"><span
                            data-feather="edit"></span> Wijzig</a>
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
