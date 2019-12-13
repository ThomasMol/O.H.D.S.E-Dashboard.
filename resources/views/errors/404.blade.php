@extends('login_layout')
@section('title','Error')
@section('content')

<div class="container text-center">
    <img class="ml-auto mr-auto d-block mt-5" src="/images/sadas.png" width="80px">
    <h4 class="text-center p-3">O.H.D. Semper Excelsius dashboard</h4>
    <p class="mb-4">{{$exception->getMessage() }}</p>
    <p>Deze pagina bestaat niet!</p>
    <a href="/" class="btn btn-link">Ga terug naar home</a>
</div>
@endsection
