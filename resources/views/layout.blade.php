<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OHD SE - @yield('title')</title>

    {{-- Stylesheets --}}
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/stylesheet.css" rel="stylesheet" type="text/css">

    {{-- Scripts --}}
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="/js/jquery-3.4.1.min.js"></script>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#e9ab3e">
    <meta name="msapplication-TileColor" content="#367bde">
    <meta name="theme-color" content="#e9ab3e">

</head>
<body>
<nav>
    <div class="mobile-nav">
        <a href="/"><img src="/images/sadas.png" class="logo-mobile" width="40px"></a>
        <button id="menu" class="btn menu navbar-toggler" data-target="#sidebarCollapse" data-toggle="collapse">menu
            <span data-feather="menu"></span></button>
    </div>
    <div class="sidebar collapse" id="sidebarCollapse">

        <ul class="nav flex-column ">
            <li class="nav-item">
                <img src="/images/sadas.png" class="logo" width="50px">
            </li>
            <li class="nav-item category">
                Algemeen
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    Overzicht
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('gegevens*') ? 'active' : '' }}" href="/gegevens">
                    Mijn gegevens
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('leden*') ? 'active' : '' }}" href="/leden">
                    Leden
                </a>
            </li>
            <li class="nav-item category">
                Financi&euml;n
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('borrel*') ? 'active' : '' }}" href="/borrels">
                    Borrels
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('contributie*') ? 'active' : '' }}" href="/contributies">
                    Contributies
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('declaratie*') ? 'active' : '' }}" href="/declaraties">
                    Declaraties
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('transacties*') ? 'active' : '' }}" href="/transacties">
                    Transacties
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('uitgave*') ? 'active' : '' }}" href="/uitgaven">
                    Uitgaven
                </a>
            </li>

          {{--  <li class="nav-item category">
                Dispuut
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('bestu*') ? 'active' : '' }}" href="/besturen">
                    Besturen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('commissie*') ? 'active' : '' }}" href="/commissies">
                    Commissies
                </a>
            </li>
--}}
            @if(Auth::user()->admin == 1)
            <li class="nav-item category">
                Bestuur
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('instelling*') ? 'active' : '' }}" href="/instellingen">
                    Instellingen
                </a>
            </li>
            @endif
            @if(Auth::check())
                <li class="nav-item logout">
                    <a class="nav-link" href="/loguit">
                        <span data-feather="log-out"></span>
                        Log uit
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>

<main class="main">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
           {{ $error }}
        </div>
        @endforeach

    @endif
    @yield('content')
</main>
<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/bootstrap.js" type="text/javascript"></script>
<script src="/js/scripts.js" type="text/javascript"></script>

<script>
    feather.replace();
</script>
</body>
</html>