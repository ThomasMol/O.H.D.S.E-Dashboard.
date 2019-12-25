@extends('layout')
@section('title','Overige kosten')
@section('content')
    <h2 class="mb-4">Overige kosten toevoegen</h2>

    <form class="card" method="POST" action="/kosten">
        @csrf
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ old('datum') ?? date('Y-m-d') }}" required>

        <div class="form-row">
                <label for="budget">Bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01" value="{{ old('bedrag') ?? '10.00'}}" min="0" max="99999999" required>
                </div>
        </div>

        <label for="omschrijving">Omschrijving</label>
        <input type="text" class="form-control mb-3" id="reden" name="omschrijving" value="{{ old('omschrijving')}}" required>

        <label for="soort">Soort</label>
        <select class="form-control mb-3" id="soort" name="soort" required>
            @foreach($kosten->kostenOptions() as $key => $soort)
                <option value="{{$key}}">{{ $soort }}</option>
            @endforeach
        </select>

        <label for="lid_id">Wie</label>
        <select class="form-control mb-3"id="lid_id" name="lid_id" required>
            @foreach($leden as $lid)
                <option value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg boete toe</button>
    </form>


@endsection
