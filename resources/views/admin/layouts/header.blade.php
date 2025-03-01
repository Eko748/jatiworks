<header class="p-3 position-relative neumorphic-header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <button id="mobileToggle" onclick="toggleSidebar()" class="toggle-btn neumorphic-card d-block d-md-none">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="fs-3 fw-bold mb-0">Jatiworks</h1>
        </div>
        <div class="dropdown user-menu d-flex align-items-center gap-2">
            <span class="mb-0 fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
            <button
                class="btn border-0 shadow-sm rounded-circle p-3 d-flex align-items-center dropdown-toggle bg-green neumorphic"
                type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-sign-out-alt"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li>
                    <form method="POST" action="{{ route('login.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="logout()">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
