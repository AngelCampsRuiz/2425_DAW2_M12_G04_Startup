document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en la página de chat
    const isChatPage = document.querySelector('#chat-messages') !== null;
    
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

    // Solo continuar con Pusher si estamos en una página de chat
    if (!isChatPage) return;

    // Obtener configuración de Pusher desde meta tags
    const pusherKey = document.querySelector('meta[name="pusher-key"]')?.content;
    const pusherCluster = document.querySelector('meta[name="pusher-cluster"]')?.content;

    // Solo configurar Pusher si tenemos las claves necesarias
    if (pusherKey && pusherCluster) {
        // Configuración de Pusher
        const pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
            forceTLS: true,
            authEndpoint: '/broadcasting/auth'
        });

        // Suscribirse al canal del chat si estamos en una página de chat
        const chatId = document.querySelector('meta[name="chat-id"]')?.content;
        if (chatId) {
            const channel = pusher.subscribe(`private-chat.${chatId}`);

            // Elementos del DOM
            const chatMessages = document.getElementById('chat-messages');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const fileInput = document.getElementById('file-input');

            // Variables de estado
            let lastMessageId = window.lastMessageId || 0;

            // Escuchar eventos de nuevos mensajes
            channel.bind('App\\Events\\MessageSent', function(data) {
                if (chatMessages) {
                    appendMessage(data);
                    if (isAtBottom()) {
                        scrollToBottom();
                    }
                }
            });

            // Función para verificar si el scroll está al final
            function isAtBottom() {
                if (!chatMessages) return false;
                const tolerance = 50;
                return (chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight) < tolerance;
            }

            // Función para hacer scroll al final
            function scrollToBottom() {
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            // Función para añadir un mensaje al chat
            function appendMessage(message) {
                if (!chatMessages) return;
                const isCurrentUser = message.user_id === parseInt(document.querySelector('meta[name="user-id"]')?.content || '0');
                const html = createMessageHtml(message, isCurrentUser);
                chatMessages.insertAdjacentHTML('beforeend', html);
                lastMessageId = message.id;
            }

            // Función para crear el HTML de un mensaje
            function createMessageHtml(message, isCurrentUser) {
                return `
                    <div class="flex items-start message ${isCurrentUser ? 'justify-end' : ''} mb-4" data-message-id="${message.id}">
                        ${!isCurrentUser ? `
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden shadow-md">
                                    ${message.user && message.user.imagen ? `
                                        <img src="/profile_images/${message.user.imagen}"
                                            alt="Foto de perfil"
                                            class="w-full h-full object-cover">
                                    ` : `
                                        <span class="text-base font-bold text-gray-700">
                                            ${message.user && message.user.nombre ? message.user.nombre.substring(0, 2).toUpperCase() : 'US'}
                                        </span>
                                    `}
                                </div>
                            </div>
                        ` : ''}
                        <div class="flex-1 ${isCurrentUser ? 'text-right' : ''}">
                            <div class="${isCurrentUser 
                                ? 'bg-gradient-to-r from-purple-500 to-indigo-600 text-white' 
                                : 'bg-white'} rounded-2xl p-4 shadow-md inline-block max-w-[85%] relative message-bubble">
                                <p class="text-sm ${isCurrentUser ? 'text-white' : 'text-gray-800'} message-content">
                                    ${message.contenido || ''}
                                </p>
                                ${message.archivo_adjunto ? `
                                    <div class="mt-2">
                                        ${message.tipo_archivo && message.tipo_archivo.startsWith('image/') ? `
                                            <a href="/chat_files/${message.archivo_adjunto}" target="_blank" class="block">
                                                <img src="/chat_files/${message.archivo_adjunto}" 
                                                    alt="Imagen adjunta" 
                                                    class="max-w-full max-h-60 rounded-lg shadow-sm">
                                            </a>
                                        ` : `
                                            <a href="/chat_files/${message.archivo_adjunto}" 
                                               target="_blank"
                                               class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors duration-200">
                                                <div class="mr-3 bg-gray-200 w-10 h-10 rounded-lg flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-file-alt text-lg"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        ${message.nombre_archivo || 'Archivo adjunto'}
                                                    </p>
                                                    <p class="text-xs text-gray-500">Descargar archivo</p>
                                                </div>
                                                <i class="fas fa-download text-purple-600"></i>
                                            </a>
                                        `}
                                    </div>
                                ` : ''}
                                <div class="text-xs ${isCurrentUser ? 'text-white/80' : 'text-gray-500'} mt-1 flex items-center justify-between">
                                    <span>${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Manejar el envío de mensajes
            if (messageForm) {
                messageForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const content = messageInput?.value.trim() || '';
                    const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
                    
                    if (!content && !hasFile) return;
                    
                    const formData = new FormData();
                    if (content) {
                        formData.append('contenido', content);
                    }
                    
                    if (hasFile) {
                        formData.append('archivo', fileInput.files[0]);
                    }
                    
                    if (window.routeSendMessage && window.csrfToken) {
                        fetch(window.routeSendMessage, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': window.csrfToken
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.error) {
                                if (messageInput) messageInput.value = '';
                                if (fileInput) fileInput.value = '';
                                
                                // El mensaje se añadirá automáticamente a través del evento de Pusher
                            }
                        })
                        .catch(error => {
                            console.error('Error al enviar mensaje:', error);
                        });
                    }
                });
            }

            // Hacer scroll al último mensaje al cargar la página
            if (chatMessages) {
                scrollToBottom();
            }
        }
    }
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