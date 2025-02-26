@extends('buyer.layouts.main')

@section('css')
    <style>
        .scrollable-cards {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling di iOS */
        }

        #catalogue-data {
            display: flex;
            flex-wrap: nowrap;
            /* Pastikan item tidak turun ke bawah */
        }

        #catalogue-data .card {
            min-width: 250px;
            /* Atur ukuran minimal kartu agar tetap proporsional */
            max-width: 300px;
            /* Batasi ukuran maksimum agar tidak terlalu besar */
            flex: 0 0 auto;
            /* Pastikan tidak mengecil */
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
                <div class="d-inline-flex gap-3">
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_1.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold text-old-blue">
                                    Empowering Skilled Craftsmen
                                </h6>
                                <p>
                                    Collaborating with small-scale craftsmen while managing buyer orders to ensure seamless
                                    production.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_2.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold text-old-blue">
                                    Upskilling for Global Standards
                                </h6>
                                <p>
                                    Training craftsmen to enhance their craftsmanship and meet international quality
                                    standards.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-w d-flex flex-column">
                        <img src="{{ asset('assets/img/public/activity_3.jpg') }}" alt=""
                            class="img-fluid rounded-4">
                        <div class="card mx-2 rounded-4 h-100" style="margin-top: -6rem; z-index: 4; position: relative;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold text-old-blue">
                                    Seamless Order Fulfillment
                                </h6>
                                <p>
                                    Coordinating shipments to ensure timely and efficient delivery to buyers worldwide.
                                </p>
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

        async function getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1, customFilter1 = {}) {
            let requestParams = {
                page: currentPage1,
                limit: defaultLimitPage1,
                ascending: defaultAscending1,
                ...customFilter1
            };

            if (defaultSearch1.trim() !== '') {
                requestParams.search = defaultSearch1;
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
                getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1, customFilter1),
            ])
        }
    </script>
@endsection
