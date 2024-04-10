<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo.png') }}"  width="150" height="80" alt="LOG">
    </header>
    @yield('content')
    <footer>
        <h2>Tous droits réservés © Loris Hourriere - 2024 </h2>
    </footer>
</body>
</html>
