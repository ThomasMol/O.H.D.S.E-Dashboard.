@extends('layout')
@section('title','Leden')
@section('content')

<header>
    <h1 class="d-lg-inline">Leden</h1>

    @if(Auth::user()->admin == 1)
    <a href="/leden/toevoegen" class="btn btn-outline-primary float-lg-right ml-2"><span data-feather="plus-circle"></span> Lid
        toevoegen</a>
    @endif
    <a href="/leden/leden_bestand" class="btn btn-outline-secondary float-lg-right"><span data-feather="download"></span> Download ledenbestand</a>
</header>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Type lid</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Schuld</th>
                        <th scope="col">Gespaard</th>
                        <th scope="col"></th>
                        @if(Auth::user()->admin == 1)
                        <th scope="col"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($leden as $lid)
                    <tr>
                        <td>{{ $lid->type_lid }}</td>
                        <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                        <td>&euro; {{ format_currency($lid->schuld) }}</td>
                        <td>&euro; {{ format_currency($lid->gespaard) }}</td>
                        <td scope="col">
                            <a class="btn btn-link" href="/lid/{{$lid->lid_id}}"><span data-feather="eye"></span>
                                Bekijk</a>
                            @if(Auth::user()->admin == 1)
                            <a class="btn btn-link" href="/leden/{{$lid->lid_id}}/wijzig"><span
                                    data-feather="edit"></span>
                                Wijzig</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div>
            {!! $leden->links(); !!}
        </div>
    </div>
</div>
@endsection
