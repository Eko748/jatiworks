<footer class="footer bg-green-old">
    <div class="container">
        <div class="footer-content">
            <div class="">
                <img src="{{ asset('assets/img/public/logo_jatiworks_putih.png') }}" alt="Jatiworks Logo" class="mb-3" height="20">
                <div class="d-flex align-items-center">
                    @php
                        $info = \App\Models\Information::first();
                    @endphp
                    <a href="{{ $info->linkedin ?? '#' }}" class="social-link me-4">
                        <span class="bi bi-linkedin h2 text-white"></span>
                    </a>
                    <a href="{{ $info->facebook ?? '#' }}" class="social-link me-4">
                        <span class="bi bi-facebook h2 text-white"></span>
                    </a>
                    <a href="{{ $info->instagram ?? '#' }}" class="social-link me-4">
                        <span class="bi bi-instagram h2 text-white"></span>
                    </a>
                    <a href="{{ $info->youtube ?? '#' }}" class="social-link me-4">
                        <span class="bi bi-youtube h1 text-white"></span>
                    </a>
                    <a href="{{ $info->tiktok ?? '#' }}" class="social-link me-4">
                        <span class="bi bi-tiktok h2 text-white"></span>
                    </a>
                </div>
            </div>

            <div class="footer-links">
                <h5 class="footer-title text-white">{{ __('localization.quicklinks') }}</h5>
                <ul class="footer-menu">
                    <li><a href="{{ route('index.home.index') }}" class="text-decoration-none text-white">Home</a></li>
                    <li><a href="{{ route('index.catalogue.index') }}" class="text-decoration-none text-white">Catalogue</a></li>
                    @auth
                        <li><a href="{{ route('index.order.index') }}" class="text-decoration-none text-white">Order</a></li>
                        <li><a href="{{ route('index.customdesign.index') }}" class="text-decoration-none text-white">Custom Design</a></li>
                        <li><a href="{{ route('profile.index') }}" class="text-decoration-none text-white">Profile</a></li>
                    @endauth
                </ul>
            </div>

            <div class="footer-contact">
                <h5 class="footer-title text-white">{{ __('localization.ouroffice') }}</h5>
                <div class="contact-info">
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-geo-alt me-2 h6"></span>
                        <span class="h6">{{ $info->address ?? 'Villa Indah Panembahan No. 5, Cirebon' }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-envelope me-2 h6"></span>
                        <span class="h6">{{ $info->email ?? 'support@jatiworks.com' }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-telephone me-2 h6"></span>
                        <span class="h6">{{ $info->phone ?? '+6282217778000' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="divider"></div>
            <div class="footer-bottom-content ">
                <p class="copyright fw-bold text-white">© {{ now()->year }} PT JATI HARAPAN NUSANTARA <br class="d-md-none"> All rights reserved.</p>
                {{-- <div class="legal-links">
                    <a href="/privacy-policy" class="fw-bold text-white">{{ __('localization.privacypolicy') }}</a>
                    <span class="separator fw-bold text-white">|</span>
                    <a href="/term-of-service" class="fw-bold text-white">{{ __('localization.terms') }}</a>
                </div> --}}
            </div>
        </div>
    </div>
</footer>
