<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OHD SE - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:200,600" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/stylesheet.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/feather-icons"></script>



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