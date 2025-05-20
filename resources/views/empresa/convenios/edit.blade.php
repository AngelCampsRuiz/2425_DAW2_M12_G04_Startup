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
                <span class="text-purple-700 font-medium">Editar Convenio</span>
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
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Convenio
                    </h1>

                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Información del Convenio -->
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 mb-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex-shrink-0">
                                @if($convenio->estudiante->imagen)
                                    <img src="{{ asset('profile_images/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}" class="h-16 w-16 rounded-full object-cover border-2 border-purple-100">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-xl">
                                        {{ strtoupper(substr($convenio->estudiante->nombre, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">{{ $convenio->estudiante->nombre }}</h2>
                                <p class="text-gray-600">{{ $convenio->estudiante->email }}</p>
                                <div class="mt-1">
                                    <span class="text-sm bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full">
                                        {{ $convenio->oferta->titulo }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de edición -->
                    <form action="{{ route('empresa.convenios.update', $convenio->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Detalles del Convenio -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">1</div>
                                Detalles del Convenio
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio *</label>
                                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $convenio->fecha_inicio->format('Y-m-d') }}" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                        @error('fecha_inicio')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha de finalización *</label>
                                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $convenio->fecha_fin->format('Y-m-d') }}" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                        @error('fecha_fin')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="horario_practica" class="block text-sm font-medium text-gray-700 mb-1">Horario de prácticas *</label>
                                    <select name="horario_practica" id="horario_practica" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                        <option value="mañana" {{ $convenio->horario_practica == 'mañana' ? 'selected' : '' }}>Mañana (9:00 - 14:00)</option>
                                        <option value="tarde" {{ $convenio->horario_practica == 'tarde' ? 'selected' : '' }}>Tarde (15:00 - 20:00)</option>
                                        <option value="flexible" {{ $convenio->horario_practica == 'flexible' ? 'selected' : '' }}>Flexible (A convenir)</option>
                                    </select>
                                    @error('horario_practica')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tutor_empresa" class="block text-sm font-medium text-gray-700 mb-1">Tutor de empresa *</label>
                                    <input type="text" name="tutor_empresa" id="tutor_empresa" value="{{ $convenio->tutor_empresa }}" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    @error('tutor_empresa')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tareas y Objetivos -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                                <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">2</div>
                                Tareas y Objetivos
                            </h4>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                <div>
                                    <label for="tareas" class="block text-sm font-medium text-gray-700 mb-1">Descripción de las tareas *</label>
                                    <textarea name="tareas" id="tareas" rows="3" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">{{ $convenio->tareas }}</textarea>
                                    @error('tareas')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Detalla las tareas que realizará el estudiante durante sus prácticas</p>
                                </div>

                                <div>
                                    <label for="objetivos" class="block text-sm font-medium text-gray-700 mb-1">Objetivos formativos *</label>
                                    <textarea name="objetivos" id="objetivos" rows="3" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">{{ $convenio->objetivos }}</textarea>
                                    @error('objetivos')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Describe los conocimientos y habilidades que adquirirá el estudiante</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('empresa.convenios.show', $convenio->id) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg">
                                Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validar que la fecha fin sea posterior a la de inicio
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        if (fechaInicio && fechaFin) {
            fechaInicio.addEventListener('change', function() {
                fechaFin.min = this.value;
                
                // Si la fecha de fin es anterior a la nueva fecha de inicio, actualizar la fecha de fin
                if (fechaFin.value && fechaFin.value < this.value) {
                    fechaFin.value = this.value;
                }
            });
            
            // Configurar inicialmente
            fechaFin.min = fechaInicio.value;
        }
    });
</script>
@endsection 