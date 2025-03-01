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

            <div class="table-responsive neumorphic-card p-3 mb-3">
                <table class="table m-0">
                    <thead>
                        <tr class="tb-head">
                            <th class="text-center text-wrap align-top">No</th>
                            <th class="text-wrap align-top">Code Design</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Price</th>
                            <th class="text-wrap align-top">Description</th>
                            <th class="text-wrap align-top">Status</th>
                            <th class="text-wrap align-top">Files</th>
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
                <nav aria-label="Page navigation" class="d-flex justify-content-center">
                    <ul class="pagination mb-0" id="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('assets_js')
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
            return {
                id: data?.id ?? '-',
                code_design: data?.code_design ?? '-',
                item_name: data?.item_name ?? '-',
                price: data?.price ?? '-',
                desc: data?.desc ?? '-',
                status: data?.status ?? '-',
                files: data?.file?.map(f => `<a href="/storage/files/${f.file_name}" target="_blank">${f.file_name}</a>`).join('<br>') ?? '-'
            };
        }

        async function setListData(data, pagination) {
            let html = '';
            data.forEach((item, index) => {
                html += `
                    <tr>
                        <td class="text-center">${(pagination.current_page - 1) * pagination.per_page + index + 1}</td>
                        <td>${item.code_design}</td>
                        <td>${item.item_name}</td>
                        <td>${item.price}</td>
                        <td>${item.desc}</td>
                        <td>${item.status}</td>
                        <td>${item.files}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${item.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#listData').html(html);
            updatePagination(pagination);
        }

        async function loadListData() {
            $('#listData').html(`
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading data...</span>
                        </div>
                    </td>
                </tr>
            `);
        }

        function errorListData(error) {
            $('#listData').html(`
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        ${error?.data?.message || 'Failed to load data'}
                    </td>
                </tr>
            `);
        }

        function updatePagination(pagination) {
            $('#countPage').text(pagination.total);
            $('#totalPage').text(pagination.total);
            
            let paginationHtml = '';
            const currentPage = pagination.current_page;
            const lastPage = pagination.last_page;

            // Previous button
            paginationHtml += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `;

            // Page numbers
            for (let i = 1; i <= lastPage; i++) {
                paginationHtml += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            // Next button
            paginationHtml += `
                <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `;

            $('#pagination').html(paginationHtml);

            // Add click event listeners to pagination
            $('.page-link').on('click', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page && !$(this).parent().hasClass('disabled')) {
                    currentPage = page;
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                }
            });
        }

        $(document).ready(function() {
            getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);

            $('#searchPage').on('input', function() {
                defaultSearch = $(this).val();
                currentPage = 1;
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            });

            $('#limitPage').on('change', function() {
                defaultLimitPage = $(this).val();
                currentPage = 1;
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            });
        });
    </script>
@endsection