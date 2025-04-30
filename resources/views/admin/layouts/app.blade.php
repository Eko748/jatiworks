<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        .sidebar {
            transition: width 0.3s ease;
        }
    </style>
    <script>
        (function() {
            if (window.innerWidth >= 768 && localStorage.getItem('sidebar-collapsed') === 'true') {
                document.documentElement.classList.add('sidebar-is-collapsed');
            }
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/public/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slimselect.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/index.css') }}">
    @yield('assets_css')
    @yield('css')
</head>

<body class="d-flex">
    @include('admin.layouts.sidebar')

    <div class="d-flex flex-column flex-grow-1">
        @include('admin.layouts.header')
        @include('admin.layouts.navbar')
        <main id="main-content" class="flex-grow-1 p-3 position-relative">
            @yield('content')
        </main>
        @include('admin.layouts.footer')
    </div>

    @include('admin.layouts.scripts')
    @yield('assets_js')
    @yield('js')
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const sidebar = document.getElementById('sidebar');
            if (document.documentElement.classList.contains('sidebar-is-collapsed')) {
                sidebar.classList.add('sidebar-collapsed');
            }
            const savedTheme = localStorage.getItem('theme');
            const toggleThemeBtn = document.getElementById('toggleTheme');

            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
                toggleThemeBtn.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                document.body.classList.remove('dark-mode');
                toggleThemeBtn.innerHTML = '<i class="fas fa-moon"></i>';
            }
            await initPageLoad();
            await tooltip();
        });
    </script>
</body>

</html>
