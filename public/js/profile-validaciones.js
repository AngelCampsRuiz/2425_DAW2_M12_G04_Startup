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

// Función para validar teléfono
function validarTelefono(field) {
    if (!field || !field.value.trim()) return true;
    const valor = field.value.trim();
    
    // Expresión regular para teléfonos móviles españoles (comienzan con 6 o 7)
    const telefonoRegex = /^[67][0-9]{8}$/;
    if (!telefonoRegex.test(valor)) {
        showError(field, "El teléfono debe ser un número móvil válido (9 dígitos comenzando por 6 o 7)");
        return false;
    }
    
    hideError(field);
    return true;
}

// Función para validar sitio web
function validarSitioWeb(field) {
    if (!field || !field.value.trim()) return true;
    const valor = field.value.trim();
    
    try {
        new URL(valor);
        hideError(field);
        return true;
    } catch (e) {
        showError(field, "La URL no es válida");
        return false;
    }
}

// Función para validar descripción
function validarDescripcion(field) {
    if (!field || !field.value.trim()) return true;
    const valor = field.value.trim();
    
    if (valor.length < 10) {
        showError(field, "La descripción debe tener al menos 10 caracteres");
        return false;
    }
    
    if (valor.length > 500) {
        showError(field, "La descripción no puede exceder los 500 caracteres");
        return false;
    }
    
    hideError(field);
    return true;
}

// Función para validar archivos
function validarArchivo(field, tipo) {
    if (!field || !field.files || !field.files[0]) return true;
    const file = field.files[0];
    
    if (tipo === 'imagen') {
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showError(field, "El archivo debe ser una imagen (JPG, PNG, GIF o WEBP)");
            return false;
        }
        if (file.size > 2 * 1024 * 1024) { // 2MB
            showError(field, "La imagen no puede exceder los 2MB");
            return false;
        }
    } else if (tipo === 'cv') {
        if (file.type !== 'application/pdf') {
            showError(field, "El archivo debe ser un PDF");
            return false;
        }
        if (file.size > 5 * 1024 * 1024) { // 5MB
            showError(field, "El CV no puede exceder los 5MB");
            return false;
        }
    }
    
    hideError(field);
    return true;
}

// Modificar el CSS para los campos obligatorios
const style = document.createElement('style');
style.textContent = `
    .required-field {
        position: relative;
        font-weight: 500;
    }
    .required-field::after {
        content: ' *';
        color: #EF4444;
        margin-left: 4px;
        font-size: 1.2em;
        font-weight: bold;
    }
`;
document.head.appendChild(style);

// Función para añadir asteriscos a campos obligatorios
function marcarCamposObligatorios() {
    const isEmpresa = document.querySelector('[data-role="empresa"]') !== null;
    
    // Campos siempre obligatorios
    const camposObligatorios = [
        { id: 'nombre', label: 'Nombre' },
        { id: 'email', label: 'Email' }
    ];

    // Campos obligatorios según el tipo de usuario
    if (isEmpresa) {
        camposObligatorios.push({ id: 'cif', label: 'CIF' });
    } else {
        camposObligatorios.push({ id: 'dni', label: 'DNI' });
        // Si es estudiante, el CV es obligatorio
        if (document.querySelector('[data-role="estudiante"]')) {
            camposObligatorios.push({ id: 'cv_pdf', label: 'Curriculum Vitae' });
        }
    }

    // Actualizar las etiquetas
    camposObligatorios.forEach(campo => {
        const label = document.querySelector(`label[for="${campo.id}"]`);
        if (label) {
            label.classList.add('required-field');
        }
    });
}

// Modificar la función handleFormSubmit para validar campos obligatorios
function handleFormSubmit(e) {
    e.preventDefault();

    if (window.isFormSubmitting) return;

    const form = e.target;
    const isEmpresa = document.querySelector('[data-role="empresa"]') !== null;
    
    // Resetear errores
    resetAllErrors();
    
    // Validar todos los campos
    let isValid = true;
    
    // Campos obligatorios
    const nombreInput = form.querySelector('[name="nombre"]');
    const emailInput = form.querySelector('[name="email"]');
    
    // Validar campos obligatorios
    if (!nombreInput || !nombreInput.value.trim()) {
        showError(nombreInput, 'El nombre es obligatorio');
        isValid = false;
    }
    
    if (!emailInput || !emailInput.value.trim()) {
        showError(emailInput, 'El email es obligatorio');
        isValid = false;
    } else if (!validarEmail(emailInput)) {
        isValid = false;
    }
    
    // Validar CIF/DNI según el tipo de usuario
    if (isEmpresa) {
        const cifInput = form.querySelector('[name="cif"]');
        if (!cifInput || !cifInput.value.trim()) {
            showError(cifInput, 'El CIF es obligatorio');
            isValid = false;
        } else if (!validarCIF(cifInput)) {
            isValid = false;
        }
    } else {
        const dniInput = form.querySelector('[name="dni"]');
        if (!dniInput || !dniInput.value.trim()) {
            showError(dniInput, 'El DNI es obligatorio');
            isValid = false;
        } else if (!validarDNI(dniInput)) {
            isValid = false;
        }
        
        // Validar CV si es estudiante
        if (document.querySelector('[data-role="estudiante"]')) {
            const cvInput = form.querySelector('[name="cv_pdf"]');
            const cvActual = document.querySelector('[data-cv-actual]');
            if (!cvInput?.files?.length && !cvActual) {
                showError(cvInput, 'El CV es obligatorio');
                isValid = false;
            } else if (cvInput?.files?.length && !validarArchivo(cvInput, 'cv')) {
                isValid = false;
            }
        }
    }

    // Validar campos opcionales si tienen valor
    const telefonoInput = form.querySelector('[name="telefono"]');
    if (telefonoInput?.value.trim() && !validarTelefono(telefonoInput)) isValid = false;

    const descripcionInput = form.querySelector('[name="descripcion"]');
    if (descripcionInput?.value.trim() && !validarDescripcion(descripcionInput)) isValid = false;

    const sitioWebInput = form.querySelector('[name="sitio_web"]');
    if (sitioWebInput?.value.trim() && !validarSitioWeb(sitioWebInput)) isValid = false;

    const ciudadInput = form.querySelector('[name="ciudad"]');
    if (ciudadInput?.value.trim() && !validarCampo(ciudadInput, 'ciudad', 2, 100)) isValid = false;

    // Validar imagen si se ha seleccionado
    const imagenInput = form.querySelector('[name="imagen"]');
    if (imagenInput?.files?.length && !validarArchivo(imagenInput, 'imagen')) isValid = false;

    if (!isValid) {
        Swal.fire({
            title: 'Error de validación',
            text: 'Por favor, completa correctamente todos los campos obligatorios (*)',
            icon: 'error',
            confirmButtonColor: '#7C3AED'
        });
        return;
    }

    // Si todas las validaciones pasan, continuar con el envío
    window.isFormSubmitting = true;
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Guardando...
        `;
    }

    // Preparar los datos del formulario
    const formData = new FormData(form);

    // Asegurarse de que los checkboxes no marcados se envíen como false
    ['show_telefono', 'show_cif', 'show_ciudad', 'show_direccion', 'show_web'].forEach(field => {
        const checkbox = form.querySelector(`input[name="${field}"]`);
        formData.set(field, checkbox && checkbox.checked ? '1' : '0');
    });

    // Asegurarse de que sitio_web se envíe aunque esté vacío
    if (!formData.has('sitio_web')) {
        formData.append('sitio_web', '');
    }

    if (!isEmpresa) {
        formData.delete('show_cif');
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
            // Actualizar campos de visibilidad
            const user = data.user;
            const camposVisibles = {
                'telefono': user.show_telefono,
                'cif': user.empresa ? user.empresa.show_cif : false,
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

            // Mostrar mensaje de éxito sin recargar
            Swal.fire({
                title: '¡Éxito!',
                text: 'Los cambios se han guardado correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            });

            // Cerrar el modal si existe
            if (typeof closeEditModal === 'function') {
                closeEditModal();
            }
        } else if (data.errors) {
            // Mostrar errores de validación
            Object.entries(data.errors).forEach(([field, messages]) => {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    showError(input, Array.isArray(messages) ? messages[0] : messages);
                }
            });
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

// Función para manejar la visibilidad de los campos en tiempo real
function setupVisibilityToggles() {
    const checkboxes = {
        'show_telefono': '[data-campo="telefono"]',
        'show_cif': '[data-campo="cif"], [data-campo="empresa-cif"]',
        'show_ciudad': '[data-campo="ciudad"]',
        'show_direccion': '[data-campo="direccion"]',
        'show_web': '[data-campo="web"]'
    };

    // Inicializar el estado inicial de los campos
    Object.entries(checkboxes).forEach(([checkboxName, selectors]) => {
        const checkbox = document.querySelector(`input[name="${checkboxName}"]`);
        // Manejar múltiples selectores
        selectors.split(', ').forEach(selector => {
            const campos = document.querySelectorAll(selector);
            campos.forEach(campo => {
                if (checkbox && campo) {
                    // Establecer visibilidad inicial
                    campo.style.display = checkbox.checked ? 'flex' : 'none';
                    
                    // Añadir listener para cambios
                    checkbox.addEventListener('change', function() {
                        campo.style.display = this.checked ? 'flex' : 'none';
                    });
                }
            });
        });
    });
}

// Inicialización de validaciones
document.addEventListener('DOMContentLoaded', function() {
    marcarCamposObligatorios();
    
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

    setupVisibilityToggles();
});


