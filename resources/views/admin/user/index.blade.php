@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center pb-3 gap-1 flex-wrap">
                <button type="button" class="add-data neumorphic-button btn btn-md">
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
                        <div class="col-md-6">
                            <label for="filterStatusLogin" class="form-label">Status Login</label>
                            <select id="filterStatusLogin" class="form-control" multiple>
                                <option value="Online">Online</option>
                                <option value="Online">Offline</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filterRole" class="form-label">Role</label>
                            <select id="filterRole" class="form-control" multiple>
                                <option value="1">Admin</option>
                                <option value="2">Buyer</option>
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
                            <th class="text-wrap align-top">Name</th>
                            <th class="text-wrap align-top">Email</th>
                            <th class="text-wrap align-top">Role</th>
                            <th class="text-wrap align-top">Status Login</th>
                            <th class="text-wrap align-top">Last Login</th>
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

            let getDataRest = await restAPI('GET', '{{ route('getdatauser') }}', requestParams)
                .then(response => response)
                .catch(error => error.response);

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleData(item))
                );
                await setListData(handleDataArray, getDataRest.data.pagination);
            } else {
                errorListData(getDataRest);
            }
        }

        async function handleData(data) {
            let statusClass = 'badge border px-2 py-1 ';
            if (data.status === 'Online') {
                statusClass += 'text-success border-success';
            } else {
                statusClass += 'text-danger border-danger';
            }

            return {
                id: data?.id ?? '-',
                name: data?.name ?? '-',
                role_name: data?.role_name ?? '-',
                email: data?.email ?? '-',
                last_login_at: data?.last_login_at ?? '-',
                status: `<span class="${statusClass}">${data?.status ?? '-'}</span>`
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
                    <td>${element.name}</td>
                    <td>${element.email}</td>
                    <td>${element.role_name}</td>
                    <td>${element.status}</td>
                    <td>${element.last_login_at}</td>
                </tr>`;
            });

            renderListData(getDataTable, pagination, display_from, display_to);
        }


        async function getFilterListData() {
            let selectedStatusLogin = Array.from(document.getElementById("filterStatusLogin").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let selectedRoles = Array.from(document.getElementById("filterRole").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let filterData = {
                status_login: selectedStatusLogin.length ? selectedStatusLogin : null,
                role: selectedRoles.length ? selectedRoles : null
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
                multiSelectData('#filterStatusLogin', 'Select Status Login'),
                multiSelectData('#filterRole', 'Select Role'),
            ])
        }
    </script>
@endsection
