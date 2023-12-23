@extends('layout')
@section('title','Leden')
@section('content')

<header>
    <h1 class="d-lg-inline">Leden</h1>

    @if(Auth::user()->admin == 1)
    <a href="/leden/toevoegen" class="btn btn-outline-primary float-lg-right ml-2"><span data-feather="plus-circle"></span> Lid
        toevoegen</a>
    @endif
    @if(request()->is('leden'))
    <a href="/leden/top5" class="btn btn-outline-primary float-lg-right ml-2"><span data-feather="bar-chart"></span>
    <span>Top 5</span>
    </a>
    @else
    <a href="/leden/" class="btn btn-outline-primary float-lg-right ml-2"><span data-feather="bar-chart-2"></span>
    <span>ABC</span>
    </a>
    @endif
    @if(Auth::user()->admin == 1)
    <a href="/leden/leden_bestand" class="btn btn-outline-secondary float-lg-right ml-2"><span data-feather="download"></span> Download ledenbestand</a>
    @endif
    <a href="/leden/leden_schulden" class="btn btn-outline-secondary float-lg-right"><span data-feather="download"></span> Download schulden</a>
</header>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">Type lid</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Schuld
                        @if(request()->is('leden/top5'))
                        <span data-feather="arrow-down"></span>
                        @endif
                        </th>
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
                        @if(Auth::user()->admin == 1)
                        <td scope="col">
                            <a class="btn btn-link" href="/lid/{{$lid->lid_id}}"><span data-feather="eye"></span>
                                Bekijk</a>
                            @if(Auth::user()->admin == 1)
                            <a class="btn btn-link" href="/leden/{{$lid->lid_id}}/wijzig"><span
                                    data-feather="edit"></span>
                                Wijzig</a>
                            @endif
                        </td>
                        @endif
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
