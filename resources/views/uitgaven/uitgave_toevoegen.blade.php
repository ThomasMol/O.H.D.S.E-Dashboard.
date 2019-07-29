@extends('layout')
@section('title','Uitgave')
@section('content')
    <h2 class="mb-4">Uitgave toevoegen</h2>

    <form class="card" method="POST" action="/uitgaven/toevoegen">
        @csrf
        <h3>Activiteit</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{ date('Y-m-d') }}" required>
        <label for="budget">Budget</label>
        <input type="number" class="form-control mb-3" id="budget" name="budget" step=".01" value="0.00" min="0" required>
        <label for="uitgave">Uitgave</label>
        <input type="number" class="form-control mb-3" id="uitgave" name="uitgave" step=".01" value="0.00" min="0" required>
        <label for="naheffing">Naheffing</label>
        <input type="number" class="form-control mb-3" id="naheffing" name="naheffing" step=".01" value="0.00" disabled>
        <label for="categorie">Categorie:</label>
        <select class="form-control mb-3"id="categorie" name="categorie" required>
            <option selected value="Overig">Overig</option>
            <option value="Weekend 1">Weekend 1</option>
            <option value="Weekend 2">Weekend 2</option>
        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving" required></textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
            </tr>
            </thead>
            <tbody>
            @foreach($leden as $lid)
                <tr>
                    <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                    <td><input type="checkbox" name="deelnemers[]" value="{{$lid->lid_id}}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3 floating">Voeg uitgave toe</button>
    </form>

    <script>
        $('input').on("change paste keyup mouseenter mouseleave click blur focus",function(){
            var budget  = Number($('#budget').val());
            var uitgave = Number($('#uitgave').val());
            document.getElementById('naheffing').value = (uitgave - budget).toFixed(2);
        });
    </script>
@endsection