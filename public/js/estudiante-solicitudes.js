/**
 * Script para manejar las solicitudes de estudiantes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const loadingIndicator = document.getElementById('loading-indicator');
    const solicitudesDataContainer = document.getElementById('solicitudes-data-container');
    const solicitudesTable = document.getElementById('solicitudes-table');
    const noSolicitudes = document.getElementById('no-solicitudes');
    const estadoLinks = document.querySelectorAll('.estado-link');
    
    // Contadores de estadísticas
    const statsTotal = document.getElementById('stats-total');
    const statsPendientes = document.getElementById('stats-pendientes');
    const statsAprobadas = document.getElementById('stats-aprobadas');
    const statsRechazadas = document.getElementById('stats-rechazadas');
    
    // Estado actual del filtro
    let estadoActual = 'todos';
    
    /**
     * Carga las solicitudes mediante AJAX
     */
    function cargarSolicitudes(estado = 'todos') {
        // Mostrar indicador de carga
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (noSolicitudes) noSolicitudes.classList.add('hidden');
        if (solicitudesTable) solicitudesTable.classList.add('hidden');
        if (solicitudesDataContainer) solicitudesDataContainer.innerHTML = '';
        
        // Actualizar el estado activo en los enlaces
        actualizarEstadoActivo(estado);
        
        // Realizar petición AJAX
        fetch(`/estudiante/api/solicitudes?estado=${estado}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Ocultar indicador de carga
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            
            // Actualizar estadísticas
            actualizarEstadisticas(data.stats);
            
            // Verificar si hay solicitudes
            if (data.solicitudes && data.solicitudes.length > 0) {
                if (solicitudesTable) solicitudesTable.classList.remove('hidden');
                if (solicitudesDataContainer) {
                    // Generar HTML de la tabla
                    solicitudesDataContainer.innerHTML = renderizarTablaSolicitudes(data.solicitudes);
                    
                    // Agregar eventos a los botones de cancelar
                    document.querySelectorAll('.cancelar-solicitud').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const solicitudId = this.getAttribute('data-id');
                            cancelarSolicitud(solicitudId);
                        });
                    });
                }
            } else {
                if (noSolicitudes) noSolicitudes.classList.remove('hidden');
                if (solicitudesTable) solicitudesTable.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error al cargar solicitudes:', error);
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            if (solicitudesDataContainer) solicitudesDataContainer.innerHTML = '<div class="text-center py-4 text-red-500">Error al cargar solicitudes. Intenta de nuevo.</div>';
        });
    }
    
    /**
     * Renderiza la tabla de solicitudes
     */
    function renderizarTablaSolicitudes(solicitudes) {
        let html = `
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publicación</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
        `;
        
        solicitudes.forEach(solicitud => {
            // Formatear fecha
            const fecha = new Date(solicitud.created_at);
            const fechaFormateada = fecha.toLocaleDateString('es-ES');
            const horaFormateada = fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});
            
            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" 
                                    src="${solicitud.publicacion?.empresa?.user?.imagen ? 
                                        '/public/profile_images/' + solicitud.publicacion.empresa.user.imagen : 
                                        '/img/company-default.png'}" 
                                    alt="Logo empresa">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    ${solicitud.publicacion?.empresa?.user?.nombre || 'Empresa'}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${solicitud.publicacion?.titulo || 'Sin título'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${fechaFormateada}</div>
                        <div class="text-sm text-gray-500">${horaFormateada}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${getEstadoBadge(solicitud.estado)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/estudiante/solicitudes/${solicitud.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Ver detalles
                        </a>
                        ${solicitud.estado === 'pendiente' ? 
                            `<button data-id="${solicitud.id}" class="cancelar-solicitud text-red-600 hover:text-red-900">
                                Cancelar
                            </button>` : ''}
                    </td>
                </tr>
            `;
        });
        
        html += `
                </tbody>
            </table>
        `;
        
        return html;
    }
    
    /**
     * Genera el HTML para el badge de estado
     */
    function getEstadoBadge(estado) {
        switch (estado) {
            case 'pendiente':
                return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>';
            case 'aceptada': // Estado en DB
                return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aceptada</span>';
            case 'rechazada':
                return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>';
            default:
                return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">${estado.charAt(0).toUpperCase() + estado.slice(1)}</span>`;
        }
    }
    
    /**
     * Actualiza el estado activo en los enlaces de filtro
     */
    function actualizarEstadoActivo(estado) {
        estadoActual = estado;
        
        // Eliminar clase activa de todos los enlaces
        estadoLinks.forEach(link => {
            link.classList.remove('bg-purple-100', 'text-[#5e0490]');
            link.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });
        
        // Agregar clase activa al enlace seleccionado
        const linkActivo = document.querySelector(`.estado-link[data-estado="${estado}"]`);
        if (linkActivo) {
            linkActivo.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            linkActivo.classList.add('bg-purple-100', 'text-[#5e0490]');
        }
    }
    
    /**
     * Actualiza los contadores de estadísticas
     */
    function actualizarEstadisticas(stats) {
        if (statsTotal) statsTotal.textContent = stats.total;
        if (statsPendientes) statsPendientes.textContent = stats.pendientes;
        if (statsAprobadas) statsAprobadas.textContent = stats.aprobadas;
        if (statsRechazadas) statsRechazadas.textContent = stats.rechazadas;
    }
    
    /**
     * Cancela una solicitud mediante AJAX
     */
    function cancelarSolicitud(solicitudId) {
        if (!confirm('¿Estás seguro de que deseas cancelar esta solicitud? Esta acción no se puede deshacer.')) {
            return;
        }
        
        fetch(`/estudiante/api/solicitudes/${solicitudId}/cancelar`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar las solicitudes con el filtro actual
                cargarSolicitudes(estadoActual);
                
                // Mostrar mensaje de éxito
                mostrarNotificacion('Solicitud cancelada correctamente', 'success');
            } else {
                mostrarNotificacion(data.message || 'Error al cancelar la solicitud', 'error');
            }
        })
        .catch(error => {
            console.error('Error al cancelar solicitud:', error);
            mostrarNotificacion('Error al cancelar la solicitud', 'error');
        });
    }
    
    /**
     * Muestra una notificación flotante
     */
    function mostrarNotificacion(mensaje, tipo = 'success') {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-opacity duration-500 ${tipo === 'success' ? 'bg-green-100 border-l-4 border-green-500 text-green-700' : 'bg-red-100 border-l-4 border-red-500 text-red-700'}`;
        notificacion.innerHTML = mensaje;
        
        // Agregar al DOM
        document.body.appendChild(notificacion);
        
        // Eliminar después de 3 segundos
        setTimeout(() => {
            notificacion.classList.add('opacity-0');
            setTimeout(() => {
                document.body.removeChild(notificacion);
            }, 500);
        }, 3000);
    }
    
    // Agregar eventos a los enlaces de filtro
    estadoLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const estado = this.getAttribute('data-estado');
            cargarSolicitudes(estado);
        });
    });
    
    // Cargar todas las solicitudes al cargar la página
    cargarSolicitudes();
}); 