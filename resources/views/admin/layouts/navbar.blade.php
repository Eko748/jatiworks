<nav aria-label="breadcrumb"
    class="p-3 neumorphic-breadcrumb mt-4 mx-4 d-flex justify-content-between align-items-center">
    <div class="breadcrumb-container">
        <a href="{{ route('dashboard.index') }}" class="breadcrumb-text text-decoration-none fw-bold">
            <i class="fas fa-home"></i>
        </a>
        <span class="breadcrumb-separator"> &raquo; </span>
        <span class="breadcrumb-text fw-bold">{{ $title }}</span>
    </div>

    <div class="d-flex gap-2">
        <button id="toggleFullscreen" class="btn neumorphic-button btn-sm p-2" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Fullscreen Mode" onclick="hideTooltip(this)">
            <i class="fas fa-expand"></i>
        </button>

        <button id="toggleTheme" class="btn neumorphic-button btn-sm p-2" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Change Theme" onclick="hideTooltip(this)">
            <i class="fas fa-moon"></i>
        </button>
    </div>
</nav>
