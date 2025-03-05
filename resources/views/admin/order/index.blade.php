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
                            <label for="filterDateRange" class="form-label">Content Date Range</label>
                            <input type="text" class="form-control neumorphic-card" id="filterDateRange"
                                placeholder="Select date range" autocomplete="off" required>
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
                            <th class="text-wrap align-top">Status</th>
                            <th class="text-wrap align-top">Image</th>
                            <th class="text-wrap align-top">Code Order</th>
                            <th class="text-wrap align-top">Buyer</th>
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
                    <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
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
        // let storageUrl = '{{ asset('storage/uploads/katalog') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'

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

            let getDataRest = await restAPI('GET', '{{ route('getdataorder') }}', requestParams)
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

            let statusHtml = statusData.dropdown ? `
                <div class="dropdown">
                    <button class="badge border px-2 py-1 ${statusData.class} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ${statusData.icon} ${data?.status ?? '-'}
                    </button>
                    <ul class="dropdown-menu">
                        ${statusData.dropdown.map(item => `
                                <li><a class="dropdown-item" href="#" onclick="updateOrderStatus('${data.id}', '${item.value}')">${item.text}</a></li>
                            `).join('')}
                    </ul>
                </div>
            ` : `<div class="badge border px-2 py-1 ${statusData.class}">${statusData.icon} ${data?.status ?? '-'}</div>`;

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
                    <td>${element.status}</td>
                    <td style="width: 150px; text-align: center;">${imageCarousel}</td>
                    <td>${element.code_order}</td>
                    <td>${element.buyer_name}</td>
                    <td>${element.item_name}</td>
                    <td>${element.qty}</td>
                    <td>${element.price}</td>
                    <td>
                        <a href="/admin/order/${element.id}/detail" class="btn btn-sm neumorphic-button">
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

        async function updateOrderStatus(orderId, status) {
            try {
                const response = await restAPI('PUT', `/admin/order/${orderId}/update-status`, {
                    status
                });
                if (response.status === 200) {
                    notyf.success('Order status updated successfully');
                    await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                } else {
                    notyf.error('Failed to update order status');
                }
            } catch (error) {
                notyf.error('An error occurred while updating order status');
            }
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
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                if (saveButton.disabled) return;

                await confirmSubmitData(saveButton);

                const originalContent = saveButton.innerHTML;
                const formData = new FormData(document.getElementById('addDataForm'));
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
                            <label for="id_user" class="form-label">Buyer</label>
                            <select id="id_user" class="form-control neumorphic-card" name="id_user">
                                ${getUserOptions()}
                            </select>
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
                            <input type="number" class="form-control neumorphic-card" name="price" placeholder="Enter price">
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
                                <label for="id_user" class="form-label">Buyer</label>
                                <select id="id_user" class="form-control required-input neumorphic-card" name="id_user">
                                    ${getUserOptions()}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="qty" placeholder="Enter qty">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="price" placeholder="Enter price">
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
                                <label class="form-label fw-bold">Dimensions (L × W × H):</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <label for="length" class="form-label">Length</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="length" name="length" placeholder="Enter length" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="width" class="form-label">Width</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="width" name="width" placeholder="Enter width" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="height" class="form-label">Height</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="height" name="height" placeholder="Enter height" required>
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
                                <textarea class="form-control required-input neumorphic-card" id="desc" name="desc" placeholder="Enter description"
                                    required></textarea>
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
                multiSelectData('#id_user', 'Select User Buyer');
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

                        if (step !== currentStep) {
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

            function getUserOptions() {
                return `
                @foreach ($user as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                @endforeach`;
            }

            function getCatalogueOptions() {
                return `
                @foreach ($katalog as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->code }}/{{ $cat->item_name }}</option>
                @endforeach`;
            }
        }

        async function addListData() {
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                if (saveButton.disabled) return;

                await confirmSubmitData(saveButton);

                const originalContent = saveButton.innerHTML;
                const formData = new FormData(document.getElementById('addDataForm'));
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
                            <button type="button" class="btn neumorphic-button" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="cropImageBtn" class="btn neumorphic-button-outline fw-bold">Crop &
                                Upload</button>
                        </div>
                    </div>
                </div>`;
            }

            function renderWithCatalogue(container) {
                container.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="id_user" class="form-label">Buyer</label>
                            <select id="id_user" class="form-control neumorphic-card" name="id_user">
                                ${getUserOptions()}
                            </select>
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
                            <input type="number" class="form-control neumorphic-card" name="price" placeholder="Enter price">
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
                                <label for="id_user" class="form-label">Buyer</label>
                                <select id="id_user" class="form-control required-input neumorphic-card" name="id_user">
                                    ${getUserOptions()}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="qty" placeholder="Enter qty">
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control required-input neumorphic-card" name="price" placeholder="Enter price">
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
                                <label class="form-label fw-bold">Dimensions (L × W × H):</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <label for="length" class="form-label">Length</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="length" name="length" placeholder="Enter length" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="width" class="form-label">Width</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="width" name="width" placeholder="Enter width" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="height" class="form-label">Height</label>
                                        <input type="number" step="0.01" class="form-control required-input neumorphic-card"
                                            id="height" name="height" placeholder="Enter height" required>
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
                                <textarea class="form-control required-input neumorphic-card" id="desc" name="desc" placeholder="Enter description"
                                    required></textarea>
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
                multiSelectData('#id_user', 'Select User Buyer');
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

                        if (step !== currentStep) {
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

            function getUserOptions() {
                return `
                @foreach ($user as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                @endforeach`;
            }

            function getCatalogueOptions() {
                return `
                @foreach ($katalog as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->code }} / {{ $cat->item_name }}</option>
                @endforeach`;
            }
        }

        async function addListData() {
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                if (saveButton.disabled) return;

                await confirmSubmitData(saveButton);

                const originalContent = saveButton.innerHTML;
                const formData = new FormData(document.getElementById('addDataForm'));
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

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter),
                searchListData(),
                setFilterListData(),
                addListData(),
                toggleFilterButton(),
                dateRangeInput('#date_range'),
                dateRangeInput('#filterDateRange'),
                setMethodAddListData(),
            ])
        }
    </script>
@endsection
