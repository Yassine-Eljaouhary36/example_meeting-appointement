<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Vue JS Meeting Appointement</title>
    <link href="{{ asset('css/app.css') }}" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div id="app">
        @include('layouts.navbar')
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/b6098f5426.js" crossorigin="anonymous"></script>
</body>
</html>