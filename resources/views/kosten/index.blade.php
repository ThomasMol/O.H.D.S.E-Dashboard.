@extends('layout')
@section('title','Overige kosten')
@section('content')
<header>
    <h3 class="d-inline">Overige kosten</h3>
    @if(Auth::user()->admin == 1)
    <a href="/kosten/toevoegen/{{$huidig_jaar->jaargang}}" class="btn btn-outline-primary float-right"><span
            data-feather="plus-circle"></span>
        Kosten
        toevoegen</a>
    @endif
</header>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Bedrag</th>
                <th scope="col">Soort</th>
                <th scope="col">Wie</th>
                @if(Auth::user()->admin == 1 )
                <th scope="col"></th>
                <th scope="col"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($kosten as $koste)
            <tr>
                <td>{{ $koste['datum'] }}</td>
                <td>&euro; {{ format_currency($koste->bedrag) }}</td>
                <td>{{ $koste->soort }}</td>
                <td>{{ $koste->roepnaam }} {{ $koste->achternaam }}</td>

                @if(Auth::user()->admin == 1 )
                @if(isset($koste->uitgave_id_boete) )
                <td>
                    <a class="btn btn-link"
                        href="/uitgaven/{{$koste->uitgave_id_boete}}/wijzig/{{$koste->jaargang}}"><span
                            data-feather="edit"></span>
                        Wijzig boete in uitgave</a>
                </td>
                <td></td>
                @elseif( isset($koste->uitgave_id_extra))
                <td>
                    <a class="btn btn-link"
                        href="/uitgaven/{{$koste->uitgave_id_extra}}/wijzig/{{$koste->jaargang}}"><span
                            data-feather="edit"></span>
                        Wijzig extra kosten in uitgave</a>
                </td>
                <td></td>
                @else
                <td>
                    <a class="btn btn-link" href="/kosten/{{$koste->kosten_id}}/wijzig/{{$koste->jaargang}}"><span
                            data-feather="edit"></span>
                        Wijzig</a>
                </td>
                <td>
                    <button class="btn btn-link float-right" data-href="/kosten/{{$koste->kosten_id}}"
                        data-toggle="modal" data-target="#confirm-delete"><span data-feather="trash"></span>
                        Verwijder</button>
                </td>
                @endif
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('confirm_dialog')

@endsection
