@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('css')
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
                        <div class="col-md-4">
                            <label for="filterDateRange" class="form-label">Last Login</label>
                            <input type="text" class="form-control neumorphic-card" id="filterDateRange"
                                placeholder="Select range last login" autocomplete="off" required>
                        </div>
                        <div class="col-md-4">
                            <label for="filterStatusLogin" class="form-label">Status</label>
                            <select id="filterStatusLogin" class="form-control" multiple>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                        </div>
                        <div class="col-md-4">
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
                            <th class="text-wrap align-top">Status</th>
                            <th class="text-wrap align-top">Last Login</th>
                            <th class="text-wrap align-top text-center">Action</th>
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
                    <h5 class="modal-title fw-bold" id="addDataModalLabel">Add New User</h5>
                    <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDataForm">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control neumorphic-card" id="name" name="name"
                                    placeholder="Enter full name" autocomplete="off" required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control neumorphic-card" id="email" name="email"
                                    placeholder="Enter email address" autocomplete="off" required>
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" class="form-control neumorphic-card" id="password"
                                    name="password" placeholder="Enter password" autocomplete="new-password" required>
                                <div class="mt-2" id="password-rules">
                                    <small class="d-block text-danger" id="rule-length">❌ At least 8 characters</small>
                                    <small class="d-block text-danger" id="rule-uppercase">❌ At least 1 uppercase
                                        letter</small>
                                    <small class="d-block text-danger" id="rule-number">❌ At least 1 number</small>
                                    <small class="d-block text-danger" id="rule-symbol">❌ At least 1 symbol</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-end">
                    <button type="button" class="btn neumorphic-button" data-bs-dismiss="modal"><i
                            class="fas fa-circle-xmark me-1"></i>Cancel</button>
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
    <script src="{{ asset('assets/js/pagination.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.min.js') }}"></script>
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
            let requestParams = {
                page: page,
                limit: limit,
                ascending: ascending,
                ...customFilter
            };

            if (search.trim() !== '') {
                requestParams.search = search;
            }

            loadListData();

            let getDataRest = await restAPI('GET', '{{ route('getdatauser') }}', requestParams)
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
            if (data.status === 'Online') {
                statusClass += 'text-success border-success';
            } else {
                statusClass += 'text-danger border-danger';
            }

            let actions = `
                    <button class="reset-data btn btn-md neumorphic-card2" data-id="${data.id}" onclick="resetPassword(this)" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Reset Password">
                        <i class="fas fa-rotate text-warning"></i>
                    </button>
                `;

            return {
                id: data?.id ?? '-',
                name: data?.name ?? '-',
                role_name: data?.role_name ?? '-',
                email: data?.email ?? '-',
                last_login_at: data?.last_login_at ?? '-',
                status: `<span class="${statusClass}">${data?.status ?? '-'}</span>`,
                actions
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
                    <td class="text-center">${element.actions}</td>
                </tr>`;
            });

            renderListData(getDataTable, pagination, display_from, display_to);
        }

        async function resetPassword(button) {
            let id = button.dataset.id;

            if (!id) {
                notyf.error("ID not found!");
                return;
            }

            const result = await Swal.fire({
                title: "Reset Password?",
                text: "password will be reset to password123",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Yes, Reset!",
                confirmButtonText: "Cancel"
            });

            if (result.dismiss === Swal.DismissReason.cancel) {
                let deleteResponse = await restAPI(
                    "PUT",
                    `{{ route('admin.user.updatePassword') }}`, {
                        id: id
                    }
                );

                if (deleteResponse && deleteResponse.status === 200) {
                    await notyf.success("Reset password successfully.");

                    setTimeout(async () => {
                        window.location.reload();
                    }, 1000);
                } else {
                    notyf.error("Failed to reset password.");
                }
            }
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

            let selectedStatusLogin = Array.from(document.getElementById("filterStatusLogin").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let selectedRoles = Array.from(document.getElementById("filterRole").selectedOptions)
                .map(option => option.value)
                .filter(value => value !== "");

            let filterData = {
                start_date: start_date,
                end_date: end_date,
                status_login: selectedStatusLogin.length ? selectedStatusLogin : null,
                role: selectedRoles.length ? selectedRoles : null
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
                const originalContent = saveButton.innerHTML;

                const confirmed = await confirmSubmitData(saveButton);
                if (!confirmed) return;

                const formData = new FormData(document.getElementById('addDataForm'));

                try {
                    const postData = await restAPI('POST', '{{ route('admin.katalog.store') }}', formData);

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

        function handlePasswordUser() {
            const passwordInput = document.querySelector("#password");
            const passwordRules = document.querySelector("#password-rules");
            const ruleLength = document.querySelector("#rule-length");
            const ruleUppercase = document.querySelector("#rule-uppercase");
            const ruleNumber = document.querySelector("#rule-number");
            const ruleSymbol = document.querySelector("#rule-symbol");

            passwordRules.style.display = "none";

            passwordInput.addEventListener("focus", function() {
                passwordRules.style.display = "block";
            });

            passwordInput.addEventListener("input", function() {
                const value = passwordInput.value;

                if (value.length >= 8) {
                    ruleLength.innerHTML = "✅ At least 8 characters";
                    ruleLength.classList.remove("text-danger");
                    ruleLength.classList.add("text-success");
                } else {
                    ruleLength.innerHTML = "❌ At least 8 characters";
                    ruleLength.classList.remove("text-success");
                    ruleLength.classList.add("text-danger");
                }

                if (/[A-Z]/.test(value)) {
                    ruleUppercase.innerHTML = "✅ At least 1 uppercase letter";
                    ruleUppercase.classList.remove("text-danger");
                    ruleUppercase.classList.add("text-success");
                } else {
                    ruleUppercase.innerHTML = "❌ At least 1 uppercase letter";
                    ruleUppercase.classList.remove("text-success");
                    ruleUppercase.classList.add("text-danger");
                }

                if (/\d/.test(value)) {
                    ruleNumber.innerHTML = "✅ At least 1 number";
                    ruleNumber.classList.remove("text-danger");
                    ruleNumber.classList.add("text-success");
                } else {
                    ruleNumber.innerHTML = "❌ At least 1 number";
                    ruleNumber.classList.remove("text-success");
                    ruleNumber.classList.add("text-danger");
                }

                if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                    ruleSymbol.innerHTML = "✅ At least 1 symbol";
                    ruleSymbol.classList.remove("text-danger");
                    ruleSymbol.classList.add("text-success");
                } else {
                    ruleSymbol.innerHTML = "❌ At least 1 symbol";
                    ruleSymbol.classList.remove("text-success");
                    ruleSymbol.classList.add("text-danger");
                }
            });

            passwordInput.addEventListener("blur", function() {
                if (passwordInput.value === "") {
                    passwordRules.style.display = "none";
                }
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
                toggleFilterButton(),
                multiSelectData('#filterStatusLogin', 'Select status'),
                multiSelectData('#filterRole', 'Select role'),
                handlePasswordUser(),
                dateRangeInput('#filterDateRange'),
            ])
        }
    </script>
@endsection
