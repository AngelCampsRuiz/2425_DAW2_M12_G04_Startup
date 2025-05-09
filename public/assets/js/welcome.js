document.addEventListener('DOMContentLoaded', function() {
    // Destruir cualquier instancia previa si existe
    if (window.empresasSwiper) {
        window.empresasSwiper.destroy(true, true);
    }

    // Usar la configuración más simple posible para garantizar funcionamiento
    window.empresasSwiper = new Swiper('.empresas-slider', {
        // Configuración básica
        slidesPerView: 1,
        spaceBetween: 20,
        speed: 300,

        // Navegación
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // Paginación simple
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            type: 'bullets'
        },

        // Sin bucle infinito
        loop: false,

        // Puntos de ruptura para diseño responsive
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            }
        }
    });
}); 