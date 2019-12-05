@extends('layout')
@section('title','Uitgave')
@section('content')
    <h2 class="mb-4">Uitgave wijzigen</h2>

    <form class="card" method="POST" action="/uitgaven/{{$uitgave->uitgave_id}}">
        @csrf
        @method('PATCH')
        <h3>Activiteit</h3>
        <div class="form-row">
            <div class="col-md-3">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $uitgave->datum }}" required>
            </div>
            <div class="col-md-3">
                <label for="budget">Budget</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="budget" step=".01" value="{{ $uitgave->budget }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="uitgave">Uitgave</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control " id="uitgave" name="uitgave" step=".01" value="{{ $uitgave->uitgave }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="naheffing">(Totale) Naheffing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="naheffing" name="naheffing" step=".01" value="{{ $uitgave->naheffing }}" max="99999999" placeholder="0.00" required readonly>
                </div>
            </div>
        </div>
        <label for="categorie">Categorie:</label>
        <select class="form-control mb-3"id="categorie" name="uitgaven_id" required>
            @foreach($categorieen as $categorie)
                <option @if($categorie->uitgaven_id == $uitgave->categorie) checked @endif value="{{$categorie->uitgaven_id}}">{{$categorie->soort}}</option>
            @endforeach
        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" required>{{ $uitgave->omschrijving }}</textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm table-responsive ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
                <th scope="col">Naheffing</th>
                <th scope="col">Afgemeld</th>
                <th scope="col">Boete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leden_deelname as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][aanwezig]" value="1" @if(!empty($lid->aanwezig)) checked @endif></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][naheffing]" value="1" @if(isset($lid->naheffing)) checked @endif></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][afgemeld]" value="1" @if(!empty($lid->afgemeld)) checked @endif></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][boete]" value="1" @if(isset($lid->boete_id)) checked @endif></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig uitgave</button>
    </form>

@endsection
