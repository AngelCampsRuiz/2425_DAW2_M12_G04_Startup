@extends('layouts.docente')

@section('title', 'Detalles del Convenio')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-purple-50 min-h-screen">
    {{-- MIGAS DE PAN STICKY --}}
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
                <a href="{{ route('docente.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('docente.convenios.index') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">Convenios</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-purple-700 font-medium">Detalle del Convenio</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        {{-- Mensajes de alerta --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Acciones rápidas --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Convenio: {{ $convenio->oferta->titulo }}
            </h1>
            
            <div class="flex space-x-2">
                <a href="{{ route('docente.convenios.download', $convenio) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Descargar PDF
                </a>
                
                <a href="{{ route('docente.convenios.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Ver todos los convenios
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Información del Estudiante --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Información del Estudiante
                </h2>
                
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 mr-4">
                        @if($convenio->estudiante->imagen)
                            <img src="{{ asset('profile_images/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}" class="h-16 w-16 rounded-full object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-sm">
                                {{ substr($convenio->estudiante->nombre, 0, 1) }}{{ isset(explode(" ", $convenio->estudiante->nombre)[1]) ? substr(explode(" ", $convenio->estudiante->nombre)[1], 0, 1) : "" }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $convenio->estudiante->nombre }}</h3>
                        <p class="text-sm text-gray-500">{{ $convenio->estudiante->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-3 text-sm">
                    @if($convenio->estudiante->telefono)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $convenio->estudiante->telefono }}</span>
                    </div>
                    @endif
                    
                    @if(isset($convenio->estudiante->dni))
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span>{{ $convenio->estudiante->dni }}</span>
                    </div>
                    @endif
                    
                    <div class="pt-3 border-t border-gray-100 mt-3">
                        <a href="{{ route('docente.alumnos.show', $convenio->estudiante_id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver perfil completo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Información de la Empresa --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Información de la Empresa
                </h2>
                
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 mr-4">
                        @if($convenio->empresa->logo)
                            <img src="{{ asset('company_logos/' . $convenio->empresa->logo) }}" alt="{{ $convenio->empresa->nombre }}" class="h-16 w-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                        @else
                            <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xl shadow-sm">
                                {{ substr($convenio->empresa->nombre, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $convenio->empresa->nombre }}</h3>
                        <p class="text-sm text-gray-500">{{ $convenio->empresa->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-3 text-sm">
                    @if($convenio->empresa->telefono)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $convenio->empresa->telefono }}</span>
                    </div>
                    @endif
                    
                    @if($convenio->empresa->direccion)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $convenio->empresa->direccion }}</span>
                    </div>
                    @endif
                    
                    @if($convenio->empresa->cif)
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>CIF: {{ $convenio->empresa->cif }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Estado del Convenio --}}
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Estado del Convenio
                </h2>
                
                <div class="mb-6">
                    @if($convenio->estado == 'pendiente')
                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-yellow-800">Pendiente de aprobación</p>
                                <p class="text-sm text-yellow-700 mt-1">Este convenio está esperando tu aprobación</p>
                            </div>
                        </div>
                        
                        <div class="flex space-x-3 mt-6">
                            <form action="{{ route('docente.convenios.aprobar', $convenio) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Aprobar convenio
                                </button>
                            </form>
                            
                            <form action="{{ route('docente.convenios.rechazar', $convenio) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Rechazar convenio
                                </button>
                            </form>
                        </div>
                    @elseif($convenio->estado == 'activo')
                        <div class="flex items-center p-4 bg-green-50 rounded-lg border border-green-200">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-green-800">Convenio activo</p>
                                <p class="text-sm text-green-700 mt-1">Este convenio ha sido aprobado y está activo</p>
                            </div>
                        </div>
                    @elseif($convenio->estado == 'finalizado')
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-blue-800">Convenio finalizado</p>
                                <p class="text-sm text-blue-700 mt-1">Este convenio ha sido completado satisfactoriamente</p>
                            </div>
                        </div>
                    @elseif($convenio->estado == 'rechazado')
                        <div class="flex items-center p-4 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-red-800">Convenio rechazado</p>
                                <p class="text-sm text-red-700 mt-1">Este convenio ha sido rechazado</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="text-sm space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fecha de solicitud:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($convenio->created_at)->format('d/m/Y') }}</span>
                    </div>
                    
                    @if($convenio->fecha_aprobacion)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fecha de respuesta:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($convenio->fecha_aprobacion)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID de convenio:</span>
                        <span class="font-medium">{{ $convenio->id }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Detalles del Convenio --}}
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transition-all duration-300 hover:shadow-lg mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Detalles del Convenio
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Detalles de las Prácticas --}}
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-gray-50 to-indigo-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-2">Periodo de prácticas</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Fecha de inicio</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Fecha de finalización</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Horario de prácticas</h3>
                        <p class="text-sm text-gray-700">{{ ucfirst($convenio->horario_practica ?? 'No especificado') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tutor de empresa</h3>
                        <p class="text-sm text-gray-700">{{ $convenio->tutor_empresa ?? 'No especificado' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Oferta relacionada</h3>
                        <div class="bg-indigo-50 p-3 rounded-lg">
                            <p class="font-medium text-indigo-800">{{ $convenio->oferta->titulo }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($convenio->oferta->descripcion, 150) }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Tareas y Objetivos --}}
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tareas a realizar</h3>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 leading-relaxed">
                            {{ $convenio->tareas ?? 'No se han especificado tareas.' }}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Objetivos formativos</h3>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 leading-relaxed">
                            {{ $convenio->objetivos ?? 'No se han especificado objetivos.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 