<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/img/public/favicon.png') }}" alt="Logo" height="30">
        </a>
        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-auto" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto ">
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.home.*') ? 'active' : '' }}"
                        href="{{ route('index.home.index') }}">{{ __('localization.home') }}</a>
                </li>
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.catalogue.*') ? 'active' : '' }}"
                        href="{{ route('index.catalogue.index') }}">Catalogue</a>
                </li>
                @guest
                    <li class="nav-item pe-4">
                        <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.order.*') ? 'active' : '' }}"
                            href="{{ route('login.index') }}">Order</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.customdesign.*') ? 'active' : '' }}"
                            href="{{ route('login.index') }}">Custom Design</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item pe-4">
                        <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.order.*') ? 'active' : '' }}"
                            href="{{ route('index.order.po') }}">Order</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="nav-link fw-bold text-old-blue {{ request()->routeIs('index.customdesign.*') ? 'active' : '' }}"
                            href="{{ route('index.customdesign.index') }}">Custom Design</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="nav-link fw-bold text-old-blue {{ request()->url() === route('profile.index') ? 'active' : '' }}"
                            href="{{ route('profile.index') }}">Profile</a>
                    </li>
                @endauth
            </ul>
            <div class="d-flex align-items-center gap-3" role="search">
                <div class="dropdown-center">
                    <ul class="dropdown-menu" style="min-width: auto">
                        <li>
                            <a class="dropdown-item fw-bold text-old-blue"
                                href="{{ route('change.language', ['locale' => 'id']) }}">
                                <img src="{{ asset('assets/img/lang/ID.png') }}" alt="">
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item fw-bold text-old-blue"
                                href="{{ route('change.language', ['locale' => 'en']) }}">
                                <img src="{{ asset('assets/img/lang/GB.png') }}" alt="">
                            </a>
                        </li>
                    </ul>
                </div>

                @guest
                    <a class="btn bg-green-young me-2 py-2 px-3 fw-bold" href="{{ route('login.index') }}"><i
                            class="fas fa-sign-in-alt me-1"></i>Login</a>
                @endguest
                @auth
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('login.logout') }}">
                        @csrf
                        <button type="submit" class="btn bg-green-young fw-bold"><i class="fas fa-sign-out-alt"></i>
                            Logout</button>
                    </form>
                @endauth
            </div>
        </div>
</nav>
