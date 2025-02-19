import 'bootstrap';
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import { Splide } from '@splidejs/splide';
import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';



// Fungsi untuk menginisialisasi Splide jika elemen ditemukan
function initSplide(selector, options, extension) {
    const element = document.querySelector(selector);
    if (element) {
        const splide = new Splide(selector, options);
        splide.mount(extension);
    }
}

// Konfigurasi Splide untuk masing-masing slider
initSplide('#splide-1', {
    type: 'loop',
    drag: 'free',
    focus: 'center',
    arrows: false,
    pagination: false,
    perPage: 3,
    autoScroll: {
        speed: 1,
    },
    breakpoints: {
        1200: {
            perPage: 2,
        },
        768: {
            perPage: 1,
        },
        480: {
            perPage: 1,
        },
    },
}, { AutoScroll });

initSplide('#splide-2', {
    type: 'loop',
    drag: 'free',
    focus: 'center',
    arrows: false,
    pagination: false,
    perPage: 4,
    autoScroll: {
        speed: -1,
    },
    breakpoints: {
        1200: {
            perPage: 2,
        },
        768: {
            perPage: 1,
        },
        480: {
            perPage: 1,
        },
    },
}, { AutoScroll });

initSplide('#splide-3', {
    type: 'loop',
    drag: 'free',
    focus: 'center',
    arrows: false,
    pagination: false,
    perPage: 6,
    autoScroll: {
        speed: 1,
    },
    breakpoints: {
        1200: {
            perPage: 4,
        },
        768: {
            perPage: 3,
        },
        480: {
            perPage: 3,
        },
    },
}, { AutoScroll });
// Slider 4
initSplide('#splide-4', {
    drag: 'free',
    arrows: true,
    pagination: true,
});
