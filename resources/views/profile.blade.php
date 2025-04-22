{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('content')
        <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Migas de pan mejoradas --}}
                <div class="bg-white shadow-sm mb-8">
                    <div class="container mx-auto px-4 py-3">
                        <div class="flex items-center text-sm">
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Inicio
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                            <span class="text-[#5e0490] font-medium">Perfil de {{ $user->role_id == 3 ? 'Estudiante' : 'Empresa' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Barra de Progreso del Perfil --}}
                @php
                    $total_campos = 0;
                    $campos_completados = 0;
                    $campos_pendientes = [];

                    // Campos obligatorios
                    $campos_obligatorios = ['nombre', 'email'];
                    $total_campos += count($campos_obligatorios);
                    foreach($campos_obligatorios as $campo) {
                        if(!empty($user->$campo)) {
                            $campos_completados++;
                        } else {
                            $campos_pendientes[] = [
                                'nombre' => ucfirst($campo),
                                'obligatorio' => true
                            ];
                        }
                    }

                    // Campos opcionales
                    $campos_opcionales = [
                        'descripcion' => 'Descripción personal',
                        'telefono' => 'Teléfono',
                        'ciudad' => 'Ciudad',
                        'dni' => 'DNI',
                        'imagen' => 'Foto de perfil'
                    ];
                    $total_campos += count($campos_opcionales);
                    foreach($campos_opcionales as $campo => $nombre) {
                        if(!empty($user->$campo)) {
                            $campos_completados++;
                        } else {
                            $campos_pendientes[] = [
                                'nombre' => $nombre,
                                'obligatorio' => false
                            ];
                        }
                    }

                    // Si es estudiante, añadir CV
                    if($user->role_id == 3) {
                        $total_campos++;
                        if(!empty($user->estudiante->cv_pdf)) {
                            $campos_completados++;
                        } else {
                            $campos_pendientes[] = [
                                'nombre' => 'Curriculum Vitae',
                                'obligatorio' => true
                            ];
                        }
                    }

                    $porcentaje = round(($campos_completados / $total_campos) * 100);
                @endphp

                @if($porcentaje < 100)
                    <div id="progressSection" class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl shadow-sm p-6 mb-8 border border-purple-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white p-2 rounded-lg shadow-sm">
                                    <svg class="w-6 h-6 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Progreso del Perfil</h3>
                                    <p class="text-sm text-gray-500">Completa tu perfil para mejorar tu visibilidad</p>
                                </div>
                            </div>
                            <button id="toggleButton" class="text-gray-500 hover:text-[#5e0490] transition-colors">
                                <svg id="toggleIcon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <div id="progressContent" class="overflow-hidden transition-all duration-300">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <div class="w-full bg-white rounded-full h-3 shadow-inner">
                                                <div id="progressBar" class="bg-gradient-to-r from-[#5e0490] to-purple-600 h-3 rounded-full transition-all duration-500"
                                                     style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <div class="absolute right-0 top-0 transform translate-y-3">
                                                <span id="progressText" class="text-sm font-bold text-[#5e0490]">{{ $porcentaje }}%</span>
                                            </div>
                                        </div>

                                        @if(count($campos_pendientes) > 0)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($campos_pendientes as $campo)
                                                    <div class="flex items-center gap-2 p-2 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                                        @if($campo['obligatorio'])
                                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @endif
                                                        <span class="text-sm text-gray-700">{{ $campo['nombre'] }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-sm">
                                    <div id="progressPercentage" class="text-3xl font-bold text-[#5e0490] mb-1">{{ $porcentaje }}%</div>
                                    <div id="progressMessage" class="text-sm text-gray-500 text-center">
                                        @if($porcentaje < 50)
                                            ¡Sigue completando tu perfil!
                                        @elseif($porcentaje < 80)
                                            ¡Vas por buen camino!
                                        @else
                                            ¡Casi lo tienes!
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const content = document.getElementById('progressContent');
                            const button = document.getElementById('toggleButton');
                            const icon = document.getElementById('toggleIcon');
                            let isExpanded = true;

                            // Función para alternar la visibilidad
                            function toggleProgress() {
                                isExpanded = !isExpanded;

                                if (isExpanded) {
                                    content.style.maxHeight = content.scrollHeight + "px";
                                    icon.style.transform = 'rotate(0deg)';
                                } else {
                                    content.style.maxHeight = "0";
                                    icon.style.transform = 'rotate(180deg)';
                                }
                            }

                            // Añadir el evento al botón
                            button.addEventListener('click', toggleProgress);

                            // Inicializar el estado
                            content.style.maxHeight = content.scrollHeight + "px";
                        });
                    </script>
                @endif

                    @if($user->role_id == 3)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                    {{-- Header del Perfil con gradiente --}}
                    <div class="relative h-64 bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-600">
                        <div class="absolute -bottom-20 left-8">
                            <div class="w-40 h-40 rounded-full bg-white border-4 border-white shadow-xl flex items-center justify-center overflow-hidden transform transition-transform duration-300 hover:scale-105">
                                @if($user->imagen)
                                    <img src="{{ asset('public/profile_images/' . $user->imagen) }}"
                                         alt="Foto de perfil"
                                         class="w-full h-full object-cover">
                                @else
                                    <span class="text-6xl font-bold text-purple-600">
                                        {{ strtoupper(substr($user->nombre, 0, 2)) }}
                                    </span>
                    @endif
                </div>
                        </div>
                    </div>

                    {{-- Contenido Principal --}}
                    <div class="pt-24 px-8 pb-8">
                        {{-- Información Principal --}}
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $user->nombre }}</h1>
                                <div class="flex items-center space-x-4">
                                    <p class="text-purple-600 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                        {{ $user->email }}
                                    </p>
                                </div>
                            </div>
                @if(auth()->id() == $user->id)
                                <div class="flex space-x-4">
                                    <button onclick="openEditModal()"
                                            class="edit-button px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Editar Perfil</span>
                        </button>

                                    <a href="{{ route('chat.index') }}"
                                       class="chat-button px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>Ir al Chat</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Descripción --}}
                        @if($user->descripcion)
                            <div class="bg-purple-50 rounded-xl p-6 mb-8">
                                <p class="text-gray-700 leading-relaxed">{{ $user->descripcion }}</p>
                            </div>
                        @endif

                        {{-- Grid de Información --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Información Académica --}}
                            <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900">Información Académica</h2>
                                </div>
                                <div class="space-y-4">
                                    @if($user->estudiante)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-gray-700">Ciclo: {{ $user->estudiante->ciclo }}</span>
                                        </div>
                                        @if($user->estudiante->cv_pdf)
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <a href="{{ asset('public/cv_pdfs/' . $user->estudiante->cv_pdf) }}"
                                                   class="text-purple-600 hover:text-purple-800"
                                                   target="_blank">
                                                    Ver CV
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            @if($empresa && isset($experiencias) && $experiencias->count() > 0)
                                {{-- Experiencias de Estudiantes --}}
                                <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                                    <div class="flex items-center mb-6">
                                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900">Experiencias de Estudiantes</h2>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Puesto</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inicio</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Fin</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($experiencias as $experiencia)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $experiencia->alumno->user->name }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{ $experiencia->puesto }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{ $experiencia->fecha_inicio->format('d/m/Y') }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">
                                                                {{ $experiencia->fecha_fin ? $experiencia->fecha_fin->format('d/m/Y') : 'Actual' }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="text-sm text-gray-900">{{ $experiencia->descripcion }}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            {{-- Información Personal --}}
                            <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                                <div class="flex items-center mb-6">
                                    <div class="p-3 bg-purple-100 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 ml-4">Información Personal</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-start" data-campo="ciudad" style="display: {{ $user->show_ciudad ? 'flex' : 'none' }}">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">Ciudad</p>
                                            <p class="font-medium text-gray-900" data-valor="ciudad">{{ $user->ciudad ?? 'No especificada' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start" data-campo="telefono" style="display: {{ $user->show_telefono ? 'flex' : 'none' }}">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">Teléfono</p>
                                            <p class="font-medium text-gray-900" data-valor="telefono">{{ $user->telefono ?? 'No especificado' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start" data-campo="dni" style="display: {{ $user->show_dni ? 'flex' : 'none' }}">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">DNI</p>
                                            <p class="font-medium text-gray-900" data-valor="dni">{{ $user->dni ?? 'No especificado' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start" data-campo="direccion" style="display: {{ $user->show_direccion ? 'flex' : 'none' }}">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">Dirección</p>
                                            <p class="font-medium text-gray-900" data-valor="direccion">{{ $user->direccion ?? 'No especificada' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start" data-campo="web" style="display: {{ $user->show_web ? 'flex' : 'none' }}">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-500">Sitio Web</p>
                                            <p class="font-medium text-gray-900" data-valor="web">{{ $user->web ?? 'No especificado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Experiencias --}}
                            <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
                                <div class="flex items-center mb-6">
                                    <div class="p-3 bg-purple-100 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 ml-4">Experiencias</h3>
                                </div>
                                @if($user->experiencias->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($user->experiencias as $experiencia)
                                            <div class="bg-purple-50 rounded-xl p-6 transform transition-all duration-300 hover:shadow-md">
                                                <div class="flex justify-between items-start mb-4">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-900">{{ $experiencia->puesto }}</h4>
                                                        <p class="text-sm text-purple-600">{{ $experiencia->empresa_nombre }}</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full">
                                                        {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('M Y') }} -
                                                        {{ $experiencia->fecha_fin ? \Carbon\Carbon::parse($experiencia->fecha_fin)->format('M Y') : 'Actual' }}
                                                    </span>
                                                </div>
                                                <p class="text-gray-700">{{ $experiencia->especializacion }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay experiencias</h3>
                                        <p class="mt-1 text-sm text-gray-500">Aún no has añadido ninguna experiencia laboral.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- CV --}}
                            @if($user->estudiante && $user->estudiante->cv_pdf)
                                <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="p-3 bg-purple-100 rounded-lg">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-semibold text-gray-900 ml-4">Curriculum Vitae</h3>
                                        </div>
                                        <a href="{{ asset('cv/' . $user->estudiante->cv_pdf) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Ver CV
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    </div>
                @else
                    {{-- Sección de Empresa --}}
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                        {{-- Header del Perfil con gradiente --}}
                        <div class="relative h-64 bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-600">
                            <div class="absolute -bottom-20 left-8">
                                <div class="w-40 h-40 rounded-full bg-white border-4 border-white shadow-xl flex items-center justify-center overflow-hidden transform transition-transform duration-300 hover:scale-105">
                                    @if($user->empresa->logo_url)
                                        <img src="{{ $user->empresa->logo_url }}"
                                             alt="Logo empresa"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-6xl font-bold text-purple-600">
                                            {{ strtoupper(substr($user->nombre, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Contenido Principal --}}
                        <div class="pt-24 px-8 pb-8">
                            {{-- Información Principal --}}
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $user->nombre }}</h1>
                                    <div class="flex items-center space-x-4">
                                        <p class="text-purple-600 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                                @if(auth()->id() == $user->id)
                                    <div class="flex space-x-4">
                                        <button onclick="openEditModal()"
                                                class="edit-button px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Editar Perfil</span>
                                        </button>

                                        <a href="{{ route('chat.index') }}"
                                           class="chat-button px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            <span>Ir al Chat</span>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Descripción --}}
                            @if($user->descripcion)
                                <div class="bg-purple-50 rounded-xl p-6 mb-8">
                                    <p class="text-gray-700 leading-relaxed">{{ $user->descripcion }}</p>
                                </div>
                            @endif

                            {{-- Grid de Información --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {{-- Información de la Empresa --}}
                                <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                                    <div class="flex items-center mb-6">
                                        <div class="p-3 bg-purple-100 rounded-lg">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 ml-4">Información de la Empresa</h3>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">CIF</p>
                                                <p class="font-medium text-gray-900">{{ $user->empresa->cif ?? 'No especificado' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Sector</p>
                                                <p class="font-medium text-gray-900">{{ $user->empresa->sector ?? 'No especificado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Información de Contacto --}}
                                <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                                    <div class="flex items-center mb-6">
                                        <div class="p-3 bg-purple-100 rounded-lg">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 ml-4">Información de Contacto</h3>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="flex items-start" data-campo="telefono" style="display: {{ $user->show_telefono ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Teléfono</p>
                                                <p class="font-medium text-gray-900" data-valor="telefono">{{ $user->telefono ?? 'No especificado' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start" data-campo="ciudad" style="display: {{ $user->show_ciudad ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Ciudad</p>
                                                <p class="font-medium text-gray-900" data-valor="ciudad">{{ $user->ciudad ?? 'No especificada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start" data-campo="direccion" style="display: {{ $user->show_direccion ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Dirección</p>
                                                <p class="font-medium text-gray-900" data-valor="direccion">{{ $user->direccion ?? 'No especificada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start" data-campo="web" style="display: {{ $user->show_web ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">Sitio Web</p>
                                                <p class="font-medium text-gray-900" data-valor="web">{{ $user->web ?? 'No especificado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botón y Modal de Valoración --}}
        @php
            $canRate = false;
            $seguimientoId = null;

            if (auth()->check()) {
                if (auth()->user()->role_id == 2 && $user->role_id == 3) {
                    // Empresa valorando a estudiante
                    $seguimiento = App\Models\Seguimiento::where('empresa_id', auth()->user()->empresa->id)
                        ->where('alumno_id', $user->estudiante->id)
                        ->where('estado', 'aceptado')
                        ->whereHas('convenio')
                        ->whereDoesntHave('convenio.valoraciones', function($query) use ($user) {
                            $query->where('emisor_id', auth()->id())
                                  ->where('receptor_id', $user->id);
                        })
                        ->first();
                    if ($seguimiento) {
                        $canRate = true;
                        $seguimientoId = $seguimiento->id;
                    }
                } elseif (auth()->user()->role_id == 3 && $user->role_id == 2) {
                    // Estudiante valorando a empresa
                    $seguimiento = App\Models\Seguimiento::where('alumno_id', auth()->user()->estudiante->id)
                        ->where('empresa_id', $user->empresa->id)
                        ->where('estado', 'aceptado')
                        ->whereHas('convenio')
                        ->whereDoesntHave('convenio.valoraciones', function($query) use ($user) {
                            $query->where('emisor_id', auth()->id())
                                  ->where('receptor_id', $user->id);
                        })
                        ->first();
                    if ($seguimiento) {
                        $canRate = true;
                        $seguimientoId = $seguimiento->id;
                    }
                }
            }
        @endphp

        @if($canRate && auth()->id() != $user->id)
            <div class="fixed bottom-8 right-8">
                <button onclick="openRatingModal()"
                        class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span>Valorar {{ $user->role_id == 3 ? 'Estudiante' : 'Empresa' }}</span>
                </button>
            </div>

            {{-- Modal de Valoración --}}
            <div id="ratingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 w-full max-w-md">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-white">Valorar {{ $user->role_id == 3 ? 'Estudiante' : 'Empresa' }}</h3>
                                <button onclick="closeRatingModal()" class="text-white hover:text-purple-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <form action="{{ route('valoraciones.store') }}" method="POST" id="ratingForm" class="p-6">
                            @csrf
                            <input type="hidden" name="seguimiento_id" value="{{ $seguimientoId }}">
                            <input type="hidden" name="receptor_id" value="{{ $user->id }}">
                            <input type="hidden" name="tipo" value="{{ auth()->user()->role_id == 2 ? 'empresa_a_alumno' : 'alumno_a_empresa' }}">

                            {{-- Estrellas de Valoración --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Puntuación</label>
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" onclick="setRating({{ $i }})"
                                                class="rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors duration-200"
                                                data-rating="{{ $i }}">★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="puntuacion" id="puntuacion" required>
                            </div>

                            {{-- Comentario --}}
                            <div class="mb-6">
                                <label for="comentario" class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                                <textarea id="comentario" name="comentario" rows="4" required
                                          class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                          placeholder="Escribe tu valoración..."></textarea>
                            </div>

                            {{-- Botones --}}
                            <div class="flex justify-end space-x-4">
                                <button type="button" onclick="closeRatingModal()"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700">
                                    Enviar Valoración
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openRatingModal() {
                    document.getElementById('ratingModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeRatingModal() {
                    document.getElementById('ratingModal').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                function setRating(rating) {
                    document.getElementById('puntuacion').value = rating;
                    const stars = document.querySelectorAll('.rating-star');
                    stars.forEach((star, index) => {
                        star.classList.toggle('text-yellow-400', index < rating);
                        star.classList.toggle('text-gray-300', index >= rating);
                    });
                }

                // Cerrar modal al hacer clic fuera
                document.getElementById('ratingModal').addEventListener('click', function(event) {
                    if (event.target === this) {
                        closeRatingModal();
                    }
                });

                // Manejar envío del formulario
                document.getElementById('ratingForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;

                    // Mostrar indicador de carga
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando...
                    `;

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            const successMessage = document.createElement('div');
                            successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                            successMessage.textContent = data.message;
                            document.body.appendChild(successMessage);

                            // Cerrar el modal y recargar la página después de 2 segundos
                            setTimeout(() => {
                                closeRatingModal();
                                location.reload();
                            }, 2000);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        // Mostrar mensaje de error
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        errorMessage.textContent = error.message;
                        document.body.appendChild(errorMessage);

                        setTimeout(() => {
                            errorMessage.remove();
                        }, 3000);
                    })
                    .finally(() => {
                        // Restaurar el botón
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    });
                });
            </script>
        @endif

        <div>

        </div>

        <!-- Sección de Valoraciones -->
        <div class="valoraciones-section mt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Valoraciones Recibidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($valoracionesRecibidas as $valoracion)
                    <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                    @if($valoracion->emisor->imagen)
                                        <img src="{{ asset('public/profile_images/' . $valoracion->emisor->imagen) }}"
                                             alt="Avatar"
                                             class="w-full h-full rounded-full object-cover">
                                    @else
                                        <span class="text-xl font-bold text-purple-600">
                                            {{ strtoupper(substr($valoracion->emisor->nombre, 0, 2)) }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $valoracion->emisor->nombre }}</h3>
                                    <p class="text-sm text-gray-500">{{ $valoracion->fecha_valoracion->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            @if(auth()->id() == $valoracion->emisor_id)
                                <div class="flex space-x-2">
                                    <button onclick="editValoracion({{ $valoracion->id }}, {{ $valoracion->puntuacion }}, '{{ $valoracion->comentario }}')"
                                            class="text-purple-600 hover:text-purple-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button onclick="deleteValoracion({{ $valoracion->id }})"
                                            class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $valoracion->puntuacion ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $valoracion->comentario }}</p>
                        <div class="mt-4 text-sm text-gray-500">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-800">
                                {{ $valoracion->tipo == 'alumno_a_empresa' ? 'Valoración de Alumno' : 'Valoración de Empresa' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2">
                        <div class="text-center py-8 bg-white rounded-xl shadow-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay valoraciones recibidas</h3>
                            <p class="mt-1 text-sm text-gray-500">Aún no has recibido ninguna valoración.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal de Edición de Valoración -->
        <div id="editValoracionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 w-full max-w-md">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-white">Editar Valoración</h3>
                            <button onclick="closeEditValoracionModal()" class="text-white hover:text-purple-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form id="editValoracionForm" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="valoracionId">

                        <!-- Estrellas de Valoración -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Puntuación</label>
                            <div class="flex space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setEditRating({{ $i }})"
                                            class="edit-rating-star text-3xl text-gray-300 hover:text-yellow-400 transition-colors duration-200"
                                            data-rating="{{ $i }}">★</button>
                                @endfor
                            </div>
                            <input type="hidden" name="puntuacion" id="editPuntuacion" required>
                        </div>

                        <!-- Comentario -->
                        <div class="mb-6">
                            <label for="editComentario" class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                            <textarea id="editComentario" name="comentario" rows="4" required
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                      placeholder="Escribe tu valoración..."></textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeEditValoracionModal()"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        // Funciones para el modal de edición de valoración
        function editValoracion(id, puntuacion, comentario) {
            document.getElementById('valoracionId').value = id;
            document.getElementById('editPuntuacion').value = puntuacion;
            document.getElementById('editComentario').value = comentario;

            // Actualizar estrellas
            setEditRating(puntuacion);

            // Mostrar modal
            document.getElementById('editValoracionModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditValoracionModal() {
            document.getElementById('editValoracionModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function setEditRating(rating) {
            document.getElementById('editPuntuacion').value = rating;
            const stars = document.querySelectorAll('.edit-rating-star');
            stars.forEach((star, index) => {
                star.classList.toggle('text-yellow-400', index < rating);
                star.classList.toggle('text-gray-300', index >= rating);
            });
        }

        // Manejar el envío del formulario de edición
        document.getElementById('editValoracionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const valoracionId = document.getElementById('valoracionId').value;
            const formData = new FormData(this);

            fetch(`/valoraciones/${valoracionId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Valoración actualizada correctamente',
                        icon: 'success',
                        confirmButtonColor: '#7C3AED'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al actualizar la valoración',
                    icon: 'error',
                    confirmButtonColor: '#7C3AED'
                });
            });
        });

        // Función para eliminar valoración
        function deleteValoracion(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7C3AED',
                cancelButtonColor: '#EF4444',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/valoraciones/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'La valoración ha sido eliminada.',
                                icon: 'success',
                                confirmButtonColor: '#7C3AED'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al eliminar la valoración',
                            icon: 'error',
                            confirmButtonColor: '#7C3AED'
                        });
                    });
                }
            });
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('editValoracionModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeEditValoracionModal();
            }
        });
        </script>
    @endsection
