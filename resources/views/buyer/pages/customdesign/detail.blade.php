@extends('buyer.layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">
@endsection

@section('content')
    <section id="main-section" class="main-section bg-green-white">
        <div class="container pt-5 pb-5">
            <div id="skeletonItemName" class="skeleton-text"></div>
            <h3 class="heading fw-bold d-none" id="itemNameData"></h3>
            <div id="skeletonCodeData" class="skeleton-text w-50"></div>
            <h6 class="subtitle h6 mb-3 d-none" id="codeData"></h6>
            <hr>
            <div class="row">
                <div class="col-md-7 mb-3">
                    <div id="carouselContainer" class="mb-3">
                        <div id="skeletonLoader" class="skeleton-box"></div>
                        <img id="imageData" src="" alt="Image Custom Design" class="img-fluid card-radius d-none">
                    </div>
                    <div class="d-flex gap-3">
                        <h6 class="fw-bold text-old-blue" id="statusData"></h6>
                        <h6 class="fw-bold text-old-blue">|</h6>
                        <h6 class="fw-bold text-old-blue">
                            <span class="bi bi-cash-stack me-2"></span>
                            <span id="priceData"></span>
                        </h6>
                    </div>
                    <div>
                        <h3 class="fw-bold">
                            Description
                        </h3>
                        <p id="descData">
                        </p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="neumorphic-card p-3 mb-3 bg-green-young">
                        <h5 class="fw-bold">Design Progress</h5>
                        <hr>
                        <div class="timeline position-relative">
                            <div class="timeline-line"></div>
                            <div id="timelineContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('assets_js')
@endsection

@section('js')
    <script>
        let urlParams = new URLSearchParams(window.location.search);
        let dataParams = urlParams.get('r');
        let storageUrl = '{{ asset('storage/uploads/custom') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'

        async function getDetailData() {
            let requestParams = {
                encrypt: dataParams
            };

            let getDataRest = await restAPI('GET', '{{ route('datadesign.detail') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

                if (getDataRest && getDataRest.status == 200) {
                let itemNameData = document.getElementById("itemNameData");
                let codeData = document.getElementById("codeData");

                let skeletonItemName = document.getElementById("skeletonItemName");
                let skeletonCodeData = document.getElementById("skeletonCodeData");

                itemNameData.innerText = getDataRest.data.data.item_name || "No Name";
                codeData.innerText = getDataRest.data.data.code || "No Code";

                skeletonItemName.remove();
                skeletonCodeData.remove();

                itemNameData.classList.remove("d-none");
                codeData.classList.remove("d-none");

                await setDetailData(getDataRest.data.data);
                await handleViewTimeline();
                await addListData();
            } else {
                console.log(getDataRest);
            }
        }

        function setData(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.innerHTML = value;
            }
        }

        async function setDetailData(data) {
            let statusClass = 'bg-secondary';
            if (data.status === 'Payment Completed') {
                statusClass = 'bg-success';
            } else if (data.status === 'Not Completed') {
                statusClass = 'bg-warning';
            }
            let carouselContainer = document.getElementById("carouselContainer");

            if (data.file.length > 0) {
                let images = data.file.map(file => `${storageUrl}/${file.file_name}`);

                if (images.length > 1) {
                    let carouselHTML = `
                        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                ${images.map((img, index) => `
                                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                            <img src="${img}" class="d-block w-100 img-fluid card-radius" alt="Slide ${index + 1}">
                                        </div>
                                    `).join('')}
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    `;
                    carouselContainer.innerHTML = carouselHTML;

                    let carousel = new bootstrap.Carousel(document.getElementById('imageCarousel'), {
                        interval: 2000, // 2 detik
                        ride: "carousel"
                    });

                } else {
                    carouselContainer.innerHTML =
                        `<img id="imageData" src="${images[0]}" class="img-fluid card-radius">`;
                }
            } else {
                carouselContainer.innerHTML =
                `<img id="imageData" src="${imageNullUrl}" class="img-fluid card-radius">`;
            }

            setData('itemNameData', data.item_name);
            setData('codeData', data.code_design);
            setData('statusData', data.status ?
                `<span class="neumorphic-card text-white px-2 py-1 ${statusClass}">${data.status}</span>` : '-');
            setData('priceData', data.price ? `<i class="bi bi-currency-dollar"></i> ${data.price.toLocaleString()}` :
                '-');
            setData('descData', data.desc ? data.desc : 'No description available.');

            setTimelineItems(encodeURIComponent(data.id), data.tracking);

            function setTimelineItems(id, trackingData) {
                const timelineContainer = document.getElementById(
                    "timelineContainer");
                timelineContainer.innerHTML = "";

                trackingData.forEach((data, index) => {
                    const statusClass = data.status === "completed" ?
                        "bg-success shadow-success" :
                        (data.status === "in_progress" ? "bg-primary shadow-primary" : "bg-secondary");

                    const iconClass = data.status === "completed" ?
                        "fa-check" :
                        (data.status === "in_progress" ? "fa-spinner fa-spin" : "fa-hourglass-start");

                    const statusTextClass = data.status === "completed" ?
                        "bg-success" :
                        (data.status === "in_progress" ? "bg-primary" : "bg-secondary");

                    const completedAt = data.completed_at ?
                        `<small class="text-success fw-bold" style="font-size: 11px;">${new Date(data.completed_at).toLocaleString()}</small>` :
                        "";

                    const div = document.createElement("div");
                    div.className = `timeline-item ${data.status} d-flex align-items-start mb-4`;
                    div.innerHTML = `
                            <div class="timeline-marker rounded-circle me-3 d-flex align-items-center justify-content-center ${statusClass}">
                                <i class="fas ${iconClass} text-white"></i>
                            </div>
                            <div class="timeline-content neumorphic-card p-3 bg-green-white">
                                <div class="d-flex flex-column flex-sm-row justify-content-between">
                                    <h4><i class="fas fa-step-forward me-1"></i> Step ${index + 1}: ${data.step_name}</h4>
                                    <div class="d-flex flex-row flex-sm-column align-items-center align-items-sm-end gap-2 mt-2 mt-sm-0">
                                        <small class="neumorphic-card text-white px-2 py-1 ${statusTextClass}">
                                            ${data.status.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}
                                        </small>
                                        ${completedAt}
                                    </div>
                                </div>
                                <hr>
                                <div class="formContainer">${setTimelineForm(id, data)}</div>
                            </div>
                        `;
                    timelineContainer.appendChild(div);
                });
            }

            function setTimelineForm(id, data) {
                if (data.status === 'pending') {
                    return `
                            <div class="neumorphic-card p-3 text-center">
                                <i class="fa fa-lock fa-2x mb-2"></i>
                                <h5>The previous step is still in the process</h5>
                                <p>Please wait, each process is done sequentially and is being worked on.</p>
                            </div>
                        `;
                }

                return `
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="neumorphic-card p-3">
                                    <span class="fw-bold">
                                        <i class="fas fa-sticky-note me-1"></i>Note:
                                    </span>
                                    <p>${data.notes ?? '-'}</p>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="neumorphic-card p-3">
                                    <span class="fw-bold">
                                        <i class="fas fa-paperclip me-1"></i>Attachment:
                                    </span>
                                    ${data.status !== 'completed' ? `Still in progress` : ''}
                                    ${data.file_name ? setAttachments(data.file_name) : data.status === 'completed' ? '<p class="mt-2 mb-2"><i class="fas fa-paperclip me-1"></i>No attachments available.</p>' : ''}
                                </div>
                            </div>
                        </div>
                        `;
            }

            function setAttachments(data) {
                let files = Array.isArray(data) ? data : [data];
                return `
                            <div class="d-flex align-items-center gap-2 flex-wrap ms-4">
                                ${files.map(file => `
                                                                                                    <div class="position-relative" style="display: inline-block;">
                                                                                                        <img src="/storage/uploads/tracking/${file}" class="img-thumbnail card-radius" style="max-width: 100px; cursor: pointer;" onclick="showFilePreview('/storage/uploads/tracking/${file}')">
                                                                                                        <button class="btn btn-sm neumorphic-button position-absolute top-0 end-0 m-1 p-1" style="background: rgba(0, 0, 0, 0.6); border-radius: 50%;" onclick="showFilePreview('/storage/uploads/tracking/${file}')">
                                                                                                            <i class="fas fa-eye text-white"></i>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                `).join('')}
                            </div>
                        `;
            }
        }

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

                        const postData = await restAPI("PUT", actionUrl, formData);

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
                getDetailData(),
            ]);
        }
    </script>
@endsection
