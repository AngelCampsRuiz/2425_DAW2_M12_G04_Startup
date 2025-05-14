// Variables globales
let socket;
let localStream;
let screenStream;
let isScreenSharing = false;
let peerConnection;
let currentUser = null;
let currentCall = null;
let onlineUsers = [];

// Configuración de WebRTC
const peerConfig = {
    iceServers: [
        { urls: 'stun:stun.l.google.com:19302' },
        { urls: 'stun:stun1.l.google.com:19302' }
    ]
};

// DOM Elements
const registerForm = document.getElementById('register-form');
const usernameInput = document.getElementById('username');
const registerCard = document.getElementById('register-card');
const mainSection = document.getElementById('main-section');
const usersList = document.getElementById('users-list');
const notifications = document.getElementById('notifications');
const localVideo = document.getElementById('local-video');
const remoteVideo = document.getElementById('remote-video');
const callControls = document.getElementById('call-controls');
const incomingCallControls = document.getElementById('incoming-call-controls');
const incomingCallText = document.getElementById('incoming-call-text');
const acceptCallBtn = document.getElementById('accept-call');
const rejectCallBtn = document.getElementById('reject-call');
const endCallBtn = document.getElementById('end-call');
const muteBtn = document.getElementById('mute-audio');
const disableVideoBtn = document.getElementById('disable-video');
const shareScreenBtn = document.getElementById('share-screen');
const callTitle = document.getElementById('call-title');
const callName = document.getElementById('call-name');
const chatBtn = document.getElementById('chat-btn');

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    // Configurar eventos
    registerForm.addEventListener('submit', registerUser);
    acceptCallBtn.addEventListener('click', acceptCall);
    rejectCallBtn.addEventListener('click', rejectCall);
    endCallBtn.addEventListener('click', endCall);
    muteBtn.addEventListener('click', muteAudio);
    disableVideoBtn.addEventListener('click', disableVideo);
    shareScreenBtn.addEventListener('click', toggleScreenSharing);
    
    // Nuevo botón de chat
    if (chatBtn) {
        chatBtn.addEventListener('click', toggleChat);
    }
});

// Función para registrar al usuario
async function registerUser(event) {
    event.preventDefault();
    
    const username = usernameInput.value.trim();
    if (!username) {
        showNotification('Por favor, introduce un nombre de usuario válido.', 'error');
        return;
    }

    try {
        // Solicitar permisos de cámara y micrófono
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;
        console.log("Cámara y micrófono accesibles");
        
        // Conectar al servidor mediante socket.io con manejo de errores mejorado
        console.log("Intentando conectar a Socket.io en http://localhost:3000");
        socket = io('http://localhost:3000', {
            reconnectionAttempts: 5,
            reconnectionDelay: 1000,
            timeout: 10000,
            transports: ['websocket', 'polling'] // Intentar primero websocket, luego polling
        });
        
        // Manejar errores de conexión
        socket.on('connect_error', (error) => {
            console.error('Error de conexión a Socket.io:', error);
            showNotification(`Error de conexión al servidor: ${error.message}`, 'error');
        });
        
        socket.on('connect', () => {
            console.log('Conectado a Socket.io con ID:', socket.id);
            
            // Solo registrar al usuario cuando estamos conectados
            socket.emit('register', username);
            currentUser = username;
            
            // Mostrar la interfaz principal
            registerCard.style.display = 'none';
            mainSection.style.display = 'block';
            
            showNotification(`Te has registrado como: ${username}`, 'success');
        });
        
        // Registrar eventos de socket
        setupSocketEvents();
        
    } catch (error) {
        showNotification(`Error al acceder a la cámara/micrófono: ${error.message}`, 'error');
        console.error('Error accessing media devices:', error);
    }
}

// Configurar eventos del socket
function setupSocketEvents() {
    // Cuando el registro es exitoso
    socket.on('register_response', ({ success, message }) => {
        if (success) {
            // El registro fue exitoso
            showNotification(message, 'success');
        } else {
            showNotification(message, 'error');
            // Volver a la pantalla de registro
            registerCard.style.display = 'block';
            mainSection.style.display = 'none';
            currentUser = null;
        }
    });
    
    // Cuando la lista de usuarios cambia
    socket.on('user_list', (users) => {
        updateUsersList(users);
    });
    
    // Cuando llega una llamada entrante
    socket.on('incoming_call', ({ from, signalData }) => {
        handleIncomingCall(from, signalData);
    });
    
    // Cuando se recibe una respuesta a una llamada
    socket.on('call_accepted', ({ answer }) => {
        handleCallAccepted(currentCall.with, answer);
    });
    
    // Cuando se recibe un candidato ICE
    socket.on('ice-candidate', ({ candidate }) => {
        handleNewICECandidate(candidate);
    });
    
    // Cuando una llamada es rechazada
    socket.on('call_rejected', ({ reason }) => {
        handleCallRejected(currentCall.with, reason);
    });
    
    // Cuando la otra persona finaliza la llamada
    socket.on('call_ended', () => {
        handleCallEnded(currentCall.with);
    });
}

// Actualizar la lista de usuarios
function updateUsersList(users) {
    onlineUsers = users.filter(user => user.username !== currentUser);
    
    usersList.innerHTML = '';
    
    if (onlineUsers.length === 0) {
        usersList.innerHTML = '<div class="p-3 text-center text-muted">No hay usuarios conectados</div>';
        return;
    }
    
    onlineUsers.forEach(user => {
        const userItem = document.createElement('div');
        userItem.className = 'user-item';
        userItem.dataset.username = user.username;
        
        const userInfo = document.createElement('div');
        userInfo.className = 'user-info';
        
        const userAvatar = document.createElement('div');
        userAvatar.className = 'user-avatar';
        userAvatar.textContent = user.username.charAt(0).toUpperCase();
        
        const userName = document.createElement('div');
        userName.className = 'user-name';
        userName.textContent = user.username;
        
        userInfo.appendChild(userAvatar);
        userInfo.appendChild(userName);
        
        const callBtn = document.createElement('button');
        callBtn.className = 'call-button';
        callBtn.innerHTML = '<i class="fas fa-phone-alt"></i>';
        callBtn.onclick = () => initiateCall(user.username);
        
        userItem.appendChild(userInfo);
        userItem.appendChild(callBtn);
        
        usersList.appendChild(userItem);
    });
}

// Mostrar notificación
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    notifications.appendChild(notification);
    
    // Eliminar la notificación después de 5 segundos
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Iniciar una llamada
async function initiateCall(toUsername) {
    if (currentCall) {
        showNotification('Ya tienes una llamada activa. Finaliza la llamada actual antes de iniciar una nueva.', 'warning');
        return;
    }
    
    try {
        // Desactivar temporalmente Agora y utilizar solo WebRTC básico
        if (typeof AgoraRTC !== 'undefined') {
            // Si se está utilizando Agora, podemos mostrar un mensaje
            showNotification('Para usar Agora, necesitas registrarte y obtener un APP_ID válido', 'warning');
            // Continuar con la llamada básica
        }
        
        // Crear una nueva conexión peer
        peerConnection = new RTCPeerConnection(peerConfig);
        
        // Añadir la transmisión local
        localStream.getTracks().forEach(track => {
            peerConnection.addTrack(track, localStream);
        });
        
        // Manejar los candidatos ICE
        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                socket.emit('ice-candidate', {
                    to: toUsername,
                    candidate: event.candidate
                });
            }
        };
        
        // Manejar la transmisión remota
        peerConnection.ontrack = (event) => {
            remoteVideo.srcObject = event.streams[0];
        };
        
        // Crear una oferta
        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        
        // Enviar la oferta al otro usuario
        socket.emit('call', {
            target: toUsername,
            signalData: peerConnection.localDescription
        });
        
        currentCall = {
            with: toUsername,
            status: 'calling'
        };
        
        showNotification(`Llamando a ${toUsername}...`, 'info');
        
    } catch (error) {
        showNotification(`Error al iniciar la llamada: ${error.message}`, 'error');
        console.error('Error initiating call:', error);
        resetCall();
    }
}

// Manejar una llamada entrante
async function handleIncomingCall(fromUsername, signalData) {
    if (currentCall) {
        // Automáticamente rechazar si ya estamos en una llamada
        socket.emit('reject', {
            from: fromUsername,
            reason: 'busy'
        });
        return;
    }
    
    // Registrar la llamada entrante
    currentCall = {
        from: fromUsername,
        status: 'incoming',
        signalData: signalData
    };
    
    // Mostrar controles de llamada entrante
    incomingCallControls.style.display = 'flex';
    incomingCallText.textContent = `Llamada entrante de ${fromUsername}`;
    
    // Reproducir sonido de llamada (si existe)
    if (window.ringtone) {
        window.ringtone.play();
    }
    
    showNotification(`Llamada entrante de ${fromUsername}`, 'info');
}

// Aceptar una llamada entrante
async function acceptCall() {
    if (!currentCall || currentCall.status !== 'incoming') {
        return;
    }
    
    try {
        // Crear la conexión peer
        peerConnection = new RTCPeerConnection(peerConfig);
        
        // Añadir la transmisión local
        localStream.getTracks().forEach(track => {
            peerConnection.addTrack(track, localStream);
        });
        
        // Manejar los candidatos ICE
        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                socket.emit('ice-candidate', {
                    to: currentCall.from,
                    candidate: event.candidate
                });
            }
        };
        
        // Manejar la transmisión remota
        peerConnection.ontrack = (event) => {
            remoteVideo.srcObject = event.streams[0];
        };
        
        // Establecer la descripción remota (oferta)
        await peerConnection.setRemoteDescription(currentCall.signalData);
        
        // Crear una respuesta
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        
        // Enviar la respuesta al llamante
        socket.emit('accept_call', {
            from: currentCall.from,
            signalData: peerConnection.localDescription
        });
        
        // Actualizar estado
        currentCall.status = 'connected';
        
        // Ocultar controles de llamada entrante y mostrar controles de llamada
        incomingCallControls.style.display = 'none';
        callControls.style.display = 'flex';
        callControls.style.zIndex = '100';
        
        document.getElementById('remote-user-name').textContent = currentCall.from;
        
        showNotification(`Llamada conectada con ${currentCall.from}`, 'success');
        
        // Actualizar título de la llamada
        updateCallInfo(currentCall.from);
        
        // Comprobación extra para depuración
        console.log("Controles de llamada activados en acceptCall:", callControls);
        console.log("Estado de visualización:", callControls.style.display);
    } catch (error) {
        showNotification(`Error al aceptar la llamada: ${error.message}`, 'error');
        console.error('Error accepting call:', error);
        resetCall();
    }
}

// Rechazar una llamada entrante
function rejectCall() {
    if (!currentCall || currentCall.status !== 'incoming') {
        return;
    }
    
    // Enviar rechazo al otro usuario
    socket.emit('reject', {
        from: currentCall.with
    });
    
    // Ocultar controles de llamada entrante
    incomingCallControls.style.display = 'none';
    
    showNotification(`Has rechazado la llamada de ${currentCall.with}`, 'info');
    
    // Restablecer la llamada
    resetCall();
}

// Manejar la aceptación de una llamada
async function handleCallAccepted(byUsername, answer) {
    try {
        if (!peerConnection) {
            console.error('No hay conexión peer activa');
            return;
        }
        
        // Establecer la descripción remota
        await peerConnection.setRemoteDescription(answer);
        
        // Actualizar el estado de la llamada
        currentCall.status = 'connected';
        
        // Mostrar controles de llamada (asegurándonos de que sean visibles)
        callControls.style.display = 'flex';
        callControls.style.zIndex = '100';
        incomingCallControls.style.display = 'none';
        
        document.getElementById('remote-user-name').textContent = byUsername;
        
        showNotification(`Llamada conectada con ${byUsername}`, 'success');
        
        // Actualizar título de la llamada
        updateCallInfo(byUsername);
        
        // Comprobación extra para depuración
        console.log("Controles de llamada:", callControls);
        console.log("Estado de visualización:", callControls.style.display);
    } catch (error) {
        showNotification(`Error al establecer la conexión: ${error.message}`, 'error');
        console.error('Error handling call acceptance:', error);
        resetCall();
    }
}

// Manejar un nuevo candidato ICE
async function handleNewICECandidate(candidate) {
    if (!peerConnection || !currentCall || currentCall.status !== 'ongoing') {
        return;
    }
    
    try {
        await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    } catch (error) {
        console.error('Error adding ICE candidate:', error);
    }
}

// Manejar el rechazo de una llamada
function handleCallRejected(byUsername, reason) {
    if (!currentCall || currentCall.with !== byUsername || currentCall.status !== 'calling') {
        return;
    }
    
    let message = `${byUsername} ha rechazado tu llamada`;
    if (reason === 'busy') {
        message = `${byUsername} está en otra llamada`;
    }
    
    showNotification(message, 'warning');
    
    // Restablecer la llamada
    resetCall();
}

// Manejar el fin de una llamada
function handleCallEnded(byUsername) {
    if (!currentCall || currentCall.with !== byUsername) {
        return;
    }
    
    showNotification(`${byUsername} ha finalizado la llamada`, 'info');
    
    // Restablecer la llamada
    resetCall();
}

// Finalizar una llamada
function endCall() {
    if (!currentCall) {
        return;
    }
    
    // Enviar fin de llamada al otro usuario
    socket.emit('end', {
        target: currentCall.with
    });
    
    showNotification(`Has finalizado la llamada con ${currentCall.with}`, 'info');
    
    // Restablecer la llamada
    resetCall();
}

// Restablecer el estado de la llamada
function resetCall() {
    // Cerrar la conexión peer
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    
    // Ocultar controles de llamada
    callControls.style.display = 'none';
    incomingCallControls.style.display = 'none';
    endCallBtn.style.display = 'none';
    
    // Limpiar el video remoto
    if (remoteVideo.srcObject) {
        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
        remoteVideo.srcObject = null;
    }
    
    // Restablecer la variable de llamada actual
    currentCall = null;
    
    // Si estamos compartiendo pantalla, detenerla
    if (isScreenSharing && screenStream) {
        screenStream.getTracks().forEach(track => track.stop());
        isScreenSharing = false;
        shareScreenBtn.classList.remove('active');
    }
}

// Silenciar audio
function muteAudio() {
    if (localStream) {
        const audioTracks = localStream.getAudioTracks();
        if (audioTracks.length > 0) {
            for (const track of audioTracks) {
                track.enabled = !track.enabled;
            }
        }
    }
}

// Desactivar vídeo
function disableVideo() {
    if (localStream) {
        const videoTracks = localStream.getVideoTracks();
        if (videoTracks.length > 0) {
            for (const track of videoTracks) {
                track.enabled = !track.enabled;
            }
        }
    }
}

// Función para compartir pantalla
async function toggleScreenSharing() {
    if (!currentCall || currentCall.status !== 'connected') {
        showNotification('Necesitas estar en una llamada para compartir tu pantalla', 'warning');
        return;
    }

    try {
        if (isScreenSharing) {
            // Detener compartir pantalla
            stopScreenSharing();
        } else {
            // Iniciar compartir pantalla
            await startScreenSharing();
        }
    } catch (error) {
        showNotification(`Error al compartir pantalla: ${error.message}`, 'error');
        console.error('Error toggling screen share:', error);
    }
}

// Iniciar compartir pantalla
async function startScreenSharing() {
    try {
        // Obtener acceso a la pantalla
        screenStream = await navigator.mediaDevices.getDisplayMedia({ 
            video: { 
                cursor: 'always',
                displaySurface: 'monitor'
            }
        });
        
        // Almacenar las pistas de video originales para restaurarlas después
        const videoTrack = localStream.getVideoTracks()[0];
        
        // Reemplazar la pista de video con la pantalla en la peer connection
        const screenTrack = screenStream.getVideoTracks()[0];
        
        // Obtener los remitentes de la conexión peer
        const senders = peerConnection.getSenders();
        const videoSender = senders.find(sender => sender.track.kind === 'video');
        
        // Reemplazar la pista de video con la pista de la pantalla
        await videoSender.replaceTrack(screenTrack);
        
        // Actualizar el video local con la pantalla compartida
        localVideo.srcObject = screenStream;
        
        // Marcar que estamos compartiendo pantalla
        isScreenSharing = true;
        shareScreenBtn.classList.add('active');
        
        // Detectar cuando el usuario detiene la compartición de pantalla
        screenTrack.onended = () => {
            stopScreenSharing();
        };
        
        showNotification('Compartiendo pantalla', 'success');
    } catch (error) {
        throw error;
    }
}

// Detener compartir pantalla
async function stopScreenSharing() {
    if (!isScreenSharing || !screenStream) {
        return;
    }
    
    try {
        // Detener todas las pistas del stream de pantalla
        screenStream.getTracks().forEach(track => track.stop());
        
        // Obtener la pista de video original
        const videoTrack = localStream.getVideoTracks()[0];
        
        // Obtener el remitente de video
        const senders = peerConnection.getSenders();
        const videoSender = senders.find(sender => sender.track.kind === 'video');
        
        // Reemplazar la pista de pantalla con la pista de video original
        if (videoTrack && videoSender) {
            await videoSender.replaceTrack(videoTrack);
        }
        
        // Restaurar el stream de video local
        localVideo.srcObject = localStream;
        
        // Actualizar estado
        isScreenSharing = false;
        shareScreenBtn.classList.remove('active');
        
        showNotification('Compartición de pantalla finalizada', 'info');
    } catch (error) {
        console.error('Error stopping screen sharing:', error);
        showNotification('Error al detener la compartición de pantalla', 'error');
    }
}

// Función para el chat
function toggleChat() {
    showNotification('Funcionalidad de chat en desarrollo', 'info');
}

// Función para actualizar la información de la llamada
function updateCallInfo(username) {
    // Actualizar el nombre en el título
    if (callName) {
        callName.textContent = username;
    }
    
    // Asegurarnos de que el header sea visible
    const callHeader = document.getElementById('call-header');
    if (callHeader) {
        callHeader.style.display = 'flex';
    }
    
    // Añadir indicadores de estado a los videos
    addStatusIndicators();
}

// Función para añadir indicadores de estado
function addStatusIndicators() {
    const localVideo = document.querySelector('.video-wrapper.local');
    const remoteVideo = document.querySelector('.video-wrapper:not(.local)');
    
    // Indicador para video local
    if (localVideo && !localVideo.querySelector('.status-indicator')) {
        const indicator = document.createElement('div');
        indicator.className = 'status-indicator';
        indicator.textContent = 'Activo';
        localVideo.appendChild(indicator);
    }
    
    // Indicador para video remoto
    if (remoteVideo && !remoteVideo.querySelector('.status-indicator')) {
        const indicator = document.createElement('div');
        indicator.className = 'status-indicator';
        indicator.textContent = 'Activo';
        remoteVideo.appendChild(indicator);
    }
} 