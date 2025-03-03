import Swiper from 'swiper';
import { Pagination, Autoplay, Keyboard } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';


let swiper = new Swiper(".swiper", {
    modules: [Pagination, Autoplay, Keyboard],
    spaceBetween: 30,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    },
    keyboard: {
        enabled: true,
    },
    loop: true
});

