// Funciones de utilidad para errores
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
    document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('input, textarea').forEach(el => el.classList.remove('border-red-500'));
}

// Funciones de validación
function validarCampo(field, nombre, minLength, maxLength) {
    if (!field || !field.value) return true;
    const valor = field.value.trim();
    
    if (!valor) {
        showError(field, `El ${nombre} es obligatorio`);
        return false;
    }
    
    if (minLength && valor.length < minLength) {
        showError(field, `El ${nombre} debe tener al menos ${minLength} caracteres`);
        return false;
    }
    
    if (maxLength && valor.length > maxLength) {
        showError(field, `El ${nombre} no puede exceder los ${maxLength} caracteres`);
        return false;
    }
    
    hideError(field);
    return true;
}

function validarEmail(field) {
    if (!field) return true;
    const valor = field.value.trim();
    
    if (!valor) {
        showError(field, "El email es obligatorio");
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(valor)) {
        showError(field, "Formato de email no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

function validarDNI(field) {
    if (!field || document.querySelector('[data-role="empresa"]')) return true;
    
    const valor = field.value.trim();
    if (!valor) {
        showError(field, "El DNI es obligatorio");
        return false;
    }
    
    const dniRegex = /^[0-9]{8}[A-Za-z]$/;
    const nieRegex = /^[XYZxyz][0-9]{7}[A-Za-z]$/;
    
    if (!dniRegex.test(valor) && !nieRegex.test(valor)) {
        showError(field, "Formato de DNI/NIE no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

function validarCIF(field) {
    if (!field) return true;
    
    const valor = field.value.trim();
    if (!valor) {
        showError(field, "El CIF es obligatorio");
        return false;
    }
    
    const cifRegex = /^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$/;
    if (!cifRegex.test(valor.toUpperCase())) {
        showError(field, "Formato de CIF no válido");
        return false;
    }
    
    hideError(field);
    return true;
}

// Función para mostrar errores usando el nombre del campo
function showErrorByName(field, message) {
    if (!field) return;
    
    const errorElement = document.getElementById(`error-${field.name}`) || 
                        document.querySelector(`[data-error-for="${field.name}"]`);
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        field.classList.add('border-red-500');
    }
}

// Función para manejar el envío del formulario
function handleFormSubmit(e) {
    e.preventDefault();

    if (window.isFormSubmitting) return;

    const form = e.target;
    const isEmpresa = document.querySelector('[data-role="empresa"]') !== null;
    
    // Campos comunes
    const nombreInput = form.querySelector('[name="nombre"]');
    
    // Validar campos obligatorios
    let isValid = true;
    
    // Validar nombre
    if (!nombreInput || !nombreInput.value.trim()) {
        showError(nombreInput, 'El nombre es obligatorio');
        isValid = false;
    }

    if (!isValid) {
        Swal.fire({
            title: 'Error de validación',
            text: 'Por favor, completa todos los campos obligatorios',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
        return;
    }

    // Preparar envío
    window.isFormSubmitting = true;
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = 'Guardando...';
    }

    // Preparar los datos del formulario
    const formData = new FormData(form);

    // Asegurarse de que los checkboxes no marcados se envíen como 0
    ['show_telefono', 'show_dni', 'show_ciudad', 'show_direccion', 'show_web'].forEach(field => {
        if (!formData.has(field)) {
            formData.append(field, '0');
        }
    });

    // Asegurarse de que sitio_web se envíe aunque esté vacío
    if (!formData.has('sitio_web')) {
        formData.append('sitio_web', '');
    }

    // Realizar la petición fetch
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.message || 'Error en el servidor');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Éxito!',
                text: 'Los cambios se han guardado correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            }).then(() => {
                window.location.reload();
            });
        } else if (data.errors) {
            // Mostrar errores de validación
            Object.entries(data.errors).forEach(([field, messages]) => {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    showError(input, Array.isArray(messages) ? messages[0] : messages);
                }
            });
            throw new Error('Por favor, corrige los errores de validación');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: error.message || 'Ha ocurrido un error al guardar los cambios',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
    })
    .finally(() => {
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Guardar cambios';
        }
        window.isFormSubmitting = false;
    });
}

// Inicialización de validaciones
document.addEventListener('DOMContentLoaded', function() {
    // Configurar el formulario
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        // Eliminar listeners anteriores y añadir el nuevo
        const newForm = profileForm.cloneNode(true);
        profileForm.parentNode.replaceChild(newForm, profileForm);
        newForm.addEventListener('submit', handleFormSubmit);
    }

    // Event listeners para validación de campos
    const inputs = {
        nombre: { min: 2, max: 100 },
        descripcion: { min: 10, max: 255 },
        telefono: { min: 9, max: 15 },
        ciudad: { min: 2, max: 100 },
        sitio_web: { min: 0, max: 255 }
    };

    Object.entries(inputs).forEach(([id, rules]) => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('blur', () => {
                validarCampo(input, id, rules.min, rules.max);
            });
        }
    });

    // Validaciones específicas
    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('blur', () => validarDNI(dniInput));
    }

    const cifInput = document.getElementById('cif');
    if (cifInput) {
        cifInput.addEventListener('blur', () => validarCIF(cifInput));
    }

    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', () => validarEmail(emailInput));
    }
});


