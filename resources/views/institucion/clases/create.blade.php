@extends('layouts.app')

@section('title', 'Crear Nueva Clase')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Crear Nueva Clase
        </h1>
        <p class="text-gray-600 mt-1">Complete el formulario para crear una nueva clase en su institución.</p>
    </div>

    <form action="{{ route('institucion.clases.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <!-- Información básica de la clase -->
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Información General</h2>
                    
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: Matemáticas Avanzadas</p>
                        @error('nombre')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de la Clase *</label>
                        <input type="text" name="codigo" id="codigo" required value="{{ old('codigo') }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: MAT-101 o MATE2023</p>
                        @error('codigo')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('descripcion') }}</textarea>
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
                                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
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
                                <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
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
                            <option value="Primaria" {{ old('nivel') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                            <option value="ESO" {{ old('nivel') == 'ESO' ? 'selected' : '' }}>ESO</option>
                            <option value="Bachillerato" {{ old('nivel') == 'Bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                            <option value="FP Básica" {{ old('nivel') == 'FP Básica' ? 'selected' : '' }}>FP Básica</option>
                            <option value="FP Medio" {{ old('nivel') == 'FP Medio' ? 'selected' : '' }}>FP Medio</option>
                            <option value="FP Superior" {{ old('nivel') == 'FP Superior' ? 'selected' : '' }}>FP Superior</option>
                            <option value="Otro" {{ old('nivel') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('nivel')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="curso" class="block text-sm font-medium text-gray-700 mb-1">Curso *</label>
                        <input type="text" name="curso" id="curso" required value="{{ old('curso') }}" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Ej: 1º, 2º, 3º, etc.</p>
                        @error('curso')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                        <input type="text" name="grupo" id="grupo" value="{{ old('grupo') }}" 
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Crear Clase
                </div>
            </button>
        </div>
    </form>
</div>
@endsection 