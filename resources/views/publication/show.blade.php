@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- BREADCRUMBS --}}
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-300">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-300">
                        Ofertas laborales
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-[#5e0490] font-medium truncate max-w-xs">{{ $publication->titulo }}</span>
                </div>
            </div>
        </div>
        
        <div class="container mx-auto px-4 py-8">
            <!-- Botón de regreso con animación mejorada -->
            <div class="mb-6">
                <a href="{{ route('student.dashboard') }}" class="group inline-flex items-center text-sm font-medium text-[#5e0490] hover:text-[#4a0370] transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver a las ofertas
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 relative">
                <!-- Cinta de destacado si la oferta está destacada -->
                @if(isset($publication->destacado) && $publication->destacado)
                <div class="absolute -right-12 top-8 bg-yellow-500 text-white px-10 py-1 rotate-45 z-10 shadow-md font-semibold text-sm">
                    Destacado
                </div>
                @endif
                
                <!-- Cabecera con diseño mejorado -->
                <div class="bg-gradient-to-r from-[#5e0490] to-[#8a2be2] px-6 py-8 text-white relative overflow-hidden">
                    <!-- Patrón decorativo de fondo -->
                    <div class="absolute inset-0 opacity-10">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <circle cx="10" cy="10" r="2" fill="white" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#dots)" />
                        </svg>
                    </div>
                    
                    <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
                        <svg viewBox="0 0 24 24" fill="white">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"></path>
                        </svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2 leading-tight">{{ $publication->titulo }}</h1>
                                <div class="flex flex-wrap items-center gap-3 mt-3">
                                    @if(isset($publication->fecha_publicacion))
                                    <p class="text-white/80 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Publicado {{ \Carbon\Carbon::parse($publication->fecha_publicacion)->diffForHumans() }}
                                    </p>
                                    @endif
                                    
                                    @if(isset($publication->ubicacion))
                                    <p class="text-white/80 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $publication->ubicacion }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-white/20 text-white text-sm font-medium px-4 py-2 rounded-full backdrop-blur-sm shadow-inner">
                            {{ ucfirst($publication->categoria->nombre_categoria ?? 'General') }}
                        </span>
                                
                                <!-- Estado en la parte superior como badge -->
                                @if(isset($publication->estado))
                                    @if($publication->estado == 'cerrada')
                                    <span class="bg-red-500/80 text-white text-sm font-medium px-4 py-2 rounded-full backdrop-blur-sm shadow-inner">
                                        Cerrada
                                    </span>
                                    @else
                                    <span class="bg-green-500/80 text-white text-sm font-medium px-4 py-2 rounded-full backdrop-blur-sm shadow-inner">
                                        Abierta
                                    </span>
                                    @endif
                                @endif
                                
                                <!-- Modalidad en la parte superior como badge con icono -->
                                @if(isset($publication->modalidad))
                                <span class="bg-white/20 text-white text-sm font-medium px-4 py-2 rounded-full backdrop-blur-sm shadow-inner flex items-center">
                                    <svg class="w-4 h-4 mr-1 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ ucfirst($publication->modalidad) }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row relative">
                    {{-- IMAGEN DE LA EMPRESA --}}
                    <div class="w-full md:w-1/3 p-6 border-r border-gray-100 flex flex-col items-center justify-center bg-gradient-to-b from-gray-50 to-white">
                        <div class="w-48 h-48 rounded-lg overflow-hidden border-4 border-white shadow-lg mb-5 flex items-center justify-center group" style="aspect-ratio: 1/1;">
                            <img src="{{ asset('public/profile_images/' . ($publication->empresa->user->imagen ?? 'company-default.png')) }}" 
                                alt="{{ $publication->empresa->nombre }}"
                                class="max-w-[85%] max-h-[85%] object-contain group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <a href="{{ route('profile.show', $publication->empresa->user->id) }}" class="group">
                            <h3 class="text-xl font-bold text-[#5e0490] text-center group-hover:text-[#4a0370] transition-colors duration-300 flex items-center justify-center">
                                {{ $publication->empresa->user->nombre }}
                                <span class="inline-block ml-1 transition-transform duration-300 group-hover:translate-x-1">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </span>
                            </h3>
                        </a>
                        
                        <!-- Badge de verificación si es una empresa verificada -->
                        @if(isset($publication->empresa->verificado) && $publication->empresa->verificado)
                        <div class="mt-2 bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-medium inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Empresa verificada
                        </div>
                        @endif
                        
                        <!-- Información de contacto de la empresa con hover effects -->
                        <div class="mt-6 text-center w-full">
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-300">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Información de contacto</h4>
                                
                            @if(isset($publication->empresa->email))
                                <div class="flex items-center justify-center mb-3 px-3">
                                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 mr-2 rounded-full bg-purple-100 text-[#5e0490]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                    <span class="text-sm text-gray-600 overflow-hidden text-ellipsis">{{ $publication->empresa->email }}</span>
                                </div>
                            @endif
                                
                            @if(isset($publication->empresa->telefono))
                                <div class="flex items-center justify-center px-3">
                                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 mr-2 rounded-full bg-purple-100 text-[#5e0490]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                    <span class="text-sm text-gray-600">{{ $publication->empresa->telefono }}</span>
                        </div>
                        @endif
                        
                                @if(isset($publication->empresa->sitio_web))
                                <div class="flex items-center justify-center mt-3 px-3">
                                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 mr-2 rounded-full bg-purple-100 text-[#5e0490]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                    </span>
                                    <a href="{{ $publication->empresa->sitio_web }}" target="_blank" class="text-sm text-[#5e0490] hover:underline">Visitar sitio web</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                    <div class="w-full md:w-2/3 p-6">
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Detalles de la oferta
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Horario</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ ucfirst($publication->horario) }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Duración</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $publication->horas_totales }} horas</p>
                                    </div>
                                </div>

                                <!-- Añadimos el contador de solicitudes -->
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Solicitudes recibidas</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $publication->solicitudes_count }} {{ Str::plural('candidato', $publication->solicitudes_count) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Salario si está disponible -->
                                @if(isset($publication->salario))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Remuneración</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $publication->salario }} €</p>
                                    </div>
                                </div>
                                @elseif(isset($publication->fecha_publicacion))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Fecha de publicación</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ \Carbon\Carbon::parse($publication->fecha_publicacion)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($publication->subcategoria))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Subcategoría</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $publication->subcategoria->nombre_subcategoria }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Añado una nueva tarjeta para la ubicación si existe -->
                                @if(isset($publication->ubicacion))
                                <div class="flex items-center p-4 bg-purple-50 rounded-lg border border-purple-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                    <span class="flex items-center justify-center w-12 h-12 mr-4 bg-[#5e0490] rounded-full shadow-inner">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Ubicación</p>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $publication->ubicacion }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Requisitos si existen -->
                        @if(isset($publication->requisitos) && !empty($publication->requisitos))
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Requisitos
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 shadow-sm">
                                <ul class="space-y-2">
                                    @foreach(explode("\n", $publication->requisitos) as $requisito)
                                        @if(trim($requisito))
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-[#5e0490] mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-gray-700">{{ trim($requisito) }}</span>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Descripción
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 shadow-sm">
                                <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $publication->descripcion }}</p>
                            </div>
                        </div>
                        
                        <!-- Beneficios si existen -->
                        @if(isset($publication->beneficios) && !empty($publication->beneficios))
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                </svg>
                                Beneficios
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 shadow-sm">
                                <ul class="space-y-2">
                                    @foreach(explode("\n", $publication->beneficios) as $beneficio)
                                        @if(trim($beneficio))
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-gray-700">{{ trim($beneficio) }}</span>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Botones de acción incluido el botón de compartir con ID -->
                        <div class="mt-8 flex justify-end items-center space-x-4">
                            <!-- Modifico el botón de compartir para añadir un id y una clase para posicionar el popover -->
                            <div class="relative" id="shareContainer">
                                <button id="shareButton" onclick="toggleShareMenu()" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg shadow hover:bg-gray-300 transition-colors duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    Compartir oferta
                                </button>
                                
                                <!-- Menú de compartir colocado encima del botón -->
                                <div id="shareMenu" class="absolute z-50 bottom-full left-0 mb-2 bg-white rounded-lg shadow-xl border border-gray-200 hidden w-64 transform transition-all duration-200">
                                    <!-- Flecha inferior del popover -->
                                    <div class="absolute -bottom-2 left-7 w-4 h-4 bg-white transform rotate-45 border-r border-b border-gray-200"></div>
                                    
                                    <div class="p-3 relative rounded-lg bg-white">
                                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Compartir oferta</h4>
                                        <div class="grid grid-cols-4 gap-3">
                                            <a href="#" onclick="shareOnPlatform('facebook')" class="flex flex-col items-center text-center p-2 rounded hover:bg-gray-100 transition-colors duration-300">
                                                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mb-1">
                                                    <i class="fab fa-facebook-f"></i>
                                                </div>
                                                <span class="text-xs">Facebook</span>
                                            </a>
                                            <a href="#" onclick="shareOnPlatform('twitter')" class="flex flex-col items-center text-center p-2 rounded hover:bg-gray-100 transition-colors duration-300">
                                                <div class="w-8 h-8 rounded-full bg-blue-400 text-white flex items-center justify-center mb-1">
                                                    <i class="fab fa-twitter"></i>
                                                </div>
                                                <span class="text-xs">Twitter</span>
                                            </a>
                                            <a href="#" onclick="shareOnPlatform('linkedin')" class="flex flex-col items-center text-center p-2 rounded hover:bg-gray-100 transition-colors duration-300">
                                                <div class="w-8 h-8 rounded-full bg-blue-700 text-white flex items-center justify-center mb-1">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </div>
                                                <span class="text-xs">LinkedIn</span>
                                            </a>
                                            <a href="#" onclick="shareOnPlatform('whatsapp')" class="flex flex-col items-center text-center p-2 rounded hover:bg-gray-100 transition-colors duration-300">
                                                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center mb-1">
                                                    <i class="fab fa-whatsapp"></i>
                                                </div>
                                                <span class="text-xs">WhatsApp</span>
                                            </a>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <button onclick="copyLink()" class="w-full flex items-center justify-center text-sm text-gray-700 px-2 py-1 rounded hover:bg-gray-100 transition-colors duration-300">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Copiar enlace
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if(Auth::check())
                                @if($solicitudExistente)
                                    <button disabled class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-medium rounded-lg shadow cursor-not-allowed">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Solicitud enviada ({{ ucfirst($solicitudExistente->estado) }})
                                    </button>
                                @else
                                    <button onclick="openSolicitudModal()" class="inline-flex items-center px-6 py-3 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                        </svg>
                                        Solicitar esta oferta
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Inicia sesión para solicitar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción flotantes en móvil -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-3 flex justify-around items-center z-50 shadow-lg">
        @if(Auth::check())
            @if(!$solicitudExistente)
            <button onclick="openSolicitudModal()" class="inline-flex items-center justify-center px-4 py-2 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300 flex-1 mr-2">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                </svg>
                Solicitar
            </button>
            @endif
            
            <!-- Botón de favoritos -->
            <button 
                class="favorite-button px-3 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-300 flex items-center justify-center"
                data-publication-id="{{ $publication->id }}"
            >
                <i class="{{ isset($publication->favorito) && $publication->favorito ? 'fas text-yellow-500' : 'far text-gray-400' }} fa-star mr-1"></i>
                <span class="text-sm">{{ isset($publication->favorito) && $publication->favorito ? 'Guardada' : 'Guardar' }}</span>
            </button>
            
            <button onclick="sharePage()" class="px-3 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors duration-300 flex items-center justify-center ml-2">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                Compartir
            </button>
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#5e0490] text-white font-medium rounded-lg shadow hover:bg-[#4a0370] transition-colors duration-300 flex-1">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Iniciar sesión
            </a>
        @endif
    </div>
    
    <!-- Ofertas relacionadas -->
    @if(isset($related_publications) && count($related_publications) > 0)
    <div class="container mx-auto px-4 py-8 mb-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Ofertas similares
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related_publications as $related)
            <a href="{{ route('publication.show', $related->id) }}" class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="bg-gradient-to-r from-[#5e0490] to-[#8a2be2] px-4 py-3 text-white">
                    <h3 class="font-semibold truncate">{{ $related->titulo }}</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden mr-3 flex-shrink-0 border border-gray-200">
                            <img src="{{ asset('public/profile_images/' . ($related->empresa->user->imagen ?? 'company-default.png')) }}" 
                                alt="{{ $related->empresa->nombre }}"
                                class="w-full h-full object-contain">
                        </div>
                        <span class="text-sm text-gray-700 truncate">{{ $related->empresa->user->nombre }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-2 mb-3 text-xs text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ ucfirst($related->horario) }}
                        </div>
                        
                        @if(isset($related->ubicacion))
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="truncate">{{ $related->ubicacion }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ Str::limit($related->descripcion, 100) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="bg-purple-100 text-[#5e0490] text-xs px-2 py-1 rounded-full">
                            {{ ucfirst($related->categoria->nombre_categoria ?? 'General') }}
                        </span>
                        
                        <span class="text-xs text-gray-500">
                            {{ isset($related->fecha_publicacion) ? \Carbon\Carbon::parse($related->fecha_publicacion)->diffForHumans() : '' }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Modal de Solicitud -->
    <div id="solicitudModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-xl rounded-xl bg-white">
            <div class="absolute top-3 right-3">
                <button onclick="closeSolicitudModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                    </div>
                    <h3 class="ml-3 text-lg leading-6 font-medium text-gray-900">Solicitar Oferta</h3>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">Estás a punto de solicitar la oferta para "{{ $publication->titulo }}". Incluye un mensaje para destacar entre los demás candidatos.</p>
                
                <form id="solicitudForm" action="{{ route('solicitudes.store', $publication->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">Carta de motivación (opcional)</label>
                        <textarea
                            id="mensaje"
                            name="mensaje"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5e0490] focus:ring focus:ring-[#5e0490] focus:ring-opacity-50 transition-shadow duration-300"
                            placeholder="Explica por qué eres el candidato ideal para esta oferta..."></textarea>
                        <p class="mt-1 text-xs text-gray-500">Un buen mensaje aumenta tus posibilidades de ser seleccionado.</p>
                    </div>
                    
                    <!-- Opción de adjuntar CV si está disponible -->
                    <div class="mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="adjuntar_cv" name="adjuntar_cv" class="w-4 h-4 text-[#5e0490] border-gray-300 rounded focus:ring-[#5e0490]">
                            <label for="adjuntar_cv" class="ml-2 block text-sm text-gray-700">Adjuntar mi CV actual</label>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Tu CV registrado será enviado a la empresa.</p>
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button
                            type="button"
                            onclick="closeSolicitudModal()"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-colors duration-300">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-[#5e0490] border border-transparent rounded-md hover:bg-[#4a0370] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-colors duration-300">
                            Enviar solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sweet Alert CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
        /* Barra de progreso de lectura */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(to right, #5e0490, #8a2be2);
            width: 0%;
            z-index: 1000;
            transition: width 0.2s ease-out;
        }
        
        /* Animación para el botón de favoritos */
        .favorite-button i.fas {
            animation: pulse 1s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        /* Estilos para la imagen de la empresa */
        .w-48.h-48.rounded-lg {
            background-color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .w-48.h-48.rounded-lg img {
            transition: transform 0.3s ease;
        }
        
        .w-48.h-48.rounded-lg:hover img {
            transform: scale(1.05);
        }
        
        /* Efecto hover para las cards */
        .hover\:shadow-md:hover {
            box-shadow: 0 4px 10px rgba(94, 4, 144, 0.1);
        }
        
        /* Mejorar el modal en móvil */
        @media (max-width: 640px) {
            .relative.top-20 {
                top: 10%;
                margin-bottom: 5rem;
            }
            
            .fixed.bottom-0 {
                padding-bottom: env(safe-area-inset-bottom);
            }
            
            .max-w-xs {
                max-width: 150px;
            }
        }
        
        /* Animaciones de entrada para elementos principales */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .bg-white.rounded-xl {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Efecto de selección para el formulario */
        textarea:focus, select:focus, input:focus {
            border-color: #5e0490;
            box-shadow: 0 0 0 2px rgba(94, 4, 144, 0.2);
        }
        
        /* Esquina de cinta para ofertas destacadas */
        .absolute.-right-12.top-8 {
            transform: rotate(45deg);
            width: 150px;
            text-align: center;
        }
        
        /* Animación para hover en cards de ofertas relacionadas */
        .grid.grid-cols-1 a {
            transition: all 0.3s ease;
        }
        
        .grid.grid-cols-1 a:hover {
            transform: translateY(-5px);
        }
        
        /* Stagger animation para cards */
        .grid.grid-cols-1 a {
            opacity: 0;
            animation: fadeUp 0.5s ease forwards;
        }
        
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .grid.grid-cols-1 a:nth-child(1) { animation-delay: 0.1s; }
        .grid.grid-cols-1 a:nth-child(2) { animation-delay: 0.2s; }
        .grid.grid-cols-1 a:nth-child(3) { animation-delay: 0.3s; }
        .grid.grid-cols-1 a:nth-child(4) { animation-delay: 0.4s; }
        .grid.grid-cols-1 a:nth-child(5) { animation-delay: 0.5s; }
        .grid.grid-cols-1 a:nth-child(6) { animation-delay: 0.6s; }
        
        /* Efecto de shimmer para las badges */
        .bg-white\/20 {
            position: relative;
            overflow: hidden;
        }
        
        .bg-white\/20::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
            pointer-events: none;
        }
        
        @keyframes shimmer {
            to {
                left: 150%;
            }
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #5e0490;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #4a0370;
        }
        
        /* Sistema de valoración de estrellas */
        .rating-stars {
            display: inline-flex;
            font-size: 0; /* Eliminar espacio entre elementos inline */
        }
        
        .rating-stars i {
            color: #e2e8f0;
            font-size: 16px;
            padding: 2px;
        }
        
        .rating-stars i.filled {
            color: #fbbf24;
        }
        
        /* Botón flotante para volver arriba */
        .back-to-top {
            position: fixed;
            bottom: 70px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #5e0490;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 40;
        }
        
        .back-to-top.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    
    <script>
        // Progress bar de lectura
        document.addEventListener('DOMContentLoaded', function() {
            // Añadir la barra de progreso al DOM
            const progressBar = document.createElement('div');
            progressBar.className = 'progress-bar';
            document.body.appendChild(progressBar);
            
            // Actualizar el progreso al hacer scroll
            window.addEventListener('scroll', function() {
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight - windowHeight;
                const scrollTop = window.scrollY || window.pageYOffset;
                const progress = (scrollTop / documentHeight) * 100;
                progressBar.style.width = progress + '%';
                
                // Mostrar/ocultar el botón de volver arriba
                const backToTopButton = document.querySelector('.back-to-top');
                if (backToTopButton) {
                    if (scrollTop > 300) {
                        backToTopButton.classList.add('visible');
                    } else {
                        backToTopButton.classList.remove('visible');
                    }
                }
            });
            
            // Crear botón para volver arriba
            const backToTopButton = document.createElement('div');
            backToTopButton.className = 'back-to-top shadow-lg';
            backToTopButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>';
            document.body.appendChild(backToTopButton);
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Script para manejar el botón de favoritos
            const favoriteButton = document.querySelector('.favorite-button');
            if (favoriteButton) {
                favoriteButton.addEventListener('click', function() {
                    const publicationId = this.getAttribute('data-publication-id');
                    const icon = this.querySelector('i');
                    const text = this.querySelector('span');
                    
                    fetch(`/toggle-favorite/${publicationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            icon.classList.remove('far', 'text-gray-400');
                            icon.classList.add('fas', 'text-yellow-500');
                            text.textContent = 'Quitar de favoritos';
                            
                            // Mostrar notificación
                            Swal.fire({
                                title: '¡Guardada!',
                                text: 'Oferta añadida a favoritos',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                background: '#fff',
                                iconColor: '#5e0490'
                            });
                        } else {
                            icon.classList.remove('fas', 'text-yellow-500');
                            icon.classList.add('far', 'text-gray-400');
                            text.textContent = 'Añadir a favoritos';
                            
                            // Mostrar notificación
                            Swal.fire({
                                title: 'Eliminada',
                                text: 'Oferta eliminada de favoritos',
                                icon: 'info',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                background: '#fff',
                                iconColor: '#5e0490'
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            }
            
            // Inicializar cualquier instancia del sistema de valoración
            const ratings = document.querySelectorAll('.rating-container');
            ratings.forEach(function(container) {
                const stars = container.querySelectorAll('.rating-stars i');
                const ratingValue = parseFloat(container.getAttribute('data-rating') || 0);
                
                // Llenar estrellas según la valoración
                stars.forEach(function(star, index) {
                    if (index < Math.floor(ratingValue)) {
                        star.classList.add('filled');
                    } else if (index === Math.floor(ratingValue) && ratingValue % 1 !== 0) {
                        star.classList.add('filled', 'half');
                    }
                });
            });
        });

        // Funciones para el modal de solicitud
        function openSolicitudModal() {
            document.getElementById('solicitudModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSolicitudModal() {
            document.getElementById('solicitudModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Nueva función para manejar el menú de compartir
        function toggleShareMenu() {
            const shareMenu = document.getElementById('shareMenu');
            if (shareMenu.classList.contains('hidden')) {
                // Mostrar con animación
                shareMenu.classList.remove('hidden');
                setTimeout(() => {
                    shareMenu.style.opacity = '1';
                    shareMenu.style.transform = 'translateY(0)';
                }, 10);
            } else {
                // Ocultar con animación
                shareMenu.style.opacity = '0';
                shareMenu.style.transform = 'translateY(10px)'; // Cambiamos para que la animación sea hacia abajo cuando se oculta
                setTimeout(() => {
                    shareMenu.classList.add('hidden');
                }, 200);
            }
        }
        
        // Compatibilidad con la función anterior para móvil
        function sharePage() {
            toggleShareMenu();
        }
        
        function shareOnPlatform(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent("{{ $publication->titulo }} - Oferta laboral");
            
            let shareUrl = '';
            
            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://api.whatsapp.com/send?text=${title} ${url}`;
                    break;
            }
            
            window.open(shareUrl, '_blank');
            toggleShareMenu();
        }
        
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                toggleShareMenu();
                Swal.fire({
                    title: '¡Enlace copiado!',
                    text: 'El enlace se ha copiado al portapapeles',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#fff',
                    iconColor: '#5e0490'
                });
            });
        }

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', function(e) {
            const solicitudModal = document.getElementById('solicitudModal');
            const shareMenu = document.getElementById('shareMenu');
            const shareButton = document.getElementById('shareButton');
            const shareContainer = document.getElementById('shareContainer');
            
            if (e.target === solicitudModal) {
                closeSolicitudModal();
            }
            
            if (shareMenu && !shareMenu.classList.contains('hidden') && 
                !shareContainer.contains(e.target)) {
                toggleShareMenu();
            }
        });

        // Manejar envío del formulario con AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const solicitudForm = document.getElementById('solicitudForm');
            if (solicitudForm) {
                solicitudForm.addEventListener('submit', function(e) {
            e.preventDefault();
                    
                    // Mostrar indicador de carga
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando...
                    `;
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                        // Restaurar botón
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        
                if (data.status === 'success') {
                    closeSolicitudModal();
                    
                    // Actualizar el botón de solicitud
                    const solicitudButton = document.querySelector('[onclick="openSolicitudModal()"]').parentElement;
                    solicitudButton.innerHTML = `
                        <button disabled class="inline-flex items-center px-6 py-3 bg-gray-400 text-white font-medium rounded-lg shadow cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Solicitud enviada (Pendiente)
                        </button>
                    `;
                    
                            // Actualizar los botones móviles si existen
                            const mobileSolicitudButton = document.querySelector('.md\\:hidden [onclick="openSolicitudModal()"]');
                            if (mobileSolicitudButton) {
                                mobileSolicitudButton.remove();
                            }
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Solicitud enviada!',
                                html: 'Tu solicitud ha sido enviada correctamente<br><small>La empresa se pondrá en contacto contigo pronto</small>',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                } else if (data.status === 'error') {
                    Swal.fire({
                        title: '¡Error!',
                        text: data.message || 'Ha ocurrido un error al enviar la solicitud',
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#5e0490',
                        background: '#fff',
                        customClass: {
                            confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                        }
                    });
                }
            })
                    .catch(error => {
                        // Restaurar botón
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        
                        console.error('Error:', error);
                        Swal.fire({
                            title: '¡Error!',
                            text: 'Ha ocurrido un error al procesar tu solicitud',
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#5e0490',
                            background: '#fff',
                            customClass: {
                                confirmButton: 'px-4 py-2 bg-[#5e0490] text-white rounded-lg hover:bg-[#4a0370] transition-colors duration-300'
                            }
                        });
                    });
                });
            }
        });
    </script>
@endsection