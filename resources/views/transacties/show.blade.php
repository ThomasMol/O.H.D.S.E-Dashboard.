@extends('layout')
@section('title','Transacties')
@section('content')
    <h2>Transactie</h2>
    <table class="table table-responsive table-sm table-hover">
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
                   <tr>
                <th>{{ date('d F Y - l', strtotime($transactie->datum)) }}</th>
                <td>{{ $transactie->naam }}</td>
                <td>{{ $transactie->tegenrekening }}</td>
                <td>{{ $transactie->af_bij }}</td>
                <td>&euro; {{ format_currency($transactie->bedrag) }}</td>
                <td>{{ $transactie->mutatieOptions()[$transactie->mutatie_soort] }}</td>
                <td>{{ isset($lid) ? $lid->roepnaam . $lid->achternaam : 'Geen lid'}}</td>
                <td>{{ $transactie->spaarplanOptions()[$transactie->spaarplan] }}</td>
                <td>{{ $transactie->mededelingen }}</td>

                <td>
                    <a class="btn btn-light" href="/transactie/{{$transactie->transactie_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-light" href="/transacties/{{$transactie->transactie_id}}/wijzig">Wijzig</a>

                </td>
                <td>
                    <form action="/transacties/{{$transactie->transactie_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                    @endif
                </td>
            </tr>

        </tbody>
    </table>
@endsection
