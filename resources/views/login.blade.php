@extends('login_layout')
@section('title','Login')
@section('content')

<div class="container">
    <img class="ml-auto mr-auto d-block mt-5" src="/images/sadas.png" width="80px">
    <h4 class="text-center p-3">O.H.D. Semper Excelsius dashboard - Login</h4>
    <div class="card form-login">
        <div class="card-body">
            <form class="" method="POST" action="/login">
                @csrf
                <label for="inputEmail" class="">Emailadres</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="emailadres" name="email" required
                    autofocus>
                <label for="inputPassword" class="">Wachtwoord</label>
                <input type="password" id="inputPassword" class="form-control mb-4" placeholder="wachtwoord"
                    name="password" required>
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
            <br>
            <a class="btn btn-link btn-block" href="/password/reset">Wachtwoord vergeten?</a>
        </div>
    </div>

</div>
@endsection
