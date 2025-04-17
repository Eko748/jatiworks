@extends('buyer.layouts.main')

@section('css')
    <style>
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

        .pdf-container {
            width: 100%;
            max-height: 400px;
            overflow: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
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

        async function getListDataOrderPO(limit = 8, page = 1, ascending = 0, search = '', customFilter = {}) {
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

            let getDataRest = await restAPI('GET', '{{ route('datapo') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListDataOrderPO(item))
                );
                const msg = 'Please click on the show list order to view details of your orders.'
                document.getElementById('noteData').innerHTML = msg;
                await setListDataOrderPO(handleDataArray, getDataRest.data.pagination);
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

        async function handleListDataOrderPO(data) {
            let statusMapping = {
                'Payment Completed': {
                    class: 'text-dark bg-green-young border-success neumorphic-card2',
                    icon: '<i class="fas fa-check-circle"></i>',
                    dropdown: false
                },
                'Partial Payment': {
                    class: 'text-dark bg-warning border-warning neumorphic-card2',
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

            let statusHtml = `<span class="badge ${statusData.class}">${statusData.icon} ${data.status}</span>`;

            const percentage = data?.percentage ?? 0;

            return {
                id: data?.id ?? '-',
                id_encrypt: data?.id_encrypt ?? '-',
                percentage: data?.percentage ?? '-',
                code: data?.kode_po ?? '-',
                id_user: data?.id_user ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                desc: data?.desc ?? '-',
                dp: data?.dp ?? '-',
                percentage: renderNeumorphicProgress(percentage, 'black'),
                file: data.file,
                status: statusHtml
            };
        }

        async function setListDataOrderPO(dataList, pagination) {
            totalPage1 = pagination.total_pages;
            currentPage1 = pagination.current_page;
            let display_from = (pagination.per_page * (currentPage1 - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataHtml = '';

            dataList.forEach((element, index) => {
                let globalIndex = pagination.total - ((currentPage1 - 1) * pagination.per_page) - index;
                let shortDesc = element.desc.length > 40 ? element.desc.substring(0, 40) + "..." : element.desc;

                let fileContent = '-';
                if (element.file) {
                    if (element.file.endsWith('.pdf')) {
                        const fileUrl = `${storageUrl}/${element.file}`;
                        const canvasId = `pdf-canvas-${index}`;
                        const isMobile = window.innerWidth <= 768;

                        const scrollContainerStyle = `
                            <div class="pdf-container" style="max-height: 300px; overflow-y: auto;">
                                <canvas id="${canvasId}" style="width: 100%;"></canvas>
                            </div>
                        `;

                        if (isMobile) {
                            fileContent = `
                                <div class="neumorphic-card card shadow-sm text-center">
                                    <div class="card-body d-flex flex-column align-items-center p-2">
                                        ${scrollContainerStyle}
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success mt-3 w-100">
                                            <i class="fas fa-external-link-alt me-1"></i> View PO files in new tab
                                        </a>
                                    </div>
                                </div>
                            `;
                            setTimeout(() => {
                                renderPdfToCanvas(fileUrl,
                                    canvasId);
                            }, 0);
                        } else {
                            fileContent = `
                                <div class="neumorphic-card card shadow-sm text-center">
                                    <div class="card-body d-flex flex-column align-items-center p-2">
                                        <iframe src="${fileUrl}" width="100%" height="270px" style="border: 1px solid #ccc; border-radius: 8px;"></iframe>
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success mt-3 w-100">
                                            <i class="fas fa-external-link-alt me-1"></i> View PO files in new tab
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                    }
                }

                getDataHtml += `
                <div class="card shadow-smooth bg-green-old card-radius overflow-hidden" style="width: 500px;">
                    <div class="card-body d-flex flex-column">
                        ${fileContent}
                        <div class="mt-2 flex">
                            <small class="text-white">PO Code: ${element.code}</small>
                            <h5 class="fw-bold text-white mb-2 mb-md-0 text-truncate">
                                PO #${globalIndex}
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
                                <i class="bi bi-credit-card h6 me-1 fw-bold text-white"></i>
                                <span class="h6 fw-bold text-white">Status:</span>
                            </div>
                            <p class="h6 fw-bold text-white mb-0">${element.status}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cash-stack h6 me-1 fw-bold text-white"></i>
                                <span class="h6 fw-bold text-white">DP:</span>
                            </div>
                            <p class="h6 fw-bold text-dark mb-0"><span class="badge bg-green-young text-dark h6"><i class="bi bi-currency-dollar fw-bold text-dark"></i>${element.dp}</span></p>
                        </div>
                        <div class="mt-3">
                            <p class="fw-bold text-white mb-1">Description:</p>
                            <p class="text-white desc-short"
                                data-full="${element.desc}"
                                data-short="${shortDesc}"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                ${shortDesc}
                            </p>
                            ${element.desc.length > 20 ? `
                                        <button class="btn btn-link btn-sm text-white toggle-desc" data-id="${index}">Read More</button>
                                    ` : ''}
                        </div>
                        <div class="mt-3">
                            <div class="d-flex flex-wrap gap-1">
                                <a href="/order?r=${element.id_encrypt}" class="btn btn-sm btn-success w-100">Show List Order</a>
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

        function renderPdfToCanvas(fileUrl, canvasId) {
            const loadingTask = pdfjsLib.getDocument(fileUrl);
            loadingTask.promise.then(pdf => {
                const canvas = document.getElementById(canvasId);
                const ctx = canvas.getContext('2d');

                let renderPages = [];

                for (let i = 1; i <= pdf.numPages; i++) {
                    renderPages.push(
                        pdf.getPage(i).then(page => {
                            const viewport = page.getViewport({
                                scale: 1.5
                            });
                            const tempCanvas = document.createElement("canvas");
                            const tempCtx = tempCanvas.getContext("2d");
                            tempCanvas.width = viewport.width;
                            tempCanvas.height = viewport.height;

                            return page.render({
                                canvasContext: tempCtx,
                                viewport
                            }).promise.then(() => {
                                const separatorY = tempCanvas.height;
                                tempCtx.beginPath();
                                tempCtx.moveTo(0, separatorY - 1);
                                tempCtx.lineTo(tempCanvas.width, separatorY - 1);
                                tempCtx.lineWidth = 2;
                                tempCtx.strokeStyle = "#000";
                                tempCtx.stroke();

                                return tempCanvas;
                            });
                        })
                    );
                }

                Promise.all(renderPages).then(pages => {
                    const width = pages[0].width;
                    const height = pages.reduce((sum, page) => sum + page.height, 0);

                    canvas.width = width;
                    canvas.height = height;

                    let y = 0;
                    pages.forEach((p, index) => {
                        ctx.drawImage(p, 0, y);
                        y += p.height;

                        if (index < pages.length - 1) {
                            ctx.beginPath();
                            ctx.moveTo(0, y - 1);
                            ctx.lineTo(canvas.width, y - 1);
                            ctx.lineWidth = 2;
                            ctx.strokeStyle = "#000";
                            ctx.stroke();
                        }
                    });
                });
            }).catch(err => {
                console.error('Error loading PDF:', err);
            });
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
                        await getListDataOrderPO(defaultLimitPage1, currentPage1, defaultAscending1,
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
                await getListDataOrderPO(defaultLimitPage1, currentPage1, defaultAscending1,
                    defaultSearch1,
                    customFilter1);
            });

            document.querySelectorAll('.tb-search').forEach(input => {
                input.addEventListener('input', debounce(async () => {
                    defaultSearch1 = input.value;
                    currentPage1 = 1;
                    await getListDataOrderPO(defaultLimitPage1, currentPage1,
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
                getListDataOrderPO(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1,
                    customFilter1),
                searchListData(),
            ])
        }
    </script>
@endsection
