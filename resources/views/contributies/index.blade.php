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
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Aangeslagen</th>
                        <th scope="col">Bedrag</th>
                        <th scope="col">Soort</th>
                        <th scope="col"></th>
                        @if(Auth::user()->admin == 1)
                        <th scope="col"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($contributies); $i++)
                    <tr>
                        <th scope="row">
                            {{ Carbon\Carbon::parse($contributies[$i]->datum)->translatedFormat('d F Y - \(l\)') }}</th>
                
                        <td>&euro; {{ $deelname[$i]->naheffing }}</td>
                        <td>&euro; {{ format_currency($contributies[$i]->bedrag) }}</td>
                        <td>{{ $contributies[$i]->soort }}</td>
                        <td><a class="btn btn-link" href="/contributie/{{$contributies[$i]->contributie_id}}"><span
                                    data-feather="eye"></span> Bekijk</a>
                            @if(Auth::user()->admin == 1)
                            <a class="btn btn-link"
                                href="/contributies/{{$contributies[$i]->contributie_id}}/wijzig/{{$contributies[$i]->jaargang}}"><span
                                    data-feather="edit"></span> Wijzig</a>
                            @endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! $contributies->links(); !!}
        </div>
    </div>
</div>
@endsection
