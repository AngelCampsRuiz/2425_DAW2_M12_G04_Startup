@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
    {{-- MIGAS DE PAN --}}
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                @if(auth()->user()->role_id == 2)
                <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    Dashboard
                </a>
                @elseif(auth()->user()->role_id == 3)
                <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    Dashboard
                </a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-purple-700 font-medium">Mis Conversaciones</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="mb-8 bg-white rounded-xl shadow-md p-6 transform transition-all duration-300 hover:shadow-lg border border-purple-100">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center shadow-md">
                        <i class="fas fa-comments text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-700 to-indigo-600">Mis Conversaciones</h1>
                        <p class="text-gray-600">Gestiona tus conversaciones con {{ auth()->user()->role_id == 2 ? 'estudiantes' : 'empresas' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center bg-purple-50 rounded-lg px-4 py-2 text-sm text-purple-700">
                        <i class="fas fa-lightbulb mr-2 text-purple-500"></i>
                        <span>Responde rápido para mayor efectividad</span>
                    </div>
                    <a href="{{ url()->previous() }}" class="flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 text-gray-700 hover:text-purple-700 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="mb-6 bg-white rounded-xl shadow-md p-4 flex flex-col sm:flex-row gap-4 items-center justify-between border border-purple-100">
            <div class="relative flex-grow max-w-md w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search-chats" placeholder="Buscar conversaciones..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
            </div>
            <div class="flex items-center gap-2 self-end sm:self-auto">
                <button class="px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors flex items-center text-sm" id="sort-button">
                    <i class="fas fa-sort-amount-down mr-2 text-purple-600"></i>
                    <span>Recientes</span>
                </button>
                <button class="p-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors flex items-center" id="filter-button">
                    <i class="fas fa-filter text-purple-600"></i>
                </button>
            </div>
        </div>

        <!-- Lista de chats -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg border border-purple-100">
            @if($chats->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 mb-6 transform transition-transform duration-300 hover:scale-105 shadow-md">
                        <i class="fas fa-comments text-4xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes conversaciones</h3>
                    <p class="mt-2 text-gray-500 max-w-md mx-auto">Cuando inicies una conversación con {{ auth()->user()->role_id == 2 ? 'estudiantes' : 'empresas' }}, aparecerán aquí.</p>
                    
                    <div class="mt-8">
                        @if(auth()->user()->role_id == 2)
                            <a href="{{ route('empresa.dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-user-plus mr-2"></i>
                                Revisar solicitudes
                            </a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Buscar ofertas
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div id="chat-list" class="divide-y divide-gray-200">
                    @foreach($chats as $chat)
                        <a href="{{ route('chat.show', $chat->id) }}" 
                           class="chat-item block p-6 hover:bg-purple-50 transition-all duration-300 transform hover:scale-[1.01] relative">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-md transition-transform duration-300 hover:scale-105">
                                        @if(auth()->user()->empresa)
                                            @if($chat->solicitud->estudiante->user->imagen)
                                                <img src="{{ asset('public/profile_images/' . $chat->solicitud->estudiante->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->solicitud->estudiante->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @else
                                            @if($chat->solicitud->publicacion->empresa->user->imagen)
                                                <img src="{{ asset('public/profile_images/' . $chat->solicitud->publicacion->empresa->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->solicitud->publicacion->empresa->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Información del chat -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            @if(auth()->user()->empresa)
                                                {{ $chat->solicitud->estudiante->user->nombre }}
                                            @else
                                                {{ $chat->solicitud->publicacion->empresa->user->nombre }}
                                            @endif
                                            @if($chat->mensajes->count() > 0 && $chat->mensajes->last()->created_at->diffInDays() < 1)
                                                <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-medium leading-none text-green-800 bg-green-100 rounded-full animate-pulse">
                                                    Reciente
                                                </span>
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500 flex items-center">
                                            <i class="far fa-clock mr-1.5 text-gray-400"></i>
                                            {{ $chat->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-medium bg-purple-100 text-purple-800 rounded-lg">
                                            <i class="fas fa-briefcase mr-1 text-purple-600"></i>
                                            Oferta
                                        </span>
                                        <p class="text-gray-600 truncate">
                                            {{ $chat->solicitud->publicacion->titulo }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-2 flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-comment-alt mr-1.5 text-purple-600"></i>
                                            <span class="font-medium">{{ $chat->mensajes->count() }}</span> 
                                            <span class="ml-1">{{ $chat->mensajes->count() === 1 ? 'mensaje' : 'mensajes' }}</span>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            @if($chat->mensajes->isNotEmpty())
                                                @php
                                                    $ultimoMensaje = $chat->mensajes->last();
                                                    $esNuevo = $ultimoMensaje->sender_id !== auth()->id() && 
                                                              ($ultimoMensaje->read_at === null);
                                                @endphp
                                                
                                                @if($esNuevo)
                                                    <span class="inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full"></span>
                                                @endif
                                            @endif
                                            <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-100 text-purple-800 rounded-full hover:bg-purple-200 transition-colors">
                                                <i class="fas fa-chevron-right text-xs"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Javascript para funcionalidad de búsqueda y filtrado -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de búsqueda
    const searchInput = document.getElementById('search-chats');
    const chatItems = document.querySelectorAll('.chat-item');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Verificar si hay resultados visibles
            checkVisibleResults();
        });
    }
    
    function checkVisibleResults() {
        const chatList = document.getElementById('chat-list');
        if (!chatList) return;
        
        let visibleItems = 0;
        chatItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleItems++;
            }
        });
        
        // Si no hay resultados, mostrar mensaje
        if (visibleItems === 0 && chatItems.length > 0) {
            // Verificar si ya existe el mensaje
            if (!document.getElementById('no-results-message')) {
                const noResults = document.createElement('div');
                noResults.id = 'no-results-message';
                noResults.className = 'p-8 text-center';
                noResults.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No se encontraron resultados</h3>
                    <p class="mt-1 text-gray-500">Prueba con otros términos de búsqueda</p>
                `;
                chatList.appendChild(noResults);
            }
        } else {
            // Eliminar mensaje si existe
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
    }
    
    // Funcionalidad para botones de ordenar y filtrar
    const sortButton = document.getElementById('sort-button');
    if (sortButton) {
        sortButton.addEventListener('click', function() {
            // Alternar entre ordenar por más reciente o más antiguo
            const isDescending = this.querySelector('i').classList.contains('fa-sort-amount-down');
            
            if (isDescending) {
                // Cambiar a ascendente
                this.querySelector('i').classList.replace('fa-sort-amount-down', 'fa-sort-amount-up');
                this.querySelector('span').textContent = 'Antiguos';
                sortChats(false);
            } else {
                // Cambiar a descendente
                this.querySelector('i').classList.replace('fa-sort-amount-up', 'fa-sort-amount-down');
                this.querySelector('span').textContent = 'Recientes';
                sortChats(true);
            }
        });
    }
    
    function sortChats(descending) {
        const chatList = document.getElementById('chat-list');
        if (!chatList) return;
        
        const items = Array.from(chatItems);
        
        items.sort((a, b) => {
            const dateA = a.querySelector('.text-gray-500').textContent.trim();
            const dateB = b.querySelector('.text-gray-500').textContent.trim();
            
            // Este es un ordenamiento simple basado en el texto de tiempo relativo
            // Para un ordenamiento más preciso se necesitaría un valor de fecha
            if (descending) {
                return dateA.localeCompare(dateB) * -1;
            } else {
                return dateA.localeCompare(dateB);
            }
        });
        
        // Reordenar los elementos en el DOM
        items.forEach(item => {
            chatList.appendChild(item);
        });
    }
    
    // Animación de entrada para los elementos de chat
    chatItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 100 + index * 50);
    });
});
</script>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Estilos adicionales y animaciones */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Estilos para scrollbar personalizado */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
@endsection 