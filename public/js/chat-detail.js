// Función para crear el HTML de un mensaje
function createMessageHtml(message) {
    const isCurrentUser = message.user_id === parseInt(document.querySelector('meta[name="user-id"]').content);
    return `
        <div class="flex items-start message ${isCurrentUser ? 'justify-end' : ''} mb-4" data-message-id="${message.id}">
            ${!isCurrentUser ? `
                <div class="flex-shrink-0 mr-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden shadow-md">
                        ${message.user.imagen ? `
                            <img src="/profile_images/${message.user.imagen}"
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
                        ${message.contenido}
                    </p>
                    <div class="text-xs ${isCurrentUser ? 'text-white/80' : 'text-gray-500'} mt-1 flex items-center justify-between">
                        <span>${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
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
    
    // Inicializar funcionalidades
    initAutoExpandTextarea();
    
    // Función para desplazamiento suave
    function smoothScrollToBottom() {
        const scrollHeight = chatMessages.scrollHeight;
        const duration = 300; // ms
        const start = chatMessages.scrollTop;
        const end = scrollHeight - chatMessages.clientHeight;
        const change = end - start;
        let startTime = null;
        
        function animateScroll(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easeProgress = 0.5 - Math.cos(progress * Math.PI) / 2; // Función de aceleración
            
            chatMessages.scrollTop = start + change * easeProgress;
            
            if (progress < 1) {
                window.requestAnimationFrame(animateScroll);
            }
        }
        
        window.requestAnimationFrame(animateScroll);
    }
    
    // Verificar si el scroll está al final
    function isAtBottom() {
        const tolerance = 50; // pixels
        return (chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight) < tolerance;
    }
    
    // Mostrar indicador de nuevo mensaje
    function showNewMessageIndicator() {
        if (document.querySelectorAll('.animate-fadeIn').length > 0) {
            unreadIndicator.classList.add('show');
        }
    }
    
    // Ocultar indicador de nuevo mensaje al hacer clic en él
    unreadIndicator.addEventListener('click', function() {
        smoothScrollToBottom();
        this.classList.remove('show');
    });
    
    // Ocultar indicador al hacer scroll manualmente al fondo
    chatMessages.addEventListener('scroll', function() {
        if (isAtBottom()) {
            unreadIndicator.classList.remove('show');
        }
    });
    
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
                    
                    // Añadir mensaje a la vista con animación
                    if (chatMessages && data.mensaje) {
                        chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(data.mensaje));
                        lastMessageId = data.mensaje.id;
                        
                        // Desplazamiento suave al último mensaje
                        smoothScrollToBottom();
                        
                        // Mostrar pequeña animación de "enviado"
                        showSentAnimation();
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
    
    // Actualizar mensajes cada 3 segundos
    setInterval(updateMessages, 3000);
    
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
    
    // Función para actualizar el estado de conexión visual
    function updateConnectionStatus(status) {
        if (!connectionStatus) return;
        
        switch(status) {
            case 'connecting':
                connectionStatus.className = 'w-2 h-2 rounded-full bg-yellow-500 mr-2';
                break;
            case 'connected':
                connectionStatus.className = 'w-2 h-2 rounded-full bg-green-500 mr-2';
                break;
            case 'error':
                connectionStatus.className = 'w-2 h-2 rounded-full bg-red-500 mr-2';
                break;
            default:
                connectionStatus.className = 'w-2 h-2 rounded-full bg-gray-500 mr-2';
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