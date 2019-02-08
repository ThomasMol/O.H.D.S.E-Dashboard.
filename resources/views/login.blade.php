@extends('login_layout')
@section('title','Login')
@section('content')

    <div class="container">
        <h1 class="text-center p-5">O.H.D. Semper Excelsius dashboard</h1>
        <form class="form-login" method="POST" action="/login">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal">Log in</h1>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email adres" name="email" required autofocus>
            <label for="inputPassword" class="sr-only">Wachtwoord</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Wachtwoord" name="password" required>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
        </form>

    </div>
@endsection