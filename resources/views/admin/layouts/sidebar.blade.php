<aside id="sidebar" class="sidebar p-4 neumorphic-sidebar d-none d-md-block">
    <div class="sidebar-header mb-3 d-flex justify-content-between align-items-center">
        <h2 class="fs-4 fw-semibold sidebar-text">Admin Panel</h2>
        <button onclick="toggleSidebar()" class="toggle-btn neumorphic-card"><span class="p-1"><i
                    class="fas fa-bars"></i></span></button>
    </div>
    <hr>
    <nav>
        <ul class="list-unstyled">
            <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <div class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </div>
                </li>
            </a>
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                    <div class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">User</span>
                    </div>
                </li>
            </a>
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item ">
                    <div class="d-flex align-items-center neu-text gap-2 sidebar-button">
                        <i class="fas fa-cogs"></i>
                        <span class="sidebar-text">Pengaturan</span>
                    </div>
                </li>
            </a>
        </ul>
    </nav>
</aside>
