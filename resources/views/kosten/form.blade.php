@csrf
<label for="datum">Datum</label>
<input type="date" class="form-control mb-3" id="datum" name="datum"
    value="{{ old('datum') ?? $kosten->datum ?? date('Y-m-d') }}" required>

<label for="budget">Bedrag</label>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <div class="input-group-text">&euro;</div>
    </div>
    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
        value="{{ old('bedrag') ?? $kosten->bedrag ?? '10.00'}}" min="0" max="99999999" required>
</div>

{{-- <label for="omschrijving">Omschrijving</label>
        <input type="text" class="form-control mb-3" id="reden" name="omschrijving" value="{{ old('omschrijving')}}"
required> --}}

<label for="inkomsten_id">Soort</label>
<select class="form-control mb-3" id="inkomsten_id" name="inkomsten_id" required>
    <option disabled selected value> - selecteer - </option>
    @foreach($categorieen as $categorie)
        <option value="{{$categorie->inkomsten_id}}" @if($categorie->inkomsten_id == $kosten->inkomsten_id) selected @endif>{{ $categorie->soort }}</option>
    @endforeach
</select>

<label for="lid_id">Wie</label>
<select class="form-control mb-3" id="lid_id" name="lid_id" required>
    <option disabled selected value> - selecteer - </option>
    @foreach($leden as $lid)
        <option value="{{$lid->lid_id}}" @if($lid->lid_id == $kosten->lid_id) selected @endif>{{$lid->roepnaam}} {{$lid->achternaam}}</option>
    @endforeach
</select>

<button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Opslaan</button>
