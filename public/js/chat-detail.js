// Función para crear el HTML de un mensaje
function createMessageHtml(message) {
    const isCurrentUser = message.user_id === parseInt(document.querySelector('meta[name="user-id"]').content);
    
    // Comprobar que el mensaje tenga la estructura necesaria
    if (!message.user) {
        console.error('Error: El mensaje no tiene la estructura esperada:', message);
        // Si no tiene la información del usuario, no podemos mostrar el mensaje correctamente
        return '';
    }
    
    // Manejar posibles valores nulos o indefinidos
    const contenido = message.contenido || '';
    
    return `
        <div class="flex items-start message ${isCurrentUser ? 'justify-end' : ''} mb-4" data-message-id="${message.id}">
            ${!isCurrentUser ? `
                <div class="flex-shrink-0 mr-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden shadow-md">
                        ${message.user.imagen ? `
                            <img src="${message.user.imagen.includes('http') ? message.user.imagen : '/profile_images/' + message.user.imagen}"
                                alt="Foto de perfil"
                                class="w-full h-full object-cover">
                        ` : `
                            <span class="text-base font-bold text-gray-700">
                                ${message.user.nombre.substring(0, 2).toUpperCase()}
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
                        ${contenido}
                    </p>
                    
                    ${message.archivo_adjunto ? generateAttachmentHTML(message, isCurrentUser) : ''}
                    
                    <div class="text-xs ${isCurrentUser ? 'text-white/80' : 'text-gray-500'} mt-1 flex items-center justify-between">
                        <span>${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Función para generar HTML para archivos adjuntos
function generateAttachmentHTML(message, isCurrentUser) {
    if (!message.archivo_adjunto) return '';
    
    const isImage = message.tipo_archivo && message.tipo_archivo.startsWith('image/');
    
    if (isImage) {
        return `
            <div class="mt-2 relative group">
                <a href="${message.archivo_adjunto}" target="_blank" class="block">
                    <img src="${message.archivo_adjunto}" alt="Imagen adjunta" class="max-w-full max-h-60 rounded-lg shadow-sm">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-search-plus mr-1"></i> Ver imagen
                        </span>
                    </div>
                </a>
            </div>
        `;
    } else {
        return `
            <div class="mt-2">
                <a href="${message.archivo_adjunto}" target="_blank" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors duration-200">
                    <div class="mr-3 bg-gray-200 w-10 h-10 rounded-lg flex items-center justify-center text-gray-500">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium ${isCurrentUser ? 'text-gray-900' : 'text-gray-900'} truncate">
                            ${message.nombre_archivo || 'Archivo adjunto'}
                        </p>
                        <p class="text-xs text-gray-500">Descargar archivo</p>
                    </div>
                    <i class="fas fa-download ${isCurrentUser ? 'text-purple-300' : 'text-purple-600'}"></i>
                </a>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del DOM con verificación de existencia
    const chatMessages = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const chatId = window.chatId;
    let lastMessageId = window.lastMessageId || 0;
    let isTyping = false;
    let typingTimeout;
    
    // Verificar que los elementos necesarios existen
    if (!chatMessages || !messageForm || !messageInput) {
        console.warn('Elementos esenciales del chat no encontrados');
        return;
    }
    
    // Crear el indicador de mensajes no leídos
    const unreadIndicator = document.createElement('div');
    unreadIndicator.className = 'unread-indicator';
    unreadIndicator.innerHTML = '<i class="fas fa-arrow-down mr-2"></i> Nuevos mensajes';
    document.body.appendChild(unreadIndicator);
    
    // Hacer scroll al último mensaje con animación
    if (chatMessages) {
        smoothScrollToBottom();
    }
    
    // Configuración de Pusher
    const pusherKey = document.querySelector('meta[name="pusher-key"]')?.content;
    const pusherCluster = document.querySelector('meta[name="pusher-cluster"]')?.content;
    
    if (pusherKey && pusherCluster && chatId) {
        console.log('Configurando Pusher para recibir mensajes en tiempo real');
        
        // Inicializar Pusher
        const pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
            forceTLS: true,
            authEndpoint: '/broadcasting/auth'
        });
        
        // Suscribirse al canal privado del chat
        const channel = pusher.subscribe(`private-chat.${chatId}`);
        
        // Escuchar eventos de nuevos mensajes
        channel.bind('App\\Events\\MessageSent', function(data) {
            console.log('Nuevo mensaje recibido por Pusher:', data);
            
            // Si el mensaje ya existe en el chat, no lo agregamos
            const existingMessage = document.querySelector(`.message[data-message-id="${data.id}"]`);
            if (existingMessage) {
                console.log('El mensaje ya existe en el DOM, no se añade:', data.id);
                return;
            }
            
            // Agregamos el mensaje al chat
            const wasAtBottom = isAtBottom();
            const html = createMessageHtml(data);
            chatMessages.insertAdjacentHTML('beforeend', html);
            
            // Actualizamos el último ID de mensaje
            if (data.id > lastMessageId) {
                lastMessageId = data.id;
            }
            
            // Si estábamos al final, hacemos scroll automático
            if (wasAtBottom) {
                smoothScrollToBottom();
            } else {
                showNewMessageIndicator();
                // Reproducir sonido de notificación
                showMessageNotification(data);
            }
            
            // Si no es nuestro mensaje, lo marcamos como leído
            const currentUserId = parseInt(document.querySelector('meta[name="user-id"]').content);
            if (data.user_id !== currentUserId) {
                markMessageAsRead(data.id);
            }
        });
        
        // Escuchar eventos de mensajes leídos
        channel.bind('message.read', function(data) {
            console.log('Mensaje marcado como leído:', data);
            
            // Actualizar la interfaz para mostrar que el mensaje ha sido leído
            const messageElement = document.querySelector(`.message[data-message-id="${data.message_id}"]`);
            if (messageElement) {
                // Añadir clase o indicador visual de que el mensaje ha sido leído
                messageElement.classList.add('message-read');
                
                // Si existe un indicador de estado de lectura, actualizarlo
                const readStatus = messageElement.querySelector('.read-status');
                if (readStatus) {
                    readStatus.innerHTML = '<i class="fas fa-check-double text-blue-500"></i>';
                    readStatus.setAttribute('title', 'Leído ' + new Date(data.read_at).toLocaleString());
                }
            }
        });
        
        // Registramos el estado de conexión de Pusher
        pusher.connection.bind('connected', function() {
            console.log('✅ Conectado a Pusher correctamente');
            updateConnectionStatus('connected');
        });
        
        pusher.connection.bind('connecting', function() {
            console.log('⏳ Conectando a Pusher...');
            updateConnectionStatus('connecting');
        });
        
        pusher.connection.bind('disconnected', function() {
            console.log('❌ Desconectado de Pusher');
            updateConnectionStatus('disconnected');
        });
        
        pusher.connection.bind('failed', function() {
            console.log('⚠️ La conexión a Pusher ha fallado');
            updateConnectionStatus('failed');
            
            // Intentar reconectar cada 5 segundos
            setTimeout(function() {
                pusher.connect();
            }, 5000);
        });
    } else {
        console.warn('No se pudo inicializar Pusher: faltan datos de configuración');
    }
    
    // ----------------------
    // FUNCIONES DE MENSAJES
    // ----------------------
    
    // Función para recargar completamente el contenedor de mensajes
    function updateMessages() {
        if (!window.routeGetMessages) {
            console.error('No se encontró la ruta para obtener mensajes');
            return;
        }
        
        console.log('Actualizando mensajes del chat...');
        
        // Solo obtenemos mensajes más recientes que el último que tenemos
        const url = `${window.routeGetMessages}?after=${lastMessageId}`;
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener mensajes: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (!data.messages || !Array.isArray(data.messages)) {
                    console.error('Formato de respuesta incorrecto:', data);
                    return;
                }
                
                // Si no hay mensajes nuevos, terminamos
                if (data.messages.length === 0) {
                    return;
                }
                
                console.log(`Recibidos ${data.messages.length} mensajes nuevos`);
                
                const wasAtBottom = isAtBottom();
                let hasNewMessages = false;
                
                // Ordenar mensajes por fecha de creación para asegurar el orden correcto
                const nuevos = data.messages.sort((a, b) => {
                    return new Date(a.created_at) - new Date(b.created_at);
                });
                
                // Añadir cada mensaje nuevo al chat
                nuevos.forEach(mensaje => {
                    // Verificar si el mensaje ya existe
                    const existingMessage = document.querySelector(`.message[data-message-id="${mensaje.id}"]`);
                    if (existingMessage) {
                        return;
                    }
                    
                    hasNewMessages = true;
                    const html = createMessageHtml(mensaje);
                    chatMessages.insertAdjacentHTML('beforeend', html);
                    
                    // Actualizamos el último ID
                    if (mensaje.id > lastMessageId) {
                        lastMessageId = mensaje.id;
                    }
                    
                    // Si no es nuestro mensaje, lo marcamos como leído
                    const currentUserId = parseInt(document.querySelector('meta[name="user-id"]').content);
                    if (mensaje.user_id !== currentUserId) {
                        markMessageAsRead(mensaje.id);
                    }
                });
                
                // Si había nuevos mensajes y estábamos al final, hacer scroll
                if (hasNewMessages && wasAtBottom) {
                    smoothScrollToBottom();
                } else if (hasNewMessages) {
                    showNewMessageIndicator();
                    
                    // Mostrar notificación para el último mensaje si no es nuestro
                    const currentUserId = parseInt(document.querySelector('meta[name="user-id"]').content);
                    const ultimoMensaje = nuevos[nuevos.length - 1];
                    if (ultimoMensaje.user_id !== currentUserId) {
                        showMessageNotification(ultimoMensaje);
                    }
                }
            })
            .catch(error => {
                console.error('Error al actualizar mensajes:', error);
            });
    }
    
    // Actualizar mensajes cada 5 segundos como respaldo a Pusher
    setInterval(updateMessages, 5000);
    
    // ----------------------
    // RESTO DEL CÓDIGO
    // ----------------------
    
    // Inicializar textarea autoexpandible
    function initAutoExpandTextarea() {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Mostrar contador de caracteres cuando se escribe
            const currentLength = this.value.length;
            const maxLength = 500;
            const lengthIndicator = document.querySelector('.message-length');
            
            if (lengthIndicator) {
            if (currentLength > 0) {
                lengthIndicator.classList.remove('hidden');
                    const currentLengthElement = document.getElementById('current-length');
                    if (currentLengthElement) {
                        currentLengthElement.textContent = currentLength;
                    }
                
                if (currentLength > maxLength * 0.8) {
                    lengthIndicator.classList.add('text-orange-500');
                } else {
                    lengthIndicator.classList.remove('text-orange-500', 'text-red-500');
                }
                
                if (currentLength > maxLength * 0.95) {
                    lengthIndicator.classList.add('text-red-500');
                }
            } else {
                lengthIndicator.classList.add('hidden');
                }
            }
            
            // Emitir evento de "está escribiendo"
            if (!isTyping) {
                isTyping = true;
            }
            
            // Reiniciar timeout de escritura
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
            }, 2000);
        });
        
        // Escuchar Enter para enviar (Shift+Enter para nueva línea)
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });
    }
    
    // Inicializar el textarea autoexpandible
    initAutoExpandTextarea();

    // Función para desplazarse suavemente al final del chat
    function smoothScrollToBottom() {
        const start = chatMessages.scrollTop;
        const end = chatMessages.scrollHeight - chatMessages.clientHeight;
        const duration = 300; // milisegundos
        const startTime = performance.now();
        
        function animateScroll(timestamp) {
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = 0.5 - Math.cos(progress * Math.PI) / 2;
            
            chatMessages.scrollTop = start + (end - start) * easeProgress;
            
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            }
        }
        
        requestAnimationFrame(animateScroll);
    }
    
    // Función para verificar si el scroll está al final
    function isAtBottom() {
        const tolerance = 50;
        return (chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight) < tolerance;
    }
    
    // Función para mostrar el indicador de nuevos mensajes
    function showNewMessageIndicator() {
        // Mostrar el indicador
        unreadIndicator.classList.add('active');
        
        // Ocultar automáticamente después de 5 segundos
        setTimeout(() => {
            unreadIndicator.classList.remove('active');
        }, 5000);
        
        // Si se hace clic, desplazarse al final
        unreadIndicator.onclick = function() {
            smoothScrollToBottom();
            unreadIndicator.classList.remove('active');
        };
    }
    
    // Observador para cuando se hace scroll
    chatMessages.addEventListener('scroll', function() {
        if (isAtBottom()) {
            unreadIndicator.classList.remove('active');
        }
    });
    
    // Función para mostrar notificación de mensaje
    function showMessageNotification(mensaje) {
        // Solo mostramos notificación si no es un mensaje propio
        const currentUserId = parseInt(document.querySelector('meta[name="user-id"]').content);
        if (mensaje.user_id === currentUserId) return;
        
        // Crear un sonido de notificación simple con la API Audio
        try {
            // Creamos un contexto de audio
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            
            // Creamos un oscilador (para el sonido)
            const oscillator = audioContext.createOscillator();
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(880, audioContext.currentTime); // Nota A5
            
            // Creamos un controlador de ganancia (para el volumen)
            const gainNode = audioContext.createGain();
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            // Conectamos el oscilador a la ganancia y luego a la salida
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            // Reproducimos el sonido
            oscillator.start();
            oscillator.stop(audioContext.currentTime + 0.3);
        } catch (e) {
            console.log('No se pudo reproducir sonido:', e);
        }
        
        // Mostrar notificación visual (Sweet Alert si está disponible, o notificación nativa)
        if (window.Swal) {
            Swal.fire({
                title: mensaje.user.nombre || 'Nuevo mensaje',
                text: mensaje.contenido || 'Has recibido un nuevo mensaje',
                icon: 'info',
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                    toast.addEventListener('click', () => {
                        smoothScrollToBottom();
                        Swal.close();
                    });
                }
            });
        } else if ('Notification' in window && Notification.permission === 'granted') {
            // Notificación nativa del navegador como respaldo
            const notification = new Notification('Nuevo mensaje de ' + (mensaje.user.nombre || 'Usuario'), {
                body: mensaje.contenido || 'Has recibido un nuevo mensaje',
                icon: '/favicon.ico'
            });
            
            notification.onclick = function() {
                window.focus();
                smoothScrollToBottom();
            };
        }
    }
    
    // Solicitar permiso para notificaciones
    if ('Notification' in window && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        // Solicitamos permiso cuando el usuario interactúa con la página
        document.addEventListener('click', function requestNotificationPermission() {
            Notification.requestPermission();
            document.removeEventListener('click', requestNotificationPermission);
        }, { once: true });
    }
    
    // Mostrar notificación de mensaje
    function showMessageNotification(mensaje) {
        // Crear notificación
        const notification = document.createElement('div');
        notification.className = 'message-notification';
        
        // Contenido de la notificación
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-purple-200 flex items-center justify-center mr-3">
                    <span class="text-sm font-bold text-[#5e0490]">
                        ${mensaje.user ? mensaje.user.nombre.substring(0, 2).toUpperCase() : window.otherUserName.substring(0, 2).toUpperCase()}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-sm">${mensaje.user ? mensaje.user.nombre : window.otherUserName}</p>
                    <p class="text-xs text-purple-100 truncate">${mensaje.contenido || 'Ha enviado un archivo'}</p>
                </div>
            </div>
        `;
        
        // Añadir a DOM
        document.body.appendChild(notification);
        
        // Mostrar con delay
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Ocultar después de 4 segundos
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 4000);
    }
    
    // Enviar mensaje con animaciones
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const content = messageInput.value.trim();
            
            if (!content) return;
            
            // Desactivar botones durante el envío
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i><span>Enviando...</span>';
            }
            
            // Verificar si tenemos la URL y el token CSRF
            if (!window.routeSendMessage || !window.csrfToken) {
                console.error('Error: No se encontró la URL para enviar mensajes o el token CSRF');
                showErrorNotification('Error: Configuración incompleta para enviar mensajes');
                
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Enviar</span>';
                }
                return;
            }
            
            // Crear FormData para enviar el contenido
            const formData = new FormData();
                formData.append('contenido', content);
            
            console.log('Enviando mensaje a:', window.routeSendMessage);
            
            // Enviar mensaje al servidor
            fetch(window.routeSendMessage, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Error en la respuesta del servidor:', response.status, response.statusText);
                    throw new Error('El servidor respondió con un error: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta del servidor:', data);
                
                if (!data.error) {
                    // Limpiar inputs
                    if (messageInput) {
                        messageInput.value = '';
                        messageInput.style.height = 'auto';
                    }
                    
                    // Añadir mensaje a la vista con animación inmediatamente
                    if (chatMessages && data.mensaje) {
                        chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(data.mensaje));
                        lastMessageId = data.mensaje.id;
                        
                        // Desplazamiento suave al último mensaje
                        smoothScrollToBottom();
                        
                        // Mostrar pequeña animación de "enviado"
                        showSentAnimation();
                        
                        // Forzar una recarga inmediata para sincronizar
                        setTimeout(updateMessages, 500);
                    } else {
                        console.error('Error: No se pudo añadir el mensaje a la vista', data);
                    }
                    
                    // Ocultar contador de caracteres
                    const lengthIndicator = document.querySelector('.message-length');
                    if (lengthIndicator) {
                        lengthIndicator.classList.add('hidden');
                    }
                } else {
                    // Mostrar error si hay alguno
                    console.error('Error devuelto por el servidor:', data.error);
                    showErrorNotification(data.error);
                }
                
                // Reactivar botón
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Enviar</span>';
                }
            })
            .catch(error => {
                console.error('Error al enviar mensaje:', error);
                
                // Mostrar error genérico
                showErrorNotification('Error al enviar el mensaje. Inténtalo de nuevo.');
                
                // Reactivar botón
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Enviar</span>';
                }
            });
        });
    } else {
        console.error('No se encontró el formulario de mensajes');
    }
    
    // Animación de mensaje enviado
    function showSentAnimation() {
        const sentIndicator = document.createElement('div');
        sentIndicator.className = 'fixed bottom-8 right-8 bg-green-500 text-white px-4 py-2 rounded-xl shadow-lg z-50 animate-fadeIn';
        sentIndicator.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Mensaje enviado';
        document.body.appendChild(sentIndicator);
        
        setTimeout(() => {
            sentIndicator.classList.add('animate-fadeOut');
            setTimeout(() => {
                document.body.removeChild(sentIndicator);
            }, 500);
        }, 2000);
    }
    
    // Mostrar notificación de error
    function showErrorNotification(message) {
        const errorIndicator = document.createElement('div');
        errorIndicator.className = 'fixed bottom-8 right-8 bg-red-500 text-white px-4 py-2 rounded-xl shadow-lg z-50 animate-fadeIn';
        errorIndicator.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i> ${message}`;
        document.body.appendChild(errorIndicator);
        
        setTimeout(() => {
            errorIndicator.classList.add('animate-fadeOut');
            setTimeout(() => {
                document.body.removeChild(errorIndicator);
            }, 500);
        }, 3000);
    }
    
    // Función para marcar un mensaje como leído
    function markMessageAsRead(messageId) {
        // Verificar que tenemos el token CSRF
        const csrfToken = window.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            console.error('No se encontró el token CSRF para marcar el mensaje como leído');
            return;
        }
        
        // Enviar petición para marcar el mensaje como leído
        fetch(`/chat/${messageId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al marcar mensaje como leído: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Mensaje marcado como leído:', messageId);
        })
        .catch(error => {
            console.error('Error al marcar mensaje como leído:', error);
        });
    }
    
    //--------------------------------------------------------------
    // FUNCIONALIDAD DE VIDEOLLAMADA MEJORADA - Segunda parte del archivo
    //--------------------------------------------------------------
    
    // Implementación de videollamada en un archivo separado
    // O se puede reducir esta sección para mantener el archivo más pequeño
    
    // Configuración de Agora
    const APP_ID = "ff42e2de41ee4ec7b9bfe51d3d9b4edd"; // App ID de Agora
    const CHANNEL_NAME = "chat_" + window.chatId;
    const TOKEN = null; // Para producción, debes generar tokens en tu servidor
    
    // Elementos del DOM para videollamada
    const videoCallBtn = document.getElementById('video-call-btn');
    const videoContainer = document.getElementById('video-container');
    const closeVideoContainer = document.getElementById('close-video-container');
    const toggleAudio = document.getElementById('toggle-audio');
    const toggleVideo = document.getElementById('toggle-video');
    const endCall = document.getElementById('end-call');
    const localVideoContainer = document.getElementById('local-video');
    const remoteVideoContainer = document.getElementById('remote-video');
    const remoteVideoLoading = document.getElementById('remote-video-loading');
    const callStatus = document.getElementById('call-status');
    const callTimer = document.getElementById('call-timer');
    const connectionStatus = document.getElementById('connection-status');
    const incomingCall = document.getElementById('incoming-call');
    const acceptCall = document.getElementById('accept-call');
    const rejectCall = document.getElementById('reject-call');
    const localVideoStatus = document.getElementById('local-video-status');
    const remoteVideoStatus = document.getElementById('remote-video-status');
    const toggleChat = document.getElementById('toggle-chat');
    
    // Variables para la videollamada
    let rtcClient;
    let localTracks = {
        videoTrack: null,
        audioTrack: null
    };
    let remoteUsers = {};
    let isCallActive = false;
    let isMinimized = false;
    let callStartTime;
    let timerInterval;
    let callStatistics = {
        bytesReceived: 0,
        bytesSent: 0,
        packetsLost: 0,
        roundTripTime: 0
    };
    
    // Configuración de Socket.io - Usar configuración del servidor si está disponible
    const socketServerUrl = window.socketServerUrl || 'http://localhost:3000';
    console.log('Conectando a servidor Socket.io:', socketServerUrl);
    
    // Conexión con socket.io para señalización con mejor manejo de errores
    let socket;
    try {
        socket = io(socketServerUrl, {
            reconnectionAttempts: 8,
            timeout: 15000,
            transports: ['websocket', 'polling'],
            autoConnect: true,
            reconnection: true,
            reconnectionDelay: 1000,
            forceNew: true
        });

        // Manejo de eventos de conexión
        socket.on('connect_error', (error) => {
            console.warn('Error de conexión socket.io:', error.message);
            updateConnectionStatus('error');
        });
        
        socket.on('connect', () => {
            console.log('Conectado al servidor de señalización');
            updateConnectionStatus('connected');
            if (window.authId) {
                socket.emit('register', { userId: window.authId });
            } else {
                console.warn('No se encontró el ID de usuario para registrar en el socket');
            }
        });
    } catch (e) {
        console.error('Error al inicializar socket.io:', e);
        socket = null;
    }
    
    // Funcionalidad básica de videollamada
    if (videoCallBtn) {
        videoCallBtn.addEventListener('click', startCall);
    }
    
    if (closeVideoContainer) {
        closeVideoContainer.addEventListener('click', toggleMinimize);
    }
    
    if (toggleAudio) {
        toggleAudio.addEventListener('click', toggleMicrophone);
    }
    
    if (toggleVideo) {
        toggleVideo.addEventListener('click', toggleCamera);
    }
    
    if (endCall) {
        endCall.addEventListener('click', endActiveCall);
    }
    
    if (acceptCall) {
        acceptCall.addEventListener('click', acceptIncomingCall);
    }
    
    if (rejectCall) {
        rejectCall.addEventListener('click', rejectIncomingCall);
    }
    
    if (toggleChat) {
        toggleChat.addEventListener('click', function() {
            // Implementación para mostrar/ocultar chat
        });
    }
    
    // Eventos de socket para videollamadas
    socket.on('incoming-call', (data) => {
        if (data.chatId === window.chatId) {
            showIncomingCall();
        }
    });
    
    socket.on('call-accepted', (data) => {
        if (data.chatId === window.chatId) {
            console.log('Llamada aceptada por el otro usuario');
            if (callStatus) {
                callStatus.textContent = 'Conectado';
            }
            if (remoteVideoLoading) {
                // Mantenemos el indicador de carga hasta que veamos el video remoto
                // Se ocultará cuando se reciba el track de video en el evento user-published
            }
        }
    });
    
    socket.on('call-rejected', (data) => {
        if (data.chatId === window.chatId) {
            endActiveCall();
            callStatus.textContent = 'Llamada rechazada';
            showErrorNotification(window.otherUserName + ' rechazó la llamada');
        }
    });
    
    socket.on('call-ended', (data) => {
        if (data.chatId === window.chatId) {
            if (isCallActive) {
                callStatus.textContent = 'Llamada finalizada';
                endActiveCall();
            }
        }
    });
    
    // Función para actualizar el estado de la conexión en la interfaz
    function updateConnectionStatus(status) {
        // Verificar si existe un elemento para mostrar el estado de la conexión
        let statusElement = document.getElementById('connection-status');
        
        // Si no existe, lo creamos
        if (!statusElement) {
            // Crear el elemento
            statusElement = document.createElement('div');
            statusElement.id = 'connection-status';
            statusElement.className = 'connection-status';
            
            // Añadir el indicador
            const indicator = document.createElement('span');
            indicator.className = 'indicator';
            statusElement.appendChild(indicator);
            
            // Añadir el texto
            const text = document.createElement('span');
            text.className = 'status-text';
            statusElement.appendChild(text);
            
            // Añadir a la interfaz (buscamos un lugar adecuado)
            const container = document.querySelector('.container');
            if (container) {
                container.insertAdjacentElement('afterbegin', statusElement);
            }
        }
        
        // Eliminar clases anteriores
        statusElement.classList.remove('connected', 'connecting', 'disconnected', 'failed');
        
        // Añadir la clase correspondiente al estado actual
        statusElement.classList.add(status);
        
        // Actualizar el texto según el estado
        const statusText = statusElement.querySelector('.status-text');
        if (statusText) {
            switch (status) {
                case 'connected':
                    statusText.textContent = 'Conectado';
                    break;
                case 'connecting':
                    statusText.textContent = 'Conectando...';
                    break;
                case 'disconnected':
                    statusText.textContent = 'Desconectado';
                    break;
                case 'failed':
                    statusText.textContent = 'Error de conexión';
                    break;
                default:
                    statusText.textContent = 'Estado desconocido';
            }
        }
        
        // Ocultar después de un tiempo si está conectado
        if (status === 'connected') {
            setTimeout(() => {
                statusElement.style.opacity = '0';
                setTimeout(() => {
                    statusElement.style.display = 'none';
                }, 300);
            }, 3000);
        } else {
            statusElement.style.display = 'flex';
            statusElement.style.opacity = '1';
        }
    }
    
    // Configurar manualmente el contenedor de video remoto para Agora
    function setupRemoteVideoContainer() {
        // Asegurarse de que el contenedor esté vacío para evitar duplicados
        if (remoteVideoContainer) {
            remoteVideoContainer.innerHTML = '';
            // Agregar un div con ID específico que Agora pueda usar
            remoteVideoContainer.style.position = 'relative';
            remoteVideoContainer.style.width = '100%';
            remoteVideoContainer.style.height = '100%';
            remoteVideoContainer.style.overflow = 'hidden';
            remoteVideoContainer.style.backgroundColor = '#000';
        }
    }
    
    // Inicializar elementos de la interfaz de llamada
    function initCallInterface() {
        // Configurar contenedor de video remoto para Agora
        setupRemoteVideoContainer();
        
        // Mostrar indicador de carga en remoto
        if (remoteVideoLoading) {
            remoteVideoLoading.classList.remove('hidden');
        }
        
        // Mostrar interfaz de videollamada
        if (videoContainer) {
            videoContainer.style.display = 'flex';
        }
    }
    
    // Modificar startCall para usar las nuevas funciones
    async function startCall() {
        if (!isCallActive) {
            console.log('Botón de videollamada presionado');
            
            // Inicializar interfaz
            initCallInterface();
            
            try {
                // Verificar si el navegador soporta getUserMedia
                if (!AgoraRTC.checkSystemRequirements()) {
                    throw new Error('Su navegador no cumple con los requisitos para videollamadas. Intente usar un navegador más moderno o acceder por HTTPS.');
                }
                
                // Inicializar cliente Agora si es necesario
                if (!rtcClient && typeof AgoraRTC !== 'undefined') {
                    rtcClient = AgoraRTC.createClient({
                        mode: 'rtc',
                        codec: 'vp8'
                    });
                    
                    // Configurar evento para manejar usuario remoto
                    rtcClient.on('user-published', async (user, mediaType) => {
                        // Suscribirse al usuario remoto
                        await rtcClient.subscribe(user, mediaType);
                        console.log('Suscrito a usuario remoto');
                        
                        // Manejar stream de video remoto
                        if (mediaType === 'video') {
                            remoteUsers[user.uid] = user;
                            
                            // Verificar si el elemento remoteVideoContainer existe
                            if (remoteVideoContainer) {
                                // Reproducir video remoto
                                user.videoTrack.play(remoteVideoContainer);
                                console.log('Video remoto reproducido correctamente');
                                
                                // Ocultar indicador de carga
                                if (remoteVideoLoading) {
                                    remoteVideoLoading.classList.add('hidden');
                                }
                            } else {
                                console.error('Contenedor de video remoto no encontrado');
                            }
                        }
                        
                        // Manejar stream de audio remoto
                        if (mediaType === 'audio') {
                            user.audioTrack.play();
                        }
                    });
                    
                    // Manejar desconexión de usuario remoto
                    rtcClient.on('user-unpublished', (user, mediaType) => {
                        if (mediaType === 'video') {
                            delete remoteUsers[user.uid];
                        }
                    });
                }
                
                // Solicitar permisos de cámara y micrófono
                try {
                    // Si aún no tenemos tracks locales, crearlos
                    if (!localTracks.videoTrack || !localTracks.audioTrack) {
                        const [audioTrack, videoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
                        localTracks.audioTrack = audioTrack;
                        localTracks.videoTrack = videoTrack;
                        
                        // Mostrar video local
                        if (localVideoContainer) {
                            videoTrack.play(localVideoContainer);
                        }
                    }
                    
                    // Unirse al canal
                    const uid = await rtcClient.join(APP_ID, CHANNEL_NAME, TOKEN, window.authId);
                    console.log('Unido al canal con UID:', uid);
                    
                    // Publicar tracks locales
                    await rtcClient.publish([localTracks.audioTrack, localTracks.videoTrack]);
                    console.log('Tracks locales publicados');
                    
                    isCallActive = true;
                    
                    // Emitir evento para notificar al otro usuario
                    if (socket) {
                        socket.emit('call-user', {
                            to: window.otherUserId,
                            from: window.authId,
                            chatId: window.chatId
                        });
                    } else {
                        console.error('Error: Socket.io no está disponible para señalización');
                        showErrorNotification('No se pudo iniciar la llamada: error de conexión');
                    }
                    
                    if (callStatus) {
                        callStatus.textContent = 'Llamando...';
                    }
                } catch (error) {
                    console.error('Error al acceder a la cámara o micrófono:', error);
                    showErrorNotification('No se pudo acceder a la cámara o micrófono. Por favor, verifica los permisos.');
                    if (callStatus) {
                        callStatus.textContent = 'Error al iniciar la cámara';
                    }
                }
            } catch (error) {
                console.error('Error al iniciar la videollamada:', error);
                showErrorNotification('Error al iniciar la videollamada: ' + error.message);
                if (callStatus) {
                    callStatus.textContent = 'Error al iniciar la llamada';
                }
            }
        }
    }
    
    function showIncomingCall() {
        if (incomingCall) {
            incomingCall.classList.remove('hidden');
        }
    }
    
    // También actualizar aceptarIncomingCall para usar setup
    async function acceptIncomingCall() {
        if (incomingCall) {
            incomingCall.classList.add('hidden');
        }
        
        // Inicializar interfaz
        initCallInterface();
        
        try {
            // Inicializar cliente Agora si es necesario
            if (!rtcClient && typeof AgoraRTC !== 'undefined') {
                rtcClient = AgoraRTC.createClient({
                    mode: 'rtc',
                    codec: 'vp8'
                });
                
                // Configurar evento para manejar usuario remoto
                rtcClient.on('user-published', async (user, mediaType) => {
                    // Suscribirse al usuario remoto
                    await rtcClient.subscribe(user, mediaType);
                    console.log('Suscrito a usuario remoto');
                    
                    // Manejar stream de video remoto
                    if (mediaType === 'video') {
                        remoteUsers[user.uid] = user;
                        
                        // Verificar si el elemento remoteVideoContainer existe
                        if (remoteVideoContainer) {
                            // Reproducir video remoto
                            user.videoTrack.play(remoteVideoContainer);
                            console.log('Video remoto reproducido correctamente');
                            
                            // Ocultar indicador de carga
                            if (remoteVideoLoading) {
                                remoteVideoLoading.classList.add('hidden');
                            }
                        } else {
                            console.error('Contenedor de video remoto no encontrado');
                        }
                    }
                    
                    // Manejar stream de audio remoto
                    if (mediaType === 'audio') {
                        user.audioTrack.play();
                    }
                });
                
                // Manejar desconexión de usuario remoto
                rtcClient.on('user-unpublished', (user, mediaType) => {
                    if (mediaType === 'video') {
                        delete remoteUsers[user.uid];
                    }
                });
            }
            
            // Si aún no tenemos tracks locales, crearlos
            if (!localTracks.videoTrack || !localTracks.audioTrack) {
                const [audioTrack, videoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
                localTracks.audioTrack = audioTrack;
                localTracks.videoTrack = videoTrack;
                
                // Mostrar video local
                if (localVideoContainer) {
                    videoTrack.play(localVideoContainer);
                }
            }
            
            // Unirse al canal
            const uid = await rtcClient.join(APP_ID, CHANNEL_NAME, TOKEN, window.authId);
            console.log('Unido al canal con UID:', uid);
            
            // Publicar tracks locales
            await rtcClient.publish([localTracks.audioTrack, localTracks.videoTrack]);
            console.log('Tracks locales publicados');
            
            isCallActive = true;
            
            // Responder a la llamada por socket
            if (socket) {
                socket.emit('accept-call', {
                    to: window.otherUserId,
                    from: window.authId,
                    chatId: window.chatId
                });
            } else {
                console.error('Error: Socket.io no está disponible para señalización');
                showErrorNotification('No se pudo aceptar la llamada: error de conexión');
            }
            
            if (callStatus) {
                callStatus.textContent = 'Conectado';
            }
            
        } catch (error) {
            console.error('Error al aceptar la llamada:', error);
            if (callStatus) {
                callStatus.textContent = 'Error al conectar';
            }
        }
    }
    
    function rejectIncomingCall() {
        if (incomingCall) {
            incomingCall.classList.add('hidden');
        }
        
        if (socket) {
            socket.emit('reject-call', {
                to: window.otherUserId,
                from: window.authId,
                chatId: window.chatId
            });
        } else {
            console.error('Error: Socket.io no está disponible para señalización');
        }
    }
    
    function toggleMicrophone() {
        if (localTracks.audioTrack) {
            const enabled = !localTracks.audioTrack.muted;
            localTracks.audioTrack.setMuted(enabled);
            
            // Actualizar UI
            if (toggleAudio) {
                toggleAudio.innerHTML = enabled ? 
                    '<i class="fas fa-microphone-slash"></i>' : 
                    '<i class="fas fa-microphone"></i>';
            }
        }
    }
    
    function toggleCamera() {
        if (localTracks.videoTrack) {
            const enabled = !localTracks.videoTrack.muted;
            localTracks.videoTrack.setMuted(enabled);
            
            // Actualizar UI
            if (toggleVideo) {
                toggleVideo.innerHTML = enabled ? 
                    '<i class="fas fa-video-slash"></i>' : 
                    '<i class="fas fa-video"></i>';
            }
        }
    }
    
    async function endActiveCall() {
        // Notificar al otro usuario
        if (socket) {
            socket.emit('end-call', {
                to: window.otherUserId,
                from: window.authId,
                chatId: window.chatId
            });
        }
        
        // Limpiar recursos
        if (rtcClient) {
            await rtcClient.leave();
        }
        
        // Detener y liberar tracks locales
        if (localTracks.audioTrack) {
            localTracks.audioTrack.stop();
            localTracks.audioTrack.close();
        }
        
        if (localTracks.videoTrack) {
            localTracks.videoTrack.stop();
            localTracks.videoTrack.close();
        }
        
        // Reiniciar variables
        localTracks.audioTrack = null;
        localTracks.videoTrack = null;
        remoteUsers = {};
        isCallActive = false;
        
        // Ocultar interfaz de videollamada
        if (videoContainer) {
            videoContainer.classList.add('hidden');
        }
    }
    
    function toggleMinimize() {
        isMinimized = !isMinimized;
        videoContainer.classList.toggle('minimized');
        closeVideoContainer.textContent = isMinimized ? 'Maximizar' : 'Minimizar';
    }
}); 