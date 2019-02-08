@extends('layout')
@section('title','Leden')
@section('content')
    <h3>Leden</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/leden/toevoegen">Lid toevoegen</a>
    @endif
        <table class="table table-hover table-sm ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnummer</th>
                <th scope="col">Schuld</th>
                <th scope="col">Gespaard</th>
                @if(Auth::user()->admin == 1)
                    <th scope="col">Wijzig</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($leden as $lid)
            <tr>
                <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                <td>{{ $lid->email }}</td>
                <td>{{ $lid->telefoonnummer }}</td>
                <td>&euro;{{ $lid->schuld }}</td>
                <td>&euro;{{ $lid->gespaard }}</td>
                @if(Auth::user()->admin == 1)
                    <td scope="col"><a class="btn btn-primary" href="/leden/wijzig/{{$lid->lid_id}}">Wijzig</a></td>
                @endif
            </tr>
            @endforeach

            </tbody>
        </table>
@endsection