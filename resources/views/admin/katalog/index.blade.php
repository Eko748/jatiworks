@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('assets_css')
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
                            <label for="filterCategory" class="form-label">Category</label>
                            <select id="filterCategory" class="form-control" multiple>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                @endforeach
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
                            <th class="text-wrap align-top">Image</th>
                            <th class="text-wrap align-top">Code</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Material</th>
                            <th class="text-wrap align-top">Weight (kg)</th>
                            <th class="text-wrap align-top">Dimensions (W x D x H)</th>
                            <th class="text-wrap align-top">Unit</th>
                            <th class="text-wrap align-top">Category</th>
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
    </div>

    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
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
        let storageUrl = '{{ asset('storage/uploads/katalog/') }}'

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

            await loadListData();

            let getDataRest = await restAPI('GET', '{{ route('getdatakatalog') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListData(item))
                );
                await setListData(handleDataArray, getDataRest.data.pagination);
            } else {
                errorListData(getDataRest);
            }
            await Promise.all([
                modalAddListData(),
                modalCrop(),
                setWizardForm(),
                uploadMultiImage(),
                addListData(),
                multiSelectData('#filterCategory', 'Select Categories'),
                multiSelectData('#id_category', 'Select Categories'),
                multiSelectData('#unit', 'Select Unit'),
            ]);
        }

        async function handleListData(data) {
            let actions = `
                    <button class="delete-data btn btn-sm neumorphic-card2" data-id="${data.id}" onclick="deleteListData(this)">
                        <i class="fas fa-trash-alt text-danger me-1"></i>Delete
                    </button>
                `;

            return {
                id: data?.id ?? '-',
                code: data?.code ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                unit: data?.unit ?? '-',
                weight: data?.weight ?? '-',
                dimensions: `${data?.width ?? '-'} x ${data?.length ?? '-'} x ${data?.height ?? '-'}`,
                category: data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-',
                images: data?.file.length ? data.file.map(f => f.file_name) : [],
                actions
            }
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total_pages
            currentPage = pagination.current_page
            let display_from = (pagination.per_page * (currentPage - 1)) + 1
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total)

            let getDataTable = ''
            dataList.forEach((element, index) => {
                let imageCarousel = element.images.length ? `
                    <div id="carousel${element.id}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" style="width: 150px;">
                        <div class="carousel-inner" style="width: 100%; max-height: 100px; overflow: hidden;">
                            ${element.images.map((img, i) => `
                                                                                                                                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                                                                                                                <img src="${storageUrl}/${img}" class="d-block w-100" style="max-height: 100px; object-fit: contain;">
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
                ` : '-'

                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td style="width: 150px; text-align: center;">${imageCarousel}</td>
                    <td>${element.code}</td>
                    <td>${element.item_name}</td>
                    <td>${element.material}</td>
                    <td>${element.weight}</td>
                    <td>${element.dimensions}</td>
                    <td>${element.unit}</td>
                    <td>${element.category}</td>
                    <td>${element.actions}</td>
                </tr>`
            })

            renderListData(getDataTable, pagination, display_from, display_to);

            document.querySelectorAll('.carousel').forEach(carousel => {
                new bootstrap.Carousel(carousel, {
                    interval: 2000,
                    ride: 'carousel'
                })
            })
        }

        async function getFilterListData() {
            let selectedOptions = Array.from(document.getElementById("filterCategory").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let filterData = {
                id_category: selectedOptions.length ? selectedOptions : null
            };

            let resetActions = {
                resetSelect: () => document.querySelectorAll(".ss-value-delete").forEach(el => el.click())
            };

            return [filterData, resetActions];
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

                            document.querySelector('.cropper-container').style.width = containerWidth +
                                'px';
                            document.querySelector('.cropper-container').style.height = containerHeight +
                                'px';
                        }
                    });
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

        async function setWizardForm() {
            let currentStep = 1;
            const steps = document.querySelectorAll(".wizard-content");
            const totalSteps = steps.length;
            const stepButtons = document.querySelectorAll(".wizard-step");

            function changeStep(step) {
                document.getElementById(`step-${currentStep}`).classList.add("d-none");
                document.querySelector(`[data-step="${currentStep}"]`).classList.remove("active");

                currentStep = step;
                document.getElementById(`step-${currentStep}`).classList.remove("d-none");
                document.querySelector(`[data-step="${currentStep}"]`).classList.add("active");

                document.getElementById("prevBtn").classList.toggle("d-none", currentStep === 1);
                document.getElementById("nextBtn").classList.toggle("d-none", currentStep === totalSteps);
                document.getElementById("submitBtnContainer").classList.toggle("d-none", currentStep !== totalSteps);
            }

            function validateStep() {
                let isValid = true;
                document.querySelectorAll(
                    `#step-${currentStep} input[required], #step-${currentStep} textarea[required], #step-${currentStep} select[required]`
                ).forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add("is-invalid");
                        isValid = false;
                    } else {
                        input.classList.remove("is-invalid");
                    }
                });
                return isValid;
            }

            stepButtons.forEach(button => {
                button.addEventListener("click", function() {
                    let targetStep = parseInt(this.getAttribute("data-step"));
                    if (targetStep > currentStep && !validateStep()) return;
                    changeStep(targetStep);
                });
            });

            document.getElementById("nextBtn").addEventListener("click", function() {
                if (!validateStep()) return;
                changeStep(currentStep + 1);
            });
            document.getElementById("prevBtn").addEventListener("click", function() {
                changeStep(currentStep - 1);
            });
            document.getElementById("addDataModal").addEventListener("shown.bs.modal", function() {
                changeStep(1);
            });
            document.getElementById("addDataModal").addEventListener("hidden.bs.modal", function() {
                resetForm();
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

            form.querySelectorAll(".ss-value-delete").forEach(el => el.click());

            const categoryContainer = form.querySelector('#categoryContainer');
            if (categoryContainer) categoryContainer.innerHTML = '';

            const imagePreviewContainer = form.querySelector("#imagePreviewContainer");
            if (imagePreviewContainer) imagePreviewContainer.innerHTML = '';

            form.querySelectorAll("input[type='file']").forEach(input => {
                input.value = '';
            });
        }

        async function addCategoryInput() {
            let container = document.getElementById('categoryContainer');
            let div = document.createElement('div');
            div.classList.add('d-flex', 'align-items-center', 'gap-2', 'mt-2');

            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'name_category[]';
            input.classList.add('form-control', 'neumorphic-card', 'mb-2');
            input.placeholder = 'Enter new category';

            let button = document.createElement('button');
            button.type = 'button';
            button.classList.add('btn', 'neumorphic-btn-danger', 'mb-2');
            button.innerHTML = '<i class="fas fa-minus-circle"></i>';
            button.onclick = function() {
                div.remove();
            };

            div.appendChild(input);
            div.appendChild(button);
            container.appendChild(div);
        }

        async function addListData() {
            document.getElementById("addDataForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                const saveButton = document.getElementById('submitBtn');
                if (saveButton.disabled) return;
                const originalContent = saveButton.innerHTML;

                const confirmed = await confirmSubmitData(saveButton);
                if (!confirmed) return;

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

                    const postData = await restAPI('POST', '{{ route('admin.katalog.store') }}', formData);

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

        function modalAddListData() {
            const modal = document.getElementById('addDataModal');
            modal.innerHTML = `
                <div class="modal-dialog modal-xl">
                    <div class="modal-content neumorphic-modal p-3">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold" id="addDataModalLabel">Add New Data</h5>
                            <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs border-0 mb-3 gap-2" id="wizardTabs">
                                <li class="nav-item">
                                    <button class="neumorphic-button text-green nav-link active wizard-step" data-step="1">
                                        1 <span class="d-none d-md-inline">. Item Details</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="neumorphic-button text-green nav-link wizard-step" data-step="2">
                                        2 <span class="d-none d-md-inline">. Select Categories</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="neumorphic-button text-green nav-link wizard-step" data-step="3">
                                        3 <span class="d-none d-md-inline">. Description Contents</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="neumorphic-button text-green nav-link wizard-step" data-step="4">
                                        4 <span class="d-none d-md-inline">. Upload Images</span>
                                    </button>
                                </li>
                            </ul>
                            <hr>
                            <form id="addDataForm">
                                <div class="wizard-content" id="step-1">
                                    <div class="row g-3">
                                        <div class="col-md-9">
                                            <label for="itemName" class="form-label fw-bold">Item Name</label>
                                            <textarea class="form-control neumorphic-card" id="itemName" name="item_name" rows="1"
                                                placeholder="Enter item name" required></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="code" class="form-label fw-bold">Catalogue Code</label>
                                            <input type="text" class="form-control neumorphic-card" id="code"
                                                name="code" placeholder="Enter code" required>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="material" class="form-label fw-bold">Material</label>
                                            <textarea class="form-control neumorphic-card" id="material" name="material" rows="1"
                                                placeholder="Enter material details" required></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="weight" class="form-label fw-bold">Weight (kg)</label>
                                            <input type="number" class="form-control neumorphic-card" id="weight"
                                                name="weight" placeholder="Enter weight" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Dimensions:</label>
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <label for="width" class="form-label">Width</label>
                                                    <input type="number" step="0.01" class="form-control neumorphic-card"
                                                    id="width" name="width" placeholder="Enter width">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="length" class="form-label">Depth</label>
                                                    <input type="number" step="0.01" class="form-control neumorphic-card"
                                                        id="length" name="length" placeholder="Enter depth">
                                                    </div>
                                                <div class="col-md-3">
                                                    <label for="height" class="form-label">Height</label>
                                                    <input type="number" step="0.01" class="form-control neumorphic-card"
                                                        id="height" name="height" placeholder="Enter height">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="unit" class="form-label">Unit</label>
                                                    <select id="unit" class="form-control neumorphic-card" name="unit"
                                                        required>
                                                        <option value="m">m (Meter)</option>
                                                        <option value="cm">cm (Centimeter)</option>
                                                        <option value="mm">mm (Milimeter)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-content d-none" id="step-2">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Category:</label>
                                            <div class="row g-2">
                                                <div class="col-md-12">
                                                    <label for="category" class="form-label">Existing Categories</label>
                                                    <select id="id_category" class="form-control neumorphic-card"
                                                        name="id_category" multiple>
                                                        @foreach ($category as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 position-relative">
                                                    <label class="form-label">Add New Category (optional)</label>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <input type="text" class="form-control neumorphic-card mb-2"
                                                            name="name_category[]" placeholder="Enter new category">
                                                        <button type="button" class="btn circle-plus mb-2 neumorphic-btn-success"
                                                            onclick="addCategoryInput()">
                                                            <i class="fas fa-circle-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div id="categoryContainer" class="mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-content d-none" id="step-3">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="desc" class="form-label fw-bold">Description</label>
                                            <textarea class="form-control neumorphic-card" id="desc" name="desc" placeholder="Enter description"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-content d-none" id="step-4">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="imageInput" class="form-label fw-bold">Upload Images</label>
                                            <input type="file" accept="image/*" class="form-control neumorphic-card"
                                                id="imageInput" multiple>
                                            <small class="neu-text">You can upload multiple images</small>
                                            <div id="imagePreviewContainer" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-between">
                            <button type="button" id="prevBtn" class="btn neumorphic-button d-none"><i
                                    class="fas fa-backward me-1"></i>Previous</button>
                            <button type="button" id="nextBtn" class="btn neumorphic-button-outline"><i
                                    class="fas fa-forward me-1"></i>Next</button>
                            <div id="submitBtnContainer" class="d-flex justify-content-end d-none gap-2">
                                <button type="button" id="closeBtn" class="btn neumorphic-button" data-bs-dismiss="modal">
                                    <i class="fas fa-circle-xmark me-1"></i>Cancel
                                </button>
                                <button type="submit" form="addDataForm" id="submitBtn"
                                    class="btn neumorphic-button-outline fw-bold">
                                    <i class="fas fa-save me-1"></i>Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        async function deleteListData(button) {
            let id = button.dataset.id;

            if (!id) {
                notyf.error("ID not found!");
                return;
            }

            const result = await Swal.fire({
                title: "Delete Data?",
                text: "Are you sure you want to delete this article?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Yes, Delete!",
                confirmButtonText: "Cancel"
            });

            if (result.dismiss === Swal.DismissReason.cancel) {
                let deleteResponse = await restAPI(
                    "DELETE",
                    `{{ route('admin.katalog.destroy', ['id' => '__id__']) }}`.replace("__id__", id)
                );

                if (deleteResponse && deleteResponse.status === 200) {
                    await notyf.success("Data deleted successfully.");

                    setTimeout(async () => {
                        window.location.reload();
                    }, 1000);
                } else {
                    notyf.error("Failed to delete data.");
                }
            }
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                modalAddListData(),
                searchListData(),
                setFilterListData(),
                toggleFilterButton(),
            ]);
        }
    </script>
@endsection
