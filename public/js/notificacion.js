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

    // Mostrar/ocultar el dropdown
    notificationButton.addEventListener('click', function () {
        notificationDropdown.classList.toggle('hidden');
    });

    // Cerrar el dropdown al hacer clic fuera
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
                        notificationList.innerHTML += `
                            <div class="p-4 border-b hover:bg-gray-100 cursor-pointer" onclick="markAsRead(${notification.id})">
                                <div class="font-semibold">${notification.title}</div>
                                <div class="text-sm text-gray-600">${notification.message}</div>
                                <div class="text-xs text-gray-400">${new Date(notification.created_at).toLocaleString()}</div>
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
    // setInterval(loadNotifications, 60000);

    loadNotifications();
});
