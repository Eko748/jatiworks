const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'center',
        y: 'top'
    }
});

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

function errorListData(getDataRest) {
    notyf.error(getDataRest.data.message);

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

function multiSelectData(isParameter, isPlaceholder) {
    new SlimSelect({
        select: isParameter,
        settings: {
            placeholderText: isPlaceholder,
            allowDeselect: true
        }
    });
}

function toggleSidebar() {
    let sidebar = document.getElementById('sidebar');
    if (window.innerWidth < 768) {
        sidebar.classList.toggle('d-none');
    }
    sidebar.classList.toggle('sidebar-collapsed');
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
