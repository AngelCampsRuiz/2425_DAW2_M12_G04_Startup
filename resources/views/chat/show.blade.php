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
                <span class="text-[#5e0490] font-medium">{{ $otherUser->nombre }}</span>
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
                        <button id="end-call" class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-colors">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 p-4 bg-gray-900 h-96">
                    <div id="local-video-container" class="bg-black rounded-lg overflow-hidden relative h-full shadow-lg">
                        <div id="local-video" class="w-full h-full"></div>
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
            <div id="chat-messages" class="h-[500px] overflow-y-auto p-6 space-y-4 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 scroll-smooth">
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
                    <div class="flex-1 relative">
                        <textarea id="message-input" 
                               class="w-full rounded-xl border-gray-300 focus:border-[#5e0490] focus:ring-[#5e0490] transition-colors duration-300 shadow-sm placeholder-gray-400 resize-none px-4 py-3 min-h-[50px] max-h-32"
                               placeholder="Escribe un mensaje a {{ $otherUser->nombre }}..."
                               rows="1"></textarea>
                        <div class="absolute right-3 bottom-3 text-gray-400 text-xs font-medium message-length hidden">
                            <span id="current-length">0</span>/<span id="max-length">500</span>
                        </div>
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
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <label for="file-input" class="cursor-pointer p-3 text-gray-500 hover:text-[#5e0490] bg-gray-100 hover:bg-purple-100 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-paperclip text-lg"></i>
                                <span class="sr-only">Adjuntar archivo</span>
                            </label>
                            <input type="file" id="file-input" name="archivo" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                            
                            <button type="button" id="emoji-button" class="p-3 text-gray-500 hover:text-[#5e0490] bg-gray-100 hover:bg-purple-100 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-smile text-lg"></i>
                                <span class="sr-only">Emojis</span>
                            </button>
                        </div>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-xl hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span>Enviar</span>
                        </button>
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
    
    .animate-fadeOut {
        animation: fadeOut 0.3s ease-in-out forwards;
    }
    
    .animate-slideUp {
        animation: slideUp 0.3s ease-in-out;
    }
    
    .animate-slideDown {
        animation: slideDown 0.3s ease-in-out;
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @keyframes slideUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes slideDown {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
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
        border-radius: 8px;
    }
    
    /* Notificación de mensaje */
    .message-notification {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #5e0490;
        color: white;
        padding: 12px 16px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 40;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }
    
    .message-notification.show {
        transform: translateY(0);
        opacity: 1;
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
        background: rgba(94, 4, 144, 0.3);
        border-radius: 10px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(94, 4, 144, 0.5);
    }
    
    /* Textarea autoexpandible */
    textarea.expand {
        overflow: hidden;
        resize: none;
        height: auto;
    }
    
    /* Emoji picker */
    .emoji-picker {
        position: absolute;
        bottom: 70px;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 12px;
        z-index: 30;
        display: none;
    }
    
    .emoji-picker.show {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .emoji-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 8px;
    }
    
    .emoji-item {
        cursor: pointer;
        font-size: 20px;
        text-align: center;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .emoji-item:hover {
        background: #f3f4f6;
        transform: scale(1.2);
    }
    
    /* Indicador de mensaje no leído */
    .unread-indicator {
        background: #5e0490;
        color: white;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        position: fixed;
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 20;
        cursor: pointer;
        display: none;
    }
    
    .unread-indicator.show {
        display: flex;
        align-items: center;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    /* Transiciones suaves para todos los elementos */
    * {
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s, opacity 0.3s;
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
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const emojiButton = document.getElementById('emoji-button');
    const chatId = '{{ $chat->id }}';
    let lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
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
    document.querySelector('.relative').appendChild(emojiPicker);
    
    // Hacer scroll al último mensaje con animación
    smoothScrollToBottom();
    
    // Inicializar textarea autoexpandible
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
    
    // Toggle del selector de emojis
    emojiButton.addEventListener('click', function() {
        emojiPicker.classList.toggle('show');
    });
    
    // Cerrar el selector de emojis al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!emojiButton.contains(e.target) && !emojiPicker.contains(e.target)) {
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
    
    // Actualizar los indicadores de lectura
    function updateReadStatus(messages) {
        messages.forEach(message => {
            if (message.user_id === {{ auth()->id() }}) {
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
        const isMine = mensaje.user_id === {{ auth()->id() }};
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
                            
                            // Mostrar notificación temporal
                            if (newMessages[0].user_id !== {{ auth()->id() }}) {
                                showMessageNotification(newMessages[0]);
                            }
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
                        ${mensaje.user ? mensaje.user.nombre.substring(0, 2).toUpperCase() : '{{ strtoupper(substr($otherUser->nombre, 0, 2)) }}'}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-sm">${mensaje.user ? mensaje.user.nombre : '{{ $otherUser->nombre }}'}</p>
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
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        const hasFile = fileInput.files.length > 0;
        
        if (!content && !hasFile) return;
        
        // Desactivar botones durante el envío
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i><span>Enviando...</span>';
        
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
                messageInput.style.height = 'auto';
                clearFileInput();
                
                // Añadir mensaje a la vista con animación
                chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(data.mensaje));
                lastMessageId = data.mensaje.id;
                
                // Desplazamiento suave al último mensaje
                smoothScrollToBottom();
                
                // Mostrar pequeña animación de "enviado"
                showSentAnimation();
                
                // Ocultar contador de caracteres
                document.querySelector('.message-length').classList.add('hidden');
            } else {
                // Mostrar error si hay alguno
                showErrorNotification(data.error);
            }
            
            // Reactivar botón
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Enviar</span>';
        })
        .catch(error => {
            console.error('Error al enviar mensaje:', error);
            
            // Mostrar error genérico
            showErrorNotification('Error al enviar el mensaje. Inténtalo de nuevo.');
            
            // Reactivar botón
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i><span>Enviar</span>';
        });
    });
    
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
    // FUNCIONALIDAD DE VIDEOLLAMADA MEJORADA
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
    
    // Socket para señalización - Intenta conectar con opciones de recuperación
    const socket = io('http://localhost:3000', {
        reconnectionAttempts: 5,
        timeout: 10000,
        transports: ['websocket', 'polling'],
        autoConnect: true,
        reconnection: true,
        reconnectionDelay: 1000
    });

    // Manejar error de conexión Socket.io
    socket.on('connect_error', (error) => {
        console.warn('Error de conexión socket.io:', error.message);
        // Actualizar estado visual
        updateConnectionStatus('error');
    });
    
    // Manejar conexión exitosa
    socket.on('connect', () => {
        console.log('Conectado al servidor de señalización');
        // Actualizar estado visual
        updateConnectionStatus('connected');
        socket.emit('register', { userId: '{{ auth()->id() }}' });
    });
    
    // Actualizar indicador visual de conexión
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
    
    // Inicializar cliente de Agora con manejo mejorado de errores
    async function initializeAgoraClient() {
        try {
            rtcClient = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });
            
            // Escuchar evento cuando un usuario remoto se une
            rtcClient.on('user-published', async (user, mediaType) => {
                await rtcClient.subscribe(user, mediaType);
                
                if (mediaType === 'video') {
                    remoteUsers[user.uid] = user;
                    user.videoTrack.play(remoteVideoContainer);
                    callStatus.textContent = 'Conectado';
                    // Ocultar el indicador de carga
                    if (remoteVideoLoading) {
                        remoteVideoLoading.style.display = 'none';
                    }
                    
                    // Actualizar estado visual
                    if (remoteVideoStatus) {
                        remoteVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Video activo';
                        remoteVideoStatus.classList.remove('bg-yellow-500');
                        remoteVideoStatus.classList.add('bg-green-500');
                    }
                }
                
                if (mediaType === 'audio') {
                    user.audioTrack.play();
                }
            });
            
            // Escuchar evento cuando un usuario remoto actualiza su publicación
            rtcClient.on('user-unpublished', (user, mediaType) => {
                if (mediaType === 'video') {
                    if (remoteUsers[user.uid]) {
                        // Actualizar estado visual
                        if (remoteVideoStatus) {
                            remoteVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Video pausado';
                            remoteVideoStatus.classList.remove('bg-green-500');
                            remoteVideoStatus.classList.add('bg-yellow-500');
                        }
                    }
                }
            });
            
            // Escuchar evento cuando un usuario remoto abandona la llamada
            rtcClient.on('user-left', (user) => {
                if (remoteUsers[user.uid]) {
                    delete remoteUsers[user.uid];
                    // Mostrar una notificación de que el usuario se desconectó
                    callStatus.textContent = 'El usuario se ha desconectado';
                    
                    // Esperar 2 segundos y finalizar la llamada
                    setTimeout(() => {
                        endActiveCall();
                    }, 2000);
                }
            });
            
            // Monitorear estadísticas de conexión
            rtcClient.on('network-quality', (stats) => {
                // Actualizar estadísticas de red si es necesario
                updateNetworkStats(stats);
            });
            
            return rtcClient;
        } catch (error) {
            console.error('Error al inicializar el cliente de Agora:', error);
            throw error;
        }
    }
    
    // Actualizar estadísticas de red
    function updateNetworkStats(stats) {
        // Aquí podrías actualizar la UI con estadísticas de red si lo deseas
        if (stats.downlinkNetworkQuality > 3) {
            // Mala calidad de conexión descendente
            showNetworkWarning('Conexión inestable');
        }
    }
    
    // Mostrar advertencia de red
    function showNetworkWarning(message) {
        // Solo mostrar si no hay ya una advertencia
        if (document.querySelector('.network-warning')) return;
        
        const warning = document.createElement('div');
        warning.className = 'network-warning absolute top-2 left-2 bg-yellow-500 text-xs text-white px-2 py-1 rounded-md flex items-center';
        warning.innerHTML = `<i class="fas fa-exclamation-triangle mr-1"></i> ${message}`;
        
        if (videoContainer.classList.contains('minimized')) {
            remoteVideoContainer.appendChild(warning);
        } else {
            const parent = document.querySelector('.grid-cols-2');
            if (parent) parent.appendChild(warning);
        }
        
        // Eliminar después de 5 segundos
        setTimeout(() => {
            if (warning.parentNode) {
                warning.parentNode.removeChild(warning);
            }
        }, 5000);
    }
    
    // Función mejorada para unirse a la llamada
    async function joinCall() {
        try {
            updateConnectionStatus('connecting');
            callStatus.textContent = 'Iniciando...';
            
            // Iniciar el temporizador de la llamada
            startCallTimer();
            
            // Inicializar el cliente de Agora
            const client = await initializeAgoraClient();
            
            try {
                // Unirse al canal
                const uid = await client.join(APP_ID, CHANNEL_NAME, TOKEN, null);
                
                // Crear tracks locales de audio y video con manejo de errores para permisos
                try {
                    [localTracks.audioTrack, localTracks.videoTrack] = await Promise.all([
                        AgoraRTC.createMicrophoneAudioTrack(),
                        AgoraRTC.createCameraVideoTrack()
                    ]);
                    
                    // Actualizar estado visual
                    if (localVideoStatus) {
                        localVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Activo';
                    }
                    
                } catch (mediaError) {
                    console.error('Error al acceder a los dispositivos multimedia:', mediaError);
                    
                    // Manejar el error de permisos de forma más amigable
                    if (mediaError.message && mediaError.message.includes('Permission denied')) {
                        callStatus.textContent = 'Permisos de cámara/micrófono denegados';
                        showErrorNotification('Necesitamos permiso para acceder a tu cámara y micrófono');
                        
                        // Intentar solicitar solo audio si el video falla
                        try {
                            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                        } catch (audioError) {
                            console.error('También falló el acceso al micrófono:', audioError);
                        }
                    }
                }
                
                // Reproducir track de video local si existe
                if (localTracks.videoTrack) {
                    localTracks.videoTrack.play(localVideoContainer);
                } else {
                    // Mostrar un placeholder si no hay video
                    localVideoContainer.innerHTML = `
                        <div class="flex h-full items-center justify-center bg-gray-800">
                            <div class="text-center">
                                <i class="fas fa-video-slash text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-300 text-sm">Cámara no disponible</p>
                            </div>
                        </div>
                    `;
                    
                    // Actualizar estado visual
                    if (localVideoStatus) {
                        localVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Sin video';
                        localVideoStatus.classList.remove('bg-green-500');
                        localVideoStatus.classList.add('bg-yellow-500');
                    }
                }
                
                // Publicar tracks locales disponibles
                const tracksToPublish = Object.values(localTracks).filter(track => track !== null);
                if (tracksToPublish.length > 0) {
                    await client.publish(tracksToPublish);
                }
                
                // Actualizar estado
                isCallActive = true;
                videoCallBtn.disabled = true;
                callStatus.textContent = 'Esperando a {{ $otherUser->nombre }}...';
                updateConnectionStatus('connected');
                
                // Mostrar el contenedor de video con animación
                videoContainer.classList.remove('hidden');
                
                // Añadir listener para teclas de atajo
                document.addEventListener('keydown', handleCallShortcuts);
            } catch (agoraError) {
                console.error('Error específico de Agora:', agoraError);
                
                // Mostrar mensaje de error específico de Agora
                if (agoraError.message && agoraError.message.includes('invalid vendor key')) {
                    callStatus.textContent = 'Error: App ID inválido';
                    showErrorNotification('El ID de la aplicación Agora no es válido');
                } else {
                    callStatus.textContent = 'Error en la videollamada';
                    showErrorNotification('No se pudo iniciar la videollamada');
                }
                
                // Intentar limpiar recursos
                leaveCall();
            }
        } catch (error) {
            console.error('Error general al unirse a la llamada:', error);
            callStatus.textContent = 'Error al iniciar';
            showErrorNotification('Error al iniciar la videollamada');
            
            // Intentar limpiar recursos
            leaveCall();
        }
    }
    
    // Manejar teclas de atajo para la llamada
    function handleCallShortcuts(e) {
        if (!isCallActive) return;
        
        // Alt+M = Toggle Mute
        if (e.altKey && e.key === 'm') {
            toggleMicrophone();
        }
        
        // Alt+V = Toggle Video
        if (e.altKey && e.key === 'v') {
            toggleCamera();
        }
        
        // Alt+E = End Call
        if (e.altKey && e.key === 'e') {
            endActiveCall();
        }
    }
    
    // Función mejorada para terminar la llamada
    async function leaveCall() {
        // Remover listener de teclas
        document.removeEventListener('keydown', handleCallShortcuts);
        
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
            try {
                await rtcClient.leave();
            } catch (error) {
                console.error('Error al abandonar el canal:', error);
            }
        }
        
        // Actualizar estado
        isCallActive = false;
        videoCallBtn.disabled = false;
        
        // Ocultar el contenedor de video con animación
        videoContainer.classList.add('animate-fadeOut');
        setTimeout(() => {
            videoContainer.classList.add('hidden');
            videoContainer.classList.remove('minimized', 'animate-fadeOut');
            isMinimized = false;
            
            // Limpiar contenedores de video
            localVideoContainer.innerHTML = '';
            remoteVideoContainer.innerHTML = '';
            
            // Restablecer estados
            if (remoteVideoLoading) {
                remoteVideoLoading.style.display = 'flex';
            }
        }, 300);
        
        // Detener el temporizador
        stopCallTimer();
    }
    
    // Mostrar notificación de llamada entrante
    function showIncomingCall() {
        incomingCall.classList.remove('hidden');
        // Reproducir sonido de llamada
        playCallSound();
    }
    
    // Reproducir sonido de llamada
    function playCallSound() {
        // Crear un elemento de audio
        const callSound = document.createElement('audio');
        callSound.src = 'https://assets.mixkit.co/sfx/preview/mixkit-classic-short-phone-ring-1357.mp3'; // Sonido de ejemplo
        callSound.loop = true;
        callSound.id = 'call-sound';
        callSound.volume = 0.5;
        document.body.appendChild(callSound);
        
        // Reproducir
        callSound.play().catch(error => {
            console.warn('No se pudo reproducir el sonido de llamada:', error);
        });
    }
    
    // Detener sonido de llamada
    function stopCallSound() {
        const callSound = document.getElementById('call-sound');
        if (callSound) {
            callSound.pause();
            callSound.remove();
        }
    }
    
    // Ocultar notificación de llamada entrante
    function hideIncomingCall() {
        incomingCall.classList.add('animate-fadeOut');
        setTimeout(() => {
            incomingCall.classList.add('hidden');
            incomingCall.classList.remove('animate-fadeOut');
        }, 300);
        
        // Detener sonido
        stopCallSound();
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
    
    // Alternar micrófono con feedback visual mejorado
    function toggleMicrophone() {
        if (localTracks.audioTrack) {
            if (localTracks.audioTrack.isEnabled) {
                localTracks.audioTrack.setEnabled(false);
                toggleAudio.innerHTML = '<i class="fas fa-microphone-slash"></i>';
                toggleAudio.classList.add('bg-red-500');
                toggleAudio.classList.remove('bg-white', 'bg-opacity-20');
                
                // Mostrar indicador en pantalla
                showMediaToggleIndicator('Micrófono silenciado', 'microphone-slash', 'red');
            } else {
                localTracks.audioTrack.setEnabled(true);
                toggleAudio.innerHTML = '<i class="fas fa-microphone"></i>';
                toggleAudio.classList.remove('bg-red-500');
                toggleAudio.classList.add('bg-white', 'bg-opacity-20');
                
                // Mostrar indicador en pantalla
                showMediaToggleIndicator('Micrófono activado', 'microphone', 'green');
            }
        }
    }
    
    // Alternar cámara con feedback visual mejorado
    function toggleCamera() {
        if (localTracks.videoTrack) {
            if (localTracks.videoTrack.isEnabled) {
                localTracks.videoTrack.setEnabled(false);
                toggleVideo.innerHTML = '<i class="fas fa-video-slash"></i>';
                toggleVideo.classList.add('bg-red-500');
                toggleVideo.classList.remove('bg-white', 'bg-opacity-20');
                
                // Actualizar estado visual
                if (localVideoStatus) {
                    localVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Video pausado';
                    localVideoStatus.classList.remove('bg-green-500');
                    localVideoStatus.classList.add('bg-yellow-500');
                }
                
                // Mostrar indicador en pantalla
                showMediaToggleIndicator('Cámara desactivada', 'video-slash', 'red');
            } else {
                localTracks.videoTrack.setEnabled(true);
                toggleVideo.innerHTML = '<i class="fas fa-video"></i>';
                toggleVideo.classList.remove('bg-red-500');
                toggleVideo.classList.add('bg-white', 'bg-opacity-20');
                
                // Actualizar estado visual
                if (localVideoStatus) {
                    localVideoStatus.innerHTML = '<i class="fas fa-circle text-[5px] mr-1"></i> Activo';
                    localVideoStatus.classList.remove('bg-yellow-500');
                    localVideoStatus.classList.add('bg-green-500');
                }
                
                // Mostrar indicador en pantalla
                showMediaToggleIndicator('Cámara activada', 'video', 'green');
            }
        }
    }
    
    // Mostrar indicador al activar/desactivar cámara o micrófono
    function showMediaToggleIndicator(message, icon, color) {
        const indicator = document.createElement('div');
        indicator.className = `absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-${color}-500 bg-opacity-80 text-white px-3 py-2 rounded-lg flex items-center animate-fadeIn z-10`;
        indicator.innerHTML = `<i class="fas fa-${icon} mr-2"></i> ${message}`;
        
        if (videoContainer.classList.contains('minimized')) {
            remoteVideoContainer.appendChild(indicator);
        } else {
            localVideoContainer.appendChild(indicator);
        }
        
        setTimeout(() => {
            indicator.classList.add('animate-fadeOut');
            setTimeout(() => {
                if (indicator.parentNode) {
                    indicator.parentNode.removeChild(indicator);
                }
            }, 300);
        }, 1500);
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
    
    // Alternar entre minimizado/maximizado
    function toggleMinimize() {
        if (isMinimized) {
            videoContainer.classList.remove('minimized');
            closeVideoContainer.textContent = 'Minimizar';
            
            // Ajustar estilos y posiciones si es necesario
            if (remoteVideoLoading) {
                remoteVideoLoading.style.display = remoteUsers[Object.keys(remoteUsers)[0]] ? 'none' : 'flex';
            }
        } else {
            videoContainer.classList.add('minimized');
            closeVideoContainer.textContent = 'Maximizar';
        }
        isMinimized = !isMinimized;
    }
    
    // Event listeners para videollamada
    videoCallBtn.addEventListener('click', async () => {
        try {
            await startCall();
        } catch (error) {
            console.error("Error al iniciar llamada:", error);
            showErrorNotification("No se pudo iniciar la videollamada");
        }
    });
    
    closeVideoContainer.addEventListener('click', toggleMinimize);
    toggleAudio.addEventListener('click', toggleMicrophone);
    toggleVideo.addEventListener('click', toggleCamera);
    endCall.addEventListener('click', endActiveCall);
    acceptCall.addEventListener('click', acceptIncomingCall);
    rejectCall.addEventListener('click', rejectIncomingCall);
    
    // Función para alternar la visibilidad del chat durante una videollamada
    if (toggleChat) {
        toggleChat.addEventListener('click', function() {
            const chatArea = document.querySelector('.container.mx-auto');
            
            if (chatArea.style.display === 'none') {
                chatArea.style.display = 'block';
                this.innerHTML = '<i class="fas fa-eye-slash mr-1"></i> Ocultar Chat';
            } else {
                chatArea.style.display = 'none';
                this.innerHTML = '<i class="fas fa-comment-alt mr-1"></i> Mostrar Chat';
            }
        });
    }
    
    // Manejar eventos de socket.io para videollamadas
    socket.on('incoming-call', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            showIncomingCall();
        }
    });
    
    socket.on('call-rejected', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            endActiveCall();
            callStatus.textContent = 'Llamada rechazada';
            showErrorNotification('{{ $otherUser->nombre }} rechazó la llamada');
        }
    });
    
    socket.on('call-ended', (data) => {
        if (data.chatId === '{{ $chat->id }}') {
            if (isCallActive) {
                callStatus.textContent = 'Llamada finalizada';
                endActiveCall();
            }
        }
    });
    
    // Funciones de diagnóstico mejoradas
    async function checkVideoCallServices() {
        // Verificar Agora
        let agoraAvailable = typeof AgoraRTC !== 'undefined';
        
        // Verificar socket.io
        let socketAvailable = socket && socket.connected;
        
        // Verificar permisos de cámara/micrófono
        let mediaPermissions = { audio: false, video: false };
        
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const hasVideoInput = devices.some(device => device.kind === 'videoinput');
            const hasAudioInput = devices.some(device => device.kind === 'audioinput');
            
            if (hasVideoInput && hasAudioInput) {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
                    stream.getTracks().forEach(track => {
                        if (track.kind === 'audio') mediaPermissions.audio = true;
                        if (track.kind === 'video') mediaPermissions.video = true;
                        track.stop();
                    });
                } catch (err) {
                    console.warn("Error de permisos de medios:", err);
                }
            }
        } catch (err) {
            console.warn("Error al enumerar dispositivos:", err);
        }
        
        const diagnosticResult = {
            agoraSDK: agoraAvailable,
            socketIO: socketAvailable,
            mediaPermisos: mediaPermissions,
            appID: APP_ID !== "YOUR_AGORA_APP_ID" && APP_ID.length > 10,
            browser: {
                name: navigator.userAgent,
                supportsWebRTC: 'RTCPeerConnection' in window
            }
        };
        
        console.log("Estado de servicios de videollamada:", diagnosticResult);
        return diagnosticResult;
    }
    
    // Ejecutar diagnóstico al cargar la página
    setTimeout(checkVideoCallServices, 2000);
});
</script>
@endsection 