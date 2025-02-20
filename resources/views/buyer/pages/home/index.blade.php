@extends('buyer.layouts.main')

@section('content')
    <section class="bg-old-blue-sec">
        <div class="container d-flex align-items-center pt-3 pt-md-5 pb-5">
            <div class="row align-items-center mb-5 h-100">
                <div class="col-md-6 order-last order-md-first" style="position: relative;margin-right:-80px;flex: 1;">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius offset-top">
                        <div class="card-body p-4">
                            <h1 class="mb-3 fw-bold text-white">{{ __('localization.home-content.section-one.title') }}</h1>
                            <h6 class="mb-4 text-white">{{ __('localization.home-content.section-one.subtitle') }}
                            </h6>
                            <div class="row mt-auto">
                                <div class="d-grid col-md-6 mb-3">
                                    <a href="https://wa.me/6282111780074?text=Hello,%20I%20am%20interested%20in%20investing.%20Please%20provide%20more%20information."
                                        target="_blank" class="btn btn-light fw-bold text-old-blue fs-6 py-2">
                                        {{ __('localization.startinves') }}
                                    </a>
                                </div>
                                <div class="d-grid col-md-6 mb-3">
                                    <a href="https://youtu.be/nqqZ4lUkMYM?si=U099j8UC0MUT3n5j"
                                        class="btn btn-light fw-bold text-old-blue fs-6 py-2 pulse">
                                        <i class="bi bi-play-circle "></i>
                                        {!! __('localization.whatis') !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-first order-md-last mb-3">
                    <img src="{{ asset('assets/img/sec2.png') }}" alt="" class="img-fluid card-radius float-end">
                </div>
            </div>

        </div>
    </section>
    <section class="bg-old-blue-sec">
        <div class="container pb-5">
            <h4 class="fw-bold mb-3 text-old-blue text-center">{{ __('localization.partner') }}</h4>
            <div id="splide-3" class="splide grayscale">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/bc.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/rs.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/rattanforlife.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/scn-logo.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/scn-reality.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/gis.png') }}" alt="" class="img-fluid">
                        </li>
                        <li class="splide__slide pb-2 me-5">
                            <img src="{{ asset('assets/img/selaras-logo.png') }}" alt="" class="img-fluid">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="features" class="bg-old-blue-tri">
        <div class="container pt-5 pb-5">
            <h3 class="fw-bold">{{ __('localization.home-content.section-two.title') }}</h3>
            <h6 class="subtitle h6 mb-5">{{ __('localization.home-content.section-two.subtitle') }}</h6>

            <div class="row g-4">
                <!-- Feature Card 1 -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-geo-fill h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">{{ __('localization.home-content.section-two.card-one.title') }}</h4>
                            </div>
                            <p class="h6 mb-5 text-white">{!! __('localization.home-content.section-two.card-one.content') !!}</p>
                            <div class="mt-auto">
                                <a href="/detail-solution" class="btn btn-light text-old-blue fw-bold float-end">{{ __('localization.readmore') }}
                                    <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Feature Card 2 -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-bank h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">{{ __('localization.home-content.section-two.card-two.title') }}</h4>
                            </div>
                            <p class="h6 mb-5 text-white">{!! __('localization.home-content.section-two.card-two.content') !!}</p>
                            <div class="mt-auto">
                                <a href="/detail-solution" class="btn btn-light text-old-blue fw-bold float-end">{{ __('localization.readmore') }}
                                    <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Feature Card 3 -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-bar-chart-line-fill h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">{{ __('localization.home-content.section-two.card-three.title') }}</h4>
                            </div>
                            <p class="h6 mb-5 text-white">{!! __('localization.home-content.section-two.card-three.content') !!}</p>
                            <div class="mt-auto">
                                <a href="/detail-solution" class="btn btn-light text-old-blue fw-bold float-end">{{ __('localization.readmore') }}
                                    <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="investments-section" class="bg-old-blue-sec">
        <div class="container pt-5 pb-5">
            <h3 class="heading fw-bold">{{ __('localization.home-content.section-three.title') }}</h3>
            <h6 class="subtitle h6 mb-5">{{ __('localization.home-content.section-three.subtitle') }}</h6>
            <div class="scrollable-cards">
                <div class="d-inline-flex gap-3">
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 card-w">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">PT CIGEDE GRIYA PERMAI </h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">14 -
                                        Day</span></span>
                                <a href="/detail-invest" class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-smooth bg-old-blue-pri card-radius h-100 card-w">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/cigede-group.png') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">PT Fajri</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Karawang</p>
                            </div>
                            <div class="d-flex justify-content-between text-white">
                                <p class="fw-bold text-white">Achieved<br><span class="text-white">Rp.-</p>
                                <p class="fw-bold text-white">Target<br><span class="text-white fw-bold">Rp.
                                        80.000.000.000</span>
                                </p>
                            </div>
                            <div class="progress mb-5" role="progressbar" aria-label="Example with label"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: 50%">50%</div>
                            </div>
                            <div class="d-flex justify-content-between mt-auto text-white">
                                <span class="time">Time Remaining<br><span style="font-weight: 600;">10 -
                                        Day</span></span>
                                <a href="/detail-invest" class="btn btn-light fw-bold text-old-blue">{{ __('localization.moredetails') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="why-ailand" class=" bg-old-blue-tri">
        <div class="container pt-5 pb-5">
            <div class="section-header">
                <h3 class="fw-bold text-old-blue mb-5">{!! __('localization.home-content.section-four.title') !!}</h3>
                {{-- <div class="section-underline mb-4"></div> --}}
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-shield-check h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">{{ __('localization.home-content.section-four.card-one.title') }}</h>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">{{ __('localization.home-content.section-four.card-one.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-people h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">{{ __('localization.home-content.section-four.card-two.title') }}</h>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">{{ __('localization.home-content.section-four.card-two.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-cpu h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">{{ __('localization.home-content.section-four.card-three.title') }}</h>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">{{ __('localization.home-content.section-four.card-three.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-hdd-network h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">{{ __('localization.home-content.section-four.card-four.title') }}</h>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">{{ __('localization.home-content.section-four.card-four.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-person-gear h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">{{ __('localization.home-content.section-four.card-five.title') }}</h>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">{{ __('localization.home-content.section-four.card-five.content') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="bg-old-blue-sec">
        <div class="container pt-5 pb-5">
            <h1 class="fw-bold text-old-blue">Testimoni</h1>
            <h5 class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis perferendis atque, optio
                iusto natus, provident!</h5>
        </div>
        <div class="container-fluid">
            <div id="splide-1" class="splide mb-3">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="splide-2" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide pb-2">
                            <div class="card card-radius h-100 shadow-smooth bg-old-blue-tri border-0 me-3">
                                <div class="card-body">
                                    <div class="d-flex mb-2 align-items-center">
                                        <img src="{{ asset('assets/img/guide.png') }}" alt=""
                                            class="rounded me-2" height="30">
                                        <h5 class="fw-bold text-old-blue">John Doe</h5>
                                    </div>
                                    <p class="fw-bold text-old-blue">Lorem ipsum dolor sit amet consectetur, adipisicing
                                        elit. Nisi omnis
                                        repudiandae id dolorem voluptate excepturi aliquam odio doloribus, ullam similique
                                        dolore incidunt maiores cupiditate neque reprehenderit ratione quis assumenda
                                        laborum.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="splide-3" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>
                        <li class="splide__slide pb-2">
                            <img src="{{ asset('assets/img/logoailandid.png') }}" alt="">
                        </li>

                    </ul>
                </div>
            </div>
        </div>

    </section> --}}
    <section id="articles-section" class="bg-old-blue-sec">
        <div class="container pb-5 pt-5">
            <div class="section-header">
                <h3 class="fw-bold text-old-blue">{{ __('localization.home-content.section-five.title') }}</h3>
                <h6 class="text-old-blue mb-5">{{ __('localization.home-content.section-five.subtitle') }}</h6>
            </div>
            <div class="scrollable-cards">
                <div class="d-inline-flex gap-3">
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/article-1.jpg') }}" alt="" class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">{{ \Carbon\Carbon::parse('2025-01-05')->translatedFormat(__('j F Y')) }}</h6>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-old-blue">Investing in Land: A Guide for Beginners</h2>
                                    <div class="mt-auto pt-3">
                                        <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                            <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/article-2.jpg') }}" alt="" class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">{{ \Carbon\Carbon::parse('2025-01-03')->translatedFormat(__('j F Y')) }}</h6>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-old-blue">Unlocking Profits in Land Investment: Smart Tips and
                                    Tricks for 2025</h2>
                                    <div class="mt-auto pt-3">
                                        <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                            <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/article-3.jpg') }}" alt="" class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">{{ \Carbon\Carbon::parse('2025-01-01')->translatedFormat(__('j F Y')) }}</h6>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property Investments:
                                    Which is More Profitable?</h2>
                                    <div class="mt-auto pt-3">
                                        <a href="/detail-article" class="fw-bold text-decoration-none h6 text-old-blue">
                                            <span class="border-bottom border-old-blue">{{ __('localization.read') }}</span> {{ __('localization.more') }}
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card shadow-sm bg-old-blue-sec border-0 card-radius h-100" style="width: 30rem">
                        <div class="card-body p-3 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-1.jpg') }}" class="card-img-top card-radius"
                                alt="Turn Key Real Estate Investing">
                            <h5><span class="badge bg-old-blue-pri"
                                    style="margin-top: -1.5rem; z-index: 4; position: relative;float: right;margin-right:1rem;">21
                                    <br>DES</span></h5>
                            <h6 class="fw-bold text-old-blue">Investing in Land: A Guide for Beginners</h2>
                                <p class="text-old-blue">Land is a valuable asset that can appreciate in value over time.
                                    It can also provide a steady stream of income through rental properties or other uses.
                                    If you are considering investing in land, there are a few things you should keep in
                                    mind.
                                </p>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue float-end">
                                        {{ __('localization.readmore') }}
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                        </div>
                    </div>
                    <div class="card shadow-sm bg-old-blue-sec border-0 ms-4 card-radius h-100" style="width: 30rem">
                        <div class="card-body p-3 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-2.jpg') }}" class="card-img-top card-radius"
                                alt="Turn Key Real Estate Investing">
                            <h5><span class="badge bg-old-blue-pri"
                                    style="margin-top: -1.5rem; z-index: 4; position: relative;float: right;margin-right:1rem;">21
                                    <br>DES</span></h5>
                            <h6 class="fw-bold text-old-blue">Unlocking Profits in Land Investment: Smart Tips and Tricks
                                for 2025</h2>
                                <p class="text-old-blue">Land investment remains a popular strategy for generating
                                    long-term wealth. However, like any investment, it's crucial to understand the inherent
                                    risks and opportunities before diving in. This article explores key tips and tricks for
                                    successful land investment in 2024, addressing potential challenges and offering
                                    strategies to overcome them.
                                </p>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue float-end">
                                        {{ __('localization.readmore') }}
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                        </div>
                    </div>
                    <div class="card shadow-sm bg-old-blue-sec border-0 ms-4 card-radius h-100" style="width: 30rem">

                        <div class="card-body p-3 d-flex flex-column">
                            <img src="{{ asset('assets/img/article-3.jpg') }}" class="card-img-top card-radius"
                                alt="Turn Key Real Estate Investing">
                            <h5><span class="badge bg-old-blue-pri"
                                    style="margin-top: -1.5rem; z-index: 4; position: relative;float: right;margin-right:1rem;">21
                                    <br>DES</span></h5>
                            <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property Investments:
                                Which is More Profitable?</h2>
                                <p class="text-old-blue">Investing in real estate offers diverse avenues for wealth
                                    creation, but choosing the right type of property is crucial. Two popular options are
                                    land investment and investing in developed properties like houses, apartments, or
                                    commercial buildings. This article delves into a detailed comparison of these two
                                    investment strategies, examining their respective advantages, disadvantages, and
                                    suitability for different investor profiles.
                                </p>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue float-end">
                                        {{ __('localization.readmore') }}
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/article-1.jpg') }}" alt="" class="img-fluid rounded-4">
                    <div class="card mx-3 rounded-4" style="margin-top: -8rem; z-index: 4; position: relative;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-old-blue">News</h6>
                                <div class="d-flex align-items-center">
                                    <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                    <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                </div>
                            </div>
                            <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property Investments:
                                Which is More Profitable?</h2>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue">
                                        <span class="border-bottom border-old-blue">READ</span> MORE
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/article-2.jpg') }}" alt="" class="img-fluid rounded-4">
                    <div class="card mx-3 rounded-4" style="margin-top: -8rem; z-index: 4; position: relative;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-old-blue">News</h6>
                                <div class="d-flex align-items-center">
                                    <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                    <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                </div>
                            </div>
                            <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property Investments:
                                Which is More Profitable?</h2>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue">
                                        <span class="border-bottom border-old-blue">READ</span> MORE
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/img/article-3.jpg') }}" alt="" class="img-fluid rounded-4">
                    <div class="card mx-3 rounded-4" style="margin-top: -8rem; z-index: 4; position: relative;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-old-blue">News</h6>
                                <div class="d-flex align-items-center">
                                    <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                    <h6 class="fw-bold text-old-blue">23 Desember 2024</h6>
                                </div>
                            </div>
                            <h6 class="fw-bold text-old-blue">Comparing Land Investment vs. Other Property Investments:
                                Which is More Profitable?</h2>
                                <div class="mt-auto pt-5">
                                    <a href="/detail-article"
                                        class="fw-bold text-decoration-none h6 text-old-blue">
                                        <span class="border-bottom border-old-blue">READ</span> MORE
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    {{-- <section class="faq-section bg-old-blue-sec">
        <div class="container pt-5 pb-5">
            <!-- Header -->
            <div class="mb-5">
                <h1 class="heading mb-3 fw-bold">FAQs</h1>
                <h5 class="subtitle">
                    Quick Answers to Your Questions. Find the solutions and information you need through frequently
                    asked questions.
                </h5>
            </div>

            <div class="accordion" id="faqAccordionLeft">
                <div class="row">
                    <div class="col-md-6">
                        <!-- FAQ Item 1 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false"
                                    aria-controls="collapse1">
                                    What's AILAND.id?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">Ailand.id is an Indonesian P2P lending platform for
                                        buying and
                                        selling land/property, present in Indonesia to bring together people with low to
                                        middle capital with people who sell land. This is done as an effort to improve
                                        the financial welfare of the community by enjoying the very promising benefits
                                        of land investment.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false"
                                    aria-controls="collapse2">
                                    What's the benefit of using AILAND?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">Ailand.id brings together people who sell land with those
                                        who
                                        want to buy land throughout Indonesia.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false"
                                    aria-controls="collapse3">
                                    What are the land objects offered?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">Land objects listed on the Ailand.id website are objects
                                        registered by the community to Ailand.id to be purchased in mutual cooperation.
                                        The land that we prioritize for sale is land on which there are business
                                        activities that have been running, but it does not rule out the possibility of
                                        land that does not yet have a business and can be empowered by Ailand.id to
                                        generate profits.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false"
                                    aria-controls="collapse4">
                                    Who can buy land at AILAND.id?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                data-bs-parent="#faqAccordionLeft">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">Investors in Ailand.id are all people who have a bank
                                        account, ID
                                        card, and wish to buy land with a minimum purchase set on each land object.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <!-- FAQ Item 5 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false"
                                    aria-controls="collapse5">
                                    How to invest in AILAND?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">
                                        - Open the AiLand.id website<br>
                                        - Select the "Easy Investment" section<br>
                                        - Select the land object that still has remaining slots<br>
                                        - Enter the amount you want to buy, then click "Invest Now!"<br>
                                        - Manual payment method through several banks<br>
                                        - Select the Bank account to be used and the destination Bank Account to
                                        AiLand.id<br>
                                        - Transfer funds according to what we send to your email<br>
                                        - Send proof of transaction to Whatsapp AiLand.id at 08xxx to speed up the
                                        Purchase confirmation process<br>
                                        - Purchase confirmation from AiLand.id which will be sent via email
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 6 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false"
                                    aria-controls="collapse6">
                                    What is the minimum and maximum purchase at AILAND.id?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">You can buy a minimum of each object sold. And we do not
                                        hold a
                                        maximum purchase, but we recommend putting it into several purchase projects if
                                        you want to make a large purchase.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 7 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false"
                                    aria-controls="collapse7">
                                    What is the land price increase expectation?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">The expected increase is the projected increase in land
                                        prices
                                        per year in accordance with indicators of land price increases, neighborhood
                                        price assessments, and interpolation.</p>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 8 -->
                        <div class="accordion-item mb-3 shadow-smooth">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button collapsed fw-semibold text-old-blue" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false"
                                    aria-controls="collapse8">
                                    What is profit expectation?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                data-bs-parent="#faqAccordionRight">
                                <div class="accordion-body">
                                    <p class="mb-0 text-old-blue">The projected profit of the business on the land is the
                                        added
                                        value of the land. So in addition to getting long-term investment benefits,
                                        landowners will get short-term benefits from the business being run. The figures
                                        presented have been analyzed by the AiLand.id Team on existing businesses. The
                                        number of projected profit percentages is NOT the exact number that investors
                                        will get. The projected profit figure is only used as a reference; the actual
                                        profit can be above or below the projected profit analyzed by Ailand.id.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> --}}
    <section class="section-dark">
        <div class="container d-flex align-items-center justify-content-center pt-5 pb-5" style="min-height: 60vh;">
            <div class="row w-100">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="fw-bold text-white">{!! __('localization.home-content.section-six.title') !!}</h3>
                    <h6 class="text-white">{{ __('localization.home-content.section-six.subtitle') }}</h6>
                </div>
                <div class="col-md-6">
                    <form action="">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="{{ __('localization.name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg" placeholder="{{ __('localization.email.title') }}">
                        </div>
                        <div class="form-group float-end">
                            <button class="btn btn-light btn-lg fw-bold text-old-blue">{{ __('localization.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
