<!DOCTYPE html>
<html lang="en">

<head>
    @include('buyer.layouts.script.topscript')
    <link rel="stylesheet" href="{{ asset('assets/css/notyf.min.css') }}">
    <style>
        .bg-green-gradient {
            background: radial-gradient(circle at 50% 50%, #95efb1, #055940);
        }

        .bg-green-white {
            background: #d4f9e0;
        }

        .bg-green-young {
            background: #a8f3c0;
        }

        .bg-green-old {
            background: #055940;
        }

        .dropdown {
            position: relative;
            z-index: 1050;
        }
    </style>
    @yield('css')
</head>

<body>
    <button class="btn-floating pulse-button bg-green-old">
        <span class="bi bi-whatsapp h3 text-white"></span>
        <p class="floating-admin" style="font-size: 13px"><a
                href="https://wa.me/6282217101985?text=Halo%20saya%20butuh%20informasi%20lebih%20lanjut" target="_blank"
                style="color: white; text-decoration: none">ADMIN JATIWORKS</a></p>
    </button>
    @include('buyer.layouts.partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('buyer.layouts.partials.footer')
    @include('buyer.layouts.script.botscript')
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
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
