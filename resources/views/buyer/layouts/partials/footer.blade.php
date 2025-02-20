<footer class="footer bg-old-blue-pri">
    <div class="container">
        <div class="footer-content">
            <!-- Brand Section -->
            <div class="">
                <img src="{{ asset('assets/img/AILANDS.png') }}" alt="AiLand.id Logo" class="mb-3" height="50">
                <div class="d-flex align-items-center">
                    <a href="#" class="social-link me-4">
                        <span class="bi bi-linkedin h2 text-white"></span>
                    </a>
                    <a href="#" class="social-link me-4">
                        <span class="bi bi-facebook h2 text-white"></span>
                    </a>
                    <a href="https://www.instagram.com/ailand_id/" class="social-link me-4">
                        <span class="bi bi-instagram h2 text-white"></span>
                    </a>
                    <a href="#" class="social-link me-4">
                        <span class="bi bi-youtube h1 text-white"></span>
                    </a>
                    <a href="#" class="social-link me-4">
                        <span class="bi bi-tiktok h2 text-white"></span>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h5 class="footer-title text-white">{{ __('localization.quicklinks') }}</h5>
                <ul class="footer-menu">
                    <li><a href="/" class="text-decoration-none text-white">{{ __('localization.home') }}</a></li>
                    <li><a href="/investing" class="text-decoration-none text-white">{{ __('localization.investing') }}</a></li>
                    <li><a href="/publishing" class="text-decoration-none text-white">{{ __('localization.publishing') }}</a></li>
                    <li><a href="/trading" class="text-decoration-none text-white">{{ __('localization.trading') }}</a></li>
                    <li><a href="/about-us" class="text-decoration-none text-white">{{ __('localization.aboutus') }}</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h5 class="footer-title text-white">{{ __('localization.ouroffice') }}</h5>
                <div class="contact-info">
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-geo-alt me-2 h6"></span>
                        <span class="h6">Jl. Otto Iskandardinata No.52, Plered, Tegalsari, Cirebon</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-envelope me-2 h6"></span>
                        <span class="h6">contact@ailand.id</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 text-white">
                        <span class="bi bi-telephone me-2 h6"></span>
                        <span class="h6">+62 821-1178-0074 (Admin)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="divider"></div>
            <div class="footer-bottom-content ">
                <p class="copyright fw-bold text-white">© 2025 PT AILAND GLOBAL INVESTMENTS <br class="d-md-none"> All rights reserved.</p>
                <div class="legal-links">
                    <a href="/privacy-policy" class="fw-bold text-white">{{ __('localization.privacypolicy') }}</a>
                    <span class="separator fw-bold text-white">|</span>
                    <a href="/term-of-service" class="fw-bold text-white">{{ __('localization.terms') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
