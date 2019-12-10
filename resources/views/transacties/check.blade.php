@extends('layout')
@section('title','Transactie')
@section('content')
    <h2 class="mb-4">Transacties check</h2>

    <form class="card" method="POST" action="/transacties/process">
        @csrf
        <h3>Transacties</h3>
        @foreach($transacties as $transactie)

        <div class="form-row">
            <div class="col-md">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $transactie[0] ?? date('Y-m-d') }}" required>
            </div>
            <div class="col-md">
                <label for="af_bij">Af/Bij </label>
                <select class="form-control mb-3" id="af_bij" name="af_bij" required>
                    @foreach($transactie_model->afbijOptions() as $key => $afbij)
                        <option value="{{ $key }}" {{ $transactie[5] == $key ? 'selected' : '' }}>{{ $afbij }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <label for="mutatie_soort">Type</label>
                <select class="form-control mb-3" id="mutatie_soort" name="mutatie_soort" required>
                    @foreach($transactie_model->mutatieOptions() as $key => $mutatie)
                        <option value="{{ $key }}" {{ $transactie[4] == $key ? 'selected' : '' }}>{{ $mutatie }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md">
                <label for="budget">Bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01" value="{{ $transactie[6] }}" min="0" max="99999999" placeholder="0.00" required>
                </div>
            </div>
            <div class="col-md">
                <label for="naam">Naam/Omschrijving</label>
                <input type="text" class="form-control mb-3" id="naam" name="naam" value="{{ $transactie[1] }}" required>
            </div>
            <div class="col-md">
                <label for="lid_id">Lid </label>
                <select class="form-control mb-3"id="lid_id" name="lid_id">
                    <option selected value="">Geen lid</option>
                    @foreach($leden as $lid)
                        <option value="{{$lid->lid_id}}" {{$transactie[9] == $lid->lid_id ? 'selected' : '' }}>{{$lid->roepnaam}} {{$lid->achternaam}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <label for="spaarplan">Spaarplan (bij wel lid)</label>
                <select class="form-control mb-3"id="spaarplan" name="spaarplan">
                    @foreach($transactie_model->spaarplanOptions() as $key => $spaarplan)
                        <option value="{{ $key }}" {{ $transactie[11] == $key ? 'selected' : '' }}>{{ $spaarplan }}</option>
                    @endforeach
                </select>

            </div>

        </div>

        <div class="form-row">
            <div class="col-md-3">
                <label for="tegenrekening">Tegenrekening (bij geen lid)</label>
                <input type="text" class="form-control mb-3" id="tegenrekening" name="tegenrekening" value="{{ $transactie[3] }}" >
            </div>

            <div class="col-md-9">
                <label for="mededelingen">Mededelingen</label>
                <textarea type="text" class="form-control mb-3" id="mededelingen" name="mededelingen" required>{{ $transactie[8] }}</textarea>
            </div>

        </div>
        <hr>
        @endforeach



        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg transactie toe</button>
    </form>


@endsection
