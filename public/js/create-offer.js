// Asegurarnos de que el script solo se ejecute una vez
const initializeForm = () => {
    // Verificar si estamos en la página correcta
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    const tituloInput = document.getElementById('titulo');
    const descripcionInput = document.getElementById('descripcion');

    // Si no encontramos los elementos necesarios, salir
    if (!categoriaSelect || !subcategoriaSelect) {
        console.log('Elementos de formulario no encontrados, no inicializando');
        return;
    }

    console.log('Inicializando formulario de ofertas con protección anti-duplicados');

    // PROTECCIÓN AVANZADA CONTRA DUPLICADOS
    // Verificar si ya se ha enviado una oferta recientemente
    const formSubmittedTimestamp = localStorage.getItem('formSubmittedTimestamp');
    const currentTime = Date.now();
    const timeDifference = formSubmittedTimestamp ? currentTime - parseInt(formSubmittedTimestamp) : null;
    const ONE_MINUTE = 60 * 1000;

    // Crear un identificador único para esta sesión
    const sessionId = Math.random().toString(36).substring(2, 15);
    console.log(`ID de sesión único para prevenir duplicados: ${sessionId}`);

    // Registrar en localStorage todas las ofertas enviadas en las últimas 24 horas
    const ofertasEnviadas = JSON.parse(localStorage.getItem('ofertasEnviadas') || '[]');
    const VEINTICUATRO_HORAS = 24 * 60 * 60 * 1000;

    // Limpiar ofertas antiguas (más de 24 horas)
    const ofertasRecientes = ofertasEnviadas.filter(oferta => {
        return currentTime - oferta.timestamp < VEINTICUATRO_HORAS;
    });

    // Almacenar las ofertas recientes filtradas
    localStorage.setItem('ofertasEnviadas', JSON.stringify(ofertasRecientes));
    console.log(`Ofertas recientes en localStorage: ${ofertasRecientes.length}`);

    // Si se envió un formulario hace menos de 1 minuto, mostrar advertencia y bloquear
    if (formSubmittedTimestamp && timeDifference && timeDifference < ONE_MINUTE) {
        console.log('🚫 Formulario enviado hace menos de 1 minuto, bloqueando envíos', {
            timeDifference: Math.round(timeDifference / 1000) + ' segundos'
        });

        // Crear aviso visual de bloqueo
        const form = document.querySelector('form');
        if (form && !document.querySelector('.bg-red-100')) {
            const infoElement = document.createElement('div');
            infoElement.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4';
            infoElement.innerHTML = `
                <p class="font-bold">⛔ ENVÍO BLOQUEADO</p>
                <p>Ya has enviado un formulario hace menos de 1 minuto. Por favor, espera antes de intentarlo nuevamente.</p>
                <p class="text-xs mt-2">Tiempo restante: <span id="timer">60</span> segundos</p>
            `;
            form.parentNode.insertBefore(infoElement, form);

            // Deshabilitar el formulario
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Actualizar el contador
            const timerElement = document.getElementById('timer');
            if (timerElement) {
                const secondsLeft = Math.ceil((ONE_MINUTE - timeDifference) / 1000);
                timerElement.textContent = secondsLeft;

                const timerInterval = setInterval(() => {
                    const currentValue = parseInt(timerElement.textContent);
                    if (currentValue <= 1) {
                        clearInterval(timerInterval);
                        location.reload(); // Recargar la página cuando termine el tiempo
                    } else {
                        timerElement.textContent = currentValue - 1;
                    }
                }, 1000);
            }
        }
    } else if (formSubmittedTimestamp) {
        // Si pasó más de 1 minuto desde el último envío, limpiar el storage
        localStorage.removeItem('formSubmittedTimestamp');
        console.log('Formulario enviado hace más de 1 minuto, permitiendo nuevos envíos');
    }

    // VERIFICACIÓN DE DUPLICADOS EN TIEMPO REAL
    // Verificar si el título o descripción ya se ha enviado anteriormente
    if (tituloInput && descripcionInput) {
        const verificarDuplicado = () => {
            const titulo = tituloInput.value.trim();
            const descripcion = descripcionInput.value.trim();

            if (titulo.length < 5 || descripcion.length < 10) return;

            // Verificar contra ofertas locales almacenadas
            const duplicado = ofertasRecientes.find(oferta => {
                // Verificar si el título es igual o muy similar
                const tituloIgual = oferta.titulo === titulo;
                // Verificar si la descripción es igual
                const descripcionIgual = oferta.descripcion === descripcion;
                return tituloIgual || descripcionIgual;
            });

            const submitButton = document.querySelector('button[type="submit"]');
            const warningElement = document.getElementById('duplicado-warning');

            if (duplicado) {
                console.log('⚠️ Posible duplicado detectado localmente', duplicado);

                if (!warningElement) {
                    const warning = document.createElement('div');
                    warning.id = 'duplicado-warning';
                    warning.className = 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4';
                    warning.innerHTML = `
                        <p class="font-bold">⚠️ Posible duplicado detectado</p>
                        <p>Ya has enviado una oferta similar hace poco tiempo. Cámbiala significativamente para evitar duplicados.</p>
                        <p class="text-xs mt-2">${new Date(duplicado.timestamp).toLocaleString()}</p>
                    `;

                    if (tituloInput.parentNode.parentNode) {
                        tituloInput.parentNode.parentNode.insertBefore(warning, tituloInput.parentNode);
                    }
                }

                // Advertir pero no bloquear
                if (submitButton) {
                    submitButton.classList.add('bg-yellow-500');
                    submitButton.classList.remove('bg-blue-500');
                }
            } else {
                // Quitar advertencia si existe
                if (warningElement) {
                    warningElement.remove();
                }

                // Restaurar botón
                if (submitButton) {
                    submitButton.classList.remove('bg-yellow-500');
                    submitButton.classList.add('bg-blue-500');
                }
            }
        };

        // Verificar al escribir (con debounce)
        let debounceTimer;
        tituloInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(verificarDuplicado, 500);
        });

        descripcionInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(verificarDuplicado, 500);
        });

        // Verificar al cargar
        verificarDuplicado();
    }

    // Prevenir múltiples envíos del formulario
    const form = document.querySelector('form');

    // Prevenir submits múltiples en el mismo segundo
    let lastSubmitTime = 0;
    const SUBMIT_THROTTLE = 2000; // 2 segundos mínimo entre envíos

    if (form) {
        console.log('Adjuntando manejador de envío al formulario con protección anti-duplicados');

        // Eliminar event listeners existentes clonando el elemento
        const newForm = form.cloneNode(true);
        form.parentNode.replaceChild(newForm, form);

        // Contador global de solicitudes en progreso
        let requestInProgress = false;

        newForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Siempre prevenir el envío por defecto

            const now = Date.now();
            const formId = now;
            console.log(`[${formId}] Iniciando procesamiento de envío de formulario`);

            // MÚLTIPLES VERIFICACIONES DE SEGURIDAD

            // 1. Verificar si el formulario ya fue enviado en el último minuto
            if (localStorage.getItem('formSubmittedTimestamp') &&
                now - parseInt(localStorage.getItem('formSubmittedTimestamp')) < ONE_MINUTE) {
                console.log(`[${formId}] 🚫 Formulario ya fue enviado recientemente, bloqueando`);
                alert('DUPLICADO: Por favor, espera al menos 1 minuto antes de enviar otro formulario.');
                return false;
            }

            // 2. Verificar si pasó suficiente tiempo desde el último intento de envío
            if (now - lastSubmitTime < SUBMIT_THROTTLE) {
                console.log(`[${formId}] 🚫 Demasiados intentos rápidos, bloqueando`);
                alert('Estás enviando demasiado rápido. Espera unos segundos.');
                return false;
            }

            // 3. Verificar si ya hay una solicitud en progreso
            if (requestInProgress) {
                console.log(`[${formId}] 🚫 Ya hay una solicitud en progreso, bloqueando`);
                return false;
            }

            // 4. Verificar si el formulario ya tiene la clase de procesamiento
            if (this.classList.contains('submitting')) {
                console.log(`[${formId}] 🚫 Formulario ya está siendo enviado (clase), bloqueando`);
                return false;
            }

            // 5. Verificar duplicados de contenido
            const tituloValue = tituloInput ? tituloInput.value.trim() : '';
            const descripcionValue = descripcionInput ? descripcionInput.value.trim() : '';

            // Verificar contra ofertas locales almacenadas
            const duplicadoLocal = ofertasRecientes.find(oferta => {
                return oferta.titulo === tituloValue || oferta.descripcion === descripcionValue;
            });

            if (duplicadoLocal) {
                console.log(`[${formId}] 🚫 Duplicado local detectado, bloqueando`, duplicadoLocal);
                alert('DUPLICADO DETECTADO: Ya has enviado una oferta similar hace poco tiempo. ' +
                      'Cambia el título y descripción significativamente.');
                return false;
            }

            // Marcar el formulario como en procesamiento
            requestInProgress = true;
            lastSubmitTime = now;
            this.classList.add('submitting');

            // Deshabilitar el botón de envío
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.textContent;
                submitButton.disabled = true;
                submitButton.textContent = 'Enviando...';
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');

                // Si por alguna razón no se procesa correctamente, restaurar después de 15 segundos
                setTimeout(() => {
                    if (requestInProgress) {
                        console.log(`[${formId}] Restaurando estado del formulario por timeout`);
                        requestInProgress = false;
                        this.classList.remove('submitting');

                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                }, 15000);
            }

            // Guardar timestamp del envío en localStorage
            localStorage.setItem('formSubmittedTimestamp', now.toString());
            console.log(`[${formId}] Marcado formulario como enviado en localStorage`);

            // Preparar los datos del formulario
            const formData = new FormData(this);

            // Mostrar al usuario que se está procesando
            const processingNotice = document.createElement('div');
            processingNotice.className = 'fixed top-0 left-0 w-full bg-blue-100 text-blue-800 p-4 text-center z-50';
            processingNotice.innerHTML = '<p>Procesando tu solicitud. Por favor, espera...</p>';
            document.body.appendChild(processingNotice);

            // Enviar la solicitud con fetch para tener más control
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-Session-ID': sessionId // ID de sesión único para detectar duplicados
                }
            })
            .then(response => {
                return response.json().then(data => {
                    return {
                        status: response.status,
                        ok: response.ok,
                        data: data
                    };
                });
            })
            .then(result => {
                console.log(`[${formId}] Respuesta recibida:`, result);

                // Eliminar el aviso de procesamiento
                processingNotice.remove();

                if (result.ok) {
                    // Éxito: registrar la oferta en localStorage para evitar duplicados futuros
                    ofertasRecientes.push({
                        id: result.data.publication?.id || 'temp-' + Date.now(),
                        titulo: tituloValue,
                        descripcion: descripcionValue,
                        timestamp: Date.now()
                    });
                    localStorage.setItem('ofertasEnviadas', JSON.stringify(ofertasRecientes));

                    // Mostrar mensaje y redirigir
                    alert('✅ Oferta creada exitosamente');
                    window.location.href = '/empresa/dashboard';
                } else {
                    // Error: Mostrar mensaje y restaurar el formulario
                    let errorMessage = 'Error al crear la oferta';

                    if (result.data && result.data.message) {
                        errorMessage = result.data.message;
                    }

                    if (result.data && result.data.duplicate) {
                        // Si es un duplicado, mostrar un error más visible
                        const dupError = document.createElement('div');
                        dupError.className = 'mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4';
                        dupError.innerHTML = `<p class="font-bold">⛔ DUPLICADO DETECTADO</p><p>${errorMessage}</p>`;
                        this.parentNode.insertBefore(dupError, this);

                        // Registrar la oferta como duplicada en localStorage
                        ofertasRecientes.push({
                            id: 'rechazado-' + Date.now(),
                            titulo: tituloValue,
                            descripcion: descripcionValue,
                            timestamp: Date.now(),
                            rechazado: true
                        });
                        localStorage.setItem('ofertasEnviadas', JSON.stringify(ofertasRecientes));
                    } else {
                        alert(errorMessage);
                    }

                    // Restaurar el estado del formulario
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = originalText;
                        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }

                // Restaurar el estado para permitir futuros envíos
                requestInProgress = false;
                this.classList.remove('submitting');
            })
            .catch(error => {
                console.error(`[${formId}] Error en la petición:`, error);
                processingNotice.remove();
                alert('Error al comunicarse con el servidor. Por favor, intenta de nuevo.');

                // Restaurar el estado del formulario
                requestInProgress = false;
                this.classList.remove('submitting');

                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });

            return false; // Impedir el envío normal del formulario
        });
    }

    // Función para limpiar y establecer una opción por defecto en el select
    const resetSelect = (select, defaultText) => {
        if (!select) return;

        select.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = defaultText;
        select.appendChild(defaultOption);
    };

    // Función para cargar subcategorías
    const loadSubcategorias = async (categoriaId) => {
        try {
            if (!categoriaId) {
                resetSelect(subcategoriaSelect, 'Primero selecciona una categoría');
                return;
            }

            // Resetear el select de subcategorías
            resetSelect(subcategoriaSelect, 'Cargando subcategorías...');

            // Generar un identificador único para esta solicitud para depuración
            const requestId = Date.now();
            console.log(`[${requestId}] Cargando subcategorías para categoría ${categoriaId}`);

            // Realizar la petición
            const response = await fetch(`/empresa/get-subcategorias/${categoriaId}`);

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();
            console.log(`[${requestId}] Respuesta recibida:`, data);

            // Verificar si hay un error en la respuesta
            if (data.error) {
                throw new Error(data.message || 'Error al cargar subcategorías');
            }

            // Resetear el select antes de añadir nuevas opciones
            resetSelect(subcategoriaSelect, 'Selecciona una subcategoría');

            // Usar un Set para mantener track de IDs únicos
            const addedIds = new Set();

            // Añadir las subcategorías únicas
            const subcategorias = data.data || [];
            subcategorias.forEach(subcategoria => {
                if (!addedIds.has(subcategoria.id)) {
                    addedIds.add(subcategoria.id);
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre_subcategoria;
                    subcategoriaSelect.appendChild(option);
                }
            });

            console.log(`[${requestId}] Agregadas ${addedIds.size} subcategorías únicas al select`);

            if (subcategorias.length === 0) {
                resetSelect(subcategoriaSelect, 'No hay subcategorías disponibles');
            }

        } catch (error) {
            console.error('Error al cargar subcategorías:', error);
            resetSelect(subcategoriaSelect, 'Error al cargar subcategorías');
        }
    };

    // Añadir event listener para cambios en el select de categoría
    if (categoriaSelect) {
        console.log('Configurando listener de cambio de categoría');
        // Eliminar event listeners existentes clonando el elemento
        const newCategoriaSelect = categoriaSelect.cloneNode(true);
        if (categoriaSelect.parentNode) {
            categoriaSelect.parentNode.replaceChild(newCategoriaSelect, categoriaSelect);

            // Añadir el nuevo event listener
            newCategoriaSelect.addEventListener('change', (e) => {
                loadSubcategorias(e.target.value);
            });

            // Si hay una categoría seleccionada al cargar la página
            if (newCategoriaSelect.value) {
                loadSubcategorias(newCategoriaSelect.value);
            }
        }
    }
};

// Asegurarnos de que el script solo se ejecute una vez cuando el DOM esté listo
try {
    console.log('Inicializando create-offer.js');

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM cargado, inicializando formulario');
            initializeForm();
        });
    } else {
        console.log('DOM ya cargado, inicializando formulario inmediatamente');
        initializeForm();
    }
} catch (error) {
    console.error('Error en la inicialización del formulario:', error);
}

// Función para abrir el modal
window.openModal = function() {
    const modalNuevaOferta = document.getElementById('modalNuevaOferta');
    if (modalNuevaOferta) {
        modalNuevaOferta.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Animación de entrada
        setTimeout(() => {
            const modalContent = modalNuevaOferta.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.add('animate-fadeIn');
            }
        }, 10);

        // Focus primer input
        setTimeout(() => {
            const firstInput = modalNuevaOferta.querySelector('input, select, textarea');
            if (firstInput) firstInput.focus();
        }, 300);
    }
};

// Función para cerrar el modal
window.closeModal = function() {
    const modalNuevaOferta = document.getElementById('modalNuevaOferta');
    if (modalNuevaOferta) {
        const modalContent = modalNuevaOferta.querySelector('.relative');
        if (modalContent) {
            modalContent.classList.remove('animate-fadeIn');
            modalContent.classList.add('animate-fadeOut');
        }

        setTimeout(() => {
            modalNuevaOferta.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            if (modalContent) {
                modalContent.classList.remove('animate-fadeOut');
            }

            const formNuevaOferta = document.getElementById('formNuevaOferta');
            if (formNuevaOferta) {
                formNuevaOferta.reset();
            }
        }, 200);
    }
};

// Función para cargar subcategorías
window.cargarSubcategorias = function() {
    const categoriaId = document.getElementById('categoria_id');
    const subcategoriasSelect = document.getElementById('subcategoria_id');

    if (!categoriaId || !subcategoriasSelect) return;

    if (!categoriaId.value) {
        subcategoriasSelect.innerHTML = '<option value="">Primero seleccione una categoría</option>';
        return;
    }

    subcategoriasSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
    subcategoriasSelect.disabled = true;

    fetch(`/empresa/get-subcategorias/${categoriaId.value}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        subcategoriasSelect.innerHTML = '<option value="">Seleccionar subcategoría</option>';

        if (data.data && data.data.length > 0) {
            data.data.forEach(subcategoria => {
                const option = document.createElement('option');
                option.value = subcategoria.id;
                option.textContent = subcategoria.nombre_subcategoria;
                subcategoriasSelect.appendChild(option);
            });
        } else {
            subcategoriasSelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        subcategoriasSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
    })
    .finally(() => {
        subcategoriasSelect.disabled = false;
    });
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Manejar envío del formulario
    const formNuevaOferta = document.getElementById('formNuevaOferta');
    if (formNuevaOferta) {
        formNuevaOferta.addEventListener('submit', function(e) {
            e.preventDefault();

            // Deshabilitar el botón de submit
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <div class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Publicando oferta...
                    </div>
                `;
            }

            const formData = new FormData(this);

            fetch('/empresa/ofertas', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar el modal
                    closeModal();

                    // Mostrar alerta de éxito
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message || 'Oferta creada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        confirmButtonColor: '#7E22CE'
                    });

                    // Actualizar la tabla de ofertas si existe la función
                    if (typeof updateOffersTable === 'function') {
                        updateOffersTable();
                    }

                    // Limpiar el formulario
                    formNuevaOferta.reset();
                } else {
                    throw new Error(data.message || 'Error al crear la oferta');
                }
            })
            .catch(error => {
                Swal.fire({
                    title: '¡Error!',
                    text: error.message || 'Ha ocurrido un error al publicar la oferta',
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#7E22CE'
                });
            })
            .finally(() => {
                // Restaurar el botón de submit
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = `
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Publicar oferta
                        </div>
                    `;
                }
            });
        });
    }

    // Cerrar modal al hacer clic fuera
    const modalNuevaOferta = document.getElementById('modalNuevaOferta');
    if (modalNuevaOferta) {
        modalNuevaOferta.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    }

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalNuevaOferta && !modalNuevaOferta.classList.contains('hidden')) {
            closeModal();
        }
    });
});
