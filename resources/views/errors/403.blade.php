@extends('login_layout')
@section('title','Error 403')
@section('content')

<div class="container text-center">
    <img class="ml-auto mr-auto d-block mt-5" src="/images/sadas.png" width="80px">
    <h4 class="text-center p-3">O.H.D. Semper Excelsius dashboard</h4>
    <p class="mb-4">{{$exception->getMessage() }}</p>
    <h1>403 Error</h1>
    <p>Je hebt geen toegang tot deze pagina.</p>
    <a href="/" class="btn btn-link">Ga terug naar home</a>
</div>
@endsection
