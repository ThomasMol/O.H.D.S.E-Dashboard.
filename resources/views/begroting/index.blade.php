@extends('layout')
@section('title','Begroting')
@section('content')
    <h3 >Begrotingen van SE</h3>
    <ul>
        @foreach($begrotingen as $begroting)
            <li>
                Jaar {{$begroting->jaargang}}, van {{date('d F Y', strtotime($begroting->van))}} tot {{date('d F Y', strtotime($begroting->tot))}}. <a class="btn btn-link" href="/begroting/{{$begroting->jaargang}}">Bekijk</a> of <a class="btn btn-link" href="/begroting/{{$begroting->jaargang}}/wijzig">Wijzig</a>
            </li>
        @endforeach
    </ul>
@endsection
