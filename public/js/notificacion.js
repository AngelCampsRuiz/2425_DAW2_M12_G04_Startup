// Configura Pusher
const pusher = new Pusher('644d2d7d1126320e15c6', {
    cluster: 'eu',
    encrypted: true
});

const userIdMeta = document.querySelector('meta[name="user-id"]');
if (userIdMeta) {
    const userId = userIdMeta.getAttribute('content');
    // Suscríbete al canal del usuario autenticado
    const channel = pusher.subscribe('user.' + userId);

    // Cuando llegue una notificación, recarga la lista
    channel.bind('notification', function(data) {
        loadNotifications();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const notificationButton = document.getElementById('notificationButton');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationCount = document.getElementById('notificationCount');
    const notificationList = document.getElementById('notificationList');

    if (notificationButton && notificationDropdown) {
        notificationButton.addEventListener('click', function () {
            notificationDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // Cargar notificaciones (AJAX)
        function loadNotifications() {
            fetch('/notifications/unread', {
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    notificationList.innerHTML = '';
                    if (!Array.isArray(data) || data.length === 0) {
                        notificationList.innerHTML = '<div class="p-4 text-gray-500">No tienes notificaciones nuevas.</div>';
                        notificationCount.style.display = 'none';
                    } else {
                        notificationCount.textContent = data.length;
                        notificationCount.style.display = 'inline-flex';
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
                })
                .catch(error => {
                    notificationList.innerHTML = '<div class="p-4 text-red-500">Error al cargar notificaciones.</div>';
                    notificationCount.style.display = 'none';
                });
        }

        // Marcar como leída (puedes mejorar esto)
        window.markAsRead = function(id) {
            fetch(`/notifications/${id}/read`, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')} })
                .then(() => loadNotifications());
        }

        // Cargar notificaciones al abrir el dropdown
        notificationButton.addEventListener('click', loadNotifications);

        // Opcional: recargar cada cierto tiempo o con Pusher
        setInterval(loadNotifications, 30000);

        loadNotifications();
    }
});

window.markAsReadAndRedirect = function(id, url) {
    // Elimina del DOM la notificación antes de redirigir
    const notifDiv = document.querySelector(`[onclick*="markAsReadAndRedirect('${id}'"]`);
    if (notifDiv) notifDiv.remove();

    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => {
        // Opcional: podrías actualizar el contador aquí si quieres
        window.location.href = url;
    });
}