<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    {{-- Stylesheets --}}
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="/css/stylesheet.css" rel="stylesheet" type="text/css">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#050914">
    <meta name="msapplication-TileColor" content="#050914">
    <meta name="theme-color" content="#050914">
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="/images/sadas.png" class="logo" width="38px"> Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenuItems"
                aria-controls="navbarMenuItems" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenuItems">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                            Overzicht
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('leden*') ? 'active' : '' }}" href="/leden">
                            Alle leden
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="financienDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Financi&euml;n
                        </a>
                        <div class="dropdown-menu" aria-labelledby="financienDropdown">
                            <a class="dropdown-item {{ Request::is('begroting*') ? 'active' : '' }}"
                                href="/begroting/{{$huidig_jaar->jaargang}}">
                                Begroting
                            </a>
                            <a class="dropdown-item {{ Request::is('declaratie*') ? 'active' : '' }}"
                                href="/declaraties">
                                Declaraties
                            </a>
                            <a class="dropdown-item {{ Request::is('transacties*') ? 'active' : '' }}"
                                href="/transacties">
                                Transacties
                            </a>
                            <a class="dropdown-item {{ Request::is('contributie*') ? 'active' : '' }}"
                                href="/contributies">
                                Contributies
                            </a>
                            <a class="dropdown-item {{ Request::is('kost*') ? 'active' : '' }}" href="/kosten">
                                Overige kosten
                            </a>
                            <a class="dropdown-item {{ Request::is('uitgave*') ? 'active' : '' }}" href="/uitgaven">
                                Uitgaven
                            </a>

                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span data-feather="user"></span> {{Auth::user()->roepnaam}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="accountDropdown">
                            <a class="dropdown-item {{ Request::is('gegevens*') ? 'active' : '' }}" href="/gegevens">
                                <span data-feather="user"></span> Mijn gegevens
                            </a>
                            @if(Auth::user()->admin == 1)
                            <a class="dropdown-item {{ Request::is('instelling*') ? 'active' : '' }}"
                                href="/instellingen">
                                <span data-feather="settings"></span> Instellingen
                            </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="/loguit">
                                <span data-feather="log-out"></span> Log uit
                            </a>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container">

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <strong><span data-feather="alert-triangle"></span> Foutmelding:</strong> {{ $error }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach
        @elseif(session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <span data-feather="check"></span> {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <span data-feather="alert-triangle"></span> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @yield('content')
    </main>

    {{-- Scripts --}}
    <script src="/js/jquery.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="/js/bootstrap.js" type="text/javascript"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="/js/scripts.js" type="text/javascript"></script>

    <script>
        feather.replace();
    </script>
</body>

</html>
