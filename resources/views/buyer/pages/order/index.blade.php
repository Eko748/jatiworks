@extends('buyer.layouts.main')

@section('css')
    <style>
        .scrollable-cards {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding: 1rem 0;
        }

        #listData {
            display: flex;
            justify-content: center;
            align-items: start;
            gap: 1rem;
            min-height: 300px;
            width: fit-content;
            margin: auto;
        }

        #listData .card {
            min-width: 250px;
            max-width: 300px;
            flex: 0 0 auto;
        }

        /* Pastikan scroll hanya muncul jika perlu */
        .scrollable-cards::-webkit-scrollbar {
            height: 8px;
        }

        .scrollable-cards::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .scrollable-cards::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color);
            pointer-events: none;
        }

        .select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color);
            pointer-events: none;
        }

        .neu-card {
            box-shadow: 2px 2px 5px #b8bcc4, -2px -2px 5px #ffffff;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <section id="catalogue-section" class="catalogue-section bg-green-white">
        <div class="container pt-5 pb-5">
            <h3 class="heading fw-bold">Your Order</h3>
            <h6 class="subtitle h6 mb-3" id="noteData"></h6>
            <div class="d-flex align-items-center gap-1 flex-wrap">
                <div class="d-flex align-items-center gap-1 ms-auto">
                    <div class="position-relative">
                        <select name="limitPage" id="limitPage" class="form-control neumorphic-card me-4">
                            <option value="8">8</option>
                            <option value="16">16</option>
                            <option value="24">24</option>
                        </select>
                        <i class="fas fa-list select-icon"></i>
                    </div>
                    <div class="position-relative">
                        <input id="searchPage" class="tb-search form-control neumorphic-card ps-2 pe-5 w-100 w-sm-auto"
                            type="search" name="search" placeholder="Search Data" aria-label="search"
                            style="max-width: 160px;">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
            </div>
            <hr>
            <div class="scrollable-cards overflow-x-auto">
                <div id="listData" class="d-flex justify-content-center flex-wrap gap-3"></div>
            </div>
            <hr>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-center text-md-start mb-2 mb-md-0">
                    <div class="pagination">
                        <div>Show <span id="countPage">0</span> from <span id="totalPage">0</span> data</div>
                    </div>
                </div>
                <nav class="text-center text-md-end">
                    <ul class="pagination justify-content-center justify-content-md-end neumorphic p-2" id="pagination-js">
                    </ul>
                </nav>
            </div>
        </div>
    </section>
@endsection

@section('assets_js')
@endsection

@section('js')
    <script>
        let defaultLimitPage1 = 8
        let currentPage1 = 1
        let totalPage1 = 1
        let defaultAscending1 = 0
        let defaultSearch1 = ''
        let customFilter1 = {}
        // let storageUrl = ''
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'

        function showErrorMessage(message, type = 'danger', showWhatsApp = false) {
            let catalogueData = document.getElementById("listData");

            let whatsappButton = showWhatsApp ?
                `<div class="mt-3">
                        <a href="https://wa.me/6282217101985?text=Hello,%20I%20am%20interested%20in%20creating%20a%20custom%20design."
                        target="_blank"
                        class="btn btn-success d-flex align-items-center justify-content-center gap-2">
                            <i class="fab fa-whatsapp"></i> Chat us on WhatsApp
                        </a>
                    </div>` :
                '';

            catalogueData.innerHTML = `
                    <div class="alert alert-${type} text-center w-100">
                        ${message}
                        ${whatsappButton}
                    </div>
                `;
        }

        async function getListDataOrder(limit = 8, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                id_user: {{ Auth::user()->id }},
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            let getDataRest = await restAPI('GET', '{{ route('dataorder') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

                if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListDataOrder(item))
                );
                const msg = 'Please click on the show details to view the tracking details of your order.'
                document.getElementById('noteData').innerHTML = msg;
                await setListDataOrder(handleDataArray, getDataRest.data.pagination);
            } else {
                let errorMessage = "Failed to load data";

                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;

                    if (getDataRest.data.id_user === false) {
                        const msg = 'Your history is not found, but you can start your Order right now!';
                        await showErrorMessage(msg, "warning", true);
                        return;
                    }
                }

                await showErrorMessage(errorMessage);
            }
        }

        async function handleListDataOrder(data) {
            let statusMapping = {
                'Payment Completed': {
                    class: 'text-green border-success neumorphic-button',
                    icon: '<i class="fas fa-check-circle"></i>',
                    dropdown: false
                },
                'Waiting for Payment': {
                    class: 'text-info border-info neumorphic-button',
                    icon: '<i class="fas fa-clock"></i>',
                    dropdown: [{
                            text: 'Not Completed',
                            value: 'NC'
                        },
                        {
                            text: 'Payment Completed',
                            value: 'PC'
                        }
                    ]
                },
                'Not Completed': {
                    class: 'text-warning border-warning neumorphic-button',
                    icon: '<i class="fas fa-times-circle"></i>',
                    dropdown: [{
                        text: 'Payment Completed',
                        value: 'PC'
                    }]
                }
            };

            let statusData = statusMapping[data.status] || {
                class: 'text-secondary border-secondary',
                icon: '<i class="fas fa-question-circle"></i>',
                dropdown: false
            };

            let statusHtml = `<span class="${statusData.class}">${statusData.icon} ${data.status}</span>`;
            let images = data?.file.length ? data.file.map(f => `{{ asset('${f.file_name}') }}`) : [imageNullUrl];

            return {
                id: data?.id ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                item_name: data?.item_name ?? '-',
                code_order: data?.code_order ?? '-',
                qty: data?.qty ?? '-',
                price: data?.price ?? '-',
                status: statusHtml,
                images
            };
        }

        async function setListDataOrder(dataList, pagination) {
            totalPage1 = pagination.total_pages;
            currentPage1 = pagination.current_page;
            let display_from = (pagination.per_page * (currentPage1 - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataHtml = '';

            dataList.forEach((element, index) => {
                let carouselId = `carousel${element.id}-${index}`;

                let imageCarousel = element.images.length ? `
                    <div class="position-relative w-100 overflow-hidden">
                        <div id="${carouselId}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" style="height: 300px;">
                                ${element.images.map((img, i) => `
                                                        <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                            <img src="${img}" class="d-block w-100 card-radius" style="height: 100%; object-fit: cover;">
                                                        </div>
                                                    `).join('')}
                            </div>
                            ${element.images.length > 1 ? `
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon"></span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon"></span>
                                                    </button>
                                                ` : ''}
                        </div>
                    </div>
                ` : '-';

                getDataHtml += `
                <div class="card shadow-smooth bg-green-old card-radius overflow-hidden" style="width: 300px;">
                    <div class="card-body d-flex flex-column">
                        ${imageCarousel}
                        <div class="mt-2">
                            <small class="text-white">Code: ${element.code_order}</small>
                            <h5 class="fw-bold text-white mb-2 mb-md-0 text-truncate">
                                ${element.item_name}
                            </h5>
                        </div>
                        <hr class="my-0 mb-2 mt-1 text-white">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-person h6 me-1 fw-bold text-white"></i>
                            <p class="h6 fw-bold text-white mb-0 flex-grow-1">
                                Buyer: ${element.buyer_name}
                            </p>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                            <p class="h6 fw-bold text-white mb-0 flex-grow-1">
                                Qty: ${element.qty}
                            </p>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-currency-dollar h6 me-1 fw-bold text-white"></i>
                            <p class="h6 fw-bold text-white mb-0 flex-grow-1">
                                Price: ${element.price.toLocaleString('id-ID')}
                            </p>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                            <p class="h6 fw-bold text-white mb-0 flex-grow-1">
                                Status: ${element.status}
                            </p>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex flex-wrap gap-1 justify-content-end">
                                <a href="/order/detail/${element.id}" class="btn btn-sm btn-success">Read More...</a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });

            document.getElementById('listData').innerHTML = getDataHtml;
            document.getElementById('totalPage').textContent = pagination.total;
            document.getElementById('countPage').textContent = `${display_from} - ${display_to}`;

            document.querySelectorAll('.carousel').forEach(carousel => {
                new bootstrap.Carousel(carousel, {
                    interval: 2000,
                    ride: 'carousel',
                    pause: false,
                    wrap: true
                });
            });

            renderPage();
        }


        function renderPage() {
            let paginationHtml = '';

            if (currentPage1 > 1) {
                paginationHtml += `
            <button class="paginate-btn prev-btn btn btn-sm btn-outline-success mx-1" data-page="${currentPage1 - 1}">
                <i class="fa fa-circle-chevron-left"></i>
            </button>`;
            }

            let startPage = Math.max(1, currentPage1 - 2);
            let endPage = Math.min(totalPage1, currentPage1 + 2);

            if (startPage > 1) {
                paginationHtml +=
                    `<button class="paginate-btn page-btn btn btn-sm btn-outline-success mx-1" data-page="1">1</button>`;
                if (startPage > 2) {
                    paginationHtml += `
                <button class="btn btn-sm btn-outline-success mx-1" style="pointer-events: none;">
                    <i class="fa fa-ellipsis"></i>
                </button>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
            <button class="paginate-btn page-btn btn btn-sm btn-outline-success mx-1 ${i === currentPage1 ? 'active' : ''}" data-page="${i}">
                ${i}
            </button>`;
            }

            if (endPage < totalPage1) {
                if (endPage < totalPage1 - 1) {
                    paginationHtml += `
                <button class="btn btn-sm btn-outline-success mx-1" style="pointer-events: none;">
                    <i class="fa fa-ellipsis"></i>
                </button>`;
                }
                paginationHtml += `
            <button class="paginate-btn page-btn btn btn-sm btn-outline-success mx-1" data-page="${totalPage1}">
                ${totalPage1}
            </button>`;
            }

            if (currentPage1 < totalPage1) {
                paginationHtml += `
            <button class="paginate-btn next-btn btn btn-sm btn-outline-success mx-1" data-page="${currentPage1 + 1}">
                <i class="fa fa-circle-chevron-right"></i>
            </button>`;
            }

            document.getElementById('pagination-js').innerHTML = paginationHtml;

            document.querySelectorAll('.paginate-btn').forEach(button => {
                button.addEventListener('click', async (e) => {
                    const newPage = parseInt(e.target.closest('button').dataset.page);
                    if (!isNaN(newPage)) {
                        currentPage1 = newPage;
                        await getListDataOrder(defaultLimitPage1, currentPage1, defaultAscending1,
                            defaultSearch1,
                            customFilter1);
                    }
                });
            });
        }

        async function searchListDataCatalogue() {
            document.getElementById('limitPage').addEventListener('change', async function() {
                defaultLimitPage1 = parseInt(this.value);
                currentPage1 = 1;
                await getListDataOrder(defaultLimitPage1, currentPage1, defaultAscending1,
                    defaultSearch1,
                    customFilter1);
            });

            document.querySelectorAll('.tb-search').forEach(input => {
                input.addEventListener('input', debounce(async () => {
                    defaultSearch1 = input.value;
                    currentPage1 = 1;
                    await getListDataOrder(defaultLimitPage1, currentPage1,
                        defaultAscending1, defaultSearch1,
                        customFilter1);
                }, 500));
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        async function initPageLoad() {
            await Promise.all([
                getListDataOrder(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1,
                    customFilter1),
                searchListDataCatalogue(),
            ])
        }
    </script>
@endsection
