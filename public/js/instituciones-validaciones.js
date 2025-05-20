document.addEventListener('DOMContentLoaded', function() {
    // Objeto con las validaciones para cada campo
    const validaciones = {
        nombre: {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre debe tener al menos 3 caracteres'
        },
        email: {
            validar: (valor) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor),
            mensaje: 'Introduce un email válido'
        },
        password: {
            validar: (valor, esModoEdicion) => {
                // En modo edición, la contraseña es opcional (puede estar vacía)
                if (esModoEdicion && valor.trim() === '') return true;
                return valor.trim().length >= 8;
            },
            mensaje: 'La contraseña debe tener al menos 8 caracteres'
        },
        password_confirmation: {
            validar: (valor, _, formulario) => {
                const password = formulario.querySelector('#password').value;
                // Si la contraseña principal está vacía y estamos en modo edición, no validamos
                if (password.trim() === '' && document.getElementById('form_method').value === 'PUT') return true;
                return valor === password;
            },
            mensaje: 'Las contraseñas no coinciden'
        },
        dni: {
            validar: (valor) => {
                // Validar DNI/NIE español o al menos 5 caracteres para otros documentos
                const dniRegex = /^[0-9XYZ][0-9]{7}[A-Z]$/;
                return dniRegex.test(valor) || valor.trim().length >= 5;
            },
            mensaje: 'Introduce un DNI/NIF válido (formato español) o al menos 5 caracteres'
        },
        telefono: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener entre 9 y 15 dígitos
                if (valor.trim() === '') return true;
                return /^\d{9,15}$/.test(valor.replace(/\s/g, ''));
            },
            mensaje: 'El teléfono debe tener entre 9 y 15 dígitos'
        },
        codigo_centro: {
            validar: (valor) => valor.trim().length >= 5,
            mensaje: 'El código de centro debe tener al menos 5 caracteres'
        },
        tipo_institucion: {
            validar: (valor) => valor.trim() !== '',
            mensaje: 'Selecciona un tipo de institución'
        },
        direccion: {
            validar: (valor) => valor.trim().length >= 5,
            mensaje: 'La dirección debe tener al menos 5 caracteres'
        },
        ciudad: {
            validar: (valor) => valor.trim().length >= 2,
            mensaje: 'La ciudad debe tener al menos 2 caracteres'
        },
        codigo_postal: {
            validar: (valor) => /^\d{4,10}$/.test(valor.trim()),
            mensaje: 'El código postal debe tener entre 4 y 10 dígitos'
        },
        representante_legal: {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre del representante legal debe tener al menos 3 caracteres'
        },
        cargo_representante: {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El cargo del representante debe tener al menos 3 caracteres'
        },
        descripcion: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener entre 10 y 500 caracteres
                if (valor.trim() === '') return true;
                return valor.trim().length >= 10 && valor.trim().length <= 500;
            },
            mensaje: 'La descripción debe tener entre 10 y 500 caracteres'
        },
        sitio_web: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe ser una URL válida
                if (valor.trim() === '') return true;
                try {
                    new URL(valor);
                    return true;
                } catch (_) {
                    return false;
                }
            },
            mensaje: 'Introduce una URL válida (incluyendo http:// o https://)'
        },
        imagen: {
            validar: (valor, _, __, input) => {
                // Si no hay archivo, es válido (la imagen es opcional)
                if (!input.files || input.files.length === 0) return true;
                
                const file = input.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                return validTypes.includes(file.type) && file.size <= maxSize;
            },
            mensaje: 'La imagen debe ser JPG, PNG, GIF o WEBP y no superar los 5MB'
        }
    };

    // Función para mostrar errores
    function mostrarError(input, mensaje) {
        // Eliminar error si ya existe
        eliminarError(input);
        
        // Añadir clase de error al campo
        input.classList.add('border-red-500');
        
        // Crear mensaje de error
        const errorElement = document.createElement('span');
        errorElement.classList.add('text-red-600', 'text-xs', 'mt-1', 'error-message');
        errorElement.textContent = mensaje;
        
        // Insertar después del input
        input.parentNode.appendChild(errorElement);
    }

    // Función para eliminar errores
    function eliminarError(input) {
        input.classList.remove('border-red-500');
        const errorMessages = input.parentNode.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());
    }

    // Función para validar un campo
    function validarCampo(campo, mostrarMensaje = true) {
        const input = document.getElementById(campo);
        if (!input) return true; // Si no existe el campo, no validamos
        
        const validacion = validaciones[campo];
        if (!validacion) return true; // Si no hay validación definida, no validamos
        
        const form = input.closest('form');
        const esModoEdicion = document.getElementById('form_method')?.value === 'PUT';
        
        const esValido = validacion.validar(input.value, esModoEdicion, form, input);
        
        if (!esValido && mostrarMensaje) {
            mostrarError(input, validacion.mensaje);
        } else if (esValido) {
            eliminarError(input);
        }
        
        return esValido;
    }

    // Añadir eventos de validación a cada campo en tiempo real
    Object.keys(validaciones).forEach(campo => {
        const input = document.getElementById(campo);
        if (!input) return;
        
        // Determinar qué evento usar según el tipo de campo
        let evento = 'blur'; // Por defecto usar blur
        
        if (input.tagName === 'SELECT') {
            evento = 'change';
        }
        
        input.addEventListener(evento, function() {
            validarCampo(campo);
        });
        
        // Para campos de texto, también validar al escribir después de un retraso
        if (input.tagName === 'INPUT' && input.type !== 'file') {
            input.addEventListener('input', debounce(function() {
                validarCampo(campo);
            }, 500));
        }
    });

    // Validar descripción y actualizar contador de caracteres
    const descripcion = document.getElementById('descripcion');
    if (descripcion) {
        // Crear contador de caracteres
        const contador = document.createElement('span');
        contador.classList.add('text-xs', 'text-gray-500', 'mt-1');
        contador.textContent = '0/500 caracteres';
        descripcion.parentNode.appendChild(contador);
        
        descripcion.addEventListener('input', function() {
            const longitud = this.value.trim().length;
            contador.textContent = `${longitud}/500 caracteres`;
            
            // Cambiar color si se acerca al límite
            if (longitud > 450) {
                contador.classList.add('text-amber-500');
            } else {
                contador.classList.remove('text-amber-500');
            }
            
            // Cambiar color si supera el límite
            if (longitud > 500) {
                contador.classList.add('text-red-500');
                contador.classList.remove('text-amber-500');
            } else {
                contador.classList.remove('text-red-500');
            }
        });
    }

    // Función debounce para no validar constantemente mientras se escribe
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }

    // Validar formulario en submit
    const form = document.getElementById('form-institucion');
    if (form) {
        // Store the original submit handler
        const originalSubmitHandler = form.onsubmit;
        
        form.addEventListener('submit', function(e) {
            // Validar todos los campos
            let formValid = true;
            
            // Determinar si estamos en modo edición
            const esModoEdicion = document.getElementById('form_method')?.value === 'PUT';
            
            // Validar campos obligatorios siempre
            const camposObligatorios = [
                'nombre', 'email', 'dni', 'telefono', 'codigo_centro', 
                'tipo_institucion', 'direccion', 'ciudad', 'codigo_postal', 
                'representante_legal', 'cargo_representante'
            ];
            
            // Si no es modo edición, validar contraseña también
            if (!esModoEdicion) {
                camposObligatorios.push('password', 'password_confirmation');
            } else if (document.getElementById('password').value.trim() !== '') {
                // Si es modo edición y hay contraseña, validarla
                camposObligatorios.push('password', 'password_confirmation');
            }
            
            // Validar todos los campos obligatorios
            camposObligatorios.forEach(campo => {
                if (!validarCampo(campo)) {
                    formValid = false;
                }
            });
            
            // Validar campos opcionales si tienen valor
            const camposOpcionales = ['descripcion', 'sitio_web', 'imagen'];
            camposOpcionales.forEach(campo => {
                const input = document.getElementById(campo);
                if (input) {
                    if (
                        (input.type === 'file' && input.files.length > 0) || 
                        (input.type !== 'file' && input.value.trim() !== '')
                    ) {
                        if (!validarCampo(campo)) {
                            formValid = false;
                        }
                    }
                }
            });
            
            // Detener envío si hay errores
            if (!formValid) {
                e.preventDefault();
                e.stopPropagation();
                
                // Mostrar mensaje general de error
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-4';
                errorDiv.innerHTML = `
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Por favor, corrige los errores en el formulario</h3>
                        </div>
                    </div>
                `;
                
                // Remover mensajes anteriores
                const previousError = form.querySelector('.bg-red-50');
                if (previousError) {
                    previousError.remove();
                }
                
                form.insertBefore(errorDiv, form.firstChild);
                
                // Hacer scroll al primer campo con error
                const primerError = form.querySelector('.border-red-500');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                return false;
            }
            
            // Si llegamos aquí, el formulario es válido
            return true;
        });
    }
}); 