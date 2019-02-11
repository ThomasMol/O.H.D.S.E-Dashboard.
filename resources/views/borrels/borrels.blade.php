@extends('layout')
@section('title','Borrels')
@section('content')
    <h3>Borrels</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/borrels/toevoegen">Borrel toevoegen</a>
    @endif
    <table class="table table-hover table-sm ">
        <thead>
        <tr>
            <th scope="col">Datum</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Budget</th>
            <th scope="col">Naheffing</th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        @foreach($borrels as $borrel)
            <tr>
                <td>{{ $borrel->datum }}</td>
                <td>{{ $borrel->omschrijving }}</td>
                <td>&euro;{{ $borrel->budget }}</td>
                <td>&euro;{{ $borrel->naheffing }}</td>
                <td><a class="btn btn-success" href="/borrel/{{$borrel->borrel_id}}">Bekijk</a>
                    @if(Auth::user()->admin == 1)
                        <a class="btn btn-primary" href="/borrels/wijzig/{{$borrel->borrel_id}}">Wijzig</a>
                    @endif
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="text-center">
        {!! $borrels->links(); !!}
    </div>
@endsection