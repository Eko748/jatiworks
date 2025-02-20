@extends('frontend.main')

@section('content')
    <section class="bg-old-blue-sec min-vh-100">
        <div class="container pt-5 pb-5">
            <h4 class="fw-bold text-old-blue ">{{ __('localization.home-content.section-five.title') }}</h4>
            <h6 class="text-old-blue  mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo
                consectetur natus aliquid delectus nisi eos nemo quas rem tempora molestias. Corporis, tempora est! Aliquam
                libero suscipit minus laboriosam voluptas? Dignissimos! Lorem ipsum dolor sit amet consectetur adipisicing
                elit. Unde deserunt, quibusdam veritatis numquam porro ullam sint. Aspernatur libero illo dicta.</h6>
            <div class="d-flex flex-wrap mb-5 align-items-center justify-content-between">
                <ul class="nav nav-underline mb-3" id="newsArticleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-3 fs-6 fw-bold text-old-blue active" id="news-tab" data-bs-toggle="tab"
                            data-bs-target="#news" type="button" role="tab" aria-controls="news"
                            aria-selected="true">{{ __('localization.news') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-3 fs-6 fw-bold text-old-blue" id="article-tab" data-bs-toggle="tab"
                            data-bs-target="#article" type="button" role="tab" aria-controls="article"
                            aria-selected="false">{{ __('localization.article') }}</button>
                    </li>
                </ul>
                <div class="d-flex float-end mb-3">
                    <div class="form-group me-2">
                        <input type="text" placeholder="{{ __('localization.search') }} {{ __('localization.home-content.section-five.title') }}" class="form-control pe-5">
                    </div>
                    <button class="btn btn-old-blue fw-bold">{{ __('localization.search') }}</button>
                </div>
            </div>
            <div class="tab-content" id="newsArticleTabContent">
                <!-- News Tab Content -->
                <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                    <h3 class="text-center">{{ __('localization.articleempty') }}</h3>
                    {{-- <div class="row">
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-1.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">News</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Investing in Land: A Guide for Beginners</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article"
                                                class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-2.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">News</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Unlocking Profits in Land Investment: Smart Tips and
                                        Tricks for 2025</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article"
                                                class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-3.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">News</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property
                                        Investments: Which is More Profitable?</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article"
                                                class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item"><a class="page-link text-old-blue" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">3</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">Next</a></li>
                        </ul>
                    </nav> --}}
                </div>

                <!-- Article Tab Content -->
                <div class="tab-pane fade" id="article" role="tabpanel" aria-labelledby="article-tab">
                    <div class="row">
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-1.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">
                                                {{ \Carbon\Carbon::parse('2025-01-05')->translatedFormat(__('j F Y')) }}
                                            </h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Investing in Land: A Guide for Beginners</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span
                                                    class="border-bottom border-old-blue">{{ __('localization.read') }}</span>
                                                {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-2.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">
                                                {{ \Carbon\Carbon::parse('2025-01-03')->translatedFormat(__('j F Y')) }}
                                            </h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Unlocking Profits in Land Investment: Smart Tips and
                                        Tricks for 2025</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span
                                                    class="border-bottom border-old-blue">{{ __('localization.read') }}</span>
                                                {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-3.jpg') }}" alt="" class="img-fluid rounded-4">
                            <div class="card mx-2 rounded-4 h-100"
                                style="margin-top: -6rem; z-index: 4; position: relative;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                            <h6 class="fw-bold text-old-blue">
                                                {{ \Carbon\Carbon::parse('2025-01-01')->translatedFormat(__('j F Y')) }}
                                            </h6>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property
                                        Investments: Which is More Profitable?</h2>
                                        <div class="mt-auto pt-3">
                                            <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                                <span
                                                    class="border-bottom border-old-blue">{{ __('localization.read') }}</span>
                                                {{ __('localization.more') }}
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item"><a class="page-link text-old-blue" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">3</a></li>
                            <li class="page-item"><a class="page-link text-old-blue" href="#">Next</a></li>
                        </ul>
                    </nav> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
