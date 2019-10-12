@extends('layout')
@section('title','Begroting')
@section('content')
    <h3>Begroting van het {{$bestuursjaar->jaargang}}e bestuursjaar aanpassen</h3>
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
                    <th scope="col">Bedrag</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inkomsten_list as $inkomsten)
                    <tr>

                        <td><input type="text" class="form-control" id="soort" name="inkomsten[{{$inkomsten->inkomsten_id}}][soort]" value="{{$inkomsten->soort}}" required></td>
                        <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">&euro;</div>
                                </div><input type="number" class="form-control" id="budget" name="inkomsten[{{$inkomsten->inkomsten_id}}][bedrag]" step=".01" value="{{$inkomsten->bedrag}}" min="0" max="99999999" required>
                            </div>
                        </td>
                    </tr>
                @endforeach

                    <tr id="inkomsten">
                        <td colspan="2"><button id="add_inkomsten" class="btn btn-light btn-block" type="button">Nieuwe inkomsten rij</button></td>
                    </tr>
                </tbody>
            </table>
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
                @foreach($uitgaven_list as $uitgave)
                    <tr>
                        <td><input type="text" class="form-control" id="soort" name="uitgave_soort[]" value="{{$uitgave->soort}}" required></td>
                        <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">&euro;</div>
                                </div><input type="number" class="form-control" id="budget" name="uitgave_budget[]" step=".01" value="{{$uitgave->budget}}" min="0" max="99999999" required>
                            </div>
                        </td>
                        <td>&euro; {{ format_currency($uitgave->realisatie) }}</td>
                        <td>&euro; {{ format_currency($uitgave->verschil) }}</td>
                    </tr>
                @endforeach

                <tr id="uitgaven">
                    <td colspan="4"><button id="add_uitgave" class="btn btn-light btn-block" type="button">Nieuwe uitgave rij</button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Opslaan</button>
    </form>
    <script>
        //Add and remove rekeningnummer input field
        $("form").on("click","#add_inkomsten",function () {
            $("#inkomsten").before(`<tr>
                <td><input type=\"text\" class="form-control" id="soort" name="inkomsten[-1][soort]" value="" placeholder="soort"></td>
                <td>
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                <div class="input-group-text">&euro;</div>
            </div>
            <input type="number" class="form-control" id="budget" name="inkomsten[-1][bedrag]" step=".01" value="" min="0" max="99999999" placeholder="bedrag">
                <button id="remove_rij" class="btn btn-link" type="button">X</button>

                </div>
                </td>
                </tr>` );
        });

        $("form").on("click","#add_uitgave",function () {
            $("#uitgaven").before(`<tr>
                    <td><input type="text" class="form-control" id="soort" name="uitgave_soort[]" value="" placeholder="soort"></td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">&euro;</div>
                            </div>
                            <input type="number" class="form-control" id="budget" name="uitgave_budget[]" step=".01" value="" min="0" max="99999999" placeholder="budget">
                        </div>
                    </td>
                    <td></td>
                    <td><button id="remove_rij" class="btn btn-link" type="button">X</button></td>
                </tr>` );
        });

        $("form").on("click","#remove_rij",function(e){
            $(this).closest('tr').remove();
        });
    </script>
@endsection
