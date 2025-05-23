@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.chat')

@section('title', 'Mis Conversaciones')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">

    <div class="container mx-auto px-4 py-8">
        <!-- Mensajes de notificación -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" id="alert-success">
            <div class="flex items-center">
                <div class="py-1"><svg class="w-6 h-6 mr-4 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg></div>
                <span>{{ session('success') }}</span>
                <button type="button" class="ml-auto" onclick="document.getElementById('alert-success').remove()">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="mb-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-md" id="alert-info">
            <div class="flex items-center">
                <div class="py-1"><svg class="w-6 h-6 mr-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg></div>
                <span>{{ session('info') }}</span>
                <button type="button" class="ml-auto" onclick="document.getElementById('alert-info').remove()">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(isset($tienesNuevosMensajes) && $tienesNuevosMensajes)
        <div class="mb-4 bg-purple-100 border-l-4 border-purple-500 text-purple-700 p-4 rounded-md shadow-md" id="alert-new-messages">
            <div class="flex items-center">
                <div class="py-1"><svg class="w-6 h-6 mr-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg></div>
                <span>¡Tienes mensajes nuevos sin leer!</span>
                <button type="button" class="ml-auto" onclick="document.getElementById('alert-new-messages').remove()">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif

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
                            @elseif(auth()->user()->role_id == 5)
                                Gestiona tus conversaciones
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
            @php
                // Verificar si hay chats sin leer
                $tienesNuevosMensajes = false;
                if(isset($chats) && $chats->isNotEmpty()) {
                    foreach($chats as $chat) {
                        if($chat->mensajes && $chat->mensajes->isNotEmpty()) {
                            $ultimoMensaje = $chat->mensajes->last();
                            if($ultimoMensaje->user_id !== auth()->id() && 
                               ($ultimoMensaje->read_at === null || $ultimoMensaje->leido === false)) {
                                $tienesNuevosMensajes = true;
                                break;
                            }
                        }
                    }
                }
            @endphp

            @if($chats->isEmpty())
            @if(auth()->user()->role_id == 4)
            <!-- Lista de estudiantes para docentes -->
            <div class="mb-8 bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg border border-purple-100">
                <div class="bg-gray-50 px-5 py-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="font-medium">Mis Estudiantes</span>
                        </div>
                        <a href="{{ route('docente.alumnos.index') }}" class="text-sm text-purple-600 hover:text-purple-800 transition-all duration-200 flex items-center">
                            <i class="fas fa-users mr-1"></i> Ver todos mis estudiantes
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if(isset($estudiantes) && $estudiantes->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($estudiantes as $estudiante)
                            <div class="bg-purple-50 rounded-lg p-4 hover:bg-purple-100 transition-colors duration-200 shadow-sm hover:shadow transform hover:-translate-y-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                                            @if($estudiante->user && $estudiante->user->imagen)
                                                <img src="{{ asset('profile_images/' . $estudiante->user->imagen) }}" 
                                                    alt="{{ $estudiante->user->nombre }}"
                                                    class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <span class="text-purple-700 font-semibold">
                                                    @if($estudiante->user)
                                                        {{ strtoupper(substr($estudiante->user->nombre, 0, 2)) }}
                                                    @else
                                                        ST
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-800">{{ $estudiante->user ? $estudiante->user->nombre : 'Estudiante' }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $estudiante->user ? $estudiante->user->email : 'Sin email' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $estudiante->clases ? $estudiante->clases->pluck('nombre')->implode(', ') : 'Sin clases asignadas' }}
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
                    @else
                    <div class="text-center py-8">
                        <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-user-graduate text-2xl text-purple-500"></i>
                        </div>
                        <h3 class="font-medium text-gray-700 mb-2">No se encontraron estudiantes</h3>
                        <p class="text-gray-500 text-sm max-w-md mx-auto mb-4">
                            No se detectaron estudiantes asignados a tus clases. Verifica que tengas clases asignadas correctamente.
                        </p>
                        <a href="{{ route('docente.alumnos.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i> Buscar estudiantes
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
                @if(auth()->user()->role_id == 3)
                <!-- Lista de docentes para estudiantes -->
                <div class="mb-8">
                    <div class="bg-gray-50 px-5 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span class="font-medium">Mis Profesores</span>
                            </div>
                            <a href="{{ route('student.dashboard') }}" class="text-sm text-purple-600 hover:text-purple-800 transition-all duration-200 flex items-center">
                                <i class="fas fa-graduation-cap mr-1"></i> Volver al dashboard
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($docentes) && $docentes->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($docentes as $docente)
                                <div class="bg-purple-50 rounded-lg p-4 hover:bg-purple-100 transition-colors duration-200 shadow-sm hover:shadow transform hover:-translate-y-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                                                @if($docente->user && $docente->user->imagen)
                                                    <img src="{{ asset('profile_images/' . $docente->user->imagen) }}" 
                                                        alt="{{ $docente->user->nombre }}"
                                                        class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <span class="text-purple-700 font-semibold">
                                                        {{ $docente->user ? strtoupper(substr($docente->user->nombre, 0, 2)) : 'PR' }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-medium text-gray-800">{{ $docente->user ? $docente->user->nombre : 'Profesor' }}</h3>
                                                <p class="text-sm text-gray-600">
                                                    {{ $docente->especialidad ?? 'Docente' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <form action="{{ route('chat.create.docente') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="docente_id" value="{{ $docente->id }}">
                                                <button type="submit" class="p-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                                    <i class="fas fa-comment"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-chalkboard-teacher text-2xl text-purple-500"></i>
                            </div>
                            <h3 class="font-medium text-gray-700 mb-2">No se encontraron profesores</h3>
                            <p class="text-gray-500 text-sm max-w-md mx-auto mb-4">
                                No se detectaron profesores asignados a tus clases. Verifica con tu institución que estés correctamente matriculado.
                            </p>
                            <a href="{{ route('chat.refresh') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                <i class="fas fa-sync-alt mr-2"></i> Refrescar datos
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 mb-6 transform transition-transform duration-300 hover:scale-105 shadow-md">
                        <i class="fas fa-comments text-4xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes conversaciones</h3>
                    <p class="mt-2 text-gray-500 max-w-md mx-auto">Cuando inicies una conversación con {{ auth()->user()->role_id == 2 ? 'estudiantes' : (auth()->user()->role_id == 3 ? 'profesores o empresas' : 'empresas') }}, aparecerán aquí.</p>
                    
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
                        
                            <!-- Revisar si hay chats sin leer -->
                            <a href="{{ route('chat.refresh') }}" class="mt-4 inline-flex items-center px-5 py-3 bg-white border border-purple-300 text-purple-700 rounded-lg shadow-sm hover:bg-purple-50 transition-all duration-200">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Revisar mensajes nuevos
                            </a>
                            <p class="mt-3 text-sm text-gray-500">Es posible que tengas mensajes nuevos que no estén apareciendo</p>
                        @elseif(auth()->user()->role_id == 4)
                            <a href="{{ route('docente.alumnos.index') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-users mr-2"></i>
                                Ver mis estudiantes
                            </a>
                            
                            <p class="mt-3 text-sm text-gray-500">Puedes iniciar conversaciones con los estudiantes asignados a tus clases</p>
                        @elseif(auth()->user()->role_id == 5)
                            <a href="{{ route('institucion.dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-university mr-2"></i>
                                Volver al panel
                            </a>
                            
                            <p class="mt-3 text-sm text-gray-500">Aquí aparecerán tus conversaciones con docentes y estudiantes</p>
                        @endif
                    </div>
                </div>
                @endif
            @else
                <div id="chat-list" class="divide-y divide-gray-200">
                    @foreach($chats as $chat)
                        @php
                            $tienesMensajesNoLeidos = false;
                            if($chat->mensajes->isNotEmpty()) {
                                $ultimoMensaje = $chat->mensajes->last();
                                $tienesMensajesNoLeidos = $ultimoMensaje->sender_id !== auth()->id() && 
                                              ($ultimoMensaje->read_at === null);
                            }
                        @endphp
                        
                        <a href="{{ route('chat.show', $chat->id) }}" 
                           class="chat-item block p-6 hover:bg-purple-50 transition-all duration-300 transform hover:scale-[1.01] relative
                           {{ $tienesMensajesNoLeidos ? 'bg-purple-50 border-l-4 border-purple-600' : '' }}">
                            
                            @if($tienesMensajesNoLeidos)
                            <div class="absolute top-2 right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full animate-pulse">
                                <i class="fas fa-envelope mr-1"></i> Nuevo mensaje
                            </div>
                            @endif
                            
                            <div class="flex items-start space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-md transition-transform duration-300 hover:scale-105">
                                        @if(auth()->user()->empresa && $chat->tipo == 'empresa_estudiante')
                                            @if($chat->solicitud->estudiante->user->imagen)
                                                <img src="{{ asset('profile_images/' . $chat->solicitud->estudiante->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->solicitud->estudiante->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @elseif(auth()->user()->estudiante && $chat->tipo == 'empresa_estudiante')
                                            @if($chat->solicitud->publicacion->empresa->user->imagen)
                                                <img src="{{ asset('profile_images/' . $chat->solicitud->publicacion->empresa->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->solicitud->publicacion->empresa->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @elseif(auth()->user()->role_id == 4 && $chat->tipo == 'docente_estudiante')
                                            @if($chat->estudiante->user->imagen)
                                                <img src="{{ asset('profile_images/' . $chat->estudiante->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->estudiante->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @elseif(auth()->user()->estudiante && $chat->tipo == 'docente_estudiante')
                                            @if($chat->docente->user->imagen)
                                                <img src="{{ asset('profile_images/' . $chat->docente->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-purple-600">
                                                    {{ strtoupper(substr($chat->docente->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Información del chat -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                            @if(auth()->user()->empresa && $chat->tipo == 'empresa_estudiante')
                                                {{ $chat->solicitud->estudiante->user->nombre }}
                                            @elseif(auth()->user()->estudiante && $chat->tipo == 'empresa_estudiante')
                                                {{ $chat->solicitud->publicacion->empresa->user->nombre }}
                                            @elseif(auth()->user()->role_id == 4 && $chat->tipo == 'docente_estudiante')
                                                {{ $chat->estudiante->user->nombre }}
                                            @elseif(auth()->user()->estudiante && $chat->tipo == 'docente_estudiante')
                                                {{ $chat->docente->user->nombre }}
                                            @endif
                                            @if($chat->mensajes->count() > 0 && $chat->mensajes->first()->created_at->diffInDays() < 1)
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
                                        @if($chat->tipo == 'empresa_estudiante')
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-medium bg-purple-100 text-purple-800 rounded-lg">
                                            <i class="fas fa-briefcase mr-1 text-purple-600"></i>
                                            Oferta
                                        </span>
                                        <p class="text-gray-600 truncate">
                                            {{ $chat->solicitud->publicacion->titulo }}
                                        </p>
                                        @elseif($chat->tipo == 'docente_estudiante')
                                        <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                            <i class="fas fa-graduation-cap mr-1 text-blue-600"></i>
                                            Estudiante
                                        </span>
                                        <p class="text-gray-600 truncate">
                                            Chat académico
                                        </p>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-2 flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-comment-alt mr-1.5 text-purple-600"></i>
                                            <span class="font-medium">{{ $chat->mensajes->count() }}</span> 
                                            <span class="ml-1">{{ $chat->mensajes->count() === 1 ? 'mensaje' : 'mensajes' }}</span>
                                            
                                            @if($tienesMensajesNoLeidos)
                                                <span class="ml-2 text-red-600 font-medium">
                                                    • No leído
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            @if($tienesMensajesNoLeidos)
                                                <span class="inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
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

        @if(auth()->user()->role_id == 4)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-[#5e0490] mb-4">Crear nuevo chat</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Formulario para crear chat con estudiante -->
                    <div class="bg-white rounded-xl p-6 shadow-md border border-purple-100">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Chat con estudiante</h3>
                        <form action="{{ route('chat.create.docente') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="estudiante_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar estudiante</label>
                                <select name="estudiante_id" id="estudiante_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <option value="">Selecciona un estudiante</option>
                                    @isset($estudiantes)
                                        @foreach($estudiantes as $estudiante)
                                            <option value="{{ $estudiante->id }}">{{ $estudiante->user->nombre }} ({{ $estudiante->clases->first()->nombre_clase ?? 'Sin clase' }})</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-md hover:from-[#4a0370] hover:to-[#5e0490] focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                Iniciar conversación
                            </button>
                        </form>
                    </div>
                    
                    <!-- Formulario para crear chat con empresa -->
                    <div class="bg-white rounded-xl p-6 shadow-md border border-purple-100">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Chat con empresa</h3>
                        <form action="{{ route('chat.create.docente.empresa') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="empresa_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar empresa</label>
                                <select name="empresa_id" id="empresa_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <option value="">Selecciona una empresa</option>
                                    @isset($empresas)
                                        @foreach($empresas as $empresa)
                                            <option value="{{ $empresa->id }}">{{ $empresa->user->nombre }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-[#5e0490] to-[#4a0370] text-white rounded-md hover:from-[#4a0370] hover:to-[#5e0490] focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                Iniciar conversación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer la URL para verificar mensajes nuevos
    document.body.setAttribute('data-check-new-url', '{{ route("chat.check_new") }}');
    
    // Verificar mensajes nuevos cada 60 segundos (opcional)
    @if(auth()->user()->role_id == 3)
    setInterval(function() {
        fetch('{{ route("chat.check_new") }}')
            .then(response => response.json())
            .then(data => {
                if (data.has_new_chats) {
                    // Mostrar notificación al usuario
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-purple-600 text-white px-4 py-3 rounded-lg shadow-lg z-50';
                    notification.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-bell mr-2"></i>
                            <span>Tienes nuevos mensajes. <a href="{{ route("chat.index") }}" class="underline">Ver ahora</a></span>
                        </div>
                    `;
                    document.body.appendChild(notification);
                    
                    // Eliminar la notificación después de 10 segundos
                    setTimeout(() => {
                        notification.remove();
                    }, 10000);
                }
            });
    }, 60000);
    @endif
});
</script>

<script src="{{ asset('js/chat.js') }}"></script>
@endsection 