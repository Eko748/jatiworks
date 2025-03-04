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

        #catalogue-data {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            min-height: 300px;
            width: fit-content;
            margin: auto;
        }

        #catalogue-data .card {
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
            <h3 class="heading fw-bold">Our Collection</h3>
            <h6 class="subtitle h6 mb-3">Explore Our Collection: Timeless Craftsmanship, Global Quality</h6>
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
                <div id="catalogue-data" class="d-flex justify-content-center flex-wrap gap-3"></div>
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
        let storageUrlCatalogue = '{{ asset('storage/uploads/katalog') }}'

        function showErrorMessage(message) {
            let catalogueData = document.getElementById("catalogue-data");
            catalogueData.innerHTML = `
                <div class="alert alert-danger text-center w-100">
                    ${message}
                </div>
            `;
        }

        async function getListDataCatalogue(limit = 8, page = 1, ascending = 0, search = '', customFilter = {}) {
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            let getDataRest = await restAPI('GET', '{{ route('datakatalog') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleListDataCatalogue(item))
                )
                await setListDataCatalogue(handleDataArray, getDataRest.data.pagination)
            } else {
                let errorMessage = "Data gagal dimuat";
                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;
                }

                await showErrorMessage(errorMessage);
            }
        }

        async function handleListDataCatalogue(data) {
            return {
                id: data?.id ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                unit: data?.unit ?? '-',
                weight: data?.weight ?? '-',
                code: data?.code ?? '-',
                dimensions: `${data?.length ?? '-'} x ${data?.width ?? '-'} x ${data?.height ?? '-'}`,
                category: data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-',
                images: data?.file.length ? data.file.map(f => f.file_name) : []
            };
        }

        async function setListDataCatalogue(dataList, pagination) {
            totalPage1 = pagination.total_pages;
            currentPage1 = pagination.current_page;
            let display_from = (pagination.per_page * (currentPage1 - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataHtml = '';

            dataList.forEach((element, index) => {
                let carouselId = `carousel${element.id}-${index}`;

                let imageCarousel = element.images.length ? `
            <div class="position-relative w-100 overflow-hidden">
                <div class="ribbon ribbon-top-right" style="position: absolute; top: -8px; right: -8px; z-index: 10;">
                    <span>New</span>
                </div>
                <div id="${carouselId}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height: 300px;">
                        ${element.images.map((img, i) => `
                                                    <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                        <img src="${storageUrlCatalogue}/${img}" class="d-block w-100 card-radius" style="height: 100%; object-fit: cover;">
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
                        <small class="text-white">Code: ${element.code}</small>
                        <h5 class="fw-bold text-white mb-2 mb-md-0 text-truncate">
                            ${element.item_name}
                        </h5>
                    </div>
                    <hr class="my-0 mb-2 mt-1 text-white">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-layers h6 me-1 fw-bold text-white"></i>
                        <p class="h6 fw-bold text-white mb-0 flex-grow-1">
                            Material: ${element.material}
                        </p>
                    </div>
                    <div class="text-white mt-3">
                        <p class="fw-bold mb-1">Dimensions & Weight:</p>
                        <div class="d-grid gap-1">
                            <div>📏 Length: <span class="fw-bold">${element.dimensions.split(' x ')[0]}${element.unit}</span></div>
                            <div>📐 Width: <span class="fw-bold">${element.dimensions.split(' x ')[1]}${element.unit}</span></div>
                            <div>📏 Height: <span class="fw-bold">${element.dimensions.split(' x ')[2]}${element.unit}</span></div>
                            <div>⚖️ Weight: <span class="fw-bold">${element.weight}kg</span></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="fw-bold text-white mb-1">Category:</p>
                        <div class="d-flex flex-wrap gap-1">
                            ${element.category.split(', ').map(cat => `<span class="badge bg-light text-dark">${cat}</span>`).join('')}
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex flex-wrap gap-1 justify-content-end">
                            <a href="{{ route('index.catalogue.detail') }}?r=${element.id}" class="btn btn-sm btn-success">Read More...</a>
                        </div>
                    </div>
                </div>
            </div>`;
            });

            document.getElementById('catalogue-data').innerHTML = getDataHtml;
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
                        await getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1,
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
                await getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1,
                    defaultSearch1,
                    customFilter1);
            });

            document.querySelectorAll('.tb-search').forEach(input => {
                input.addEventListener('input', debounce(async () => {
                    defaultSearch1 = input.value;
                    currentPage1 = 1;
                    await getListDataCatalogue(defaultLimitPage1, currentPage1,
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
                getListDataCatalogue(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1,
                    customFilter1),
                searchListDataCatalogue(),
            ])
        }
    </script>
@endsection
