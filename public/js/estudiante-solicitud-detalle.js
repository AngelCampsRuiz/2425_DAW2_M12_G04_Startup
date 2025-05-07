/**
 * Script para manejar los detalles de solicitudes de estudiantes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const detalleContainer = document.getElementById('solicitud-detalle-container');
    const detalleContent = document.getElementById('solicitud-detalle-content');
    const loadingIndicator = document.getElementById('loading-indicator-detalle');
    
    /**
     * Carga el detalle de una solicitud específica
     */
    window.cargarDetalleSolicitud = function(solicitudId) {
        // Mostrar indicador de carga
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        
        // Mostrar contenedor de detalles
        if (detalleContainer) detalleContainer.classList.remove('hidden');
        
        // Ocultar contenedor de listado
        const solicitudesContainer = document.getElementById('solicitudes-container');
        if (solicitudesContainer) solicitudesContainer.classList.add('hidden');
        
        // Obtener el token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Realizar petición AJAX
        fetch(`${window.location.origin}/estudiante/api/solicitudes/${solicitudId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Generar HTML del detalle
                if (detalleContent) {
                    detalleContent.innerHTML = generarDetalleHTML(data.solicitud);
                    initDetalleButtons(data.solicitud);
                }
            } else {
                throw new Error(data.message || 'Error al cargar el detalle de la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Mostrar mensaje de error
            if (detalleContent) {
                detalleContent.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-red-500">Error al cargar el detalle de la solicitud. Inténtalo de nuevo más tarde.</p>
                        <button id="volver-solicitudes-btn" class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver al listado
                        </button>
                    </div>
                `;
                
                document.getElementById('volver-solicitudes-btn').addEventListener('click', volverAlListado);
            }
        })
        .finally(() => {
            // Ocultar indicador de carga
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
        });
        
        // Cambiar la URL para permitir compartir el enlace
        window.history.pushState({}, 'Detalle de Solicitud', `${window.location.pathname}?tab=solicitudes&solicitud_id=${solicitudId}`);
    };
    
    /**
     * Generar HTML para mostrar el detalle de la solicitud
     */
    function generarDetalleHTML(solicitud) {
        // Definir clases para el badge de estado
        let badgeClass = '';
        switch(solicitud.estado) {
            case 'pendiente':
                badgeClass = 'bg-yellow-100 text-yellow-800';
                break;
            case 'aprobada':
                badgeClass = 'bg-green-100 text-green-800';
                break;
            case 'rechazada':
                badgeClass = 'bg-red-100 text-red-800';
                break;
            default:
                badgeClass = 'bg-gray-100 text-gray-800';
        }
        
        // Formatear fechas
        const fechaCreacion = new Date(solicitud.created_at).toLocaleDateString('es-ES', { 
            day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' 
        });
        
        let fechaRespuesta = solicitud.fecha_respuesta ? new Date(solicitud.fecha_respuesta).toLocaleDateString('es-ES', { 
            day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' 
        }) : null;
        
        // Generar el HTML
        let html = `
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Detalle de Solicitud</h1>
                <button id="volver-solicitudes-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </button>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Cabecera -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 rounded-full object-cover" 
                                    src="${window.location.origin}/public/profile_images/${solicitud.institucion?.imagen || 'default.png'}" 
                                    alt="${solicitud.institucion?.nombre || 'Institución'}">
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-medium text-gray-900">${solicitud.institucion?.nombre || 'Institución'}</h2>
                                <div class="mt-1 flex items-center">
                                    <span class="text-sm text-gray-500">Solicitud enviada el ${fechaCreacion}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full ${badgeClass}">
                                ${solicitud.estado.charAt(0).toUpperCase() + solicitud.estado.slice(1)}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Contenido -->
                <div class="p-6 space-y-6">
                    <!-- Detalles de la solicitud -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Detalles de la Solicitud</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Estado</p>
                                <p class="mt-1 text-sm text-gray-900">${solicitud.estado.charAt(0).toUpperCase() + solicitud.estado.slice(1)}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Fecha de la solicitud</p>
                                <p class="mt-1 text-sm text-gray-900">${fechaCreacion}</p>
                            </div>
        `;
        
        // Agregar fecha de respuesta si existe
        if (fechaRespuesta) {
            html += `
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Fecha de respuesta</p>
                    <p class="mt-1 text-sm text-gray-900">${fechaRespuesta}</p>
                </div>
            `;
        }
        
        // Agregar clase si existe
        if (solicitud.clase) {
            html += `
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Clase asignada</p>
                    <p class="mt-1 text-sm text-gray-900">${solicitud.clase.nombre}</p>
                </div>
            `;
        }
        
        html += `
                        </div>
                    </div>
        `;
        
        // Agregar mensaje de la solicitud si existe
        if (solicitud.mensaje) {
            html += `
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Mensaje de la Solicitud</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">${solicitud.mensaje}</p>
                    </div>
                </div>
            `;
        }
        
        // Agregar respuesta de la institución si existe
        if (solicitud.respuesta) {
            html += `
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Respuesta de la Institución</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">${solicitud.respuesta}</p>
                    </div>
                </div>
            `;
        }
        
        // Agregar información de la clase si está asignada
        if (solicitud.clase_asignada && solicitud.clase) {
            html += `
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Información de la Clase</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nombre de la clase</p>
                                <p class="mt-1 text-sm text-gray-900">${solicitud.clase.nombre}</p>
                            </div>
            `;
            
            if (solicitud.clase.departamento) {
                html += `
                    <div>
                        <p class="text-sm font-medium text-gray-500">Departamento</p>
                        <p class="mt-1 text-sm text-gray-900">${solicitud.clase.departamento.nombre}</p>
                    </div>
                `;
            }
            
            if (solicitud.clase.docente && solicitud.clase.docente.user) {
                html += `
                    <div>
                        <p class="text-sm font-medium text-gray-500">Docente</p>
                        <p class="mt-1 text-sm text-gray-900">${solicitud.clase.docente.user.nombre}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email del docente</p>
                        <p class="mt-1 text-sm text-gray-900">${solicitud.clase.docente.user.email}</p>
                    </div>
                `;
            }
            
            html += `
                        </div>
                    </div>
                </div>
            `;
        }
        
        html += `
                </div>
                
                <!-- Acciones -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-end">
        `;
        
        // Agregar botón de cancelar si está pendiente
        if (solicitud.estado === 'pendiente') {
            html += `
                <button id="cancelar-solicitud-btn" data-id="${solicitud.id}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
                    Cancelar Solicitud
                </button>
            `;
        }
        
        html += `
                    </div>
                </div>
            </div>
        `;
        
        return html;
    }
    
    /**
     * Inicializar los botones de la página de detalle
     */
    function initDetalleButtons(solicitud) {
        // Botón volver al listado
        const volverBtn = document.getElementById('volver-solicitudes-btn');
        if (volverBtn) {
            volverBtn.addEventListener('click', volverAlListado);
        }
        
        // Botón cancelar solicitud
        const cancelarBtn = document.getElementById('cancelar-solicitud-btn');
        if (cancelarBtn && solicitud.estado === 'pendiente') {
            cancelarBtn.addEventListener('click', function() {
                const solicitudId = this.dataset.id;
                
                if (confirm('¿Estás seguro de que deseas cancelar esta solicitud? Esta acción no se puede deshacer.')) {
                    // Obtener el token CSRF
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Realizar petición AJAX
                    fetch(`${window.location.origin}/estudiante/api/solicitudes/${solicitudId}/cancelar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la petición');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            mostrarMensaje('Solicitud cancelada correctamente', 'success');
                            
                            // Volver al listado después de 1 segundo
                            setTimeout(() => {
                                volverAlListado();
                            }, 1000);
                        } else {
                            throw new Error(data.message || 'Error al cancelar la solicitud');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Mostrar mensaje de error
                        mostrarMensaje(error.message || 'Error al cancelar la solicitud', 'error');
                    });
                }
            });
        }
    }
    
    /**
     * Volver al listado de solicitudes
     */
    function volverAlListado() {
        // Ocultar contenedor de detalles
        if (detalleContainer) detalleContainer.classList.add('hidden');
        
        // Mostrar contenedor de listado
        const solicitudesContainer = document.getElementById('solicitudes-container');
        if (solicitudesContainer) solicitudesContainer.classList.remove('hidden');
        
        // Cambiar la URL
        window.history.pushState({}, 'Mis Solicitudes', `${window.location.pathname}?tab=solicitudes`);
    }
    
    /**
     * Mostrar un mensaje temporal en la pantalla
     */
    function mostrarMensaje(mensaje, tipo) {
        // Crear elemento de mensaje
        const mensajeElement = document.createElement('div');
        mensajeElement.className = `fixed bottom-5 right-5 px-6 py-3 rounded shadow-lg z-50 ${tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
        mensajeElement.innerHTML = mensaje;
        
        // Agregar elemento al DOM
        document.body.appendChild(mensajeElement);
        
        // Eliminar mensaje después de 3 segundos
        setTimeout(() => {
            mensajeElement.remove();
        }, 3000);
    }
    
    // Verificar si debemos cargar un detalle específico al iniciar
    const urlParams = new URLSearchParams(window.location.search);
    const solicitudId = urlParams.get('solicitud_id');
    
    if (solicitudId && urlParams.get('tab') === 'solicitudes') {
        cargarDetalleSolicitud(solicitudId);
    }
}); 