<!-- resources/views/exports/inkomsten_uitgaven.blade.php -->

<div class="col-md-6">
    <h4>Standen</h4>
    <table class="table table-hover table-sm">
        <tbody>
            <tr>
                <td>SE rekening</td>
                <td>{{ $additionalInfo['serekening']->saldo }}</td>
            </tr>
            <tr>
                <td>Liquiditeit</td>
                <td>{{ $additionalInfo['liquiditeit'] }}</td>
            </tr>
            <tr>
                <td>Totaal bij</td>
                <td>{{ $additionalInfo['bij'] }}</td>
            </tr>
            <tr>
                <td>Totaal af</td>
                <td>{{ $additionalInfo['af'] }}</td>
            </tr>
            <tr>
                <td>Totaal uitgaven</td>
                <td>{{ $additionalInfo['uit'] }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="col-md-6">
    <h4>Inkomsten</h4>
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Soort</th>
                <th scope="col">Budget</th>
                <th scope="col">Realisatie</th>
                <th scope="col">Verschil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inkomstenList as $inkomsten)
                <tr>
                    <td>{{$inkomsten->soort}}</td>
                    <td>&euro; {{ format_currency($inkomsten->budget) }}</td>
                    <td>&euro; {{ format_currency($inkomsten->realisatie) }}</td>
                    <td>&euro; {{ format_currency($inkomsten->verschil) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Totaal:</strong></td>
                <td><strong>&euro; {{ format_currency($inkomstenList->sum('budget')) }}</strong></td>
                <td><strong>&euro; {{ format_currency($inkomstenList->sum('realisatie')) }}</strong></td>
                <td><strong>&euro; {{ format_currency($inkomstenList->sum('verschil')) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="col-md-6">
    <h4>Uitgaven</h4>
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Soort</th>
                <th scope="col">Budget</th>
                <th scope="col">Realisatie</th>
                <th scope="col">Verschil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uitgavenList as $uitgaven)
                <tr>
                    <td>{{$uitgaven->soort}}</td>
                    <td>&euro; {{ format_currency($uitgaven->budget) }}</td>
                    <td>&euro; {{ format_currency($uitgaven->realisatie) }}</td>
                    <td>&euro; {{ format_currency($uitgaven->verschil) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Totaal:</strong></td>
                <td><strong>&euro; {{ format_currency($uitgavenList->sum('budget')) }}</strong></td>
                <td><strong>&euro; {{ format_currency($uitgavenList->sum('realisatie')) }}</strong></td>
                <td><strong>&euro; {{ format_currency($uitgavenList->sum('verschil')) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
