document.addEventListener('DOMContentLoaded', function() {
    // Objeto con las validaciones para cada campo
    const validaciones = {
        nombre: {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre debe tener al menos 3 caracteres'
        },
        apellidos: {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'Los apellidos deben tener al menos 3 caracteres'
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
        fecha_nacimiento: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe ser una fecha válida
                if (valor.trim() === '') return true;
                
                // Validar formato de fecha
                const fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
                if (!fechaRegex.test(valor)) return false;
                
                // Validar que sea una fecha válida
                const fecha = new Date(valor);
                if (isNaN(fecha.getTime())) return false;
                
                // Validar que no sea una fecha futura y que no sea hace más de 120 años
                const hoy = new Date();
                const minDate = new Date();
                minDate.setFullYear(hoy.getFullYear() - 120);
                
                return fecha <= hoy && fecha >= minDate;
            },
            mensaje: 'Introduce una fecha de nacimiento válida'
        },
        telefono: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener entre 9 y 15 dígitos
                if (valor.trim() === '') return true;
                return /^\d{9,15}$/.test(valor.replace(/\s/g, ''));
            },
            mensaje: 'El teléfono debe tener entre 9 y 15 dígitos'
        },
        direccion: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener al menos 5 caracteres
                if (valor.trim() === '') return true;
                return valor.trim().length >= 5;
            },
            mensaje: 'La dirección debe tener al menos 5 caracteres'
        },
        ciudad: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener al menos 2 caracteres
                if (valor.trim() === '') return true;
                return valor.trim().length >= 2;
            },
            mensaje: 'La ciudad debe tener al menos 2 caracteres'
        },
        codigo_postal: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener entre 4 y 10 dígitos
                if (valor.trim() === '') return true;
                return /^\d{4,10}$/.test(valor.trim());
            },
            mensaje: 'El código postal debe tener entre 4 y 10 dígitos'
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
        descripcion: {
            validar: (valor) => {
                // Opcional, pero si se proporciona debe tener entre 10 y 500 caracteres
                if (valor.trim() === '') return true;
                return valor.trim().length >= 10 && valor.trim().length <= 500;
            },
            mensaje: 'La descripción debe tener entre 10 y 500 caracteres'
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
        if (input.tagName === 'INPUT' && input.type !== 'file' && input.type !== 'date') {
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

    // Variable para controlar envíos múltiples
    let isSubmitting = false;

    // Validar formulario en submit
    const form = document.getElementById('form-alumno');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Evitar envíos duplicados
            if (isSubmitting) return;
            
            // Validar todos los campos
            let formValid = true;
            
            // Determinar si estamos en modo edición
            const esModoEdicion = document.getElementById('form_method')?.value === 'PUT';
            
            // Validar campos obligatorios siempre
            const camposObligatorios = [
                'nombre', 'email', 'dni'
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
            const camposOpcionales = [
                'apellidos', 'telefono', 'direccion', 'ciudad', 'codigo_postal', 
                'fecha_nacimiento', 'sitio_web', 'descripcion', 'imagen'
            ];
            
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
            
            // Si el formulario es válido, enviarlo mediante AJAX
            isSubmitting = true;
            
            // Deshabilitar botón de envío
            const submitBtn = document.getElementById('btn-guardar');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                `;
            }
            
            const formData = new FormData(form);
            const url = form.action;
            const method = esModoEdicion ? 'PUT' : 'POST';
            
            // Si es edición, asegurarse de usar el método PUT
            if (esModoEdicion) {
                formData.append('_method', 'PUT');
            }
            
            fetch(url, {
                method: 'POST', // Siempre POST con FormData
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cerrar el modal
                    const modal = document.getElementById('modal-alumno');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                    
                    // Mostrar mensaje de éxito
                    mostrarMensajeExito(data.message || 'Operación realizada con éxito');
                    
                    // Recargar solo la tabla
                    refreshAlumnosTable();
                } else if (data.errors) {
                    // Mostrar errores de validación
                    mostrarErroresValidacion(data.errors);
                } else {
                    throw new Error(data.message || 'Ha ocurrido un error desconocido');
                }
            })
            .catch(error => {
                console.error('Error al enviar formulario:', error);
                
                // Mostrar mensaje de error
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
                            <h3 class="text-sm font-medium text-red-800">Error al procesar el formulario</h3>
                            <p class="text-sm text-red-700">${error.message}</p>
                        </div>
                    </div>
                `;
                
                // Remover mensajes anteriores
                const previousError = form.querySelector('.bg-red-50');
                if (previousError) {
                    previousError.remove();
                }
                
                form.insertBefore(errorDiv, form.firstChild);
            })
            .finally(() => {
                isSubmitting = false;
                
                // Restaurar botón de envío
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Guardar';
                }
            });
        });
    }

    // Función para mostrar mensajes de éxito
    function mostrarMensajeExito(mensaje) {
        const messageElement = document.getElementById('success-message');
        const messageText = document.getElementById('success-message-text');
        
        if (messageElement && messageText) {
            messageText.textContent = mensaje;
            messageElement.style.display = 'block';
            
            // Desplazar al principio de la página para ver el mensaje
            window.scrollTo(0, 0);
            
            // Ocultar el mensaje después de 3 segundos
            setTimeout(function() {
                messageElement.style.display = 'none';
            }, 3000);
        }
    }

    // Función para mostrar errores de validación del servidor
    function mostrarErroresValidacion(errores) {
        // Mostrar errores en los campos
        for (const campo in errores) {
            const input = document.getElementById(campo);
            if (input) {
                mostrarError(input, errores[campo][0]);
            }
        }
        
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
        const form = document.getElementById('form-alumno');
        const previousError = form.querySelector('.bg-red-50');
        if (previousError) {
            previousError.remove();
        }
        
        form.insertBefore(errorDiv, form.firstChild);
    }

    // Función para recargar solo la tabla de alumnos
    function refreshAlumnosTable() {
        // Obtener los valores de los filtros actuales
        const filtroNombre = document.getElementById('filtro_nombre')?.value || '';
        const filtroEmail = document.getElementById('filtro_email')?.value || '';
        const filtroDni = document.getElementById('filtro_dni')?.value || '';
        const filtroCiudad = document.getElementById('filtro_ciudad')?.value || '';
        const filtroEstado = document.getElementById('filtro_estado')?.value || '';
        
        // Construir parámetros de filtrado
        const params = new URLSearchParams();
        if (filtroNombre) params.append('nombre', filtroNombre);
        if (filtroEmail) params.append('email', filtroEmail);
        if (filtroDni) params.append('dni', filtroDni);
        if (filtroCiudad) params.append('ciudad', filtroCiudad);
        if (filtroEstado) params.append('estado', filtroEstado);
        
        // Añadir timestamp para evitar caché
        params.append('_', new Date().getTime());
        
        // Mostrar indicador de carga
        const tablaContainer = document.getElementById('tabla-container');
        if (tablaContainer) {
            tablaContainer.innerHTML = `
                <div class="flex justify-center items-center p-8">
                    <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            `;
        }

        // Hacer petición AJAX para obtener la tabla actualizada
        fetch(`/admin/alumnos?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (tablaContainer && data.tabla) {
                tablaContainer.innerHTML = data.tabla;
                
                // Volver a asignar eventos a los botones de la tabla actualizada
                initTableButtons();
            } else {
                throw new Error('No se recibieron datos válidos de la tabla');
            }
        })
        .catch(error => {
            console.error('Error al actualizar la tabla:', error);
            if (tablaContainer) {
                tablaContainer.innerHTML = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">No se pudieron cargar los datos. ${error.message}</span>
                    </div>
                `;
            }
        });
    }

    // Función para inicializar los botones de la tabla
    function initTableButtons() {
        // Botones de editar
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                // Verificar que la función existe en el scope global
                if (typeof window.mostrarFormularioEditar === 'function') {
                    window.mostrarFormularioEditar(id);
                } else {
                    console.error('La función mostrarFormularioEditar no está disponible');
                }
            });
        });
        
        // Botones de activar/desactivar
        document.querySelectorAll('.btn-activar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const isActive = this.getAttribute('data-active');
                // Verificar que la función existe en el scope global
                if (typeof window.openActivateModal === 'function') {
                    window.openActivateModal(id, isActive);
                } else {
                    console.error('La función openActivateModal no está disponible');
                }
            });
        });
        
        // Botones de crear
        document.querySelectorAll('.btn-crear').forEach(btn => {
            btn.addEventListener('click', function() {
                // Verificar que la función existe en el scope global
                if (typeof window.mostrarFormularioCrear === 'function') {
                    window.mostrarFormularioCrear();
                } else {
                    console.error('La función mostrarFormularioCrear no está disponible');
                }
            });
        });
    }
}); 