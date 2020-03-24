@extends('layout')
@section('title','Borrel')
@section('content')
<h3>Declaratie</h3>
@if(Auth::user()->admin == 1 )
<a class="btn btn-primary" href="/borrels/{{$borrel->borrel_id}}/wijzig">Borrel wijzigen</a>
@endif
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th scope="col">Datum</th>
                <th scope="col">Bedrag</th>
                <th scope="col">Uitgave</th>
                <th scope="col">(Totale) Naheffing</th>
                <th scope="col">Omschrijving</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ date('d F Y - l', strtotime($borrel->datum)) }}</td>
                <td>&euro; {{ format_currency($borrel->bedrag) }}</td>
                <td>&euro; {{ format_currency($borrel->uitgave) }}</td>
                <td>&euro; {{ format_currency($borrel->naheffing) }}</td>
                <td>{{ $borrel->omschrijving }}</td>

            </tr>

        </tbody>
    </table>
</div>
<ul>
    @foreach($leden_deelname as $lid)
    <li>{{$lid->roepnaam}}: Aanwezig: {{$lid->aanwezig}}. Naheffing: &euro; {{format_currency($lid->naheffing)}}</li>
    @endforeach
</ul>
@endsection
