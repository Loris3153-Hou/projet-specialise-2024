<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <h2>LOGO</h2>
    </header>
    @yield('content')
    <footer>
        <h2>Contact</h2>
    </footer>
</body>
</html>
