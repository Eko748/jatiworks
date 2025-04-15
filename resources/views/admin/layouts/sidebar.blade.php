<aside id="sidebar" class="sidebar p-4 neumorphic-sidebar d-none d-md-block">
    <div class="sidebar-header mb-3 d-flex justify-content-between align-items-center">
        <h2 class="fs-4 fw-semibold sidebar-text">
            {{ ucwords(strtolower(Auth::user()->role->role_name)) }}
        </h2>
        <button onclick="toggleSidebar()" class="toggle-btn neumorphic-card"><span class="p-1"><i
                    class="fas fa-bars"></i></span></button>
    </div>
    <hr>
    <nav>
        <ul class="list-unstyled">
            <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </div>
                </li>
            </a>
            <p>Data Master</p>
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">User</span>
                    </div>
                </li>
            </a>
            <a href="{{ route('admin.katalog.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.katalog.index') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.katalog.index') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span class="sidebar-text">Catalogue</span>
                    </div>
                </li>
            </a>
            <a href="{{ route('admin.article.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.article.index') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.article.index') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        <span class="sidebar-text">Article</span>
                    </div>
                </li>
            </a>
            <p>PO</p>
            <a href="{{ route('admin.po.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.po.*') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.po.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span class="sidebar-text">Order</span>
                    </div>
                </li>
            </a>
            <a href="{{ route('admin.custom.index') }}" class="text-decoration-none">
                <li
                    class="mb-3 neumorphic-card sidebar-item {{ request()->routeIs('admin.custom.*') ? 'active' : '' }}">
                    <div
                        class="d-flex align-items-center neu-text gap-2 sidebar-button {{ request()->routeIs('admin.custom.*') ? 'active' : '' }}">
                        <i class="fas fa-palette"></i>
                        <span class="sidebar-text">Custom Design</span>
                    </div>
                </li>
            </a>
        </ul>
    </nav>
</aside>
