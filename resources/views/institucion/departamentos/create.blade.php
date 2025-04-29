@extends('layouts.institucion')

@section('title', 'Crear Nuevo Departamento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Crear Nuevo Departamento</h1>
    <a href="{{ route('institucion.departamentos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
        <i class="fas fa-arrow-left mr-2"></i> Volver al listado
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('institucion.departamentos.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <div class="mb-4">
                    <label for="jefe_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe de Departamento</label>
                    <select name="jefe_departamento_id" id="jefe_departamento_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">-- Seleccionar Jefe de Departamento --</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ old('jefe_departamento_id') == $docente->id ? 'selected' : '' }}>
                                {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                            </option>
                        @endforeach
                    </select>
                    @error('jefe_departamento_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Después de crear el departamento, podrás asignar docentes a este departamento desde la vista de detalles.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-6 flex justify-end">
            <a href="{{ route('institucion.departamentos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition mr-2">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-save mr-2"></i> Guardar Departamento
            </button>
        </div>
    </form>
</div>
@endsection 