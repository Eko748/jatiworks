<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" href="{{ asset('assets/admin/images/Logomk-white.png') }}"> --}}

    <title>{{ config('app.name', 'AILand') }}</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
</body>

</html>
