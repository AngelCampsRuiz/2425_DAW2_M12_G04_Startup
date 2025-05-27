@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.chat')

@section('title', 'Chat con ' . $otherUser->nombre)

@section('meta')
    <meta name="chat-id" content="{{ $chat->id }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pusher-key" content="{{ config('broadcasting.connections.pusher.key') }}">
    <meta name="pusher-cluster" content="{{ config('broadcasting.connections.pusher.options.cluster') }}">
    <meta name="agora-app-id" content="ff42e2de41ee4ec7b9bfe51d3d9b4edd">
@endsection

@push('scripts')
    <!-- Definimos las variables globales que utilizará chat-detail.js -->
    <script>
    window.chatId = '{{ $chat->id }}';
    window.authId = {{ auth()->id() }};
    window.otherUserId = '{{ $otherUser->id }}';
    window.otherUserName = '{{ $otherUser->nombre }}';
    window.lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
    window.csrfToken = '{{ csrf_token() }}';
    window.routeGetMessages = '{{ route('chat.messages', ['chat' => $chat->id]) }}';
    window.routeSendMessage = '{{ route('chat.message', ['chat' => $chat->id]) }}';
    </script>
    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- Chat JavaScript -->
    <script src="{{ asset('js/chat.js') }}"></script>
    <!-- Chat Detail JavaScript -->
    <script src="{{ asset('js/chat-detail.js') }}"></script>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 transition-colors duration-500">

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado del chat -->
        <div class="mb-6 bg-white rounded-2xl shadow-lg p-3 sm:p-6 transform transition-all duration-300 hover:shadow-xl border border-purple-100 animate-fadeIn hover:-translate-y-1">
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-[#5e0490] transition-colors duration-300 bg-purple-50 p-2 sm:p-3 rounded-full hover:bg-purple-100 shadow-sm hover:shadow flex items-center justify-center">
                        <i class="fas fa-arrow-left text-base sm:text-lg"></i>
                    </a>
                    <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="relative group">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center overflow-hidden ring-2 sm:ring-4 ring-white shadow-xl transform transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                            @if($otherUser->imagen)
                                <img src="{{ asset('profile_images/' . $otherUser->imagen) }}"
                                    alt="Foto de perfil"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-lg sm:text-2xl font-bold text-[#5e0490]">
                                    {{ strtoupper(substr($otherUser->nombre, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 sm:w-4 sm:h-4 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                        <div class="absolute inset-0 bg-white rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 shadow-lg"></div>
                    </a>
                    <div>
                        <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="group">
                            <h1 class="text-lg sm:text-2xl font-bold text-gray-800 group-hover:text-[#5e0490] transition-colors duration-300">{{ $otherUser->nombre }}</h1>
                            <p class="text-xs sm:text-sm text-gray-600 flex items-center">
                                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                @if(isset($solicitud) && $solicitud)
                                {{ $solicitud->publicacion->titulo }}
                                @elseif($chat->tipo == 'docente_estudiante')
                                    @if(auth()->user()->role_id == 4)
                                        Estudiante
                                    @else
                                        Docente
                                    @endif
                                @elseif($chat->tipo == 'docente_empresa')
                                    @if(auth()->user()->role_id == 4)
                                        Empresa
                                    @else
                                        Docente
                                    @endif
                                @endif
                            </p>
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:space-x-3">
                    <button id="video-call-btn" onclick="window.startVideoCall(); return false;" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
                        <i class="fas fa-video mr-0 sm:mr-2 group-hover:animate-pulse"></i>
                        <span class="hidden sm:inline">Videollamada</span>
                    </button>
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 shadow-sm">
                        <span class="w-2 h-2 mr-1 sm:mr-2 rounded-full bg-green-400 animate-ping opacity-75"></span>
                        <span class="hidden sm:inline">En línea</span>
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
                        <button id="open-whiteboard" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white transition-colors">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button id="open-settings" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white transition-colors">
                            <i class="fas fa-cog"></i>
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
                        <img src="{{ asset('profile_images/' . $otherUser->imagen) }}"
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
                        @php
                            $isCurrentUser = $mensaje->user_id == auth()->id();
                        @endphp
                        <div class="flex items-start message {{ $isCurrentUser ? 'justify-end' : '' }} mb-4" data-message-id="{{ $mensaje->id }}">
                            @if(!$isCurrentUser)
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden shadow-md">
                                        @if($mensaje->user->imagen)
                                            <img src="{{ asset('profile_images/' . $mensaje->user->imagen) }}"
                                                alt="Foto de perfil"
                                                class="w-full h-full object-cover">
                                        @else
                                            <span class="text-base font-bold text-gray-700">
                                                {{ strtoupper(substr($mensaje->user->nombre, 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="flex-1 {{ $isCurrentUser ? 'text-right' : '' }}">
                                <div class="{{ $isCurrentUser 
                                    ? 'bg-gradient-to-r from-purple-500 to-indigo-600 text-white' 
                                    : 'bg-white'}} rounded-2xl p-4 shadow-md inline-block max-w-[85%] relative message-bubble">
                                    <p class="text-sm {{ $isCurrentUser ? 'text-white' : 'text-gray-800' }} message-content">
                                        {{ $mensaje->contenido }}
                                    </p>
                                    @if($mensaje->archivo_adjunto)
                                        @if(Str::startsWith($mensaje->tipo_archivo, 'image/'))
                                            <div class="mt-2 relative group">
                                                <a href="{{ asset('chat_files/' . $mensaje->archivo_adjunto) }}" target="_blank" class="block">
                                                    <img src="{{ asset('chat_files/' . $mensaje->archivo_adjunto) }}" 
                                                        alt="Imagen adjunta" 
                                                        class="max-w-full max-h-60 rounded-lg shadow-sm">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                                        <span class="bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded-full">
                                                            <i class="fas fa-search-plus mr-1"></i> Ver imagen
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <a href="{{ asset('chat_files/' . $mensaje->archivo_adjunto) }}" 
                                                   target="_blank"
                                                   class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors duration-200">
                                                    <div class="mr-3 bg-gray-200 w-10 h-10 rounded-lg flex items-center justify-center text-gray-500">
                                                        <i class="fas fa-file-alt text-lg"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $mensaje->nombre_archivo ?: 'Archivo adjunto' }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">Descargar archivo</p>
                                                    </div>
                                                    <i class="fas fa-download text-purple-600"></i>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="text-xs {{ $isCurrentUser ? 'text-white/80' : 'text-gray-500' }} mt-1 flex items-center justify-between">
                                        <span>{{ \Carbon\Carbon::parse($mensaje->created_at)->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Formulario de mensajes -->
            <form id="message-form" class="flex items-end gap-2 bg-white p-4 rounded-xl shadow-lg border border-purple-100">
                <div class="flex-1 relative">
                    <textarea
                        id="message-input"
                        name="message"
                        rows="1"
                        class="w-full resize-none rounded-xl border-gray-200 bg-gray-50 p-3 text-sm placeholder-gray-400 focus:border-purple-400 focus:ring-purple-400"
                        placeholder="Escribe un mensaje..."
                        maxlength="500"
                    ></textarea>
                    
                    <div class="message-length hidden absolute -top-6 right-0 text-xs text-gray-500">
                        <span id="current-length">0</span>/500
                    </div>
                </div>
                
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 px-4 py-3 text-white hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed h-[42px]"
                >
                    <i class="fas fa-paper-plane"></i>
                    <span class="sr-only">Enviar mensaje</span>
                </button>
            </form>

            <div class="flex flex-col sm:flex-row gap-3 border-t border-gray-200 p-4 bg-white">
                @if(isset($solicitud) && $solicitud)
                <div class="flex items-center bg-purple-50 px-4 py-2 rounded-lg flex-grow-0 text-sm text-purple-700">
                    <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                    <span>Conversación sobre: <span class="font-medium">{{ $solicitud->publicacion->titulo }}</span></span>
                                    </div>
                @elseif($chat->tipo == 'docente_estudiante')
                <div class="flex items-center bg-blue-50 px-4 py-2 rounded-lg flex-grow-0 text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    <span>
                        @if(auth()->user()->role_id == 4)
                            Conversación con estudiante: <span class="font-medium">{{ $otherUser->nombre }}</span>
                        @else
                            Conversación con docente: <span class="font-medium">{{ $otherUser->nombre }}</span>
                        @endif
                    </span>
                                </div>
                @elseif($chat->tipo == 'docente_empresa')
                <div class="flex items-center bg-green-50 px-4 py-2 rounded-lg flex-grow-0 text-sm text-green-700">
                    <i class="fas fa-info-circle mr-2 text-green-500"></i>
                    <span>
                        @if(auth()->user()->role_id == 4)
                            Conversación con empresa: <span class="font-medium">{{ $otherUser->nombre }}</span>
                        @else
                            Conversación con docente: <span class="font-medium">{{ $otherUser->nombre }}</span>
                        @endif
                    </span>
                                    </div>
                @endif
                
                <!-- <div class="flex items-center ml-auto gap-2">
                    <a href="{{ route('chat.index') }}" class="flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 text-gray-700 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver a conversaciones
                    </a>
                    <a href="#chat-form" class="flex items-center justify-center px-4 py-2 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Responder</span>
                    </a>
                            </div>
                            </div>
                            </div>
                            </div>
</div> -->

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Agregar el SDK de Agora -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.18.2.js"></script>

<!-- Agregar socket.io para la señalización (versión actualizada) -->
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js" integrity="sha384-mZLF4UVrpi/QTWPA7BjNPEnkIfRFn4ZEO3Qt/HFklTJBj/gBOV8G3HcKn4NfQblz" crossorigin="anonymous"></script>

<!-- Añadir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Añadir CSS personalizado -->
<link rel="stylesheet" href="{{ asset('css/chat-detail.css') }}">

<!-- Configuración para Socket.io -->
<script>
    // Añadir logs de depuración
    console.log('Script de chat inicializándose...');
    
    // Configurar la variable global para la URL del servidor Socket.io
    window.socketServerUrl = '{{ env('SOCKET_SERVER_URL', 'http://localhost:3000') }}';

    // Las variables que se pasan a JavaScript desde Blade
    window.chatId = '{{ $chat->id }}';
    window.authId = {{ auth()->id() }};
    window.otherUserId = '{{ $otherUser->id }}';
    window.otherUserName = '{{ $otherUser->nombre }}';
    window.lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
    window.csrfToken = '{{ csrf_token() }}';
    window.routeGetMessages = '{{ route('chat.messages', ['chat' => $chat->id]) }}';
    window.routeSendMessage = '{{ route('chat.message', ['chat' => $chat->id]) }}';

    // Variables para la videollamada
    let localStream = null;
    let remoteStream = null;
    let selectedAudioInput = null;
    let selectedAudioOutput = null;
    let selectedVideoInput = null;
    let agoraClient = null;
    let isScreenSharing = false;
    let screenStream = null;
    let channelName = 'chat_{{ $chat->id }}';
    let localUid = {{ auth()->id() }};
    let agoraAppId = 'ff42e2de41ee4ec7b9bfe51d3d9b4edd';
    
    console.log('Agora AppID configurado directamente:', agoraAppId);
    
    // Función wrapper para el botón de videollamada (accesible globalmente)
    function startVideoCallBtn() {
        console.log('Función startVideoCallBtn llamada directamente desde onclick');
        try {
            startVideoCall();
        } catch (error) {
            console.error('Error al iniciar la videollamada:', error);
            alert('Error al iniciar la videollamada: ' + error.message);
        }
    }
    
    // Versión simplificada para depuración
    window.startVideoCall = function() {
        console.log('Función startVideoCall llamada');
        
        try {
            // Mostrar el contenedor de video
            const videoContainer = document.getElementById('video-container');
            if (!videoContainer) {
                throw new Error('No se encontró el contenedor de video');
            }
            
            videoContainer.style.display = 'flex';
            console.log('Contenedor de video mostrado');
            
            // Verificar si la API de mediaDevices está disponible
            if (!navigator.mediaDevices || typeof navigator.mediaDevices.getUserMedia !== 'function') {
                throw new Error('La API de cámara no está disponible en este navegador');
            }
            
            // Solicitar acceso a la cámara y micrófono
            navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            })
            .then(function(stream) {
                console.log('Acceso a la cámara concedido');
                
                // Guardar el stream
                localStream = stream;
                
                // Mostrar el video local
                const localVideoElement = document.getElementById('local-video');
                if (localVideoElement) {
                    localVideoElement.srcObject = stream;
                    localVideoElement.onloadedmetadata = function() {
                        localVideoElement.play()
                        .then(() => {
                            console.log('Video local reproduciendo');
                            
                            // Intentar inicializar Agora
                            initializeAgoraClient()
                            .then(success => {
                                if (!success) {
                                    console.error('No se pudo inicializar Agora');
                                }
                            })
                            .catch(error => {
                                console.error('Error al inicializar Agora:', error);
                            });
                        })
                        .catch(e => console.error('Error al reproducir video local:', e));
                    };
                } else {
                    throw new Error('No se encontró el elemento de video local');
                }
            })
            .catch(function(error) {
                console.error('Error al acceder a la cámara:', error);
                Swal.fire({
                    title: 'Error de acceso',
                    text: 'No se pudo acceder a la cámara o micrófono. Por favor, verifica los permisos.',
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#5e0490'
                });
                
                // Ocultar el contenedor de video en caso de error
                videoContainer.style.display = 'none';
            });
        } catch (error) {
            console.error('Error al iniciar la videollamada:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al iniciar la videollamada: ' + error.message,
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#5e0490'
            });
        }
    };

    // Inicializar el cliente de Agora y configurar la conexión
    async function initializeAgoraClient() {
        try {
            console.log('Inicializando cliente de Agora...');
            
            // Verificar si ya existe un cliente
            if (agoraClient) {
                console.log('Cliente de Agora ya inicializado');
                return true;
            }
            
            // Verificar que tenemos un AppID válido
            if (!agoraAppId || agoraAppId.trim() === '') {
                console.error('AppID no válido:', agoraAppId);
                throw new Error('No se ha configurado el AppID de Agora o es inválido');
            }
            
            console.log('Usando Agora AppID:', agoraAppId);
            console.log('Canal a unirse:', channelName);
            console.log('UID local:', localUid);
            
            // Crear cliente de Agora
            agoraClient = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });
            
            if (!agoraClient) {
                throw new Error('No se pudo crear el cliente de Agora');
            }
            
            // Agregar event listeners
            agoraClient.on('user-published', handleUserPublished);
            agoraClient.on('user-unpublished', handleUserUnpublished);
            agoraClient.on('connection-state-change', handleConnectionStateChange);
            
            // Verificar que localStream existe antes de continuar
            if (!localStream) {
                throw new Error('No hay acceso a la cámara o micrófono');
            }
            
            // Unirse al canal con un token nulo (para desarrollo)
            console.log('Intentando unirse al canal: ' + channelName + ' con uid: ' + localUid);
            
            // Intentar unirse al canal con reintentos
            let attempts = 0;
            const maxAttempts = 3;
            
            while (attempts < maxAttempts) {
                try {
                    attempts++;
                    console.log(`Intento ${attempts} de ${maxAttempts}...`);
                    await agoraClient.join(agoraAppId, channelName, null, localUid);
                    console.log('Unión exitosa al canal de Agora');
                    break; // Salir del bucle si la unión es exitosa
                } catch (joinError) {
                    console.error(`Error en intento ${attempts}:`, joinError);
                    
                    if (attempts >= maxAttempts) {
                        throw joinError; // Propagar el error si se agotaron los intentos
                    }
                    
                    // Esperar antes del siguiente intento
                    await new Promise(resolve => setTimeout(resolve, 1000));
                }
            }
            
            // Crear las pistas de audio y video a partir del stream local
            const audioTrack = AgoraRTC.createMicrophoneAudioTrack({ microphoneId: localStream.getAudioTracks()[0].id });
            const videoTrack = AgoraRTC.createCameraVideoTrack({ cameraId: localStream.getVideoTracks()[0].id });
            
            // Publicar las pistas individualmente en lugar de publicar el stream completo
            await agoraClient.publish([audioTrack, videoTrack]);
            console.log('Publicación exitosa en el canal de Agora');
            
            // Inicializar controles de videollamada con el stream local
            initializeControls(localStream);
            
            return true;
        } catch (error) {
            console.error('Error al inicializar Agora:', error);
            
            // Limpiar recursos en caso de error
            if (agoraClient) {
                try {
                    await agoraClient.leave();
                } catch (leaveError) {
                    console.error('Error al abandonar el canal:', leaveError);
                }
                agoraClient = null;
            }
            
            // Mostrar un mensaje amigable al usuario
            Swal.fire({
                title: 'Error de conexión',
                text: 'No se pudo establecer la videollamada. Por favor, intenta de nuevo más tarde.',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#5e0490'
            });
            
            return false;
        }
    }

    // Manejar la publicación de streams de otros usuarios
    async function handleUserPublished(user, mediaType) {
        // Ocultar el mensaje de carga
        const loadingElement = document.getElementById('remote-video-loading');
        if (loadingElement) {
            loadingElement.style.display = 'none';
        }
        
        // Suscribirse al usuario remoto
        await agoraClient.subscribe(user, mediaType);
        console.log(`Suscrito a ${user.uid} para ${mediaType}`);
        
        // Si es video, añadirlo al elemento remoto
        if (mediaType === 'video') {
            // Crear un nuevo elemento de video para el usuario remoto si no existe
            const remoteVideoContainer = document.getElementById('remote-video');
            if (!remoteVideoContainer) {
                console.error('No se encontró el contenedor de video remoto');
                return;
            }
            
            // Comprobar si ya existe un elemento para este usuario
            let playerElement = document.getElementById(`remote-player-${user.uid}`);
            if (!playerElement) {
                playerElement = document.createElement('div');
                playerElement.id = `remote-player-${user.uid}`;
                playerElement.style.width = '100%';
                playerElement.style.height = '100%';
                remoteVideoContainer.appendChild(playerElement);
            }
            
            // Reproducir el video del usuario remoto
            user.videoTrack.play(playerElement);
            
            // Actualizar el estado de la llamada
            document.getElementById('call-status').textContent = 'Conectado';
            document.getElementById('connection-status').style.backgroundColor = '#10b981'; // verde
            
            // Iniciar temporizador de llamada
            startCallTimer();
        }
        
        // Si es audio, reproducirlo
        if (mediaType === 'audio') {
            user.audioTrack.play();
        }
    }

    // Manejar cuando un usuario deja de publicar su stream
    function handleUserUnpublished(user, mediaType) {
        console.log(`Usuario ${user.uid} dejó de publicar ${mediaType}`);
        
        if (mediaType === 'video') {
            // Eliminar el elemento de video
            const playerElement = document.getElementById(`remote-player-${user.uid}`);
            if (playerElement) {
                playerElement.remove();
            }
            
            // Mostrar mensaje de reconexión
            const loadingElement = document.getElementById('remote-video-loading');
            if (loadingElement) {
                loadingElement.style.display = 'flex';
                const loadingText = loadingElement.querySelector('p');
                if (loadingText) {
                    loadingText.textContent = 'Esperando a que se reconecte...';
                }
            }
            
            // Actualizar estado
            document.getElementById('call-status').textContent = 'Esperando...';
            document.getElementById('connection-status').style.backgroundColor = '#f59e0b'; // amarillo
        }
    }

    // Manejar cambios en el estado de la conexión
    function handleConnectionStateChange(state, reason) {
        console.log(`Estado de conexión cambió de ${state} a ${reason}`);
        
        const connectionStatus = document.getElementById('connection-status');
        const callStatus = document.getElementById('call-status');
        
        switch (state) {
            case 'CONNECTING':
                connectionStatus.style.backgroundColor = '#f59e0b'; // amarillo
                callStatus.textContent = 'Conectando...';
                break;
            case 'CONNECTED':
                connectionStatus.style.backgroundColor = '#10b981'; // verde
                callStatus.textContent = 'Conectado';
                break;
            case 'DISCONNECTING':
                connectionStatus.style.backgroundColor = '#f59e0b'; // amarillo
                callStatus.textContent = 'Desconectando...';
                break;
            case 'DISCONNECTED':
                connectionStatus.style.backgroundColor = '#ef4444'; // rojo
                callStatus.textContent = 'Desconectado';
                break;
            case 'RECONNECTING':
                connectionStatus.style.backgroundColor = '#f59e0b'; // amarillo
                callStatus.textContent = 'Reconectando...';
                break;
            default:
                connectionStatus.style.backgroundColor = '#6b7280'; // gris
                callStatus.textContent = 'Estado desconocido';
        }
    }

    // Función para compartir pantalla
    async function toggleScreenSharing() {
        try {
            const shareScreenBtn = document.getElementById('share-screen');
            
            // Si ya estamos compartiendo pantalla, detener
            if (isScreenSharing && screenStream) {
                // Detener todas las pistas del stream de pantalla
                screenStream.getTracks().forEach(track => track.stop());
                
                // Cambiar de nuevo a la cámara
                if (localStream) {
                    await agoraClient.unpublish(screenStream);
                    await agoraClient.publish(localStream);
                }
                
                isScreenSharing = false;
                screenStream = null;
                
                // Actualizar botón
                if (shareScreenBtn) {
                    shareScreenBtn.innerHTML = '<i class="fas fa-desktop"></i>';
                    shareScreenBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                    shareScreenBtn.classList.add('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                }
                
                return;
            }
            
            // Iniciar compartir pantalla
            screenStream = await navigator.mediaDevices.getDisplayMedia({
                video: {
                    cursor: 'always'
                },
                audio: false
            });
            
            // Reemplazar el stream de video actual con el de la pantalla
            await agoraClient.unpublish(localStream.videoTrack);
            await agoraClient.publish(screenStream.getVideoTracks()[0]);
            
            isScreenSharing = true;
            
            // Actualizar botón
            if (shareScreenBtn) {
                shareScreenBtn.innerHTML = '<i class="fas fa-times"></i>';
                shareScreenBtn.classList.remove('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                shareScreenBtn.classList.add('bg-red-500', 'hover:bg-red-600');
            }
            
            // Cuando el usuario detiene la compartición desde el navegador
            screenStream.getVideoTracks()[0].onended = async () => {
                if (isScreenSharing) {
                    // Detener todas las pistas
                    screenStream.getTracks().forEach(track => track.stop());
                    
                    // Volver a publicar la cámara
                    if (localStream) {
                        await agoraClient.unpublish(screenStream.getVideoTracks()[0]);
                        await agoraClient.publish(localStream.videoTrack);
                    }
                    
                    isScreenSharing = false;
                    screenStream = null;
                    
                    // Actualizar botón
                    if (shareScreenBtn) {
                        shareScreenBtn.innerHTML = '<i class="fas fa-desktop"></i>';
                        shareScreenBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                        shareScreenBtn.classList.add('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                    }
                }
            };
        } catch (error) {
            console.error('Error al compartir pantalla:', error);
            
            Swal.fire({
                title: 'Error',
                text: 'No se pudo compartir la pantalla: ' + error.message,
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#5e0490'
            });
        }
    }

    // Inicializar controles
    function initializeControls(stream) {
        if (!stream) {
            console.error('No se proporcionó un stream para inicializar los controles');
            return;
        }
        
        // Mute/unmute audio
        const toggleAudioBtn = document.getElementById('toggle-audio');
        if (toggleAudioBtn) {
            toggleAudioBtn.addEventListener('click', function() {
                const audioTracks = stream.getAudioTracks();
                if (audioTracks.length > 0) {
                    audioTracks[0].enabled = !audioTracks[0].enabled;
                    this.innerHTML = audioTracks[0].enabled ?
                        '<i class="fas fa-microphone"></i>' :
                        '<i class="fas fa-microphone-slash"></i>';
                    
                    // Cambiar estilo del botón
                    if (audioTracks[0].enabled) {
                        this.classList.remove('bg-red-500', 'hover:bg-red-600');
                        this.classList.add('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                    } else {
                        this.classList.remove('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                        this.classList.add('bg-red-500', 'hover:bg-red-600');
                    }
                }
            });
        }
        
        // Toggle video
        const toggleVideoBtn = document.getElementById('toggle-video');
        if (toggleVideoBtn) {
            toggleVideoBtn.addEventListener('click', function() {
                const videoTracks = stream.getVideoTracks();
                if (videoTracks.length > 0) {
                    videoTracks[0].enabled = !videoTracks[0].enabled;
                    this.innerHTML = videoTracks[0].enabled ?
                        '<i class="fas fa-video"></i>' :
                        '<i class="fas fa-video-slash"></i>';
                    
                    // Cambiar estilo del botón
                    if (videoTracks[0].enabled) {
                        this.classList.remove('bg-red-500', 'hover:bg-red-600');
                        this.classList.add('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                    } else {
                        this.classList.remove('bg-white', 'bg-opacity-20', 'hover:bg-opacity-30');
                        this.classList.add('bg-red-500', 'hover:bg-red-600');
                    }
                    
                    // Actualizar estado local
                    const localVideoStatus = document.getElementById('local-video-status');
                    if (localVideoStatus) {
                        localVideoStatus.className = videoTracks[0].enabled ?
                            'bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center' :
                            'bg-red-500 text-white text-xs px-2 py-1 rounded-full flex items-center';
                        localVideoStatus.innerHTML = videoTracks[0].enabled ?
                            '<i class="fas fa-circle text-[5px] mr-1"></i> Activo' :
                            '<i class="fas fa-circle text-[5px] mr-1"></i> Inactivo';
                    }
                }
            });
        }
        
        // Terminar llamada
        const endCallBtn = document.getElementById('end-call');
        if (endCallBtn) {
            endCallBtn.addEventListener('click', endCall);
        }
        
        // Cerrar/minimizar video
        const closeVideoBtn = document.getElementById('close-video-container');
        if (closeVideoBtn) {
            closeVideoBtn.addEventListener('click', function() {
                const videoContainer = document.getElementById('video-container');
                if (videoContainer) {
                    videoContainer.style.display = 'none';
                }
            });
        }
    }

    // Función para enumerar dispositivos
    async function enumerateDevices() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            
            // Agrupar por tipo
            const audioInputs = devices.filter(device => device.kind === 'audioinput');
            const audioOutputs = devices.filter(device => device.kind === 'audiooutput');
            const videoInputs = devices.filter(device => device.kind === 'videoinput');
            
            // Actualizar selectores si existen
            updateDeviceSelectors(audioInputs, audioOutputs, videoInputs);
            
            return { audioInputs, audioOutputs, videoInputs };
        } catch (error) {
            console.error('Error al enumerar dispositivos:', error);
            return { audioInputs: [], audioOutputs: [], videoInputs: [] };
        }
    }

    // Actualizar selectores de dispositivos
    function updateDeviceSelectors(audioInputs = [], audioOutputs = [], videoInputs = []) {
        const micSelect = document.getElementById('microphone-select');
        const speakerSelect = document.getElementById('speaker-select');
        const cameraSelect = document.getElementById('camera-select');

        // Verificar que todos los selectores existen
        if (!micSelect || !speakerSelect || !cameraSelect) {
            console.warn('Algunos selectores de dispositivos no se encontraron en el DOM');
            return; // Salir si alguno no existe
        }

        // Limpiar selectores
        micSelect.innerHTML = '';
        speakerSelect.innerHTML = '';
        cameraSelect.innerHTML = '';

        // Rellenar micrófonos
        audioInputs.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Micrófono ${micSelect.options.length + 1}`;
            micSelect.appendChild(option);
        });

        // Rellenar altavoces
        audioOutputs.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Altavoz ${speakerSelect.options.length + 1}`;
            speakerSelect.appendChild(option);
        });

        // Rellenar cámaras
        videoInputs.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Cámara ${cameraSelect.options.length + 1}`;
            cameraSelect.appendChild(option);
        });
    }

    // Finalizar llamada
    async function endCall() {
        try {
            // Detener todas las pistas del stream local
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localStream = null;
            }
            
            // Detener stream de pantalla compartida si existe
            if (isScreenSharing && screenStream) {
                screenStream.getTracks().forEach(track => track.stop());
                screenStream = null;
                isScreenSharing = false;
            }
            
            // Salir del canal de Agora
            if (agoraClient) {
                await agoraClient.leave();
                agoraClient = null;
            }
            
            // Ocultar contenedor de video
            const videoContainer = document.getElementById('video-container');
            if (videoContainer) {
                videoContainer.style.display = 'none';
            }
            
            console.log('Llamada finalizada correctamente');
        } catch (error) {
            console.error('Error al finalizar la llamada:', error);
        }
    }

    // Iniciar temporizador de llamada
    function startCallTimer() {
        const timerElement = document.getElementById('call-timer');
        if (!timerElement) return;
        
        let seconds = 0;
        const timerInterval = setInterval(() => {
            seconds++;
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            
            // Si la llamada ha terminado, detener el temporizador
            if (!agoraClient) {
                clearInterval(timerInterval);
            }
        }, 1000);
    }

    // Inicializar eventos cuando el DOM esté cargado
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado, inicializando eventos...');
        
        // Asignar evento al botón de videollamada
        const videoCallBtn = document.getElementById('video-call-btn');
        if (videoCallBtn) {
            console.log('Botón de videollamada encontrado, asignando evento');
            
            // Limpiar cualquier event listener previo
            const newBtn = videoCallBtn.cloneNode(true);
            videoCallBtn.parentNode.replaceChild(newBtn, videoCallBtn);
            
            // Asignar nuevo event listener
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Botón de videollamada presionado mediante event listener');
                window.startVideoCall();
                return false;
            });
        } else {
            console.error('No se encontró el botón de videollamada en el DOM');
        }
    });
</script>

<!-- Añadir soporte de Pusher para el chat en tiempo real -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

@endsection
