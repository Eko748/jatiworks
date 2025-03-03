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
                            <label for="filterStatus" class="form-label">Status</label>
                            <select id="filterStatus" class="form-control" multiple>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
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
                            <th class="text-wrap align-top">Status</th>
                            <th class="text-wrap align-top">Image</th>
                            <th class="text-wrap align-top">Code Design</th>
                            <th class="text-wrap align-top">Buyer</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Description</th>
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
@endsection

@section('assets_js')
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/cropper.min.js') }}"></script>
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
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
        let storageUrl = '{{ asset('storage/uploads/custom/') }}'
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}'

        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter = {}) {
            let requestParams = {
                page: currentPage,
                limit: defaultLimitPage,
                ascending: defaultAscending,
                ...customFilter
            };

            if (defaultSearch.trim() !== '') {
                requestParams.search = defaultSearch;
            }

            loadListData();

            let getDataRest = await restAPI('GET', '{{ route('getdatadesign') }}', requestParams)
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
                                    <li><a class="dropdown-item" href="#" onclick="updateStatus('${data.id}', '${item.value}')">${item.text}</a></li>
                                `).join('')}
                    </ul>
                </div>
            ` :
            `<div class="badge border px-2 py-1 ${statusData.class}">${statusData.icon} ${data?.status ?? '-'}</div>`;

            let images = data?.file.length ? data.file.map(f => `${storageUrl}/${f.file_name}`) : [imageNullUrl];

            let actions = `
                <a href="{{ route('admin.custom.detail') }}?r=${encodeURIComponent(data.id)}" class="btn btn-sm neumorphic-button">
                    <i class="fas fa-eye me-1"></i>Detail
                </a>
            `;
            return {
                id: data?.id ?? '-',
                code_design: data?.code_design ?? '-',
                item_name: data?.item_name ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                price: data?.price ?? '-',
                weight: data?.weight ?? '-',
                desc: data?.desc ?? '-',
                status: statusHtml,
                images,
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
                    <td>${element.code_design}</td>
                    <td>${element.buyer_name}</td>
                    <td>${element.item_name}</td>
                    <td>${element.desc}</td>
                    <td>${element.price}</td>
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
            let selectedOptions = Array.from(document.getElementById("filterStatus").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let filterData = {
                status: selectedOptions.length ? selectedOptions : null
            };

            let resetActions = {
                resetSelect: () => document.querySelectorAll(".ss-value-delete").forEach(el => el.click())
            };

            return [filterData, resetActions];
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                searchListData(),
                setFilterListData(),
                toggleFilterButton(),
                multiSelectData('#filterStatus', 'Select Status'),
            ]);
        }
    </script>
@endsection
