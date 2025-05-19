@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
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
                <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('empresa.convenios') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">Convenios</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-purple-700 font-medium">Detalle de Convenio</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            @include('layouts.empresa-sidebar')

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Convenio de Prácticas
                        </h1>
                        <div class="flex gap-2">
                            <a href="{{ route('empresa.convenios.edit', $convenio->id) }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg shadow hover:bg-amber-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                            <a href="{{ route('empresa.convenios.download', $convenio->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Descargar
                            </a>
                        </div>
                    </div>

                    <!-- Estado del convenio -->
                    <div class="mb-6">
                        <span class="px-4 py-1 rounded-full font-medium text-sm
                            {{ $convenio->estado == 'activo' ? 'bg-green-100 text-green-800' : 
                              ($convenio->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                              'bg-gray-100 text-gray-800') }}">
                            Estado: {{ ucfirst($convenio->estado) }}
                        </span>
                    </div>

                    <!-- Información Principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Datos del Estudiante -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Estudiante
                            </h2>
                            <div class="flex items-center space-x-4 mb-4">
                                @if($convenio->estudiante->imagen)
                                    <img src="{{ asset('profile_images/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}" class="h-14 w-14 rounded-full object-cover border-2 border-purple-100">
                                @else
                                    <div class="h-14 w-14 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-xl">
                                        {{ strtoupper(substr($convenio->estudiante->nombre, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $convenio->estudiante->nombre }}</h3>
                                    <p class="text-gray-600">{{ $convenio->estudiante->email }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex">
                                    <span class="font-medium text-gray-500 w-24">Teléfono:</span>
                                    <span>{{ $convenio->estudiante->telefono ?? 'No especificado' }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium text-gray-500 w-24">Dirección:</span>
                                    <span>{{ $convenio->estudiante->direccion ?? 'No especificada' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Datos de la Oferta -->
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Oferta
                            </h2>
                            <div class="space-y-2 text-sm">
                                <div class="flex">
                                    <span class="font-medium text-gray-500 w-24">Título:</span>
                                    <span class="font-medium text-gray-900">{{ $convenio->oferta->titulo }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium text-gray-500 w-24">Categoría:</span>
                                    <span>{{ $convenio->oferta->categoria->nombre_categoria ?? 'No especificada' }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium text-gray-500 w-24">Horas:</span>
                                    <span>{{ $convenio->oferta->horas_totales }} horas</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-medium text-gray-800 mb-2">Descripción de la oferta:</h3>
                                <p class="text-gray-600 text-sm">{{ $convenio->oferta->descripcion }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Convenio -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Detalles del Convenio</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">Fechas</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Fecha de inicio</span>
                                            <span class="block text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Fecha de fin</span>
                                            <span class="block text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">Horario y Tutor</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Horario</span>
                                            <span class="block text-base font-semibold text-gray-900">{{ ucfirst($convenio->horario_practica) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Tutor de empresa</span>
                                            <span class="block text-base font-semibold text-gray-900">{{ $convenio->tutor_empresa }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">Tareas a realizar</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $convenio->tareas }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-medium text-gray-800 mb-2">Objetivos formativos</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $convenio->objetivos }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enlaces -->
                    <div class="flex justify-between mt-8">
                        <a href="{{ route('empresa.convenios') }}" class="text-purple-600 hover:text-purple-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver a Convenios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 