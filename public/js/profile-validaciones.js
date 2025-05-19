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
    
    const valor = field.value.trim().toUpperCase();
    if (!valor) {
        showError(field, "El CIF es obligatorio");
        return false;
    }
    
    // Validación básica del formato CIF
    // Letra válida + 7 dígitos + dígito o letra de control
    const cifRegex = /^[ABCDEFGHJKLMNPQRSUVW]\d{7}[0-9A-J]$/;
    
    if (!cifRegex.test(valor)) {
        showError(field, "El formato del CIF debe ser: letra + 7 números + dígito/letra");
        return false;
    }

    // Si pasa la validación básica, lo consideramos válido
    hideError(field);
    return true;
}

function validarBanner(field) {
    if (field.files.length > 0) {
        const file = field.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!validImageTypes.includes(fileType)) {
            showError(field, "El archivo debe ser una imagen (JPG, PNG, GIF o WEBP)");
            return false;
        } else if (file.size > 5 * 1024 * 1024) { // 5MB
            showError(field, "La imagen no puede exceder los 5MB");
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
    
    // Validar campos obligatorios
    let isValid = true;
    
    // Validar nombre
    const nombreInput = form.querySelector('[name="nombre"]');
    if (!nombreInput || !nombreInput.value.trim()) {
        showError(nombreInput, 'El nombre es obligatorio');
        isValid = false;
    }

    // Validar CIF si es empresa
    if (isEmpresa) {
        const cifInput = form.querySelector('[name="cif"]');
        if (cifInput && !validarCIF(cifInput)) {
            isValid = false;
        }
    }

    if (!isValid) {
        Swal.fire({
            title: 'Error de validación',
            text: 'Por favor, completa todos los campos obligatorios correctamente',
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

    // Asegurarse de que los checkboxes no marcados se envíen como false
    ['show_telefono', 'show_cif', 'show_ciudad', 'show_direccion', 'show_web'].forEach(field => {
        const checkbox = form.querySelector(`input[name="${field}"]`);
        formData.set(field, checkbox && checkbox.checked ? '1' : '0');
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
            const user = data.user;
            console.log('Datos recibidos del servidor:', user);

            // Actualizar nombre
            const nombreElements = document.querySelectorAll('h1.text-4xl.font-bold');
            nombreElements.forEach(el => el.textContent = user.nombre);

            // Actualizar email
            const emailElements = document.querySelectorAll('.text-purple-600 span, .text-purple-600');
            emailElements.forEach(el => {
                if (el.textContent.includes('@')) {
                    el.textContent = user.email;
                }
            });

            // Actualizar descripción
            const descripcionElement = document.querySelector('.bg-purple-50.rounded-xl p-6.mb-8 p');
            if (descripcionElement) {
                if (user.descripcion) {
                    descripcionElement.textContent = user.descripcion;
                    descripcionElement.parentElement.style.display = 'block';
                } else {
                    descripcionElement.parentElement.style.display = 'none';
                }
            }

            // Actualizar la barra de progreso
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const progressPercentage = document.getElementById('progressPercentage');
            const progressMessage = document.getElementById('progressMessage');
            const progressSection = document.getElementById('progressSection');

            if (progressBar && progressText && progressPercentage && progressMessage) {
                const porcentaje = data.porcentaje;
                
                // Actualizar la barra de progreso con animación
                progressBar.style.width = porcentaje + '%';
                progressText.textContent = porcentaje + '%';
                progressPercentage.textContent = porcentaje + '%';

                // Actualizar mensaje según el porcentaje
                if (porcentaje < 50) {
                    progressMessage.textContent = '¡Sigue completando tu perfil!';
                } else if (porcentaje < 80) {
                    progressMessage.textContent = '¡Vas por buen camino!';
                } else {
                    progressMessage.textContent = '¡Casi lo tienes!';
                }

                // Manejar la visibilidad de la sección de progreso
                if (porcentaje === 100) {
                    // Ocultar la sección con animación
                    progressSection.style.opacity = '0';
                    setTimeout(() => {
                        progressSection.style.display = 'none';
                    }, 500);
                } else {
                    // Mostrar la sección si estaba oculta
                    if (progressSection.style.display === 'none') {
                        progressSection.style.display = 'block';
                        // Forzar un reflow para que la animación funcione
                        progressSection.offsetHeight;
                        progressSection.style.opacity = '1';
                    }
                }
            }

            // Actualizar campos de visibilidad y valores
            const camposInfo = {
                'telefono': { visible: user.show_telefono, valor: user.telefono },
                'ciudad': { visible: user.show_ciudad, valor: user.ciudad },
                'direccion': { visible: user.show_direccion, valor: user.direccion },
                'web': { visible: user.show_web, valor: user.sitio_web }
            };

            // Actualización específica del CIF
            if (user.empresa) {
                console.log('Actualizando CIF:', user.empresa.cif);
                console.log('Visibilidad CIF:', user.empresa.show_cif);

                // Actualizar todos los elementos que muestran el CIF
                const cifContainers = document.querySelectorAll('[data-campo="cif"], [data-campo="empresa-cif"]');
                console.log('Contenedores CIF encontrados:', cifContainers.length);
                
                cifContainers.forEach(elemento => {
                    elemento.style.display = user.empresa.show_cif ? 'flex' : 'none';
                    console.log('Actualizando visibilidad de contenedor CIF:', elemento, user.empresa.show_cif);
                });

                // Actualizar el valor del CIF en todos los lugares donde aparece
                const cifValues = document.querySelectorAll('[data-valor="cif"], .font-medium.text-gray-900[data-valor="cif"], p.font-medium.text-gray-900');
                console.log('Elementos de valor CIF encontrados:', cifValues.length);
                
                cifValues.forEach(elemento => {
                    elemento.textContent = user.empresa.cif || 'No especificado';
                    console.log('Actualizando valor de CIF en elemento:', elemento);
                });

                // Actualizar específicamente el texto del CIF en la sección de información
                const cifInfoText = document.querySelector('.ml-4 p.font-medium.text-gray-900');
                if (cifInfoText) {
                    cifInfoText.textContent = user.empresa.cif || 'No especificado';
                    console.log('Actualizando texto de info CIF:', cifInfoText);
                }

                // Actualizar el valor en el formulario
                const cifInput = document.querySelector('input[name="cif"]');
                if (cifInput) {
                    cifInput.value = user.empresa.cif || '';
                    console.log('Actualizando input CIF:', cifInput);
                }

                // Actualizar el checkbox de visibilidad
                const cifCheckbox = document.querySelector('input[name="show_cif"]');
                if (cifCheckbox) {
                    cifCheckbox.checked = user.empresa.show_cif;
                    console.log('Actualizando checkbox CIF:', cifCheckbox);
                }

                // Forzar actualización de elementos específicos de empresa
                const empresaCifElements = document.querySelectorAll('.flex.items-start[data-campo="empresa-cif"] p.font-medium.text-gray-900');
                empresaCifElements.forEach(element => {
                    element.textContent = user.empresa.cif || 'No especificado';
                    console.log('Actualizando elemento específico de empresa:', element);
                });
            }

            // Actualizar el resto de campos
            Object.entries(camposInfo).forEach(([campo, info]) => {
                // Actualizar visibilidad
                document.querySelectorAll(`[data-campo="${campo}"]`).forEach(elemento => {
                    elemento.style.display = info.visible ? 'flex' : 'none';
                });

                // Actualizar valores
                document.querySelectorAll(`[data-valor="${campo}"]`).forEach(elemento => {
                    elemento.textContent = info.valor || 'No especificado';
                });
            });

            // Actualizar imagen de perfil si se cambió
            if (user.imagen) {
                document.querySelectorAll('.rounded-full img').forEach(img => {
                    img.src = `/profile_images/${user.imagen}`;
                });
            }

            // Actualizar banner si se cambió
            if (user.banner) {
                const bannerElement = document.querySelector('.h-64 img');
                if (bannerElement) {
                    bannerElement.src = `/profile_banners/${user.banner}`;
                }
            }

            // Actualizar CV si se cambió (solo para estudiantes)
            if (user.estudiante && user.estudiante.cv_pdf) {
                const cvLinks = document.querySelectorAll('a[href*="cv/"]');
                cvLinks.forEach(link => {
                    link.href = `/cv/${user.estudiante.cv_pdf}`;
                });
            }

            // Mostrar mensaje de éxito
            Swal.fire({
                title: '¡Éxito!',
                text: 'Los cambios se han guardado correctamente',
                icon: 'success',
                confirmButtonColor: '#7C3AED'
            });

            // Cerrar el modal
            closeEditModal();
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