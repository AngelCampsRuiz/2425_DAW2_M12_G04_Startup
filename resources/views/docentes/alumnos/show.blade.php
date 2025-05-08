@extends('layouts.docente')

@section('title', 'Detalle de Alumno')

@section('content')
<div class="space-y-6">
    <!-- Botón para volver -->
    <div class="mb-6">
        <a href="{{ route('docente.alumnos.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver al listado
        </a>
    </div>
    
    <!-- Información del alumno -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta personal -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="flex flex-col items-center text-center mb-6">
                @if($alumno->imagen)
                    <div class="w-24 h-24 mb-3">
                        <img class="w-24 h-24 rounded-full object-cover" src="{{ asset('public/profile_images/' . $alumno->imagen) }}" alt="{{ $alumno->nombre }}">
                    </div>
                @else
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xl font-bold mb-3">
                        {{ strtoupper(substr($alumno->nombre, 0, 2)) }}
                    </div>
                @endif
                <h2 class="text-xl font-bold text-gray-800">{{ $alumno->nombre }}</h2>
                <p class="text-purple-600 font-medium">Alumno</p>
                
                <!-- Acciones -->
                <div class="flex space-x-2 mt-4">
                    <a href="{{ route('chat.show', $alumno->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Mensaje
                    </a>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-gray-500 uppercase">Email</span>
                        <span class="text-sm text-gray-800">{{ $alumno->email }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-gray-500 uppercase">Teléfono</span>
                        <span class="text-sm text-gray-800">{{ $alumno->telefono ?? 'No disponible' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-gray-500 uppercase">DNI/NIF</span>
                        <span class="text-sm text-gray-800">{{ $alumno->dni }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-gray-500 uppercase">Fecha de Registro</span>
                        <span class="text-sm text-gray-800">{{ $alumno->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Clases del alumno -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl shadow-md h-full">
                <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Clases Inscritas
                </h3>
                
                @if(count($alumno->clases) > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($alumno->clases as $clase)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $clase->nombre }}</h4>
                                        <p class="text-sm text-gray-600">Código: {{ $clase->codigo }}</p>
                                        <p class="text-xs text-gray-500">{{ $clase->departamento->nombre ?? 'Departamento no asignado' }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('docente.clases.show', $clase->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            Ver detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2">El alumno no está inscrito en ninguna clase.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Historial de actividad -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Historial de Actividad
        </h3>
        
        @if(isset($actividades) && count($actividades) > 0)
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @foreach($actividades as $actividad)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center ring-8 ring-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">{{ $actividad->descripcion }}</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $actividad->created_at }}">{{ $actividad->created_at->format('d/m/Y H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                No hay actividad registrada.
            </div>
        @endif
    </div>
</div>
@endsection 