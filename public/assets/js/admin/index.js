const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
        y: 'top'
    }
});

function modalCrop() {
    const modalCrop = document.getElementById('cropImageModal');
    modalCrop.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content neumorphic-modal p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close neumorphic-btn-danger" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="imagePreview">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn neumorphic-button" data-bs-dismiss="modal"><i
                            class="fas fa-circle-xmark me-1"></i>Cancel</button>
                    <button type="button" id="cropImageBtn" class="btn neumorphic-button-outline fw-bold"><i
                            class="fas fa-upload me-1"></i>Crop &
                        Upload</button>
                </div>
            </div>
        </div>`;
}

function loadListData() {
    let thElements = document.getElementsByClassName("tb-head")[0].getElementsByTagName("th");
    let thCount = thElements.length;

    let loadingRow = `
        <tr class="neumorphic-tr">
            <td class="text-center fw-bold" colspan="${thCount}">
                <div class="neumorphic-loader">
                    <div class="spinner"></div>
                </div>
            </td>
        </tr>`;

    document.getElementById('listData').innerHTML = loadingRow;
}

function loadDetailData(isParams) {
    let loadingRow = `
        <div class="neumorphic-tr">
            <div class="text-center fw-bold">
                <div class="neumorphic-loader">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>`;

    document.getElementById(isParams).innerHTML = loadingRow;
}

function errorListData(getDataRest) {
    let thElements = document.getElementsByClassName("tb-head")[0].getElementsByTagName("th");
    let thCount = thElements.length;

    let errorMessage = "Data gagal dimuat";
    if (getDataRest && getDataRest.data && getDataRest.data.message) {
        errorMessage = getDataRest.data.message;
    }

    let errorRow = `
    <tr class="neumorphic-tr">
        <td class="text-center fw-bold" colspan="${thCount}">
            <i class="fas fa-circle-exclamation me-2"></i>${errorMessage}
        </td>
    </tr>`;

    document.getElementById('listData').innerHTML = errorRow;
    document.getElementById('countPage').textContent = "0 - 0";
    document.getElementById('totalPage').textContent = "0";
}

function renderListData(getDataTable, pagination, display_from, display_to) {
    document.getElementById('listData').innerHTML = getDataTable
    document.getElementById('totalPage').textContent = pagination.total
    document.getElementById('countPage').textContent = `${display_from} - ${display_to}`
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el)
    })

    renderPagination()
}

async function setFilterListData() {
    document.getElementById('filterForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        if (typeof getFilterListData !== "function")
            return notyf.error('filter is not set');

        const [filterData] = await getFilterListData();
        customFilter = filterData;

        defaultSearch = document.getElementById("searchPage").value;
        defaultLimitPage = document.getElementById("limitPage").value;
        currentPage = 1;

        await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
            customFilter);
    });

    document.getElementById('resetFilter').addEventListener('click', async function () {
        if (typeof getFilterListData !== "function")
            return notyf.error('filter is not set');
        if (!document.getElementById('filterForm'))
            return notyf.error('filter form is not set');

        document.querySelectorAll("#filterForm input, #filterForm textarea, #filterForm select")
            .forEach(el => {
                el.value = "";
            });

        const [, resetActions] = await getFilterListData();
        if (resetActions) {
            Object.values(resetActions).forEach(action => action());
        }

        customFilter = {};
        defaultSearch = document.getElementById("searchPage").value;
        defaultLimitPage = document.getElementById("limitPage").value;
        currentPage = 1;

        await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
            customFilter);
    });
}

async function confirmSubmitData(saveButton) {
    const result = await Swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to save this data?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: '#2ecc71',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Save',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    });

    if (!result.isConfirmed) return false;

    saveButton.disabled = true;
    saveButton.innerHTML =
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...`;

    return true;
}

function multiSelectData(isParameter, isPlaceholder) {
    const selectElement = document.querySelector(isParameter);

    if (!selectElement) return;

    const slim = new SlimSelect({
        select: selectElement,
        settings: {
            placeholderText: isPlaceholder,
            allowDeselect: true
        }
    });

    slim.setSelected('');

    const modal = selectElement.closest('.modal');
    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            const dropdown = document.querySelector('.ss-dropdown');
            if (dropdown) {
                dropdown.style.zIndex = '1050';
                dropdown.style.position = 'absolute';
            }

            const searchInput = document.querySelector('.ss-search input');
            if (searchInput) {
                searchInput.removeAttribute('tabindex');
            }
        });
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');

    if (window.innerWidth < 768) {
        // Mobile logic (tidak perlu simpan di localStorage)
        if (!document.getElementById('mobileSidebarStyles')) {
            const style = document.createElement('style');
            style.id = 'mobileSidebarStyles';
            style.innerHTML = `
                #sidebar {
                    transition: transform 0.3s ease, opacity 0.3s ease;
                    transform: translateX(0);
                    opacity: 1;
                    z-index: 9999;
                }
                #sidebar.sidebar-hidden {
                    transform: translateX(-100%);
                    opacity: 0;
                    pointer-events: none;
                }
                #sidebar.d-none {
                    display: none !important;
                }
            `;
            document.head.appendChild(style);
        }

        if (sidebar.classList.contains('sidebar-hidden')) {
            sidebar.classList.remove('d-none');
            void sidebar.offsetWidth;
            sidebar.classList.remove('sidebar-hidden');
        } else {
            sidebar.classList.add('sidebar-hidden');
            setTimeout(() => {
                sidebar.classList.add('d-none');
            }, 300);
        }
    } else {
        // Desktop logic with localStorage
        sidebar.classList.toggle('sidebar-collapsed');
        const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    }
}

document.getElementById('toggleTheme').addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        this.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
        localStorage.setItem('theme', 'light');
        this.innerHTML = '<i class="fas fa-moon"></i>';
    }
});

document.getElementById('toggleFullscreen').addEventListener('click', function () {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        document.exitFullscreen();
    }
});

function hideTooltip(element) {
    var tooltip = bootstrap.Tooltip.getInstance(element);
    if (tooltip) {
        tooltip.hide();
    }
}

function tooltip() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

function toggleFilterButton() {
    const toggleFilter = document.getElementById("toggleFilter");
    const filterContainer = document.getElementById("filterContainer");
    const icon = toggleFilter.querySelector("i");
    const textSpan = toggleFilter.querySelector("span");

    filterContainer.addEventListener("show.bs.collapse", function () {
        toggleFilter.classList.add("active");
        icon.classList.replace("fa-filter", "fa-circle-xmark");
        textSpan.textContent = "Close";
    });

    filterContainer.addEventListener("hide.bs.collapse", function () {
        toggleFilter.classList.remove("active");
        icon.classList.replace("fa-circle-xmark", "fa-filter");
        textSpan.textContent = "Filter";
    });
}
