@extends('layouts.institucion')

@section('title', 'Detalles del Departamento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">{{ $departamento->nombre }}</h1>
    <div class="flex space-x-2">
        <a href="{{ route('institucion.departamentos.edit', $departamento->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-edit mr-2"></i> Editar
        </a>
        <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
            <i class="fas fa-user-plus mr-2"></i> Asignar Docentes
        </a>
        <a href="{{ route('institucion.departamentos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Información Básica -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-purple-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información del Departamento</h2>
                <i class="fas fa-building text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800">{{ $departamento->nombre }}</h3>
                @if($departamento->descripcion)
                    <p class="text-gray-600 mt-2">{{ $departamento->descripcion }}</p>
                @else
                    <p class="text-gray-400 mt-2 italic">Sin descripción</p>
                @endif
            </div>
            
            <div class="border-t pt-4">
                <div class="mb-4">
                    <span class="text-gray-600 text-sm block">Jefe de Departamento:</span>
                    @if($departamento->jefeDepartamento)
                        <div class="flex items-center mt-1">
                            <img class="h-10 w-10 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($departamento->jefeDepartamento->user->nombre) }}&background=7705B6&color=fff" alt="{{ $departamento->jefeDepartamento->user->nombre }}">
                            <div>
                                <a href="{{ route('institucion.docentes.show', $departamento->jefeDepartamento->id) }}" class="font-medium text-primary hover:underline">
                                    {{ $departamento->jefeDepartamento->user->nombre }}
                                </a>
                                <div class="text-xs text-gray-500">{{ $departamento->jefeDepartamento->cargo }}</div>
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400 italic">No asignado</span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <span class="text-gray-600 text-sm block">Docentes asignados:</span>
                    <span class="font-medium">{{ $departamento->docentes->count() }}</span>
                </div>
                
                <div class="mb-4">
                    <span class="text-gray-600 text-sm block">Clases asociadas:</span>
                    <span class="font-medium">{{ $departamento->clases->count() }}</span>
                </div>
                
                <div class="mb-4">
                    <span class="text-gray-600 text-sm block">Fecha de creación:</span>
                    <span class="font-medium">{{ $departamento->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Docentes del Departamento -->
    <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-2">
        <div class="p-5 bg-blue-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Docentes del Departamento</h2>
                <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="text-white hover:text-blue-200">
                    <i class="fas fa-user-plus"></i> Asignar
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($departamento->docentes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($departamento->docentes as $docente)
                        <div class="border rounded-lg p-4 flex items-center hover:bg-gray-50 transition">
                            <img class="h-12 w-12 rounded-full mr-4" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $docente->user->nombre }}">
                            <div class="flex-1">
                                <div class="font-medium">{{ $docente->user->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $docente->especialidad }}</div>
                                <div class="text-xs text-gray-400">{{ $docente->cargo }}</div>
                            </div>
                            <a href="{{ route('institucion.docentes.show', $docente->id) }}" class="text-primary hover:text-primary-dark">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="mb-3 text-gray-400">
                        <i class="fas fa-user-slash text-4xl"></i>
                    </div>
                    <p class="text-gray-500">No hay docentes asignados a este departamento.</p>
                    <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="mt-2 inline-block text-primary hover:underline">
                        <i class="fas fa-user-plus mr-1"></i> Asignar docentes
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Clases del Departamento -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Clases del Departamento</h2>
        <a href="{{ route('institucion.clases.index', ['openModal' => true]) }}" class="text-primary hover:text-primary-dark">
            <i class="fas fa-plus-circle mr-1"></i> Crear Nueva Clase
        </a>
    </div>
    
    @if($departamento->clases->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Curso / Grupo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($departamento->clases as $clase)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $clase->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $clase->codigo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $clase->nivel }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $clase->curso }}
                                    @if($clase->grupo) / {{ $clase->grupo }} @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($clase->docente)
                                        <a href="{{ route('institucion.docentes.show', $clase->docente->id) }}" class="text-primary hover:underline">
                                            {{ $clase->docente->user->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">No asignado</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('institucion.clases.show', $clase->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border rounded-lg bg-gray-50">
            <i class="fas fa-graduation-cap text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-500">No hay clases asociadas a este departamento.</p>
            <a href="{{ route('institucion.clases.index', ['openModal' => true]) }}" class="mt-2 inline-block text-primary hover:underline">
                <i class="fas fa-plus-circle mr-1"></i> Crear una nueva clase
            </a>
        </div>
    @endif
</div>

<!-- Acciones -->
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('institucion.departamentos.edit', $departamento->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
        <i class="fas fa-edit mr-2"></i> Editar Departamento
    </a>
    <form action="{{ route('institucion.departamentos.destroy', $departamento->id) }}" method="POST" class="inline-block delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
            <i class="fas fa-trash-alt mr-2"></i> Eliminar Departamento
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmación de eliminación
        const deleteForm = document.querySelector('.delete-form');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este departamento? Esta acción no se puede deshacer y puede afectar a docentes y clases.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endpush 