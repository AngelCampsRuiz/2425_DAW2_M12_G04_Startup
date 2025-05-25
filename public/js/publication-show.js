// Progress bar de lectura
document.addEventListener('DOMContentLoaded', function() {
    // Añadir la barra de progreso al DOM
    const progressBar = document.createElement('div');
    progressBar.className = 'progress-bar';
    document.body.appendChild(progressBar);

    // Actualizar el progreso al hacer scroll
    window.addEventListener('scroll', function() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrollTop = window.scrollY || window.pageYOffset;
        const progress = (scrollTop / documentHeight) * 100;
        progressBar.style.width = progress + '%';

        // Mostrar/ocultar el botón de volver arriba
        const backToTopButton = document.querySelector('.back-to-top');
        if (backToTopButton) {
            if (scrollTop > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        }
    });

    // Crear botón para volver arriba
    const backToTopButton = document.createElement('div');
    backToTopButton.className = 'back-to-top shadow-lg';
    backToTopButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>';
    document.body.appendChild(backToTopButton);

    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Inicializar cualquier instancia del sistema de valoración
    const ratings = document.querySelectorAll('.rating-container');
    ratings.forEach(function(container) {
        const stars = container.querySelectorAll('.rating-stars i');
        const ratingValue = parseFloat(container.getAttribute('data-rating') || 0);

        // Llenar estrellas según la valoración
        stars.forEach(function(star, index) {
            if (index < Math.floor(ratingValue)) {
                star.classList.add('filled');
            } else if (index === Math.floor(ratingValue) && ratingValue % 1 !== 0) {
                star.classList.add('filled', 'half');
            }
        });
    });
});

// Funciones para el modal de solicitud
function openSolicitudModal() {
    document.getElementById('solicitudModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSolicitudModal() {
    document.getElementById('solicitudModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Función para manejar el menú de compartir
function toggleShareMenu() {
    const shareMenu = document.getElementById('shareMenu');
    if (shareMenu.classList.contains('hidden')) {
        // Mostrar con animación
        shareMenu.classList.remove('hidden');
        setTimeout(() => {
            shareMenu.style.opacity = '1';
            shareMenu.style.transform = 'translateY(0)';
        }, 10);
    } else {
        // Ocultar con animación
        shareMenu.style.opacity = '0';
        shareMenu.style.transform = 'translateY(10px)';
        setTimeout(() => {
            shareMenu.classList.add('hidden');
        }, 200);
    }
}

// Compatibilidad con la función anterior para móvil
function sharePage() {
    toggleShareMenu();
}

function shareOnPlatform(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);

    let shareUrl = '';

    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
        case 'whatsapp':
            shareUrl = `https://api.whatsapp.com/send?text=${title} ${url}`;
            break;
    }

    window.open(shareUrl, '_blank');
    toggleShareMenu();
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        toggleShareMenu();
        Swal.fire({
            title: '¡Enlace copiado!',
            text: 'El enlace se ha copiado al portapapeles',
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#fff',
            iconColor: '#5e0490'
        });
    });
}

// Cerrar modales al hacer clic fuera
document.addEventListener('click', function(e) {
    const solicitudModal = document.getElementById('solicitudModal');
    const shareMenu = document.getElementById('shareMenu');
    const shareButton = document.getElementById('shareButton');
    const shareContainer = document.getElementById('shareContainer');

    if (e.target === solicitudModal) {
        closeSolicitudModal();
    }

    if (shareMenu && !shareMenu.classList.contains('hidden') &&
        !shareContainer.contains(e.target)) {
        toggleShareMenu();
    }
});

// Manejar envío del formulario con AJAX
document.addEventListener('DOMContentLoaded', function() {
    const solicitudForm = document.getElementById('solicitudForm');
    if (solicitudForm) {
        solicitudForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Mostrar indicador de carga
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
            `;

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // Restaurar botón
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;

                if (data.status === 'success') {
                    closeSolicitudModal();

                    // Actualizar el botón de solicitud
                    const solicitudButton = document.querySelector('[onclick="openSolicitudModal()"]').parentElement;
                    solicitudButton.innerHTML = `
                        <button disabled class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-medium rounded-lg shadow cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Solicitud enviada (Pendiente)
                        </button>
                    `;

                    // Actualizar los botones móviles si existen
                    const mobileSolicitudButton = document.querySelector('.md\\:hidden [onclick="openSolicitudModal()"]');
                    if (mobileSolicitudButton) {
                        mobileSolicitudButton.remove();
                    }

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Solicitud enviada!',
                        html: 'Tu solicitud ha sido enviada correctamente<br><small>La empresa se pondrá en contacto contigo pronto</small>',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                } else if (data.status === 'error') {
                    Swal.fire({
                        title: '¡Error!',
                        text: data.message || 'Ha ocurrido un error al enviar la solicitud',
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                }
            })
            .catch(error => {
                // Restaurar botón
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;

                console.error('Error:', error);
                Swal.fire({
                    title: '¡Error!',
                    text: 'Ha ocurrido un error al procesar tu solicitud',
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#5e0490',
                    background: '#fff',
                    customClass: {
                        confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                    }
                });
            });
        });
    }
});

// Funciones para el menú de compartir móvil
function toggleMobileShareMenu() {
    const mobileShareMenu = document.getElementById('mobileShareMenu');
    if (mobileShareMenu.classList.contains('hidden')) {
        mobileShareMenu.classList.remove('hidden');
        mobileShareMenu.style.transform = 'translateY(0)';
    } else {
        mobileShareMenu.classList.add('hidden');
        mobileShareMenu.style.transform = 'translateY(100%)';
    }
} 