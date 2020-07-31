<div class="form-row">
    <div class="col-md-4">
        <div class="card card-sticky">
            <div class="card-body">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum"
                    value="{{ old('datum') ?? $contributie->datum ?? date('Y-m-d') }}" required>

                <label for="bedrag">Bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                        value="{{ old('budget') ?? $contributie->bedrag}}" min="0" max="99999999"
                        placeholder="Vul bedrag in" required>
                </div>
                <label for="inkomsten_id">Contributie soort</label>
                <select class="form-control mb-3" id="inkomsten_id" name="inkomsten_id" required>
                    @foreach($categorieen as $categorie)
                    <option @if($categorie->inkomsten_id == $contributie->inkomsten_id || $categorie->inkomsten_id ==
                        old('inkomsten_id')) selected @endif value="{{$categorie->inkomsten_id}}">{{$categorie->soort}}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Opslaan</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
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
                        data-toggle="collapse" href="#collapse-geen" role="button" aria-expanded="false"
                        aria-controls="collapse-geen">
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
        </div>
    </div>
</div>
