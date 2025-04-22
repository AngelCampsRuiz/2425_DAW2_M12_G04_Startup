@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- MIGAS DE PAN --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                @if(auth()->user()->role_id == 2)
                <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-[#5e0490]">
                    Dashboard
                </a>
                @elseif(auth()->user()->role_id == 3)
                <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-[#5e0490]">
                    Dashboard
                </a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-[#5e0490]">Mis Conversaciones</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">{{ $otherUser->nombre }}</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado del chat -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6 transform transition-all duration-300 hover:shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-[#5e0490] transition-colors duration-200">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-lg transform transition-transform duration-300 hover:scale-105">
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
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $otherUser->nombre }}</h1>
                        <p class="text-gray-600">{{ $solicitud->publicacion->titulo }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 animate-pulse">
                        <span class="w-2 h-2 mr-2 rounded-full bg-green-400"></span>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenedor del chat -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden transform transition-all duration-300 hover:shadow-md">
            <!-- Área de mensajes -->
            <div id="chat-messages" class="h-[500px] overflow-y-auto p-6 space-y-4 bg-gray-50">
                @if($mensajes->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 mb-4">
                            <i class="fas fa-comments text-2xl text-[#5e0490]"></i>
                        </div>
                        <p class="text-gray-500">No hay mensajes aún. ¡Comienza la conversación!</p>
                    </div>
                @else
                    @foreach($mensajes as $mensaje)
                        <div class="flex {{ $mensaje->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs md:max-w-md lg:max-w-lg {{ $mensaje->user_id === auth()->id() ? 'bg-[#5e0490] text-white' : 'bg-gray-100 text-gray-800' }} rounded-2xl px-4 py-2 shadow-sm transform transition-transform duration-200 hover:scale-105">
                                <p class="text-sm">{{ $mensaje->contenido }}</p>
                                <p class="text-xs mt-1 {{ $mensaje->user_id === auth()->id() ? 'text-purple-200' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($mensaje->fecha_envio)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Formulario para enviar mensajes -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <form id="message-form" class="flex space-x-4">
                    <div class="flex-1">
                        <input type="text" id="message-input" 
                               class="w-full rounded-lg border-gray-300 focus:border-[#5e0490] focus:ring-[#5e0490] transition-colors duration-200" 
                               placeholder="Escribe un mensaje...">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-colors duration-200 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Scripts para el chat -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const chatId = '{{ $chat->id }}';
    let lastMessageId = {{ $mensajes->last() ? $mensajes->last()->id : 0 }};
    
    // Hacer scroll al último mensaje
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Función para crear el HTML de un mensaje
    function createMessageHtml(mensaje) {
        const isMine = mensaje.user_id === {{ auth()->id() }};
        return `
            <div class="flex ${isMine ? 'justify-end' : 'justify-start'}">
                <div class="max-w-xs md:max-w-md lg:max-w-lg ${isMine ? 'bg-[#5e0490] text-white' : 'bg-gray-100 text-gray-800'} rounded-2xl px-4 py-2 shadow-sm transform transition-transform duration-200 hover:scale-105">
                    <p class="text-sm">${mensaje.contenido}</p>
                    <p class="text-xs mt-1 ${isMine ? 'text-purple-200' : 'text-gray-500'}">
                        ${new Date(mensaje.fecha_envio).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </p>
                </div>
            </div>
        `;
    }
    
    // Función para actualizar los mensajes
    function updateMessages() {
        fetch('{{ route('chat.messages', ['chat' => $chat->id]) }}')
            .then(response => response.json())
            .then(data => {
                if (!data.error && data.mensajes.length > 0) {
                    const newMessages = data.mensajes.filter(mensaje => mensaje.id > lastMessageId);
                    
                    if (newMessages.length > 0) {
                        newMessages.forEach(mensaje => {
                            chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(mensaje));
                        });
                        
                        lastMessageId = newMessages[newMessages.length - 1].id;
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                }
            })
            .catch(error => {
                console.error('Error al actualizar mensajes:', error);
            });
    }
    
    // Enviar mensaje
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        if (!content) return;
        
        // Enviar mensaje al servidor
        fetch('{{ route('chat.message', ['chat' => $chat->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ contenido: content })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                // Limpiar input
                messageInput.value = '';
                
                // Añadir mensaje a la vista
                chatMessages.insertAdjacentHTML('beforeend', createMessageHtml(data.mensaje));
                lastMessageId = data.mensaje.id;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error al enviar mensaje:', error);
        });
    });
    
    // Actualizar mensajes cada 3 segundos
    setInterval(updateMessages, 3000);
});
</script>
@endsection 