@extends('layout')
@section('title','Borrel')
@section('content')
    <h2 class="mb-4">Borrel wijzigen</h2>

    <form class="card" method="POST" action="/borrels/{{$borrel->borrel_id}}">
        @csrf
        @method('PATCH')
        <h3>Borrel</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ $borrel->datum }}" required>

        <div class="form-row">
            <div class="col">
                <label for="budget">Budget</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="budget" name="budget" step=".01" value="{{ $borrel->budget }}" min="0" max="99999999" required>
                </div>
            </div>
            <div class="col">
                <label for="uitgave">Uitgave</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control " id="uitgave" name="uitgave" step=".01" value="{{ $borrel->uitgave }}" min="0" max="99999999" required>
                </div>
            </div>
            <div class="col">
                <label for="naheffing">(Totale) Naheffing</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">&euro;</div>
                    </div>
                    <input type="number" class="form-control" id="naheffing" name="naheffing" step=".01" value="{{ $borrel->naheffing }}" max="99999999" required readonly>
                </div>
            </div>
        </div>

        <label for="omschrijving">Omschrijving of opmerking</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving">{{ $borrel->omschrijving }}</textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm ">
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
                    <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][aanwezig]" value="1" @if(isset($lid->aanwezigh)) checked @endif></td>
                    <td><input class="form-control" id="naheffing_leden" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][naheffing]" value="1" @if(isset($lid->naheffing)) checked @endif></td>
                    @if($lid->type_lid == "Actief")
                        <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][afgemeld]" value="1" @if(isset($lid->afgemeld)) checked @endif></td>
                        <td><input class="form-control" type="checkbox" name="aanwezigheid[{{$lid->lid_id}}][boete]" value="1" @if(isset($lid->boete)) checked @endif></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <input class="form-control" type="number" id="naheffing_leden_aantal" name="naheffing_leden_aantal" value="0" readonly hidden>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Wijzig borrel</button>
    </form>

    <script>
        $('form').on("change paste keyup click blur focus submit",function(){
            var budget  = Number($('#budget').val());
            var uitgave = Number($('#uitgave').val());
            var naheffing_checked = $('#naheffing_leden:checked').length;

            $('#naheffing').val((uitgave - budget).toFixed(2));
            $('#naheffing_leden_aantal').val(naheffing_checked);
        });
    </script>
@endsection