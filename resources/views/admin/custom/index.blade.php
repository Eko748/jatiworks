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
                            <th class="text-wrap align-top">Status</th>
                            <th class="text-wrap align-top">Image</th>
                            <th class="text-wrap align-top">Code Design</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Price</th>
                            <th class="text-wrap align-top">Description</th>
                            {{-- <th class="text-wrap align-top">Action</th> --}}
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
        let storageUrl = '{{ asset('storage/uploads/custom/') }}';
        let imageNullUrl = '{{ asset('assets/img/public/image_null.webp') }}';

        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchQuery = '';

            function loadData() {
                const loadingHtml = `
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
                `;
                document.getElementById('listData').innerHTML = loadingHtml;

                const url = new URL('{{ route("getdatadesign") }}', window.location.origin);
                url.searchParams.append('page', currentPage);
                url.searchParams.append('limit', itemsPerPage);
                url.searchParams.append('search', searchQuery);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 200 || data.status === "success") {
                            renderTable(data.data);
                            updatePagination(data.pagination);
                        } else {
                            showError(data.message || 'Failed to load data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('Failed to load data');
                    });
            }

            function renderTable(data) {
                const tableBody = document.getElementById('listData');
                let html = '';

                data.forEach((item, index) => {
                    const images = item.file ? item.file.map(f => `${storageUrl}/${f.file_name}`) : [imageNullUrl];
                    const imageCarousel = `
                        <div id="carousel${item.id}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" style="width: 150px;">
                            <div class="carousel-inner" style="width: 100%; max-height: 100px; overflow: hidden;">
                                ${images.map((img, i) => `
                                    <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                        <img src="${img}" class="d-block w-100" style="max-height: 100px; object-fit: contain;">
                                    </div>
                                `).join('')}
                            </div>
                            ${images.length > 1 ? `
                                <button class="carousel-control-prev neu-text" type="button" data-bs-target="#carousel${item.id}" data-bs-slide="prev">
                                    <i class="fas fa-circle-chevron-left fs-3"></i>
                                </button>
                                <button class="carousel-control-next neu-text" type="button" data-bs-target="#carousel${item.id}" data-bs-slide="next">
                                    <i class="fas fa-circle-chevron-right fs-3"></i>
                                </button>
                            ` : ''}
                        </div>
                    `;

                    html += `
                        <tr>
                            <td class="text-center">${(currentPage - 1) * itemsPerPage + index + 1}</td>
                            <td>${item.status || '-'}</td>
                            <td>${imageCarousel}</td>
                            <td>${item.code_design || '-'}</td>
                            <td>${item.item_name || '-'}</td>
                            <td>${item.price || '-'}</td>
                            <td>${item.desc || '-'}</td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = html;
            }

            function updatePagination(pagination) {
                document.getElementById('countPage').textContent = pagination.total;
                document.getElementById('totalPage').textContent = pagination.total;

                const paginationContainer = document.getElementById('pagination');
                let paginationHtml = '';

                // Previous button
                paginationHtml += `
                    <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page - 1}">&laquo;</a>
                    </li>
                `;

                // Page numbers
                for (let i = 1; i <= pagination.last_page; i++) {
                    paginationHtml += `
                        <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                // Next button
                paginationHtml += `
                    <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page + 1}">&raquo;</a>
                    </li>
                `;

                paginationContainer.innerHTML = paginationHtml;

                // Add click events to pagination links
                paginationContainer.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.dataset.page);
                        if (page && !this.parentElement.classList.contains('disabled')) {
                            currentPage = page;
                            loadData();
                        }
                    });
                });
            }

            function showError(message) {
                const errorHtml = `
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            <i class="fas fa-circle-exclamation me-2"></i>
                            ${message}
                        </td>
                    </tr>
                `;
                document.getElementById('listData').innerHTML = errorHtml;
            }

            // Event Listeners
            document.getElementById('searchPage').addEventListener('input', function() {
                searchQuery = this.value;
                currentPage = 1;
                loadData();
            });

            document.getElementById('limitPage').addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                currentPage = 1;
                loadData();
            });

            // Initial load
            loadData();
        });
    </script>
@endsection
