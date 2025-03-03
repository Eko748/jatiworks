@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('assets_css')
    <link rel="stylesheet" href="{{ asset('assets/css/cropper.min.css') }}">
@endsection

@section('css')
    <style>
        .timeline-item.completed .timeline-line {
            background: #28a745;
        }

        .timeline-item.in_progress .timeline-line {
            background: #ffc107;
        }

        .timeline-item.pending .timeline-line {
            background: #6c757d;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-line {
            position: absolute;
            width: 4px;
            background: #b9b9b9;
            top: 0;
            height: 100%;
            left: 45px;
            z-index: 1;
        }

        .timeline-item {
            position: relative;
            display: flex;
            align-items: start;
        }

        .timeline-marker {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: inset 1px 1px 2px var(--shadow-dark), inset -1px -1px 2px var(--shadow-light);
            position: relative;
            z-index: 2;
            background: white;
            border: 4px solid #ccc;
        }

        .timeline-marker i {
            transition: transform 0.3s ease-in-out;
        }

        .timeline-marker:hover i {
            transform: scale(1.2);
        }

        .timeline-marker {
            animation: fadeInScale 0.5s ease-in-out;
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 576px) {
            .timeline {
                padding-left: 15px;
            }

            .timeline-line {
                left: 25px;
            }

            .timeline-marker {
                width: 24px;
                height: 24px;
                border-width: 3px;
            }

            .timeline-item {
                flex-direction: column;
                align-items: start;
                text-align: start;
                margin-left: 10px;
            }

            .timeline-content {
                width: 100%;
                max-width: 90%;
            }
        }

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

@section('back')
    <a href="{{ route('admin.order.index') }}" class="btn btn-outline-dark neumorphic-button" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Back to {{ $title }} page" onclick="hideTooltip(this)">
        <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="neumorphic-card p-3 mb-3">
                <h5 class="fw-bold">Order Progress</h5>
                <hr>
                @if ($order->status->label() === 'Waiting for Payment')
                    <div class="text-center fw-bold">
                        {{ $order->status->label() }}
                    </div>
                @else
                    <div class="timeline position-relative">
                        <div class="timeline-line"></div>
                        @foreach ($order->orderTracking->sortBy('trackingStep.step_order') as $index => $tracking)
                            <div class="timeline-item {{ $tracking->status }} d-flex align-items-start mb-4">
                                <div
                                    class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center
                                    {{ $tracking->status === 'completed' ? 'bg-success shadow-success' : ($tracking->status === 'in_progress' ? 'bg-primary shadow-primary' : 'bg-secondary') }}">
                                    <i
                                        class="fas {{ $tracking->status === 'completed' ? 'fa-check' : ($tracking->status === 'in_progress' ? 'fa-spinner fa-spin' : 'fa-hourglass-start') }} text-white"></i>
                                </div>
                                <div class="timeline-content neumorphic-card2 p-3">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between">
                                        <h6><i class="fas fa-step-forward me-1"></i> Step {{ $index + 1 }}:
                                            {{ $tracking->trackingStep->step_name }}
                                        </h6>
                                        <div
                                            class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end gap-2 mt-2 mt-sm-0">
                                            <small
                                                class="neumorphic-card2 text-white px-2 py-1
                                                {{ $tracking->status === 'completed' ? 'bg-success' : ($tracking->status === 'in_progress' ? 'bg-primary' : 'bg-secondary') }}">
                                                {{ ucfirst($tracking->status) }}
                                            </small>
                                            @if ($tracking->completed_at)
                                                <small class="text-success fw-bold" style="font-size: 11px;">
                                                    {{ $tracking->completed_at->format('d M Y H:i') }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    @if ($tracking->status !== 'pending')
                                        <form action="{{ route('order.updateTracking', $tracking->id_order) }}"
                                            class="mt-3 addDataForm">
                                            @method('PUT')
                                            <input type="hidden" name="id_order_tracking" value="{{ $tracking->id }}">
                                            <input type="hidden" name="id_tracking_step"
                                                value="{{ $tracking->id_tracking_step }}">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">
                                                        @if ($tracking->status === 'completed')
                                                            <i class="fas fa-edit me-1"></i>
                                                            Update Note
                                                        @else
                                                            <i class="fas fa-sticky-note me-1"></i>
                                                            Add Note
                                                        @endif
                                                    </label>
                                                    <textarea name="notes" class="form-control neumorphic-card" rows="2" placeholder="Enter note">{{ $tracking->notes }}</textarea>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    @if ($tracking->status !== 'completed')
                                                        <label class="form-label"><i class="fas fa-paperclip me-1"></i>
                                                            Upload
                                                            Image</label>
                                                        <input type="file" id="imageInput"
                                                            class="form-control neumorphic-card" accept="image/*" multiple>
                                                        <small class="ms-1">You can upload maximum 3 images</small>
                                                        <div id="imagePreviewContainer" class="ms-1 mt-3"></div>
                                                    @endif
                                                    @if ($tracking->file_name)
                                                        <p class="mt-2 mb-2"><i class="fas fa-paperclip me-1"></i>
                                                            Attachment:</p>
                                                        <div class="d-flex align-items-center gap-2 flex-wrap ms-4">
                                                            @php
                                                                $decodedFiles = json_decode($tracking->file_name, true);
                                                                $files = is_array($decodedFiles)
                                                                    ? $decodedFiles
                                                                    : [$tracking->file_name];
                                                            @endphp
                                                            @foreach ($files as $file)
                                                                <div class="position-relative"
                                                                    style="display: inline-block;">
                                                                    <img src="{{ asset('storage/uploads/tracking/' . $file) }}"
                                                                        class="img-thumbnail card-radius"
                                                                        style="max-width: 100px; cursor: pointer;"
                                                                        onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $file) }}')">
                                                                    <button
                                                                        class="btn btn-sm neumorphic-button position-absolute top-0 end-0 m-1 p-1"
                                                                        style="background: rgba(0, 0, 0, 0.6); border-radius: 50%;"
                                                                        onclick="showFilePreview('{{ asset('storage/uploads/tracking/' . $file) }}')">
                                                                        <i class="fas fa-eye text-white"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        @if ($tracking->status === 'completed')
                                                            <p class="mt-2 mb-2"><i class="fas fa-paperclip me-1"></i>No
                                                                attachments
                                                                available.</p>
                                                        @endif
                                                    @endif
                                                </div>
                                                @if ($tracking->status !== 'completed')
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label"><i class="fas fa-tasks me-1"></i> Update
                                                            Status</label>
                                                        <select name="status" class="form-select neumorphic-card">
                                                            <option value="in_progress"
                                                                {{ $tracking->status === 'in_progress' ? 'selected' : '' }}>
                                                                In
                                                                Progress</option>
                                                            <option value="completed"
                                                                {{ $tracking->status === 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-md-12 mb-3 text-center text-md-end">
                                                    @if ($tracking->status === 'completed')
                                                        <button type="submit"
                                                            class="btn neumorphic-button fw-bold save-data">
                                                            <i class="fas fa-edit me-1"></i>
                                                            Edit Changes
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="btn neumorphic-btn-success fw-bold save-data">
                                                            <i class="fas fa-save me-1"></i>
                                                            Save Changes
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="neumorphic-card2 p-3">
                                            <div class="text-center">
                                                <i class="fa fa-lock fa-2x mb-2"></i>
                                                <h5>Complete the Previous Steps</h5>
                                                <p>Make sure you have completed the previous steps before proceeding.</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
        <div class="col-md-4">
            <div class="col-md-12 mb-3">
                <div class="neumorphic-card p-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between">
                        <h5 class="mb-0 fw-bold">Order Information</h5>
                        <span>#Code Order: <strong
                                class="neumorphic-card2 text-white px-2 py-1 bg-success">{{ $order->code_order }}</strong></span>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Status:</span>
                                <span
                                    class="neumorphic-card2 fw-bold text-white px-2
                                        {{ $order->status->label() === 'Not Completed'
                                            ? 'bg-warning'
                                            : ($order->status->label() === 'Waiting for Payment'
                                                ? 'bg-info'
                                                : 'bg-success') }}">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-cube me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Item Name:</span>
                                <span>{{ $order->id_katalog ? $order->katalog->item_name : $order->item_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-industry me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Material:</span>
                                <span>{{ $order->id_katalog ? $order->katalog->material : $order->material }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-ruler-combined me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Dimensions:</span>
                                <span>
                                    L
                                    {{ $orderDetails['length'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                    x W
                                    {{ $orderDetails['width'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                    x H
                                    {{ $orderDetails['height'] }}{{ $order->id_katalog ? $order->katalog->unit : $order->unit }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-weight-hanging me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Weight:</span>
                                <span>{{ $order->id_katalog ? $order->katalog->weight : $order->weight }} kg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-sticky-note me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Description:</span>
                                <span>{{ $order->id_katalog ? $order->katalog->desc : $order->desc }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="neumorphic-card p-3">
                    <h5 class="fw-bold">Buyer Information</h5>
                    <hr>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-user-circle me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Name:</span>
                                <span>{{ $order->user->name }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-envelope me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Email:</span>
                                <span>{{ $order->user->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-phone me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Phone:</span>
                                <span>{{ $order->user->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-start mb-2 neumorphic-card2 p-2">
                            <i class="fas fa-map-marker-alt me-2 mt-1"></i>
                            <div>
                                <span class="fw-bold d-block">Address:</span>
                                <span>{{ $order->user->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
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
        </div>
    </div>
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/cropper.min.js') }}"></script>
@endsection

@section('js')
    <script>
        function showFilePreview(fileUrl) {
            document.getElementById('previewImage').src = fileUrl;
            var modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            modal.show();
        }

        function handleViewTimeline() {
            const timelineContents = document.querySelectorAll(".timeline-content");

            if (timelineContents.length > 0) {
                let maxWidth = 0;

                timelineContents.forEach(el => {
                    let width = el.offsetWidth;
                    if (width > maxWidth) {
                        maxWidth = width;
                    }
                });

                timelineContents.forEach(el => {
                    el.style.width = maxWidth + "px";
                });
            }
        }

        async function uploadMultiImage() {
            let cropper;
            let imageFiles = [];
            let croppedImages = [];
            let currentImageIndex = 0;

            const MAX_IMAGES = 3;

            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");
            const cropImageModal = new bootstrap.Modal(document.getElementById("cropImageModal"));
            const cropImageBtn = document.getElementById("cropImageBtn");
            const imagePreviewContainer = document.getElementById("imagePreviewContainer");

            imageInput.addEventListener("change", function(event) {
                if (croppedImages.length >= MAX_IMAGES) {
                    notyf.error(
                        `Maximum of ${MAX_IMAGES} images allowed. Delete an image before adding a new one.`);
                    imageInput.value = "";
                    return;
                }

                const newFiles = Array.from(event.target.files);

                if (newFiles.length + croppedImages.length > MAX_IMAGES) {
                    notyf.error(`You can only add ${MAX_IMAGES - croppedImages.length} more images.`);
                    imageInput.value = "";
                    return;
                }

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
                    if (croppedImages.length >= MAX_IMAGES) {
                        notyf.error(`Maximum of ${MAX_IMAGES} images allowed.`);
                        return;
                    }

                    const index = croppedImages.length;
                    croppedImages.push(blob);

                    let wrapper = document.createElement("div");
                    wrapper.classList.add("cropped-image-wrapper", "position-relative",
                        "d-inline-block", "me-2");
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
                        let deleteIndex = croppedImages.indexOf(blob);
                        if (deleteIndex !== -1) {
                            croppedImages.splice(deleteIndex, 1);
                        }
                        wrapper.remove();

                        if (croppedImages.length < MAX_IMAGES) {
                            imageInput.disabled = false;
                            imageInput.classList.remove("d-none");
                        }
                    });

                    wrapper.appendChild(imgElement);
                    wrapper.appendChild(deleteBtn);
                    imagePreviewContainer.appendChild(wrapper);

                    currentImageIndex++;
                    if (currentImageIndex < imageFiles.length && croppedImages.length < MAX_IMAGES) {
                        showCropModal(imageFiles[currentImageIndex]);
                    } else {
                        cropImageModal.hide();
                        imageInput.value = "";
                    }

                    if (croppedImages.length >= MAX_IMAGES) {
                        imageInput.disabled = true;
                        imageInput.classList.add("d-none");
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

        async function addListData() {
            document.querySelectorAll(".addDataForm").forEach(form => {
                form.addEventListener("submit", async function(e) {
                    e.preventDefault();

                    const saveButton = e.submitter;
                    const originalContent = saveButton.innerHTML;
                    if (!saveButton.classList.contains("save-data") || saveButton.disabled) return;

                    const confirmed = await confirmSubmitData(saveButton);
                    if (!confirmed) return;

                    const formData = new FormData(form);
                    const croppedImages = form.querySelectorAll('.cropped-preview');

                    try {
                        await Promise.all(
                            Array.from(croppedImages).map(async (img, index) => {
                                const response = await fetch(img.src);
                                const blob = await response.blob();

                                const now = new Date();
                                const timestamp =
                                    `${String(now.getHours()).padStart(2, "0")}${String(now.getMinutes()).padStart(2, "0")}${String(now.getSeconds()).padStart(2, "0")}_${String(now.getDate()).padStart(2, "0")}${String(now.getMonth() + 1).padStart(2, "0")}${String(now.getFullYear()).slice(-2)}`;

                                const fileName = `${timestamp}_${index}.png`.replace(
                                    /\s+/g, '');
                                formData.append(`file[]`, blob, fileName);
                            })
                        );

                        const actionUrl = form.getAttribute("action");

                        const postData = await restAPI("POST", actionUrl, formData);

                        console.log("postData:", postData);

                        if (postData.status >= 200 && postData.status < 300) {
                            await notyf.success("Data saved successfully.");

                            setTimeout(async () => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            notyf.error("An error occurred while saving data.");
                        }
                    } catch (error) {
                        notyf.error("Failed to save data. Please try again.");
                    } finally {
                        saveButton.disabled = false;
                        saveButton.innerHTML = originalContent;
                    }
                });
            });
        }

        function showFilePreview(fileUrl) {
            const previewModal = document.createElement('div');
            previewModal.style.position = 'fixed';
            previewModal.style.top = '0';
            previewModal.style.left = '0';
            previewModal.style.width = '100%';
            previewModal.style.height = '100%';
            previewModal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            previewModal.style.display = 'flex';
            previewModal.style.alignItems = 'center';
            previewModal.style.justifyContent = 'center';
            previewModal.style.zIndex = '9999';

            const image = document.createElement('img');
            image.src = fileUrl;
            image.style.maxWidth = '90%';
            image.style.maxHeight = '90%';
            image.style.borderRadius = '10px';
            image.style.boxShadow = '0px 0px 10px rgba(255, 255, 255, 0.5)';

            previewModal.onclick = function() {
                document.body.removeChild(previewModal);
            };

            previewModal.appendChild(image);
            document.body.appendChild(previewModal);
        }

        async function initPageLoad() {
            await Promise.all([
                handleViewTimeline(),
                uploadMultiImage(),
                addListData(),
            ]);
        }
    </script>
@endsection
