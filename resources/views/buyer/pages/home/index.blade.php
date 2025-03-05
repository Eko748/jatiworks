@extends('buyer.layouts.main')

@section('css')
    <style>
        .scrollable-cards {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            white-space: normal;
        }

        #catalogue-data {
            display: flex;
            flex-wrap: nowrap;
        }

        #catalogue-data .card {
            min-width: 280px;
            max-width: 350px;
            flex: 0 0 auto;
        }

        .card-body p {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }
    </style>
@endsection

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
                                    <a href="#" target="_blank"
                                        class="btn btn-light fw-bold text-old-blue fs-6 py-2 pulse">
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
    <section id="catalogue-section" class="catalogue-section bg-green-white">
        <div class="container pt-5 pb-5">
            <h3 class="heading fw-bold">Our Collection</h3>
            <h6 class="subtitle h6 mb-5">Explore Our Collection: Timeless Craftsmanship, Global Quality</h6>
            <div class="scrollable-cards overflow-x-auto">
                <div id="catalogue-data" class="d-inline-flex gap-3">
                </div>
            </div>
        </div>
    </section>
    <section id="why-ailand" class="bg-green-young">
        <div class="container pt-5 pb-5">
            <div class="section-header">
                <h3 class="fw-bold text-old-blue mb-5">Why Jatiworks? The Smart Choice for Furniture Sourcing</h3>
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
                                <span class="bi bi-cash-stack h2 text-old-blue" data-icon="uiw:safety"></span>
                                <h5 class="fw-bold text-old-blue mb-2 ms-2">
                                    Competitive Pricing
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
                <h6 class="text-old-blue mb-5">Crafting Quality, Empowering Communities</h6>
            </div>
            <div class="scrollable-cards">
                <div id="article-data" class="d-inline-flex gap-3">
                </div>
            </div>
        </div>
    </section>
    <section class="section-dark">
        <div class="container d-flex align-items-center justify-content-center pt-5 pb-5" style="min-height: 60vh;">
            <div class="row w-100">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="fw-bold text-white">Stay In Touch with <br class="d-md-none">Jatiworks</h3>
                    <h6 class="text-white">Get The Latest Informations</h6>
                    <h6 class="text-white">Sent Directly to Your Email !</h6>
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
        let defaultLimitPage1 = 10
        let currentPage1 = 1
        let totalPage1 = 1
        let defaultAscending1 = 0
        let defaultSearch1 = ''
        let customFilter1 = {}
        let storageUrlCatalogue = '{{ asset('storage/uploads/katalog') }}'

        async function getListDataCatalogue(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            let getDataRest = await restAPI('GET', '{{ route('datakatalog') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListDataCatalogue(item))
                )
                await setListDataCatalogue(handleDataArray, getDataRest.data.pagination)
            } else {
                let errorMessage = "Data gagal dimuat";
                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;
                }
            }
        }

        async function handleListDataCatalogue(data) {
            return {
                id: data?.id ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                unit: data?.unit ?? '-',
                weight: data?.weight ?? '-',
                dimensions: `${data?.length ?? '-'} x ${data?.width ?? '-'} x ${data?.height ?? '-'}`,
                category: data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-',
                images: data?.file.length ? data.file.map(f => f.file_name) : []
            };
        }

        async function setListDataCatalogue(dataList, pagination) {
            totalPage1 = pagination.total_pages;
            currentPage1 = pagination.current_page;

            let getDataHtml = '';
            dataList.forEach((element) => {
                let carouselId = `carousel${element.id}`;
                let imageCarousel = element.images.length ? `
                <div class="position-relative w-100">
                    <div class="ribbon ribbon-top-right" style="position: absolute; top: -8px; right: -8px; z-index: 10;">
                        <span>New</span>
                    </div>
                    <div id="${carouselId}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                        <div class="carousel-inner">
                            ${element.images.map((img, i) => `
                                                                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                                                <img src="${storageUrlCatalogue}/${img}" class="d-block w-100 card-radius" style="height: 200px; object-fit: cover;">
                                                                            </div>
                                                                        `).join('')}
                        </div>
                        ${element.images.length > 1 ? `
                                                                        <button class="text-dark carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev" style="position: absolute; z-index: 10;">
                                                                            <i class="fas fa-circle-chevron-left fs-3"></i>
                                                                        </button>
                                                                        <button class="text-dark carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next" style="position: absolute; z-index: 10;">
                                                                            <i class="fas fa-circle-chevron-right fs-3"></i>
                                                                        </button>
                                                                    ` : ''}
                    </div>
                </div>
                ` : '-';

                getDataHtml += `
                <div class="card shadow-smooth bg-green-old card-radius w-100 overflow-hidden">
                    <div class="card-body d-flex flex-column">
                        ${imageCarousel}

                        <div class="mt-2">
                            <h5 class="fw-bold text-white mb-2 mb-md-0 text-truncate" style="word-break: break-word; overflow-wrap: break-word; max-width: 100%;">
                                ${element.item_name}
                            </h5>
                        </div>
                        <hr class="my-0 mb-2 mt-1 text-white">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                            <p class="h6 fw-bold text-white mb-0 flex-grow-1" style="word-break: break-word; max-width: 100%;">
                                Material: ${element.material}
                            </p>
                        </div>

                        <div class="text-white mt-3">
                            <p class="fw-bold mb-1">Dimensions & Weight:</p>
                            <div class="d-grid gap-1" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));">
                                <div>📏 Length: <span class="fw-bold">${element.dimensions.split(' x ')[0]}${element.unit}</span></div>
                                <div>📐 Width: <span class="fw-bold">${element.dimensions.split(' x ')[1]}${element.unit}</span></div>
                                <div>📏 Height: <span class="fw-bold">${element.dimensions.split(' x ')[2]}${element.unit}</span></div>
                                <div>⚖️ Weight: <span class="fw-bold">${element.weight}kg</span></div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p class="fw-bold text-white mb-1">Category:</p>
                            <div class="d-flex flex-wrap gap-1">
                                ${element.category.split(', ').map(cat => `<span class="badge bg-light text-dark">${cat}</span>`).join('')}
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex flex-wrap gap-1 justify-content-end">
                                <a href="{{ route('index.catalogue.detail') }}?r=${element.id}" class="btn btn-sm btn-success">Read More...</a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            document.getElementById('catalogue-data').innerHTML = getDataHtml;

            document.querySelectorAll('.carousel').forEach(carousel => {
                let bsCarousel = new bootstrap.Carousel(carousel, {
                    interval: 2000,
                    ride: 'carousel'
                });
                bsCarousel.cycle();
            });
        }

        async function initPageLoad() {
            await Promise.all([
                getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1,
                    customFilter1),
                getListDataArticle(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2,
                    customFilter2),
            ])
        }
    </script>

    <script>
        let defaultLimitPage2 = 10
        let currentPage2 = 1
        let totalPage2 = 1
        let defaultAscending2 = 0
        let defaultSearch2 = ''
        let customFilter2 = {}
        let storageUrlArticle = '{{ asset('storage/uploads/article') }}'
        let globalDataListArticle = [];

        async function getListDataArticle(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            let getDataRest = await restAPI('GET', '{{ route('dataarticle') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListDataArticle(item))
                )
                await setListDataArticle(handleDataArray, getDataRest.data.pagination)
            } else {
                let errorMessage = "Data gagal dimuat";
                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;
                }
            }
        }

        async function handleListDataArticle(data) {
            return {
                id: data?.id ?? '-',
                title: data?.title ?? '-',
                desc: data?.desc ?? '-',
                status: data?.status ?? '-',
                images: data?.file_name ?? ''
            };
        }

        async function setListDataArticle(dataList, pagination) {
            globalDataListArticle = dataList;
            totalPage2 = pagination.total_pages;
            currentPage2 = pagination.current_page;

            let getDataHtml = '';
            dataList.forEach((element, index) => {
                let shortDesc = element.desc.length > 100 ? element.desc.substring(0, 100) + '...' : element
                    .desc;
                let isLongText = element.desc.length > 100;

                getDataHtml += `
                <div class="card-w d-flex flex-column">
                    <img src="${storageUrlArticle}/${element.images}" alt=""
                        class="img-fluid rounded-4">
                    <div class="card mx-2 rounded-4 d-flex flex-column h-100"
                        style="margin-top: -6rem; z-index: 4; position: relative; min-height: 100px;">
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h6 class="fw-bold text-old-blue">${element.title}</h6>
                            <p class="m-0 desc" id="desc-${index}">
                                ${shortDesc}
                            </p>
                            ${isLongText ? `
                                    <div class="mt-auto text-end">
                                        <button class="btn btn-link p-0" id="toggle-${index}" onclick="toggleReadMore(${index})">Read More..</button>
                                    </div>` : ''}
                        </div>
                    </div>
                </div>`;
            });

            document.getElementById('article-data').innerHTML = getDataHtml;
        }

        function toggleReadMore(index) {
            let descElement = document.getElementById(`desc-${index}`);
            let buttonElement = document.getElementById(`toggle-${index}`);

            if (buttonElement.innerText === "Read More..") {
                descElement.innerText = globalDataListArticle[index].desc;
                buttonElement.innerText = "Read Less..";
            } else {
                descElement.innerText = globalDataListArticle[index].desc.substring(0, 100) + "...";
                buttonElement.innerText = "Read More..";
            }
        }
    </script>
@endsection
