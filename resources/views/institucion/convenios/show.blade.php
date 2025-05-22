@extends('layouts.institucion')

@section('title', 'Detalles del Convenio')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-purple-50">
    <!-- Notificaciones -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Cabecera -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Detalles del Convenio
            </h1>
            <p class="text-gray-600 mt-1">Información completa del convenio de prácticas</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            <a href="{{ route('institucion.convenios.download', $convenio) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Descargar PDF
            </a>
            
            @if(!$convenio->firmado_institucion)
                <form action="{{ route('institucion.convenios.firmar', $convenio) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 flex items-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Firmar Convenio
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Estado del Convenio - Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Estado del Convenio
        </h2>
        
        <div class="flex flex-wrap gap-3">
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                @if($convenio->estado === 'activo') bg-green-100 text-green-800 border border-green-200
                @elseif($convenio->estado === 'pendiente') bg-yellow-100 text-yellow-800 border border-yellow-200
                @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Estado: {{ ucfirst($convenio->estado) }}
            </div>
            
            @if($convenio->firmado_institucion)
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Firmado por la Institución
                </div>
            @else
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Pendiente de firma
                </div>
            @endif
        </div>
    </div>

    <!-- Grid de información -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Información del Estudiante -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Estudiante
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    @if($convenio->estudiante->imagen)
                        <img class="h-14 w-14 rounded-full mr-4 border-2 border-purple-100 shadow-md" src="{{ asset('storage/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}">
                    @else
                        <div class="h-14 w-14 rounded-full mr-4 bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center text-white font-bold text-lg border-2 border-purple-100 shadow-md">
                            {{ strtoupper(substr($convenio->estudiante->nombre, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $convenio->estudiante->nombre }}</h3>
                        <p class="text-sm text-gray-600">{{ $convenio->estudiante->email }}</p>
                    </div>
                </div>
                
                <div class="mt-4 space-y-2">
                    @if(isset($convenio->estudiante->telefono))
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $convenio->estudiante->telefono }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información de la Empresa -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-teal-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Empresa
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Nombre de la Empresa</h3>
                        <p class="text-gray-900 font-medium">{{ $convenio->oferta->empresa->nombre }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Oferta</h3>
                        <p class="text-gray-900 font-medium">{{ $convenio->oferta->titulo }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Tutor de Empresa</h3>
                        <p class="text-gray-900 font-medium">{{ $convenio->tutor_empresa }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de la Firma (si está firmado) -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Información de Firma
                </h2>
            </div>
            <div class="p-6">
                @if($convenio->firmado_institucion)
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Firmado por</h3>
                            <p class="text-gray-900 font-medium">{{ $convenio->firmadoPorInstitucion->nombre }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Fecha de Firma</h3>
                            <p class="text-gray-900 font-medium">{{ $convenio->fecha_firma_institucion ? $convenio->fecha_firma_institucion->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-3 flex items-start mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-green-700">El convenio ha sido firmado y está activo para el periodo de prácticas establecido.</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center h-full py-8">
                        <div class="text-center">
                            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Pendiente de Firma</h3>
                            <p class="text-sm text-gray-600">Este convenio aún no ha sido firmado por la institución</p>
                            
                            <form action="{{ route('institucion.convenios.firmar', $convenio) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Firmar Ahora
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detalles del Convenio y Fechas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Fechas del Convenio -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Fechas del Convenio
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-amber-50 rounded-lg p-4">
                        <h3 class="text-xs text-amber-600 font-medium uppercase tracking-wider mb-1">Fecha de Inicio</h3>
                        <p class="text-xl text-gray-800 font-semibold">{{ $convenio->fecha_inicio->format('d/m/Y') }}</p>
                    </div>
                    
                    <div class="bg-amber-50 rounded-lg p-4">
                        <h3 class="text-xs text-amber-600 font-medium uppercase tracking-wider mb-1">Fecha de Fin</h3>
                        <p class="text-xl text-gray-800 font-semibold">{{ $convenio->fecha_fin->format('d/m/Y') }}</p>
                    </div>
                    
                    <div class="bg-amber-50 rounded-lg p-4">
                        <h3 class="text-xs text-amber-600 font-medium uppercase tracking-wider mb-1">Horario</h3>
                        <p class="text-lg text-gray-800 font-medium">{{ $convenio->horario_practica }}</p>
                    </div>
                    
                    <div class="bg-amber-50 rounded-lg p-4">
                        <h3 class="text-xs text-amber-600 font-medium uppercase tracking-wider mb-1">Fecha de Aprobación</h3>
                        <p class="text-lg text-gray-800 font-medium">
                            {{ $convenio->fecha_aprobacion ? $convenio->fecha_aprobacion->format('d/m/Y') : 'Pendiente' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Duración y otros detalles -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Detalles Adicionales
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if(isset($convenio->oferta->horas_totales))
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Horas Totales</h3>
                        <p class="text-xl text-gray-900 font-semibold">{{ $convenio->oferta->horas_totales }} horas</p>
                    </div>
                    @endif
                    
                    @if(isset($convenio->oferta->remuneracion))
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Remuneración</h3>
                        <p class="text-xl text-gray-900 font-semibold">{{ $convenio->oferta->remuneracion }}€</p>
                    </div>
                    @endif
                    
                    <div class="bg-indigo-50 rounded-lg p-4 mt-2">
                        <h3 class="text-sm font-bold text-indigo-800 uppercase mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Duración Total
                        </h3>
                        <p class="text-md text-indigo-700">
                            @php
                                $diff = $convenio->fecha_inicio->diffInDays($convenio->fecha_fin);
                                $meses = floor($diff / 30);
                                $dias = $diff % 30;
                            @endphp
                            {{ $meses }} meses y {{ $dias }} días ({{ $diff }} días)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tareas y Objetivos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Tareas -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-green-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Tareas a Realizar
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-white p-4 rounded border border-gray-200 min-h-[160px]">
                    <p class="text-gray-800 whitespace-pre-line">{{ $convenio->tareas }}</p>
                </div>
            </div>
        </div>

        <!-- Objetivos -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-4 px-6">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Objetivos del Convenio
                </h2>
            </div>
            <div class="p-6">
                <div class="bg-white p-4 rounded border border-gray-200 min-h-[160px]">
                    <p class="text-gray-800 whitespace-pre-line">{{ $convenio->objetivos }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-between mt-8">
        <a href="{{ route('institucion.convenios.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Volver a la lista
        </a>
        
        <div class="flex space-x-3">
            <a href="{{ route('institucion.convenios.download', $convenio) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Descargar PDF
            </a>
            
            @if(!$convenio->firmado_institucion)
                <form action="{{ route('institucion.convenios.firmar', $convenio) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 flex items-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Firmar Convenio
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection 