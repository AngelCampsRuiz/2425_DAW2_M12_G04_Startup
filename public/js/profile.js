document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const modal = document.getElementById('modalValoracion');
    const closeBtn = document.querySelector('.close');
    const valorarBtn = document.querySelector('.valorar-button');
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const valoracionForm = document.getElementById('valoracionForm');

    // Función para abrir el modal
    if (valorarBtn) {
        valorarBtn.addEventListener('click', function() {
            modal.style.display = 'block';
        });
    }

    // Función para cerrar el modal
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    // Cerrar modal al hacer clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Manejar la interacción con las estrellas
    stars.forEach((star, index) => {
        star.addEventListener('mouseover', function() {
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add('star-filled');
            }
        });

        star.addEventListener('mouseout', function() {
            const rating = ratingInput.value;
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('star-filled');
                } else {
                    s.classList.remove('star-filled');
                }
            });
        });

        star.addEventListener('click', function() {
            ratingInput.value = index + 1;
            stars.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add('star-filled');
                } else {
                    s.classList.remove('star-filled');
                }
            });
        });
    });

    // Función para mostrar mensajes con SweetAlert2
    const showMessage = (title, text, icon) => {
        return Swal.fire({
            title,
            text,
            icon,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#7705b6'
        });
    };

    // Función para enviar la valoración
    const enviarValoracion = async (formData, url) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                await showMessage('¡Éxito!', 'La valoración se ha enviado correctamente', 'success');
                modal.style.display = 'none';
                valoracionForm.reset();
                window.location.reload();
            } else {
                throw new Error(data.message || 'Error al enviar la valoración');
            }
        } catch (error) {
            console.error('Error:', error);
            await showMessage('Error', error.message || 'Ha ocurrido un error al enviar la valoración', 'error');
        }
    };

    // Manejar el envío del formulario
    if (valoracionForm) {
        valoracionForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Deshabilitar el botón de envío y mostrar estado de carga
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <div class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                </div>
            `;

            try {
                const formData = new FormData(this);
                const url = this.getAttribute('action');
                await enviarValoracion(formData, url);
            } finally {
                // Restaurar el botón
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });
    }
});
