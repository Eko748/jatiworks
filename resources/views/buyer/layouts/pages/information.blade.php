@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5" style="min-height: 100vh">
            <h4 class="fw-bold text-old-blue">{{ __('localization.disclosure') }}</h4>
            <h6 class="text-old-blue mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo
                consectetur natus aliquid delectus nisi eos nemo quas rem tempora molestias. Corporis, tempora est! Aliquam
                libero suscipit minus laboriosam voluptas? Dignissimos!</h6>
            <div class="card shadow-sm bg-old-blue-tri card-radius h-100 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-2 text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero,
                        blanditiis.</h4>
                    <div class="d-flex align-items-center">
                        <span class="h6 bi bi-calendar-range text-old-blue"></span>
                        <h6 class="text-old-blue ms-2 fw-bold">{{ \Carbon\Carbon::parse('2025-01-05')->translatedFormat(__('j F Y')) }}</h6>
                    </div>
                    <h6 class="mb-3 text-old-blue">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum soluta
                        tempora
                        earum iste
                        perspiciatis consectetur exercitationem blanditiis distinctio fugiat provident, repellendus
                        ea.
                        Fugiat quaerat, ut asperiores modi dolor labore facere!</h6>
                    <div class="mb-3 text-end d-grid">
                        <button class="btn btn-outline-old-blue fw-bold px-4 py-2"> <span class="h6 bi bi-download me-2"></span>
                            {{ __('localization.download') }}</button>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm bg-old-blue-tri card-radius h-100 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-2 text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero,
                        blanditiis.</h4>
                    <div class="d-flex align-items-center">
                        <span class="h6 bi bi-calendar-range text-old-blue"></span>
                        <h6 class="text-old-blue ms-2 fw-bold">{{ \Carbon\Carbon::parse('2025-01-03')->translatedFormat(__('j F Y')) }}</h6>
                    </div>
                    <h6 class="mb-3 text-old-blue">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum soluta
                        tempora
                        earum iste
                        perspiciatis consectetur exercitationem blanditiis distinctio fugiat provident, repellendus
                        ea.
                        Fugiat quaerat, ut asperiores modi dolor labore facere!</h6>
                    <div class="mb-3 text-end d-grid">
                        <button class="btn btn-outline-old-blue fw-bold px-4 py-2"> <span class="h6 bi bi-download me-2"></span>
                            {{ __('localization.download') }}</button>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm bg-old-blue-tri card-radius h-100 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-2 text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero,
                        blanditiis.</h4>
                    <div class="d-flex align-items-center">
                        <span class="h6 bi bi-calendar-range text-old-blue"></span>
                        <h6 class="text-old-blue ms-2 fw-bold">{{ \Carbon\Carbon::parse('2025-01-01')->translatedFormat(__('j F Y')) }}</h6>
                    </div>
                    <h6 class="mb-3 text-old-blue">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum soluta
                        tempora
                        earum iste
                        perspiciatis consectetur exercitationem blanditiis distinctio fugiat provident, repellendus
                        ea.
                        Fugiat quaerat, ut asperiores modi dolor labore facere!</h6>
                    <div class="mb-3 text-end d-grid">
                        <button class="btn btn-outline-old-blue fw-bold px-4 py-2"> <span class="h6 bi bi-download me-2"></span>
                            {{ __('localization.download') }}</button>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm bg-old-blue-tri card-radius h-100 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-2 text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero,
                        blanditiis.</h4>
                    <div class="d-flex align-items-center">
                        <span class="h6 bi bi-calendar-range text-old-blue"></span>
                        <h6 class="text-old-blue ms-2 fw-bold">{{ \Carbon\Carbon::parse('2024-12-25')->translatedFormat(__('j F Y')) }}</h6>
                    </div>
                    <h6 class="mb-3 text-old-blue">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum soluta
                        tempora
                        earum iste
                        perspiciatis consectetur exercitationem blanditiis distinctio fugiat provident, repellendus
                        ea.
                        Fugiat quaerat, ut asperiores modi dolor labore facere!</h6>
                    <div class="mb-3 text-end d-grid">
                        <button class="btn btn-outline-old-blue fw-bold px-4 py-2"> <span class="h6 bi bi-download me-2"></span>
                            {{ __('localization.download') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
