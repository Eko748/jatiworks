@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <main id="main-content" class="flex-grow-1 p-4 position-relative">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <select name="limitPage" id="limitPage" class="form-control mr-2 mb-2 mb-lg-0"
                        style="width: 100px;">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                    <input id="tb-search" class="tb-search form-control mb-2 mb-lg-0" type="search"
                        name="search" placeholder="Cari Data" aria-label="search" style="width: 200px;">
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-scroll-wrapper">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr class="tb-head">
                                    <th class="text-center text-wrap align-top">No</th>
                                    <th class="text-wrap align-top">Nama User</th>
                                    <th class="text-wrap align-top">Level</th>
                                    <th class="text-wrap align-top">Toko</th>
                                    <th class="text-wrap align-top">Username</th>
                                    <th class="text-wrap align-top">Email</th>
                                    <th class="text-wrap align-top">No. HP</th>
                                    <th class="text-wrap align-top">Alamat</th>
                                    <th class="text-center text-wrap align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody id="listData">
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
                        <div class="text-center text-md-start mb-2 mb-md-0">
                            <div class="pagination">
                                <div>Menampilkan <span id="countPage">0</span> dari <span
                                        id="totalPage">0</span> data</div>
                            </div>
                        </div>
                        <nav class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end"
                                id="pagination-js">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
            $('#listData').html(loadingData())

            let filterParams = {}

            let getDataRest = await renderAPI(
                'GET',
                '{{ route('master.getdatauser') }}', {
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
                $('#listData').html(errorRow)
                $('#countPage').text("0 - 0")
                $('#totalPage').text("0")
            }
        }

        async function handleData(data) {
            let status = ''
            if (data?.status === 'Sukses') {
                status =
                    `<span class="badge badge-success custom-badge"><i class="mx-1 fa fa-circle-check"></i>Sukses</span>`
            } else if (data?.status === 'Gagal') {
                status =
                    `<span class="badge badge-danger custom-badge"><i class="mx-1 fa fa-circle-xmark"></i>Gagal</span>`
            } else {
                status = `<span class="badge badge-secondary custom-badge">Tidak Diketahui</span>`
            }

            let edit_button = `
            <a href='user/edit/${data.id}' class="p-1 btn edit-data action_button"
                data-container="body" data-toggle="tooltip" data-placement="top"
                title="Edit ${title}: ${data.nama}"
                data-id='${data.id}'>
                <span class="text-dark">Edit</span>
                <div class="icon text-warning">
                    <i class="fa fa-edit"></i>
                </div>
            </a>`

            let delete_button = `
            <a class="p-1 btn hapus-data action_button"
                data-container="body" data-toggle="tooltip" data-placement="top"
                title="Hapus ${title}: ${data.nama}"
                data-id='${data.id}'
                data-name='${data.nama}'>
                <span class="text-dark">Hapus</span>
                <div class="icon text-danger">
                    <i class="fa fa-trash"></i>
                </div>
            </a>`

            return {
                id: data?.id ?? '-',
                nama: data?.nama ?? '-',
                nama_level: data?.nama_level ?? '-',
                nama_toko: data?.nama_toko ?? '-',
                username: data?.username ?? '-',
                email: data?.email ?? '-',
                no_hp: data?.no_hp ?? '-',
                alamat: data?.alamat ?? '-',
                edit_button,
                delete_button,
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
                        <td class="${classCol}">${element.nama}</td>
                        <td class="${classCol}">${element.nama_level}</td>
                        <td class="${classCol}">${element.nama_toko}</td>
                        <td class="${classCol}">${element.username}</td>
                        <td class="${classCol}">${element.email}</td>
                        <td class="${classCol}">${element.no_hp}</td>
                        <td class="${classCol}">${element.alamat}</td>
                        <td class="${classCol}">
                            <div class="d-flex justify-content-center w-100">
                                <div class="hovering p-1">
                                    ${element.edit_button}
                                </div>
                                <div class="hovering p-1">
                                    ${element.delete_button}
                                </div>
                            </div>
                        </td>
                    </tr>`
            })

            $('#listData').html(getDataTable)
            $('#totalPage').text(pagination.total)
            $('#countPage').text(`${display_from} - ${display_to}`)
            $('[data-bs-toggle="tooltip"]').tooltip()
            renderPagination()
        }

        async function initPageLoad() {
            await Promise.all([
                // getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter)
            ])
        }
    </script>
@endsection
