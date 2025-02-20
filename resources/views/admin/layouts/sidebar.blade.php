<aside id="sidebar" class="sidebar p-4 neumorphic-sidebar d-none d-md-block">
    <div class="sidebar-header mb-3 d-flex justify-content-between align-items-center">
        <h2 class="fs-4 fw-semibold sidebar-text">Admin Panel</h2>
        <button onclick="toggleSidebar()" class="toggle-btn neumorphic-card"><span class="p-1"><i
                    class="fas fa-bars"></i></span></button>
    </div>
    <hr>
    <nav>
        <ul class="list-unstyled">
            <li class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <i class="fas fa-home"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="mb-3 neumorphic-card sidebar-item">
                <a href="{{ route('admin.user.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <i class="fas fa-users"></i>
                    <span class="sidebar-text">User</span>
                </a>
            </li>
            <li class="mb-3 neumorphic-card sidebar-item">
                <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <i class="fas fa-cogs"></i>
                    <span class="sidebar-text">Setting</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
