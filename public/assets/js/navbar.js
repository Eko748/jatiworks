document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    const navbarCollapse = document.querySelector(".navbar-collapse");
    const dropdowns = document.querySelectorAll(".dropdown-menu, .dropdown-item");

    let lastScrollTop = 0;

    window.addEventListener("scroll", function () {
        const currentScroll = window.scrollY;

        if (currentScroll > 50) {

            
            navbar.classList.add("scrolled");
            navbarCollapse.classList.add("scrolled");
            dropdowns.forEach(dropdown => dropdown.classList.add("scrolled"));
        } else {
            navbar.classList.remove("scrolled");
            navbarCollapse.classList.remove("scrolled");
            dropdowns.forEach(dropdown => dropdown.classList.remove("scrolled"));
        }

        lastScrollTop = currentScroll;
    });
});
