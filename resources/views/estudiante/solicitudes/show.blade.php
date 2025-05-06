@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- BREADCRUMBS --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('estudiante.solicitudes.index') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200">
                    Mis Solicitudes
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">Detalle de Solicitud</span>
            </div>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <svg class="w-8 h-8 mr-3 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Detalle de Solicitud
            </h1>
            <a href="{{ route('estudiante.solicitudes.index') }}" class="bg-white hover:bg-gray-100 text-gray-700 py-2.5 px-5 rounded-xl flex items-center shadow-sm transition-all hover:shadow-md transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a la lista
            </a>
        </div>
        
        {{-- TARJETA DE DETALLES --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- CABECERA --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-[#5e0490]/10 to-purple-100 opacity-60"></div>
                <div class="relative p-8 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 relative">
                                @if($solicitud->publicacion->empresa->user->imagen ?? null)
                                    <img class="h-20 w-20 rounded-xl object-cover shadow-md border-2 border-white" src="{{ asset('public/profile_images/' . $solicitud->publicacion->empresa->user->imagen) }}" alt="Logo empresa">
                                @else
                                    <div class="h-20 w-20 rounded-xl bg-purple-100 flex items-center justify-center text-[#5e0490] shadow-md">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-1 shadow-md">
                                    <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}</h2>
                                <p class="text-lg text-gray-700 font-medium">{{ $solicitud->publicacion->titulo ?? 'Publicación' }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Solicitud enviada el {{ $solicitud->created_at->format('d/m/Y') }} a las {{ $solicitud->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            @php
                                $badgeClass = '';
                                $badgeIcon = '';
                                $badgeDot = '';
                                
                                switch($solicitud->estado) {
                                    case 'pendiente':
                                        $badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-300';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-yellow-400 ring-2 ring-white animate-ping"></span>';
                                        break;
                                    case 'aceptada':
                                        $badgeClass = 'bg-green-100 text-green-800 border-green-300';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-500 ring-2 ring-white"></span>';
                                        break;
                                    case 'rechazada':
                                        $badgeClass = 'bg-red-100 text-red-800 border-red-300';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>';
                                        break;
                                }
                            @endphp
                            <span class="relative inline-flex items-center px-4 py-2 rounded-xl border {{ $badgeClass }} text-sm font-medium shadow-sm">
                                {!! $badgeIcon !!}
                                {{ ucfirst($solicitud->estado) }}
                                {!! $badgeDot !!}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- CONTENIDO --}}
            <div class="p-8 space-y-8">
                {{-- DETALLES DE LA SOLICITUD --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Detalles de la Solicitud
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <p class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-2">Estado</p>
                            <div class="flex items-center">
                                @if($solicitud->estado === 'pendiente')
                                    <div class="mr-2 h-3 w-3 rounded-full bg-yellow-400 animate-pulse"></div>
                                @elseif($solicitud->estado === 'aceptada')
                                    <div class="mr-2 h-3 w-3 rounded-full bg-green-500"></div>
                                @else
                                    <div class="mr-2 h-3 w-3 rounded-full bg-red-500"></div>
                                @endif
                                <p class="text-base text-gray-900 font-medium">{{ ucfirst($solicitud->estado) }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <p class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-2">Fecha de la solicitud</p>
                            <p class="text-base text-gray-900 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <p class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-2">Publicación</p>
                            <p class="text-base text-gray-900 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                {{ $solicitud->publicacion->titulo ?? 'Sin título' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <p class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-2">Empresa</p>
                            <p class="text-base text-gray-900 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                {{-- MENSAJE DE LA SOLICITUD --}}
                @if($solicitud->mensaje)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Mensaje de tu Solicitud
                    </h3>
                    <div class="bg-[#5e0490]/5 p-6 rounded-xl shadow-sm border-l-4 border-[#5e0490] relative">
                        <div class="absolute -top-3 -left-3 bg-[#5e0490] rounded-full p-2 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <p class="text-gray-700 italic">{{ $solicitud->mensaje }}</p>
                    </div>
                </div>
                @endif
                
                {{-- RESPUESTA DE LA EMPRESA --}}
                @if($solicitud->respuesta_empresa)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                        Respuesta de la Empresa
                    </h3>
                    <div class="bg-yellow-50 p-6 rounded-xl shadow-sm border-l-4 border-yellow-400 relative">
                        <div class="absolute -top-3 -left-3 bg-yellow-500 rounded-full p-2 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <p class="text-gray-700">{{ $solicitud->respuesta_empresa }}</p>
                    </div>
                </div>
                @endif
                
                {{-- DETALLES DE LA PUBLICACIÓN --}}
                @if($solicitud->publicacion)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Detalles de la Publicación
                    </h3>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="flex flex-col">
                                <span class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-1">Horario</span>
                                <span class="text-gray-700 text-base flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ ucfirst($solicitud->publicacion->horario ?? 'No especificado') }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-1">Horas totales</span>
                                <span class="text-gray-700 text-base flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $solicitud->publicacion->horas_totales ?? 'No especificado' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-1">Descripción</span>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100">{{ $solicitud->publicacion->descripcion ?? 'Sin descripción' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            {{-- ACCIONES --}}
            @if($solicitud->estado === 'pendiente')
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-end">
                    <form id="cancelar-form" action="{{ route('estudiante.solicitudes.cancelar', $solicitud->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="button" id="btn-cancelar" class="group relative inline-flex items-center px-6 py-3 overflow-hidden text-lg font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                            <span class="absolute left-0 block w-full h-0 transition-all bg-red-800 opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-300 ease"></span>
                            <span class="absolute right-0 flex items-center justify-start w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </span>
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Cancelar Solicitud
                            </span>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- SweetAlert2 para alertas modales --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar botón de cancelar solicitud
        const btnCancelar = document.getElementById('btn-cancelar');
        if (btnCancelar) {
            btnCancelar.addEventListener('click', function() {
                Swal.fire({
                    title: '<span class="text-red-600 font-bold">¿Cancelar solicitud?</span>',
                    html: `
                        <div class="text-center">
                            <div class="mx-auto w-24 h-24 mb-4 relative">
                                <svg class="w-full h-full text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <div class="absolute inset-0 bg-red-100 rounded-full -z-10 animate__animated animate__pulse animate__infinite"></div>
                            </div>
                            <p class="text-gray-700 mb-2 font-medium">Esta acción <span class="text-red-600">no se puede deshacer</span>.</p>
                            <div class="mt-4 bg-yellow-50 p-3 rounded-lg text-sm border-l-4 border-yellow-400">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-600">La solicitud será marcada como <span class="font-semibold text-red-600">rechazada</span> y no podrá ser reactivada después.</p>
                                </div>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: '<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>Sí, cancelar solicitud</div>',
                    cancelButtonText: '<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>No, mantener solicitud</div>',
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#5e0490',
                    background: 'rgba(255, 255, 255, 0.98)',
                    backdrop: `
                        rgba(0,0,0,0.6)
                        url("/img/loading-bg.png")
                        left top
                        no-repeat
                    `,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    },
                    customClass: {
                        title: 'text-xl font-bold mb-4',
                        htmlContainer: 'py-4',
                        confirmButton: 'rounded-xl px-6 py-3 font-medium text-white shadow-lg hover:shadow-red-500/30 transition-all duration-200',
                        cancelButton: 'rounded-xl px-6 py-3 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200',
                        icon: 'border-red-500 text-red-500',
                        container: 'z-[1060]',
                        actions: 'gap-4'
                    },
                    buttonsStyling: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    focusDeny: false,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar indicador de carga con animación y diseño personalizado
                        Swal.fire({
                            title: '<span class="text-[#5e0490] font-bold">Procesando...</span>',
                            html: `
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 relative mb-4">
                                        <div class="absolute inset-0 rounded-full border-4 border-gray-200"></div>
                                        <div class="absolute inset-0 rounded-full border-4 border-t-[#5e0490] animate-spin"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-[#5e0490]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-[#5e0490] font-medium">Cancelando tu solicitud</p>
                                    <p class="text-sm text-gray-500 mt-2">Esto solo tomará un momento...</p>
                                    <div class="w-48 h-1.5 bg-gray-200 rounded-full mt-4 overflow-hidden">
                                        <div class="h-full bg-[#5e0490] rounded-full animate-pulse"></div>
                                    </div>
                                </div>
                            `,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                                // Enviar el formulario después de mostrar el loader
                                setTimeout(() => {
                                    document.getElementById('cancelar-form').submit();
                                }, 800);
                            },
                            background: 'rgba(255, 255, 255, 0.98)',
                            backdrop: `rgba(94, 4, 144, 0.15)`,
                            customClass: {
                                title: 'text-xl font-bold mb-4',
                                htmlContainer: 'py-4'
                            }
                        });
                    }
                });
            });
        }
    });
</script>
@endsection 