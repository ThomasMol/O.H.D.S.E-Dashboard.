@extends('layout')
@section('title','Begroting')
@section('content')
<header>
    <h1 class="d-inline">Begroting van het {{$bestuursjaar->jaargang}}e bestuursjaar</h1>
    <a href="/begroting/{{$bestuursjaar->jaargang}}/wijzig" class="btn btn-outline-primary float-right"><span
            data-feather="edit"></span> Wijzig</a>
</header>

<div class="card">
    <div class="card-header">
        <h3>Saldo SE rekening: <span class="badge badge-success">&euro;
                {{format_currency($se_rekening->saldo)}}</span></h3>
    </div>
    <div class="card-body">
        <p>Verschil tussen inkomsten en uitgaven:
            {{format_currency($inkomsten_list->sum('budget') - $uitgaven_list->sum('budget'))}}
        </p>


        <p>Totaal AF transacties: {{format_currency($transacties_af_aggregate)}}</p>
        <p>Totaal Uitgaven: {{format_currency($uitgaven_aggregate)}}</p>
    </div>
</div>


<div class="card">
    <div class="card-body">
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

        </div>
    </div>
</div>



@endsection
