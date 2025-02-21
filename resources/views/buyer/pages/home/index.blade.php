@extends('buyer.layouts.main')

@section('content')
    <section class="bg-green-white">
        <div class="container d-flex align-items-center pt-3 pt-md-5 pb-5">
            <div class="row align-items-center mb-5 h-100">
                <div class="col-md-6 order-last order-md-first" style="position: relative;margin-right:-80px;flex: 1;">
                    <div class="card shadow-smooth bg-green-old card-radius offset-top">
                        <div class="card-body p-4">
                            <h3 class="mb-3 fw-bold text-white">
                                Streamlining the furniture supply chain by
                                connecting skilled small-scale Indonesian craftsmen
                                with global markets through technology
                            </h3>
                            <div class="row mt-auto">
                                <div class="d-grid col-md-6 mb-3">
                                    <a href="https://wa.me/6282111780074?text=Hello,%20I%20am%20interested%20in%20investing.%20Please%20provide%20more%20information."
                                        target="_blank" class="btn btn-light fw-bold text-old-blue fs-6 py-2 pulse">
                                        <i class="bi bi-play-circle"></i>
                                        What is <span id="land">Jatiworks?</span>
                                    </a>
                                </div>
                                <div class="d-grid col-md-6 mb-3">
                                    <a href="{{ route('login.index') }}"
                                        class="btn btn-light fw-bold text-old-blue fs-6 py-2">
                                        <i class="fas fa-sign-in"></i>
                                        Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-first order-md-last mb-3">
                    <img src="{{ asset('assets/img/public/home.png') }}" alt=""
                        class="img-fluid card-radius float-end">
                </div>
            </div>
        </div>
    </section>
    <section id="features" class="bg-green-young">
        <div class="container pt-5 pb-5">
            <h3 class="fw-bold">Our Features</h3>
            <h6 class="subtitle h6 mb-5">Seamless Experience, Full Transparency</h6>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-green-old card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-pencil h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">Design Progress Tracking</h4>
                            </div>
                            <p class="mb-5 text-white">
                                Seamlessly monitor each stage, from concept and technical drawings to 3D renderings and
                                product samples.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-green-old card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-gear-wide-connected h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">Production Status Tracking</h4>
                            </div>
                            <p class="mb-5 text-white">
                                Stay updated on the real-time progress of your furniture manufacturing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow-smooth bg-green-old card-radius h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex">
                                <i class="bi bi-cash-stack h4 me-2 text-white"></i>
                                <h4 class="fw-bold text-white">Payment Status</h4>
                            </div>
                            <p class="mb-5 text-white">
                                Stay updated on the real-time progress of your furniture manufacturing.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="investments-section" class="bg-green-white">
        <div class="container pt-5 pb-5">
            <h3 class="heading fw-bold">Our Catalogue</h3>
            <h6 class="subtitle h6 mb-5">Check our catalog which has the design you want</h6>
            <div class="scrollable-cards overflow-x-auto">
                <div class="d-inline-flex gap-3">
                    <div class="card shadow-smooth bg-green-old card-radius h-100 card-w">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/public/catalogue_1.jpg') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Solar Wood Mini House</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Materials: Teak Wood</p>
                            </div>
                            <div class="d-flex flex-column flex-md-row text-white">
                                <div class="me-md-auto">
                                    <p class="fw-bold">Dimensions:</p>
                                    <ul>
                                        <li>Length: 6m</li>
                                        <li>Width: 3m</li>
                                        <li>Height: 4m</li>
                                    </ul>
                                </div>
                                <div class="mt-3 mt-md-0">
                                    <p class="fw-bold">Category:</p>
                                    <span class="badge bg-light text-dark me-1">Eco-Friendly</span>
                                    <span class="badge bg-light text-dark">Sustainable Housing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-smooth bg-green-old card-radius h-100 card-w">
                        <div class="card-body d-flex flex-column">
                            <div class="image-container position-relative">
                                <div class="ribbon ribbon-top-right"><span>{{ __('localization.new') }}</span></div>
                                <img class="card-img-top card-radius mb-3"
                                    src="{{ asset('assets/img/public/catalogue_2.jpg') }}" alt="Land Image">
                            </div>
                            <h5 class="fw-bold text-white">Minimalis Lamp</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                                <p class="h6 fw-bold text-white">Materials: Teak Wood</p>
                            </div>
                            <div class="d-flex flex-column flex-md-row text-white">
                                <div class="me-md-auto">
                                    <p class="fw-bold">Dimensions:</p>
                                    <ul>
                                        <li>Length: 30cm</li>
                                        <li>Width: 30cm</li>
                                        <li>Height: 60cm</li>
                                    </ul>
                                </div>
                                <div class="mt-3 mt-md-0">
                                    <p class="fw-bold">Category:</p>
                                    <span class="badge bg-light text-dark me-1">Home Decor</span>
                                    <span class="badge bg-light text-dark">Minimalist Design</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="why-ailand" class="bg-green-young">
        <div class="container pt-5 pb-5">
            <div class="section-header">
                <h3 class="fw-bold text-old-blue mb-5">Why Jatiworks is The Best Choice for furniture supply chain ?</h3>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-headset h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    End-to-End Support
                                </h5>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">
                                    Jatiworks handles ordering, production, and delivery for buyers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-check2-circle h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    Sourcing & Quality Assurance
                                </h5>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">
                                    Guaranteed high-quality materials with strict quality control.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-brush h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    Custom Design
                                </h5>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">
                                    Buyers can order furniture designs tailored to their project needs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-boxes h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    Flexible MOQ
                                </h5>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">
                                    Orders can be placed in small or large quantities as needed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-smooth  bg-old-blue-sec border-0" style="border-radius: 15px">
                        <div class="card-body p-4">
                            <div class="feature-icon d-flex align-items-center">
                                <span class="bi bi-boxes h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    Competitive Pricing Without Middlemen
                                </h5>
                            </div>
                            <div class="feature-content">
                                <p class="h6 text-old-blue">
                                    Buyers get better prices by sourcing directly from skilled craftsmen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="articles-section" class="bg-green-white">
        <div class="container pb-5 pt-5">
            <div class="section-header">
                <h3 class="fw-bold text-old-blue">Our Activities</h3>
                <h6 class="text-old-blue mb-5">Activities in supporting and maintaining the quality of all aspects</h6>
            </div>
            <div class="scrollable-cards">
                <div class="d-inline-flex gap-3">
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_1.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">
                                            {{ \Carbon\Carbon::parse('2025-01-05')->translatedFormat(__('j F Y')) }}</h6>
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
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_2.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">
                                            {{ \Carbon\Carbon::parse('2025-01-03')->translatedFormat(__('j F Y')) }}</h6>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-old-blue">Carry out loading of goods by paying attention to the quality of the goods</h2>
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
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_3.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-old-blue">{{ __('localization.article') }}</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="bi bi-calendar-range h6 me-2 text-old-blue"></span>
                                        <h6 class="fw-bold text-old-blue">
                                            {{ \Carbon\Carbon::parse('2025-01-01')->translatedFormat(__('j F Y')) }}</h6>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-old-blue">Shipping activities to various corners of the world</h6>
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
            </div>
        </div>
    </section>
    <section class="section-dark">
        <div class="container d-flex align-items-center justify-content-center pt-5 pb-5" style="min-height: 60vh;">
            <div class="row w-100">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="fw-bold text-white">Stay In Touch with <br class="d-md-none">Jatiworks</h3>
                    <h6 class="text-white">Get The Latest Informations Sent Directly to Your Email !</h6>
                </div>
                <div class="col-md-6">
                    <form action="">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg"
                                placeholder="{{ __('localization.name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg"
                                placeholder="{{ __('localization.email.title') }}">
                        </div>
                        <div class="form-group float-end">
                            <button
                                class="btn btn-light btn-lg fw-bold text-old-blue">{{ __('localization.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        let defaultLimitPage = 10
        let currentPage = 1
        let totalPage = 1
        let defaultAscending = 0
        let defaultSearch = ''
        let customFilter = {}
        let storageUrl = '{{ asset('storage') }}'

        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let filterParams = {}

            let getDataRest = await renderAPI(
                'GET',
                '{{ route('getdatakatalog') }}', {
                    page: page,
                    limit: limit,
                    ascending: ascending,
                    search: search,
                    ...filterParams
                }
            ).then(function(response) {
                return response
            }).catch(function(error) {
                let resp = error.response
                return resp
            })

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleData(item))
                )
                await setListData(handleDataArray, getDataRest.data.pagination)
            } else {
                let errorMessage = "Data gagal dimuat";
                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;
                }

                let thElements = document.getElementsByClassName("tb-head")[0].getElementsByTagName("th");
                let thCount = thElements.length;

                let errorRow = '<tr class="neumorphic-tr">' +
                    '<td class="text-center fw-bold" colspan="' + thCount +
                    '"><i class="fas fa-circle-exclamation me-2"></i>' + errorMessage + '</td>' +
                    '</tr>';

                document.getElementById('listData').innerHTML = errorRow;
                document.getElementById('countPage').textContent = "0 - 0";
                document.getElementById('totalPage').textContent = "0";
            }
        }

        async function handleData(data) {
            return {
                id: data?.id ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                dimensions: `${data?.length ?? '-'} x ${data?.width ?? '-'} x ${data?.height ?? '-'}`,
                category: data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-',
                images: data?.file.length ? data.file.map(f => f.file_name) : []
            };
        }

        async function setListData(dataList, pagination) {
            let totalPage = pagination.total_pages;
            let currentPage = pagination.current_page;
            let display_from = (pagination.per_page * (currentPage - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataTable = '';
            dataList.forEach((element, index) => {
                let imageCarousel = element.images.length ?
                    `
                <div id="carousel${element.id}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        ${element.images.map((img, i) => `
                                                    <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                        <img src="${storageUrl}/${img}" class="d-block w-100" style="max-height: 100px; object-fit: contain;">
                                                    </div>
                                                `).join('')}
                    </div>
                    ${element.images.length > 1 ? `
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                            ` : ''}
                </div>
            ` : '-';

                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td>${imageCarousel}</td>
                    <td>${element.item_name}</td>
                    <td>${element.material}</td>
                    <td>${element.dimensions}</td>
                    <td>${element.category}</td>
                </tr>`;
            });

            document.getElementById('listData').innerHTML = getDataTable;
            document.getElementById('totalPage').textContent = pagination.total;
            document.getElementById('countPage').textContent = `${display_from} - ${display_to}`;
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
            ])
        }
    </script>
@endsection
