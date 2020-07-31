<div class="form-row">
    <div class="col-md-4">
        <div class="card card-sticky">
            <div class="card-body">

                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum"
                    value="{{ old('datum') ?? date('Y-m-d') }}" required>

                <label for="budget">Budget</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="budget" step=".01"
                        value="{{ old('budget') }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>

                <label for="uitgave">Uitgave</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control " id="uitgave" name="uitgave" step=".01"
                        value="{{ old('uitgave') }}" min="-99999999" max="99999999" placeholder="Vul bedrag in"
                        required>
                </div>

                <label for="naheffing">(Totale) Naheffing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="naheffing" name="naheffing" step=".01"
                        value="{{ old('naheffing')}}" max="99999999" placeholder="0.00" required readonly>
                </div>
                <label for="categorie">Categorie:</label>
                <select class="form-control mb-3" id="categorie" name="uitgaven_id" required>
                    @foreach($categorieen as $categorie)
                    <option value="{{$categorie->uitgaven_id}}">{{$categorie->soort}}</option>
                    @endforeach
                </select>


                <label for="omschrijving">Omschrijving</label>
                <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving"
                    required>{{ old('omschrijving')}}</textarea>
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Opslaan</button>
            </div>


        </div>
    </div>
    <div class="col-md-8">
        {{-- <div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        data-toggle="collapse" href="#collapse-actief" role="button" aria-expanded="false"
                        aria-controls="collapse-actief">
                        <h4>Actieve leden</h4>
                        <span data-feather="chevron-down"></span>
                    </a>
                    <div class="collapse show" id="collapse-actief">
                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                            <strong>Selecteer alles</strong>
                            <input type="checkbox" class="select-all" data-select-lid-type="actief">
                        </li>
                        @foreach($actieve_leden as $lid)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $lid->roepnaam }} {{ $lid->achternaam }}
        <input data-lid-type="actief" type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"
            @if(isset($lid->deelname))
        checked @endif>
        </li>
        @endforeach
    </div>


    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
        data-toggle="collapse" href="#collapse-passief" role="button" aria-expanded="false"
        aria-controls="collapse-passief">
        <h4>Passieve leden</h4>
        <span data-feather="chevron-down"></span>
    </a>
    <div class="collapse show" id="collapse-passief">
        <li class="list-group-item d-flex justify-content-between align-items-center ">
            <strong>Selecteer alles</strong>
            <input type="checkbox" class="select-all" data-select-lid-type="passief">
        </li>
        @foreach($passieve_leden as $lid)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $lid->roepnaam }} {{ $lid->achternaam }}
            <input data-lid-type="passief" type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"
                @if(isset($lid->deelname))
            checked @endif>
        </li>
        @endforeach
    </div>


    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
        data-toggle="collapse" href="#collapse-reunisten" role="button" aria-expanded="false"
        aria-controls="collapse-reunisten">
        <h4>Re&uuml;nisten</h4>
        <span data-feather="chevron-down"></span>
    </a>
    <div class="collapse" id="collapse-reunisten">
        <li class="list-group-item d-flex justify-content-between align-items-center ">
            <strong>Selecteer alles</strong>
            <input type="checkbox" class="select-all" data-select-lid-type="reunisten">
        </li>
        @foreach($reunisten as $lid)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $lid->roepnaam }} {{ $lid->achternaam }}
            <input data-lid-type="reunisten" type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"
                @if(isset($lid->deelname))
            checked @endif>
        </li>
        @endforeach
    </div>

    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
        data-toggle="collapse" href="#collapse-geen" role="button" aria-expanded="false" aria-controls="collapse-geen">
        <h4>Geen lid</h4>
        <span data-feather="chevron-down"></span>
    </a>
    <div class="collapse" id="collapse-geen">
        <li class="list-group-item d-flex justify-content-between align-items-center ">
            <strong>Selecteer alles</strong>
            <input type="checkbox" class="select-all" data-select-lid-type="geen">
        </li>
        @foreach($geen_lid as $lid)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $lid->roepnaam }} {{ $lid->achternaam }}
            <input data-lid-type="geen" type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"
                @if(isset($lid->deelname))
            checked @endif>
        </li>
        @endforeach
    </div>
    </ul>
</div>
</div> --}}
<div class="card table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            {{--  <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
                <th scope="col">Naheffing</th>
                <th scope="col">Afgemeld</th>
                <th scope="col">Boete</th>
            </tr> --}}
        </thead>
        <tbody>
            @foreach($leden as $lid)
            <tr>
                <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                <td>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-secondary">
                            <input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][aanwezig]"
                                value="1"> Aanwezig
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][naheffing]"
                                value="1"> Naheffing
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][afgemeld]"
                                value="1"> Afgemeld
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][boete]"
                                value="{{$inkomsten_boete_id}}">
                            Boete
                        </label>
                        <label class="btn btn-outline-secondary">
                            <input class="form-control" type="checkbox"
                                name="aanwezigheid[{{$lid->lid_id}}][extra_kosten]"
                                value="{{$inkomsten_extra_kosten_id}}"> Extra kosten
                        </label>
                    </div>
                </td>
                {{--   <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][aanwezig]"
                value="1"></td>
                <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][naheffing]"
                        value="1"></td>
                <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][afgemeld]"
                        value="1"></td>
                <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][boete]" value="1">
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>
