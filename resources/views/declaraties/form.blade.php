<div class="form-row">
    <div class="col-md-4">
        <div class="card card-sticky">
            <div class="card-body">
                <input type="hidden" name="created_by_id" value="{{Auth::user()->lid_id}}">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum"
                    value="{{ old('datum') ?? $declaratie->datum ?? date('Y-m-d') }}" required>
                <label for="bedrag">Totaal bedrag</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                        value="{{ old('bedrag') ?? $declaratie->bedrag }}" min="0" max="99999999" placeholder="0.00" required>
                </div>
                <label for="betaald_door">Betaald door:</label>
                <select class="form-control mb-3" id="betaald_door" name="betaald_door_id">
                    @if(isset($declaratie->betaald_door_id))
                        @foreach($leden as $lid)
                            <option @if($lid->lid_id == $declaratie->betaald_door_id) selected @endif value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
                        @endforeach
                    @else
                        @foreach($leden as $lid)
                        <option @if($lid->lid_id == Auth::user()->lid_id) selected @endif value="{{$lid->lid_id}}">{{$lid->roepnaam}} {{$lid->achternaam}}</option>
                        @endforeach
                    @endif

                </select>
                <label for="omschrijving">Omschrijving</label>
                <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving"
                    required>{{ old('omschrijving') ?? $declaratie->omschrijving }}</textarea>

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
                            <input data-lid-type="reunisten" type="checkbox" name="deelnemers[]"
                                value="{{$lid->lid_id}}" @if(isset($lid->deelname))
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
