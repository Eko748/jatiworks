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
    </style>
</head>

<body>
    <a href="#">
        <button class="btn-floating pulse-button">
            <span class="bi bi-whatsapp h3 text-white p-2"></span>
            <p class="floating-admin" style="font-size: 13px"><a
                    href="https://wa.me/6282111780074?text=Halo%20saya%20butuh%20informasi%20lebih%20lanjut"
                    target="_blank" style="color: white; text-decoration: none">ADMIN AILAND</a></p>
        </button>
    </a>
    @include('buyer.layouts.partials.navbar')
    <main>
        @yield('content')
    </main>
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/notyf.min.js') }}"></script>
    <script>
        const notyf = new Notyf({
            position: {
                x: 'center',
                y: 'top'
            }
        });
    </script>
    @include('buyer.layouts.partials.footer')
    @include('buyer.layouts.script.botscript')
    @yield('js')
    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            await initPageLoad();
        });
    </script>
</body>

</html>
