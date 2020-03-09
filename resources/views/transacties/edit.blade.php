@extends('layout')
@section('title','Transactie')
@section('content')
<header>
    <h2>Transactie wijzigen</h2>
</header>


<form class="card" method="POST" action="/transacties/{{$transactie->transactie_id}}">
    @csrf
    @method('PATCH')
    <div class="form-row">
        <div class="col-md">
            <label for="datum">Datum</label>
            <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $transactie->datum }}"
                required>
        </div>
        <div class="col-md">
            <label for="af_bij">Af/Bij (op de dispuutsrekening)</label>
            <select class="form-control mb-3" id="af_bij" name="af_bij" required>
                <option selected disabled value="">Selecteer af/bij</option>
                @foreach($transactie->afbijOptions() as $key => $afbij)
                <option {{$transactie->af_bij == $key ? 'selected' : ''}} value="{{ $key }}">{{ $afbij }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md">
            <label for="mutatie_soort">Type</label>
            <select class="form-control mb-3" id="mutatie_soort" name="mutatie_soort" required>
                <option selected disabled value="">Selecteer type</option>
                @foreach($transactie->mutatieOptions() as $key => $mutatie)
                <option {{$transactie->mutatie_soort == $key ? 'selected' : ''}} value="{{ $key }}">{{ $mutatie }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md">
            <label for="budget">Bedrag</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">&euro;</div>
                </div>
                <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                    value="{{ $transactie->bedrag }}" min="0" max="99999999" placeholder="0.00" required>
            </div>
        </div>
    </div>

    <label for="naam">Naam/Omschrijving</label>
    <input type="text" class="form-control mb-3" id="naam" name="naam" value="{{ $transactie->naam }}" required>

    <div class="form-row">
        <div class="col-md">
            <label for="lid_id">Lid (bij geen tegenrekening)</label>
            <select class="form-control mb-3" id="lid_id" name="lid_id">
                <option selected value="">Geen lid</option>
                @foreach($leden as $lid)
                <option {{$transactie->lid_id == $lid->lid_id ? 'selected' : ''}} value="{{$lid->lid_id}}">
                    {{$lid->roepnaam}} {{$lid->achternaam}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md">
            <label for="spaarplan">Spaarplan (bij wel lid)</label>
            <select class="form-control mb-3" id="spaarplan" name="spaarplan">
                @foreach($transactie->spaarplanOptions() as $key => $spaarplan)
                <option {{$transactie->spaarplan === $key ? 'selected' : ''}} value="{{ $key }}">{{ $spaarplan }}
                </option>
                @endforeach
            </select>

        </div>
    </div>


    <label for="tegenrekening">Tegenrekening (bij geen lid)</label>
    <input type="text" class="form-control mb-3" id="tegenrekening" name="tegenrekening"
        value="{{ $transactie->tegenrekening }}">

    <label for="mededelingen">Mededelingen</label>
    <input type="text" class="form-control mb-3" id="mededelingen" name="mededelingen"
        value="{{ $transactie->mededelingen }}" required>



    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig transactie</button>
</form>


@endsection
