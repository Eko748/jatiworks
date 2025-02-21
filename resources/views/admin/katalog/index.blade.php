@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('css')
@endsection

@section('content')
    <main id="main-content" class="flex-grow-1 p-4 position-relative">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-3 gap-1 flex-wrap">
                    <button type="button" class="add-data neumorphic-button btn btn-md">
                        <i class="fas fa-circle-plus"></i><span class="d-none d-sm-inline ms-1">Add</span>
                    </button>
                    <button type="button" class="filter-data neumorphic-button btn btn-md">
                        <i class="fas fa-filter"></i><span class="d-none d-sm-inline ms-1">Filter</span>
                    </button>
                    <div class="d-flex align-items-center gap-1 ms-auto">
                        <div class="position-relative">
                            <select name="limitPage" id="limitPage" class="form-control neumorphic-card me-3">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                            <i class="fas fa-list select-icon"></i>
                        </div>
                        <div class="position-relative">
                            <input id="tb-search" class="tb-search form-control neumorphic-card ps-3 pe-5 w-100 w-sm-auto"
                                type="search" name="search" placeholder="Search Data" aria-label="search"
                                style="max-width: 165px;">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="table-responsive neumorphic-card p-3 mb-3">
                    <table class="table m-0">
                        <thead>
                            <tr class="tb-head">
                                <th class="text-center text-wrap align-top">No</th>
                                <th class="text-wrap align-top">Image</th>
                                <th class="text-wrap align-top">Item Name</th>
                                <th class="text-wrap align-top">Material</th>
                                <th class="text-wrap align-top">Dimensions (l x w x h) Meter</th>
                                <th class="text-wrap align-top">Category</th>
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
        let storageUrl = '{{ asset('storage') }}'

        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter = {}) {
            let filterParams = {}

            let getDataRest = await renderAPI(
                'GET',
                '{{ route('getdatakatalog') }}', {
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
                let errorMessage = "Data gagal dimuat";
                if (getDataRest && getDataRest.data && getDataRest.data.message) {
                    errorMessage = getDataRest.data.message;
                }

                let thElements = document.getElementsByClassName("tb-head")[0].getElementsByTagName("th");
                let thCount = thElements.length;

                let errorRow = '<tr class="neumorphic-tr">' +
                    '<td class="text-center fw-bold" colspan="' + thCount +
                    '"><i class="fas fa-circle-exclamation me-2"></i>' + errorMessage + '</td>' +
                    '</tr>';

                document.getElementById('listData').innerHTML = errorRow;
                document.getElementById('countPage').textContent = "0 - 0";
                document.getElementById('totalPage').textContent = "0";
            }
        }

        async function handleData(data) {
            return {
                id: data?.id ?? '-',
                item_name: data?.item_name ?? '-',
                material: data?.material ?? '-',
                dimensions: `${data?.length ?? '-'} x ${data?.width ?? '-'} x ${data?.height ?? '-'}`,
                category: data?.category.length ? data.category.map(c => c.name_category ?? '-').join(', ') : '-',
                images: data?.file.length ? data.file.map(f => f.file_name) : []
            };
        }

        async function setListData(dataList, pagination) {
            let totalPage = pagination.total_pages;
            let currentPage = pagination.current_page;
            let display_from = (pagination.per_page * (currentPage - 1)) + 1;
            let display_to = Math.min(display_from + dataList.length - 1, pagination.total);

            let getDataTable = '';
            dataList.forEach((element, index) => {
                let imageCarousel = element.images.length ?
                    `
                        <div id="carousel${element.id}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                ${element.images.map((img, i) => `
                                            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                <img src="${storageUrl}/${img}" class="d-block w-100" style="max-height: 100px; object-fit: contain;">
                                            </div>
                                        `).join('')}
                            </div>
                            ${element.images.length > 1 ? `
                                        <button class="carousel-control-prev neu-text" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="prev">
                                            <i class="fas fa-chevron-left fs-3"></i> <!-- FontAwesome -->
                                        </button>
                                        <button class="carousel-control-next neu-text" type="button" data-bs-target="#carousel${element.id}" data-bs-slide="next">
                                            <i class="fas fa-chevron-right fs-3"></i>
                                        </button>
                                    ` : ''}
                        </div>
                    ` : '-';

                getDataTable += `
                <tr class="neumorphic-tr">
                    <td class="text-center">${display_from + index}.</td>
                    <td>${imageCarousel}</td>
                    <td>${element.item_name}</td>
                    <td>${element.material}</td>
                    <td>${element.dimensions}</td>
                    <td>${element.category}</td>
                </tr>`;
            });

            document.getElementById('listData').innerHTML = getDataTable;
            document.getElementById('totalPage').textContent = pagination.total;
            document.getElementById('countPage').textContent = `${display_from} - ${display_to}`;
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                searchList()
            ])
        }
    </script>
@endsection
