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

    // Manejar el envío del formulario
    if (valoracionForm) {
        valoracionForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = this.getAttribute('action');

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'La valoración se ha enviado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        modal.style.display = 'none';
                        valoracionForm.reset();
                        // Recargar la página para mostrar la nueva valoración
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Ha ocurrido un error al enviar la valoración',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al enviar la valoración',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    }
});
