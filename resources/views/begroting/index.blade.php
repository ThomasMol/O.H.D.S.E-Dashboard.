@extends('layout')
@section('title','Begroting')
@section('content')
    <h3 >Begrotingen van SE</h3>
    <ul>
        @foreach($begrotingen as $begroting)
            <li>
                Jaar {{$begroting->jaargang}}, van {{Carbon\Carbon::parse($begroting->van)->translatedFormat('d F Y')}} tot {{Carbon\Carbon::parse($begroting->tot)->translatedFormat('d F Y')}}. <a class="btn btn-link" href="/begroting/{{$begroting->jaargang}}">Bekijk</a> of <a class="btn btn-link" href="/begroting/{{$begroting->jaargang}}/wijzig">Wijzig</a>
            </li>
        @endforeach
    </ul>
@endsection
