// Configura Pusher
const pusher = new Pusher('644d2d7d1126320e15c6', {
    cluster: 'eu',
    encrypted: true
});

// Variables para control de estado
let notificationsLoaded = false; 
let isLoadingNotifications = false;
let notificationInterval = null;
let lastLoadTimestamp = 0;
const MIN_LOAD_INTERVAL = 60000; // Mínimo 1 minuto entre cargas (aumentado)
const isSolicitudesPage = window.location.pathname.includes('/solicitudes');

// Si estamos en la página de solicitudes, no cargar notificaciones automáticamente
if (isSolicitudesPage) {
    console.log('Página de solicitudes detectada - desactivando carga automática de notificaciones');
}

// Configuración del canal Pusher para notificaciones del usuario
const userIdMeta = document.querySelector('meta[name="user-id"]');
if (userIdMeta) {
    const userId = userIdMeta.getAttribute('content');
    // Suscribirse al canal del usuario autenticado
    const channel = pusher.subscribe('user.' + userId);

    // Cuando llegue una notificación, esperar un tiempo prudencial antes de recargar
    channel.bind('notification', function(data) {
        // No cargar en la página de solicitudes
        if (isSolicitudesPage) return;
        
        if (document.visibilityState === 'visible' && 
            !isLoadingNotifications && 
            (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL)) {
            loadNotifications();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const notificationButton = document.getElementById('notificationButton');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationCount = document.getElementById('notificationCount');
    const notificationList = document.getElementById('notificationList');

    // Si no existen los elementos, salimos para evitar errores
    if (!notificationButton || !notificationDropdown || !notificationCount || !notificationList) {
        console.log('No se encontraron elementos de notificación en el DOM');
        return;
    }

    // Manejador de clic para el botón de notificaciones
    notificationButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Evitar propagación del evento
        notificationDropdown.classList.toggle('hidden');
        
        // Solo cargar notificaciones si se está abriendo el dropdown
        // y ha pasado suficiente tiempo desde la última carga
        if (!notificationDropdown.classList.contains('hidden') && 
            (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL) &&
            !isLoadingNotifications) {
            loadNotifications();
        }
    });

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function (event) {
        if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });

    // Función optimizada para cargar notificaciones
    window.loadNotifications = function() {
        // No cargar notificaciones en la página de solicitudes
        if (isSolicitudesPage) {
            console.log('Carga de notificaciones desactivada en la página de solicitudes');
            return;
        }
        
        // Evitar múltiples solicitudes simultáneas
        if (isLoadingNotifications) {
            console.log('Ya hay una carga de notificaciones en progreso');
            return;
        }
        
        // Registrar timestamp de carga
        lastLoadTimestamp = Date.now();
        isLoadingNotifications = true;
        
        // Indicador visual de carga
        notificationList.innerHTML = '<div class="p-4 text-center"><div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-primary"></div> <span class="ml-2 text-gray-500">Cargando...</span></div>';
        
        // Realizar la petición con caché desactivada
        fetch('/notifications/unread', {
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            // Limpiar el contenedor
            notificationList.innerHTML = '';
            
            // Mostrar mensaje si no hay notificaciones
            if (!Array.isArray(data) || data.length === 0) {
                notificationList.innerHTML = '<div class="p-4 text-gray-500 text-center">No tienes notificaciones nuevas.</div>';
                notificationCount.style.display = 'none';
            } else {
                // Mostrar contador y actualizar la lista
                notificationCount.textContent = data.length;
                notificationCount.style.display = 'inline-flex';
                
                // Renderizar cada notificación
                data.forEach(notification => {
                    // Determina el icono y color según el tipo
                    let icon = '';
                    let iconColor = '';
                    
                    switch (notification.type) {
                        case 'mensaje_no_leido':
                        case 'App\\Notifications\\MensajeNoLeidoNotification':
                            icon = '<i class="fas fa-envelope fa-xs"></i>';
                            iconColor = 'text-purple-600 bg-purple-100';
                            break;
                        case 'nueva_solicitud':
                        case 'App\\Notifications\\AlumnoSuscritoNotification':
                            icon = '<i class="fas fa-user-plus fa-xs"></i>';
                            iconColor = 'text-blue-600 bg-blue-100';
                            break;
                        case 'respuesta_publicacion':
                        case 'App\\Notifications\\SolicitudEstadoNotification':
                        case 'solicitud_estado':
                            if (notification.estado === 'rechazada') {
                                icon = '<i class="fas fa-times-circle fa-xs"></i>';
                                iconColor = 'text-red-600 bg-red-100';
                            } else {
                                icon = '<i class="fas fa-check-circle fa-xs"></i>';
                                iconColor = 'text-green-600 bg-green-100';
                            }
                            break;
                        default:
                            icon = '<i class="fas fa-info-circle fa-xs"></i>';
                            iconColor = 'text-gray-600 bg-gray-100';
                    }

                    // Agregar la notificación al DOM
                    notificationList.innerHTML += `
                        <div class="p-3 border-b hover:bg-gray-100 cursor-pointer flex items-start space-x-2"
                             onclick="markAsReadAndRedirect('${notification.id}', '${notification.url}')">
                            <div class="flex-shrink-0 rounded-full p-1.5 ${iconColor} flex items-center justify-center" style="width:28px;height:28px;">
                                ${icon}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm">${notification.title}</div>
                                <div class="text-xs text-gray-600">${notification.message}</div>
                                <div class="text-xs text-gray-400">${new Date(notification.created_at).toLocaleString()}</div>
                            </div>
                        </div>
                    `;
                });
            }
            
            // Restablecer flag de carga
            notificationsLoaded = true;
            isLoadingNotifications = false;
        })
        .catch(error => {
            console.error('Error al cargar notificaciones:', error);
            notificationList.innerHTML = '<div class="p-4 text-red-500">Error al cargar notificaciones.</div>';
            notificationCount.style.display = 'none';
            
            // Restablecer flags en caso de error
            isLoadingNotifications = false;
        });
    }

    // Función para marcar una notificación como leída
    window.markAsRead = function(id) {
        // No procesar en la página de solicitudes
        if (isSolicitudesPage) return;
        
        fetch(`/notifications/${id}/read`, { 
            method: 'POST', 
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache, no-store'
            } 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al marcar notificación: ' + response.status);
            }
            return response.json();
        })
        .then(() => {
            // Solo recargar si el dropdown está visible y ha pasado suficiente tiempo
            if (!notificationDropdown.classList.contains('hidden') && 
                !isLoadingNotifications && 
                (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL)) {
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error al marcar notificación como leída:', error);
        });
    };

    // Control de visibilidad de la página - Optimizado
    function handleVisibilityChange() {
        // No procesar en la página de solicitudes
        if (isSolicitudesPage) return;
        
        if (document.visibilityState === 'visible') {
            // Cargar notificaciones si hace mucho que no se cargan
            if (!isLoadingNotifications && (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL)) {
                loadNotifications();
            }
            
            // Establecer intervalo solo si no existe ya
            if (!notificationInterval) {
                notificationInterval = setInterval(function() {
                    if (!isLoadingNotifications && (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL)) {
                        loadNotifications();
                    }
                }, 120000); // Cada 2 minutos verificar si es necesario recargar (aumentado)
                
                // Hacer disponible globalmente para poder detenerlo si es necesario
                window.notificationInterval = notificationInterval;
            }
        } else {
            // Eliminar intervalo si la página no está visible
            if (notificationInterval) {
                clearInterval(notificationInterval);
                notificationInterval = null;
                window.notificationInterval = null;
            }
        }
    }
    
    // Configurar eventos de visibilidad
    document.addEventListener('visibilitychange', handleVisibilityChange);
    
    // Inicialización - solo cargar si la página está visible Y no es la página de solicitudes
    if (document.visibilityState === 'visible' && !isSolicitudesPage) {
        // Retrasar la carga inicial para no afectar el rendimiento de carga
        setTimeout(function() {
            if (!isLoadingNotifications) {
                loadNotifications();
            }
            
            // Configurar el intervalo inicial
            notificationInterval = setInterval(function() {
                if (!isLoadingNotifications && (Date.now() - lastLoadTimestamp > MIN_LOAD_INTERVAL)) {
                    loadNotifications();
                }
            }, 120000); // 2 minutos entre verificaciones
            
            // Hacer disponible globalmente
            window.notificationInterval = notificationInterval;
        }, 5000); // Retraso de 5 segundos para la carga inicial (aumentado)
    }
});

// Función para marcar como leída y redirigir
window.markAsReadAndRedirect = function(id, url) {
    // No procesar si estamos en la página de solicitudes
    if (isSolicitudesPage) {
        window.location.href = url;
        return;
    }
    
    // Eliminar del DOM la notificación antes de redirigir para feedback inmediato
    const notifDiv = document.querySelector(`[onclick*="markAsReadAndRedirect('${id}'"]`);
    if (notifDiv) notifDiv.remove();

    // Actualizar contador visual
    const notificationCount = document.getElementById('notificationCount');
    if (notificationCount && notificationCount.textContent) {
        const count = parseInt(notificationCount.textContent);
        if (count > 1) {
            notificationCount.textContent = count - 1;
        } else {
            notificationCount.style.display = 'none';
        }
    }

    // Enviar solicitud para marcar como leída
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Cache-Control': 'no-cache, no-store'
        }
    }).then(response => {
        if (!response.ok) {
            throw new Error('Error al marcar notificación: ' + response.status);
        }
        window.location.href = url;
    }).catch(error => {
        console.error('Error al marcar notificación como leída:', error);
        // En caso de error, redirigir de todos modos
        window.location.href = url;
    });
};