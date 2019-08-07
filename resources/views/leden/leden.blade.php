@extends('layout')
@section('title','Leden')
@section('content')
    <h3>Leden</h3>
    @if(Auth::user()->admin == 1)
        <a class="btn btn-primary" href="/leden/toevoegen">Lid toevoegen</a>
    @endif
        <table class="table table-hover table-sm table-responsive">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Email</th>
                <th scope="col">Telefoonnummer</th>
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
                <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                <td>{{ $lid->email }}</td>
                <td>{{ $lid->telefoonnummer }}</td>
                <td>&euro;{{ $lid->schuld }}</td>
                <td>&euro;{{ $lid->gespaard }}</td>
                <td scope="col">
                    <a class="btn btn-light" href="/lid/{{$lid->lid_id}}">bekijk</a>
                @if(Auth::user()->admin == 1)
                    <a class="btn btn-light" href="/leden/{{$lid->lid_id}}/wijzig">Wijzig</a>
                </td>
                <td>
                    <form action="/leden/{{$lid->lid_id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                @endif
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    <div>
        {!! $leden->links(); !!}
    </div>
@endsection