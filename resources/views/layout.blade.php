<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    {{-- Stylesheets --}}
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/stylesheet.css" rel="stylesheet" type="text/css">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#e9ab3e">
    <meta name="msapplication-TileColor" content="#367bde">
    <meta name="theme-color" content="#e9ab3e">

</head>

<body>
    <nav>
        <div class="mobile-nav">
            <a href="/"><img src="/images/sadas.png" class="logo-mobile" width="40px"></a>
            <button id="menu" class="btn menu navbar-toggler" data-target="#sidebar-collapse" data-toggle="collapse">
                <span data-feather="menu"></span>
            </button>
        </div>
        <div class="sidebar collapse" id="sidebar-collapse">
            <div class="1accordion" id="accordion">

                <ul class="nav flex-column ">
                    <li class="nav-item">
                        <img src="/images/sadas.png" class="logo" width="50px">
                    </li>
                    <li class="nav-item category dropdown-toggle" data-toggle="collapse" data-target="#collapseOne">
                        Algemeen
                    </li>
                    <div id="collapseOne" class="collapse show" 1data-parent="#accordion">
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

                    </div>

                    <li class="nav-item category dropdown-toggle" data-toggle="collapse" data-target="#collapseTwo">
                        Financi&euml;n
                    </li>
                    <div id="collapseTwo" class="collapse" 1data-parent="#accordion">
                        @if(Auth::user()->admin == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('begroting*') ? 'active' : '' }}"
                                href="/begroting/{{$huidig_jaar->jaargang}}">
                                Begroting
                            </a>
                        </li>
                        @endif
                        {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('borrel*') ? 'active' : '' }}" href="/borrels">
                        Borrels
                        </a>
                        </li> --}}
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
                            <a class="nav-link {{ Request::is('kost*') ? 'active' : '' }}" href="/kosten">
                                Overige kosten
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
                    </div>

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

                    <li class="nav-item category dropdown-toggle" data-toggle="collapse" data-target="#collapseThree">
                        Bestuur
                    </li>
                    <div id="collapseThree" class="collapse" 1data-parent="#accordion">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('instelling*') ? 'active' : '' }}" href="/instellingen">
                                Instellingen
                            </a>
                        </li>
                        @endif

                    </div>
                </ul>
            </div>
            @if(Auth::check())
            <a class="nav-link logout" href="/loguit">
                <span data-feather="log-out"></span>
                Log uit
            </a>
            @endif
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
