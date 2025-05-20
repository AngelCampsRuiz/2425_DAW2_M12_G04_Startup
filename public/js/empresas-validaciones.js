/**
 * Validaciones para el formulario de empresas
 * Implementación no intrusiva para crear y editar empresas
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de validación de empresas cargado correctamente');
    
    // Configuración de validaciones
    const validaciones = {
        // Datos de usuario
        'nombre': {
            validar: (valor) => valor.trim().length >= 3,
            mensaje: 'El nombre es obligatorio y debe tener al menos 3 caracteres.'
        },
        'email': {
            validar: (valor) => {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(valor);
            },
            mensaje: 'El email debe tener un formato válido.'
        },
        'password': {
            validar: (valor, elemento) => {
                // Si estamos en modo edición (modal título contiene "Editar") y el campo está vacío, no es requerido
                const esEdicion = document.getElementById('modal-titulo') && 
                                  document.getElementById('modal-titulo').textContent.includes('Editar');
                
                if (esEdicion && valor === '') {
                    return true; // En edición, contraseña vacía es válida (no se cambia)
                }
                
                // En modo creación o si se está cambiando la contraseña
                return valor.length >= 6;
            },
            mensaje: 'La contraseña debe tener al menos 6 caracteres.'
        },
        'password_confirmation': {
            validar: (valor, elemento) => {
                const password = document.getElementById('password').value;
                
                // Si estamos en modo edición y ambos campos están vacíos, es válido
                const esEdicion = document.getElementById('modal-titulo') && 
                                  document.getElementById('modal-titulo').textContent.includes('Editar');
                
                if (esEdicion && valor === '' && password === '') {
                    return true;
                }
                
                // Si password tiene valor, debe coincidir
                if (password) {
                    return valor === password;
                }
                
                return true;
            },
            mensaje: 'Las contraseñas no coinciden.'
        },
        'dni': {
            validar: (valor) => {
                if (!valor.trim()) return false; // El DNI es obligatorio
                
                // Validar formato de DNI/NIE español o documento extranjero (mínimo 5 caracteres)
                const dniRegex = /^[0-9]{8}[A-Z]$/;
                const nieRegex = /^[XYZ][0-9]{7}[A-Z]$/;
                return dniRegex.test(valor) || nieRegex.test(valor) || valor.length >= 5;
            },
            mensaje: 'El DNI/NIE es obligatorio y debe tener un formato válido.'
        },
        'telefono': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                return /^[0-9+() -]{9,15}$/.test(valor.replace(/\s+/g, ''));
            },
            mensaje: 'El teléfono debe tener entre 9 y 15 dígitos.'
        },
        'ciudad': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                return valor.trim().length >= 2;
            },
            mensaje: 'La ciudad debe tener al menos 2 caracteres.'
        },
        'fecha_nacimiento': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                
                // Validar formato de fecha y que no sea futura
                const fecha = new Date(valor);
                const hoy = new Date();
                return !isNaN(fecha) && fecha <= hoy;
            },
            mensaje: 'La fecha de constitución no puede ser futura.'
        },
        
        // Datos de empresa
        'cif': {
            validar: (valor) => {
                if (!valor.trim()) return false; // El CIF es obligatorio
                return valor.trim().length >= 5;
            },
            mensaje: 'El CIF es obligatorio y debe tener un formato válido (mínimo 5 caracteres).'
        },
        'provincia': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                return valor.trim().length >= 2;
            },
            mensaje: 'La provincia debe tener al menos 2 caracteres.'
        },
        'direccion': {
            validar: (valor) => {
                if (!valor.trim()) return false; // La dirección es obligatoria
                return valor.trim().length >= 5;
            },
            mensaje: 'La dirección es obligatoria y debe tener al menos 5 caracteres.'
        },
        'sitio_web': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                
                // Comprobamos si comienza con http:// o https://
                if (!valor.match(/^https?:\/\//)) {
                    valor = 'http://' + valor;
                }
                
                try {
                    new URL(valor);
                    return true;
                } catch (e) {
                    return false;
                }
            },
            mensaje: 'El sitio web debe ser una URL válida.'
        },
        'latitud': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                const lat = parseFloat(valor);
                return !isNaN(lat) && lat >= -90 && lat <= 90;
            },
            mensaje: 'La latitud debe ser un número entre -90 y 90.'
        },
        'longitud': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                const lng = parseFloat(valor);
                return !isNaN(lng) && lng >= -180 && lng <= 180;
            },
            mensaje: 'La longitud debe ser un número entre -180 y 180.'
        },
        'descripcion': {
            validar: (valor) => {
                if (valor === '') return true; // No es obligatorio
                return valor.trim().length >= 10 && valor.trim().length <= 500;
            },
            mensaje: 'La descripción debe tener entre 10 y 500 caracteres.'
        },
        'imagen': {
            validar: (valor, elemento) => {
                if (!elemento.files || elemento.files.length === 0) return true; // No es obligatorio
                
                const file = elemento.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!allowedTypes.includes(file.type)) {
                    return false;
                }
                
                if (file.size > maxSize) {
                    return false;
                }
                
                return true;
            },
            mensaje: 'La imagen debe ser de tipo JPG, PNG, GIF o WEBP y no exceder los 5MB.'
        }
    };

    // Función para validar un campo
    function validarCampo(elemento) {
        const id = elemento.id;
        if (!validaciones[id]) return true;

        const valor = elemento.value;
        const validar = validaciones[id].validar;
        const mensaje = validaciones[id].mensaje;
        
        // Buscar o crear el elemento de error
        let errorId = id + '-error';
        let errorElem = document.getElementById(errorId);
        
        // Validar el valor
        if (!validar(valor, elemento)) {
            // Mostrar error
            if (!errorElem) {
                errorElem = document.createElement('p');
                errorElem.id = errorId;
                errorElem.className = 'text-red-600 text-sm mt-1';
                elemento.parentNode.appendChild(errorElem);
            }
            errorElem.textContent = mensaje;
            elemento.classList.add('border-red-500');
            return false;
        } else {
            // Quitar error
            if (errorElem) {
                errorElem.remove();
            }
            elemento.classList.remove('border-red-500');
            return true;
        }
    }

    // Función para agregar eventos a los campos
    function agregarEventosCampos() {
        // Campos de texto y email
        const camposTexto = ['nombre', 'email', 'dni', 'telefono', 'ciudad', 'cif', 'provincia', 'direccion', 'sitio_web', 'descripcion'];
        camposTexto.forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.addEventListener('blur', function() {
                    validarCampo(this);
                });
                // También validar al cambiar para campos como textarea
                if (id === 'descripcion') {
                    campo.addEventListener('input', function() {
                        validarCampo(this);
                        actualizarContadorCaracteres(this);
                    });
                }
            }
        });
        
        // Inicializar contador de caracteres para descripción
        const descripcion = document.getElementById('descripcion');
        if (descripcion) {
            actualizarContadorCaracteres(descripcion);
        }
        
        // Campos numéricos
        const camposNumericos = ['latitud', 'longitud'];
        camposNumericos.forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.addEventListener('blur', function() {
                    validarCampo(this);
                });
            }
        });
        
        // Campos de fecha
        const fecha = document.getElementById('fecha_nacimiento');
        if (fecha) {
            fecha.addEventListener('change', function() {
                validarCampo(this);
            });
        }
        
        // Campo de imagen
        const imagen = document.getElementById('imagen');
        if (imagen) {
            imagen.addEventListener('change', function() {
                validarCampo(this);
            });
        }
        
        // Campos de contraseña
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        if (password) {
            password.addEventListener('blur', function() {
                validarCampo(this);
                // Si cambia la contraseña, validar también la confirmación
                if (passwordConfirmation && passwordConfirmation.value) {
                    validarCampo(passwordConfirmation);
                }
            });
        }
        
        if (passwordConfirmation) {
            passwordConfirmation.addEventListener('blur', function() {
                validarCampo(this);
            });
        }
    }
    
    // Función para actualizar el contador de caracteres
    function actualizarContadorCaracteres(elemento) {
        if (elemento.id !== 'descripcion') return;
        
        const contador = document.getElementById('descripcion-contador');
        if (!contador) return;
        
        const maxLength = elemento.getAttribute('maxlength') || 500;
        const caracteresRestantes = maxLength - elemento.value.length;
        contador.textContent = `${caracteresRestantes} caracteres restantes`;
        
        // Cambiar color según cantidad de caracteres restantes
        if (caracteresRestantes < 50) {
            contador.classList.remove('text-gray-500');
            contador.classList.add('text-orange-500');
        } else {
            contador.classList.remove('text-orange-500');
            contador.classList.add('text-gray-500');
        }
    }
    
    // Validar al enviar el formulario
    function inicializarFormulario() {
        const form = document.getElementById('form-empresa');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let formValido = true;
                
                // Validar todos los campos requeridos
                const camposRequeridos = ['nombre', 'email', 'dni', 'cif', 'direccion'];
                camposRequeridos.forEach(id => {
                    const elemento = document.getElementById(id);
                    if (elemento) {
                        const esValido = validarCampo(elemento);
                        if (!esValido) formValido = false;
                    }
                });
                
                // Validar contraseña solo en modo creación o si se está cambiando
                const esCreacion = document.getElementById('modal-titulo').textContent.includes('Crear');
                const password = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                
                if (esCreacion || (password && password.value)) {
                    if (password) {
                        const esValido = validarCampo(password);
                        if (!esValido) formValido = false;
                    }
                    
                    if (passwordConfirmation) {
                        const esValido = validarCampo(passwordConfirmation);
                        if (!esValido) formValido = false;
                    }
                }
                
                // Validar campos opcionales que tienen valor
                const camposOpcionales = ['telefono', 'ciudad', 'provincia', 'sitio_web', 'latitud', 'longitud', 'descripcion', 'fecha_nacimiento'];
                camposOpcionales.forEach(id => {
                    const elemento = document.getElementById(id);
                    if (elemento && elemento.value) {
                        const esValido = validarCampo(elemento);
                        if (!esValido) formValido = false;
                    }
                });
                
                // Validar campo de imagen si hay un archivo seleccionado
                const imagen = document.getElementById('imagen');
                if (imagen && imagen.files.length > 0) {
                    const esValido = validarCampo(imagen);
                    if (!esValido) formValido = false;
                }
                
                // Si todo es válido, permitir el envío
                if (formValido) {
                    console.log('Formulario válido, enviando...');
                    // Restaurar el comportamiento normal del formulario
                    e.target.removeEventListener(e.type, arguments.callee);
                    e.target.submit();
                } else {
                    console.log('Formulario con errores, corregir antes de enviar');
                    // Mostrar mensaje general de error
                    const formErrors = document.getElementById('form-errors');
                    if (formErrors) {
                        formErrors.classList.remove('hidden');
                    }
                    
                    // Desplazarse al primer error
                    const primerError = document.querySelector('.border-red-500');
                    if (primerError) {
                        primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        primerError.focus();
                    }
                }
            });
        }
    }
    
    // Función para manejar la apertura del modal
    function handleModalOpen() {
        console.log('Modal de empresa detectado, configurando validaciones...');
        setTimeout(() => {
            agregarEventosCampos();
            inicializarFormulario();
        }, 100);
    }
    
    // Detectar clicks en los botones que abren el modal
    document.addEventListener('click', function(e) {
        if (e.target.closest('#btnCrearEmpresa') || e.target.closest('.btn-editar')) {
            console.log('Botón de empresa clickeado, preparando validación');
            handleModalOpen();
        }
    });
    
    // Inicializar eventos para formularios ya visibles
    inicializarFormulario();
    agregarEventosCampos();
}); 