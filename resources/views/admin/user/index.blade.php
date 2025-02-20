@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('css')
    <style>
        .neumorphic-inset {
            background: #e0e5ec;
            border-radius: 10px;
            box-shadow: inset 5px 5px 10px #b8baba, inset -5px -5px 10px #ffffff;
        }

        .table thead th {
            background: #e0e5ec;
            box-shadow: inset 3px 3px 6px #b8baba, inset -3px -3px 6px #ffffff;
            border: none;
        }

        .table tbody td {
            background: #e0e5ec;
            border: none;
        }

        .table tbody tr:hover {
            background: #d1d9e6;
        }

        .pagination .page-item .page-link {
            background: #e0e5ec;
            border: none;
            border-radius: 5px;
            box-shadow: 3px 3px 6px #b8baba, -3px -3px 6px #ffffff;
        }

        .pagination .page-item .page-link:hover {
            background: #d1d9e6;
        }
    </style>
@endsection

@section('content')
    <main id="main-content" class="flex-grow-1 p-4 position-relative">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-3 gap-3">
                    <input id="tb-search" class="tb-search form-control neumorphic-card mb-2 mb-lg-0" type="search"
                        name="search" placeholder="Search Data" aria-label="search" style="width: 200px;">
                    <select name="limitPage" id="limitPage" class="form-control neumorphic-card" style="width: auto;">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="table-responsive neumorphic-card p-3 mb-3">
                    <table class="table table-striped m-0">
                        <thead>
                            <tr class="tb-head">
                                <th class="text-center text-wrap align-top">No</th>
                                <th class="text-wrap align-top">Name</th>
                                <th class="text-wrap align-top">Role</th>
                                <th class="text-wrap align-top">Email</th>
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
                        <ul class="pagination justify-content-center justify-content-md-end neumorphic p-2"
                            id="pagination-js">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
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

        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let filterParams = {}

            let getDataRest = await renderAPI(
                'GET',
                '{{ route('getdatauser') }}', {
                    page: page,
                    limit: limit,
                    ascending: ascending,
                    search: search,
                    ...filterParams
                }
            ).then(function(response) {
                return response
            }).catch(function(error) {
                let resp = error.response
                return resp
            })

            if (getDataRest && getDataRest.status == 200 && Array.isArray(getDataRest.data.data)) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleData(item))
                )
                await setListData(handleDataArray, getDataRest.data.pagination)
            } else {
                let errorMessage = getDataRest?.data?.message || 'Data gagal dimuat'
                let errorRow = `
                <tr class="text-dark">
                    <th class="text-center" colspan="${$('.tb-head th').length}"> ${errorMessage} </th>
                </tr>`
                document.getElementById('listData').innerHTML = errorRow;
                document.getElementById('countPage').textContent = "0 - 0";
                document.getElementById('totalPage').textContent = "0";
            }
        }

        async function handleData(data) {
            return {
                id: data?.id ?? '-',
                name: data?.name ?? '-',
                role_name: data?.role_name ?? '-',
                email: data?.email ?? '-',
                last_login_at: data?.last_login_at ?? '-',
            }
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total_pages
            currentPage = pagination.current_page
            let display_from = ((defaultLimitPage * (currentPage - 1)) + 1)
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total)

            let getDataTable = ''
            let classCol = 'align-center text-dark text-wrap'
            dataList.forEach((element, index) => {
                getDataTable += `
                    <tr class="text-dark">
                        <td class="${classCol} text-center">${display_from + index}.</td>
                        <td class="${classCol}">${element.name}</td>
                        <td class="${classCol}">${element.role_name}</td>
                        <td class="${classCol}">${element.email}</td>
                        <td class="${classCol}">${element.last_login_at}</td>
                    </tr>`
            })

            document.getElementById('listData').innerHTML = getDataTable;
            document.getElementById('totalPage').textContent = pagination.total;
            document.getElementById('countPage').textContent = `${display_from} - ${display_to}`;

            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                new bootstrap.Tooltip(el);
            });

            renderPagination()
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter)
            ])
        }
    </script>
@endsection
