@extends('buyer.layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">
@endsection

@section('content')
    <section id="main-section" class="main-section bg-green-white">
        <div class="container pt-5 pb-5">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div id="skeletonItemName" class="skeleton-text"></div>
                    <h3 class="heading fw-bold d-none" id="itemNameData"></h3>
                    <div id="skeletonCodeData" class="skeleton-text w-50"></div>
                    <h6 class="subtitle h6 mb-3 d-none" id="codeData"></h6>
                </div>
                <a href="{{ url()->previous() }}" type="button" id="toggleFilter"
                    class="filter-data btn-success btn btn-md">
                    <i class="fas fa-circle-chevron-left"></i><span class="d-none d-sm-inline ms-1">Back</span>
                </a>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-7 mb-3">
                    <div id="carouselContainer" class="mb-3">
                        <div id="skeletonLoader" class="skeleton-box"></div>
                        <img id="imageData" src="" alt="Image Catalogue" class="img-fluid card-radius d-none">
                    </div>
                    <div class="d-flex gap-3">
                        <h6 class="fw-bold text-old-blue" id="lengthData"></h6>
                        <h6 class="fw-bold text-old-blue">|</h6>
                        <h6 class="fw-bold text-old-blue" id="widthData"></h6>
                        <h6 class="fw-bold text-old-blue">|</h6>
                        <h6 class="fw-bold text-old-blue" id="heightData"></h6>
                        <h6 class="fw-bold text-old-blue">|</h6>
                        <h6 class="fw-bold text-old-blue" id="weightData"></h6>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="neumorphic-card p-3 mb-3 bg-green-young">
                        <h4 class="fw-bold mb-0">Detail Catalogue</h4>
                    </div>
                    <hr>
                    <div class="neumorphic-card p-3 mb-3 bg-green-young">
                        <h5 class="fw-bold">Material</h5>
                        <span id="materialData"></span>
                        <hr>
                        <h5 class="fw-bold">Description</h5>
                        <span id="descData"></span>
                        <hr>
                        <h5 class="fw-bold">Category</h5>
                        <div class="d-flex flex-wrap gap-1" id="categoryData"></div>
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
        let storageUrl = '{{ asset('storage/uploads/katalog') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'

        async function getDetailData() {
            let requestParams = {
                encrypt: dataParams
            };

            let getDataRest = await restAPI('GET', '{{ route('datacatalogue.detail') }}', requestParams)
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
                        interval: 2000,
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

            let category = data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-';

            setData('itemNameData', data.item_name);
            setData('codeData',`Code Catalogue : ${data.code}`);
            setData('materialData', data.material);
            setData('lengthData', data.length ? `Length: ${data.length}${data.unit}` : '-');
            setData('widthData', data.width ? `Width: ${data.width}${data.unit}` : '-');
            setData('heightData', data.height ? `Height: ${data.height}${data.unit}` : '-');
            setData('weightData', data.weight ? `Weight: ${data.weight}kg` : '-');
            setData('priceData', data.price ? `<i class="bi bi-currency-dollar"></i> ${data.price.toLocaleString()}` :
                '-');
            setData('descData', data.desc ? data.desc : 'No description available.');
            setData('categoryData', data.category ?
                `${category.split(', ').map(cat => `<span class="badge bg-light text-dark">${cat}</span>`).join('')}` :
                '-');
        }

        async function initPageLoad() {
            await Promise.all([
                getDetailData(),
            ]);
        }
    </script>
@endsection
