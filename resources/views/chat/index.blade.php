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
                @php
                    $user = auth()->user();
                    $dashboardRoute = match($user->role_id) {
                        2 => route('empresa.dashboard'),
                        3 => route('student.dashboard'),
                        4 => route('docente.dashboard'),
                        5 => route('institucion.dashboard'),
                        default => '#'
                    };
                @endphp
                
                @if($dashboardRoute !== '#')
                <a href="{{ $dashboardRoute }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                    Dashboard
                </a>
                <span class="mx-2 text-gray-400">/</span>
                @endif
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
                        <p class="text-gray-600">
                            @if(auth()->user()->role_id == 2)
                                Gestiona tus conversaciones con estudiantes
                            @elseif(auth()->user()->role_id == 3)
                                Gestiona tus conversaciones con empresas y docentes
                            @elseif(auth()->user()->role_id == 4)
                                Gestiona tus conversaciones con estudiantes
                            @endif
                        </p>
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
            @if(auth()->user()->role_id == 4 && isset($estudiantes))
        <!-- Lista de estudiantes para docentes -->
        <div class="mb-8 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg border border-purple-100">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Mis Estudiantes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($estudiantes as $estudiante)
                        <div class="bg-purple-50 rounded-lg p-4 hover:bg-purple-100 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                                        <span class="text-purple-700 font-semibold">
                                            {{ strtoupper(substr($estudiante->user->nombre, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">{{ $estudiante->user->nombre }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $estudiante->clases->pluck('nombre')->implode(', ') }}
                                        </p>
                                    </div>
                                </div>
                                <form action="{{ route('chat.create.docente') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                                    <button type="submit" class="p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                        <i class="fas fa-comment"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
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
                        @elseif(auth()->user()->role_id == 3)
                            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Buscar ofertas
                            </a>
			@elseif(auth()->user()->role_id == 4)
                            Cuando inicies una conversación con estudiantes, aparecerán aquí.
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
                                                <img src="{{ asset('profile_images/' . $chat->solicitud->estudiante->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->solicitud->estudiante->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @else
                                            @if($chat->solicitud->publicacion->empresa->user->imagen)
                                                <img src="{{ asset('profile_images/' . $chat->solicitud->publicacion->empresa->user->imagen) }}" 
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

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
<script src="{{ asset('js/chat.js') }}"></script>
@endsection 