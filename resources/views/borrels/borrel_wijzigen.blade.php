@extends('layout')
@section('title','Activiteiten')
@section('content')
    <h2 class="mb-4">Borrel wijzigen</h2>

    <form class="card" method="POST" action="/borrel/wijzig/{{$borrel->borrel_id}}">
        @csrf
        <h3>Borrel</h3>
        <label for="datum">Datum</label>
        <input type="date" class="form-control mb-3" id="datum" name="datum" value="{{$borrel->datum}}" required>
        <label for="budget">Budget</label>
        <input type="number" class="form-control mb-3" id="budget" name="budget" value="{{$borrel->budget}}" step=".01" value="0.00" required>
        <label for="naheffing">Naheffing</label>
        <input type="number" class="form-control mb-3" id="naheffing" name="naheffing" value="{{$borrel->naheffing}}" step=".01" value="0.00" required>

        <label for="betaald_door">Betaald door:</label>
        <select class="form-control mb-3"id="betaald_door" name="betaald_door_id" >
            <option selected value="se">SE</option>

        </select>
        <label for="omschrijving">Omschrijving</label>
        <textarea type="text" class="form-control mb-3" id="omschrijving" name="omschrijving"> {{$borrel->omschrijving}}</textarea>

        <h3>Aanwezigheid</h3>
        <table class="table table-hover table-sm ">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Aanwezig</th>
                <th scope="col">Afwezig</th>
                <th scope="col">Afgemeld</th>
                <th scope="col">Te laat</th>
                <th scope="col">Naheffing</th>

            </tr>
            </thead>
            <tbody>
            @foreach($leden_aanwezigheid as $lid)
                <tr>
                    @if($lid->type_lid == "Actief")
                        <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                        <td><input type="radio" name="{{$lid->lid_id}}[]" value="aanwezig" @if($lid->aanwezig == 1) checked @endif required></td>
                        <td><input type="radio" name="{{$lid->lid_id}}[]" value="afwezig" @if($lid->afwezig == 1) checked @endif required></td>
                        <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="afgemeld" @if($lid->afgemeld == 1) checked @endif></td>
                        <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="te_laat" @if($lid->te_laat == 1) checked @endif></td>
                        <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="naheffing_aanwezig" @if($lid->naheffing_aanwezig == 1) checked @endif></td>
                    @else
                        <th scope="row">{{ $lid->roepnaam }} {{ $lid->achternaam }}</th>
                        <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="aanwezig" @if($lid->aanwezig == 1) checked @endif></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox" name="{{$lid->lid_id}}[]" value="naheffing_aanwezig"@if($lid->naheffing_aanwezig == 1) checked @endif></td>
                    @endif
                </tr>
            @endforeach

            </tbody>
        </table>

        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3 mt-3">Wijzig borrel</button>
    </form>
@endsection