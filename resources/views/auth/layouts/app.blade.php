<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AILand') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/public/favicon.png') }}">

    <!-- Fonts -->
    {{-- <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('assets_css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('assets/js/notyf.min.js') }}"></script>
    @yield('assets_js')
    @yield('js')
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            await initPageLoad();
        });
    </script>
</body>

</html>
