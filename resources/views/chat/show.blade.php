@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 transition-colors duration-500">
    {{-- MIGAS DE PAN --}}
    <div class="bg-white shadow-md backdrop-blur-xl bg-opacity-80 sticky top-0 z-10 border-b border-purple-100">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-all duration-300 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                @if(auth()->user()->role_id == 2)
                <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-[#5e0490] transition-all duration-300">
                    Dashboard
                </a>
                @elseif(auth()->user()->role_id == 3)
                <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-[#5e0490] transition-all duration-300">
                    Dashboard
                </a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-[#5e0490] transition-all duration-300">Mis Conversaciones</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">{{ $otherUser?->nombre ?? 'Usuario desconocido' }}</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado del chat -->
        <div class="mb-6 bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl border border-purple-100 animate-fadeIn hover:-translate-y-1">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-[#5e0490] transition-colors duration-300 bg-purple-50 p-3 rounded-full hover:bg-purple-100 shadow-sm hover:shadow flex items-center justify-center">
                        <i class="fas fa-arrow-left text-lg"></i>
                    </a>
                    <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="relative group">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-xl transform transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                            @if($otherUser->imagen)
                                <img src="{{ asset('public/profile_images/' . $otherUser->imagen) }}"
                                    alt="Foto de perfil"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl font-bold text-[#5e0490]">
                                    {{ strtoupper(substr($otherUser->nombre, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                        <div class="absolute inset-0 bg-white rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 shadow-lg"></div>
                    </a>
                    <div>
                        <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="group">
                            <h1 class="text-2xl font-bold text-gray-800 group-hover:text-[#5e0490] transition-colors duration-300">{{ $otherUser->nombre }}</h1>
                            <p class="text-gray-600 flex items-center">
                                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                {{ $solicitud->publicacion->titulo }}
                            </p>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="video-call-btn" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <i class="fas fa-video mr-2 group-hover:animate-pulse"></i>
                        <span>Videollamada</span>
                    </button>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 shadow-sm">
                        <span class="w-2 h-2 mr-2 rounded-full bg-green-400 animate-ping opacity-75"></span>
                        En línea
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenedor de videollamada (oculto por defecto) -->
        <div id="video-container" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center hidden backdrop-blur-sm">
            <div class="bg-white rounded-xl w-full max-w-4xl h-auto mx-4 overflow-hidden shadow-2xl animate-fadeIn">
                <div class="flex justify-between items-center p-4 border-b bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white">
                    <h3 class="text-lg font-bold">Videollamada con {{ $otherUser->nombre }}</h3>
                    <div class="flex space-x-3">
                        <button id="toggle-audio" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white transition-colors">
                            <i class="fas fa-microphone"></i>
                        </button>
                        <button id="toggle-video" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white transition-colors">
                            <i class="fas fa-video"></i>
                        </button>
                        <button id="share-screen" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white transition-colors">
                            <i class="fas fa-desktop"></i>
                        </button>
                        <button id="end-call" class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 p-4 bg-gray-900 h-96">
                    <div id="local-video-container" class="bg-black rounded-lg overflow-hidden relative h-full shadow-lg">
                        <video id="local-video" autoplay playsinline></video>
                        <div class="absolute bottom-2 left-2 text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded-md">
                            Tú
                        </div>
                        <div class="absolute top-2 right-2 flex space-x-2">
                            <span id="local-video-status" class="bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-[5px] mr-1"></i> Activo
                            </span>
                        </div>
                    </div>
                    <div id="remote-video-container" class="bg-black rounded-lg overflow-hidden relative h-full shadow-lg">
                        <div id="remote-video" class="w-full h-full"></div>
                        <div class="absolute bottom-2 left-2 text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded-md">
                            {{ $otherUser->nombre }}
                        </div>
                        <div class="absolute top-2 right-2 flex space-x-2">
                            <span id="remote-video-status" class="bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-[5px] mr-1"></i> Activo
                            </span>
                        </div>
                        <div id="remote-video-loading" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-70">
                            <div class="text-center">
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
                                <p class="text-white mt-4">Conectando con {{ $otherUser->nombre }}...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t bg-white flex justify-between items-center">
                    <div class="text-sm text-gray-500 flex items-center">
                        <span id="connection-status" class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                        <span id="call-status">Conectando...</span>
                        <span id="call-timer" class="ml-2 font-medium"></span>
                    </div>
                    <div class="flex space-x-2">
                        <button id="toggle-chat" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors">
                            <i class="fas fa-comment-alt mr-1"></i> Chat
                        </button>
                        <button id="close-video-container" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors">
                            Minimizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notificación de llamada entrante -->
        <div id="incoming-call" class="fixed bottom-5 right-5 bg-white rounded-xl shadow-2xl p-4 flex items-center hidden animate-fadeIn z-50">
            <div class="mr-4 relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center overflow-hidden ring-2 ring-purple-100">
                    @if($otherUser->imagen)
                        <img src="{{ asset('public/profile_images/' . $otherUser->imagen) }}"
                            alt="Foto de perfil"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-xl font-bold text-[#5e0490]">
                            {{ strtoupper(substr($otherUser->nombre, 0, 2)) }}
                        </span>
                    @endif
                </div>
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full animate-pulse flex items-center justify-center">
                    <i class="fas fa-video text-white text-xs"></i>
                </span>
            </div>
            <div>
                <p class="font-bold text-gray-800">{{ $otherUser->nombre }}</p>
                <p class="text-sm text-gray-600">Llamada entrante...</p>
            </div>
            <div class="ml-4 flex space-x-2">
                <button id="accept-call" class="p-2 rounded-full bg-green-500 hover:bg-green-600 text-white transition-colors shadow-lg transform hover:scale-105">
                    <i class="fas fa-phone"></i>
                </button>
                <button id="reject-call" class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors shadow-lg transform hover:scale-105">
                    <i class="fas fa-phone-slash"></i>
                </button>
            </div>
        </div>

        <!-- Contenedor del chat -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl border border-purple-100 animate-fadeIn">
            <!-- Área de mensajes -->
            <div id="chat-messages" class="h-[300px] overflow-y-auto p-6 space-y-4 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 scroll-smooth">
                @if($mensajes->isEmpty())
                    <div class="text-center py-12 animate-fadeIn flex flex-col items-center justify-center h-full">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-purple-200 to-indigo-200 mb-4 shadow-md">
                            <i class="fas fa-comments text-3xl text-[#5e0490]"></i>
                        </div>
                        <p class="text-gray-600 text-lg font-medium">No hay mensajes aún</p>
                        <p class="text-gray-400 text-sm mt-2 max-w-sm text-center">Envía un mensaje o un archivo para empezar a chatear con {{ $otherUser->nombre }}</p>
                        <div class="mt-6 animate-bounce">
                            <i class="fas fa-arrow-down text-purple-300 text-xl"></i>
                        </div>
                    </div>
                @else
                    @foreach($mensajes as $mensaje)
                        <div class="flex {{ $mensaje->user_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fadeIn">
                            <div class="group max-w-xs md:max-w-md lg:max-w-lg {{ $mensaje->user_id === auth()->id() ? 'bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white' : 'bg-white text-gray-800 border border-gray-200' }} rounded-2xl px-4 py-3 shadow-md transform transition-all duration-300 hover:shadow-lg {{ $mensaje->user_id === auth()->id() ? 'hover:-translate-y-1 hover:scale-102' : 'hover:-translate-y-1 hover:scale-102' }}">
                                @if($mensaje->contenido)
                                    <p class="text-sm leading-relaxed">{{ $mensaje->contenido }}</p>
                                @endif

                                @if($mensaje->archivo_adjunto)
                                    <div class="mt-2">
                                        @if(strpos($mensaje->tipo_archivo, 'image/') === 0)
                                            <!-- Mostrar imagen -->
                                            <div class="mt-2 relative group overflow-hidden rounded-lg shadow-sm">
                                                <img src="{{ $mensaje->archivo_adjunto }}"
                                                    alt="Imagen adjunta"
                                                    class="max-w-full h-auto rounded-lg max-h-64 cursor-pointer transition-transform duration-500 transform hover:scale-105"
                                                    onclick="window.open('{{ $mensaje->archivo_adjunto }}', '_blank')">
                                                <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                    <a href="{{ $mensaje->archivo_adjunto }}"
                                                        download="{{ $mensaje->nombre_archivo }}"
                                                        class="bg-white p-2 rounded-full shadow-md text-[#5e0490] transform transition-all duration-300 hover:rotate-12 hover:scale-110">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Mostrar documento -->
                                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $mensaje->user_id === auth()->id() ? 'bg-purple-200 bg-opacity-20' : 'bg-purple-50' }} backdrop-blur-sm transition-transform duration-300 transform hover:scale-102">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-file-alt text-2xl {{ $mensaje->user_id === auth()->id() ? 'text-purple-100' : 'text-[#5e0490]' }}"></i>
                                                </div>
                                                <div class="flex-grow overflow-hidden text-sm {{ $mensaje->user_id === auth()->id() ? 'text-purple-100' : 'text-gray-700' }}">
                                                    <p class="truncate font-medium">{{ $mensaje->nombre_archivo }}</p>
                                                    <p class="text-xs {{ $mensaje->user_id === auth()->id() ? 'text-purple-200' : 'text-gray-500' }}">
                                                        {{ number_format(strlen($mensaje->archivo_adjunto) / 1024, 0) }} KB
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ $mensaje->archivo_adjunto }}"
                                                    download="{{ $mensaje->nombre_archivo }}"
                                                    class="{{ $mensaje->user_id === auth()->id() ? 'bg-purple-300 bg-opacity-30 text-white' : 'bg-purple-100 text-[#5e0490]' }} p-2 rounded-full hover:bg-opacity-100 transition-all duration-300 block">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-xs {{ $mensaje->user_id === auth()->id() ? 'text-purple-200' : 'text-gray-500' }} flex items-center">
                                        <span>{{ \Carbon\Carbon::parse($mensaje->fecha_envio)->format('H:i') }}</span>
                                    </p>
                                    @if($mensaje->user_id === auth()->id())
                                        <span class="message-status flex items-center" data-message-id="{{ $mensaje->id }}">
                                            <i class="fas fa-check {{ $mensaje->leido ? 'fa-check-double text-purple-200' : 'text-purple-200 opacity-60' }} ml-1 text-xs"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Formulario para enviar mensajes -->
            <div class="border-t border-purple-100 p-4 bg-white backdrop-blur-lg shadow-inner">
                <form id="message-form" class="flex flex-col space-y-3" enctype="multipart/form-data">
                    <div class="flex items-center space-x-3">
                        <label for="file-input" class="cursor-pointer p-3 text-gray-500 hover:text-[#5e0490] bg-gray-100 hover:bg-purple-100 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-paperclip text-lg"></i>
                            <span class="sr-only">Adjuntar archivo</span>
                        </label>
                        <input type="file" id="file-input" name="archivo" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">

                        <button type="button" id="emoji-button" class="p-3 text-gray-500 hover:text-[#5e0490] bg-gray-100 hover:bg-purple-100 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-smile text-lg"></i>
                            <span class="sr-only">Emojis</span>
                        </button>
                        
                        <div class="flex-1 relative">
                            <textarea id="message-input"
                                   class="w-full rounded-xl border-gray-300 focus:border-[#5e0490] focus:ring-[#5e0490] transition-colors duration-300 shadow-sm placeholder-gray-400 resize-none px-4 py-3 min-h-[50px] max-h-32"
                                   placeholder="Escribe un mensaje a {{ $otherUser->nombre }}..."
                                   rows="1"></textarea>
                            <div class="absolute right-3 bottom-3 text-gray-400 text-xs font-medium message-length hidden">
                                <span id="current-length">0</span>/<span id="max-length">500</span>
                            </div>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span>Enviar</span>
                        </button>
                    </div>

                    <div id="file-preview" class="hidden flex-grow p-3 bg-purple-50 rounded-xl border border-purple-100 animate-fadeIn">
                        <div class="flex items-center">
                            <i class="fas fa-paperclip mr-2 text-[#5e0490]"></i>
                            <span id="file-name" class="text-sm text-gray-600 mr-2 truncate"></span>
                            <button id="remove-file" type="button" class="text-red-500 hover:text-red-700 bg-white rounded-full p-1 shadow-sm transition-transform duration-300 hover:scale-110">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div id="image-preview-container" class="mt-2 hidden">
                            <img id="image-preview" class="h-20 rounded-lg object-cover shadow-sm" alt="Vista previa">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Agregar el SDK de Agora -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.18.2.js"></script>

<!-- Agregar socket.io para la señalización -->
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>

<!-- Añadir CSS personalizado -->
<link rel="stylesheet" href="{{ asset('css/chat-detail.css') }}">

<!-- Script de funcionalidad de chat -->
<script>
    // Pasar variables necesarias a JavaScript
    window.chatId = '{{ $chat->id }}';
    window.authId = {{ auth()->id() }};
    window.otherUserId = '{{ $otherUser->id }}';
    window.otherUserName = '{{ $otherUser->nombre }}';
    window.lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
    window.csrfToken = '{{ csrf_token() }}';
    window.routeGetMessages = '{{ route('chat.messages', ['chat' => $chat->id]) }}';
    window.routeSendMessage = '{{ route('chat.message', ['chat' => $chat->id]) }}';

    // Variables para la videollamada
    let localStream;
    let screenStream;
    let isScreenSharing = false;
    let agoraClient;
    let agoraScreenClient;

    document.getElementById('video-call-btn').addEventListener('click', async function() {
        console.log('Botón de videollamada presionado');
        document.getElementById('video-container').style.display = 'flex';
        
        try {
            // Solicitar permisos explícitamente
            const stream = await navigator.mediaDevices.getUserMedia({video: true, audio: true});
            localStream = stream;
            
            // Obtener referencia al elemento de video
            const localVideo = document.getElementById('local-video');
            console.log('Elemento de video local:', localVideo);
            
            if (localVideo) {
                // Verificar que es un elemento de video HTML válido
                console.log('¿Es elemento de video?', localVideo instanceof HTMLVideoElement);
                
                // Asignar el stream directamente
                localVideo.srcObject = stream;
                
                // Verificar tracks de video
                console.log('Tracks de video disponibles:', stream.getVideoTracks().length);
                
                // Agregar listener de carga
                localVideo.onloadedmetadata = function() {
                    console.log('Video local cargado correctamente');
                    // Intentar reproducir automáticamente cuando los metadatos estén cargados
                    localVideo.play().catch(e => console.log('Reproducción automática bloqueada, espera interacción del usuario'));
                };
            } else {
                console.error('No se encontró el elemento de video local');
                alert('Error: No se pudo encontrar el elemento de video en la página');
            }
            
            // Inicializar los controles
            initializeControls(stream);
            
            console.log('Cámara iniciada correctamente');
        } catch (error) {
            console.error('Error al acceder a la cámara:', error);
            alert('No se pudo acceder a la cámara o micrófono. Por favor, verifica los permisos: ' + error.message);
        }
    });

    function initializeControls(stream) {
        // Mute/unmute audio
        document.getElementById('toggle-audio').addEventListener('click', function() {
            const audioTracks = stream.getAudioTracks();
            if (audioTracks.length > 0) {
                audioTracks[0].enabled = !audioTracks[0].enabled;
                this.innerHTML = audioTracks[0].enabled ? 
                    '<i class="fas fa-microphone"></i>' : 
                    '<i class="fas fa-microphone-slash"></i>';
            }
        });
        
        // Enable/disable video
        document.getElementById('toggle-video').addEventListener('click', function() {
            const videoTracks = stream.getVideoTracks();
            if (videoTracks.length > 0) {
                videoTracks[0].enabled = !videoTracks[0].enabled;
                this.innerHTML = videoTracks[0].enabled ? 
                    '<i class="fas fa-video"></i>' : 
                    '<i class="fas fa-video-slash"></i>';
            }
        });

        // Compartir pantalla
        document.getElementById('share-screen').addEventListener('click', toggleScreenSharing);
        
        // End call
        document.getElementById('end-call').addEventListener('click', function() {
            stream.getTracks().forEach(track => track.stop());
            
            // Si estamos compartiendo pantalla, detenerla
            if (isScreenSharing && screenStream) {
                screenStream.getTracks().forEach(track => track.stop());
            }
            
            document.getElementById('video-container').style.display = 'none';
        });
        
        // Toggle chat
        document.getElementById('toggle-chat').addEventListener('click', function() {
            // Código para mostrar/ocultar el chat
        });
        
        // Close video container
        document.getElementById('close-video-container').addEventListener('click', function() {
            document.getElementById('video-container').style.display = 'none';
        });
    }

    // Función para compartir pantalla
    async function toggleScreenSharing() {
        if (!localStream) {
            console.error('No hay stream local disponible');
            return;
        }

        if (isScreenSharing) {
            await stopScreenSharing();
        } else {
            await startScreenSharing();
        }
    }

    // Iniciar compartir pantalla
    async function startScreenSharing() {
        try {
            console.log('Iniciando compartición de pantalla...');
            
            // Solicitar acceso a la pantalla
            screenStream = await navigator.mediaDevices.getDisplayMedia({
                video: {
                    cursor: 'always',
                    displaySurface: 'monitor'
                }
            });
            
            // Guardar la referencia al video local original
            const localVideo = document.getElementById('local-video');
            
            // Mostrar la pantalla compartida en el video local
            localVideo.srcObject = screenStream;
            
            // Marcar el botón como activo
            const shareButton = document.getElementById('share-screen');
            shareButton.classList.add('bg-green-500');
            shareButton.classList.remove('bg-white', 'bg-opacity-20');
            
            // Actualizar estado
            isScreenSharing = true;
            
            // Detectar cuando el usuario detiene la compartición de pantalla desde el navegador
            screenStream.getVideoTracks()[0].onended = function() {
                stopScreenSharing();
            };
            
            console.log('Compartición de pantalla iniciada');
        } catch (error) {
            console.error('Error al iniciar la compartición de pantalla:', error);
            alert('No se pudo compartir la pantalla: ' + error.message);
        }
    }

    // Detener compartir pantalla
    async function stopScreenSharing() {
        if (!isScreenSharing || !screenStream) {
            return;
        }
        
        try {
            console.log('Deteniendo compartición de pantalla...');
            
            // Detener todas las pistas del stream de pantalla
            screenStream.getTracks().forEach(track => track.stop());
            
            // Restaurar el vídeo de la cámara
            const localVideo = document.getElementById('local-video');
            localVideo.srcObject = localStream;
            
            // Restaurar el aspecto del botón
            const shareButton = document.getElementById('share-screen');
            shareButton.classList.remove('bg-green-500');
            shareButton.classList.add('bg-white', 'bg-opacity-20');
            
            // Actualizar estado
            isScreenSharing = false;
            screenStream = null;
            
            console.log('Compartición de pantalla detenida');
        } catch (error) {
            console.error('Error al detener la compartición de pantalla:', error);
        }
    }

    // Añade esto después del código anterior
    document.head.insertAdjacentHTML('beforeend', `
        <style>
        #local-video-container, #remote-video-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
            overflow: hidden;
        }
        #local-video, #remote-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        </style>
    `);
</script>
<script src="{{ asset('js/chat-detail.js') }}"></script>

@endsection
