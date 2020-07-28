@extends('layout')
@section('title','Uitgaven')
@section('content')
<header>
    <h1 class="d-inline">Uitgaven</h1>
    @if(Auth::user()->admin == 1)
    <a class="btn btn-outline-primary float-right" href="/uitgaven/toevoegen/{{$huidig_jaar->jaargang}}"><span
            data-feather="plus-circle"></span> Uitgave toevoegen</a>
    @endif
</header>
<div class="table-responsive card">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Categorie</th>
                <th scope="col">Omschrijving</th>
                <th scope="col">Budget</th>
                <th scope="col">Uitgave</th>
                <th scope="col">(Totale) Naheffing</th>
                <th scope="col"></th>
                @if(Auth::user()->admin == 1)
                <th scope="col"></th>
                @endif

            </tr>
        </thead>
        <tbody>
            @foreach($uitgaven as $uitgave)
            <tr>
                <th>{{ Carbon\Carbon::parse($uitgave->datum)->translatedFormat('d F Y - \(l\)')}}</th>
                <td>{{ $uitgave->soort }}</td>
                <td>{{ $uitgave->omschrijving }}</td>
                <td>&euro; {{ format_currency($uitgave->budget) }}</td>
                <td>&euro; {{ format_currency($uitgave->uitgave) }}</td>
                <td>&euro; {{ format_currency($uitgave->naheffing) }}</td>
                <td><a class="btn btn-link" href="/uitgave/{{$uitgave->uitgave_id}}"><span data-feather="eye"></span>
                        Bekijk</a>
                    @if(Auth::user()->admin == 1)
                    <a class="btn btn-link"
                        href="/uitgaven/{{$uitgave->uitgave_id}}/wijzig/{{$uitgave->jaargang}}"><span
                            data-feather="edit"></span> Wijzig</a>
                </td>

                @endif
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<div class="text-center">
    {!! $uitgaven->links(); !!}
</div>
@endsection
