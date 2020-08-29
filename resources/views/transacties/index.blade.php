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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="transacties" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Af/Bij</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Naam/Omschrijving</th>
                        <th scope="col">Bedrag</th>
                        <th scope="col">Lid</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transacties as $transactie)
                    <tr>
                        <td><span class="badge @if($transactie->af_bij == "Af")badge-danger @else badge-success @endif">{{ $transactie->af_bij }}</span></td>
                        <th>{{ Carbon\Carbon::parse($transactie->datum)->translatedFormat('d F Y') }}</th>
                        <td>{{ $transactie->naam }}</td>
                        <td>&euro;{{ format_currency($transactie->bedrag) }}</td>
                        <td>{{ $transactie->roepnaam . ' ' . $transactie->achternaam }}</td>
                        <td>
                            <button data-target="#transactie-id-{{$transactie->transactie_id}}" class="btn btn-link"
                                data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="transactie-id-{{$transactie->transactie_id}}">Meer</button>
                        </td>
                        <td>
                            {{-- <a class="btn btn-link" href="/transactie/{{$transactie->transactie_id}}"><span
                                data-feather="eye"></span> Bekijk</a> --}}
                            @if(Auth::user()->admin == 1)
                            <a class="btn btn-link" href="/transacties/{{$transactie->transactie_id}}/wijzig"><span
                                    data-feather="edit"></span> Wijzig</a>
                            @endif
                        </td>
                    </tr>
                    <tr class="collapse" id="transactie-id-{{$transactie->transactie_id}}">
                        <td></td>
                        <td colspan=6>
                            <strong>Spaarplan: </strong>{{ $transactie->spaarplanOptions()[$transactie->spaarplan]  }}<br>
                            <strong>Tegenrekening: </strong>{{ $transactie->tegenrekening }}<br>
                            <strong>Mutatie: </strong>{{ $transactie->mutatieOptions()[$transactie->mutatie_soort] }}<br>
                            <strong>Mededelingen: </strong>{{ $transactie->mededelingen }}
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $transacties->links(); !!}
        </div>
    </div>
</div>

@endsection
