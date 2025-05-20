@php
$layout = 'layouts.app';

if (auth()->user()->role_id == 4) {
    $layout = 'layouts.docente';
} elseif (auth()->user()->role_id == 2) {
    $layout = 'layouts.empresa-sidebar';
} elseif (auth()->user()->role_id == 5) {
    $layout = 'layouts.institucion';
}
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 transition-colors duration-500">
    {{-- MIGAS DE PAN --}}
    @if(auth()->user()->role_id != 4 && auth()->user()->role_id != 5 && auth()->user()->role_id != 2)
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
    @endif

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
                    <button id="video-call-btn" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white hover:shadow-lg transition-all duration-300 transform hover:scale-105 group">
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
                            $userName = $mensaje->user->nombre;
                            $userRole = '';
                            
                            if ($mensaje->user->role_id == 2) {
                                $userRole = 'Empresa';
                            } elseif ($mensaje->user->role_id == 3) {
                                $userRole = 'Estudiante';
                            } elseif ($mensaje->user->role_id == 4) {
                                $userRole = 'Docente';
                            }
                            
                            // Determinar la imagen o iniciales para mostrar
                            $userImage = null;
                            if ($mensaje->user->imagen) {
                                $userImage = asset('profile_images/' . $mensaje->user->imagen);
                            }
                        @endphp
                        <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }} animate-fadeIn">
                            <div class="group max-w-xs md:max-w-md lg:max-w-lg {{ $isCurrentUser ? 'bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white' : 'bg-white text-gray-800 border border-gray-200' }} rounded-2xl px-4 py-3 shadow-md transform transition-all duration-300 hover:shadow-lg {{ $isCurrentUser ? 'hover:-translate-y-1 hover:scale-102' : 'hover:-translate-y-1 hover:scale-102' }}">
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
                                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $isCurrentUser ? 'bg-purple-200 bg-opacity-20' : 'bg-purple-50' }} backdrop-blur-sm transition-transform duration-300 transform hover:scale-102">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-file-alt text-2xl {{ $isCurrentUser ? 'text-purple-100' : 'text-[#5e0490]' }}"></i>
                                                </div>
                                                <div class="flex-grow overflow-hidden text-sm {{ $isCurrentUser ? 'text-purple-100' : 'text-gray-700' }}">
                                                    <p class="truncate font-medium">{{ $mensaje->nombre_archivo }}</p>
                                                    <p class="text-xs {{ $isCurrentUser ? 'text-purple-200' : 'text-gray-500' }}">
                                                        {{ number_format(strlen($mensaje->archivo_adjunto) / 1024, 0) }} KB
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ $mensaje->archivo_adjunto }}"
                                                    download="{{ $mensaje->nombre_archivo }}"
                                                    class="{{ $isCurrentUser ? 'bg-purple-300 bg-opacity-30 text-white' : 'bg-purple-100 text-[#5e0490]' }} p-2 rounded-full hover:bg-opacity-100 transition-all duration-300 block">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-xs {{ $isCurrentUser ? 'text-purple-200' : 'text-gray-500' }} flex items-center">
                                        <span>{{ \Carbon\Carbon::parse($mensaje->fecha_envio)->format('H:i') }}</span>
                                    </p>
                                    @if($isCurrentUser)
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

            <!-- Formulario para enviar un nuevo mensaje -->
            <div id="chat-form" class="p-5 border-t border-gray-100 bg-white rounded-b-2xl">
                <form id="message-form" class="space-y-4" data-chat-id="{{ $chat->id }}">
                    @csrf
                    <div class="relative">
                        <textarea
                            id="message-input"
                            name="contenido"
                            rows="3"
                            placeholder="Escribe tu mensaje aquí..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 resize-none transition-all duration-300"
                        ></textarea>
                        <button type="button" id="emoji-button" class="absolute bottom-3 right-4 text-gray-500 hover:text-purple-600 transition-colors">
                            <i class="far fa-smile-beam text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <label for="file-upload" class="p-2 bg-purple-50 text-purple-700 rounded-lg cursor-pointer hover:bg-purple-100 transition-colors">
                                <span class="flex items-center">
                                    <i class="fas fa-paperclip mr-2"></i>
                                    <span>Adjuntar</span>
                                </span>
                                <input id="file-upload" name="archivo" type="file" class="hidden" />
                            </label>
                            <span id="file-name" class="text-sm text-gray-500"></span>
                        </div>
                        
                        <button type="submit" id="send-button" class="px-5 py-2 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="flex items-center">
                                <span class="mr-2">Enviar</span>
                                <i class="fas fa-paper-plane"></i>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            
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
                
                <div class="flex items-center ml-auto gap-2">
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
</div>

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
    let localStream;
    let screenStream;
    let isScreenSharing = false;
    let agoraClient;
    let agoraScreenClient;

    // Variables para configuración de audio/video
    let videoDevices = [];
    let audioInputDevices = [];
    let audioOutputDevices = [];
    let selectedAudioInput = '';
    let selectedAudioOutput = '';
    let selectedVideoInput = '';
    let audioContext;
    let mediaStreamSource;
    let analyzer;
    let audioLevelInterval;

    // Variables para la pizarra virtual
    let canvas;
    let ctx;
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    let currentColor = '#000000';
    let currentLineWidth = 2;
    let currentTool = 'pen';
    let drawingHistory = [];
    let historyIndex = -1;
    let textInputActive = false;
    let startX, startY;

    // Configuración por defecto
    const defaultSettings = {
        audioInput: '',
        audioOutput: '',
        videoInput: '',
        videoQuality: 'standard',
        videoBitrate: 'unlimited',
        videoFps: '24',
        echoCancellation: true,
        noiseSuppression: true,
        hardwareAcceleration: true,
        lowBandwidthMode: false
    };

    // Configuración actual
    let currentSettings = {...defaultSettings};

    // Configuración Socket.io - Hacerla configurable
    const socketServerUrl = '{{ env('SOCKET_SERVER_URL', 'http://localhost:3000') }}';
    console.log('Conectando a servidor Socket.io:', socketServerUrl);

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Botón de videollamada
        document.getElementById('video-call-btn').addEventListener('click', startVideoCall);

        // Botón de configuración
        document.getElementById('open-settings').addEventListener('click', openSettings);
        document.getElementById('close-settings').addEventListener('click', closeSettings);

        // Botón de pizarra virtual
        document.getElementById('open-whiteboard').addEventListener('click', openWhiteboard);
        document.getElementById('close-whiteboard').addEventListener('click', closeWhiteboard);

        // Botones de la pizarra
        document.getElementById('undo-whiteboard').addEventListener('click', undoWhiteboard);
        document.getElementById('clear-whiteboard').addEventListener('click', clearWhiteboard);
        document.getElementById('save-whiteboard').addEventListener('click', saveWhiteboard);

        // Herramientas de la pizarra
        const toolButtons = document.querySelectorAll('.whiteboard-tool');
        toolButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tool = button.getAttribute('data-tool');
                selectTool(tool);
            });
        });

        // Opciones de color
        const colorButtons = document.querySelectorAll('.color-option');
        colorButtons.forEach(button => {
            button.addEventListener('click', () => {
                const color = button.getAttribute('data-color');
                selectColor(color);
            });
        });

        // Opciones de grosor de línea
        const lineWidthButtons = document.querySelectorAll('.line-width-option');
        lineWidthButtons.forEach(button => {
            button.addEventListener('click', () => {
                const width = button.getAttribute('data-width');
                selectLineWidth(parseInt(width));
            });
        });

        // Gestión de pestañas de configuración
        const tabButtons = document.querySelectorAll('.settings-tab');
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab');
                switchTab(tabName);
            });
        });

        // Botones de acción de configuración
        document.getElementById('save-settings').addEventListener('click', saveSettings);
        document.getElementById('reset-settings').addEventListener('click', resetSettings);
        document.getElementById('test-audio').addEventListener('click', testAudio);

        // Cambio de dispositivos
        document.getElementById('microphone-select').addEventListener('change', changeMicrophone);
        document.getElementById('speaker-select').addEventListener('change', changeSpeaker);
        document.getElementById('camera-select').addEventListener('change', changeCamera);

        // Configuración de sonido
        document.getElementById('echo-cancellation').addEventListener('change', updateAudioConstraints);
        document.getElementById('noise-suppression').addEventListener('change', updateAudioConstraints);
    });

    async function startVideoCall() {
        console.log('Botón de videollamada presionado');
        document.getElementById('video-container').style.display = 'flex';

        try {
            // Verificar si la API de mediaDevices está disponible
            if (!navigator.mediaDevices || typeof navigator.mediaDevices.getUserMedia !== 'function') {
                throw new Error('La API de cámara no está disponible en este navegador o contexto. Intente usar HTTPS o un navegador más moderno.');
            }
            
            // Solicitar permisos explícitamente con las restricciones guardadas
            const stream = await navigator.mediaDevices.getUserMedia({
                video: getVideoConstraints(),
                audio: getAudioConstraints()
            });

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

            // Enumerar dispositivos para configuración
            await enumerateDevices();

            console.log('Cámara iniciada correctamente');
        } catch (error) {
            console.error('Error al acceder a la cámara:', error);
            alert('No se pudo acceder a la cámara o micrófono. Por favor, verifica los permisos: ' + error.message);
        }
    }

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

        // Compartir pantalla - Asegurar que funcione correctamente
        const shareScreenBtn = document.getElementById('share-screen');
        if (shareScreenBtn) {
            // Asegurarse que solo se añada un listener
            shareScreenBtn.removeEventListener('click', toggleScreenSharing);
            shareScreenBtn.addEventListener('click', toggleScreenSharing);

            console.log('Evento de compartir pantalla asignado correctamente');

            // Verificar si el navegador soporta compartir pantalla
            if (!navigator.mediaDevices || typeof navigator.mediaDevices.getDisplayMedia !== 'function') {
                console.warn('Este navegador no soporta compartir pantalla');
                shareScreenBtn.style.display = 'none';
            }
        } else {
            console.error('No se encontró el botón de compartir pantalla');
        }

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

        // Añadir manejador para el botón de pizarra
        document.getElementById('open-whiteboard').addEventListener('click', openWhiteboard);
    }

    // ---- FUNCIONES PARA LA PIZARRA VIRTUAL ----

    // Inicializar la pizarra virtual
    function initializeWhiteboard() {
        canvas = document.getElementById('whiteboard-canvas');
        ctx = canvas.getContext('2d');

        // Establecer tamaño del canvas
        resizeCanvas();

        // Listener para redimensionar el canvas cuando cambie el tamaño de la ventana
        window.addEventListener('resize', resizeCanvas);

        // Manejar eventos de ratón/táctil
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        // Soporte táctil
        canvas.addEventListener('touchstart', handleTouchStart);
        canvas.addEventListener('touchmove', handleTouchMove);
        canvas.addEventListener('touchend', handleTouchEnd);

        // Guardar el estado inicial (lienzo en blanco)
        saveState();
    }

    // Redimensionar el canvas para que se ajuste al contenedor
    function resizeCanvas() {
        const container = canvas.parentElement;
        canvas.width = container.offsetWidth;
        canvas.height = container.offsetHeight;

        // Restaurar el último estado guardado
        if (drawingHistory.length > 0 && historyIndex >= 0) {
            const img = new Image();
            img.onload = function() {
                ctx.drawImage(img, 0, 0);
            };
            img.src = drawingHistory[historyIndex];
        }

        // Restaurar configuración del contexto
        updateContextSettings();
    }

    // Actualizar la configuración del contexto de canvas
    function updateContextSettings() {
        ctx.strokeStyle = currentColor;
        ctx.lineWidth = currentLineWidth;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        if (currentTool === 'eraser') {
            ctx.globalCompositeOperation = 'destination-out';
            ctx.lineWidth = currentLineWidth * 5; // Borrador más grande
        } else {
            ctx.globalCompositeOperation = 'source-over';
        }
    }

    // Iniciar el dibujo
    function startDrawing(e) {
        if (textInputActive) return;

        isDrawing = true;

        const rect = canvas.getBoundingClientRect();
        lastX = e.clientX - rect.left;
        lastY = e.clientY - rect.top;
        startX = lastX;
        startY = lastY;

        if (currentTool === 'text') {
            createTextInput(startX, startY);
            return;
        }

        // Si estamos usando una herramienta de forma, solo guardamos el punto inicial
        if (['line', 'rectangle', 'circle'].includes(currentTool)) {
            return;
        }

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(lastX, lastY);
        ctx.stroke();
    }

    // Dibujar mientras se mueve el ratón
    function draw(e) {
        if (!isDrawing) return;

        const rect = canvas.getBoundingClientRect();
        const currentX = e.clientX - rect.left;
        const currentY = e.clientY - rect.top;

        // Si estamos usando una herramienta de forma, dibujamos una vista previa temporal
        if (['line', 'rectangle', 'circle'].includes(currentTool)) {
            // Restaurar el estado anterior para borrar la vista previa anterior
            if (drawingHistory.length > 0 && historyIndex >= 0) {
                const img = new Image();
                img.onload = function() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);

                    // Dibujar la forma actual
                    drawShape(startX, startY, currentX, currentY);
                };
                img.src = drawingHistory[historyIndex];
            }
            return;
        }

        // Para el lápiz y borrador, dibujar de forma continua
        if (['pen', 'eraser'].includes(currentTool)) {
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(currentX, currentY);
            ctx.stroke();
        }

        lastX = currentX;
        lastY = currentY;
    }

    // Detener el dibujo
    function stopDrawing(e) {
        if (!isDrawing) return;

        if (['line', 'rectangle', 'circle'].includes(currentTool)) {
            const rect = canvas.getBoundingClientRect();
            const currentX = (e.clientX || e.changedTouches[0].clientX) - rect.left;
            const currentY = (e.clientY || e.changedTouches[0].clientY) - rect.top;

            // Dibujar la forma final
            drawShape(startX, startY, currentX, currentY);

            // Guardar el estado después de dibujar la forma
            saveState();
        } else if (['pen', 'eraser'].includes(currentTool)) {
            // Para lápiz y borrador, ya hemos estado dibujando, solo guardamos el estado
            saveState();
        }

        isDrawing = false;
    }

    // Manejar eventos táctiles
    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function handleTouchMove(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }

    function handleTouchEnd(e) {
        e.preventDefault();
        const mouseEvent = new MouseEvent('mouseup', {});
        canvas.dispatchEvent(mouseEvent);
    }

    // Dibujar formas (línea, rectángulo, círculo)
    function drawShape(x1, y1, x2, y2) {
        updateContextSettings();

        switch (currentTool) {
            case 'line':
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
                break;

            case 'rectangle':
                const width = x2 - x1;
                const height = y2 - y1;
                ctx.beginPath();
                ctx.rect(x1, y1, width, height);
                ctx.stroke();
                break;

            case 'circle':
                const radius = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
                ctx.beginPath();
                ctx.arc(x1, y1, radius, 0, 2 * Math.PI);
                ctx.stroke();
                break;
        }
    }

    // Crear un campo de texto
    function createTextInput(x, y) {
        // Eliminar cualquier input de texto existente
        const existingInput = document.getElementById('whiteboard-text-input');
        if (existingInput) {
            existingInput.remove();
        }

        // Crear un nuevo input
        const input = document.createElement('input');
        input.type = 'text';
        input.id = 'whiteboard-text-input';
        input.className = 'absolute bg-transparent border border-blue-400 px-1 outline-none';
        input.style.left = x + 'px';
        input.style.top = y + 'px';
        input.style.color = currentColor;
        input.style.fontSize = (currentLineWidth * 8) + 'px';
        input.style.fontFamily = 'Arial, sans-serif';

        // Añadir al contenedor del canvas
        canvas.parentElement.appendChild(input);

        // Enfocar el input
        input.focus();
        textInputActive = true;

        // Manejar cambio de tamaño del input mientras se escribe
        input.addEventListener('input', function() {
            this.style.width = (this.value.length * 0.7 + 1) + 'em';
        });

        // Confirmar el texto cuando se presiona Enter o se pierde el foco
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                commitText(input);
            }
        });

        input.addEventListener('blur', function() {
            commitText(input);
        });
    }

    // Añadir el texto escrito al canvas
    function commitText(input) {
        if (input.value.trim() !== '') {
            const x = parseInt(input.style.left);
            const y = parseInt(input.style.top);

            // Dibujar el texto en el canvas
            ctx.fillStyle = currentColor;
            ctx.font = input.style.fontSize + ' Arial, sans-serif';
            ctx.fillText(input.value, x, y + parseInt(input.style.fontSize));

            // Guardar el estado después de añadir texto
            saveState();
        }

        // Eliminar el input
        input.remove();
        textInputActive = false;
    }

    // Seleccionar herramienta
    function selectTool(tool) {
        currentTool = tool;

        // Desactivar todas las herramientas
        document.querySelectorAll('.whiteboard-tool').forEach(btn => {
            btn.classList.remove('active');
            btn.querySelector('div').classList.remove('bg-purple-50', 'border-purple-200');
            btn.querySelector('i').classList.remove('text-[#5e0490]');
            btn.querySelector('i').classList.add('text-gray-600');
        });

        // Activar la herramienta seleccionada
        const selectedButton = document.querySelector(`.whiteboard-tool[data-tool="${tool}"]`);
        selectedButton.classList.add('active');
        selectedButton.querySelector('div').classList.add('bg-purple-50', 'border-purple-200');
        selectedButton.querySelector('i').classList.remove('text-gray-600');
        selectedButton.querySelector('i').classList.add('text-[#5e0490]');

        // Actualizar estilo del cursor
        if (tool === 'eraser') {
            canvas.classList.remove('cursor-crosshair');
            canvas.classList.add('cursor-cell');
        } else if (tool === 'text') {
            canvas.classList.remove('cursor-crosshair', 'cursor-cell');
            canvas.classList.add('cursor-text');
        } else {
            canvas.classList.remove('cursor-cell', 'cursor-text');
            canvas.classList.add('cursor-crosshair');
        }

        // Actualizar la configuración del contexto
        if (ctx) {
            updateContextSettings();
        }
    }

    // Seleccionar color
    function selectColor(color) {
        currentColor = color;

        // Desactivar todos los colores
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('border-purple-500');
            btn.classList.add('border-gray-300');
        });

        // Activar el color seleccionado
        const selectedButton = document.querySelector(`.color-option[data-color="${color}"]`);
        selectedButton.classList.add('active', 'border-purple-500');
        selectedButton.classList.remove('border-gray-300');

        // Actualizar los colores en los selectores de grosor
        document.querySelectorAll('.line-width-option div').forEach(div => {
            div.style.backgroundColor = color;
        });

        // Actualizar la configuración del contexto
        if (ctx) {
            updateContextSettings();
        }
    }

    // Seleccionar grosor de línea
    function selectLineWidth(width) {
        currentLineWidth = width;

        // Desactivar todos los grosores
        document.querySelectorAll('.line-width-option').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('bg-gray-100');
        });

        // Activar el grosor seleccionado
        const selectedButton = document.querySelector(`.line-width-option[data-width="${width}"]`);
        selectedButton.classList.add('active', 'bg-gray-100');

        // Actualizar la configuración del contexto
        if (ctx) {
            updateContextSettings();
        }
    }

    // Guardar el estado actual de la pizarra
    function saveState() {
        // Truncar el historial si hemos hecho deshacer y luego dibujamos algo nuevo
        if (historyIndex < drawingHistory.length - 1) {
            drawingHistory = drawingHistory.slice(0, historyIndex + 1);
        }

        // Guardar el estado actual
        drawingHistory.push(canvas.toDataURL());
        historyIndex = drawingHistory.length - 1;

        // Habilitar/deshabilitar el botón de deshacer
        document.getElementById('undo-whiteboard').disabled = historyIndex <= 0;
    }

    // Deshacer último cambio
    function undoWhiteboard() {
        if (historyIndex <= 0) return;

        historyIndex--;
        const img = new Image();
        img.onload = function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0);
        };
        img.src = drawingHistory[historyIndex];

        // Deshabilitar el botón de deshacer si ya no podemos deshacer más
        document.getElementById('undo-whiteboard').disabled = historyIndex <= 0;
    }

    // Limpiar la pizarra
    function clearWhiteboard() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Se borrará todo el contenido de la pizarra',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5e0490',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar todo',
            cancelButtonText: 'Cancelar',
            background: '#fff',
            backdrop: 'rgba(0,0,0,0.4)',
            customClass: {
                confirmButton: 'px-4 py-2 rounded-md text-white',
                cancelButton: 'px-4 py-2 rounded-md text-white'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                saveState();

                Swal.fire({
                    title: '¡Borrado!',
                    text: 'La pizarra ha sido limpiada',
                    icon: 'success',
                    confirmButtonColor: '#5e0490',
                    confirmButtonText: 'Continuar',
                    timer: 1500,
                    timerProgressBar: true,
                    customClass: {
                        confirmButton: 'px-4 py-2 rounded-md text-white'
                    }
                });
            }
        });
    }

    // Guardar la pizarra como imagen
    function saveWhiteboard() {
        const link = document.createElement('a');
        link.download = 'pizarra_' + new Date().toISOString().slice(0, 19).replace(/[:.]/g, '-') + '.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    // Abrir la pizarra virtual
    function openWhiteboard() {
        document.getElementById('whiteboard-panel').style.display = 'flex';

        // Inicializar la pizarra si no se ha hecho ya
        if (!canvas) {
            initializeWhiteboard();
        } else {
            // Redimensionar el canvas por si ha cambiado el tamaño del contenedor
            resizeCanvas();
        }

        // Transferir streams de video a la pizarra
        transferVideoStreams();

        // Configurar el botón para expandir/contraer el video
        setupVideoSizeToggle();
    }

    // Transferir streams de video a la pizarra
    function transferVideoStreams() {
        const mainLocalVideo = document.getElementById('local-video');
        const mainRemoteVideo = document.getElementById('remote-video');
        const whiteboardLocalVideo = document.getElementById('whiteboard-local-video');
        const whiteboardRemoteVideo = document.getElementById('whiteboard-remote-video');

        // Transferir el stream local
        if (mainLocalVideo && mainLocalVideo.srcObject && whiteboardLocalVideo) {
            whiteboardLocalVideo.srcObject = mainLocalVideo.srcObject;

            // Si estamos compartiendo pantalla, agregar indicador
            if (isScreenSharing) {
                const whiteboardContainer = whiteboardLocalVideo.parentElement;
                let screenShareIndicator = whiteboardContainer.querySelector('.wb-screen-share-indicator');

                if (!screenShareIndicator) {
                    screenShareIndicator = document.createElement('div');
                    screenShareIndicator.className = 'wb-screen-share-indicator absolute top-1 right-1 bg-red-500 text-white text-xs px-1 py-0.5 rounded-full flex items-center animate-pulse';
                    screenShareIndicator.innerHTML = '<i class="fas fa-desktop text-xs mr-1"></i><span class="text-[10px]">Compartiendo</span>';
                    whiteboardContainer.appendChild(screenShareIndicator);
                }
            }
        }

        // Transferir el stream remoto
        if (mainRemoteVideo && mainRemoteVideo.srcObject && whiteboardRemoteVideo) {
            whiteboardRemoteVideo.srcObject = mainRemoteVideo.srcObject;
        }
    }

    // Configurar el toggle de tamaño del contenedor de video
    function setupVideoSizeToggle() {
        const toggleButton = document.getElementById('toggle-video-size');
        const videoContainer = document.getElementById('whiteboard-video-container');

        if (!toggleButton || !videoContainer) return;

        // Estado inicial
        let isExpanded = false;

        toggleButton.addEventListener('click', function() {
            if (isExpanded) {
                // Contraer
                videoContainer.classList.remove('w-96', 'h-72');
                videoContainer.classList.add('w-64', 'h-48');
                toggleButton.innerHTML = '<i class="fas fa-expand-alt text-xs"></i>';
            } else {
                // Expandir
                videoContainer.classList.remove('w-64', 'h-48');
                videoContainer.classList.add('w-96', 'h-72');
                toggleButton.innerHTML = '<i class="fas fa-compress-alt text-xs"></i>';
            }

            isExpanded = !isExpanded;
        });

        // Hacer el contenedor arrastrable
        makeElementDraggable(videoContainer);
    }

    // Hacer un elemento arrastrable dentro de su contenedor padre
    function makeElementDraggable(element) {
        const dragHandle = document.getElementById('drag-handle');

        if (!dragHandle || !element) return;

        let isDragging = false;
        let initialX, initialY;
        let currentX = parseInt(element.style.right || '16') * -1;
        let currentY = parseInt(element.style.bottom || '16') * -1;

        // Función para iniciar el arrastre
        function startDrag(e) {
            // Si es evento táctil, usar el primer toque
            const clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
            const clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;

            isDragging = true;
            initialX = clientX - currentX;
            initialY = clientY - currentY;

            // Añadir clase para indicar estado de arrastre
            element.classList.add('dragging');

            // Evitar arrastrar el canvas mientras se arrastra el video
            e.preventDefault();
            e.stopPropagation();
        }

        // Función para mover durante el arrastre
        function drag(e) {
            if (!isDragging) return;

            // Si es evento táctil, usar el primer toque
            const clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
            const clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;

            // Calcular nueva posición
            currentX = clientX - initialX;
            currentY = clientY - initialY;

            // Obtener dimensiones del contenedor padre y del elemento
            const canvas = document.getElementById('whiteboard-canvas');
            const canvasRect = canvas.getBoundingClientRect();
            const elementRect = element.getBoundingClientRect();

            // Mantener dentro de los límites de la pizarra (considerando el tamaño del elemento)
            const maxX = canvasRect.width - elementRect.width;
            const maxY = canvasRect.height - elementRect.height;

            currentX = Math.max(0, Math.min(currentX, maxX));
            currentY = Math.max(0, Math.min(currentY, maxY));

            // Actualizar posición con transform (mejor rendimiento)
            element.style.transform = `translate(${currentX}px, ${currentY}px)`;

            // Reset de las propiedades originales (importante para que transform funcione correctamente)
            element.style.bottom = 'auto';
            element.style.right = 'auto';
            element.style.top = '0';
            element.style.left = '0';

            // Evitar arrastrar el canvas mientras se arrastra el video
            e.preventDefault();
            e.stopPropagation();
        }

        // Función para finalizar el arrastre
        function endDrag() {
            if (!isDragging) return;

            isDragging = false;
            element.classList.remove('dragging');

            // Guardar la última posición
            element.setAttribute('data-x', currentX.toString());
            element.setAttribute('data-y', currentY.toString());
        }

        // Eventos de ratón
        dragHandle.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', endDrag);

        // Eventos táctiles
        dragHandle.addEventListener('touchstart', startDrag, { passive: false });
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('touchend', endDrag);

        // Restaurar la posición guardada si existe
        const savedX = element.getAttribute('data-x');
        const savedY = element.getAttribute('data-y');
        if (savedX && savedY) {
            currentX = parseInt(savedX);
            currentY = parseInt(savedY);
            element.style.transform = `translate(${currentX}px, ${currentY}px)`;
            element.style.bottom = 'auto';
            element.style.right = 'auto';
            element.style.top = '0';
            element.style.left = '0';
        }
    }

    // Cerrar la pizarra virtual
    function closeWhiteboard() {
        document.getElementById('whiteboard-panel').style.display = 'none';

        // Detener referencia a los videos (opcional, para liberar recursos)
        const whiteboardLocalVideo = document.getElementById('whiteboard-local-video');
        const whiteboardRemoteVideo = document.getElementById('whiteboard-remote-video');

        if (whiteboardLocalVideo) whiteboardLocalVideo.srcObject = null;
        if (whiteboardRemoteVideo) whiteboardRemoteVideo.srcObject = null;
    }

    // ---- FUNCIONES DE CONFIGURACIÓN DE DISPOSITIVOS Y OTRAS EXISTENTES ----

    // Enumerar dispositivos disponibles
    async function enumerateDevices() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();

            // Limpiar arrays
            videoDevices = [];
            audioInputDevices = [];
            audioOutputDevices = [];

            // Clasificar dispositivos
            devices.forEach(device => {
                if (device.kind === 'videoinput') {
                    videoDevices.push(device);
                } else if (device.kind === 'audioinput') {
                    audioInputDevices.push(device);
                } else if (device.kind === 'audiooutput') {
                    audioOutputDevices.push(device);
                }
            });

            // Actualizar selectores
            updateDeviceSelectors();

            // Si no se han seleccionado dispositivos, seleccionar los primeros disponibles
            if (!selectedAudioInput && audioInputDevices.length > 0) {
                selectedAudioInput = audioInputDevices[0].deviceId;
            }

            if (!selectedVideoInput && videoDevices.length > 0) {
                selectedVideoInput = videoDevices[0].deviceId;
            }

            if (!selectedAudioOutput && audioOutputDevices.length > 0) {
                selectedAudioOutput = audioOutputDevices[0].deviceId;
            }
        } catch (error) {
            console.error('Error al enumerar dispositivos:', error);
        }
    }

    // Actualizar selectores de dispositivos
    function updateDeviceSelectors() {
        const micSelect = document.getElementById('microphone-select');
        const speakerSelect = document.getElementById('speaker-select');
        const cameraSelect = document.getElementById('camera-select');

        // Limpiar selectores
        micSelect.innerHTML = '';
        speakerSelect.innerHTML = '';
        cameraSelect.innerHTML = '';

        // Actualizar selector de micrófonos
        audioInputDevices.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Micrófono ${micSelect.options.length + 1}`;
            micSelect.appendChild(option);
        });

        // Actualizar selector de altavoces
        audioOutputDevices.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Altavoz ${speakerSelect.options.length + 1}`;
            speakerSelect.appendChild(option);
        });

        // Actualizar selector de cámaras
        videoDevices.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Cámara ${cameraSelect.options.length + 1}`;
            cameraSelect.appendChild(option);
        });

        // Seleccionar dispositivos actuales
        if (selectedAudioInput) {
            micSelect.value = selectedAudioInput;
        }

        if (selectedAudioOutput) {
            speakerSelect.value = selectedAudioOutput;
        }

        if (selectedVideoInput) {
            cameraSelect.value = selectedVideoInput;
        }
    }

    // Cambiar micrófono
    async function changeMicrophone() {
        const micSelect = document.getElementById('microphone-select');
        selectedAudioInput = micSelect.value;

        if (localStream) {
            // Detener pistas de audio actuales
            localStream.getAudioTracks().forEach(track => track.stop());

            try {
                // Obtener nueva pista de audio
                const newStream = await navigator.mediaDevices.getUserMedia({
                    audio: getAudioConstraints()
                });

                // Reemplazar pista de audio en el stream local
                const newAudioTrack = newStream.getAudioTracks()[0];
                const oldAudioTrack = localStream.getAudioTracks()[0];

                if (oldAudioTrack) {
                    localStream.removeTrack(oldAudioTrack);
                }

                localStream.addTrack(newAudioTrack);

                // Actualizar el medidor de audio
                setupAudioMeter(newStream);

                // Si estamos en una llamada, actualizar la pista en la conexión peer
                if (agoraClient) {
                    // Código específico para Agora
                }
            } catch (error) {
                console.error('Error al cambiar de micrófono:', error);
            }
        }
    }

    // Cambiar altavoz (solo funciona si el navegador lo soporta)
    function changeSpeaker() {
        const speakerSelect = document.getElementById('speaker-select');
        selectedAudioOutput = speakerSelect.value;

        const remoteVideo = document.getElementById('remote-video');
        if (remoteVideo && typeof remoteVideo.setSinkId === 'function') {
            remoteVideo.setSinkId(selectedAudioOutput)
                .then(() => console.log('Altavoz cambiado con éxito'))
                .catch(error => console.error('Error al cambiar de altavoz:', error));
        } else {
            console.warn('Este navegador no soporta selección de dispositivo de salida de audio');
        }
    }

    // Cambiar cámara
    async function changeCamera() {
        const cameraSelect = document.getElementById('camera-select');
        selectedVideoInput = cameraSelect.value;

        // Actualizar vista previa de la cámara
        updateCameraPreview();

        if (localStream) {
            // Detener pistas de video actuales
            localStream.getVideoTracks().forEach(track => track.stop());

            try {
                // Obtener nueva pista de video
                const newStream = await navigator.mediaDevices.getUserMedia({
                    video: getVideoConstraints()
                });

                // Reemplazar pista de video en el stream local
                const newVideoTrack = newStream.getVideoTracks()[0];
                const oldVideoTrack = localStream.getVideoTracks()[0];

                if (oldVideoTrack) {
                    localStream.removeTrack(oldVideoTrack);
                }

                localStream.addTrack(newVideoTrack);

                // Actualizar video local
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                }

                // Si estamos en una llamada, actualizar la pista en la conexión peer
                if (agoraClient) {
                    // Código específico para Agora
                }
            } catch (error) {
                console.error('Error al cambiar de cámara:', error);
            }
        }
    }

    // Actualizar vista previa de la cámara
    async function updateCameraPreview() {
        const preview = document.getElementById('camera-preview');
        const noCamera = document.getElementById('no-camera-message');

        try {
            // Detener cualquier pista de video que estuviera reproduciéndose
            if (preview.srcObject) {
                preview.srcObject.getTracks().forEach(track => track.stop());
            }

            // Obtener nueva pista de video para la vista previa
            const previewStream = await navigator.mediaDevices.getUserMedia({
                video: getVideoConstraints(),
                audio: false
            });

            preview.srcObject = previewStream;
            preview.style.display = 'block';
            noCamera.style.display = 'none';
        } catch (error) {
            console.error('Error al mostrar vista previa de la cámara:', error);
            preview.style.display = 'none';
            noCamera.style.display = 'flex';
        }
    }

    // Obtener restricciones de audio basadas en configuración
    function getAudioConstraints() {
        return {
            deviceId: selectedAudioInput ? { exact: selectedAudioInput } : undefined,
            echoCancellation: document.getElementById('echo-cancellation').checked,
            noiseSuppression: document.getElementById('noise-suppression').checked,
            autoGainControl: true
        };
    }

    // Obtener restricciones de video basadas en configuración
    function getVideoConstraints() {
        const qualitySelect = document.getElementById('video-quality');
        const fpsSelect = document.getElementById('video-fps');

        let width, height;
        switch (qualitySelect.value) {
            case 'low':
                width = 320;
                height = 240;
                break;
            case 'standard':
                width = 640;
                height = 480;
                break;
            case 'high':
                width = 1280;
                height = 720;
                break;
            case 'hd':
                width = 1920;
                height = 1080;
                break;
            default:
                width = 640;
                height = 480;
        }

        return {
            deviceId: selectedVideoInput ? { exact: selectedVideoInput } : undefined,
            width: { ideal: width },
            height: { ideal: height },
            frameRate: { ideal: parseInt(fpsSelect.value) }
        };
    }

    // Actualizar restricciones de audio en tiempo real
    function updateAudioConstraints() {
        if (localStream && localStream.getAudioTracks().length > 0) {
            changeMicrophone();
        }
    }

    // Configurar el medidor de nivel de audio
    function setupAudioMeter(stream) {
        try {
            // Detener el intervalo anterior si existe
            if (audioLevelInterval) {
                clearInterval(audioLevelInterval);
            }

            // Crear contexto de audio si no existe
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }

            // Crear fuente de stream y analizador
            mediaStreamSource = audioContext.createMediaStreamSource(stream);
            analyzer = audioContext.createAnalyser();
            analyzer.fftSize = 256;
            mediaStreamSource.connect(analyzer);

            // Configurar array para los datos del analizador
            const dataArray = new Uint8Array(analyzer.frequencyBinCount);
            const micLevelIndicator = document.getElementById('mic-level-indicator');
            const micLevelValue = document.getElementById('mic-level-value');

            // Actualizar el nivel cada 100ms
            audioLevelInterval = setInterval(() => {
                analyzer.getByteFrequencyData(dataArray);

                // Calcular el nivel de audio (0-100)
                let sum = 0;
                for (let i = 0; i < dataArray.length; i++) {
                    sum += dataArray[i];
                }

                const average = sum / dataArray.length;
                const level = Math.min(100, Math.round((average / 255) * 100));

                // Actualizar UI
                micLevelIndicator.style.width = `${level}%`;
                micLevelValue.textContent = `${level}%`;

                // Añadir clase según el nivel
                if (level > 70) {
                    micLevelIndicator.className = 'h-full bg-red-500 transition-all';
                } else if (level > 30) {
                    micLevelIndicator.className = 'h-full bg-yellow-500 transition-all';
                } else {
                    micLevelIndicator.className = 'h-full bg-green-500 transition-all';
                }
            }, 100);
        } catch (error) {
            console.error('Error al configurar el medidor de audio:', error);
        }
    }

    // Probar sonido del altavoz
    function testAudio() {
        // Crear un elemento de audio
        const testSound = new Audio('/notification.mp3');

        // Asignar dispositivo de salida si está soportado
        if (typeof testSound.setSinkId === 'function' && selectedAudioOutput) {
            testSound.setSinkId(selectedAudioOutput)
                .then(() => {
                    testSound.play();
                })
                .catch(error => {
                    console.error('Error al asignar dispositivo de salida:', error);
                    testSound.play();
                });
        } else {
            testSound.play();
        }
    }

    // ---- FUNCIONES DE LA INTERFAZ DE CONFIGURACIÓN ----

    // Abrir panel de configuración
    function openSettings() {
        document.getElementById('settings-panel').style.display = 'flex';

        // Cargar dispositivos actuales
        enumerateDevices().then(() => {
            // Mostrar vista previa de la cámara
            updateCameraPreview();

            // Configurar medidor de audio si hay stream activo
            if (localStream && localStream.getAudioTracks().length > 0) {
                setupAudioMeter(localStream);
            }
        });
    }

    // Cerrar panel de configuración
    function closeSettings() {
        document.getElementById('settings-panel').style.display = 'none';

        // Detener el medidor de audio
        if (audioLevelInterval) {
            clearInterval(audioLevelInterval);
        }

        // Detener la vista previa
        const preview = document.getElementById('camera-preview');
        if (preview.srcObject) {
            preview.srcObject.getTracks().forEach(track => track.stop());
            preview.srcObject = null;
        }
    }

    // Cambiar entre pestañas
    function switchTab(tabName) {
        // Ocultar todos los contenidos
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        // Desactivar todos los botones
        document.querySelectorAll('.settings-tab').forEach(button => {
            button.classList.remove('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
            button.classList.add('text-gray-500');
        });

        // Mostrar contenido de la pestaña seleccionada
        document.getElementById(`${tabName}-tab`).classList.remove('hidden');

        // Activar botón seleccionado
        const activeButton = document.querySelector(`.settings-tab[data-tab="${tabName}"]`);
        activeButton.classList.remove('text-gray-500');
        activeButton.classList.add('text-[#5e0490]', 'border-b-2', 'border-[#5e0490]');
    }

    // Guardar configuración
    function saveSettings() {
        // Guardar valores actuales
        currentSettings = {
            audioInput: document.getElementById('microphone-select').value,
            audioOutput: document.getElementById('speaker-select').value,
            videoInput: document.getElementById('camera-select').value,
            videoQuality: document.getElementById('video-quality').value,
            videoBitrate: document.getElementById('bandwidth-limit').value,
            videoFps: document.getElementById('video-fps').value,
            echoCancellation: document.getElementById('echo-cancellation').checked,
            noiseSuppression: document.getElementById('noise-suppression').checked,
            hardwareAcceleration: document.getElementById('hardware-acceleration').checked,
            lowBandwidthMode: document.getElementById('low-bandwidth-mode').checked
        };

        // Guardar en localStorage para persistencia
        localStorage.setItem('videocallSettings', JSON.stringify(currentSettings));

        // Aplicar cambios si hay una videollamada activa
        if (localStream) {
            changeCamera();
            changeMicrophone();
            changeSpeaker();
        }

        // Cerrar panel
        closeSettings();
    }

    // Restablecer configuración
    function resetSettings() {
        // Restablecer valores a los predeterminados
        document.getElementById('echo-cancellation').checked = defaultSettings.echoCancellation;
        document.getElementById('noise-suppression').checked = defaultSettings.noiseSuppression;
        document.getElementById('video-quality').value = defaultSettings.videoQuality;
        document.getElementById('bandwidth-limit').value = defaultSettings.videoBitrate;
        document.getElementById('video-fps').value = defaultSettings.videoFps;
        document.getElementById('hardware-acceleration').checked = defaultSettings.hardwareAcceleration;
        document.getElementById('low-bandwidth-mode').checked = defaultSettings.lowBandwidthMode;

        // Actualizar vista previa con los cambios
        updateCameraPreview();
    }

    // Función para compartir pantalla
    async function toggleScreenSharing() {
        if (!localStream) {
            console.error('No hay stream local disponible');
            alert('Primero necesitas iniciar la videollamada para compartir tu pantalla');
            return;
        }

        try {
            if (isScreenSharing) {
                await stopScreenSharing();
            } else {
                await startScreenSharing();
            }
        } catch (error) {
            console.error('Error al alternar compartir pantalla:', error);
            alert('No se pudo compartir pantalla: ' + error.message);
        }
    }

    // Iniciar compartir pantalla
    async function startScreenSharing() {
        try {
            console.log('Iniciando compartición de pantalla...');

            // Cambiar estado visual del botón para indicar que está procesando
            const shareButton = document.getElementById('share-screen');
            shareButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';

            // Solicitar acceso a la pantalla con opciones mejoradas
            screenStream = await navigator.mediaDevices.getDisplayMedia({
                video: {
                    cursor: 'always',
                    displaySurface: 'monitor',
                    logicalSurface: true,
                    frameRate: 30
                },
                audio: false
            });

            // Guardar la referencia al video local original para restaurar después
            const localVideo = document.getElementById('local-video');
            const localContainer = document.getElementById('local-video-container');

            // Mostrar la pantalla compartida en el video local
            localVideo.srcObject = screenStream;

            // Agregar un indicador visual de compartir pantalla
            let screenShareIndicator = document.getElementById('screen-share-indicator');
            if (!screenShareIndicator) {
                screenShareIndicator = document.createElement('div');
                screenShareIndicator.id = 'screen-share-indicator';
                screenShareIndicator.className = 'absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full flex items-center animate-pulse';
                screenShareIndicator.innerHTML = '<i class="fas fa-desktop mr-1"></i> Compartiendo pantalla';
                localContainer.appendChild(screenShareIndicator);
            } else {
                screenShareIndicator.style.display = 'flex';
            }

            // Marcar el botón como activo
            shareButton.innerHTML = '<i class="fas fa-desktop"></i>';
            shareButton.classList.add('bg-green-500');
            shareButton.classList.remove('bg-white', 'bg-opacity-20');

            // Actualizar estado
            isScreenSharing = true;

            // Detectar cuando el usuario detiene la compartición de pantalla desde el navegador
            screenStream.getVideoTracks()[0].onended = function() {
                stopScreenSharing();
            };

            // Mostrar una notificación
            Swal.fire({
                title: 'Compartiendo pantalla',
                text: 'Tu pantalla está siendo compartida',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });

            console.log('Compartición de pantalla iniciada');
        } catch (error) {
            // Si el usuario cancela la selección, no mostrar error
            if (error.name === 'NotAllowedError' || error.name === 'AbortError') {
                console.log('Usuario canceló la compartición de pantalla');
            } else {
                console.error('Error al iniciar la compartición de pantalla:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo compartir la pantalla: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#5e0490'
                });
            }

            // Restaurar botón
            const shareButton = document.getElementById('share-screen');
            shareButton.innerHTML = '<i class="fas fa-desktop"></i>';

            throw error;
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

            // Ocultar el indicador de compartir pantalla
            const screenShareIndicator = document.getElementById('screen-share-indicator');
            if (screenShareIndicator) {
                screenShareIndicator.style.display = 'none';
            }

            // Restaurar el aspecto del botón
            const shareButton = document.getElementById('share-screen');
            shareButton.classList.remove('bg-green-500');
            shareButton.classList.add('bg-white', 'bg-opacity-20');

            // Actualizar estado
            isScreenSharing = false;
            screenStream = null;

            // Mostrar notificación
            Swal.fire({
                title: 'Compartición finalizada',
                text: 'Has dejado de compartir tu pantalla',
                icon: 'info',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });

            console.log('Compartición de pantalla detenida');
        } catch (error) {
            console.error('Error al detener la compartición de pantalla:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un problema al detener la compartición: ' + error.message,
                icon: 'warning',
                confirmButtonColor: '#5e0490'
            });
        }
    }

    // Comprobar si hay configuración guardada al cargar
    (function loadSavedSettings() {
        try {
            const savedSettings = localStorage.getItem('videocallSettings');
            if (savedSettings) {
                currentSettings = JSON.parse(savedSettings);

                // Aplicar cuando se abra el panel de configuración
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('open-settings').addEventListener('click', function() {
                        setTimeout(() => {
                            // Aplicar valores guardados a los controles
                            if (currentSettings.echoCancellation !== undefined) {
                                document.getElementById('echo-cancellation').checked = currentSettings.echoCancellation;
                            }

                            if (currentSettings.noiseSuppression !== undefined) {
                                document.getElementById('noise-suppression').checked = currentSettings.noiseSuppression;
                            }

                            if (currentSettings.videoQuality) {
                                document.getElementById('video-quality').value = currentSettings.videoQuality;
                            }

                            if (currentSettings.videoBitrate) {
                                document.getElementById('bandwidth-limit').value = currentSettings.videoBitrate;
                            }

                            if (currentSettings.videoFps) {
                                document.getElementById('video-fps').value = currentSettings.videoFps;
                            }

                            if (currentSettings.hardwareAcceleration !== undefined) {
                                document.getElementById('hardware-acceleration').checked = currentSettings.hardwareAcceleration;
                            }

                            if (currentSettings.lowBandwidthMode !== undefined) {
                                document.getElementById('low-bandwidth-mode').checked = currentSettings.lowBandwidthMode;
                            }
                        }, 500);
                    });
                });
            }
        } catch (error) {
            console.error('Error al cargar configuración guardada:', error);
        }
    })();

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
        /* Añadir un sonido de notificación para la prueba de audio */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            80% {
                opacity: 0.5;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Estilos para el input de texto en la pizarra */
        #whiteboard-text-input {
            position: absolute;
            background: transparent;
            min-width: 50px;
        }
        </style>
    `);
</script>
<script src="{{ asset('js/chat-detail.js') }}"></script>

<!-- Añadir soporte de Pusher para el chat en tiempo real -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Pusher con nuestra clave y opciones
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
        }
    });
    
    // Suscribirse al canal privado del chat
    const channel = pusher.subscribe('private-chat.{{ $chat->id }}');
    
    // Escuchar por eventos de nuevos mensajes
    channel.bind('App\\Events\\MessageSent', function(data) {
        // Solo procesar si el mensaje es de otra persona
        if (data.user_id !== {{ auth()->id() }}) {
            // Llamar a función para agregar mensaje a la conversación
            appendMessage(data);
            
            // Reproducir sonido de notificación
            playMessageSound();
            
            // Actualizar estado de lectura
            markMessageAsRead(data.id);
        }
    });
    
    // Función para agregar mensaje recibido al chat
    function appendMessage(data) {
        const chatMessages = document.getElementById('chat-messages');
        let messageHtml = '';
        
        // Crear elemento HTML para el mensaje recibido
        if (data.user_id !== {{ auth()->id() }}) {
            // Mensaje recibido (de la otra persona)
            messageHtml = `
                <div class="flex items-start message" data-message-id="${data.id}">
                    <div class="flex-shrink-0 mr-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden shadow-md">
                            ${data.user.imagen 
                                ? `<img src="{{ asset('profile_images/') }}/${data.user.imagen}" alt="Foto de perfil" class="w-full h-full object-cover">` 
                                : `<span class="text-base font-bold text-gray-700">${data.user.nombre.substring(0, 2).toUpperCase()}</span>`
                            }
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white rounded-2xl p-4 shadow-md inline-block max-w-[85%] relative message-bubble">
                            <p class="text-sm text-gray-800 message-content">${data.contenido}</p>
                            ${data.archivo_adjunto ? generateAttachmentHTML(data) : ''}
                            <div class="text-xs text-gray-500 mt-1 flex items-center justify-between">
                                <span>${formatMessageTime(new Date(data.created_at))}</span>
                            </div>
                            <div class="absolute h-4 w-4 bg-white transform rotate-45 left-[-8px] top-4"></div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        if (messageHtml) {
            // Agregar mensaje al contenedor
            const messagesContainer = document.getElementById('chat-messages');
            
            // Verificar si debemos hacer scroll automático
            const shouldScroll = messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < 100;
            
            // Insertar HTML del mensaje
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = messageHtml;
            const messageElement = tempDiv.firstElementChild;
            messagesContainer.appendChild(messageElement);
            
            // Aplicar animación de entrada
            setTimeout(() => {
                messageElement.classList.add('animate-fadeIn');
            }, 50);
            
            // Hacer scroll al final si estábamos cerca del final
            if (shouldScroll) {
                scrollToBottom();
            } else {
                // Mostrar botón "nuevos mensajes" si no estamos en el fondo
                showNewMessageAlert();
            }
        }
    }
    
    // Generar HTML para archivos adjuntos
    function generateAttachmentHTML(data) {
        if (!data.archivo_adjunto) return '';
        
        const isImage = data.tipo_archivo && data.tipo_archivo.startsWith('image/');
        
        if (isImage) {
            return `
                <div class="mt-2 relative group">
                    <a href="${data.archivo_adjunto}" target="_blank" class="block">
                        <img src="${data.archivo_adjunto}" alt="Imagen adjunta" class="max-w-full max-h-60 rounded-lg shadow-sm">
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
                    <a href="${data.archivo_adjunto}" target="_blank" class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors duration-200">
                        <div class="mr-3 bg-gray-200 w-10 h-10 rounded-lg flex items-center justify-center text-gray-500">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${data.nombre_archivo || 'Archivo adjunto'}</p>
                            <p class="text-xs text-gray-500">Descargar archivo</p>
                        </div>
                        <i class="fas fa-download text-purple-600"></i>
                    </a>
                </div>
            `;
        }
    }
    
    // Formatear hora del mensaje
    function formatMessageTime(date) {
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }
    
    // Reproducir sonido de notificación
    function playMessageSound() {
        const audio = new Audio('/sounds/message.mp3');
        audio.volume = 0.5;
        audio.play().catch(e => console.log('Error reproduciendo sonido:', e));
    }
    
    // Marcar mensaje como leído
    function markMessageAsRead(messageId) {
        fetch(`/chat/${messageId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).catch(e => console.error('Error marcando mensaje como leído:', e));
    }
    
    // Animación de scroll al fondo
    function scrollToBottom() {
        const messagesContainer = document.getElementById('chat-messages');
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: 'smooth'
        });
    }
    
    // Mostrar alerta de nuevos mensajes
    function showNewMessageAlert() {
        let newMessageAlert = document.getElementById('new-message-alert');
        if (!newMessageAlert) {
            newMessageAlert = document.createElement('div');
            newMessageAlert.id = 'new-message-alert';
            newMessageAlert.className = 'fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-purple-600 text-white px-4 py-2 rounded-full shadow-lg cursor-pointer z-10 animate-bounce';
            newMessageAlert.innerHTML = '<i class="fas fa-chevron-down mr-2"></i> Nuevos mensajes';
            newMessageAlert.addEventListener('click', scrollToBottom);
            document.body.appendChild(newMessageAlert);
            
            // Auto-ocultar después de 5 segundos
            setTimeout(() => {
                if (newMessageAlert.parentNode) {
                    newMessageAlert.remove();
                }
            }, 5000);
        }
    }
    
    // Inicializar envío de mensajes con Pusher
    const messageForm = document.getElementById('message-form');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();
            
            if (message) {
                // Limpiar input antes de enviar para mejor UX
                messageInput.value = '';
                
                // Crear formdata
                const formData = new FormData();
                formData.append('contenido', message);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Enviar mensaje mediante fetch API
                fetch('{{ route("chat.message", $chat->id) }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error enviando mensaje:', data.message);
                        // Restaurar mensaje en caso de error
                        messageInput.value = message;
                    } else {
                        // El mensaje se envió correctamente
                        // Agregar mensaje a interfaz (opcional ya que Pusher también lo mostrará)
                        // appendSentMessage(data.mensaje);
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    messageInput.value = message;
                });
            }
        });
    }
    
    // Inicializar envío de archivos con Pusher
    const fileInput = document.getElementById('file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                // Mostrar vista previa
                showFilePreview(file);
                
                // Crear formdata
                const formData = new FormData();
                formData.append('archivo', file);
                formData.append('_token', '{{ csrf_token() }}');
                
                // Mostrar indicador de carga
                showUploadingIndicator();
                
                // Enviar archivo
                fetch('{{ route("chat.message", $chat->id) }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error enviando archivo:', data.message);
                        hideUploadingIndicator();
                    } else {
                        // Archivo enviado correctamente
                        hideUploadingIndicator();
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    hideUploadingIndicator();
                });
                
                // Limpiar input
                this.value = '';
            }
        });
    }
    
    function showFilePreview(file) {
        // Implementar vista previa de archivo si es necesario
    }
    
    function showUploadingIndicator() {
        const uploadIndicator = document.createElement('div');
        uploadIndicator.id = 'upload-indicator';
        uploadIndicator.className = 'fixed bottom-20 right-8 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-lg z-10';
        uploadIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Subiendo archivo...';
        document.body.appendChild(uploadIndicator);
    }
    
    function hideUploadingIndicator() {
        const indicator = document.getElementById('upload-indicator');
        if (indicator) indicator.remove();
    }
    
    // Inicializar al cargar
    scrollToBottom();
});
</script>

@endsection
