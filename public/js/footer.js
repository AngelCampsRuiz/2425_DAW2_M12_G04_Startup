document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('back-to-top');

    // Función para controlar la visibilidad del botón
    function toggleBackToTopButton() {
        if (window.scrollY > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.add('opacity-0');
            backToTopButton.classList.remove('opacity-100');

            // Usar un timeout para asegurar que la transición de opacidad termine antes de ocultar el elemento
            setTimeout(() => {
                if (window.scrollY <= 300) {
                    backToTopButton.classList.add('invisible');
                    backToTopButton.classList.remove('visible');
                }
            }, 300);
        }
    }

    // Escuchar el evento de scroll para mostrar/ocultar el botón
    window.addEventListener('scroll', toggleBackToTopButton);

    // Aplicar el estado inicial
    toggleBackToTopButton();

    // Manejar el click en el botón
    backToTopButton.addEventListener('click', function(e) {
        e.preventDefault();

        // Aplicar desplazamiento suave al top
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}); 