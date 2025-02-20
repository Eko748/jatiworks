const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
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

document.getElementById('toggleTheme').addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        this.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
        localStorage.setItem('theme', 'light');
        this.innerHTML = '<i class="fas fa-moon"></i>';
    }
});


document.getElementById('toggleFullscreen').addEventListener('click', function () {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        document.exitFullscreen();
    }
});

function hideTooltip(element) {
    var tooltip = bootstrap.Tooltip.getInstance(element);
    if (tooltip) {
        tooltip.hide();
    }
}

function tooltip() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}
