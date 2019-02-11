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
<div class="flex-container">
    <nav>
        <div class="mobile-nav">
            <a>SE</a>
            <button id="menu" class="btn menu navbar-toggler" data-target="#sidebarCollapse" data-toggle="collapse">menu <span data-feather="menu"></span></button>
        </div>
        <div class="sidebar collapse" id="sidebarCollapse">

            <ul class="nav flex-column ">
                <li class="nav-item">
                    <img src="/images/sadas.png" class="logo" width="70px">
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                        <span data-feather="home"></span>
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('gegevens*') ? 'active' : '' }}" href="/gegevens">
                        <span data-feather="user"></span>
                        Mijn gegevens
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('leden*') ? 'active' : '' }}" href="/leden">
                        <span data-feather="users"></span>
                        Leden
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('activiteit*') ? 'active' : '' }}" href="/activiteiten">
                        <span data-feather="coffee"></span>
                        Activiteiten
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('borrel*') ? 'active' : '' }}" href="/borrels">
                        <span data-feather="coffee"></span>
                        Borrels
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('declaratie*') ? 'active' : '' }}" href="/declaraties">
                        <span data-feather="dollar-sign"></span>
                        Declaraties
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('transacties*') ? 'active' : '' }}" href="/transacties">
                        <span data-feather="repeat"></span>
                        Transacties
                    </a>
                </li>
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
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</div>

<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/bootstrap.js" type="text/javascript"></script>
<script src="/js/scripts.js" type="text/javascript"></script>
<script>
    feather.replace();
</script>
</body>
</html>