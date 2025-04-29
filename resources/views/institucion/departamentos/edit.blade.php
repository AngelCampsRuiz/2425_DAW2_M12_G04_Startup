@extends('layouts.institucion')

@section('title', 'Editar Departamento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Editar Departamento</h1>
    <div class="flex space-x-2">
        <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-eye mr-2"></i> Ver Detalles
        </a>
        <a href="{{ route('institucion.departamentos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('institucion.departamentos.update', $departamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $departamento->nombre) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('descripcion', $departamento->descripcion) }}</textarea>
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
                            <option value="{{ $docente->id }}" {{ old('jefe_departamento_id', $departamento->jefe_departamento_id) == $docente->id ? 'selected' : '' }}>
                                {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                            </option>
                        @endforeach
                    </select>
                    @error('jefe_departamento_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                El departamento actual tiene <strong>{{ $departamento->docentes->count() }}</strong> docentes asignados y <strong>{{ $departamento->clases->count() }}</strong> clases asociadas.
                            </p>
                            <p class="text-sm text-blue-700 mt-2">
                                <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="font-medium underline">
                                    Gestionar docentes del departamento
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-6 flex justify-end">
            <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition mr-2">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-save mr-2"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<!-- Docentes del Departamento -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Docentes Asignados</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($departamento->docentes as $docente)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $docente->user->nombre }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $docente->user->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $docente->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->especialidad }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->cargo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No hay docentes asignados a este departamento.
                            <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="text-primary font-medium">Asignar docentes</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 text-right">
        <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="text-primary hover:text-primary-dark font-medium">
            <i class="fas fa-user-plus mr-1"></i> Gestionar asignación de docentes
        </a>
    </div>
</div>
@endsection 