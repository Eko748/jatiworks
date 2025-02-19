<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/img/ail.png') }}" alt="Logo" height="30">
        </a>
        <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-auto" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto ">
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->url() === url('/') ? 'active' : '' }}"
                        href="/">{{ __('localization.home') }}</a>
                </li>
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->url() === url('/investing') ? 'active' : '' }}"
                        href="/investing">{{ __('localization.investing') }}</a>
                </li>
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->url() === url('/publishing') ? 'active' : '' }}"
                        href="/publishing">{{ __('localization.publishing') }}</a>
                </li>
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->url() === url('/trading') ? 'active' : '' }}"
                        href="/trading">{{ __('localization.trading') }}</a>
                </li>
                <li class="nav-item pe-4">
                    <a class="nav-link fw-bold text-old-blue {{ request()->url() === url('/about-us') ? 'active' : '' }}"
                        href="/about-us">{{ __('localization.aboutus') }}</a>
                </li>
                <li class="nav-item pe-4 dropdown">
                    <a class="nav-link dropdown-toggle fw-bold text-old-blue" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('localization.publications') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold text-old-blue" href="/articles">{{ __('localization.article') }} & {{ __('localization.news') }}</a></li>
                        <li><a class="dropdown-item fw-bold text-old-blue" href="/information-disclosure">{{ __('localization.disclosure') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item pe-4 dropdown">
                    <a class="nav-link dropdown-toggle fw-bold text-old-blue" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('localization.informations') }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold text-old-blue" href="/manual-user">{{ __('localization.usermanual') }}</a></li>
                        <li><a class="dropdown-item fw-bold text-old-blue" href="/faq">{{ __('localization.faq') }}</a></li>
                        <li><a class="dropdown-item fw-bold text-old-blue" href="/contact-us">{{ __('localization.contactus') }}</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex" role="search">
                <div class="dropdown-center">
                    <a class="btn border-0 fw-bold dropdown-toggle me-2 py-2" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if (App::getLocale() == 'id')
                            <img src="{{ asset('assets/img/lang/ID.png') }}" alt="">
                        @else
                            <img src="{{ asset('assets/img/lang/GB.png') }}" alt="">
                        @endif
                    </a>
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

                <a class="btn btn-outline-old-blue me-2 py-2 px-3 fw-bold" href="/login">{{ __('localization.startinves') }}</a>
                <a class="btn btn-old-blue py-2 px-3 fw-bold" href="/register">{{ __('localization.starttrad') }}</a>
            </div>
        </div>
</nav>
