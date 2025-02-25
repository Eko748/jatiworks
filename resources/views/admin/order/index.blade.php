@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('assets_css')
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
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
                            <th class="text-wrap align-top">Buyer</th>
                            <th class="text-wrap align-top">Item Name</th>
                            <th class="text-wrap align-top">Material</th>
                            <th class="text-wrap align-top">Weight (kg)</th>
                            <th class="text-wrap align-top">Dimensions (l x w x h)</th>
                            <th class="text-wrap align-top">Unit</th>
                            <th class="text-wrap align-top">Qty</th>
                            <th class="text-wrap align-top">Price</th>
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
                    <h5 class="modal-title fw-bold" id="addDataModalLabel">Add New Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDataForm">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control neumorphic-card" id="title" name="title"
                                    placeholder="Enter title" autocomplete="off" required>
                            </div>
                            <div class="col-md-12">
                                <label for="desc" class="form-label fw-bold">Description</label>
                                <textarea class="form-control neumorphic-card" id="desc" name="desc" placeholder="Enter description"
                                    rows="4" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="file_name" class="form-label fw-bold">Upload Image</label>
                                <input type="file" class="form-control neumorphic-card" id="article" name="article"
                                    accept="image/*" required>
                            </div>
                            <div class="col-md-12">
                                <label for="date_range" class="form-label fw-bold">Content Date Range</label>
                                <input type="text" class="form-control neumorphic-card" id="date_range"
                                    name="date_range" placeholder="Select date range" autocomplete="off" required>
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
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
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

            let getDataRest = await restAPI('GET', '{{ route('getdataorder') }}', requestParams)
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
            let statusClass = 'badge border px-2 py-1 ';
            let statusIcon = '';

            switch (data.status) {
                case 'Payment Completed':
                    statusClass += 'text-success border-success';
                    statusIcon = '<i class="fas fa-check-circle"></i>';
                    break;
                case 'Waiting for Payment':
                    statusClass += 'text-info border-info';
                    statusIcon = '<i class="fas fa-clock"></i>';
                    break;
                case 'Not Completed':
                    statusClass += 'text-danger border-danger';
                    statusIcon = '<i class="fas fa-times-circle"></i>';
                    break;
                default:
                    statusClass += 'text-secondary border-secondary';
                    statusIcon = '<i class="fas fa-question-circle"></i>';
            }

            return {
                id: data?.id ?? '-',
                buyer_name: data?.buyer_name ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                unit: data?.unit ?? '-',
                weight: data?.weight ?? '-',
                qty: data?.qty ?? '-',
                price: data?.price ?? '-',
                dimensions: `${data?.length ?? '-'} x ${data?.width ?? '-'} x ${data?.height ?? '-'}`,
                status: `<span class="${statusClass}">${statusIcon} ${data?.status ?? '-'}</span>`,
            };
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total_pages;
            currentPage = pagination.current_page;
            let display_from = (defaultLimitPage * (currentPage - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataTable = '';
            dataList.forEach((element, index) => {
                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td>${element.status}</td>
                    <td>${element.buyer_name}</td>
                    <td>${element.item_name}</td>
                    <td>${element.material}</td>
                    <td>${element.weight}</td>
                    <td>${element.dimensions}</td>
                    <td>${element.unit}</td>
                    <td>${element.qty}</td>
                    <td>${element.price}</td>
                </tr>`;
            });

            renderListData(getDataTable, pagination, display_from, display_to);
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

                const dateRangeValue = document.getElementById("date_range").value;
                if (dateRangeValue) {
                    const dateRangeArray = dateRangeValue.split(
                        " to ");
                    if (dateRangeArray.length === 2) {
                        formData.append("start_date", dateRangeArray[0]);
                        formData.append("end_date", dateRangeArray[1]);
                    }
                }

                try {
                    const postData = await restAPI('POST', '{{ route('admin.article.store') }}', formData);

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

            form.querySelectorAll(".ss-value-delete").forEach(el => el.click());

            const categoryContainer = form.querySelector('#categoryContainer');
            if (categoryContainer) categoryContainer.innerHTML = '';

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

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                searchListData(),
                setFilterListData(),
                addListData(),
                toggleFilterButton(),
                dateRangeInput('#date_range'),
                dateRangeInput('#filterDateRange')
            ])
        }
    </script>
@endsection
