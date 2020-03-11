@extends('login_layout')
@section('title','Login')
@section('content')

    <div class="container">
        <img class="ml-auto mr-auto d-block mt-5" src="/images/sadas.png" width="80px">
        <h4 class="text-center p-3">O.H.D. Semper Excelsius dashboard</h4>
        <form class="form-login card" method="POST" action="/login">
            @csrf
            <div class="card-header"><h2>Log in</h2></div>
            <div class="card-body">
                    <label for="inputEmail" class="">Email addres</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="email" name="email" required autofocus>
                    <label for="inputPassword" class="">Wachtwoord</label>
                    <input type="password" id="inputPassword" class="form-control mb-4" placeholder="wachtwoord" name="password" required>
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
            </div>

        </form>
        <a class="btn btn-lg btn-link btn-block" href="/password/reset">Wachtwoord vergeten?</a>
    </div>
@endsection
