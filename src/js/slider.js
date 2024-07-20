import Swiper from "swiper";
import { Navigation, Pagination, Autoplay, Scrollbar} from "swiper/modules";

import 'swiper/css';
import 'swiper/css/navigation';
import  'swiper/css/autoplay';
import  'swiper/css/scrollbar';
import  'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector('.slider')) {
        const opciones = {
            
            // numero de slider
            slidesPerView: 1,
            spaceBetween: 10, // espacio de 15 px
            freeMode: true,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },

            scrollbar: {
                el: '.swiper-scrollbar',
            },

            pagination: {
                el: '.swiper-pagination',
            },
            // media query pero en el slider
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 3
                }
            }
        }

        Swiper.use([Navigation])
        Swiper.use([Autoplay])
        Swiper.use([Scrollbar])
        Swiper.use([Pagination])

        new Swiper('.slider', opciones)
    }
})