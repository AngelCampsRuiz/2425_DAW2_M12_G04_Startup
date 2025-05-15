{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    @section('content')
        <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50">
            {{-- MIGAS DE PAN --}}
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
                        @if(auth()->user()->role_id == 2)
                        <a href="{{ route('empresa.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                            Dashboard
                        </a>
                        @elseif(auth()->user()->role_id == 3)
                        <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                            Dashboard
                        </a>
                        @elseif(auth()->user()->role_id == 4)
                        <a href="{{ route('institucion.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                            Dashboard
                        </a>
                        @endif
                        <span class="mx-2 text-gray-400">/</span>
                        <span class="text-purple-700 font-medium">
                            @if($user->role_id == 3)
                                Perfil de Estudiante
                            @elseif($user->role_id == 2)
                                Perfil de Empresa
                            @elseif($user->role_id == 4)
                                Perfil de Institución
                            @else
                                Perfil
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
                    <div id="progressSection" class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-purple-100 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-xl shadow-sm">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ __('messages.profile_progress') }}</h3>
                                    <p class="text-sm text-gray-500">{{ __('messages.complete_your_profile') }}</p>
                                </div>
                            </div>
                            <button id="toggleButton" class="text-gray-500 hover:text-purple-700 transition-colors">
                                <svg id="toggleIcon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <div id="progressContent" class="overflow-hidden transition-all duration-300">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                <div class="flex-1">
                                    <div class="space-y-6">
                                        <div class="relative">
                                            <div class="w-full bg-gray-100 rounded-full h-4 shadow-inner">
                                                <div id="progressBar" class="bg-gradient-to-r from-purple-600 to-indigo-600 h-4 rounded-full transition-all duration-500"
                                                     style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <div class="absolute right-0 top-0 transform translate-y-5">
                                                <span id="progressText" class="text-lg font-bold text-purple-700">{{ $porcentaje }}%</span>
                                            </div>
                                        </div>

                                        @if(count($campos_pendientes) > 0)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @foreach($campos_pendientes as $campo)
                                                    <div class="flex items-center gap-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                                        @if($campo['obligatorio'])
                                                            <div class="bg-red-100 p-2 rounded-lg">
                                                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="bg-yellow-100 p-2 rounded-lg">
                                                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <span class="text-sm font-medium text-gray-900">{{ $campo['nombre'] }}</span>
                                                            <p class="text-xs text-gray-500">{{ $campo['obligatorio'] ? 'Campo obligatorio' : 'Campo opcional' }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl shadow-sm">
                                    <div id="progressPercentage" class="text-4xl font-bold text-purple-700 mb-2">{{ $porcentaje }}%</div>
                                    <div id="progressMessage" class="text-sm text-gray-600 text-center">
                                        @if($porcentaje < 50)
                                            {{ __('messages.keep_completing_your_profile') }}
                                        @elseif($porcentaje < 80)
                                            {{ __('messages.you_are_on_the_right_track') }}
                                        @else
                                            {{ __('messages.almost_there') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                    <a href={{ route('publication.index') }} class="chat-button px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21l7-5 7 5V5a2 2 0 00-2-2H7a2 2 0 00-2 2z"/>
                                        </svg>
                                    </a>
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
                                    <h2 class="text-2xl font-bold text-gray-900">{{ __('messages.academic_information') }}</h2>
                                </div>
                                <div class="space-y-4">
                                    @if($user->estudiante)
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-gray-700">{{ __('messages.cycle') }}: {{ $user->estudiante->ciclo }}</span>
                                        </div>
                                        @if($user->estudiante->cv_pdf)
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <a href="{{ asset('public/cv_pdfs/' . $user->estudiante->cv_pdf) }}"
                                                   class="text-purple-600 hover:text-purple-800"
                                                   target="_blank">
                                                    {{ __('messages.view_cv') }}
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
                                        <h2 class="text-2xl font-bold text-gray-900">{{ __('messages.student_experiences') }}</h2>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.student') }}</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.position') }}</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.start_date') }}</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.end_date') }}</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.description') }}</th>
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
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-xl shadow-sm">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 ml-4">Información Personal</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div class="flex items-start" data-campo="ciudad" style="display: {{ $user->show_ciudad ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <div class="bg-purple-100 p-2 rounded-lg">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-500">{{ __('messages.city_profile') }}</p>
                                                <p class="text-lg font-semibold text-gray-900" data-valor="ciudad">{{ $user->ciudad ?? 'No especificada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start" data-campo="telefono" style="display: {{ $user->show_telefono ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <div class="bg-purple-100 p-2 rounded-lg">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-500">{{ __('messages.phone') }}</p>
                                                <p class="text-lg font-semibold text-gray-900" data-valor="telefono">{{ $user->telefono ?? 'No especificado' }}</p>
                                            </div>
                                        </div>

                                        @if(auth()->user()->role_id == 2)
                                            <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                                <input type="checkbox" name="show_cif" value="1"
                                                       {{ $user->empresa && $user->empresa->show_cif ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                <span class="text-sm font-medium text-gray-700">Mostrar CIF</span>
                                            </label>
                                        @endif

                                        {{-- Sección donde se muestra el CIF --}}
                                        @php
                                            $showCif = $user->empresa && $user->empresa->show_cif;
                                        @endphp

                                        <div class="flex items-start" 
                                             data-campo="cif" 
                                             style="display: {{ $showCif ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm text-gray-500">CIF</p>
                                                <p class="font-medium text-gray-900">{{ $user->empresa ? $user->empresa->cif : 'No especificado' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex items-start" data-campo="direccion" style="display: {{ $user->show_direccion ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <div class="bg-purple-100 p-2 rounded-lg">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-500">{{ __('messages.address_profile') }}</p>
                                                <p class="text-lg font-semibold text-gray-900" data-valor="direccion">{{ $user->direccion ?? 'No especificada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start" data-campo="web" style="display: {{ $user->show_web ? 'flex' : 'none' }}">
                                            <div class="flex-shrink-0">
                                                <div class="bg-purple-100 p-2 rounded-lg">
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-500">Sitio Web</p>
                                                <input type="url" name="sitio_web" id="sitio_web" value="{{ $user->sitio_web }}"
                                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                       placeholder="https://ejemplo.com">
                                                <span id="error-sitio_web" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Experiencias --}}
                            <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl md:col-span-2">
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-xl shadow-sm">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 ml-4">Experiencias</h3>
                                </div>
                                @if($user->experiencias->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($user->experiencias as $experiencia)
                                            <div class="bg-gradient-to-br from-white to-purple-50 rounded-xl p-6 transform transition-all duration-300 hover:shadow-md border border-purple-100">
                                                <div class="flex justify-between items-start mb-4">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900">{{ $experiencia->puesto }}</h4>
                                                        <p class="text-sm text-purple-600 font-medium">{{ $experiencia->empresa_nombre }}</p>
                                                    </div>
                                                    <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm">
                                                        {{ \Carbon\Carbon::parse($experiencia->fecha_inicio)->format('M Y') }} -
                                                        {{ $experiencia->fecha_fin ? \Carbon\Carbon::parse($experiencia->fecha_fin)->format('M Y') : 'Actual' }}
                                                    </span>
                                                </div>
                                                <div class="space-y-3">
                                                    <p class="text-gray-700">{{ $experiencia->especializacion }}</p>
                                                    @if($experiencia->descripcion)
                                                        <div class="bg-white rounded-lg p-4 shadow-sm">
                                                            <p class="text-sm text-gray-600">{{ $experiencia->descripcion }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-12">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 mb-4">
                                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay experiencias</h3>
                                        <p class="text-gray-500 max-w-md mx-auto">Aún no has añadido ninguna experiencia laboral. Añade tus experiencias para mejorar tu perfil.</p>
                                        @if(auth()->id() == $user->id)
                                            <button onclick="openEditModal()" class="mt-6 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Añadir Experiencia
                                            </button>
                                        @endif
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
                                    @if($user->imagen)
                                        <img src="{{ asset('public/profile_images/' . $user->imagen) }}"
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
                                        <div class="flex items-start" data-campo="empresa-cif">
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
                                                <p class="text-sm font-medium text-gray-500">Sitio Web</p>
                                                <input type="url" name="sitio_web" id="sitio_web" value="{{ $user->sitio_web }}"
                                                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                                       placeholder="https://ejemplo.com">
                                                <span id="error-sitio_web" class="error-message text-xs text-red-500 mt-1 hidden"></span>
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
        @endif

        <div>

        </div>

        <!-- Sección de Valoraciones -->
        <div class="valoraciones-section mt-8">
            <div class="bg-white rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-3 rounded-xl shadow-sm">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 ml-4">Valoraciones Recibidas</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($valoracionesRecibidas as $valoracion)
                        <div class="bg-gradient-to-br from-white to-purple-50 rounded-xl p-6 transform transition-all duration-300 hover:shadow-md border border-purple-100">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-md">
                                        @if($valoracion->emisor->imagen)
                                            <img src="{{ asset('public/profile_images/' . $valoracion->emisor->imagen) }}"
                                                 alt="Avatar"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xl font-bold text-purple-600">
                                                {{ strtoupper(substr($valoracion->emisor->nombre, 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold text-gray-900">{{ $valoracion->emisor->nombre }}</h3>
                                        <p class="text-sm text-gray-500">{{ $valoracion->fecha_valoracion->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                @if(auth()->id() == $valoracion->emisor_id)
                                    <div class="flex space-x-2">
                                        <button onclick="editValoracion({{ $valoracion->id }}, {{ $valoracion->puntuacion }}, '{{ $valoracion->comentario }}')"
                                                class="text-purple-600 hover:text-purple-800 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteValoracion({{ $valoracion->id }})"
                                                class="text-red-600 hover:text-red-800 transition-colors">
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
                                        <svg class="w-6 h-6 {{ $i <= $valoracion->puntuacion ? 'text-yellow-400' : 'text-gray-300' }}"
                                             fill="currentColor"
                                             viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm mb-4">
                                <p class="text-gray-700">{{ $valoracion->comentario }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 text-sm font-medium">
                                    {{ $valoracion->tipo == 'alumno_a_empresa' ? 'Valoración de Alumno' : 'Valoración de Empresa' }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $valoracion->fecha_valoracion->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2">
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-indigo-100 mb-4">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay valoraciones recibidas</h3>
                                <p class="text-gray-500 max-w-md mx-auto">Aún no has recibido ninguna valoración. Las valoraciones aparecerán aquí cuando otros usuarios te valoren.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
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
                        <input type="hidden" id="valoracionId" name="valoracion_id">

                        {{-- Estrellas de Valoración --}}
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

                        {{-- Comentario --}}
                        <div class="mb-6">
                            <label for="editComentario" class="block text-sm font-medium text-gray-700 mb-2">Comentario</label>
                            <textarea id="editComentario" name="comentario" rows="4" required
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                      placeholder="Escribe tu valoración..."></textarea>
                        </div>

                        {{-- Botones --}}
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

        {{-- Modal de Edición --}}
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
            <div class="relative top-20 mx-auto p-5 w-full max-w-4xl">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300">
                    {{-- Header del Modal --}}
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white">Editar Perfil</h3>
                            </div>
                            <button onclick="closeEditModal()" class="text-white hover:text-purple-200 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Contenido del Modal --}}
                    <div class="p-8">
                        <form id="profileForm" 
                              action="{{ route('profile.update') }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Información Básica --}}
                            <div class="space-y-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900">Información Básica</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" value="{{ $user->nombre }}"
                                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                               onblur="validarNombre(this)">
                                        <span id="error-nombre" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" id="email" value="{{ $user->email }}"
                                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                               onblur="validarEmail(this)">
                                        <span id="error-email" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                    </div>

                                    @if(auth()->user()->role_id == 2)
                                        <div>
                                            <label for="cif" class="block text-sm font-medium text-gray-700 mb-2">CIF</label>
                                            <input type="text" name="cif" id="cif" value="{{ $user->empresa->cif ?? '' }}"
                                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                                   onblur="validarCIF(this)">
                                            <span id="error-cif" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        </div>
                                    @else
                                        <div>
                                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI</label>
                                            <input type="text" name="dni" id="dni" value="{{ $user->dni ?? '' }}"
                                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                                   onblur="validarDNI(this)">
                                            <span id="error-dni" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        </div>
                                    @endif

                                    @if($user->role_id == 3)
                                        <div>
                                            <label for="cv_pdf" class="block text-sm font-medium text-gray-700 mb-2">Curriculum Vitae</label>
                                            <input type="file" name="cv_pdf" id="cv_pdf" accept=".pdf"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all duration-200"
                                                   onchange="validarCV(this)">
                                            <span id="error-cv_pdf" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Campos Opcionales --}}
                            <div class="space-y-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900">Visibilidad de Campos</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                        <input type="checkbox" name="show_telefono" value="1"
                                               {{ $user->show_telefono ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <span class="text-sm font-medium text-gray-700">Mostrar Teléfono</span>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                        <input type="checkbox" name="show_cif" value="1"
                                               {{ $user->empresa && $user->empresa->show_cif ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <span class="text-sm font-medium text-gray-700">Mostrar CIF</span>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                        <input type="checkbox" name="show_ciudad" value="1"
                                               {{ $user->show_ciudad ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <span class="text-sm font-medium text-gray-700">Mostrar Ciudad</span>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                        <input type="checkbox" name="show_direccion" value="1"
                                               {{ $user->show_direccion ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <span class="text-sm font-medium text-gray-700">Mostrar Dirección</span>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                                        <input type="checkbox" name="show_web" value="1"
                                               {{ $user->show_web ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <span class="text-sm font-medium text-gray-700">Mostrar Sitio Web</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Información Personal --}}
                            <div class="space-y-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900">Información Personal</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                            Teléfono
                                            <span class="text-sm text-gray-500"></span>
                                        </label>
                                        <input type="text" name="telefono" id="telefono" value="{{ $user->telefono }}"
                                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                               onblur="validarTelefono(this)"
                                               placeholder="Ej: 612345678">
                                        <span id="error-telefono" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                    </div>

                                    @if(auth()->user()->role_id == 2)
                                      
                                    @else
                                        {{-- Campo DNI para otros usuarios --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">DNI</label>
                                            <input type="text" name="dni" id="dni" value="{{ $user->dni ?? '' }}"
                                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                                   onblur="validarDNI(this)">
                                            <span id="error-dni" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        </div>
                                    @endif

                                    <div>
                                        <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                                        <input type="text" name="ciudad" id="ciudad" value="{{ $user->ciudad }}"
                                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-200"
                                               onblur="validarCiudad(this)">
                                        <span id="error-ciudad" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        @error('ciudad')
                                            <span class="error-message text-xs text-red-500 mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Archivos --}}
                            <div class="space-y-6">
                                <div class="flex items-center mb-4">
                                    <div class="bg-gradient-to-br from-purple-100 to-indigo-100 p-2 rounded-lg mr-3">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900">Archivos</h4>
                                </div>

                                <div class="space-y-6">
                                    {{-- Banner de Perfil --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner de Perfil</label>
                                        @if($user->banner)
                                            <div class="mt-2 mb-4">
                                                <img src="{{ asset('public/profile_banners/' . $user->banner) }}"
                                                     alt="Banner actual"
                                                     class="w-full h-32 object-cover rounded-lg border-4 border-purple-100 shadow-md">
                                            </div>
                                        @else
                                            <p class="mt-2 text-sm text-gray-500">No hay banner personalizado</p>
                                        @endif
                                        <input type="file" name="banner" id="banner" accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all duration-200"
                                               onchange="validarBanner(this)">
                                        <span id="error-banner" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        @error('banner')
                                            <span class="error-message text-xs text-red-500 mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Foto de Perfil --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto de Perfil Actual</label>
                                        @if($user->imagen)
                                            <div class="mt-2 mb-4">
                                                <img src="{{ asset('public/profile_images/' . $user->imagen) }}"
                                                     alt="Foto actual"
                                                     class="h-24 w-24 rounded-full object-cover border-4 border-purple-100 shadow-md">
                                            </div>
                                        @else
                                            <p class="mt-2 text-sm text-gray-500">No hay foto de perfil</p>
                                        @endif
                                        <input type="file" name="imagen" id="imagen" accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all duration-200"
                                               onchange="validarImagen(this)">
                                        <span id="error-imagen" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                        @error('imagen')
                                            <span class="error-message text-xs text-red-500 mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                {{-- iffjujf --}}

                                    {{-- CV --}}
                                    @if($user->role_id == 3)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">CV Actual</label>
                                            @if($user->estudiante && $user->estudiante->cv_pdf)
                                                <div class="mt-2 mb-4">
                                                    <a href="{{ asset('cv/' . $user->estudiante->cv_pdf) }}"
                                                       target="_blank"
                                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-50 to-indigo-50 text-purple-700 rounded-xl hover:from-purple-100 hover:to-indigo-100 transition-all duration-200">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                        </svg>
                                                        Ver CV actual
                                                    </a>
                                                </div>
                                            @else
                                                <p class="mt-2 text-sm text-gray-500">No hay CV subido</p>
                                            @endif
                                            <input type="file" name="cv_pdf" id="cv_pdf" accept=".pdf"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition-all duration-200"
                                                   onchange="validarCV(this)">
                                            <span id="error-cv_pdf" class="error-message text-xs text-red-500 mt-1 hidden"></span>
                                            @error('cv_pdf')
                                                <span class="error-message text-xs text-red-500 mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Sección del Mapa (solo para empresas) --}}
                            @if(auth()->user()->role_id == 2)
                                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                            {{-- Ubicación del mapa --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Ubicación
                                        </h3>
                                        <button type="button" onclick="saveLocation()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Guardar ubicación
                                        </button>
                                    </div>

                                    {{-- Contenedor del mapa --}}
                                    <div class="w-full rounded-xl overflow-hidden shadow-md mb-4" style="height: 400px;">
                                        <div id="locationMap" class="w-full h-full"></div>
                                    </div>

                                    {{-- Campos de ubicación --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                            <input type="text" name="direccion" id="direccion" value="{{ $user->direccion }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" readonly>
                                        </div>
                                
                                    </div>

                                    {{-- Campos ocultos para las coordenadas --}}
                                    <input type="hidden" id="lat" name="lat" value="{{ $user->lat ?? '41.390205' }}">
                                    <input type="hidden" id="lng" name="lng" value="{{ $user->lng ?? '2.154007' }}">
                                </div>
                            @endif

                            {{-- Botones --}}
                            <div class="flex justify-end space-x-4 pt-6 border-t">
                                <button type="button" onclick="closeEditModal()"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                    Cancelar
                                </button>
                                <button type="submit" id="submitBtn"
                                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scripts para el modal --}}
        <script>
            function openEditModal() {
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                // Resetear errores al abrir modal
                resetAllErrors();
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

            // Manejar envío del formulario
            // Funciones de validación
            function showError(field, message) {
                const errorElement = document.getElementById('error-' + field.id);
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                    field.classList.add('border-red-500');
                }
            }

            function hideError(field) {
                const errorElement = document.getElementById('error-' + field.id);
                if (errorElement) {
                    errorElement.classList.add('hidden');
                    field.classList.remove('border-red-500');
                }
            }

            function resetAllErrors() {
                document.querySelectorAll('.error-message').forEach(el => {
                    el.classList.add('hidden');
                });
                document.querySelectorAll('input, textarea').forEach(el => {
                    el.classList.remove('border-red-500');
                });
            }

            // Añadir onblur a todos los campos cuando se carga la página
            document.addEventListener('DOMContentLoaded', function() {
                const nombreInput = document.getElementById('nombre');
                const descripcionInput = document.getElementById('descripcion');
                const telefonoInput = document.getElementById('telefono');
                const dniInput = document.getElementById('dni');
                const ciudadInput = document.getElementById('ciudad');

                if (nombreInput) nombreInput.addEventListener('blur', function() { validarNombre(this); });
                if (descripcionInput) descripcionInput.addEventListener('blur', function() { validarDescripcion(this); });
                if (telefonoInput) telefonoInput.addEventListener('blur', function() { validarTelefono(this); });
                if (dniInput) dniInput.addEventListener('blur', function() { validarDNI(this); });
                if (ciudadInput) ciudadInput.addEventListener('blur', function() { validarCiudad(this); });
            });

            function validarNombre(field) {
                if (!field.value.trim()) {
                    showError(field, "El nombre es obligatorio");
                    return false;
                } else if (field.value.trim().length < 2) {
                    showError(field, "El nombre debe tener al menos 2 caracteres");
                    return false;
                } else if (field.value.trim().length > 100) {
                    showError(field, "El nombre no puede exceder los 100 caracteres");
                    return false;
                } else {
                    hideError(field);
                    return true;
                }
            }

            function validarDescripcion(field) {
                if (field.value.trim().length > 500) {
                    showError(field, "La descripción no puede exceder los 500 caracteres");
                    return false;
                } else {
                    hideError(field);
                    return true;
                }
            }

            function validarTelefono(field) {
                if (field.value.trim() && !/^[0-9]{9}$/.test(field.value.trim())) {
                    showError(field, "El teléfono debe contener 9 dígitos");
                    return false;
                } else {
                    hideError(field);
                    return true;
                }
            }

            function validarDNI(field) {
                if (field.value.trim()) {
                    @if(auth()->user()->role_id == 2)
                        // Validación de CIF
                        const cifRegex = /^[A-HJNP-SUVW][0-9]{7}[0-9A-J]$/;
                        if (!cifRegex.test(field.value.trim().toUpperCase())) {
                            showError(field, "Formato de CIF no válido");
                            return false;
                        }
                    @else
                        // Validación de DNI/NIE
                        const dniRegex = /^[0-9]{8}[A-Za-z]$/;
                        const nieRegex = /^[XYZxyz][0-9]{7}[A-Za-z]$/;
                        if (!dniRegex.test(field.value.trim()) && !nieRegex.test(field.value.trim())) {
                            showError(field, "Formato de DNI/NIE no válido");
                            return false;
                        }
                    @endif
                    hideError(field);
                    return true;
                }
                hideError(field);
                return true;
            }

            function validarCiudad(field) {
                if (field.value.trim() && field.value.trim().length < 2) {
                    showError(field, "La ciudad debe tener al menos 2 caracteres");
                    return false;
                } else if (field.value.trim().length > 100) {
                    showError(field, "La ciudad no puede exceder los 100 caracteres");
                    return false;
                } else {
                    hideError(field);
                    return true;
                }
            }

            function validarImagen(field) {
                if (field.files.length > 0) {
                    const file = field.files[0];
                    const fileType = file.type;
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                    if (!validImageTypes.includes(fileType)) {
                        showError(field, "El archivo debe ser una imagen (JPG, PNG, GIF o WEBP)");
                        return false;
                    } else if (file.size > 2 * 1024 * 1024) { // 2MB
                        showError(field, "La imagen no puede exceder los 2MB");
                        return false;
                    } else {
                        hideError(field);
                        return true;
                    }
                } else {
                    hideError(field);
                    return true;
                }
            }

            function validarCV(field) {
                if (field.files.length > 0) {
                    const file = field.files[0];

                    if (file.type !== 'application/pdf') {
                        showError(field, "El archivo debe ser un PDF");
                        return false;
                    } else if (file.size > 5 * 1024 * 1024) { // 5MB
                        showError(field, "El CV no puede exceder los 5MB");
                        return false;
                    } else {
                        hideError(field);
                        return true;
                    }
                } else {
                    hideError(field);
                    return true;
                }
            }

            // Validar todo el formulario antes de enviar
            document.getElementById('profileForm').addEventListener('submit', function(e) {
                // Primero validar todos los campos
                let isValid = true;

                if (!validarNombre(document.getElementById('nombre'))) isValid = false;
                if (!validarDescripcion(document.getElementById('descripcion'))) isValid = false;
                if (!validarTelefono(document.getElementById('telefono'))) isValid = false;
                if (!validarDNI(document.getElementById('dni'))) isValid = false;
                if (!validarCiudad(document.getElementById('ciudad'))) isValid = false;

                const imagenInput = document.getElementById('imagen');
                if (imagenInput && imagenInput.files.length > 0) {
                    if (!validarImagen(imagenInput)) isValid = false;
                }

                const cvInput = document.getElementById('cv_pdf');
                if (cvInput && cvInput.files.length > 0) {
                    if (!validarCV(cvInput)) isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

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
                            'cif': user.empresa && $user->empresa->show_cif,
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
                            'cif': user.empresa.cif,
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

                        // Actualizar imagen de perfil si se cambió
                        if (user.imagen) {
                            const imagenPerfil = document.querySelector('.w-40.h-40.rounded-full img');
                            if (imagenPerfil) {
                                imagenPerfil.src = `{{ asset('public/profile_images/') }}/${user.imagen}`;
                            }
                        }

                        // Actualizar CV si se cambió
                        if (user.estudiante && user.estudiante.cv_pdf) {
                            const cvLink = document.querySelector('a[href*="cv/"]');
                            if (cvLink) {
                                cvLink.href = `/cv/${user.estudiante.cv_pdf}`;
                            }
                        }

                        // Mostrar mensaje de éxito
                        const successMessage = document.createElement('div');
                        successMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        successMessage.textContent = data.message;
                        document.body.appendChild(successMessage);

                        // Cerrar el modal y recargar la página después de 2 segundos
                        setTimeout(() => {
                            closeEditModal();
                            location.reload();
                        }, 2000);
                    } else if (data.errors) {
                        // Mostrar errores de validación
                        resetAllErrors();
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const inputField = document.querySelector(`[name="${field}"]`);
                            if (inputField) {
                                const errorMessage = Array.isArray(messages) ? messages[0] : messages;
                                showError(inputField, errorMessage);
                            }
                        });
                    } else {
                        throw new Error(data.message || "Ha ocurrido un error al guardar los cambios");
                    }
                })
                .catch(error => {
                    // Primero intentar parsear el error como JSON en caso de que sea una respuesta del servidor
                    let parsedError;
                    try {
                        // Si la respuesta es un objeto Response, intentamos obtener el JSON
                        if (error instanceof Response) {
                            return error.json().then(data => {
                                handleApiError(data);
                            });
                        }
                        // Si ya tenemos un objeto, lo usamos directamente
                        else if (error.message) {
                            handleApiError({ message: error.message });
                        }
                        // Último caso, error sin formato claro
                        else {
                            handleApiError({ message: "Ha ocurrido un error desconocido" });
                        }
                    } catch (e) {
                        // Si falla el parsing, usamos el error como string
                        handleApiError({ message: error.toString() });
                    }
                })
                .finally(() => {
                    // Restaurar el botón
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
            });

            // Función para manejar errores de la API
            function handleApiError(errorData) {
                const errorMsg = errorData.message || "Ha ocurrido un error al procesar la solicitud";

                // Detectar tipos específicos de errores
                if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_telefono_unique')) {
                    // Error de teléfono duplicado
                    const telefonoInput = document.getElementById('telefono');
                    if (telefonoInput) {
                        showError(telefonoInput, "Este número de teléfono ya está registrado");
                        return;
                    }
                } else if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_cif_unique')) {
                    // Error de DNI duplicado
                    const cifInput = document.getElementById('cif');
                    if (cifInput) {
                        showError(cifInput, "Este CIF ya está registrado");
                        return;
                    }
                } else if (errorMsg.includes('Duplicate entry') && errorMsg.includes('user_email_unique')) {
                    // Error de email duplicado
                    const emailInput = document.getElementById('email');
                    if (emailInput) {
                        showError(emailInput, "Este email ya está registrado");
                        return;
                    }
                }

                // Para otros errores, mostrar un mensaje dentro del modal
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mt-4 p-4 bg-red-50 text-red-700 rounded-lg';
                errorDiv.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Ha ocurrido un error</h3>
                            <div class="mt-1 text-sm text-red-700">
                                ${errorMsg}
                            </div>
                        </div>
                    </div>
                `;

                // Insertar el error en el formulario
                const form = document.getElementById('profileForm');
                const submitBtn = document.getElementById('submitBtn');

                // Remover cualquier mensaje de error anterior
                const prevError = document.querySelector('.bg-red-50.text-red-700');
                if (prevError) prevError.remove();

                // Insertar antes del botón de envío
                if (form && submitBtn) {
                    form.insertBefore(errorDiv, submitBtn.parentNode);
                }
            }
        </script>

        @if(auth()->user()->role_id == 2)
        @endif

        <!-- Sección del Mapa de Solo Lectura -->
        @if($user->role_id == 2 && !is_null($user->lat) && !is_null($user->lng))
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ubicación</h2>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="w-full h-[300px] rounded-xl overflow-hidden shadow-md">
                        <div id="viewLocationMap"
                             class="w-full h-full"
                             data-lat="{{ number_format($user->lat, 8, '.', '') }}"
                             data-lng="{{ number_format($user->lng, 8, '.', '') }}">
                        </div>
                    </div>
                    @if($user->direccion)
                        <div class="mt-4 flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $user->direccion }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endsection

@push('scripts')
    {{-- Cargar las dependencias --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- Cargar los scripts en orden --}}
    <script src="{{ asset('js/profile-validaciones.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/profile.js') }}?v={{ time() }}"></script>
@endpush

@prepend('scripts')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endprepend

@if(auth()->user()->role_id == 2)
    <div data-role="empresa" class="hidden"></div>
@endif

<script>
    function handleFormSubmit(e) {
        e.preventDefault();

        if (window.isFormSubmitting) return;

        const form = e.target;
        
        const emailInput = form.querySelector('input[name="email"]') || 
                          form.querySelector('#email') ||
                          form.querySelector('input[type="email"]');
                          
        const nombreInput = form.querySelector('input[name="nombre"]') ||
                           form.querySelector('#nombre') ||
                           form.querySelector('input[name="name"]');

        if (!emailInput) {
            Swal.fire({
                title: 'Error',
                text: 'No se encontró el campo de email en el formulario',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
            return;
        }

        if (!nombreInput) {
            Swal.fire({
                title: 'Error',
                text: 'No se encontró el campo de nombre en el formulario',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
            return;
        }

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Los cambios se han guardado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#7C3AED'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Error al guardar los cambios');
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: error.message || 'Ha ocurrido un error al guardar los cambios',
                icon: 'error',
                confirmButtonColor: '#7C3AED'
            });
        })
        .finally(() => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = 'Guardar cambios';
            }
            window.isFormSubmitting = false;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const profileForm = document.getElementById('profileForm');
        
        if (profileForm) {
            const newForm = profileForm.cloneNode(true);
            profileForm.parentNode.replaceChild(newForm, profileForm);
            newForm.addEventListener('submit', handleFormSubmit);
        }
    });
</script>