@extends('layouts.app')

@section('title', 'Editar Clase')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Editar Clase: {{ $clase->nombre }}
        </h1>
        <p class="text-gray-600 mt-1">Actualice la información de la clase según sea necesario.</p>
    </div>

    <form action="{{ route('institucion.clases.update', $clase->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <!-- Información básica de la clase -->
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Información General</h2>
                    
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre', $clase->nombre) }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: Matemáticas Avanzadas</p>
                        @error('nombre')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de la Clase *</label>
                        <input type="text" name="codigo" id="codigo" required value="{{ old('codigo', $clase->codigo) }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: MAT-101 o MATE2023</p>
                        @error('codigo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('descripcion', $clase->descripcion) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Descripción breve de la clase y sus objetivos</p>
                        @error('descripcion')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <!-- Información académica de la clase -->
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Información Académica</h2>
                    
                    <div class="mb-4">
                        <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento *</label>
                        <select name="departamento_id" id="departamento_id" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Seleccionar Departamento --</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('departamento_id', $clase->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('departamento_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente Responsable</label>
                        <select name="docente_id" id="docente_id"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Seleccionar Docente --</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}" {{ old('docente_id', $clase->docente_id) == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                        @error('docente_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Información del curso -->
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Información del Curso</h2>
                    
                    <div class="mb-4">
                        <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">Nivel *</label>
                        <select name="nivel" id="nivel" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Seleccionar Nivel --</option>
                            <option value="Primaria" {{ old('nivel', $clase->nivel) == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                            <option value="ESO" {{ old('nivel', $clase->nivel) == 'ESO' ? 'selected' : '' }}>ESO</option>
                            <option value="Bachillerato" {{ old('nivel', $clase->nivel) == 'Bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                            <option value="FP Básica" {{ old('nivel', $clase->nivel) == 'FP Básica' ? 'selected' : '' }}>FP Básica</option>
                            <option value="FP Medio" {{ old('nivel', $clase->nivel) == 'FP Medio' ? 'selected' : '' }}>FP Medio</option>
                            <option value="FP Superior" {{ old('nivel', $clase->nivel) == 'FP Superior' ? 'selected' : '' }}>FP Superior</option>
                            <option value="Otro" {{ old('nivel', $clase->nivel) == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('nivel')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="curso" class="block text-sm font-medium text-gray-700 mb-1">Curso *</label>
                        <input type="text" name="curso" id="curso" required value="{{ old('curso', $clase->curso) }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: 1º, 2º, 3º, etc.</p>
                        @error('curso')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                        <input type="text" name="grupo" id="grupo" value="{{ old('grupo', $clase->grupo) }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: A, B, C, etc.</p>
                        @error('grupo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t mt-6 flex justify-end space-x-3">
            <a href="{{ route('institucion.clases.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Actualizar Clase
                </div>
            </button>
        </div>
    </form>
</div>
@endsection 