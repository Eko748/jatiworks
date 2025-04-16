@extends('buyer.layouts.main')

@section('css')
    <style>
        #listData {
            display: flex;
            justify-content: center;
            align-items: start;
            gap: 1rem;
            min-height: 500px;
            width: fit-content;
            margin: auto;
        }

        #listData .card {
            min-width: 250px;
            max-width: 350px;
            flex: 0 0 auto;
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

        .neumorphic-progress {
            display: inline-block;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 1px 1px 3px #b8bcc4, -1px -1px 3px #ffffff;
            padding: 5px;
        }

        .circular-chart {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .circle-bg {
            fill: none;
            stroke: #727272bd;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke-width: 2.8;
            stroke-linecap: round;
            transition: stroke-dasharray 0.6s ease;
        }

        .percentage-text {
            font-size: 0.6em;
            text-anchor: middle;
            dominant-baseline: middle;
        }

        .circular-chart.danger .circle {
            stroke: #dc3545;
        }

        .circular-chart.warning .circle {
            stroke: #ffc107;
        }

        .circular-chart.info .circle {
            stroke: #17a2b8;
        }

        .circular-chart.success .circle {
            stroke: #28a745;
        }
    </style>
@endsection

@section('content')
    <section id="catalogue-section" class="catalogue-section bg-green-white">
        <div class="container pt-5 pb-5">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="heading fw-bold">PO Information</h5>
                    <h6 class="subtitle h6 mb-3" id="noteData"></h6>
                </div>
                <a href="{{ route('index.order.po') }}" type="button" id="toggleFilter" class="filter-data btn-success btn btn-md">
                    <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
                </a>
            </div>
            <div class="neumorphic-card mb-3 bg-green-young card p-3">
                <div id="detail-information" class="row">
                </div>
            </div>
            <hr>
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
            <div class="scrollable-cards">
                <div id="listData" class="d-inline-flex gap-3"></div>
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
        let storageUrl = '{{ asset('storage/uploads/po') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'
        let urlParams = new URLSearchParams(window.location.search);
        let dataParams = urlParams.get('r');

        async function getDetailData() {
            let requestParams = {
                id_po: dataParams,
            };

            let getDataRest = await restAPI('GET', '{{ route('datapodetail') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status === 200 && getDataRest.data && getDataRest.data.data) {
                const data = getDataRest.data.data;
                const fileUrl = data.file ? `${storageUrl}/${data.file}` : null;
                buyer = data.buyer_name;
                id_user = data.id_user;

                let statusMapping = {
                    'Payment Completed': {
                        class: 'text-white bg-success border-success neu-card',
                        icon: '<i class="fas fa-check-circle"></i>',
                        dropdown: false
                    },
                    'Partial Payment': {
                        class: 'text-dark bg-warning border-warning neu-card',
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

                let statusHtml = statusData ?
                    `<div class="badge border px-2 py-1 ${statusData.class}">${statusData.icon} ${data?.status ?? '-'}</div>` :
                    '-';

                const html = `
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-hashtag me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">PO Code:</span>
                                <span>${data.kode_po || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-user-circle me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Buyer Name:</span>
                                <span>${data.buyer_name || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-dollar ms-1 me-2 mt-1"></i>
                            <div class="d-flex gap-3">
                                <div>
                                    <span class="fw-bold d-block">Deposit:</span>
                                    <span>${data.dp || 0}</span>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">Balance:</span>
                                    <span>${data.ba || 0}</span>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">Total:</span>
                                    <span>${data.ta || 0}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-align-left me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Description:</span>
                                <span>${data.desc || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-percent me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Progress:</span>
                                <span>${data.percentage ? renderNeumorphicProgress(data.percentage, 'black') : renderNeumorphicProgress(0, 'black')}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neu-card p-2">
                            <i class="fas fa-chart-simple me-2 mt-1"></i>
                            <div class="mb-2">
                                <span class="fw-bold d-block">Status:</span>
                                <span>${statusHtml || '-'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="neu-card p-2">
                            <span class="fw-bold d-block mb-2"><i class="fas fa-file-pdf me-2"></i>PO File:</span>
                            ${fileUrl ? `
                                                                                <div class="text-center">
                                                                                    <div class="card-body d-flex flex-column align-items-center p-2">
                                                                                        <iframe src="${fileUrl}"
                                                                                            width="100%" height="325px"
                                                                                            style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                                                                        </iframe>
                                                                                        <a href="${fileUrl}" target="_blank"
                                                                                            class="btn btn-sm btn-outline-success mt-3 w-100"
                                                                                            style="text-decoration: none;">
                                                                                            <i class="fas fa-external-link-alt me-1"></i> View PO files in new tabs
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            ` : `<p class="ms-4">No File</p>`}
                        </div>
                    </div>
                `;

                const breadcrumb =
                    `<span class="breadcrumb-text fw-bold"><span class="breadcrumb-separator"> &raquo; ${data.urutan}</span></span>`

                document.getElementById('detail-information').innerHTML = html;
            }
        }

        function renderNeumorphicProgress(value, text) {
            const val = parseInt(value) || 0;
            let color = 'danger';
            if (val > 25 && val <= 50) color = 'warning';
            else if (val > 50 && val <= 75) color = 'info';
            else if (val > 75 && val <= 100) color = 'success';

            return `
                    <div class="neumorphic-progress bg-green-young ${color}">
                        <svg viewBox="0 0 36 36" class="circular-chart ${color}">
                            <path class="circle-bg"
                                d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="circle"
                                stroke-dasharray="${val}, 100"
                                d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <g transform="rotate(90, 18, 18)">
                                <text x="18" y="20.5" class="percentage-text fw-bold ${text}" style="fill: ${text};">${val}%</text>
                            </g>
                        </svg>
                    </div>
                `;
        }

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
                id_po: dataParams,
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
            let images = data?.file.length ? data.file.map(f => `{{ asset('${f.file_name}') }}`) : [imageNullUrl];

            const percentage = data?.percentage ?? 0;

            return {
                id: data?.id ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                item_name: data?.item_name ?? '-',
                code_order: data?.code_order ?? '-',
                percentage: renderNeumorphicProgress(percentage, 'black'),
                qty: data?.qty ?? '-',
                price: data?.price ?? '-',
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
                            <div class="carousel-inner" style="height: 320px;">
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
                <div class="card shadow-smooth bg-green-old card-radius overflow-hidden" style="width: 500px;">
                    <div class="card-body d-flex flex-column">
                        ${imageCarousel}
                        <div class="mt-2">
                            <small class="text-white">Code Order: ${element.code_order}</small>
                            <h5 class="fw-bold text-white mb-2 mb-md-0 text-truncate">
                                ${element.item_name}
                            </h5>
                        </div>
                        <hr class="my-0 mb-2 mt-1 text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-bar-chart h6 me-1 fw-bold text-white"></i>
                                <span class="h6 fw-bold text-white">Progress:</span>
                            </div>
                            <div class="mb-3">${element.percentage}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cash-stack h6 me-1 fw-bold text-white"></i>
                                <span class="h6 fw-bold text-white">Price:</span>
                            </div>
                            <p class="h6 text-dark fw-bold mb-0"><span class="badge text-dark bg-green-young h6"><i class="bi bi-currency-dollar fw-bold text-dark"></i>${element.price}</span></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                                <span class="h6 fw-bold text-white">Qty:</span>
                            </div>
                            <p class="h6 fw-bold mb-0"><span class="badge text-dark bg-green-young h6">${element.qty}</span></p>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex flex-wrap gap-1">
                                <a href="/order/detail/${element.id}" class="btn btn-sm btn-success w-100">Show Details...</a>
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

        async function searchListData() {
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
                getDetailData(),
                getListDataOrder(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1,
                    customFilter1),
                searchListData(),
            ])
        }
    </script>
@endsection
