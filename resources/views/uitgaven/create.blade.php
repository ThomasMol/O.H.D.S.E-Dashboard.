@extends('layout')
@section('title','Uitgave')
@section('content')
    <h2 class="mb-4">Uitgave toevoegen</h2>
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownJaar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Begroting van jaargang:
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownJaar">

            @foreach($bestuursjaren as $bestuursjaar)
                <a class="dropdown-item" href="/uitgaven/toevoegen/{{$bestuursjaar->jaargang}}">Jaar {{$bestuursjaar->jaargang}} @if($bestuursjaar->jaargang == $huidig_jaar->jaargang) <i>Huidig jaar</i>@endif</a>
            @endforeach
        </div>
    </div>
    <form class="card" method="POST" action="/uitgaven">
        @csrf
        <h3>Uitgave</h3>
        <div class="form-row">
            <div class="col-md-3">
                <label for="datum">Datum</label>
                <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ old('datum') ?? date('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label for="budget">Budget</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="budget" step=".01" value="{{ old('budget') }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="uitgave">Uitgave</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control " id="uitgave" name="uitgave" step=".01" value="{{ old('uitgave') }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
                </div>
            </div>
            <div class="col-md-3">
                <label for="naheffing">(Totale) Naheffing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="naheffing" name="naheffing" step=".01" value="{{ old('naheffing')}}" max="99999999" placeholder="0.00" required readonly>
                </div>
            </div>
        </div>

        <label for="categorie">Categorie:</label>
                <select class="form-control mb-3"id="categorie" name="uitgaven_id" required>
                    @foreach($categorieen as $categorie)
                        <option value="{{$categorie->uitgaven_id}}">{{$categorie->soort}}</option>
                    @endforeach
                  </select>


        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" required>{{ old('omschrijving')}}</textarea>

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
            @foreach($leden as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    {{-- <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"></td> --}}
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][aanwezig]" value="1"></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][naheffing]" value="1"></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][afgemeld]" value="1"></td>
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][boete]" value="1"></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg uitgave toe</button>
    </form>
@endsection
