@extends('layout')
@section('title','Transactie')
@section('content')
    <h2 class="mb-4">Transactie toevoegen</h2>

    <form class="card" method="POST" action="/transacties">
        @csrf
        <h3>Transactie</h3>
        <div class="form-row">
            <div class="col-md">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ old('datum') ?? date('Y-m-d') }}" required>
            </div>
            <div class="col-md">
                <label for="af_bij">Af/Bij (op de dispuutsrekening)</label>
                <select class="form-control mb-3" id="af_bij" name="af_bij" required>
                    <option selected disabled value="">Selecteer af/bij</option>
                    <option value="Af">Af</option>
                    <option value="Bij">Bij</option>
                </select>
            </div>
            <div class="col-md">
                <label for="code">Type</label>
                <select class="form-control mb-3" id="code" name="code" required>
                    <option selected disabled value="">Selecteer type</option>
                    <option value="AC">Acceptgiro (AC)</option>
                    <option value="BA">Betaalautomaat (BA)</option>
                    <option value="DV">Diversen (DV)</option>
                    <option value="FL">Filiaalboeking (FL)</option>
                    <option value="GF">Telefonisch bankieren (GF)</option>
                    <option value="GM">Geldautomaat (GM)</option>
                    <option value="GT">Online bankieren (GT)</option>
                    <option value="IC">Incasso (IC)</option>
                    <option value="OV">Overschrijving (OV)</option>
                    <option value="PK">Opname kantoor (PK)</option>
                    <option value="PO">Periodieke overschrijving (PO)</option>
                    <option value="ST">Storting (ST)</option>
                    <option value="VZ">Verzamelbetaling (VZ)</option>
                </select>
            </div>

            <div class="col-md">
                <label for="budget">Bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01" value="{{ old('bedrag')}}" min="0" max="99999999" placeholder="0.00" required>
                </div>
            </div>
        </div>

        <label for="naam">Naam/Omschrijving</label>
        <input type="text" class="form-control mb-3" id="naam" name="naam" value="{{ old('naam')}}" required>

        <label for="lid_id">Lid (optioneel)</label>
        <select class="form-control mb-3"id="lid_id" name="lid_id">
            <option selected value="">Geen lid</option>
            @foreach($leden as $lid)
                <option value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
            @endforeach
        </select>

        <label for="tegenrekening">Tegenrekening (optioneel)</label>
        <input type="text" class="form-control mb-3" id="tegenrekening" name="tegenrekening" value="{{ old('tegenrekening')}}" >

        <label for="mededelingen">Mededelingen</label>
        <input type="text" class="form-control mb-3" id="mededelingen" name="mededelingen" value="{{ old('mededelingen')}}" required>

        <label for="spaarplan">Spaarplan?</label>
        <input type="checkbox" class="mb-3" id="spaarplan" name="spaarplan" value="1">

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg transactie toe</button>
    </form>


@endsection