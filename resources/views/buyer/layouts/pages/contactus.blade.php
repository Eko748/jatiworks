@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5" style="min-height: 100vh">
            <h4 class="fw-bold text-old-blue">{{ __('localization.contactus') }}</h4>
            <h6 class="text-old-blue mb-5">{{ __('localization.contactsub') }}</h6>
            <div class="row g-4">
                <!-- WhatsApp Contact -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-smooth bg-old-blue-tri h-100">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="rounded-circle bg-old-blue-pri text-white p-3 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-whatsapp fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-old-blue mt-3">WhatsApp</h5>
                            <p class="text-old-blue fw-bold text-muted">{{ __('localization.whatsapp.subtitle') }}</p>
                            <p class="text-old-blue fw-bold mb-0">
                                <i class="bi bi-whatsapp me-2"></i>
                                <span class="fw-bold text-old-blue">+62 812 3456
                                    7890</span>
                            </p>
                            <div class="d-grid mt-auto">
                                <a href="https://wa.me/6281234567890" target="_blank"
                                    class="btn fw-bold btn-old-blue mt-3 py-2">
                                    <i class="bi bi-chat-dots me-1"></i> {{ __('localization.whatsapp.hub') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Telephone Contact -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-smooth bg-old-blue-tri h-100">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="rounded-circle bg-old-blue-pri text-white p-3 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-telephone-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-old-blue mt-3">{{ __('localization.phone.title') }}</h5>
                            <p class="text-old-blue fw-bold text-muted">{{ __('localization.phone.subtitle') }}</p>
                            <p class="text-old-blue fw-bold mb-0">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <span class="fw-bold text-old-blue">+62 898 7654
                                    3210</span>
                            </p>
                            <div class="d-grid mt-auto">
                                <a href="tel:+6289876543210" class="btn fw-bold btn-old-blue mt-3 py-2">
                                    <i class="bi bi-telephone me-1"></i> {{ __('localization.phone.hub') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Contact -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-smooth bg-old-blue-tri h-100">
                        <div class="card-body text-center p-4 d-flex flex-column">
                            <div class="rounded-circle bg-old-blue-pri text-white p-3 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-envelope-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-old-blue mt-3">Email</h5>
                            <p class="text-old-blue fw-bold text-muted">{{ __('localization.email.subtitle') }}
                            </p>
                            <p class="text-old-blue fw-bold mb-0">
                                <i class="bi bi-envelope-fill me-2"></i>
                                <span class=" fw-bold text-old-blue">cs@example.com</span>
                            </p>
                            <div class="d-grid mt-auto">
                                <a href="mailto:cs@example.com" class="btn fw-bold btn-old-blue mt-3 py-2">
                                    <i class="bi bi-envelope me-1"></i> {{ __('localization.email.hub') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
