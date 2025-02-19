<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Neumorphic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background: #e0e5ec;
        }

        .neumorphic {
            background: #e0e5ec;
            box-shadow: 8px 8px 15px #b8bcc4, -8px -8px 15px #ffffff;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
        }

        .sidebar {
            height: 100vh;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease-in-out;
            width: 250px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .sidebar-item i {
            font-size: 1.2rem;
        }


        @media (min-width: 768px) {
            .sidebar-collapsed {
                width: 90px !important;
                overflow: hidden;
            }

            .sidebar-collapsed .sidebar-text {
                display: none;
            }

            .sidebar-collapsed .sidebar-header .sidebar-text {
                display: none;
            }
        }


        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-btn {
            background: #32CD32;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #ffffff;
        }

        .toggle-btn:hover {
            background: #b8bcc4;
            color: black;
            transition: background 0.3s ease-in-out;
        }

        .sidebar-item:hover {
            background: #32CD32;
            color: white;
            transition: background 0.3s ease-in-out;
        }

        .sidebar-item:hover a {
            color: white;
        }

        .sidebar-item.active {
            background: #32CD32;
            border-radius: 10px;
            color: white;
        }

        .sidebar-item a {
            color: #333;
        }

        .sidebar-item.active a {
            font-weight: bold;
            color: white;
        }


        /* Bg */
        .bg-green {
            background: #32CD32;
        }

        .popup-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #32CD32;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        .popup-btn:hover {
            background: #b8bcc4;
            color: black;
        }

        .user-menu .btn {
            color: white;
            width: 50px;
            height: 50px;
            aspect-ratio: 1/1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            border-radius: 50%;
        }

        .user-menu .btn:hover {
            background: #b8bcc4;
            color: black;
            transition: background 0.3s ease-in-out;
        }

        .user-menu .btn i {
            font-size: 1.2rem;
        }

        #mobileToggle {
            width: 40px;
            height: 40px;
        }


        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                width: 250px;
                height: 100vh;
                z-index: 1050;
            }
        }
    </style>
</head>

<body class="d-flex">
    <aside id="sidebar" class="sidebar p-4 neumorphic d-none d-md-block">
        <div class="sidebar-header mb-3 d-flex justify-content-between align-items-center">
            <h2 class="fs-4 fw-semibold sidebar-text">Admin Panel</h2>
            <button onclick="toggleSidebar()" class="toggle-btn neumorphic"><span class="p-1"><i
                        class="fas fa-bars"></i></span></button>
        </div>
        <hr>
        <nav>
            <ul class="list-unstyled">
                <li class="mb-3 neumorphic sidebar-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}"
                        class="d-flex align-items-center gap-2 text-decoration-none">
                        <i class="fas fa-home"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                <li class="mb-3 neumorphic sidebar-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="d-flex align-items-center gap-2 text-decoration-none">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">User</span>
                    </a>
                </li>
                <li class="mb-3 neumorphic sidebar-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="d-flex align-items-center gap-2 text-decoration-none">
                        <i class="fas fa-cogs"></i>
                        <span class="sidebar-text">Setting</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="d-flex flex-column flex-grow-1">
        <header class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <button id="mobileToggle" onclick="toggleSidebar()" class="toggle-btn neumorphic d-block d-md-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="fs-3 fw-bold mb-0">Dashboard</h1>
                </div>
                <div class="dropdown user-menu d-flex align-items-center gap-2">
                    <span class="mb-0 fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
                    <button
                        class="btn border-0 shadow-sm rounded-circle p-3 d-flex align-items-center dropdown-toggle bg-green neumorphic"
                        type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li>
                            <button class="dropdown-item" onclick="logout()">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main id="main-content" class="flex-grow-1 p-4 position-relative">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-4 neumorphic">
                        <h2 class="fs-5">Total Users</h2>
                        <p class="fs-4 fw-bold">120</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 neumorphic">
                        <h2 class="fs-5">Total Orders</h2>
                        <p class="fs-4 fw-bold">350</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 neumorphic">
                        <h2 class="fs-5">Revenue</h2>
                        <p class="fs-4 fw-bold">$25,000</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    <!-- Notyf CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        // Inisialisasi Notyf
        const notyf = new Notyf({
            duration: 3000, // Notifikasi hilang dalam 3 detik
            position: {
                x: 'middle',
                y: 'top'
            }
        });

        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('d-none');
            }
            sidebar.classList.toggle('sidebar-collapsed');
        }

        async function logout() {
            try {
                let response = await renderAPI('POST', '{{ route('login.logout') }}');

                if (response.status === 200) {
                    notyf.success('Logout berhasil, mengarahkan...');
                    setTimeout(() => {
                        window.location.href = "{{ route('login.index') }}"; // Redirect setelah logout
                    }, 1500);
                }
            } catch (error) {
                let resp = error.response;
                notyf.error(resp?.data?.message || 'Terjadi Kesalahan');
            }
        }
    </script>
</body>

</html>
