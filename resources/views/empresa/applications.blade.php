@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        @component('components.breadcrumb')
            @slot('items')
                [{"name": "Dashboard", "route": "empresa.dashboard"}, {"name": "Solicitudes"}]
            @endslot
        @endcomponent

        <!-- Encabezado mejorado -->
        <div class="mb-8 bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 break-words">{{ $publication->titulo }}</h1>
                    <div class="flex flex-col sm:flex-row sm:items-center mt-2 space-y-1 sm:space-y-0 sm:space-x-4">
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Publicado: {{ $publication->fecha_publicacion ? date('d/m/Y', strtotime($publication->fecha_publicacion)) : 'Fecha no disponible' }}
                        </span>
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Horario: {{ ucfirst($publication->horario) }}
                        </span>
                        <span class="text-gray-600 flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            {{ $solicitudes->count() }} solicitudes
                        </span>
                    </div>
                </div>
                <div class="flex justify-end md:justify-end">
                    <a href="{{ route('empresa.dashboard') }}" class="flex items-center text-gray-600 hover:text-gray-900 mt-4 md:mt-0">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtros y estadísticas -->
        <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="text-sm font-medium text-gray-500">Total Solicitudes</div>
                <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $solicitudes->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="text-sm font-medium text-gray-500">Pendientes</div>
                <div class="mt-1 text-2xl font-semibold text-yellow-600">
                    {{ $solicitudes->where('estado', 'pendiente')->count() }}
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="text-sm font-medium text-gray-500">Aceptadas</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">
                    {{ $solicitudes->where('estado', 'aceptada')->count() }}
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="text-sm font-medium text-gray-500">Rechazadas</div>
                <div class="mt-1 text-2xl font-semibold text-red-600">
                    {{ $solicitudes->where('estado', 'rechazada')->count() }}
                </div>
            </div>
        </div>

        <!-- Lista de solicitudes -->
        <div class="bg-white rounded-lg shadow-md">
            @if($solicitudes->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No hay solicitudes</h3>
                    <p class="mt-2 text-gray-500">Aún no has recibido solicitudes para esta oferta.</p>
                </div>
            @else
                <div class="overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($solicitudes as $solicitud)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:space-x-6 gap-3">
                                    <!-- Avatar y estado arriba en móvil -->
                                    <div class="flex flex-row items-center gap-3 sm:flex-col sm:items-start">
                                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                                            <span class="text-xl font-bold text-purple-700">
                                                {{ strtoupper(substr(optional(optional($solicitud->estudiante)->user)->nombre ?? '--', 0, 2)) }}
                                            </span>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($solicitud->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                            @elseif($solicitud->estado === 'aceptada') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif
                                            sm:mt-3 sm:text-sm">
                                            <span class="w-2 h-2 mr-2 rounded-full
                                                @if($solicitud->estado === 'pendiente') bg-yellow-400
                                                @elseif($solicitud->estado === 'aceptada') bg-green-400
                                                @else bg-red-400 @endif">
                                            </span>
                                            {{ ucfirst($solicitud->estado) }}
                                        </span>
                                    </div>

                                    <!-- Información principal -->
                                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div>
                                                <a href="{{ route('profile.show', optional(optional($solicitud->estudiante)->user)->id ?? '#') }}"
                                                   class="group flex items-center space-x-2 hover:text-purple-600 transition-colors duration-200">
                                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 group-hover:text-purple-600">
                                                        {{ optional(optional($solicitud->estudiante)->user)->nombre ?? 'Sin nombre' }}
                                                    </h3>
                                                    <i class="fas fa-external-link-alt text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                                </a>
                                            </div>
                                            @if($solicitud->estudiante->cv_pdf)
                                                <a href="{{ asset('cv/' . $solicitud->estudiante->cv_pdf) }}"
                                                   target="_blank"
                                                   class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                                                    <i class="fas fa-file-pdf mr-1"></i>
                                                    <span class="hidden md:block">Ver CV</span>
                                                </a>
                                            @endif
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:flex-wrap sm:space-x-6">
                                            <div class="flex items-center text-xs sm:text-sm text-gray-500 mt-1">
                                                <i class="fas fa-school mr-1.5 text-gray-400"></i>
                                                {{ $solicitud->estudiante->centro_educativo }}
                                            </div>
                                            <div class="flex items-center text-xs sm:text-sm text-gray-500 mt-1">
                                                <i class="fas fa-calendar mr-1.5 text-gray-400"></i>
                                                Solicitado: {{ date('d/m/Y H:i', strtotime($solicitud->created_at)) }}
                                            </div>
                                        </div>

                                        @if($solicitud->mensaje)
                                            <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                                <h4 class="text-xs sm:text-sm font-medium text-gray-900 mb-1 flex items-center">
                                                    <i class="fas fa-comment-alt mr-2 text-gray-400"></i>
                                                    Mensaje del estudiante
                                                </h4>
                                                <p class="text-gray-600 text-xs sm:text-sm">{{ $solicitud->mensaje }}</p>
                                            </div>
                                        @endif

                                        @if($solicitud->respuesta_empresa)
                                            <div class="mt-3 bg-purple-50 rounded-lg p-3">
                                                <h4 class="text-xs sm:text-sm font-medium text-purple-900 mb-1 flex items-center">
                                                    <i class="fas fa-reply mr-2 text-purple-400"></i>
                                                    Tu respuesta
                                                </h4>
                                                <p class="text-purple-600 text-xs sm:text-sm">{{ $solicitud->respuesta_empresa }}</p>
                                            </div>
                                        @endif

                                        @if($solicitud->estado === 'pendiente')
                                            <form action="{{ route('empresa.applications.update', ['publication' => $publication->id, 'application' => $solicitud->id]) }}"
                                                  method="POST"
                                                  class="mt-6">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        <i class="fas fa-pen mr-2"></i>
                                                        Escribe una respuesta
                                                    </label>
                                                    <textarea name="respuesta_empresa"
                                                              rows="3"
                                                              class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                                              placeholder="Escribe un mensaje para el estudiante..."></textarea>
                                                </div>

                                                <div class="flex justify-end space-x-3">
                                                    <button type="submit"
                                                            name="estado"
                                                            value="rechazada"
                                                            class="inline-flex items-center px-4 py-2 border border-red-500 text-red-500 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Rechazar
                                                    </button>
                                                    <button type="submit"
                                                            name="estado"
                                                            value="aceptada"
                                                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                                        <i class="fas fa-check mr-2"></i>
                                                        Aceptar
                                                    </button>
                                                </div>
                                            </form>
                                        @elseif($solicitud->estado === 'aceptada')
                                            <div class="mt-6">
                                                @if($solicitud->chat)
                                                    <a href="{{ route('chat.show', $solicitud->chat->id) }}"
                                                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                                        <i class="fas fa-comments mr-2"></i>
                                                        Ir al chat
                                                    </a>
                                                @else
                                                    <form action="{{ route('chat.create', $solicitud->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                                            <i class="fas fa-plus-circle mr-2"></i>
                                                            Crear chat
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Sweet Alert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script de animaciones -->
<script src="{{ asset('js/applications-animations.js') }}"></script>
@endsection
