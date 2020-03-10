@extends('layout')
@section('title','Begroting')
@section('content')
<header>
    <h3 class="d-inline">Begroting van het {{$bestuursjaar->jaargang}}e bestuursjaar</h3>
    <a href="/begroting/{{$bestuursjaar->jaargang}}/wijzig" class="btn btn-outline-primary float-right"><span data-feather="edit"></span> Wijzig</a>
</header>
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
                    <td>{{$inkomsten->soort}}</td>
                    <td>&euro; {{ format_currency($inkomsten->budget) }}</td>
                    <td>&euro; {{ format_currency($inkomsten->realisatie) }}</td>
                    <td>&euro; {{ format_currency($inkomsten->verschil) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td><strong>Totaal:</strong></td>
                    <td><strong>&euro; {{ format_currency($inkomsten_list->sum('budget')) }}</strong></td>
                    <td><strong>&euro; {{ format_currency($inkomsten_list->sum('realisatie')) }}</strong></td>
                    <td><strong>&euro; {{ format_currency($inkomsten_list->sum('verschil')) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col md-6">
        <h4>Uitgaven</h4>
        <table class="table table-hover table-sm ">
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
                    <td>{{$uitgaven->soort}}</td>
                    <td>&euro; {{ format_currency($uitgaven->budget) }}</td>
                    <td>&euro; {{ format_currency($uitgaven->realisatie) }}</td>
                    <td>&euro; {{ format_currency($uitgaven->verschil) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td><strong>Totaal:</strong></td>
                    <td><strong>&euro; {{ format_currency($uitgaven_list->sum('budget')) }}</strong></td>
                    <td><strong>&euro; {{ format_currency($uitgaven_list->sum('realisatie')) }}</strong></td>
                    <td><strong>&euro; {{ format_currency($uitgaven_list->sum('verschil')) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <p>Verschil tussen inkomsten en uitgaven:
            {{format_currency($inkomsten_list->sum('budget') - $uitgaven_list->sum('budget'))}}
        </p>

        <p>Geld op de rekening: {{$se_rekening->saldo}}</p>
        <p>Totaal AF transacties: {{format_currency($transacties_af_aggregate)}}</p>
        <p>Totaal Uitgaven: {{format_currency($uitgaven_aggregate)}}</p>
    </div>
</div>


@endsection
