document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de búsqueda
    const searchInput = document.getElementById('search-chats');
    const chatItems = document.querySelectorAll('.chat-item');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Verificar si hay resultados visibles
            checkVisibleResults();
        });
    }
    
    function checkVisibleResults() {
        const chatList = document.getElementById('chat-list');
        if (!chatList) return;
        
        let visibleItems = 0;
        chatItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleItems++;
            }
        });
        
        // Si no hay resultados, mostrar mensaje
        if (visibleItems === 0 && chatItems.length > 0) {
            // Verificar si ya existe el mensaje
            if (!document.getElementById('no-results-message')) {
                const noResults = document.createElement('div');
                noResults.id = 'no-results-message';
                noResults.className = 'p-8 text-center';
                noResults.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No se encontraron resultados</h3>
                    <p class="mt-1 text-gray-500">Prueba con otros términos de búsqueda</p>
                `;
                chatList.appendChild(noResults);
            }
        } else {
            // Eliminar mensaje si existe
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
    }
    
    // Funcionalidad para botones de ordenar y filtrar
    const sortButton = document.getElementById('sort-button');
    if (sortButton) {
        let sortOrder = 'desc'; // Default: más recientes primero
        
        sortButton.addEventListener('click', function() {
            const chatList = document.getElementById('chat-list');
            if (!chatList) return;
            
            const chats = Array.from(chatList.querySelectorAll('.chat-item'));
            
            // Cambiar el orden
            sortOrder = sortOrder === 'desc' ? 'asc' : 'desc';
            
            // Actualizar el texto del botón
            const buttonText = sortOrder === 'desc' ? 'Recientes' : 'Antiguos';
            sortButton.querySelector('span').textContent = buttonText;
            
            // Ordenar los elementos
            chats.sort((a, b) => {
                const dateA = new Date(a.querySelector('.far.fa-clock').nextSibling.textContent.trim());
                const dateB = new Date(b.querySelector('.far.fa-clock').nextSibling.textContent.trim());
                
                return sortOrder === 'desc' ? dateB - dateA : dateA - dateB;
            });
            
            // Reposicionar los elementos
            chats.forEach(chat => chatList.appendChild(chat));
        });
    }
    
    // Comprobar mensajes nuevos cada 30 segundos
    setInterval(function() {
        const checkNewMessagesUrl = document.body.getAttribute('data-check-new-url');
        if (checkNewMessagesUrl) {
            fetch(checkNewMessagesUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.has_new_chats) {
                        // Solo mostrar notificación si no estamos ya en la página de chat
                        if (!window.location.pathname.includes('/chat')) {
                            showNotification('Tienes nuevos mensajes sin leer.', 'info');
                        }
                        
                        // Actualizar el contador de mensajes en el menú si existe
                        const notificationBadge = document.querySelector('.notification-badge');
                        if (notificationBadge) {
                            notificationBadge.style.display = 'flex';
                            notificationBadge.classList.add('animate-pulse');
                        }
                    }
                })
                .catch(error => console.error('Error al verificar mensajes nuevos:', error));
        }
    }, 30000);
    
    // Animación de entrada para los elementos de chat
    chatItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 100 + index * 50);
    });
});

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    // Crear el elemento de notificación
    const notification = document.createElement('div');
    
    // Asignar clases según el tipo
    let bgColor, borderColor, textColor, icon;
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-100';
            borderColor = 'border-green-500';
            textColor = 'text-green-700';
            icon = '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            break;
        case 'error':
            bgColor = 'bg-red-100';
            borderColor = 'border-red-500';
            textColor = 'text-red-700';
            icon = '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            break;
        case 'warning':
            bgColor = 'bg-yellow-100';
            borderColor = 'border-yellow-500';
            textColor = 'text-yellow-700';
            icon = '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
            break;
        default: // info
            bgColor = 'bg-blue-100';
            borderColor = 'border-blue-500';
            textColor = 'text-blue-700';
            icon = '<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    }
    
    // Construir la notificación
    notification.className = `fixed bottom-4 right-4 ${bgColor} ${textColor} px-4 py-3 rounded-lg shadow-lg z-50 border-l-4 ${borderColor} max-w-sm flex items-center animate-fade-in-up`;
    notification.innerHTML = `
        ${icon}
        <div>${message}</div>
        <button type="button" class="ml-auto" onclick="this.parentElement.remove()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    // Añadir al body
    document.body.appendChild(notification);
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('animate-fade-out');
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
} 