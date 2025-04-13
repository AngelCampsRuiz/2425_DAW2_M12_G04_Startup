@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado del chat -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <span class="text-xl font-bold text-purple-700">
                            {{ strtoupper(substr($otherUser->name, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $otherUser->name }}</h1>
                        <p class="text-gray-600">{{ $solicitud->publicacion->titulo }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 mr-2 rounded-full bg-green-400"></span>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenedor del chat -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Área de mensajes -->
            <div id="chat-messages" class="h-96 overflow-y-auto p-6 space-y-4">
                @if($mensajes->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">No hay mensajes aún. ¡Comienza la conversación!</p>
                    </div>
                @else
                    @foreach($mensajes as $mensaje)
                        <div class="flex {{ $mensaje->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs md:max-w-md lg:max-w-lg {{ $mensaje->user_id === auth()->id() ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }} rounded-lg px-4 py-2">
                                <p class="text-sm">{{ $mensaje->contenido }}</p>
                                <p class="text-xs mt-1 {{ $mensaje->user_id === auth()->id() ? 'text-purple-600' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($mensaje->fecha_envio)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Formulario para enviar mensajes -->
            <div class="border-t border-gray-200 p-4">
                <form id="message-form" class="flex space-x-4">
                    <div class="flex-1">
                        <input type="text" id="message-input" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" placeholder="Escribe un mensaje...">
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
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
    const currentMessageCount = '{{ $mensajes->count() }}';
    
    // Hacer scroll al último mensaje
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
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
                const messageHtml = `
                    <div class="flex justify-end">
                        <div class="max-w-xs md:max-w-md lg:max-w-lg bg-purple-100 text-purple-800 rounded-lg px-4 py-2">
                            <p class="text-sm">${data.mensaje.contenido}</p>
                            <p class="text-xs mt-1 text-purple-600">
                                ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </p>
                        </div>
                    </div>
                `;
                
                chatMessages.insertAdjacentHTML('beforeend', messageHtml);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error al enviar mensaje:', error);
        });
    });
    
    // Actualizar mensajes cada 10 segundos
    setInterval(function() {
        fetch('{{ route('chat.messages', ['chat' => $chat->id]) }}')
            .then(response => response.json())
            .then(data => {
                if (!data.error && data.mensajes.length > parseInt(currentMessageCount)) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error al actualizar mensajes:', error);
            });
    }, 10000);
});
</script>
@endsection 