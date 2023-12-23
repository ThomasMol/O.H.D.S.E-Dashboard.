@extends('layout')
@section('title','Uitgaven')
@section('content')
<header>
    <h1 class="d-lg-inline">Uitgaven</h1>
    @if(Auth::user()->admin == 1)
    <a class="btn btn-outline-primary float-lg-right" href="/uitgaven/toevoegen/{{$huidig_jaar->jaargang}}"><span
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
                <th scope="col">Aangeslagen</th>
                <th scope="col">Budget</th>
                <th scope="col">Uitgave</th>
                <th scope="col"></th>
                @if(Auth::user()->admin == 1)
                <th scope="col"></th>
                @endif

            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($uitgaven); $i++)
            <tr>
                <th>{{ Carbon\Carbon::parse($uitgaven[$i]->datum)->translatedFormat('d F Y')}}</th>
                <td>{{ $uitgaven[$i]->soort }}</td>
                <td>{{ $uitgaven[$i]->omschrijving }}</td>
                <td>&euro;{{ $leden_deelname[$i]->naheffing }}</td>
                <td>&euro;{{ format_currency($uitgaven[$i]->budget) }}</td>
                <td>&euro;{{ format_currency($uitgaven[$i]->uitgave) }}</td>
                <td><a class="btn btn-link" href="/uitgave/{{$uitgaven[$i]->uitgave_id}}"><span data-feather="eye"></span>
                        Bekijk</a>
                    @if(Auth::user()->admin == 1)
                    <td>
                    <a class="btn btn-link"
                        href="/uitgaven/{{$uitgaven[$i]->uitgave_id}}/wijzig/{{$uitgaven[$i]->jaargang}}"><span
                            data-feather="edit"></span> Wijzig</a>
                </td>

                @endif
                </td>

            </tr>
            @endfor

        </tbody>
    </table>
</div>
<div class="text-center">
    {!! $uitgaven->links(); !!}
</div>
@endsection
