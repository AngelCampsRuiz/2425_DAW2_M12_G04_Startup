// Variables globales
const socket = io();
let localStream;
let remoteStream;
let peerConnection;
let currentUser = null;
let currentCall = null;

// Configuración de WebRTC
const configuration = {
    iceServers: [
        { urls: 'stun:stun.l.google.com:19302' },
        { urls: 'stun:stun1.l.google.com:19302' }
    ]
};

// Elementos del DOM
const registerSection = document.getElementById('register-section');
const mainSection = document.getElementById('main-section');
const usernameInput = document.getElementById('username-input');
const registerButton = document.getElementById('register-button');
const usersList = document.getElementById('users-list');
const localVideo = document.getElementById('local-video');
const remoteVideo = document.getElementById('remote-video');
const endCallButton = document.getElementById('end-call-button');
const incomingCallControls = document.getElementById('incoming-call-controls');
const incomingCallText = document.getElementById('incoming-call-text');
const acceptCallButton = document.getElementById('accept-call-button');
const rejectCallButton = document.getElementById('reject-call-button');
const notificationsArea = document.getElementById('notifications-area');

// Listeners de eventos
registerButton.addEventListener('click', registerUser);
endCallButton.addEventListener('click', endCall);
acceptCallButton.addEventListener('click', acceptCall);
rejectCallButton.addEventListener('click', rejectCall);

// Inicialización
document.addEventListener('DOMContentLoaded', initialize);

function initialize() {
    mainSection.style.display = 'none';
    incomingCallControls.style.display = 'none';
    endCallButton.style.display = 'none';
}

// Funciones de registro
function registerUser() {
    const username = usernameInput.value.trim();
    if (username) {
        socket.emit('register', username);
        currentUser = username;
    } else {
        showNotification('Por favor, introduce un nombre de usuario', 'warning');
    }
}

// Funciones de WebRTC
async function setupMediaDevices() {
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;
    } catch (error) {
        showNotification(`Error al acceder a la cámara o micrófono: ${error.message}`, 'danger');
    }
}

async function createPeerConnection(targetUser) {
    peerConnection = new RTCPeerConnection(configuration);
    
    // Añadir tracks al peer connection
    localStream.getTracks().forEach(track => {
        peerConnection.addTrack(track, localStream);
    });
    
    // Manejar ICE candidates
    peerConnection.onicecandidate = event => {
        if (event.candidate) {
            socket.emit('ice-candidate', {
                target: targetUser,
                candidate: event.candidate
            });
        }
    };
    
    // Manejar cambios de estado de conexión
    peerConnection.onconnectionstatechange = () => {
        if (peerConnection.connectionState === 'connected') {
            showNotification('Conexión establecida', 'success');
        }
    };
    
    // Manejar stream remoto
    peerConnection.ontrack = event => {
        remoteStream = event.streams[0];
        remoteVideo.srcObject = remoteStream;
    };
}

async function startCall(targetUser) {
    currentCall = targetUser;
    await setupMediaDevices();
    await createPeerConnection(targetUser);
    
    // Crear y enviar oferta SDP
    const offer = await peerConnection.createOffer();
    await peerConnection.setLocalDescription(offer);
    
    socket.emit('call-offer', {
        target: targetUser,
        offer: offer
    });
    
    showNotification(`Llamando a ${targetUser}...`, 'info');
    endCallButton.style.display = 'block';
}

async function handleCallOffer(data) {
    incomingCallText.textContent = `${data.caller} te está llamando`;
    incomingCallControls.style.display = 'block';
    currentCall = data.caller;
    
    // Guardar la oferta para usarla si acepta la llamada
    incomingCallControls.dataset.offer = JSON.stringify(data.offer);
}

async function acceptCall() {
    await setupMediaDevices();
    await createPeerConnection(currentCall);
    
    // Recuperar la oferta guardada
    const offerData = JSON.parse(incomingCallControls.dataset.offer);
    await peerConnection.setRemoteDescription(new RTCSessionDescription(offerData));
    
    // Crear y enviar respuesta
    const answer = await peerConnection.createAnswer();
    await peerConnection.setLocalDescription(answer);
    
    socket.emit('call-answer', {
        target: currentCall,
        answer: answer
    });
    
    incomingCallControls.style.display = 'none';
    endCallButton.style.display = 'block';
}

function rejectCall() {
    socket.emit('call-rejected', {
        target: currentCall
    });
    
    incomingCallControls.style.display = 'none';
    currentCall = null;
}

async function handleCallAnswer(data) {
    await peerConnection.setRemoteDescription(new RTCSessionDescription(data.answer));
}

function handleIceCandidate(data) {
    if (peerConnection) {
        peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
    }
}

function endCall() {
    if (peerConnection) {
        peerConnection.close();
        peerConnection = null;
    }
    
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
    }
    
    localVideo.srcObject = null;
    remoteVideo.srcObject = null;
    
    socket.emit('call-ended', {
        target: currentCall
    });
    
    currentCall = null;
    endCallButton.style.display = 'none';
    
    showNotification('Llamada finalizada', 'info');
}

// Funciones de interfaz de usuario
function updateUsersList(users) {
    usersList.innerHTML = '';
    users.forEach(user => {
        if (user !== currentUser) {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = user;
            listItem.onclick = () => startCall(user);
            usersList.appendChild(listItem);
        }
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} notification`;
    notification.textContent = message;
    
    notificationsArea.appendChild(notification);
    
    // Auto eliminar después de 5 segundos
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Eventos de Socket.io
socket.on('register-success', () => {
    registerSection.style.display = 'none';
    mainSection.style.display = 'block';
    showNotification(`Bienvenido, ${currentUser}!`, 'success');
});

socket.on('register-failed', (message) => {
    showNotification(message, 'danger');
});

socket.on('users-list', (users) => {
    updateUsersList(users);
});

socket.on('call-offer', (data) => {
    handleCallOffer(data);
});

socket.on('call-answer', (data) => {
    handleCallAnswer(data);
});

socket.on('ice-candidate', (data) => {
    handleIceCandidate(data);
});

socket.on('call-rejected', () => {
    showNotification(`${currentCall} rechazó tu llamada`, 'warning');
    endCall();
});

socket.on('call-ended', () => {
    showNotification('La otra persona finalizó la llamada', 'info');
    endCall();
});

socket.on('user-disconnected', (username) => {
    showNotification(`${username} se ha desconectado`, 'info');
    if (currentCall === username) {
        endCall();
    }
    updateUsersList();
}); 