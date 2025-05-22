// Archivo para manejar videollamadas
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando módulo de videollamada...');
    
    // Verificación de seguridad - Comprobamos que estamos en la página de chat y no en otra
    const chatMessagesElement = document.getElementById('chat-messages');
    if (!chatMessagesElement) {
        console.log('No estamos en la página de chat, no se inicializa la videollamada');
        return;
    }
    
    // Verificar variables globales críticas
    if (typeof window.chatId === 'undefined' || 
        typeof window.authId === 'undefined' || 
        typeof window.otherUserId === 'undefined') {
        console.error('Error: Variables globales críticas no disponibles', {
            chatId: typeof window.chatId !== 'undefined',
            authId: typeof window.authId !== 'undefined',
            otherUserId: typeof window.otherUserId !== 'undefined'
        });
        // Desactivar botón de videollamada si existe
        const videoCallBtn = document.getElementById('video-call-btn');
        if (videoCallBtn) {
            videoCallBtn.classList.add('opacity-50', 'cursor-not-allowed');
            videoCallBtn.title = 'Videollamada no disponible - falta configuración';
            videoCallBtn.disabled = true;
        }
        return;
    }
    
    // Referencias a elementos DOM
    const videoCallBtn = document.getElementById('video-call-btn');
    const videoContainer = document.getElementById('video-container');
    const closeVideoContainer = document.getElementById('close-video-container');
    const toggleAudio = document.getElementById('toggle-audio');
    const toggleVideo = document.getElementById('toggle-video');
    const endCall = document.getElementById('end-call');
    const localVideoContainer = document.getElementById('local-video-container');
    const localVideo = document.getElementById('local-video');
    const remoteVideoContainer = document.getElementById('remote-video-container');
    const remoteVideo = document.getElementById('remote-video');
    const remoteVideoLoading = document.getElementById('remote-video-loading');
    const callStatus = document.getElementById('call-status');
    const callTimer = document.getElementById('call-timer');
    const connectionStatus = document.getElementById('connection-status');
    const incomingCall = document.getElementById('incoming-call');
    const acceptCall = document.getElementById('accept-call');
    const rejectCall = document.getElementById('reject-call');
    const shareScreen = document.getElementById('share-screen');
    const openWhiteboard = document.getElementById('open-whiteboard');
    const openSettings = document.getElementById('open-settings');
    const toggleChat = document.getElementById('toggle-chat');
    
    // Desactivar los botones que no implementaremos por ahora
    if (shareScreen) shareScreen.classList.add('opacity-50', 'cursor-not-allowed');
    if (openWhiteboard) openWhiteboard.classList.add('opacity-50', 'cursor-not-allowed');
    if (openSettings) openSettings.classList.add('opacity-50', 'cursor-not-allowed');
    if (toggleChat) toggleChat.classList.add('opacity-50', 'cursor-not-allowed');

    // Verificación de elementos DOM esenciales para videollamada
    const essentialElements = {
        videoCallBtn,
        videoContainer,
        localVideo,
        remoteVideo
    };

    // Registro de elementos encontrados/faltantes
    let missingElements = [];
    for (const [name, element] of Object.entries(essentialElements)) {
        if (!element) {
            missingElements.push(name);
        }
    }

    console.log('Estado de los elementos DOM:', {
        videoCallBtn: !!videoCallBtn,
        videoContainer: !!videoContainer,
        localVideo: !!localVideo,
        remoteVideo: !!remoteVideo,
        incomingCall: !!incomingCall,
        missingElements: missingElements.length > 0 ? missingElements : 'Ninguno'
    });

    // Variables para la videollamada
    let rtcClient = null;
    let localTracks = {
        videoTrack: null,
        audioTrack: null
    };
    let remoteUsers = {};
    let isCallActive = false;
    let isMinimized = false;
    let callStartTime;
    let timerInterval;
    let socket = null;
    
    // Verificar que Agora.io está disponible
    const isAgoraAvailable = typeof AgoraRTC !== 'undefined';
    console.log('Estado de Agora RTC SDK:', isAgoraAvailable ? 'Disponible' : 'No disponible');
    
    // Si Agora no está disponible, cargar dinámicamente
    if (!isAgoraAvailable) {
        console.warn('Agora RTC SDK no detectado. Intentando cargar dinámicamente...');
        
        // Deshabilitar momentáneamente el botón
        if (videoCallBtn) {
            videoCallBtn.disabled = true;
            videoCallBtn.classList.add('opacity-50');
            
            // Mostrar indicador de carga
            const oldHtml = videoCallBtn.innerHTML;
            videoCallBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i><span>Cargando SDK...</span>';
            
            // Cargar el script dinámicamente
            const script = document.createElement('script');
            script.src = 'https://download.agora.io/sdk/release/AgoraRTC_N-4.14.1.js';
            script.async = true;
            
            script.onload = function() {
                console.log('Agora RTC SDK cargado dinámicamente');
                videoCallBtn.disabled = false;
                videoCallBtn.classList.remove('opacity-50');
                videoCallBtn.innerHTML = oldHtml;
                
                // Reinicializar el módulo después de cargar
                initVideoCallFeatures();
            };
            
            script.onerror = function() {
                console.error('Error al cargar Agora RTC SDK');
                videoCallBtn.innerHTML = oldHtml;
                videoCallBtn.title = 'Error al cargar SDK de videollamada';
                videoCallBtn.disabled = true;
                videoCallBtn.classList.add('opacity-50', 'cursor-not-allowed');
            };
            
            document.head.appendChild(script);
        } else {
            console.error('No se encontró el botón de videollamada para actualizar su estado');
        }
        return; // No continuamos hasta que el SDK esté cargado
    }
    
    // Configuración de Agora
    const APP_ID = "ff42e2de41ee4ec7b9bfe51d3d9b4edd"; // App ID de Agora
    const CHANNEL_NAME = window.chatId ? "chat_" + window.chatId : "chat_channel";
    const TOKEN = null; // Para producción, debes generar tokens en tu servidor
    
    // Comprobar si tenemos los IDs necesarios
    const authId = window.authId || null;
    const otherUserId = window.otherUserId || null;
    const chatId = window.chatId || null;
    
    // Inicializar las funciones de videollamada si todo está en orden
    initVideoCallFeatures();
    
    // Función principal de inicialización de videollamada
    function initVideoCallFeatures() {
        // Comprobar si todos los elementos esenciales están disponibles
        const isVideoCallAvailable = missingElements.length === 0 && 
                                    authId && 
                                    otherUserId && 
                                    chatId && 
                                    typeof AgoraRTC !== 'undefined';
        
        console.log('Estado de la funcionalidad de videollamada:', 
                    isVideoCallAvailable ? 'Disponible' : 'No disponible');
        
        // Si no están todos los elementos necesarios, deshabilitamos la videollamada
        if (!isVideoCallAvailable) {
            console.warn('La funcionalidad de videollamada no está disponible debido a componentes faltantes.');
            if (videoCallBtn) {
                videoCallBtn.classList.add('opacity-50', 'cursor-not-allowed');
                videoCallBtn.title = 'Videollamada no disponible - faltan componentes';
                videoCallBtn.disabled = true;
            }
            return;
        }
        
        // Verificamos que todo esté listo y habilitamos el botón
        if (videoCallBtn) {
            videoCallBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            videoCallBtn.disabled = false;
            videoCallBtn.title = 'Iniciar videollamada';
        }
        
        // Inicializar eventos solo si la videollamada está disponible
        if (isVideoCallAvailable) {
            console.log('Inicializando sistema de videollamadas...');
            
            // Event listeners para los botones de control
            if (videoCallBtn) {
                videoCallBtn.addEventListener('click', startVideoCall);
                console.log('Evento de clic registrado para botón de videollamada');
            } else {
                console.error('No se pudo encontrar el botón de videollamada para asignar evento');
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
            
            // Inicialización del canal y los eventos de Pusher
            initPusherEvents();
        }
    }
    
    // Funciones de la videollamada
    function initPusherEvents() {
        if (!window.Echo) {
            console.error('Error: Laravel Echo no está disponible. Verifica que esté correctamente inicializado.');
            return;
        }
        
        try {
            // Canal privado para llamadas, usando window.authId como identificador único
            console.log(`Suscribiéndose al canal privado: user.${authId}`);
            window.Echo.private(`user.${authId}`)
                .listen('.incoming.call', (data) => {
                    console.log('Evento IncomingCall recibido por Pusher:', data);
                    if (data.chatId == chatId) {
                        showIncomingCall();
                    }
                })
                .listen('.call.accepted', (data) => {
                    console.log('Evento CallAccepted recibido por Pusher:', data);
                    if (data.chatId == chatId && callStatus) {
                        callStatus.textContent = 'Conectado';
                        callStatus.className = 'text-green-500';
                    }
                })
                .listen('.call.rejected', (data) => {
                    console.log('Evento CallRejected recibido por Pusher:', data);
                    if (data.chatId == chatId) {
                        endActiveCall();
                        if (callStatus) {
                            callStatus.textContent = 'Llamada rechazada';
                            callStatus.className = 'text-red-500';
                        }
                        showNotification('Llamada rechazada', 'error');
                    }
                })
                .listen('.call.ended', (data) => {
                    console.log('Evento CallEnded recibido por Pusher:', data);
                    if (data.chatId == chatId && isCallActive) {
                        if (callStatus) {
                            callStatus.textContent = 'Llamada finalizada';
                            callStatus.className = 'text-gray-500';
                        }
                        endActiveCall();
                    }
                });
            
            console.log('Suscripción a eventos de Pusher para videollamadas exitosa');
        } catch (error) {
            console.error('Error al inicializar eventos de Pusher:', error);
        }
    }
    
    // Función para iniciar videollamada
    async function startVideoCall() {
        console.log('Función startVideoCall llamada');
        
        if (!isCallActive) {
            console.log('Iniciando videollamada...');
            
            if (videoContainer) {
                videoContainer.classList.remove('hidden');
            }
            
            if (callStatus) {
                callStatus.textContent = 'Conectando...';
                callStatus.className = 'text-yellow-500';
            }
            
            try {
                // Inicializar el cliente Agora RTC
                rtcClient = AgoraRTC.createClient({
                    mode: 'rtc',
                    codec: 'vp8'
                });
                
                console.log('Cliente Agora RTC inicializado');
                
                // Eventos para manejo de usuarios remotos
                rtcClient.on('user-published', async (user, mediaType) => {
                    console.log(`Usuario ${user.uid} publicó ${mediaType}`);
                    await rtcClient.subscribe(user, mediaType);
                    
                    if (mediaType === 'video' && remoteVideo) {
                        remoteUsers[user.uid] = user;
                        user.videoTrack.play(remoteVideo);
                        console.log('Video remoto reproducido');
                        
                        if (remoteVideoLoading) {
                            remoteVideoLoading.classList.add('hidden');
                        }
                    }
                    
                    if (mediaType === 'audio') {
                        user.audioTrack.play();
                        console.log('Audio remoto reproducido');
                    }
                });
                
                rtcClient.on('user-unpublished', (user, mediaType) => {
                    console.log(`Usuario ${user.uid} dejó de publicar ${mediaType}`);
                    if (mediaType === 'video') {
                        delete remoteUsers[user.uid];
                    }
                });
                
                // IMPORTANTE: Crear tracks de audio y video con opciones simples
                console.log('Solicitando acceso a cámara y micrófono...');
                
                const [audioTrack, videoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
                
                console.log('Tracks de audio y video creados correctamente');
                localTracks.audioTrack = audioTrack;
                localTracks.videoTrack = videoTrack;
                
                // Mostrar video local
                if (localVideo) {
                    videoTrack.play(localVideo);
                    console.log('Video local reproducido');
                }
                
                // Mostrar estado de conexión como conectado
                if (connectionStatus) {
                    connectionStatus.className = 'w-2 h-2 rounded-full bg-green-500 mr-2';
                }
                
                // Unirse al canal
                console.log(`Uniéndose al canal ${CHANNEL_NAME} con UID ${authId}`);
                const uid = await rtcClient.join(APP_ID, CHANNEL_NAME, TOKEN, authId);
                console.log(`Unido al canal con UID: ${uid}`);
                
                // Publicar tracks
                await rtcClient.publish([audioTrack, videoTrack]);
                console.log('Tracks de audio y video publicados');
                
                isCallActive = true;
                
                // Enviar notificación de llamada usando Pusher
                if (window.Echo) {
                    try {
                        window.Echo.private(`user.${otherUserId}`)
                            .whisper('incomingCall', {
                                from: authId,
                                chatId: chatId
                            });
                        
                        console.log('Notificación de llamada enviada por Pusher a usuario:', otherUserId);
                    } catch (error) {
                        console.error('Error al enviar notificación de llamada por Pusher:', error);
                        showNotification('Error al notificar al otro usuario', 'error');
                    }
                } else {
                    console.error('Echo no está disponible para enviar notificación');
                    showNotification('Error de comunicación', 'error');
                }
                
                // Cambiar texto de estado
                if (callStatus) {
                    callStatus.textContent = 'Llamando...';
                    callStatus.className = 'text-yellow-500';
                }
                
                // Iniciar cronómetro de llamada
                startCallTimer();
                
            } catch (error) {
                console.error('Error al iniciar la videollamada:', error);
                showNotification('No se pudo acceder a la cámara o micrófono. Por favor, verifica los permisos: ' + error.message, 'error');
                
                if (callStatus) {
                    callStatus.textContent = 'Error al iniciar la cámara';
                    callStatus.className = 'text-red-500';
                }
                
                if (connectionStatus) {
                    connectionStatus.className = 'w-2 h-2 rounded-full bg-red-500 mr-2';
                }
                
                endActiveCall();
            }
        } else {
            console.log('La llamada ya está activa');
        }
    }
    
    // Mostrar notificación de llamada entrante
    function showIncomingCall() {
        console.log('Mostrando notificación de llamada entrante');
        if (incomingCall) {
            incomingCall.classList.remove('hidden');
            
            // Reproducir sonido de llamada
            try {
                const ringtone = new Audio('/sounds/ringtone.mp3');
                ringtone.loop = true;
                ringtone.play().catch(e => console.log('No se pudo reproducir el sonido:', e));
                
                // Guardar referencia para poder detenerlo
                window.currentRingtone = ringtone;
                
                // Función para detener el sonido cuando se acepte/rechace
                const stopRingtone = function() {
                    if (window.currentRingtone) {
                        window.currentRingtone.pause();
                        window.currentRingtone = null;
                    }
                };
                
                // Detener cuando se acepte o rechace
                if (acceptCall) acceptCall.addEventListener('click', stopRingtone, { once: true });
                if (rejectCall) rejectCall.addEventListener('click', stopRingtone, { once: true });
                
            } catch (error) {
                console.warn('No se pudo reproducir el sonido de llamada:', error);
            }
        } else {
            console.error('Elemento de llamada entrante no encontrado en el DOM');
            // Mostrar notificación alternativa
            showNotification('Llamada entrante', 'info');
        }
    }
    
    // Aceptar llamada entrante
    async function acceptIncomingCall() {
        console.log('Aceptando llamada entrante');
        
        // Detener sonido si está reproduciéndose
        if (window.currentRingtone) {
            window.currentRingtone.pause();
            window.currentRingtone = null;
        }
        
        if (incomingCall) {
            incomingCall.classList.add('hidden');
        }
        
        if (videoContainer) {
            videoContainer.classList.remove('hidden');
        }
        
        if (callStatus) {
            callStatus.textContent = 'Conectando...';
            callStatus.className = 'text-yellow-500';
        }
        
        try {
            // Inicializar cliente Agora
            rtcClient = AgoraRTC.createClient({
                mode: 'rtc',
                codec: 'vp8'
            });
            
            console.log('Cliente Agora RTC inicializado');
            
            // Eventos para manejo de usuarios remotos
            rtcClient.on('user-published', async (user, mediaType) => {
                console.log(`Usuario ${user.uid} publicó ${mediaType}`);
                await rtcClient.subscribe(user, mediaType);
                
                if (mediaType === 'video' && remoteVideo) {
                    remoteUsers[user.uid] = user;
                    user.videoTrack.play(remoteVideo);
                    console.log('Video remoto reproducido');
                    
                    if (remoteVideoLoading) {
                        remoteVideoLoading.classList.add('hidden');
                    }
                }
                
                if (mediaType === 'audio') {
                    user.audioTrack.play();
                    console.log('Audio remoto reproducido');
                }
            });
            
            rtcClient.on('user-unpublished', (user, mediaType) => {
                console.log(`Usuario ${user.uid} dejó de publicar ${mediaType}`);
                if (mediaType === 'video') {
                    delete remoteUsers[user.uid];
                }
            });
            
            // Obtener tracks locales
            console.log('Solicitando acceso a cámara y micrófono...');
            const [audioTrack, videoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
            
            localTracks.audioTrack = audioTrack;
            localTracks.videoTrack = videoTrack;
            console.log('Tracks de audio y video creados correctamente');
            
            // Mostrar video local
            if (localVideo) {
                videoTrack.play(localVideo);
                console.log('Video local reproducido');
            }
            
            // Mostrar estado de conexión como conectado
            if (connectionStatus) {
                connectionStatus.className = 'w-2 h-2 rounded-full bg-green-500 mr-2';
            }
            
            // Unirse al canal
            console.log(`Uniéndose al canal ${CHANNEL_NAME} con UID ${authId}`);
            const uid = await rtcClient.join(APP_ID, CHANNEL_NAME, TOKEN, authId);
            console.log(`Unido al canal con UID: ${uid}`);
            
            // Publicar tracks
            await rtcClient.publish([audioTrack, videoTrack]);
            console.log('Tracks de audio y video publicados');
            
            isCallActive = true;
            
            // Notificar aceptación
            if (window.Echo) {
                try {
                    window.Echo.private(`user.${otherUserId}`)
                        .whisper('callAccepted', {
                            from: authId,
                            chatId: chatId
                        });
                    
                    console.log('Notificación de aceptación enviada por Pusher a usuario:', otherUserId);
                } catch (error) {
                    console.error('Error al enviar notificación de aceptación por Pusher:', error);
                }
            } else {
                console.error('Echo no está disponible para enviar notificación');
            }
            
            if (callStatus) {
                callStatus.textContent = 'Conectado';
                callStatus.className = 'text-green-500';
            }
            
            // Iniciar cronómetro de llamada
            startCallTimer();
            
        } catch (error) {
            console.error('Error al aceptar la llamada:', error);
            showNotification('Error al iniciar la cámara: ' + error.message, 'error');
            
            if (callStatus) {
                callStatus.textContent = 'Error al conectar';
                callStatus.className = 'text-red-500';
            }
            
            if (connectionStatus) {
                connectionStatus.className = 'w-2 h-2 rounded-full bg-red-500 mr-2';
            }
        }
    }
    
    // Rechazar llamada entrante
    function rejectIncomingCall() {
        console.log('Rechazando llamada entrante');
        
        // Detener sonido si está reproduciéndose
        if (window.currentRingtone) {
            window.currentRingtone.pause();
            window.currentRingtone = null;
        }
        
        if (incomingCall) {
            incomingCall.classList.add('hidden');
        }
        
        // Notificar rechazo
        if (window.Echo) {
            try {
                window.Echo.private(`user.${otherUserId}`)
                    .whisper('callRejected', {
                        from: authId,
                        chatId: chatId
                    });
                
                console.log('Notificación de rechazo enviada por Pusher a usuario:', otherUserId);
            } catch (error) {
                console.error('Error al enviar notificación de rechazo por Pusher:', error);
            }
        } else {
            console.error('Echo no está disponible para enviar notificación');
        }
    }
    
    // Alternar micrófono
    function toggleMicrophone() {
        console.log('Alternando estado del micrófono');
        if (localTracks.audioTrack) {
            const enabled = !localTracks.audioTrack.muted;
            localTracks.audioTrack.setMuted(enabled);
            console.log('Micrófono ' + (enabled ? 'silenciado' : 'activado'));
            
            if (toggleAudio) {
                toggleAudio.innerHTML = enabled ? 
                    '<i class="fas fa-microphone-slash"></i>' : 
                    '<i class="fas fa-microphone"></i>';
            }
        } else {
            console.error('No hay track de audio para alternar');
        }
    }
    
    // Alternar cámara
    function toggleCamera() {
        console.log('Alternando estado de la cámara');
        if (localTracks.videoTrack) {
            const enabled = !localTracks.videoTrack.muted;
            localTracks.videoTrack.setMuted(enabled);
            console.log('Cámara ' + (enabled ? 'apagada' : 'encendida'));
            
            if (toggleVideo) {
                toggleVideo.innerHTML = enabled ? 
                    '<i class="fas fa-video-slash"></i>' : 
                    '<i class="fas fa-video"></i>';
            }
        } else {
            console.error('No hay track de video para alternar');
        }
    }
    
    // Cronómetro de llamada
    function startCallTimer() {
        if (callTimer) {
            callStartTime = new Date();
            
            // Limpiar intervalo anterior si existe
            if (timerInterval) {
                clearInterval(timerInterval);
            }
            
            // Actualizar cada segundo
            timerInterval = setInterval(() => {
                if (!isCallActive) {
                    clearInterval(timerInterval);
                    return;
                }
                
                const now = new Date();
                const diff = now - callStartTime;
                
                // Formato mm:ss
                const minutes = Math.floor(diff / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);
                
                callTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }
    }
    
    // Finalizar llamada
    async function endActiveCall() {
        console.log('Finalizando llamada activa');
        
        // Notificar fin de llamada
        if (isCallActive) {
            if (window.Echo) {
                try {
                    window.Echo.private(`user.${otherUserId}`)
                        .whisper('callEnded', {
                            from: authId,
                            chatId: chatId
                        });
                    
                    console.log('Notificación de fin de llamada enviada por Pusher a usuario:', otherUserId);
                } catch (error) {
                    console.error('Error al enviar notificación de fin de llamada por Pusher:', error);
                }
            }
        }
        
        // Detener cronómetro
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
        
        // Limpiar recursos
        if (rtcClient) {
            try {
                await rtcClient.leave();
                console.log('Cliente abandonó el canal');
            } catch (e) {
                console.error('Error al abandonar el canal:', e);
            }
            rtcClient = null;
        }
        
        // Detener y liberar tracks locales
        if (localTracks.audioTrack) {
            localTracks.audioTrack.stop();
            localTracks.audioTrack.close();
            console.log('Track de audio detenido y liberado');
        }
        
        if (localTracks.videoTrack) {
            localTracks.videoTrack.stop();
            localTracks.videoTrack.close();
            console.log('Track de video detenido y liberado');
        }
        
        // Reiniciar variables
        localTracks.audioTrack = null;
        localTracks.videoTrack = null;
        remoteUsers = {};
        isCallActive = false;
        
        // Resetear estado de conexión
        if (connectionStatus) {
            connectionStatus.className = 'w-2 h-2 rounded-full bg-yellow-500 mr-2';
        }
        
        // Resetear estado de llamada
        if (callStatus) {
            callStatus.textContent = 'Llamada finalizada';
            callStatus.className = 'text-gray-500';
        }
        
        // Resetear tiempo
        if (callTimer) {
            callTimer.textContent = '';
        }
        
        // Ocultar interfaz de videollamada
        if (videoContainer) {
            videoContainer.classList.add('hidden');
        }
        
        console.log('Llamada finalizada correctamente');
    }
    
    // Alternar minimizado
    function toggleMinimize() {
        console.log('Alternando tamaño de la ventana de videollamada');
        isMinimized = !isMinimized;
        
        if (videoContainer) {
            videoContainer.classList.toggle('minimized');
        }
        
        if (closeVideoContainer) {
            closeVideoContainer.textContent = isMinimized ? 'Maximizar' : 'Minimizar';
        }
    }
    
    // Mostrar notificación
    function showNotification(message, type = 'info') {
        console.log(`Mostrando notificación: ${message} (${type})`);
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 ${type === 'error' ? 'bg-red-500' : type === 'info' ? 'bg-blue-500' : 'bg-green-500'} text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fadeIn`;
        notification.innerHTML = `<i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : 'fa-check-circle'} mr-2"></i>${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-fadeOut');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 500);
        }, 4000);
    }
    
    // Manejador de cierres o recargas de ventana
    window.addEventListener('beforeunload', function(e) {
        if (isCallActive) {
            endActiveCall();
        }
    });
}); 