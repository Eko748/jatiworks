@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('assets_css')
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cropper.min.css') }}">
@endsection

@section('css')
    <style>
        .cropper-container {
            max-width: 100%;
            width: 100%;
            height: auto;
            max-height: 90vh;
            margin: 0 auto;
            overflow: hidden;
        }

        #imagePreview {
            display: block;
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        table,
        tr,
        td {
            overflow: visible !important;
            position: relative;
        }

        .dropdown-menu {
            z-index: 9999;
        }

        .circular-chart {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .circle-bg {
            fill: none;
            stroke: #dad8d8ef;
            stroke-width: 3.8;
        }

        .circle {
            fill: none;
            stroke-width: 2.8;
            stroke-linecap: round;
            transition: stroke-dasharray 0.6s ease;
        }

        .percentage-text {
            fill: var(--text-color);
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

        #pdf-container {
            width: 100%;
            max-height: 400px;
            overflow: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
@endsection

@section('back')
    <a href="{{ route('admin.po.index') }}" class="btn btn-outline-dark neumorphic-button" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Back to PO page" onclick="hideTooltip(this)">
        <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center pb-3 gap-1 flex-wrap">
                <button type="button" class="add-data neumorphic-button btn btn-md" data-bs-toggle="modal"
                    data-bs-target="#addDataModal">
                    <i class="fas fa-circle-plus"></i><span class="d-none d-sm-inline ms-1">Add</span>
                </button>
                <button type="button" id="toggleFilter" class="filter-data neumorphic-button btn btn-md"
                    data-bs-toggle="collapse" data-bs-target="#filterContainer">
                    <i class="fas fa-filter"></i><span class="d-none d-sm-inline ms-1">Filter</span>
                </button>
                <div class="d-flex align-items-center gap-1 ms-auto">
                    <div class="position-relative">
                        <select name="limitPage" id="limitPage" class="form-control neumorphic-card me-4">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
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
            <div id="filterContainer" class="neumorphic-card p-3 mb-3 collapse">
                <form id="filterForm">
                    <div class="row g-3">
                        {{-- <div class="col-md-12">
                            <label for="filterDateRange" class="form-label">Content Date Range</label>
                            <input type="text" class="form-control neumorphic-card" id="filterDateRange"
                                placeholder="Select date range" autocomplete="off" required>
                        </div> --}}
                        <div class="col-md-12 d-flex align-items-end justify-content-end gap-2">
                            <button type="reset" id="resetFilter" class="btn neumorphic-button"><i
                                    class="fas fa-rotate me-1"></i>Reset</button>
                            <button type="submit" id="applyFilter" class="btn neumorphic-button-outline fw-bold"><i
                                    class="fas fa-circle-check me-1"></i>Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="neumorphic-card p-3 mb-3">
                <h5 class="fw-bold">PO Information</h5>
                <hr>
                <div id="detail-information" class="row">
                </div>
            </div>
            <div class="table-responsive neumorphic-card p-3 mb-3">
                <table class="table m-0">
                    <thead>
                        <tr class="tb-head">
                            <th class="text-center text-wrap align-top">No</th>
                            <th class="text-wrap align-top">Progress</th>
                            <th class="text-wrap align-top">Image</th>
                            <th class="text-wrap align-top">Code Order</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Qty</th>
                            <th class="text-wrap align-top">Price</th>
                            <th class="text-wrap align-top">Action</th>
                        </tr>
                    </thead>
                    <tbody id="listData">
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 neumorphic-card">
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
    </div>

    <div class="modal fade" id="addDataModal" tabindex="-1" data-bs-focus="false" aria-labelledby="addDataModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content neumorphic-modal p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="addDataModalLabel">Add New Order</h5>
                    <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                        <label class="card neumorphic-button p-3 text-center flex-grow-1 position-relative">
                            <input type="radio" name="catalogue_option" value="with-catalogue" class="d-none">
                            <h6 class="fw-bold mb-1">With Catalogue</h6>
                            <i class="fas fa-book fa-2x text-info"></i>
                        </label>
                        <label class="card neumorphic-button p-3 text-center flex-grow-1 position-relative">
                            <input type="radio" name="catalogue_option" value="without-catalogue" class="d-none">
                            <h6 class="fw-bold mb-1">Without Catalogue</h6>
                            <i class="fas fa-edit fa-2x text-warning"></i>
                        </label>
                    </div>
                    <hr>
                    <form id="addDataForm">
                        <div id="formContainer"></div>
                    </form>
                </div>
                <div id="btnContainer" class="modal-footer border-0">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/cropper.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
@endsection

@section('js')
    <script>
        let title = '{{ $title }}'
        let defaultLimitPage = 10
        let currentPage = 1
        let totalPage = 1
        let defaultAscending = 0
        let defaultSearch = ''
        let customFilter = {}
        let storageUrl = '{{ asset('storage/uploads/po') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'
        let urlParams = new URLSearchParams(window.location.search);
        let dataParams = urlParams.get('r');
        let id_user = null;
        let buyer = '';

        async function getDetailData() {
            let requestParams = {
                id_po: dataParams,
            };

            loadDetailData('detail-information');

            let getDataRest = await restAPI('GET', '{{ route('admin.po.detail') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status === 200 && getDataRest.data && getDataRest.data.data) {
                const data = getDataRest.data.data;
                const fileUrl = data.file ? `${storageUrl}/${data.file}` : null;
                buyer = data.buyer_name;
                id_user = data.id_user;

                let statusMapping = {
                    'Payment Completed': {
                        class: 'text-green border-success neumorphic-card2',
                        icon: '<i class="fas fa-check-circle"></i>',
                        dropdown: false
                    },
                    'Partial Payment': {
                        class: 'text-warning border-warning neumorphic-card2',
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

                let statusHtml = statusData.dropdown ? `
                <div class="dropdown">
                    <button class="badge border px-2 py-1 ${statusData.class} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${statusData.icon} ${data?.status ?? '-'}
                    </button>
                    <ul class="dropdown-menu">
                        ${statusData.dropdown.map(item => `
                                                                                                                                                        <li><a class="dropdown-item" href="#" onclick="updatePOStatus('${data.id}', '${item.value}')">${item.text}</a></li>
                                                                                                                                                    `).join('')}
                    </ul>
                </div>
            ` :
                    `<div class="badge border px-2 py-1 ${statusData.class}">${statusData.icon} ${data?.status ?? '-'}</div>`;

                const html = `
                    <div class="col-md-6">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-hashtag me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">PO Code:</span>
                                <span>${data.kode_po || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-user-circle me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Buyer Name:</span>
                                <span>${data.buyer_name || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
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
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-align-left me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Description:</span>
                                <span>${data.desc || '-'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-percent me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Progress:</span>
                                <span>${data.percentage ? renderNeumorphicProgress(data.percentage) : renderNeumorphicProgress(0)}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-chart-simple me-2 mt-1"></i>
                            <div class="mb-2">
                                <span class="fw-bold d-block">Status:</span>
                                <span>${statusHtml || '-'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="neumorphic-card2 p-2">
                            <span class="fw-bold d-block mb-2"><i class="fas fa-file-pdf me-2"></i>PO File:</span>
                            <div id="po-preview" class="text-center"></div>
                        </div>
                    </div>
                `;

                const breadcrumb =
                    `<span class="breadcrumb-text fw-bold"><span class="breadcrumb-separator"> &raquo; ${data.urutan}</span></span>`

                document.getElementById('breadcrumb-detail').innerHTML = breadcrumb;
                const detailContainer = document.getElementById('detail-information');
                if (detailContainer) {
                    detailContainer.innerHTML = html;

                    if (fileUrl) {
                        const previewContainer = document.getElementById('po-preview');

                        if (previewContainer) {
                            if (window.innerWidth < 768) {
                                previewContainer.innerHTML = `
                                <div class="card-body d-flex flex-column align-items-center p-2">
                                    <div id="pdf-container" style="max-height: 300px; overflow-y: auto;">
                                        <canvas id="pdf-canvas" style="width: 100%;"></canvas>
                                    </div>
                                    <a href="${fileUrl}" target="_blank" class="btn btn-sm neumorphic-btn-success mt-3 w-100">
                                        <i class="fas fa-external-link-alt me-1"></i> View PO files in new tab
                                    </a>
                                </div>
                                `;
                                setTimeout(() => {
                                    renderPdfToCanvas(fileUrl, 'pdf-canvas');
                                }, 300);
                            } else {
                                previewContainer.innerHTML = `
                                    <div class="card-body d-flex flex-column align-items-center p-2">
                                        <iframe src="${fileUrl}" width="100%" height="345px"
                                            style="border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                        </iframe>
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm neumorphic-btn-success mt-3 w-100">
                                            <i class="fas fa-external-link-alt me-1"></i> View PO file in new tab
                                        </a>
                                    </div>
                                `;
                            }
                        }
                    }
                }
            } else {
                errorListData(getDataRest);
            }
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

        async function updatePOStatus(poId, status) {
            try {
                const response = await restAPI('PUT', `/admin/po/${poId}/update-status`, {
                    status
                });
                if (response.status === 200) {
                    notyf.success('PO status updated successfully');
                    await getDetailData();
                    await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                } else {
                    notyf.error('Failed to update po status');
                }
            } catch (error) {
                notyf.error('An error occurred while updating po status');
            }
        }

        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                id_po: dataParams,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            loadListData();

            let getDataRest = await restAPI('GET', '{{ route('getdataorder') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(getDataRest.data.data.map(async item => handleListData(item)));
                await setListData(handleDataArray, getDataRest.data.pagination);
            } else {
                errorListData(getDataRest);
            }
            await addListData();
        }

        function renderNeumorphicProgress(value) {
            const val = parseInt(value) || 0;
            let color = 'danger';
            if (val > 25 && val <= 50) color = 'warning';
            else if (val > 50 && val <= 75) color = 'info';
            else if (val > 75 && val <= 100) color = 'success';

            return `
                    <div class="neumorphic-progress ${color}">
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
                                <text x="18" y="20.5" class="percentage-text fw-bold">${val}%</text>
                            </g>
                        </svg>
                    </div>
                `;
        }

        async function handleListData(data) {
            let images = data?.file?.length ? data.file.map(f => `{{ asset('${f.file_name}') }}`) : [imageNullUrl];

            const percentage = data?.percentage ?? 0;

            return {
                id: data?.id ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                item_name: data?.item_name ?? '-',
                code_order: data?.code_order ?? '-',
                qty: data?.qty ?? '-',
                price: data?.price ?? '-',
                percentage: renderNeumorphicProgress(percentage),
                images
            };
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total_pages;
            currentPage = pagination.current_page;
            let display_from = (defaultLimitPage * (currentPage - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataTable = '';
            dataList.forEach((element, index) => {
                let imageCarousel = `
                    <div id="carousel${element.id}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" style="width: 150px;">
                        <div class="carousel-inner" style="width: 100%; max-height: 100px; overflow: hidden;">
                            ${element.images.map((img, i) => `
                                                                                                                                                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                                                                                                                                <img src="${img}" class="d-block w-100" style="max-height: 100px; object-fit: contain;">
                                                                                                                                                            </div>
                                                                                                                                                        `).join('')}
                        </div>
                        ${element.images.length > 1 ? `
                                                                                                                                                        <button class="carousel-control-prev neu-text" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="prev">
                                                                                                                                                            <i class="fas fa-circle-chevron-left fs-3"></i>
                                                                                                                                                        </button>
                                                                                                                                                        <button class="carousel-control-next neu-text" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="next">
                                                                                                                                                            <i class="fas fa-circle-chevron-right fs-3"></i>
                                                                                                                                                        </button>
                                                                                                                                                    ` : ''}
                    </div>
                `;

                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td>${element.percentage}</td>
                    <td style="width: 150px; text-align: center;">${imageCarousel}</td>
                    <td>${element.code_order}</td>
                    <td>${element.item_name}</td>
                    <td>${element.qty}</td>
                    <td>${element.price}</td>
                    <td>
                        <a href="/admin/order/${element.id}/detail?r=${dataParams}" class="btn btn-sm neumorphic-card2">
                            <i class="fas fa-eye text-info me-1"></i>Detail
                        </a>
                    </td>
                </tr>`;
            });

            renderListData(getDataTable, pagination, display_from, display_to);

            document.querySelectorAll('.carousel').forEach(carousel => {
                new bootstrap.Carousel(carousel, {
                    interval: 2000,
                    ride: 'carousel'
                });
            });
        }

        async function getFilterListData() {
            let dateRangeValue = document.getElementById("filterDateRange").value;
            let start_date;
            let end_date;

            if (dateRangeValue) {
                const dateRangeArray = dateRangeValue.split(
                    " to ");
                if (dateRangeArray.length === 2) {
                    start_date = dateRangeArray[0];
                    end_date = dateRangeArray[1];
                }
            }

            let filterData = {
                start_date: start_date,
                end_date: end_date,
            };

            let resetActions = {
                resetSelect: () => document.querySelectorAll(".ss-value-delete").forEach(el => el.click())
            };

            return [filterData, resetActions];
        }

        async function addListData() {
            document.getElementById("addDataModal").addEventListener("hidden.bs.modal", function() {
                resetForm();
            });
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                const originalContent = saveButton.innerHTML;
                if (saveButton.disabled) return;

                const confirmed = await confirmSubmitData(saveButton);
                if (!confirmed) return;

                const formData = new FormData(document.getElementById('addDataForm'));
                formData.append(`id_po`, dataParams);
                formData.append(`id_user`, id_user);
                const croppedImages = document.querySelectorAll('.cropped-preview');

                try {
                    await Promise.all(
                        Array.from(croppedImages).map(async (img, index) => {
                            const response = await fetch(img.src);
                            const blob = await response.blob();

                            const now = new Date();
                            const timestamp =
                                `${String(now.getHours()).padStart(2, "0")}${String(now.getMinutes()).padStart(2, "0")}${String(now.getSeconds()).padStart(2, "0")}_${String(now.getDate()).padStart(2, "0")}${String(now.getMonth() + 1).padStart(2, "0")}${String(now.getFullYear()).slice(-2)}`;

                            const fileName = `${timestamp}_${index}.png`.replace(/\s+/g, '');
                            formData.append(`file[]`, blob, fileName);
                        })
                    );

                    const postData = await restAPI('POST', '{{ route('admin.order.store') }}', formData);

                    if (postData.status >= 200 && postData.status < 300) {
                        await notyf.success('Data saved successfully.');

                        setTimeout(async () => {
                            await getDetailData();
                            await getListData(defaultLimitPage, currentPage, defaultAscending,
                                defaultSearch, customFilter);
                        }, 1000);

                        const modalElement = document.getElementById('addDataModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            await modalInstance.hide();
                        }

                        await resetForm();
                    } else {
                        notyf.error('An error occurred while saving data.');
                    }
                } catch (error) {
                    notyf.error('Failed to save data. Please try again.');
                } finally {
                    saveButton.disabled = false;
                    saveButton.innerHTML = originalContent;
                }
            });
        }

        async function uploadMultiImage() {
            let cropper;
            let imageFiles = [];
            let croppedImages = [];
            let currentImageIndex = 0;

            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");
            const cropImageModal = new bootstrap.Modal(document.getElementById("cropImageModal"));
            const cropImageBtn = document.getElementById("cropImageBtn");
            const imagePreviewContainer = document.getElementById("imagePreviewContainer");
            imageInput.addEventListener("change", function(event) {
                const newFiles = Array.from(event.target.files);
                imageFiles = [...imageFiles, ...newFiles];
                if (newFiles.length > 0) {
                    currentImageIndex = imageFiles.length - newFiles.length;
                    showCropModal(imageFiles[currentImageIndex]);
                }
            });

            function showCropModal(file) {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    cropImageModal.show();

                    if (cropper) {
                        cropper.destroy();
                    }

                    let containerWidth = Math.min(window.innerWidth * 0.9, 750);
                    let containerHeight = (containerWidth / 750) * 400;

                    setTimeout(() => {
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                            dragMode: "move",
                            minCanvasWidth: containerWidth,
                            minCanvasHeight: containerHeight,
                            minContainerWidth: containerWidth,
                            minContainerHeight: containerHeight,
                            responsive: true,
                            ready() {
                                let containerData = cropper.getContainerData();
                                cropper.setCanvasData({
                                    left: 0,
                                    top: 0,
                                    width: containerWidth,
                                    height: containerHeight
                                });

                                cropper.setCropBoxData({
                                    left: containerData.width / 2 - containerWidth / 2,
                                    top: containerData.height / 2 - containerHeight / 2,
                                    width: containerWidth,
                                    height: containerHeight
                                });

                                document.querySelector('.cropper-container').style.width =
                                    containerWidth +
                                    'px';
                                document.querySelector('.cropper-container').style.height =
                                    containerHeight +
                                    'px';
                            }
                        });
                    }, 100);
                };
                reader.readAsDataURL(file);
            }

            cropImageBtn.addEventListener("click", function() {
                if (!cropper) return;

                cropper.getCroppedCanvas({
                    width: 500,
                    height: 500
                }).toBlob(function(blob) {
                    const index = croppedImages.length;
                    croppedImages.push(blob);

                    let wrapper = document.createElement("div");
                    wrapper.classList.add("cropped-image-wrapper", "position-relative",
                        "d-inline-block",
                        "me-2");
                    wrapper.style.width = "100px";
                    wrapper.style.height = "100px";

                    let imgElement = document.createElement("img");
                    imgElement.src = URL.createObjectURL(blob);
                    imgElement.classList.add("cropped-preview");
                    imgElement.style.width = "100px";
                    imgElement.style.height = "100px";
                    imgElement.style.borderRadius = "5px";

                    let deleteBtn = document.createElement("button");
                    deleteBtn.innerHTML = "&times;";
                    deleteBtn.classList.add("btn", "btn-danger", "btn-sm", "position-absolute");
                    deleteBtn.style.top = "5px";
                    deleteBtn.style.right = "5px";
                    deleteBtn.style.borderRadius = "50%";
                    deleteBtn.style.width = "20px";
                    deleteBtn.style.height = "20px";
                    deleteBtn.style.display = "flex";
                    deleteBtn.style.alignItems = "center";
                    deleteBtn.style.justifyContent = "center";

                    deleteBtn.addEventListener("click", function() {
                        croppedImages.splice(index, 1);
                        wrapper.remove();
                    });

                    wrapper.appendChild(imgElement);
                    wrapper.appendChild(deleteBtn);
                    imagePreviewContainer.appendChild(wrapper);

                    currentImageIndex++;
                    if (currentImageIndex < imageFiles.length) {
                        showCropModal(imageFiles[currentImageIndex]);
                    } else {
                        cropImageModal.hide();
                        imageInput.value = "";
                    }
                });
            });

            const modal = document.getElementById('cropImageModal');

            if (modal && imageInput) {
                modal.addEventListener('hidden.bs.modal', function() {
                    imageInput.value = '';
                });
            }
        }

        function resetForm() {
            const form = document.getElementById("addDataForm");

            if (!form) return;

            form.reset();

            form.querySelectorAll('.ss-main select').forEach(select => {
                const instance = select.slim;
                if (instance) {
                    instance.set('');
                }
            });
            document.querySelectorAll('input[name="catalogue_option"]').forEach((radio) => {
                radio.value = "";
            });

            form.querySelectorAll(".ss-value-delete").forEach(el => el.click());
            form.querySelectorAll(".ss-deselect").forEach(el => el.click());


            const imagePreviewContainer = form.querySelector("#imagePreviewContainer");
            if (imagePreviewContainer) imagePreviewContainer.innerHTML = '';

            form.querySelectorAll("input[type='file']").forEach(input => {
                input.value = '';
            });
        }

        function dateRangeInput(isParameter) {
            flatpickr(isParameter, {
                mode: "range",
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                locale: "en"
            });
        }

        function setMethodAddListData() {
            let currentStep = 1;

            document.querySelectorAll('input[name="catalogue_option"]').forEach((radio) => {
                radio.addEventListener("change", function() {
                    const container = document.getElementById("formContainer");
                    container.innerHTML = "";
                    const modalFooter = document.getElementById("btnContainer");

                    document.querySelectorAll('input[name="catalogue_option"]').forEach((el) => {
                        el.closest("label").classList.remove("active");
                    });

                    this.closest("label").classList.add("active");

                    if (this.value === "with-catalogue") {
                        renderWithCatalogue(container);
                        modalFooter.innerHTML = `
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" id="closeBtn" class="btn neumorphic-button" data-bs-dismiss="modal">
                                    <i class="fas fa-circle-xmark me-1"></i>Cancel
                                </button>
                                <button type="submit" form="addDataForm" id="submitBtn" class="btn neumorphic-button-outline fw-bold">
                                    <i class="fas fa-save me-1"></i>Submit
                                </button>
                            </div>
                        `;
                    } else if (this.value === "without-catalogue") {
                        modalCrop();
                        renderWithoutCatalogue(container);
                        setupWizardFooter(1, 4);
                    }
                });
            });

            function modalCrop() {
                const modalCrop = document.getElementById('cropImageModal');
                modalCrop.innerHTML = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content neumorphic-modal p-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Crop Image</h5>
                            <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <img id="imagePreview">
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn neumorphic-button" data-bs-dismiss="modal"><i
                                    class="fas fa-circle-xmark me-1"></i>Cancel</button>
                            <button type="button" id="cropImageBtn" class="btn neumorphic-button-outline fw-bold"><i
                                    class="fas fa-upload me-1"></i>Crop &
                                Upload</button>
                        </div>
                    </div>
                </div>`;
            }

            function renderWithCatalogue(container) {
                container.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="buyer" class="form-label">Buyer</label>
                            <input type="text" class="text-dark form-control neumorphic-card-reverse" value="${buyer}" disabled>
                        </div>
                        <div class="col-md-12">
                            <label for="id_katalog" class="form-label">Catalogue</label>
                            <select id="id_katalog" class="form-control neumorphic-card" name="id_katalog">
                                ${getCatalogueOptions()}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" class="form-control neumorphic-card" name="qty" placeholder="Enter qty">
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control neumorphic-card" name="price" step="any" placeholder="Enter price">
                        </div>
                    </div>
                `;
                multiSelectData('#id_katalog', 'Select Catalogue');
                multiSelectData('#id_user', 'Select User Buyer');
            }

            function renderWithoutCatalogue(container) {
                const steps = [
                    "Information Order",
                    "Item Details",
                    "Description Contents",
                    "Upload Images"
                ];

                let navTabs = steps.map((step, index) => `
                    <li class="nav-item">
                        <button class="neumorphic-button text-green nav-link wizard-step ${index === 0 ? 'active' : ''}"
                            data-step="${index + 1}">
                            ${index + 1} . ${step}
                        </button>
                    </li>
                `).join('');

                let stepContents = [
                    `<div class="wizard-content" id="step-1">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="buyer" class="form-label">Buyer</label>
                                <input type="text" class="text-dark form-control neumorphic-card-reverse" value="${buyer}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="qty" placeholder="Enter qty" required>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="price" step="any" placeholder="Enter price" required>
                            </div>
                        </div>
                    </div>`,
                    `<div class="wizard-content d-none" id="step-2">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="itemName" class="form-label fw-bold">Item Name</label>
                                <input type="text" class="form-control required-input neumorphic-card" id="itemName"
                                    name="item_name" placeholder="Enter item name" required>
                            </div>
                            <div class="col-md-9">
                                <label for="material" class="form-label fw-bold">Material</label>
                                <textarea class="form-control required-input neumorphic-card" id="material" name="material" rows="1"
                                    placeholder="Enter material details" required></textarea>
                            </div>
                            <div class="col-md-3">
                                <label for="weight" class="form-label fw-bold">Weight (kg)</label>
                                <input type="number" class="form-control required-input neumorphic-card" id="weight"
                                    name="weight" placeholder="Enter weight" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Dimensions:</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <label for="width" class="form-label">Width</label>
                                        <input type="number" step="any" class="form-control required-input neumorphic-card"
                                        id="width" name="width" placeholder="Enter width">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="length" class="form-label">Depth</label>
                                        <input type="number" step="any" class="form-control required-input neumorphic-card"
                                            id="length" name="length" placeholder="Enter depth">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="height" class="form-label">Height</label>
                                        <input type="number" step="any" class="form-control required-input neumorphic-card"
                                            id="height" name="height" placeholder="Enter height">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="unit" class="form-label">Unit</label>
                                        <select id="unit" class="form-control required-input neumorphic-card" name="unit"
                                            required>
                                            <option value="m">m (Meter)</option>
                                            <option value="cm">cm (Centimeter)</option>
                                            <option value="mm">mm (Milimeter)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`,
                    `<div class="wizard-content d-none" id="step-3">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="desc" class="form-label fw-bold">Description</label>
                                <textarea class="form-control neumorphic-card" id="desc" name="desc" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                    </div>`,
                    `<div class="wizard-content d-none" id="step-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="imageInput" class="form-label fw-bold">Upload Images</label>
                                <input type="file" accept="image/*" class="form-control required-input neumorphic-card"
                                    id="imageInput" multiple>
                                <small class="neu-text">You can upload multiple images</small>
                                <div id="imagePreviewContainer" class="mt-3"></div>
                            </div>
                        </div>
                    </div>`
                ].join('');

                container.innerHTML = `
                    <ul class="nav nav-tabs border-0 mb-3 gap-2" id="wizardTabs">
                        ${navTabs}
                    </ul>
                    <hr>
                    ${stepContents}
                `;

                initWizard(steps.length);
                multiSelectData('#unit', 'Select Unit');
                uploadMultiImage();
            }

            function initWizard(totalSteps) {
                currentStep = 1;
                setupWizardFooter(currentStep, totalSteps);

                document.getElementById("wizardTabs").addEventListener("click", function(event) {
                    if (event.target.classList.contains("wizard-step")) {
                        event.preventDefault();
                        let step = parseInt(event.target.dataset.step);

                        if (step > currentStep) {
                            if (!isStepValid(currentStep)) {
                                return;
                            }
                        }

                        if (step <= currentStep) {
                            document.getElementById(`step-${currentStep}`).classList.add("d-none");
                            document.getElementById(`step-${step}`).classList.remove("d-none");

                            document.querySelectorAll(".wizard-step").forEach(btn => btn.classList.remove(
                                "active"));
                            event.target.classList.add("active");

                            currentStep = step;
                            setupWizardFooter(currentStep, totalSteps);
                        }
                    }
                });

                document.addEventListener("click", function(event) {
                    if (event.target.id === "nextBtn" && currentStep < totalSteps) {
                        if (!isStepValid(currentStep)) return;
                        document.getElementById(`step-${currentStep}`).classList.add("d-none");
                        currentStep++;
                        document.getElementById(`step-${currentStep}`).classList.remove("d-none");

                        document.querySelectorAll(".wizard-step").forEach(btn => btn.classList.remove("active"));
                        document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.add("active");

                        setupWizardFooter(currentStep, totalSteps);
                    }

                    if (event.target.id === "prevBtn" && currentStep > 1) {
                        document.getElementById(`step-${currentStep}`).classList.add("d-none");
                        currentStep--;
                        document.getElementById(`step-${currentStep}`).classList.remove("d-none");

                        document.querySelectorAll(".wizard-step").forEach(btn => btn.classList.remove("active"));
                        document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.add("active");

                        setupWizardFooter(currentStep, totalSteps);
                    }
                });
            }

            function isStepValid(step) {
                const stepContainer = document.getElementById(`step-${step}`);
                const inputs = stepContainer.querySelectorAll("input, select, textarea");
                let valid = true;

                const requiredInputs = stepContainer.querySelectorAll(
                    "input[required], select[required], textarea[required]");

                if (requiredInputs.length === 0) {
                    return true;
                }

                inputs.forEach(input => {
                    if (input.hasAttribute("required") && !input.value.trim()) {
                        valid = false;
                        input.classList.add("is-invalid");
                    } else {
                        input.classList.remove("is-invalid");
                    }
                });

                return valid;
            }

            function setupWizardFooter(currentStep, totalSteps = 4) {
                const modalFooter = document.querySelector(".modal-footer");

                modalFooter.innerHTML = `
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            ${currentStep > 1 ? `
                                                                                                                                                                                                                                        <button type="button" id="prevBtn" class="btn neumorphic-button">
                                                                                                                                                                                                                                            <i class="fas fa-backward me-1"></i>Previous
                                                                                                                                                                                                                                        </button>` : ''
                        }
                        </div>
                        <div class="d-flex gap-2">
                            ${currentStep < totalSteps ? `
                                                                                                                                                                                                                                            <button type="button" id="nextBtn" class="btn neumorphic-button-outline">
                                                                                                                                                                                                                                                <i class="fas fa-forward me-1"></i>Next
                                                                                                                                                                                                                                            </button>` : ''
                            }
                            ${currentStep === totalSteps ? `
                                                                                                                                                                                                                                            <button type="button" id="closeBtn" class="btn neumorphic-button" data-bs-dismiss="modal">
                                                                                                                                                                                                                                                <i class="fas fa-circle-xmark me-1"></i>Cancel
                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                            <button type="submit" form="addDataForm" id="submitBtn" class="btn neumorphic-button-outline fw-bold">
                                                                                                                                                                                                                                                <i class="fas fa-save me-1"></i>Submit
                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                        ` : ''
                            }
                        </div>
                    </div>
                `;
            }

            function getCatalogueOptions() {
                return `
                @foreach ($katalog as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->code }}/{{ $cat->item_name }}</option>
                @endforeach`;
            }
        }

        async function uploadMultiImage() {
            let cropper;
            let imageFiles = [];
            let croppedImages = [];
            let currentImageIndex = 0;

            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");
            const cropImageModal = new bootstrap.Modal(document.getElementById("cropImageModal"));
            const cropImageBtn = document.getElementById("cropImageBtn");
            const imagePreviewContainer = document.getElementById("imagePreviewContainer");
            imageInput.addEventListener("change", function(event) {
                const newFiles = Array.from(event.target.files);
                imageFiles = [...imageFiles, ...newFiles];
                if (newFiles.length > 0) {
                    currentImageIndex = imageFiles.length - newFiles.length;
                    showCropModal(imageFiles[currentImageIndex]);
                }
            });

            function showCropModal(file) {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    cropImageModal.show();

                    if (cropper) {
                        cropper.destroy();
                    }

                    let containerWidth = Math.min(window.innerWidth * 0.9, 750);
                    let containerHeight = (containerWidth / 750) * 400;

                    setTimeout(() => {
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                            dragMode: "move",
                            minCanvasWidth: containerWidth,
                            minCanvasHeight: containerHeight,
                            minContainerWidth: containerWidth,
                            minContainerHeight: containerHeight,
                            responsive: true,
                            ready() {
                                let containerData = cropper.getContainerData();
                                cropper.setCanvasData({
                                    left: 0,
                                    top: 0,
                                    width: containerWidth,
                                    height: containerHeight
                                });

                                cropper.setCropBoxData({
                                    left: containerData.width / 2 - containerWidth / 2,
                                    top: containerData.height / 2 - containerHeight / 2,
                                    width: containerWidth,
                                    height: containerHeight
                                });

                                document.querySelector('.cropper-container').style.width =
                                    containerWidth +
                                    'px';
                                document.querySelector('.cropper-container').style.height =
                                    containerHeight +
                                    'px';
                            }
                        });
                    }, 100);
                };
                reader.readAsDataURL(file);
            }

            cropImageBtn.addEventListener("click", function() {
                if (!cropper) return;

                cropper.getCroppedCanvas({
                    width: 500,
                    height: 500
                }).toBlob(function(blob) {
                    const index = croppedImages.length;
                    croppedImages.push(blob);

                    let wrapper = document.createElement("div");
                    wrapper.classList.add("cropped-image-wrapper", "position-relative",
                        "d-inline-block",
                        "me-2");
                    wrapper.style.width = "100px";
                    wrapper.style.height = "100px";

                    let imgElement = document.createElement("img");
                    imgElement.src = URL.createObjectURL(blob);
                    imgElement.classList.add("cropped-preview");
                    imgElement.style.width = "100px";
                    imgElement.style.height = "100px";
                    imgElement.style.borderRadius = "5px";

                    let deleteBtn = document.createElement("button");
                    deleteBtn.innerHTML = "&times;";
                    deleteBtn.classList.add("btn", "btn-danger", "btn-sm", "position-absolute");
                    deleteBtn.style.top = "5px";
                    deleteBtn.style.right = "5px";
                    deleteBtn.style.borderRadius = "50%";
                    deleteBtn.style.width = "20px";
                    deleteBtn.style.height = "20px";
                    deleteBtn.style.display = "flex";
                    deleteBtn.style.alignItems = "center";
                    deleteBtn.style.justifyContent = "center";

                    deleteBtn.addEventListener("click", function() {
                        croppedImages.splice(index, 1);
                        wrapper.remove();
                    });

                    wrapper.appendChild(imgElement);
                    wrapper.appendChild(deleteBtn);
                    imagePreviewContainer.appendChild(wrapper);

                    currentImageIndex++;
                    if (currentImageIndex < imageFiles.length) {
                        showCropModal(imageFiles[currentImageIndex]);
                    } else {
                        cropImageModal.hide();
                        imageInput.value = "";
                    }
                });
            });

            const modal = document.getElementById('cropImageModal');

            if (modal && imageInput) {
                modal.addEventListener('hidden.bs.modal', function() {
                    imageInput.value = '';
                });
            }
        }

        function resetForm() {
            const form = document.getElementById("addDataForm");

            if (!form) return;

            form.reset();

            form.querySelectorAll('.ss-main select').forEach(select => {
                const instance = select.slim;
                if (instance) {
                    instance.set('');
                }
            });

            form.querySelectorAll(".ss-value-delete").forEach(el => el.click());

            const imagePreviewContainer = form.querySelector("#imagePreviewContainer");
            if (imagePreviewContainer) imagePreviewContainer.innerHTML = '';

            form.querySelectorAll("input[type='file']").forEach(input => {
                input.value = '';
            });
        }

        function dateRangeInput(isParameter) {
            flatpickr(isParameter, {
                mode: "range",
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                locale: "en"
            });
        }

        async function initPageLoad() {
            await Promise.all([
                getDetailData(),
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter),
                searchListData(),
                setFilterListData(),
                toggleFilterButton(),
                dateRangeInput('#date_range'),
                dateRangeInput('#filterDateRange'),
                setMethodAddListData(),
            ])
        }
    </script>
@endsection
