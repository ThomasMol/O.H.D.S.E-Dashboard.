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
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#e9ab3e">
    <meta name="msapplication-TileColor" content="#367bde">
    <meta name="theme-color" content="#e9ab3e">

</head>
<body>
<div class="container-fluid">
    @yield('content')
</div>

<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/bootstrap.js" type="text/javascript"></script>
<script>
    feather.replace();
</script>
</body>
</html>