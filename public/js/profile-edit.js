// Funciones para validación y manejo del formulario de edición de perfil

// Mostrar y ocultar errores
function showError(field, message) {
    const errorElement = document.getElementById('error-' + field.id);
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        field.classList.add('border-red-500');
    }
}

function hideError(field) {
    const errorElement = document.getElementById('error-' + field.id);
    if (errorElement) {
        errorElement.classList.add('hidden');
        field.classList.remove('border-red-500');
    }
}

function resetAllErrors() {
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.add('hidden');
    });
    document.querySelectorAll('input, textarea').forEach(el => {
        el.classList.remove('border-red-500');
    });
}

// Funciones adicionales de validación específicas para el formulario de edición
function validarCV(field) {
    if (field.files.length > 0) {
        const file = field.files[0];
        
        if (file.type !== 'application/pdf') {
            showError(field, "El archivo debe ser un PDF");
            return false;
        } else if (file.size > 5 * 1024 * 1024) { // 5MB
            showError(field, "El CV no puede exceder los 5MB");
            return false;
        } else {
            hideError(field);
            return true;
        }
    } else {
        hideError(field);
        return true;
    }
}

// Función para manejar errores de la API
function handleApiError(errorData) {
    const errorMsg = errorData.message || "Ha ocurrido un error al procesar la solicitud";
    
    // Detectar tipos específicos de errores
    if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_telefono_unique')) {
        // Error de teléfono duplicado
        const telefonoInput = document.getElementById('telefono');
        if (telefonoInput) {
            showError(telefonoInput, "Este número de teléfono ya está registrado");
            return;
        }
    } else if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_dni_unique')) {
        // Error de DNI duplicado
        const dniInput = document.getElementById('dni');
        if (dniInput) {
            showError(dniInput, "Este DNI/NIE ya está registrado");
            return;
        }
    } else if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_email_unique')) {
        // Error de email duplicado
        const emailInput = document.getElementById('email');
        if (emailInput) {
            showError(emailInput, "Este email ya está registrado");
            return;
        }
    }
    
    // Para otros errores, mostrar un mensaje dentro del modal
    const errorDiv = document.createElement('div');
    errorDiv.className = 'mt-4 p-4 bg-red-50 text-red-700 rounded-lg';
    errorDiv.innerHTML = `
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
                <div class="mt-1 text-sm text-red-700">
                    ${errorMsg}
                </div>
            </div>
        </div>
    `;
    
    // Insertar el error en el formulario
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Remover cualquier mensaje de error anterior
    const prevError = document.querySelector('.bg-red-50.text-red-700');
    if (prevError) prevError.remove();
    
    // Insertar antes del botón de envío
    if (form && submitBtn) {
        form.insertBefore(errorDiv, submitBtn.parentNode);
    }
}

// Inicialización de eventos cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners para la ventana modal
    const editModal = document.getElementById('editModal');
    if (editModal) {
        window.onclick = function(event) {
            if (event.target == editModal) {
                closeEditModal();
            }
        };
    }

    // Event listeners para los campos de formulario
    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');
    const telefonoInput = document.getElementById('telefono');
    const dniInput = document.getElementById('dni');
    const ciudadInput = document.getElementById('ciudad');
    const cvInput = document.getElementById('cv_pdf');
    
    if (nombreInput) nombreInput.addEventListener('blur', function() { validarNombre(this); });
    if (descripcionInput) descripcionInput.addEventListener('blur', function() { validarDescripcion(this); });
    if (telefonoInput) telefonoInput.addEventListener('blur', function() { validarTelefono(this); });
    if (dniInput) dniInput.addEventListener('blur', function() { validarDNI(this); });
    if (ciudadInput) ciudadInput.addEventListener('blur', function() { validarCiudad(this); });
    if (cvInput) cvInput.addEventListener('change', function() { validarCV(this); });

    // Event listener para el formulario de edición de perfil
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            // Primero validar todos los campos
            let isValid = true;
            
            if (!validarNombre(document.getElementById('nombre'))) isValid = false;
            if (!validarDescripcion(document.getElementById('descripcion'))) isValid = false;
            if (!validarTelefono(document.getElementById('telefono'))) isValid = false;
            if (!validarDNI(document.getElementById('dni'))) isValid = false;
            if (!validarCiudad(document.getElementById('ciudad'))) isValid = false;
            
            const imagenInput = document.getElementById('imagen');
            if (imagenInput && imagenInput.files.length > 0) {
                if (!validarImagen(imagenInput)) isValid = false;
            }
            
            const cvInput = document.getElementById('cv_pdf');
            if (cvInput && cvInput.files.length > 0) {
                if (!validarCV(cvInput)) isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }

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
                Guardando...
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
                    // Actualizar la barra de progreso
                    const progressBar = document.getElementById('progressBar');
                    const progressText = document.getElementById('progressText');
                    const progressPercentage = document.getElementById('progressPercentage');
                    const progressMessage = document.getElementById('progressMessage');

                    if (progressBar && progressText && progressPercentage && progressMessage) {
                        progressBar.style.width = data.porcentaje + '%';
                        progressText.textContent = data.porcentaje + '%';
                        progressPercentage.textContent = data.porcentaje + '%';

                        // Actualizar mensaje según el porcentaje
                        if (data.porcentaje < 50) {
                            progressMessage.textContent = '¡Sigue completando tu perfil!';
                        } else if (data.porcentaje < 80) {
                            progressMessage.textContent = '¡Vas por buen camino!';
                        } else {
                            progressMessage.textContent = '¡Casi lo tienes!';
                        }
                    }

                    // Actualizar la información del perfil
                    const user = data.user;

                    // Actualizar nombre
                    const nombreElement = document.querySelector('h1.text-4xl');
                    if (nombreElement) nombreElement.textContent = user.nombre;

                    // Actualizar descripción
                    const descripcionElement = document.querySelector('.text-gray-700.leading-relaxed');
                    if (descripcionElement) descripcionElement.textContent = user.descripcion || '';

                    // Actualizar campos de visibilidad
                    const camposVisibles = {
                        'telefono': user.show_telefono,
                        'dni': user.show_dni,
                        'ciudad': user.show_ciudad,
                        'direccion': user.show_direccion,
                        'web': user.show_web
                    };

                    // Actualizar la visibilidad de cada campo
                    Object.entries(camposVisibles).forEach(([campo, visible]) => {
                        const elemento = document.querySelector(`[data-campo="${campo}"]`);
                        if (elemento) {
                            elemento.style.display = visible ? 'flex' : 'none';
                        }
                    });

                    // Actualizar valores de los campos
                    const camposValores = {
                        'telefono': user.telefono,
                        'dni': user.dni,
                        'ciudad': user.ciudad,
                        'direccion': user.direccion,
                        'web': user.web
                    };

                    Object.entries(camposValores).forEach(([campo, valor]) => {
                        const elemento = document.querySelector(`[data-valor="${campo}"]`);
                        if (elemento) {
                            elemento.textContent = valor || 'No especificado';
                        }
                    });

                    // Mostrar mensaje de éxito
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMessage.textContent = data.message;
                    document.body.appendChild(successMessage);

                    // Cerrar el modal y recargar la página después de 2 segundos
                    setTimeout(() => {
                        closeEditModal();
                        location.reload();
                    }, 2000);
                } else if (data.errors) {
                    // Mostrar errores de validación
                    resetAllErrors();
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const inputField = document.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            const errorMessage = Array.isArray(messages) ? messages[0] : messages;
                            showError(inputField, errorMessage);
                        }
                    });
                } else {
                    throw new Error(data.message || "Ha ocurrido un error al guardar los cambios");
                }
            })
            .catch(error => {
                // Primero intentar parsear el error como JSON en caso de que sea una respuesta del servidor
                let parsedError;
                try {
                    // Si la respuesta es un objeto Response, intentamos obtener el JSON
                    if (error instanceof Response) {
                        return error.json().then(data => {
                            handleApiError(data);
                        });
                    }
                    // Si ya tenemos un objeto, lo usamos directamente
                    else if (error.message) {
                        handleApiError({ message: error.message });
                    }
                    // Último caso, error sin formato claro
                    else {
                        handleApiError({ message: "Ha ocurrido un error desconocido" });
                    }
                } catch (e) {
                    // Si falla el parsing, usamos el error como string
                    handleApiError({ message: error.toString() });
                }
            })
            .finally(() => {
                // Restaurar el botón
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
});