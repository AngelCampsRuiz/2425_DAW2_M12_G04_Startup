@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- BREADCRUMBS --}}
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
                <a href="{{ route('estudiante.solicitudes.index') }}" class="text-gray-500 hover:text-[#5e0490]">
                    Mis Solicitudes
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">Detalle de Solicitud</span>
            </div>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detalle de Solicitud</h1>
            <a href="{{ route('estudiante.solicitudes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
        </div>
        
        {{-- TARJETA DE DETALLES --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            {{-- CABECERA --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16">
                            @if($solicitud->publicacion->empresa->user->imagen ?? null)
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('public/profile_images/' . $solicitud->publicacion->empresa->user->imagen) }}" alt="Logo empresa">
                            @else
                                <div class="h-16 w-16 rounded-full bg-purple-100 flex items-center justify-center text-[#5e0490]">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-medium text-gray-900">{{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}</h2>
                            <p class="text-sm text-gray-600">{{ $solicitud->publicacion->titulo ?? 'Publicación' }}</p>
                            <div class="mt-1 flex items-center">
                                <span class="text-sm text-gray-500">Solicitud enviada el {{ $solicitud->created_at->format('d/m/Y') }} a las {{ $solicitud->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        @php
                            $badgeClass = '';
                            switch($solicitud->estado) {
                                case 'pendiente':
                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'aceptada':
                                    $badgeClass = 'bg-green-100 text-green-800';
                                    break;
                                case 'rechazada':
                                    $badgeClass = 'bg-red-100 text-red-800';
                                    break;
                            }
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $badgeClass }}">
                            {{ ucfirst($solicitud->estado) }}
                        </span>
                    </div>
                </div>
            </div>
            
            {{-- CONTENIDO --}}
            <div class="p-6 space-y-6">
                {{-- DETALLES DE LA SOLICITUD --}}
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Detalles de la Solicitud</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Estado</p>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($solicitud->estado) }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Fecha de la solicitud</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Publicación</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $solicitud->publicacion->titulo ?? 'Sin título' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Empresa</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- MENSAJE DE LA SOLICITUD --}}
                @if($solicitud->mensaje)
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Mensaje de la Solicitud</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $solicitud->mensaje }}</p>
                    </div>
                </div>
                @endif
                
                {{-- RESPUESTA DE LA EMPRESA --}}
                @if($solicitud->respuesta_empresa)
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Respuesta de la Empresa</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $solicitud->respuesta_empresa }}</p>
                    </div>
                </div>
                @endif
                
                {{-- DETALLES DE LA PUBLICACIÓN --}}
                @if($solicitud->publicacion)
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Detalles de la Publicación</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Horario</p>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($solicitud->publicacion->horario ?? 'No especificado') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Horas totales</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $solicitud->publicacion->horas_totales ?? 'No especificado' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Descripción</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $solicitud->publicacion->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            {{-- ACCIONES --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-end">
                    @if($solicitud->estado === 'pendiente')
                    <form action="{{ route('estudiante.solicitudes.cancelar', $solicitud->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg" onclick="return confirm('¿Estás seguro de cancelar esta solicitud? Esta acción no se puede deshacer.')">
                            Cancelar Solicitud
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 