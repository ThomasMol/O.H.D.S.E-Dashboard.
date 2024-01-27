@extends('layout')
@section('title','Declaraties')
@section('content')

<header>
    <h1 class="d-lg-inline">Declaraties</h1>
    <a href="/declaraties/toevoegen" class="btn btn-outline-primary float-lg-right"><span
            data-feather="plus-circle"></span>
        Declaratie toevoegen</a>
</header>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span data-feather="alert-circle"></span> Deze pagina is louter bedoeld voor 'wie betaalt wat'-achtige declaraties. Denk aan pr&eacute;-borrel herendiners en dergelijken. Heb je iets betaald voor SE waar budget voor was? Stuur dan een tikkie naar de fiscus.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Aangeslagen</th>
                        <th scope="col">Bedrag</th>
                        <th scope="col">Omschrijving</th>
                        <th scope="col">Betaald door</th>
                        <th scope="col"></th>
                        <th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($declaraties as $declaratie)
                    <tr>
                        <th>{{ Carbon\Carbon::parse($declaratie->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                        <td>&euro; {{ format_currency($declaratie->aangeslagen) }}</td>
                        <td>&euro; {{ format_currency($declaratie->bedrag) }}</td>
                        <td>{{ $declaratie->omschrijving }}</td>
                        <td>{{ $declaratie->roepnaam }} {{ $declaratie->achternaam }}</td>
                        <td>
                            <a class="btn btn-link" href="/declaratie/{{$declaratie->declaratie_id}}"><span
                                    data-feather="eye"></span> Bekijk</a>
                            @if(Auth::user()->admin == 1)
                            <a class="btn btn-link" href="/declaraties/{{$declaratie->declaratie_id}}/wijzig"><span
                                    data-feather="edit"></span> Wijzig</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $declaraties->links(); !!}
        </div>
    </div>
</div>

@endsection
