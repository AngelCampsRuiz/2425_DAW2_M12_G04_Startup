document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const removeFile = document.getElementById('remove-file');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const emojiButton = document.getElementById('emoji-button');
    const chatId = window.chatId;
    let lastMessageId = window.lastMessageId;
    let isTyping = false;
    let typingTimeout;
    
    // Crear el indicador de mensajes no leídos
    const unreadIndicator = document.createElement('div');
    unreadIndicator.className = 'unread-indicator';
    unreadIndicator.innerHTML = '<i class="fas fa-arrow-down mr-2"></i> Nuevos mensajes';
    document.body.appendChild(unreadIndicator);
    
    // Crear el contenedor del selector de emojis
    const emojiPicker = document.createElement('div');
    emojiPicker.className = 'emoji-picker';
    emojiPicker.innerHTML = `
        <div class="emoji-grid">
            <div class="emoji-item">😊</div>
            <div class="emoji-item">😂</div>
            <div class="emoji-item">❤️</div>
            <div class="emoji-item">👍</div>
            <div class="emoji-item">🎉</div>
            <div class="emoji-item">🔥</div>
            <div class="emoji-item">😍</div>
            <div class="emoji-item">🤔</div>
            <div class="emoji-item">😎</div>
            <div class="emoji-item">👋</div>
            <div class="emoji-item">🙏</div>
            <div class="emoji-item">👏</div>
            <div class="emoji-item">🤝</div>
            <div class="emoji-item">💯</div>
            <div class="emoji-item">⭐</div>
            <div class="emoji-item">💪</div>
            <div class="emoji-item">🤣</div>
            <div class="emoji-item">😢</div>
        </div>
    `;
    
    // Verificar que exista el contenedor antes de añadir el selector de emojis
    const relativeContainer = document.querySelector('.relative');
    if (relativeContainer) {
        relativeContainer.appendChild(emojiPicker);
        
        // Toggle del selector de emojis
        if (emojiButton) {
            emojiButton.addEventListener('click', function() {
                emojiPicker.classList.toggle('show');
            });
        }
        
        // Cerrar el selector de emojis al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (emojiButton && !emojiButton.contains(e.target) && !emojiPicker.contains(e.target)) {
                emojiPicker.classList.remove('show');
            }
        });
        
        // Insertar emoji seleccionado
        document.querySelectorAll('.emoji-item').forEach(item => {
            item.addEventListener('click', function() {
                messageInput.value += this.textContent;
                messageInput.focus();
                // Disparar evento input para activar autoexpand
                messageInput.dispatchEvent(new Event('input'));
                emojiPicker.classList.remove('show');
            });
        });
    } else {
        console.warn('No se encontró el contenedor para el selector de emojis');
    }
    
    // Hacer scroll al último mensaje con animación
    if (chatMessages) {
        smoothScrollToBottom();
    }
    
    // Inicializar textarea autoexpandible
    if (messageInput) {
        initAutoExpandTextarea();
    }
    
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
    
    // Función para inicializar textarea autoexpandible
    function initAutoExpandTextarea() {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Mostrar contador de caracteres cuando se escribe
            const currentLength = this.value.length;
            const maxLength = 500;
            const lengthIndicator = document.querySelector('.message-length');
            
            if (currentLength > 0) {
                lengthIndicator.classList.remove('hidden');
                document.getElementById('current-length').textContent = currentLength;
                
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
            
            // Emitir evento de "está escribiendo"
            if (!isTyping) {
                isTyping = true;
                // Aquí se podría emitir un evento al servidor
            }
            
            // Reiniciar timeout de escritura
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
                // Aquí se podría emitir un evento al servidor
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
    
    // Manejar la previsualización de archivos con animación
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const file = this.files[0];
            fileName.textContent = file.name;
            
            // Añadir información de tamaño
            const fileSizeKB = Math.round(file.size / 1024);
            const fileSizeText = fileSizeKB < 1024 ? 
                `${fileSizeKB} KB` : 
                `${(fileSizeKB / 1024).toFixed(1)} MB`;
                
            fileName.textContent = `${file.name} (${fileSizeText})`;
            
            filePreview.classList.remove('hidden');
            filePreview.classList.add('animate-slideUp');
            
            // Si es imagen, mostrar una previsualización
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreviewContainer.classList.add('hidden');
            }
        } else {
            clearFileInput();
        }
    });
    
    // Eliminar archivo seleccionado con animación
    removeFile.addEventListener('click', function() {
        filePreview.classList.add('animate-fadeOut');
        setTimeout(() => clearFileInput(), 300);
    });
    
    function clearFileInput() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        filePreview.classList.remove('animate-slideUp', 'animate-fadeOut');
        fileName.textContent = '';
        imagePreviewContainer.classList.add('hidden');
    }
    
    // Actualizar los indicadores de lectura
    function updateReadStatus(messages) {
        messages.forEach(message => {
            if (message.user_id === window.authId) {
                const statusElement = document.querySelector(`.message-status[data-message-id="${message.id}"] i`);
                if (statusElement && message.leido) {
                    statusElement.classList.remove('opacity-60', 'fa-check');
                    statusElement.classList.add('fa-check-double');
                }
            }
        });
    }
    
    // Función para crear el HTML de un mensaje con animaciones
    function createMessageHtml(mensaje) {
        const isMine = mensaje.user_id === window.authId;
        let messageContent = '';
        
        if (mensaje.contenido) {
            messageContent += `<p class="text-sm leading-relaxed">${mensaje.contenido}</p>`;
        }
        
        if (mensaje.archivo_adjunto) {
            messageContent += '<div class="mt-2">';
            
            if (mensaje.tipo_archivo && mensaje.tipo_archivo.startsWith('image/')) {
                messageContent += `
                    <div class="mt-2 relative group overflow-hidden rounded-lg shadow-sm">
                        <img src="${mensaje.archivo_adjunto}" 
                             alt="Imagen adjunta" 
                             class="max-w-full h-auto rounded-lg max-h-64 cursor-pointer transition-transform duration-500 transform hover:scale-105"
                             onclick="window.open('${mensaje.archivo_adjunto}', '_blank')">
                        <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="${mensaje.archivo_adjunto}" 
                               download="${mensaje.nombre_archivo}"
                               class="bg-white p-2 rounded-full shadow-md text-[#5e0490] transform transition-all duration-300 hover:rotate-12 hover:scale-110">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                `;
            } else {
                // Calcular tamaño aproximado del archivo
                const fileSizeKB = Math.round(mensaje.nombre_archivo.length * 10);
                
                messageContent += `
                    <div class="flex items-center gap-3 p-3 rounded-xl ${isMine ? 'bg-purple-200 bg-opacity-20' : 'bg-purple-50'} backdrop-blur-sm transition-transform duration-300 transform hover:scale-102">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt text-2xl ${isMine ? 'text-purple-100' : 'text-[#5e0490]'}"></i>
                        </div>
                        <div class="flex-grow overflow-hidden text-sm ${isMine ? 'text-purple-100' : 'text-gray-700'}">
                            <p class="truncate font-medium">${mensaje.nombre_archivo}</p>
                            <p class="text-xs ${isMine ? 'text-purple-200' : 'text-gray-500'}">
                                ${fileSizeKB} KB
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="${mensaje.archivo_adjunto}" 
                               download="${mensaje.nombre_archivo}"
                               class="${isMine ? 'bg-purple-300 bg-opacity-30 text-white' : 'bg-purple-100 text-[#5e0490]'} p-2 rounded-full hover:bg-opacity-100 transition-all duration-300 block">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                `;
            }
            
            messageContent += '</div>';
        }
        
        // Estado de lectura
        let readStatus = '';
        if (isMine) {
            const readIcon = mensaje.leido ? 
                '<i class="fas fa-check-double text-xs text-purple-200"></i>' : 
                '<i class="fas fa-check text-xs text-purple-200 opacity-60"></i>';
            
            readStatus = `
                <span class="message-status flex items-center" data-message-id="${mensaje.id}">
                    ${readIcon}
                </span>
            `;
        }
        
        messageContent += `
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs ${isMine ? 'text-purple-200' : 'text-gray-500'} flex items-center">
                    <span>${new Date(mensaje.fecha_envio).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                </p>
                ${isMine ? readStatus : ''}
            </div>
        `;
        
        return `
            <div class="flex ${isMine ? 'justify-end' : 'justify-start'} animate-fadeIn">
                <div class="group max-w-xs md:max-w-md lg:max-w-lg ${isMine ? 'bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white' : 'bg-white text-gray-800 border border-gray-200'} rounded-2xl px-4 py-3 shadow-md transform transition-all duration-300 hover:shadow-lg ${isMine ? 'hover:-translate-y-1 hover:scale-102' : 'hover:-translate-y-1 hover:scale-102'}">
                    ${messageContent}
                </div>
            </div>
        `;
    }
    
    // Función para actualizar los mensajes con animaciones
    function updateMessages() {
        if (!window.routeGetMessages) {
            console.error('Error: No se encontró la URL para obtener mensajes');
            return;
        }
        
        console.log('Solicitando mensajes de:', window.routeGetMessages);
        
        fetch(window.routeGetMessages)
            .then(response => {
                if (!response.ok) {
                    console.error('Error en la respuesta del servidor:', response.status, response.statusText);
                    throw new Error('El servidor respondió con un error: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Mensajes recibidos:', data);
                
                if (!data.error && data.mensajes && data.mensajes.length > 0) {
                    // Actualizar el estado de lectura de los mensajes existentes
                    updateReadStatus(data.mensajes);
                    
                    const newMessages = data.mensajes.filter(mensaje => mensaje.id > lastMessageId);
                    console.log('Nuevos mensajes:', newMessages.length);
                    
                    if (newMessages.length > 0) {
                        const wasAtBottom = isAtBottom();
                        
                        newMessages.forEach(mensaje => {
                            if (chatMessages) {
                                chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(mensaje));
                            }
                        });
                        
                        lastMessageId = newMessages[newMessages.length - 1].id;
                        
                        // Solo hacer scroll si ya estaba en el fondo
                        if (wasAtBottom && chatMessages) {
                            smoothScrollToBottom();
                        } else {
                            // Mostrar indicador de nuevos mensajes
                            showNewMessageIndicator();
                            
                            // Mostrar notificación temporal
                            if (newMessages[0].user_id !== window.authId) {
                                showMessageNotification(newMessages[0]);
                            }
                        }
                    }
                } else if (data.error) {
                    console.error('Error al obtener mensajes:', data.error);
                }
            })
            .catch(error => {
                console.error('Error al actualizar mensajes:', error);
            });
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
            
            const content = messageInput ? messageInput.value.trim() : '';
            const hasFile = fileInput && fileInput.files.length > 0;
            
            if (!content && !hasFile) return;
            
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
            
            // Crear FormData para enviar el contenido y archivo
            const formData = new FormData();
            if (content) {
                formData.append('contenido', content);
            }
            
            if (hasFile) {
                formData.append('archivo', fileInput.files[0]);
            }
            
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
                    clearFileInput();
                    
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
                    if (callStatus) {
                        callStatus.textContent = 'Error al iniciar la cámara';
                    }
                }
            } catch (error) {
                console.error('Error al iniciar la videollamada:', error);
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