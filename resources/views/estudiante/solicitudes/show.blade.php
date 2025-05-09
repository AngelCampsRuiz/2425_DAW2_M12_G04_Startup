@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- BREADCRUMBS --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200 flex items-center group">
                    <div class="bg-gray-100 group-hover:bg-purple-100 p-1.5 rounded-lg mr-2 transition-all duration-200">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#5e0490] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
                <a href="{{ route('estudiante.solicitudes.index') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200 flex items-center group">
                    <div class="bg-gray-100 group-hover:bg-purple-100 p-1.5 rounded-lg mr-2 transition-all duration-200">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#5e0490] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    Mis Solicitudes
                </a>
                <span class="mx-2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
                <span class="text-[#5e0490] font-medium flex items-center">
                    <div class="bg-purple-100 p-1.5 rounded-lg mr-2">
                        <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    Detalle de Solicitud
                </span>
            </div>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <div class="bg-purple-100 p-3 rounded-xl mr-4 shadow-sm">
                    <svg class="w-8 h-8 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="relative">
                    Detalle de Solicitud
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#5e0490] to-purple-300 rounded-full transform translate-y-1"></span>
                </span>
            </h1>
            <a href="{{ route('estudiante.solicitudes.index') }}" class="bg-white hover:bg-gray-100 text-gray-700 py-3 px-6 rounded-xl flex items-center shadow-sm transition-all hover:shadow-md transform hover:-translate-y-0.5 border border-gray-200 group">
                <svg class="w-5 h-5 mr-2 text-gray-600 group-hover:text-[#5e0490] transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium group-hover:text-[#5e0490] transition-colors duration-300">Volver a la lista</span>
            </a>
        </div>
        
        {{-- TARJETA DE DETALLES --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all duration-300">
            {{-- CABECERA --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-[#5e0490]/20 to-purple-50 opacity-80"></div>
                <div class="relative p-8 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 relative group">
                                @if($solicitud->publicacion->empresa->user->imagen ?? null)
                                    <div class="h-20 w-20 rounded-xl overflow-hidden shadow-md border-2 border-white relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-[#5e0490]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                                        <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ asset('public/profile_images/' . $solicitud->publicacion->empresa->user->imagen) }}" alt="Logo empresa">
                                    </div>
                                @else
                                    <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center text-[#5e0490] shadow-md border-2 border-white group-hover:from-purple-200 group-hover:to-purple-100 transition-all duration-300">
                                        <svg class="w-12 h-12 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-md">
                                    <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h2 class="text-2xl font-bold text-gray-900 group-hover:text-[#5e0490] transition-colors duration-300">{{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}</h2>
                                <p class="text-lg text-gray-700 font-medium">{{ $solicitud->publicacion->titulo ?? 'Publicación' }}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <div class="bg-gray-100 p-1.5 rounded-lg mr-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    Solicitud enviada el {{ $solicitud->created_at->format('d/m/Y') }} a las {{ $solicitud->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            @php
                                $badgeClass = '';
                                $badgeIcon = '';
                                $badgeDot = '';
                                $badgeBg = '';
                                
                                switch($solicitud->estado) {
                                    case 'pendiente':
                                        $badgeClass = 'border-yellow-300 group-hover:border-yellow-400';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-yellow-400 ring-2 ring-white animate-ping"></span>';
                                        $badgeBg = 'bg-gradient-to-r from-yellow-50 to-yellow-100';
                                        break;
                                    case 'aceptada':
                                        $badgeClass = 'border-green-300 group-hover:border-green-400';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-500 ring-2 ring-white"></span>';
                                        $badgeBg = 'bg-gradient-to-r from-green-50 to-green-100';
                                        break;
                                    case 'rechazada':
                                        $badgeClass = 'border-red-300 group-hover:border-red-400';
                                        $badgeIcon = '<svg class="w-5 h-5 mr-1.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                                        $badgeDot = '<span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>';
                                        $badgeBg = 'bg-gradient-to-r from-red-50 to-red-100';
                                        break;
                                }
                            @endphp
                            <span class="relative inline-flex items-center px-5 py-2.5 rounded-xl border {{ $badgeClass }} text-sm font-medium shadow-sm {{ $badgeBg }} group transition-all duration-300 hover:shadow-md">
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
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="relative">
                            Detalles de la Solicitud
                            <span class="absolute bottom-0 left-0 w-2/3 h-0.5 bg-gradient-to-r from-[#5e0490]/70 to-transparent rounded-full transform translate-y-1"></span>
                        </span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-purple-200 group">
                            <div class="flex items-center mb-1">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-xs uppercase tracking-wider font-medium text-gray-500 group-hover:text-[#5e0490] transition-colors duration-300">Estado</p>
                            </div>
                            <div class="flex items-center pl-10">
                                @if($solicitud->estado === 'pendiente')
                                    <div class="mr-2 h-3 w-3 rounded-full bg-yellow-400 animate-pulse"></div>
                                    <p class="text-base text-gray-900 font-medium">{{ ucfirst($solicitud->estado) }}</p>
                                @elseif($solicitud->estado === 'aceptada')
                                    <div class="mr-2 h-3 w-3 rounded-full bg-green-500"></div>
                                    <p class="text-base text-green-700 font-medium">{{ ucfirst($solicitud->estado) }}</p>
                                @else
                                    <div class="mr-2 h-3 w-3 rounded-full bg-red-500"></div>
                                    <p class="text-base text-red-700 font-medium">{{ ucfirst($solicitud->estado) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-purple-200 group">
                            <div class="flex items-center mb-1">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-xs uppercase tracking-wider font-medium text-gray-500 group-hover:text-[#5e0490] transition-colors duration-300">Fecha de la solicitud</p>
                            </div>
                            <p class="text-base text-gray-900 font-medium pl-10">
                                {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-purple-200 group">
                            <div class="flex items-center mb-1">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                                <p class="text-xs uppercase tracking-wider font-medium text-gray-500 group-hover:text-[#5e0490] transition-colors duration-300">Publicación</p>
                            </div>
                            <p class="text-base text-gray-900 font-medium pl-10 truncate">
                                {{ $solicitud->publicacion->titulo ?? 'Sin título' }}
                            </p>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-purple-200 group">
                            <div class="flex items-center mb-1">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <p class="text-xs uppercase tracking-wider font-medium text-gray-500 group-hover:text-[#5e0490] transition-colors duration-300">Empresa</p>
                            </div>
                            <p class="text-base text-gray-900 font-medium pl-10 truncate">
                                {{ $solicitud->publicacion->empresa->user->nombre ?? 'Empresa' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                {{-- MENSAJE DE LA SOLICITUD --}}
                @if($solicitud->mensaje)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <span class="relative">
                            Mensaje de tu Solicitud
                            <span class="absolute bottom-0 left-0 w-2/3 h-0.5 bg-gradient-to-r from-[#5e0490]/70 to-transparent rounded-full transform translate-y-1"></span>
                        </span>
                    </h3>
                    <div class="bg-gradient-to-r from-[#5e0490]/5 to-purple-50 p-7 rounded-xl shadow-sm border-l-4 border-[#5e0490] relative hover:shadow-md transition-all duration-300">
                        <div class="absolute -top-3 -left-3 bg-[#5e0490] rounded-full p-2.5 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <p class="text-gray-700 italic leading-relaxed">{{ $solicitud->mensaje }}</p>
                    </div>
                </div>
                @endif
                
                {{-- RESPUESTA DE LA EMPRESA --}}
                @if($solicitud->respuesta_empresa)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </div>
                        <span class="relative">
                            Respuesta de la Empresa
                            <span class="absolute bottom-0 left-0 w-2/3 h-0.5 bg-gradient-to-r from-[#5e0490]/70 to-transparent rounded-full transform translate-y-1"></span>
                        </span>
                    </h3>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-7 rounded-xl shadow-sm border-l-4 border-yellow-400 relative hover:shadow-md transition-all duration-300">
                        <div class="absolute -top-3 -left-3 bg-yellow-500 rounded-full p-2.5 shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed">{{ $solicitud->respuesta_empresa }}</p>
                    </div>
                </div>
                @endif
                
                {{-- DETALLES DE LA PUBLICACIÓN --}}
                @if($solicitud->publicacion)
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="relative">
                            Detalles de la Publicación
                            <span class="absolute bottom-0 left-0 w-2/3 h-0.5 bg-gradient-to-r from-[#5e0490]/70 to-transparent rounded-full transform translate-y-1"></span>
                        </span>
                    </h3>
                    <div class="bg-white p-7 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 hover:border-purple-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-purple-200 transition-all duration-300 flex items-center group">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs uppercase tracking-wider font-medium text-gray-500 block mb-1 group-hover:text-[#5e0490] transition-colors duration-300">Horario</span>
                                    <span class="text-gray-700 text-base font-medium">
                                        {{ ucfirst($solicitud->publicacion->horario ?? 'No especificado') }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 hover:border-purple-200 transition-all duration-300 flex items-center group">
                                <div class="rounded-full bg-purple-100 p-2 mr-3 group-hover:bg-purple-200 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs uppercase tracking-wider font-medium text-gray-500 block mb-1 group-hover:text-[#5e0490] transition-colors duration-300">Horas totales</span>
                                    <span class="text-gray-700 text-base font-medium">
                                        {{ $solicitud->publicacion->horas_totales ?? 'No especificado' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <span class="text-xs uppercase tracking-wider font-medium text-gray-500 mb-3 block flex items-center">
                                <div class="rounded-full bg-purple-100 p-2 mr-2">
                                    <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                    </svg>
                                </div>
                                Descripción
                            </span>
                            <div class="bg-gradient-to-r from-gray-50 to-white p-5 rounded-xl border border-gray-100">
                                <p class="text-gray-700 leading-relaxed">{{ $solicitud->publicacion->descripcion ?? 'Sin descripción' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            {{-- ACCIONES --}}
            @if($solicitud->estado === 'pendiente')
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-t border-gray-200">
                <div class="flex justify-end">
                    <form id="cancelar-form" action="{{ route('estudiante.solicitudes.cancelar', $solicitud->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="button" id="btn-cancelar" class="group relative inline-flex items-center px-8 py-3 overflow-hidden text-lg font-medium text-white bg-gradient-to-r from-red-600 to-red-500 rounded-xl hover:from-red-700 hover:to-red-600 transition-all duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
                                <div class="absolute inset-0 bg-red-50 rounded-full animate-pulse"></div>
                                <svg class="w-full h-full text-red-500 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <p class="text-gray-700 mb-2 font-medium">Esta acción <span class="text-red-600">no se puede deshacer</span>.</p>
                            <div class="mt-4 bg-yellow-50 p-4 rounded-lg text-sm border-l-4 border-yellow-400">
                                <div class="flex items-start">
                                    <div class="rounded-full bg-yellow-100 p-2 mr-2 flex-shrink-0">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
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
                        rgba(0,0,0,0.7)
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
                        htmlContainer: 'py-4 text-left',
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
                                    <div class="w-24 h-24 relative mb-6">
                                        <div class="absolute inset-0 rounded-full border-4 border-t-[#5e0490] animate-spin"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-[#5e0490]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-[#5e0490] font-medium">Cancelando tu solicitud</p>
                                    <p class="text-sm text-gray-500 mt-2">Esto solo tomará un momento...</p>
                                    <div class="w-64 h-2 bg-gray-200 rounded-full mt-6 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-[#5e0490] to-purple-400 rounded-full animate-pulse"></div>
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

<style>
/* Animaciones y efectos visuales */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
    100% { transform: translateY(0px); }
}

@keyframes pulse-border {
    0% { box-shadow: 0 0 0 0 rgba(94, 4, 144, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(94, 4, 144, 0); }
    100% { box-shadow: 0 0 0 0 rgba(94, 4, 144, 0); }
}

/* Efectos de hover mejorados */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(94, 4, 144, 0.1);
}

/* Mejora de tarjetas con efecto de brillo */
.card-shine {
    position: relative;
    overflow: hidden;
}

.card-shine::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        to right,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.3) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    transform: skewX(-25deg);
    transition: all 0.75s;
}

.card-shine:hover::before {
    left: 125%;
}

/* Efecto de borde brillante */
.glow-border {
    position: relative;
}

.glow-border:hover {
    animation: pulse-border 2s infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c5b5d6;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #5e0490;
}

/* Diseño sensible a modo oscuro */
@media (prefers-color-scheme: dark) {
    .dark-mode-ready {
        --bg-color: #1a1a1a;
        --text-color: #f5f5f5;
    }
}
</style>
@endsection 