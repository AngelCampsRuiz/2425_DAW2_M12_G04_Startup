{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @section('content')
        <div class="min-h-screen bg-gray-50 py-8">
            @if($user->role_id == 3) {{-- Perfil de Estudiante --}}
                <div class="max-w-4xl mx-auto px-4">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        {{-- Header del Perfil --}}
                        <div class="bg-gradient-to-r from-purple-600 to-purple-800 p-6 text-white">
                            <div class="flex items-center space-x-6">
                                <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                                    @if($user->imagen)
                                        <img src="{{ asset($user->imagen) }}" alt="Foto de perfil" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <span class="text-4xl font-bold text-purple-600">
                                            {{ strtoupper(substr($user->nombre, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold">{{ $user->nombre }}</h1>
                                    <p class="text-purple-200">{{ $user->email }}</p>
                                    <p class="mt-2">{{ $user->descripcion }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Información del Estudiante --}}
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-purple-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-purple-800 mb-2">Información Académica</h3>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Título:</span> {{ $user->estudiante->titulo->name_titulo ?? 'No asignado' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Centro:</span> {{ $user->estudiante->centro->nombre_centro ?? 'No asignado' }}
                                    </p>
                                </div>

                                <div class="bg-purple-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-purple-800 mb-2">Información Personal</h3>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Ciudad:</span> {{ $user->ciudad ?? 'No especificada' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Teléfono:</span> {{ $user->telefono ?? 'No especificado' }}
                                    </p>
                                </div>
                            </div>

                            {{-- CV y Acciones --}}
                            <div class="mt-6 flex items-center justify-between">
                                @if($user->estudiante->cv_pdf)
                                    <a href="{{ asset('cv/' . $user->estudiante->cv_pdf) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                        <i class="fas fa-file-pdf mr-2"></i>
                                        Ver CV
                                    </a>
                                @endif

                                @if(auth()->id() == $user->id)
                                    <div class="flex space-x-4">
                                        <button class="edit-button px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-edit mr-2"></i>Editar Perfil
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($user->role_id == 2) {{-- Perfil de Empresa --}}
                <div class="max-w-4xl mx-auto px-4">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        {{-- Header del Perfil --}}
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                            <div class="flex items-center space-x-6">
                                <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                                    @if($user->empresa->logo_url)
                                        <img src="{{ $user->empresa->logo_url }}" alt="Logo de empresa" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <span class="text-4xl font-bold text-blue-600">
                                            {{ strtoupper(substr($user->nombre, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold">{{ $user->nombre }}</h1>
                                    <p class="text-blue-200">{{ $user->email }}</p>
                                    <p class="mt-2">{{ $user->descripcion }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Información de la Empresa --}}
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Información de la Empresa</h3>
                                    <p class="text-gray-600">
                                        <span class="font-medium">CIF:</span> {{ $user->empresa->cif ?? 'No especificado' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Sector:</span> {{ $user->empresa->sector ?? 'No especificado' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Provincia:</span> {{ $user->empresa->provincia ?? 'No especificada' }}
                                    </p>
                                </div>

                                <div class="bg-blue-50 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Contacto</h3>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Dirección:</span> {{ $user->empresa->direccion ?? 'No especificada' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Teléfono:</span> {{ $user->telefono ?? 'No especificado' }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Web:</span> 
                                        <a href="{{ $user->sitio_web }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $user->sitio_web }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            {{-- Acciones --}}
                            @if(auth()->id() == $user->id)
                                <div class="mt-6 flex justify-end">
                                    <button class="edit-button px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-edit mr-2"></i>Editar Perfil
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endsection