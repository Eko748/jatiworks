<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.script.topscript')
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
    @include('frontend.partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('frontend.partials.footer')
    @include('frontend.script.botscript')
</body>

</html>
