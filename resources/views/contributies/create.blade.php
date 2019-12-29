@extends('layout')
@section('title','Contributie')
@section('content')
<header>
    <h3 class="d-inline">Contributie toevoegen</h3>
    <div class="dropdown float-right">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownJaar" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Begroting van jaargang {{$bestuursjaar->jaargang}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownJaar">

            @foreach($bestuursjaren as $bestuursjaar_value)
            <a class="dropdown-item @if($bestuursjaar_value->jaargang == $bestuursjaar->jaargang ) active @endif" href="/contributies/toevoegen/{{$bestuursjaar_value->jaargang}}">Jaar
                {{$bestuursjaar_value->jaargang}}
                @if($bestuursjaar_value->jaargang == $huidig_jaar->jaargang) (Huidig jaar)@endif</a>
            @endforeach
        </div>
    </div>
</header>

<form class="card" method="POST" action="/contributies">
    @csrf
    <div class="form-row">
        <div class="col-md-4">
            <label for="datum">Datum</label>
            <input type="date" class="form-control mb-3" id="datum" name="datum"
                value="{{ old('datum') ?? date('Y-m-d') }}" required>
        </div>
        <div class="col-md-4">
            <label for="bedrag">Bedrag</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">&euro;</div>
                </div>
                <input type="number" class="form-control" id="bedrag" name="bedrag" step=".01"
                    value="{{ old('budget') }}" min="0" max="99999999" placeholder="Vul bedrag in" required>
            </div>
        </div>
        <div class="col-md-4">
            <label for="inkomsten_id">Contributie soort</label>
            <select class="form-control mb-3" id="inkomsten_id" name="inkomsten_id" required>
                @foreach($categorieen as $categorie)
                <option value="{{$categorie->inkomsten_id}}">{{$categorie->soort}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <h3>Aanwezigheid</h3>
    <table class="table table-hover table-sm table-responsive">
        <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leden as $lid)

            @if($loop->index >= 1)
            @if($leden[$loop->index - 1]->type_lid != $lid->type_lid)
            <tr class="thead-light">
                <th scope="row">{{ $lid->type_lid }}</th>
            </tr>
            @endif
            @endif

            <tr>
                <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"></td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Voeg contributie toe</button>
</form>
@endsection
