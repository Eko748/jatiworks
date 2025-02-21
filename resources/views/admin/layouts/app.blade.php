<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/public/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/notyf.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
