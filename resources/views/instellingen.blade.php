@extends('layout')
@section('title','Instellingen')
@section('content')
<header>
    <h2>Instellingen</h2>
</header>
<div>
    @if(Auth::user()->admin == 1)
    <h5>Begrotingen</h5>
    <div class="dropdown mb-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownJaar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Bekijk begroting van jaargang:
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownJaar">
                @foreach($bestuursjaren as $bestuursjaar_value)
                    <a class="dropdown-item" href="/begroting/{{$bestuursjaar_value->jaargang}}">Jaar {{$bestuursjaar_value->jaargang}} @if($bestuursjaar_value->jaargang == $huidig_jaar->jaargang) <i>Huidig jaar</i>@endif</a>
                @endforeach
            </div>
        </div>
        <form action="/instellingen/nieuwebegroting" method="GET">
            <button type="submit" class="btn btn-secondary" onclick="return confirm('Weet je het zeker?')">Maak begroting aan van jaargang {{$bestuursjaren->last()->jaargang + 1}}.</button>
        </form>
    <hr>
    <h5>Standaardwaarde</h5>
        <ul>
            <li>Boetes: 10</li>
            <li>Kosten reunist/passief: 10</li>
        </ul>
    <hr>
    <h5>Verwijderde leden</h5>
    <table class="table table-responsive table-hover">
        <thead>
            <th>Naam</th>
            <th>Verwijderd op</th>
            <th></th>
        </thead>
        @foreach ($verwijderdeLeden as $lid)
        <tr>
            <td>{{$lid->roepnaam}} {{$lid->achternaam}}</td>
            <td>{{$lid->deleted_at}}</td>
            <td><a href="/instellingen/onverwijderlid/{{$lid->lid_id}}" class="btn btn-outline-primary">Onverwijder</a>
            </td>
        </tr>

        @endforeach
    </table>
    <hr>
    @endif
</div>
@endsection
