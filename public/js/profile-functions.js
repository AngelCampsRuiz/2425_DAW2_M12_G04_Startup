// Funciones para el Modal de Valoración
function openRatingModal() {
    document.getElementById('ratingModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRatingModal() {
    document.getElementById('ratingModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function setRating(rating) {
    document.getElementById('rating').value = rating;
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < rating);
        star.classList.toggle('text-gray-300', index >= rating);
    });
}

// Funciones para el Modal de Edición de Valoración
function editValoracion(id, puntuacion, comentario) {
    document.getElementById('valoracionId').value = id;
    document.getElementById('editPuntuacion').value = puntuacion;
    document.getElementById('editComentario').value = comentario;

    // Actualizar estrellas
    const stars = document.querySelectorAll('.edit-rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < puntuacion);
        star.classList.toggle('text-gray-300', index >= puntuacion);
    });

    // Abrir modal
    document.getElementById('editValoracionModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditValoracionModal() {
    document.getElementById('editValoracionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function setEditRating(rating) {
    document.getElementById('editPuntuacion').value = rating;
    const stars = document.querySelectorAll('.edit-rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < rating);
        star.classList.toggle('text-gray-300', index >= rating);
    });
}

function deleteValoracion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7C3AED',
        cancelButtonColor: '#EF4444',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/valoraciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Eliminada',
                        text: 'La valoración ha sido eliminada',
                        icon: 'success',
                        confirmButtonColor: '#7C3AED'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al eliminar la valoración',
                    icon: 'error',
                    confirmButtonColor: '#7C3AED'
                });
            });
        }
    });
}

// Función para abrir el modal de edición de perfil
function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Validaciones de formulario
function validarNombre(input) {
    const errorElement = document.getElementById('error-nombre');
    if (input.value.trim() === '') {
        errorElement.textContent = 'El nombre es obligatorio';
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }
}

function validarDescripcion(input) {
    const errorElement = document.getElementById('error-descripcion');
    if (input.value.trim().length > 500) {
        errorElement.textContent = 'La descripción no puede exceder los 500 caracteres';
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }
}

function validarTelefono(input) {
    const errorElement = document.getElementById('error-telefono');
    const telefonoPattern = /^[0-9]{9}$/;
    
    if (input.value.trim() !== '' && !telefonoPattern.test(input.value.trim())) {
        errorElement.textContent = 'Introduce un número de teléfono válido (9 dígitos)';
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }
}

function validarDNI(input) {
    const errorElement = document.getElementById('error-dni');
    const dniPattern = /^[0-9]{8}[A-Z]$/;
    
    if (input.value.trim() !== '' && !dniPattern.test(input.value.trim())) {
        errorElement.textContent = 'Introduce un DNI válido (8 dígitos + letra)';
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }
}

function validarCiudad(input) {
    const errorElement = document.getElementById('error-ciudad');
    if (input.value.trim() !== '' && input.value.trim().length < 3) {
        errorElement.textContent = 'La ciudad debe tener al menos 3 caracteres';
        errorElement.classList.remove('hidden');
        input.classList.add('border-red-500');
        return false;
    } else {
        errorElement.classList.add('hidden');
        input.classList.remove('border-red-500');
        return true;
    }
}

function validarImagen(input) {
    const errorElement = document.getElementById('error-imagen');
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    const maxSizeMB = 2;
    
    if (input.files.length > 0) {
        const fileExtension = input.files[0].name.split('.').pop().toLowerCase();
        const fileSize = input.files[0].size / (1024 * 1024); // Convertir a MB
        
        if (!allowedExtensions.includes(fileExtension)) {
            errorElement.textContent = 'Formato no válido. Usa JPG, PNG o GIF';
            errorElement.classList.remove('hidden');
            return false;
        } else if (fileSize > maxSizeMB) {
            errorElement.textContent = `La imagen no debe superar ${maxSizeMB}MB`;
            errorElement.classList.remove('hidden');
            return false;
        } else {
            errorElement.classList.add('hidden');
            return true;
        }
    }
    return true;
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners para la sección de progreso del perfil
    const progressContent = document.getElementById('progressContent');
    const toggleButton = document.getElementById('toggleButton');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (progressContent && toggleButton && toggleIcon) {
        let isExpanded = true;

        // Función para alternar la visibilidad
        function toggleProgress() {
            isExpanded = !isExpanded;

            if (isExpanded) {
                progressContent.style.maxHeight = progressContent.scrollHeight + "px";
                toggleIcon.style.transform = 'rotate(0deg)';
            } else {
                progressContent.style.maxHeight = "0";
                toggleIcon.style.transform = 'rotate(180deg)';
            }
        }

        // Añadir el evento al botón
        toggleButton.addEventListener('click', toggleProgress);

        // Inicializar el estado
        progressContent.style.maxHeight = progressContent.scrollHeight + "px";
    }
    
    // Event listeners para las estrellas de valoración
    const ratingStars = document.querySelectorAll('.rating-star');
    if (ratingStars.length > 0) {
        ratingStars.forEach((star, index) => {
            star.addEventListener('mouseover', function() {
                for (let i = 0; i <= index; i++) {
                    ratingStars[i].classList.add('text-yellow-400');
                    ratingStars[i].classList.remove('text-gray-300');
                }
            });

            star.addEventListener('mouseout', function() {
                const rating = document.getElementById('rating').value;
                ratingStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });

            star.addEventListener('click', function() {
                setRating(index + 1);
            });
        });
    }
    
    // Event listeners para las estrellas de edición de valoración
    const editRatingStars = document.querySelectorAll('.edit-rating-star');
    if (editRatingStars.length > 0) {
        editRatingStars.forEach((star, index) => {
            star.addEventListener('mouseover', function() {
                for (let i = 0; i <= index; i++) {
                    editRatingStars[i].classList.add('text-yellow-400');
                    editRatingStars[i].classList.remove('text-gray-300');
                }
            });

            star.addEventListener('mouseout', function() {
                const rating = document.getElementById('editPuntuacion').value;
                editRatingStars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });

            star.addEventListener('click', function() {
                setEditRating(index + 1);
            });
        });
    }

    // Cerrar modal de valoración al hacer clic en el botón de cerrar
    const closeBtn = document.querySelector('.close');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeRatingModal);
    }
    
    // Event listener para el formulario del rating modal
    const ratingForm = document.getElementById('valoracionForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;

            // Mostrar indicador de carga
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Enviando...
            `;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMessage.textContent = data.message;
                    document.body.appendChild(successMessage);

                    // Cerrar el modal y recargar la página después de 2 segundos
                    setTimeout(() => {
                        closeRatingModal();
                        location.reload();
                    }, 2000);
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                // Mostrar mensaje de error
                const errorMessage = document.createElement('div');
                errorMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                errorMessage.textContent = error.message;
                document.body.appendChild(errorMessage);

                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            })
            .finally(() => {
                // Restaurar el botón
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
    
    // Event listener para el formulario de edición de valoración
    const editValoracionForm = document.getElementById('editValoracionForm');
    if (editValoracionForm) {
        editValoracionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const valoracionId = document.getElementById('valoracionId').value;
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;

            // Mostrar indicador de carga
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Guardando...
            `;

            fetch(`/valoraciones/${valoracionId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: 'Éxito',
                        text: 'La valoración se ha actualizado correctamente',
                        icon: 'success',
                        confirmButtonColor: '#7C3AED'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Error al actualizar la valoración');
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'Ha ocurrido un error al actualizar la valoración',
                    icon: 'error',
                    confirmButtonColor: '#7C3AED'
                });
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
    
    // Event listeners para cerrar modales al hacer clic fuera
    const ratingModal = document.getElementById('ratingModal');
    if (ratingModal) {
        ratingModal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeRatingModal();
            }
        });
    }
    
    const editValoracionModal = document.getElementById('editValoracionModal');
    if (editValoracionModal) {
        editValoracionModal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditValoracionModal();
            }
        });
    }
    
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditModal();
            }
        });
    }
}); 