<style>
    :root {
        --bg-color: #e0e5ec;
        --bg-color-btn: #1a1a1a;
        --shadow-dark: #b8bcc4;
        --shadow-light: #ffffff;
        --text-color: #333;
        --sidebar-bg: #e0e5ec;
        --sidebar-active: #32CD32;
    }

    .dark-mode {
        --bg-color: #2c2c2c;
        --bg-color-btn: #e0e5ec;
        --shadow-dark: #1a1a1a;
        --shadow-light: #3a3a3a;
        --text-color: #f0f0f0;
        --sidebar-bg: #222;
        --sidebar-active: #32CD32;
    }

    body {
        background: var(--bg-color);
        color: var(--text-color);
    }

    .breadcrumb-text {
        color: var(--text-color);
    }

    .neumorphic-card {
        background: var(--bg-color);
        box-shadow: 8px 8px 15px var(--shadow-dark), -8px -8px 15px var(--shadow-light);
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-button {
        color: var(--bg-color-btn);
        background: var(--bg-color);
        box-shadow: 8px 8px 15px var(--shadow-dark), -4px -8px 15px var(--shadow-light);
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-button:hover {
        color: var(--bg-color);
        background: var(--bg-color-btn);
        box-shadow: 8px 8px 15px var(--shadow-dark), -8px -8px 15px var(--shadow-light);
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-breadcrumb {
        background: var(--bg-color);
        box-shadow: 8px 8px 15px var(--shadow-dark), -8px -8px 15px var(--shadow-light);
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-sidebar {
        background: var(--bg-color);
        box-shadow: 8px 8px 15px var(--shadow-dark), -8px -8px 15px var(--shadow-light);
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-header {
        background: var(--sidebar-bg);
        box-shadow: 8px 8px 15px var(--shadow-dark), 0px -8px 15px var(--shadow-dark);
        transition: all 0.3s ease-in-out;
    }

    .neumorphic-footer {
        background: var(--sidebar-bg);
        box-shadow: 8px 8px 15px var(--shadow-dark), 0px -8px 15px var(--shadow-dark);
        transition: all 0.3s ease-in-out;
    }

    .sidebar {
        height: 100vh;
        display: flex;
        flex-direction: column;
        transition: width 0.3s ease-in-out;
        width: 250px;
        background: var(--sidebar-bg);
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
        background: var(--sidebar-active);
        border-radius: 10px;
        color: white;
    }

    .sidebar-item a {
        color: var(--text-color);
    }

    .sidebar-item.active a {
        font-weight: bold;
        color: white;
    }

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
