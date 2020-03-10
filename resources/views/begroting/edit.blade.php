@extends('layout')
@section('title','Begroting')
@section('content')
<header>
    <h3>Begroting van het {{$bestuursjaar->jaargang}}e bestuursjaar wijzigen</h3>
</header>
<form method="POST" action="/begroting/{{$bestuursjaar->jaargang}}">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-md-6">
            <h4>Inkomsten</h4>
            <table class="table table-hover table-sm  ">
                <thead>
                    <tr>
                        <th scope="col">Soort</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Realisatie</th>
                        <th scope="col">Verschil</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($inkomsten_list as $inkomsten)
                    <tr>
                        <input type="hidden" name="inkomsten[{{$loop->iteration}}][id]"
                            value="{{$inkomsten->inkomsten_id}}">
                        <td><input type="text" class="form-control" id="soort"
                                name="inkomsten[{{$loop->iteration}}][soort]" value="{{$inkomsten->soort}}" required
                                @if($inkomsten->readonly) readonly @endif>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">&euro;</div>
                                </div><input type="number" class="form-control" id="bedrag"
                                    name="inkomsten[{{$loop->iteration}}][budget]" step=".01"
                                    value="{{$inkomsten->budget}}" min="0" max="99999999" required>
                            </div>
                        </td>
                        <td>&euro; {{ format_currency($inkomsten->realisatie) }}</td>
                        <td>&euro; {{ format_currency($inkomsten->verschil) }}</td>
                    </tr>
                    @endforeach

                    <tr id="inkomsten"></tr>

                </tbody>
            </table>
            <button id="add_inkomsten" class="btn btn-outline-secondary btn-block" type="button">Nieuwe inkomsten
                rij</button>
        </div>
        <div class="col md-6">
            <h4>Uitgaven</h4>
            <table class="table table-hover table-sm  ">
                <thead>
                    <tr>
                        <th scope="col">Soort</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Realisatie</th>
                        <th scope="col">Verschil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uitgaven_list as $uitgaven)
                    <tr>
                        <input type="hidden" name="uitgaven[{{$loop->iteration}}][id]"
                            value="{{$uitgaven->uitgaven_id}}">
                        <td><input type="text" class="form-control" id="soort"
                                name="uitgaven[{{$loop->iteration}}][soort]" value="{{$uitgaven->soort}}" required
                                @if($uitgaven->readonly) readonly @endif></td>
                        <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">&euro;</div>
                                </div><input type="number" class="form-control" id="budget"
                                    name="uitgaven[{{$loop->iteration}}][budget]" step=".01"
                                    value="{{$uitgaven->budget}}" min="0" max="99999999" required>
                            </div>
                        </td>
                        <td>&euro; {{ format_currency($uitgaven->realisatie) }}</td>
                        <td>&euro; {{ format_currency($uitgaven->verschil) }}</td>
                    </tr>
                    @endforeach
                    <tr id="uitgaven"></tr>
                </tbody>
            </table>
            <button id="add_uitgave" class="btn btn-outline-secondary btn-block" type="button">Nieuwe uitgave
                rij</button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Opslaan</button>
</form>
@endsection
