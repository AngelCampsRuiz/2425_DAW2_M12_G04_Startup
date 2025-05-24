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

            // Mostrar error con SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al cargar tus solicitudes. Intenta de nuevo.',
                confirmButtonColor: '#5e0490',
                confirmButtonText: 'Entendido'
            });

            if (solicitudesDataContainer) {
                solicitudesDataContainer.innerHTML = '<div class="text-center py-8 text-red-500 flex flex-col items-center"><svg class="w-12 h-12 mb-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>Error al cargar solicitudes. Intenta de nuevo.</div>';
            }
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publicación</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
        `;

        solicitudes.forEach((solicitud, index) => {
            // Formatear fecha
            const fecha = new Date(solicitud.created_at);
            const fechaFormateada = fecha.toLocaleDateString('es-ES');
            const horaFormateada = fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});

            // Alternar colores de fila para mejor legibilidad
            const rowClass = index % 2 === 0 ? '' : 'bg-gray-50';

            html += `
                <tr class="${rowClass} hover:bg-purple-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 relative">
                                <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow"
                                    src="${solicitud.publicacion?.empresa?.user?.imagen ?
                                        '/profile_images/' + solicitud.publicacion.empresa.user.imagen :
                                        '/img/company-default.png'}"
                                    alt="Logo empresa">
                                <div class="absolute bottom-0 right-0 rounded-full bg-white p-0.5 shadow">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    ${solicitud.publicacion?.empresa?.user?.nombre || 'Empresa'}
                                </div>
                                <div class="text-xs text-gray-500">
                                    ${formatTimeSince(solicitud.created_at)}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 mb-1">${solicitud.publicacion?.titulo || 'Sin título'}</div>
                        <div class="text-xs text-gray-500 line-clamp-1">${solicitud.publicacion?.descripcion ? solicitud.publicacion.descripcion.substring(0, 60) + (solicitud.publicacion.descripcion.length > 60 ? '...' : '') : ''}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${fechaFormateada}</div>
                                <div class="text-xs text-gray-500">${horaFormateada}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${getEstadoBadge(solicitud.estado)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3">
                            <a href="/estudiante/solicitudes/${solicitud.id}" class="bg-[#5e0490]/10 hover:bg-[#5e0490]/20 text-[#5e0490] p-2 rounded-lg transition-colors group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span class="sr-only">Ver detalles</span>
                            </a>
                            ${solicitud.estado === 'pendiente' ?
                                `<button data-id="${solicitud.id}" class="cancelar-solicitud bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="sr-only">Cancelar</span>
                                </button>` : ''}
                        </div>
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
                return `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse mr-2"></div>
                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-100 text-yellow-800">
                            Pendiente
                        </span>
                    </div>`;
            case 'aceptada': // Estado en DB
                return `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-green-500 mr-2"></div>
                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                            <svg class="mr-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Aceptada
                        </span>
                    </div>`;
            case 'rechazada':
                return `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-red-500 mr-2"></div>
                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-medium rounded-full bg-red-100 text-red-800">
                            <svg class="mr-1 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Rechazada
                        </span>
                    </div>`;
            default:
                return `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-gray-400 mr-2"></div>
                        <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 text-gray-800">
                            ${estado.charAt(0).toUpperCase() + estado.slice(1)}
                        </span>
                    </div>`;
        }
    }

    /**
     * Formatea el tiempo transcurrido desde una fecha
     */
    function formatTimeSince(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) {
            return interval === 1 ? 'hace 1 año' : `hace ${interval} años`;
        }

        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) {
            return interval === 1 ? 'hace 1 mes' : `hace ${interval} meses`;
        }

        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
            return interval === 1 ? 'hace 1 día' : `hace ${interval} días`;
        }

        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
            return interval === 1 ? 'hace 1 hora' : `hace ${interval} horas`;
        }

        interval = Math.floor(seconds / 60);
        if (interval >= 1) {
            return interval === 1 ? 'hace 1 minuto' : `hace ${interval} minutos`;
        }

        return seconds < 10 ? 'ahora mismo' : `hace ${Math.floor(seconds)} segundos`;
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
        if (statsAprobadas) statsAprobadas.textContent = stats.aceptadas;
        if (statsRechazadas) statsRechazadas.textContent = stats.rechazadas;
    }

    /**
     * Cancela una solicitud mediante AJAX
     */
    function cancelarSolicitud(solicitudId) {
        // SweetAlert2 mejorado con diseño personalizado
        Swal.fire({
            title: '<span class="text-red-600 font-bold">¿Cancelar solicitud?</span>',
            html: `
                <div class="text-center">
                    <div class="mx-auto w-24 h-24 mb-4 text-red-500">
                        <svg class="w-full h-full animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-2">Esta acción no se puede deshacer.</p>
                    <p class="text-gray-600 text-sm">La solicitud será marcada como <span class="font-semibold text-red-600">rechazada</span> y no podrá ser reactivada.</p>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Sí, cancelar solicitud',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>No, mantener solicitud',
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#5e0490',
            background: 'rgba(255, 255, 255, 0.95)',
            backdrop: `
                rgba(0,0,0,0.4)
                url("/img/loading-bg.png")
                left top
                no-repeat
            `,
            showClass: {
                popup: 'animate__animated animate__fadeInDown animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            },
            customClass: {
                title: 'text-xl font-bold',
                htmlContainer: 'py-4',
                confirmButton: 'rounded-xl px-6 py-2.5 font-medium text-white shadow-lg hover:shadow-red-500/30 transition-all duration-200',
                cancelButton: 'rounded-xl px-6 py-2.5 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200',
                icon: 'border-red-500 text-red-500',
                container: 'z-[1060]'
            },
            buttonsStyling: true,
            focusConfirm: false,
            reverseButtons: true,
            focusDeny: false,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar indicador de carga con animación y diseño personalizado
                Swal.fire({
                    title: 'Procesando...',
                    html: `
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 relative">
                                <div class="absolute inset-0 rounded-full border-4 border-gray-200"></div>
                                <div class="absolute inset-0 rounded-full border-4 border-t-[#5e0490] animate-spin"></div>
                            </div>
                            <p class="mt-4 text-[#5e0490]">Cancelando tu solicitud</p>
                            <p class="text-sm text-gray-500 mt-2">Esto solo tomará un momento...</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    background: 'rgba(255, 255, 255, 0.98)',
                    backdrop: `
                        rgba(94, 4, 144, 0.15)
                    `,
                    customClass: {
                        title: 'text-xl font-bold text-[#5e0490]',
                        htmlContainer: 'py-4'
                    }
                });

                // Realizar petición AJAX para cancelar
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

                        // Mostrar mensaje de éxito con animación y diseño personalizado
                        Swal.fire({
                            icon: 'success',
                            title: '<span class="text-green-600">¡Solicitud cancelada!</span>',
                            html: `
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-700">La solicitud ha sido cancelada correctamente.</p>
                                </div>
                            `,
                            showConfirmButton: true,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#5e0490',
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                title: 'text-xl font-bold',
                                htmlContainer: 'py-4',
                                confirmButton: 'rounded-xl px-6 py-2.5 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200',
                                timerProgressBar: 'bg-[#5e0490]'
                            },
                            showClass: {
                                popup: 'animate__animated animate__zoomIn animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__zoomOut animate__faster'
                            }
                        });
                    } else {
                        // Mostrar mensaje de error con diseño personalizado
                        Swal.fire({
                            icon: 'error',
                            title: '<span class="text-red-600">Error</span>',
                            html: `
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-700">${data.message || 'Error al cancelar la solicitud'}</p>
                                </div>
                            `,
                            confirmButtonColor: '#5e0490',
                            confirmButtonText: 'Intentar de nuevo',
                            customClass: {
                                title: 'text-xl font-bold',
                                htmlContainer: 'py-4',
                                confirmButton: 'rounded-xl px-6 py-2.5 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200'
                            },
                            showClass: {
                                popup: 'animate__animated animate__headShake animate__faster'
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al cancelar solicitud:', error);

                    // Mostrar mensaje de error con diseño personalizado
                    Swal.fire({
                        icon: 'error',
                        title: '<span class="text-red-600">Error inesperado</span>',
                        html: `
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700">Hubo un problema al cancelar la solicitud.</p>
                                <p class="text-sm text-gray-500 mt-2">Por favor, intenta de nuevo más tarde.</p>
                            </div>
                        `,
                        confirmButtonColor: '#5e0490',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            title: 'text-xl font-bold',
                            htmlContainer: 'py-4',
                            confirmButton: 'rounded-xl px-6 py-2.5 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200'
                        },
                        showClass: {
                            popup: 'animate__animated animate__shakeX animate__faster'
                        }
                    });
                });
            }
        });
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