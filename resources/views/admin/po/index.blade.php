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
                        <div class="col-md-12">
                            <label for="filterStatus" class="form-label">Status</label>
                            <select id="filterStatus" class="form-control" multiple>
                                {{-- @foreach ($status as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-12 d-flex align-items-end justify-content-end gap-2">
                            <button type="reset" id="resetFilter" class="btn neumorphic-button"><i
                                    class="fas fa-rotate me-1"></i>Reset</button>
                            <button type="submit" id="applyFilter" class="btn neumorphic-button-outline fw-bold"><i
                                    class="fas fa-circle-check me-1"></i>Apply</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive neumorphic-card p-3 mb-3">
                <table class="table m-0">
                    <thead>
                        <tr class="tb-head">
                            <th class="text-center text-wrap align-top">No</th>
                            <th class="text-wrap align-top">File</th>
                            <th class="text-wrap align-top">Progess</th>
                            <th class="text-wrap align-top">Code</th>
                            <th class="text-wrap align-top">Buyer</th>
                            <th class="text-wrap align-top">Description</th>
                            <th class="text-wrap align-top">DP</th>
                            <th class="text-wrap align-top">Status</th>
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
                    <h5 class="modal-title fw-bold" id="addDataModalLabel">Add New PO</h5>
                    <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDataForm">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="id_user" class="form-label">Buyer</label>
                                <select id="id_user" class="form-control neumorphic-card" name="id_user">
                                    @foreach ($user as $usr)
                                        <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kode_po" class="form-label fw-bold">PO Code</label>
                                <input type="text" class="form-control neumorphic-card" id="kode_po" name="kode_po"
                                    placeholder="Enter PO Code" autocomplete="off" required>
                            </div>
                            <div class="col-md-6">
                                <label for="dp" class="form-label fw-bold">DP</label>
                                <input type="number" class="form-control neumorphic-card" id="dp" name="dp"
                                    step="any" placeholder="Enter DP" autocomplete="off" required>
                            </div>
                            <div class="col-md-12">
                                <label for="desc" class="form-label fw-bold">Description</label>
                                <textarea class="form-control neumorphic-card" id="desc" name="desc" placeholder="Enter description"
                                    rows="4" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="file" class="form-label fw-bold">Upload File PO</label>
                                <input type="file" class="form-control neumorphic-card" id="file"
                                    accept="application/pdf">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-end">
                    <button type="button" class="btn neumorphic-button" data-bs-dismiss="modal">
                        <i class="fas fa-circle-xmark me-1"></i>Cancel
                    </button>
                    <button type="submit" form="addDataForm" id="submitBtn"
                        class="btn neumorphic-button-outline fw-bold">
                        <i class="fas fa-save me-1"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
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

        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            loadListData();

            let getDataRest = await restAPI('GET', '{{ route('getdatapo') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(getDataRest.data.data.map(async item => handleListData(item)));
                await setListData(handleDataArray, getDataRest.data.pagination);
            } else {
                errorListData(getDataRest);
            }
        }

        async function handleListData(data) {
            let statusMapping = {
                'Payment Completed': {
                    class: 'text-white bg-success neumorphic-card2',
                    icon: '<i class="fas fa-check-circle"></i>',
                    dropdown: false
                },
                'Partial Payment': {
                    class: 'text-dark bg-warning neumorphic-card2',
                    icon: '<i class="fas fa-hourglass-half"></i>',
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
                    <button class="badge border px-2 py-1 ${statusData.class} dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${statusData.icon}
                        <span>${data?.status ?? '-'}</span>
                    </button>
                    ${data.status === 'Partial Payment' ? '<small class="ms-1 text-secondary">Click to change status</small>' : ''}
                    <ul class="dropdown-menu">
                        ${statusData.dropdown.map(item => `
                            <li><a class="dropdown-item" href="#" onclick="updatePOStatus('${data.id}', '${item.value}')">${item.text}</a></li>
                        `).join('')}
                    </ul>
                </div>
            ` :
                `<div class="badge border px-2 py-1 ${statusData.class}">${statusData.icon} ${data?.status ?? '-'}</div>`;

            const percentage = data?.percentage ?? 0;

            return {
                id: data?.id ?? '-',
                id_encrypt: data?.id_encrypt ?? '-',
                percentage: data?.percentage ?? '-',
                code: data?.kode_po ?? '-',
                id_user: data?.id_user ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                desc: data?.desc ?? '-',
                percentage: renderNeumorphicProgress(percentage),
                dp: data?.dp ?? '-',
                file: data.file,
                status: statusHtml,
            };
        }

        async function updatePOStatus(poId, status) {
            try {
                const response = await restAPI('PUT', `/admin/po/${poId}/update-status`, {
                    status
                });
                if (response.status === 200) {
                    notyf.success('PO status updated successfully');
                    await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                } else {
                    notyf.error('Failed to update po status');
                }
            } catch (error) {
                notyf.error('An error occurred while updating po status');
            }
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total_pages;
            currentPage = pagination.current_page;
            let display_from = (defaultLimitPage * (currentPage - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataTable = '';
            dataList.forEach((element, index) => {
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
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm neumorphic-btn-success mt-3 w-100">
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
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm neumorphic-btn-success mt-3 w-100">
                                            <i class="fas fa-external-link-alt me-1"></i> View PO files in new tab
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                    } else {
                        fileContent = `<a href="${storageUrl}/${element.file}" target="_blank">View file</a>`;
                    }
                }

                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td style="min-width: 300px;">${fileContent}</td>
                    <td>${element.percentage}</td>
                    <td>${element.code}</td>
                    <td>${element.buyer_name}</td>
                    <td style="text-align: justify; word-wrap: break-word;">${element.desc}</td>
                    <td>${element.dp}</td>
                    <td>${element.status}</td>
                    <td>
                        <a href="/admin/order?r=${element.id_encrypt}" class="btn btn-sm neumorphic-card2">
                            <i class="fas fa-eye text-info me-1"></i>Detail
                        </a>
                    </td>
                </tr>`;
            });

            renderListData(getDataTable, pagination, display_from, display_to);
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

                const fileInput = document.getElementById('file');
                if (fileInput && fileInput.files.length === 1) {
                    const originalFile = fileInput.files[0];

                    const now = new Date();
                    const timestamp =
                        `${String(now.getHours()).padStart(2, "0")}${String(now.getMinutes()).padStart(2, "0")}${String(now.getSeconds()).padStart(2, "0")}_${String(now.getDate()).padStart(2, "0")}${String(now.getMonth() + 1).padStart(2, "0")}${String(now.getFullYear()).slice(-2)}`;

                    const customFileName = `PO-${timestamp}_1.${originalFile.name.split('.').pop()}`
                        .replace(/\s+/g, '');

                    const renamedFile = new File([originalFile], customFileName, {
                        type: originalFile.type,
                        lastModified: originalFile.lastModified,
                    });

                    formData.append('file', renamedFile);
                    formData.append('file_name', renamedFile.name);
                }

                try {
                    const postData = await restAPI('POST', '{{ route('admin.po.store') }}', formData);

                    if (postData.status >= 200 && postData.status < 300) {
                        await notyf.success('Data saved successfully.');

                        setTimeout(async () => {
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

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter),
                searchListData(),
                setFilterListData(),
                toggleFilterButton(),
                multiSelectData('#id_user', 'Select User Buyer'),
                addListData()
            ])
        }
    </script>
@endsection
