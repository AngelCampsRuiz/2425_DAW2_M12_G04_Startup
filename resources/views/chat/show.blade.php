@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    {{-- MIGAS DE PAN --}}
    <div class="bg-white shadow-sm backdrop-blur-xl bg-opacity-80 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-all duration-300">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <span class="text-[#5e0490] font-medium">{{ $otherUser->nombre }}</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado del chat -->
        <div class="mb-6 bg-white rounded-2xl shadow-md p-6 transform transition-all duration-300 hover:shadow-lg border border-purple-100 animate-fadeIn">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-[#5e0490] transition-colors duration-300 bg-purple-50 p-2 rounded-full hover:bg-purple-100">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="relative group">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-xl transform transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
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
                        <span class="absolute inset-0 rounded-full bg-gray-900 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    </a>
                    <div>
                        <a href="{{ auth()->user()->role_id == 2 ? route('profile.view', $otherUser->id) : route('profile.view', $otherUser->id) }}" class="group">
                            <h1 class="text-2xl font-bold text-gray-800 group-hover:text-[#5e0490] transition-colors duration-300">{{ $otherUser->nombre }}</h1>
                            <p class="text-gray-600">{{ $solicitud->publicacion->titulo }}</p>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="video-call-btn" class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-video mr-2"></i>
                        Videollamada
                    </button>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 animate-pulse shadow-sm">
                        <span class="w-2 h-2 mr-2 rounded-full bg-green-400 animate-ping"></span>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenedor de videollamada (oculto por defecto) -->
        <div id="video-container" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-xl w-full max-w-4xl h-auto mx-4 overflow-hidden shadow-2xl">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-bold text-gray-800">Videollamada con {{ $otherUser->nombre }}</h3>
                    <div class="flex space-x-3">
                        <button id="toggle-audio" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                            <i class="fas fa-microphone"></i>
                        </button>
                        <button id="toggle-video" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                            <i class="fas fa-video"></i>
                        </button>
                        <button id="end-call" class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 p-4 bg-gray-100 h-96">
                    <div id="local-video-container" class="bg-black rounded-lg overflow-hidden relative h-full">
                        <div id="local-video" class="w-full h-full"></div>
                        <div class="absolute bottom-2 left-2 text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded-md">
                            Tú
                        </div>
                    </div>
                    <div id="remote-video-container" class="bg-black rounded-lg overflow-hidden relative h-full">
                        <div id="remote-video" class="w-full h-full"></div>
                        <div class="absolute bottom-2 left-2 text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded-md">
                            {{ $otherUser->nombre }}
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t bg-white flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        <span id="call-status">Conectando...</span>
                        <span id="call-timer" class="ml-2"></span>
                    </div>
                    <button id="close-video-container" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors">
                        Minimizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Notificación de llamada entrante -->
        <div id="incoming-call" class="fixed bottom-5 right-5 bg-white rounded-xl shadow-2xl p-4 flex items-center hidden animate-bounce z-50">
            <div class="mr-4">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden">
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
            </div>
            <div>
                <p class="font-bold text-gray-800">{{ $otherUser->nombre }}</p>
                <p class="text-sm text-gray-600">Videollamada entrante...</p>
            </div>
            <div class="ml-4 flex space-x-2">
                <button id="accept-call" class="p-2 rounded-full bg-green-500 hover:bg-green-600 text-white transition-colors">
                    <i class="fas fa-phone"></i>
                </button>
                <button id="reject-call" class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors">
                    <i class="fas fa-phone-slash"></i>
                </button>
            </div>
        </div>

        <!-- Contenedor del chat -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg border border-purple-100 animate-fadeIn">
            <!-- Área de mensajes -->
            <div id="chat-messages" class="h-[500px] overflow-y-auto p-6 space-y-4 bg-gradient-to-br from-gray-50 to-purple-50 scroll-smooth">
                @if($mensajes->isEmpty())
                    <div class="text-center py-12 animate-fadeIn">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 mb-4 shadow-md">
                            <i class="fas fa-comments text-3xl text-[#5e0490]"></i>
                        </div>
                        <p class="text-gray-500 text-lg">No hay mensajes aún. ¡Comienza la conversación!</p>
                        <p class="text-gray-400 text-sm mt-2">Envía un mensaje o un archivo para empezar a chatear con {{ $otherUser->nombre }}</p>
                    </div>
                @else
                    @foreach($mensajes as $mensaje)
                        <div class="flex {{ $mensaje->user_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fadeIn">
                            <div class="group max-w-xs md:max-w-md lg:max-w-lg {{ $mensaje->user_id === auth()->id() ? 'bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white' : 'bg-white text-gray-800 border border-gray-200' }} rounded-2xl px-4 py-3 shadow-md transform transition-all duration-300 hover:shadow-lg {{ $mensaje->user_id === auth()->id() ? 'hover:-translate-y-1 hover:scale-105' : 'hover:-translate-y-1 hover:scale-105' }}">
                                @if($mensaje->contenido)
                                    <p class="text-sm">{{ $mensaje->contenido }}</p>
                                @endif
                                
                                @if($mensaje->archivo_adjunto)
                                    <div class="mt-2">
                                        @if(strpos($mensaje->tipo_archivo, 'image/') === 0)
                                            <!-- Mostrar imagen -->
                                            <div class="mt-2 relative group overflow-hidden rounded-lg">
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
                                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $mensaje->user_id === auth()->id() ? 'bg-purple-200 bg-opacity-20' : 'bg-purple-50' }} backdrop-blur-sm transition-transform duration-300 transform hover:scale-105">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-file-alt text-2xl {{ $mensaje->user_id === auth()->id() ? 'text-purple-100' : 'text-[#5e0490]' }}"></i>
                                                </div>
                                                <div class="flex-grow overflow-hidden text-sm {{ $mensaje->user_id === auth()->id() ? 'text-purple-100' : 'text-gray-700' }}">
                                                    <p class="truncate">{{ $mensaje->nombre_archivo }}</p>
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
                    <div class="flex-1">
                        <input type="text" id="message-input" 
                               class="w-full rounded-xl border-gray-300 focus:border-[#5e0490] focus:ring-[#5e0490] transition-colors duration-300 shadow-sm placeholder-gray-400" 
                               placeholder="Escribe un mensaje...">
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <div id="file-preview" class="hidden flex-grow p-3 bg-purple-50 rounded-xl border border-purple-100 animate-fadeIn">
                            <div class="flex items-center">
                                <i class="fas fa-paperclip mr-2 text-[#5e0490]"></i>
                                <span id="file-name" class="text-sm text-gray-600 mr-2 truncate"></span>
                                <button id="remove-file" type="button" class="text-red-500 hover:text-red-700 bg-white rounded-full p-1 shadow-sm transition-transform duration-300 hover:scale-110">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <label for="file-input" class="cursor-pointer p-3 text-gray-500 hover:text-[#5e0490] bg-gray-100 hover:bg-purple-100 rounded-xl mr-2 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-paperclip text-xl"></i>
                                <span class="sr-only">Adjuntar archivo</span>
                            </label>
                            <input type="file" id="file-input" name="archivo" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                            
                    <button type="submit" 
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar
                    </button>
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

<!-- Estilos adicionales -->
<style>
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* Estilos para videollamada */
    #video-container.minimized {
        inset: auto;
        top: auto;
        right: 20px;
        bottom: 20px;
        left: auto;
        width: 300px;
        height: auto;
        background: transparent;
    }
    
    #video-container.minimized .bg-white {
        max-width: 300px;
    }
    
    #video-container.minimized .grid-cols-2 {
        grid-template-columns: 1fr;
        height: 180px;
    }
    
    #video-container.minimized #remote-video-container {
        display: block;
    }
    
    #video-container.minimized #local-video-container {
        position: absolute;
        right: 10px;
        bottom: 60px;
        width: 80px;
        height: 80px;
        z-index: 10;
        border: 2px solid white;
    }
    
    /* Estilizar la barra de desplazamiento */
    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    #chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb {
        background: #d8c1e9;
        border-radius: 10px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: #5e0490;
    }
    
    /* Transiciones suaves para todos los elementos */
    * {
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }
</style>

<!-- Scripts para el chat -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const removeFile = document.getElementById('remove-file');
    const chatId = '{{ $chat->id }}';
    let lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
    
    // Hacer scroll al último mensaje con animación
    smoothScrollToBottom();
    
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
                    // Podría añadir una previsualización de la imagen si lo deseas
                };
                reader.readAsDataURL(file);
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
    }
    
    // Actualizar los indicadores de lectura
    function updateReadStatus(messages) {
        messages.forEach(message => {
            if (message.user_id === {{ auth()->id() }}) {
                const statusElement = document.querySelector(`.message-status[data-message-id="${message.id}"] i`);
                if (statusElement && message.leido) {
                    statusElement.classList.remove('opacity-60');
                    statusElement.classList.add('fa-check-double');
                }
            }
        });
    }
    
    // Función para crear el HTML de un mensaje con animaciones
    function createMessageHtml(mensaje) {
        const isMine = mensaje.user_id === {{ auth()->id() }};
        let messageContent = '';
        
        if (mensaje.contenido) {
            messageContent += `<p class="text-sm">${mensaje.contenido}</p>`;
        }
        
        if (mensaje.archivo_adjunto) {
            messageContent += '<div class="mt-2">';
            
            if (mensaje.tipo_archivo && mensaje.tipo_archivo.startsWith('image/')) {
                messageContent += `
                    <div class="mt-2 relative group overflow-hidden rounded-lg">
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
                    <div class="flex items-center gap-3 p-3 rounded-xl ${isMine ? 'bg-purple-200 bg-opacity-20' : 'bg-purple-50'} backdrop-blur-sm transition-transform duration-300 transform hover:scale-105">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt text-2xl ${isMine ? 'text-purple-100' : 'text-[#5e0490]'}"></i>
                        </div>
                        <div class="flex-grow overflow-hidden text-sm ${isMine ? 'text-purple-100' : 'text-gray-700'}">
                            <p class="truncate">${mensaje.nombre_archivo}</p>
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
                <div class="group max-w-xs md:max-w-md lg:max-w-lg ${isMine ? 'bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white' : 'bg-white text-gray-800 border border-gray-200'} rounded-2xl px-4 py-3 shadow-md transform transition-all duration-300 hover:shadow-lg ${isMine ? 'hover:-translate-y-1 hover:scale-105' : 'hover:-translate-y-1 hover:scale-105'}">
                    ${messageContent}
                </div>
            </div>
        `;
    }
    
    // Función para actualizar los mensajes con animaciones
    function updateMessages() {
        fetch('{{ route('chat.messages', ['chat' => $chat->id]) }}')
            .then(response => response.json())
            .then(data => {
                if (!data.error && data.mensajes.length > 0) {
                    // Actualizar el estado de lectura de los mensajes existentes
                    updateReadStatus(data.mensajes);
                    
                    const newMessages = data.mensajes.filter(mensaje => mensaje.id > lastMessageId);
                    
                    if (newMessages.length > 0) {
                        const wasAtBottom = isAtBottom();
                        
                        newMessages.forEach(mensaje => {
                            chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(mensaje));
                        });
                        
                        lastMessageId = newMessages[newMessages.length - 1].id;
                        
                        // Solo hacer scroll si ya estaba en el fondo
                        if (wasAtBottom) {
                            smoothScrollToBottom();
                        } else {
                            // Mostrar indicador de nuevos mensajes
                            showNewMessageIndicator();
                        }
                    }
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
        // Aquí podrías implementar un indicador visual
        // de que hay nuevos mensajes que no están visibles
    }
    
    // Enviar mensaje con animaciones
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        const hasFile = fileInput.files.length > 0;
        
        if (!content && !hasFile) return;
        
        // Desactivar botones durante el envío
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i> Enviando...';
        
        // Crear FormData para enviar el contenido y archivo
        const formData = new FormData();
        if (content) {
            formData.append('contenido', content);
        }
        
        if (hasFile) {
            formData.append('archivo', fileInput.files[0]);
        }
        
        // Enviar mensaje al servidor
        fetch('{{ route('chat.message', ['chat' => $chat->id]) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                // Limpiar inputs
                messageInput.value = '';
                clearFileInput();
                
                // Añadir mensaje a la vista con animación
                chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(data.mensaje));
                lastMessageId = data.mensaje.id;
                
                // Desplazamiento suave al último mensaje
                smoothScrollToBottom();
                
                // Mostrar pequeña animación de "enviado"
                showSentAnimation();
            }
            
            // Reactivar botón
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Enviar';
        })
        .catch(error => {
            console.error('Error al enviar mensaje:', error);
            
            // Reactivar botón
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Enviar';
        });
    });
    
    // Animación de mensaje enviado
    function showSentAnimation() {
        const sentIndicator = document.createElement('div');
        sentIndicator.className = 'fixed bottom-8 right-8 bg-green-500 text-white px-4 py-2 rounded-xl shadow-lg z-50 animate-bounce';
        sentIndicator.innerHTML = '<i class="fas fa-check mr-2"></i> Mensaje enviado';
        document.body.appendChild(sentIndicator);
        
        setTimeout(() => {
            sentIndicator.classList.add('animate-fadeOut');
            setTimeout(() => {
                document.body.removeChild(sentIndicator);
            }, 500);
        }, 2000);
    }
    
    // Actualizar mensajes cada 3 segundos
    setInterval(updateMessages, 3000);
    
    //--------------------------------------------------------------
    // FUNCIONALIDAD DE VIDEOLLAMADA
    //--------------------------------------------------------------
    
    // Configuración de Agora
    const APP_ID = "ff42e2de41ee4ec7b9bfe51d3d9b4edd"; // App ID de Agora
    const CHANNEL_NAME = "chat_{{ $chat->id }}";
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
    const callStatus = document.getElementById('call-status');
    const callTimer = document.getElementById('call-timer');
    const incomingCall = document.getElementById('incoming-call');
    const acceptCall = document.getElementById('accept-call');
    const rejectCall = document.getElementById('reject-call');
    
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
    
    // Socket para señalización - Intenta conectar con opciones de recuperación
    const socket = io('http://localhost:3000', {
        reconnectionAttempts: 3,
        timeout: 10000,
        transports: ['websocket', 'polling'],
        autoConnect: true,
        reconnection: true
    });

    // Manejar error de conexión Socket.io
    socket.on('connect_error', (error) => {
        console.warn('Error de conexión socket.io:', error.message);
        // Podemos implementar una lógica alternativa aquí si es necesario
    });
    
    // Inicializar cliente de Agora
    async function initializeAgoraClient() {
        rtcClient = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });
        
        // Escuchar evento cuando un usuario remoto se une
        rtcClient.on('user-published', async (user, mediaType) => {
            await rtcClient.subscribe(user, mediaType);
            
            if (mediaType === 'video') {
                remoteUsers[user.uid] = user;
                user.videoTrack.play(remoteVideoContainer);
                callStatus.textContent = 'Conectado';
            }
            
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        });
        
        // Escuchar evento cuando un usuario remoto se desconecta
        rtcClient.on('user-unpublished', (user, mediaType) => {
            if (mediaType === 'video') {
                if (remoteUsers[user.uid]) {
                    delete remoteUsers[user.uid];
                }
            }
        });
        
        // Escuchar evento cuando un usuario remoto abandona la llamada
        rtcClient.on('user-left', (user) => {
            if (remoteUsers[user.uid]) {
                delete remoteUsers[user.uid];
                endActiveCall();
            }
        });
    }
    
    // Función para unirse a la llamada
    async function joinCall() {
        try {
            // Iniciar el temporizador de la llamada
            startCallTimer();
            
            // Inicializar el cliente de Agora
            await initializeAgoraClient();
            
            try {
                // Unirse al canal
                const uid = await rtcClient.join(APP_ID, CHANNEL_NAME, TOKEN, null);
                
                // Crear tracks locales de audio y video
                localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
                
                // Reproducir track de video local
                localTracks.videoTrack.play(localVideoContainer);
                
                // Publicar tracks locales
                await rtcClient.publish(Object.values(localTracks));
                
                // Actualizar estado
                isCallActive = true;
                videoCallBtn.disabled = true;
                callStatus.textContent = 'Esperando a que se conecte {{ $otherUser->nombre }}...';
                
                // Mostrar el contenedor de video
                videoContainer.classList.remove('hidden');
            } catch (agoraError) {
                console.error('Error específico de Agora:', agoraError);
                
                // Mostrar mensaje de error específico de Agora
                if (agoraError.message && agoraError.message.includes('invalid vendor key')) {
                    callStatus.textContent = 'Error: Necesitas registrarte en Agora y configurar un App ID válido';
                    alert('Para usar videollamadas, debes registrarte en Agora.io y configurar un App ID válido. Por favor, contacta al administrador.');
                } else {
                    callStatus.textContent = 'Error en el servicio de videollamadas';
                }
                
                // Intentar limpiar recursos
                leaveCall();
            }
        } catch (error) {
            console.error('Error general al unirse a la llamada:', error);
            callStatus.textContent = 'Error al iniciar la llamada';
            
            // Intentar limpiar recursos
            leaveCall();
        }
    }
    
    // Función para terminar la llamada
    async function leaveCall() {
        // Detener tracks locales
        for (const trackName in localTracks) {
            const track = localTracks[trackName];
            if (track) {
                track.stop();
                track.close();
                localTracks[trackName] = null;
            }
        }
        
        // Abandonar el canal
        if (rtcClient) {
            await rtcClient.leave();
        }
        
        // Actualizar estado
        isCallActive = false;
        videoCallBtn.disabled = false;
        
        // Ocultar el contenedor de video
        videoContainer.classList.add('hidden');
        videoContainer.classList.remove('minimized');
        isMinimized = false;
        
        // Detener el temporizador
        stopCallTimer();
    }
    
    // Mostrar notificación de llamada entrante
    function showIncomingCall() {
        incomingCall.classList.remove('hidden');
    }
    
    // Ocultar notificación de llamada entrante
    function hideIncomingCall() {
        incomingCall.classList.add('hidden');
    }
    
    // Iniciar una llamada
    async function startCall() {
        if (!isCallActive) {
            callStatus.textContent = 'Iniciando llamada...';
            // Notificar al otro usuario sobre la llamada entrante
            socket.emit('call-user', {
                to: '{{ $otherUser->id }}',
                from: '{{ auth()->id() }}',
                chatId: '{{ $chat->id }}'
            });
            
            await joinCall();
        }
    }
    
    // Terminar una llamada activa
    async function endActiveCall() {
        if (isCallActive) {
            // Notificar al otro usuario que finalizamos la llamada
            socket.emit('end-call', {
                to: '{{ $otherUser->id }}',
                from: '{{ auth()->id() }}',
                chatId: '{{ $chat->id }}'
            });
            
            await leaveCall();
        }
    }
    
    // Aceptar una llamada entrante
    async function acceptIncomingCall() {
        hideIncomingCall();
        await joinCall();
    }
    
    // Rechazar una llamada entrante
    function rejectIncomingCall() {
        hideIncomingCall();
        socket.emit('reject-call', {
            to: '{{ $otherUser->id }}',
            from: '{{ auth()->id() }}',
            chatId: '{{ $chat->id }}'
        });
    }
    
    // Alternar micrófono
    function toggleMicrophone() {
        if (localTracks.audioTrack) {
            if (localTracks.audioTrack.isEnabled) {
                localTracks.audioTrack.setEnabled(false);
                toggleAudio.innerHTML = '<i class="fas fa-microphone-slash"></i>';
                toggleAudio.classList.add('bg-red-100');
            } else {
                localTracks.audioTrack.setEnabled(true);
                toggleAudio.innerHTML = '<i class="fas fa-microphone"></i>';
                toggleAudio.classList.remove('bg-red-100');
            }
        }
    }
    
    // Alternar cámara
    function toggleCamera() {
        if (localTracks.videoTrack) {
            if (localTracks.videoTrack.isEnabled) {
                localTracks.videoTrack.setEnabled(false);
                toggleVideo.innerHTML = '<i class="fas fa-video-slash"></i>';
                toggleVideo.classList.add('bg-red-100');
            } else {
                localTracks.videoTrack.setEnabled(true);
                toggleVideo.innerHTML = '<i class="fas fa-video"></i>';
                toggleVideo.classList.remove('bg-red-100');
            }
        }
    }
    
    // Iniciar temporizador de llamada
    function startCallTimer() {
        callStartTime = new Date();
        callTimer.textContent = '00:00';
        
        timerInterval = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime - callStartTime;
            
            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            
            callTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }
    
    // Detener temporizador de llamada
    function stopCallTimer() {
        clearInterval(timerInterval);
        callTimer.textContent = '';
    }
    
    // Minimizar/maximizar la ventana de videollamada
    function toggleMinimize() {
        if (isMinimized) {
            videoContainer.classList.remove('minimized');
            closeVideoContainer.textContent = 'Minimizar';
        } else {
            videoContainer.classList.add('minimized');
            closeVideoContainer.textContent = 'Maximizar';
        }
        isMinimized = !isMinimized;
    }
    
    // Event listeners para videollamada
    videoCallBtn.addEventListener('click', async () => {
        try {
            // Intentar primero con Agora
            await startCall();
        } catch (error) {
            console.error("Error al iniciar llamada con Agora:", error);
            alert("No se pudo iniciar la videollamada con el servicio principal. Contacta al administrador para más información.");
        }
    });
    closeVideoContainer.addEventListener('click', toggleMinimize);
    toggleAudio.addEventListener('click', toggleMicrophone);
    toggleVideo.addEventListener('click', toggleCamera);
    endCall.addEventListener('click', endActiveCall);
    acceptCall.addEventListener('click', acceptIncomingCall);
    rejectCall.addEventListener('click', rejectIncomingCall);
    
    // Manejar eventos de socket.io
    socket.on('connect', () => {
        console.log('Conectado al servidor de señalización');
        socket.emit('register', { userId: '{{ auth()->id() }}' });
    });
    
    socket.on('incoming-call', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            showIncomingCall();
        }
    });
    
    socket.on('call-rejected', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            endActiveCall();
            callStatus.textContent = 'Llamada rechazada';
        }
    });
    
    socket.on('call-ended', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            endActiveCall();
        }
    });
    
    // Función adicional de diagnóstico
    async function checkVideoCallServices() {
        // Verificar Agora
        let agoraAvailable = typeof AgoraRTC !== 'undefined';
        
        // Verificar socket.io
        let socketAvailable = socket && socket.connected;
        
        // Verificar permisos de cámara/micrófono
        let mediaPermissions = false;
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
            stream.getTracks().forEach(track => track.stop());
            mediaPermissions = true;
        } catch (err) {
            console.error("Error de permisos de medios:", err);
        }
        
        console.log("Estado de servicios de videollamada:", {
            agoraSDK: agoraAvailable,
            socketIO: socketAvailable,
            mediaPermisos: mediaPermissions,
            appID: APP_ID !== "YOUR_AGORA_APP_ID" && APP_ID.length > 10
        });
        
        return {
            agoraSDK: agoraAvailable,
            socketIO: socketAvailable,
            mediaPermisos: mediaPermissions,
            appID: APP_ID !== "YOUR_AGORA_APP_ID" && APP_ID.length > 10
        };
    }
    
    // Ejecutar diagnóstico al cargar la página
    setTimeout(checkVideoCallServices, 2000);
});
</script>
@endsection 