{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Migas de pan --}}
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
                        <span class="text-[#5e0490] font-medium">Perfil de Empresa</span>
                    </div>
                </div>
            </div>

            {{-- Barra de Progreso del Perfil --}}
            @php
                $total_campos = 0;
                $campos_completados = 0;
                $campos_pendientes = [];
                
                // Campos obligatorios
                $campos_obligatorios = ['nombre', 'email', 'cif'];
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
                    'descripcion' => 'Descripción',
                    'telefono' => 'Teléfono',
                    'ciudad' => 'Ciudad',
                    'sector' => 'Sector',
                    'logo_url' => 'Logo'
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
            @endif

            {{-- Contenido Principal --}}
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

                        {{-- Experiencias de Estudiantes --}}
                        <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl mt-8">
                            <div class="flex items-center mb-6">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 ml-4">Experiencias de Estudiantes</h3>
                            </div>
                            @if(isset($experiencias) && $experiencias->count() > 0)
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
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay experiencias registradas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Aún no hay estudiantes que hayan realizado prácticas en esta empresa.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Edición --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-2xl">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300">
                {{-- Header del Modal --}}
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-white">Editar Perfil</h3>
                        <button onclick="closeEditModal()" class="text-white hover:text-purple-200 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Contenido del Modal --}}
                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        {{-- Información Básica --}}
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Información Básica</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                    <input type="text" name="nombre" value="{{ $user->nombre }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                    <textarea name="descripcion" rows="3" 
                                              class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ $user->descripcion }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Información de la Empresa --}}
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Información de la Empresa</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CIF</label>
                                    <input type="text" name="cif" value="{{ $user->empresa->cif }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                                    <input type="text" name="sector" value="{{ $user->empresa->sector }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>
                            </div>
                        </div>

                        {{-- Campos Opcionales --}}
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Visibilidad de Campos</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <input type="checkbox" name="show_telefono" value="1" 
                                           {{ $user->show_telefono ? 'checked' : '' }} 
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Mostrar Teléfono</span>
                                </label>

                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <input type="checkbox" name="show_ciudad" value="1" 
                                           {{ $user->show_ciudad ? 'checked' : '' }} 
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Mostrar Ciudad</span>
                                </label>

                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <input type="checkbox" name="show_direccion" value="1" 
                                           {{ $user->show_direccion ? 'checked' : '' }} 
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Mostrar Dirección</span>
                                </label>

                                <label class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <input type="checkbox" name="show_web" value="1" 
                                           {{ $user->show_web ? 'checked' : '' }} 
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Mostrar Sitio Web</span>
                                </label>
                            </div>
                        </div>

                        {{-- Información Personal --}}
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Información Personal</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                    <input type="text" name="telefono" value="{{ $user->telefono }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                                    <input type="text" name="ciudad" value="{{ $user->ciudad }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <input type="text" name="direccion" value="{{ $user->direccion }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
                                    <input type="text" name="web" value="{{ $user->web }}" 
                                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                </div>
                            </div>
                        </div>

                        {{-- Logo --}}
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">Logo</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Logo Actual</label>
                                @if($user->empresa->logo_url)
                                    <div class="mt-2 mb-4">
                                        <img src="{{ $user->empresa->logo_url }}" 
                                             alt="Logo actual" 
                                             class="h-24 w-24 rounded-full object-cover border-4 border-purple-100">
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-500">No hay logo subido</p>
                                @endif
                                <input type="file" name="logo" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end space-x-4 pt-4 border-t">
                            <button type="button" onclick="closeEditModal()" 
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors duration-200">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para animaciones y modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Funciones para el modal
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }

        // Actualizar el botón de editar para abrir el modal
        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.querySelector('.edit-button');
            if (editButton) {
                editButton.onclick = openEditModal;
            }
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
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
                Guardando...
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
                    // Actualizar la barra de progreso
                    const progressBar = document.getElementById('progressBar');
                    const progressText = document.getElementById('progressText');
                    const progressPercentage = document.getElementById('progressPercentage');
                    const progressMessage = document.getElementById('progressMessage');
                    
                    if (progressBar && progressText && progressPercentage && progressMessage) {
                        progressBar.style.width = data.porcentaje + '%';
                        progressText.textContent = data.porcentaje + '%';
                        progressPercentage.textContent = data.porcentaje + '%';
                        
                        // Actualizar mensaje según el porcentaje
                        if (data.porcentaje < 50) {
                            progressMessage.textContent = '¡Sigue completando tu perfil!';
                        } else if (data.porcentaje < 80) {
                            progressMessage.textContent = '¡Vas por buen camino!';
                        } else {
                            progressMessage.textContent = '¡Casi lo tienes!';
                        }
                    }

                    // Actualizar la información del perfil
                    const user = data.user;
                    
                    // Actualizar nombre
                    const nombreElement = document.querySelector('h1.text-4xl');
                    if (nombreElement) nombreElement.textContent = user.nombre;

                    // Actualizar descripción
                    const descripcionElement = document.querySelector('.text-gray-700.leading-relaxed');
                    if (descripcionElement) descripcionElement.textContent = user.descripcion || '';

                    // Actualizar campos de visibilidad
                    const camposVisibles = {
                        'telefono': user.show_telefono,
                        'ciudad': user.show_ciudad,
                        'direccion': user.show_direccion,
                        'web': user.show_web
                    };

                    // Actualizar la visibilidad de cada campo
                    Object.entries(camposVisibles).forEach(([campo, visible]) => {
                        const elemento = document.querySelector(`[data-campo="${campo}"]`);
                        if (elemento) {
                            elemento.style.display = visible ? 'flex' : 'none';
                        }
                    });

                    // Actualizar valores de los campos
                    const camposValores = {
                        'telefono': user.telefono,
                        'ciudad': user.ciudad,
                        'direccion': user.direccion,
                        'web': user.web
                    };

                    Object.entries(camposValores).forEach(([campo, valor]) => {
                        const elemento = document.querySelector(`[data-valor="${campo}"]`);
                        if (elemento) {
                            elemento.textContent = valor || 'No especificado';
                        }
                    });

                    // Actualizar logo si se cambió
                    if (user.empresa && user.empresa.logo_url) {
                        const logoPerfil = document.querySelector('.w-40.h-40.rounded-full img');
                        if (logoPerfil) {
                            logoPerfil.src = user.empresa.logo_url;
                        }
                    }
                    
                    // Mostrar mensaje de éxito
                    const successMessage = document.createElement('div');
                    successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMessage.textContent = data.message;
                    document.body.appendChild(successMessage);
                    
                    // Cerrar el modal después de 2 segundos
                    setTimeout(() => {
                        closeEditModal();
                        successMessage.remove();
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
@endsection 