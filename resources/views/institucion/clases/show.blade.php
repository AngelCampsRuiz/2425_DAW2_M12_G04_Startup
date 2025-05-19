@extends('layouts.institucion')

@section('title', 'Detalles de la Clase')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalles de la Clase</h1>
    <div class="flex space-x-2">
        <button onclick="openModalEdit({{ $clase->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-edit mr-2"></i> Editar
        </button>
        <a href="{{ route('institucion.clases.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información Básica -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-primary text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información General</h2>
                <i class="fas fa-graduation-cap text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 mr-4">
                    <div class="h-24 w-24 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-3xl font-bold">
                        {{ substr($clase->nombre, 0, 1) }}
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $clase->nombre }}</h3>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <span class="text-gray-600 text-sm block">Código:</span>
                        <span class="font-medium">{{ $clase->codigo }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Nivel Educativo:</span>
                        <span class="font-medium">{{ $clase->nivel }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Curso:</span>
                        <span class="font-medium">{{ $clase->curso }}</span>
                    </div>
                    @if($clase->grupo)
                    <div>
                        <span class="text-gray-600 text-sm block">Grupo:</span>
                        <span class="font-medium">{{ $clase->grupo }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información del Departamento y Docente -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-blue-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Departamento y Docente</h2>
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <span class="text-gray-600 text-sm block">Departamento:</span>
                    <span class="font-medium">
                        @if($clase->departamento)
                            <a href="{{ route('institucion.departamentos.show', $clase->departamento->id) }}" class="text-primary hover:underline">
                                {{ $clase->departamento->nombre }}
                            </a>
                        @else
                            <span class="text-gray-400">No asignado</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Docente Responsable:</span>
                    <span class="font-medium">
                        @if($clase->docente)
                            <a href="{{ route('institucion.docentes.show', $clase->docente->id) }}" class="text-primary hover:underline">
                                {{ $clase->docente->user->nombre }}
                            </a>
                        @else
                            <span class="text-gray-400">No asignado</span>
                        @endif
                    </span>
                </div>
                @if($clase->docente && $clase->docente->especialidad)
                <div>
                    <span class="text-gray-600 text-sm block">Especialidad del Docente:</span>
                    <span class="font-medium">{{ $clase->docente->especialidad }}</span>
                </div>
                @endif
                <div>
                    <span class="text-gray-600 text-sm block">Fecha de creación:</span>
                    <span class="font-medium">{{ $clase->created_at->format('d/m/Y') }}</span>
                </div>
                @if($clase->descripcion)
                <div class="mt-2 pt-2 border-t">
                    <span class="text-gray-600 text-sm block">Descripción:</span>
                    <p class="font-medium mt-1">{{ $clase->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Estadísticas y Acciones -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-green-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Estadísticas</h2>
                <i class="fas fa-chart-bar text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-full mr-3">
                            <i class="fas fa-user-graduate text-blue-600"></i>
                        </div>
                        <div>
                            <span class="text-gray-600 text-sm">Estudiantes:</span>
                            <span class="font-bold text-lg block">{{ $clase->estudiantes->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t">
                    <h3 class="font-medium text-gray-700 mb-2">Acciones Rápidas</h3>
                    <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="text-primary hover:text-primary-dark font-medium flex items-center mb-2">
                        <i class="fas fa-user-plus mr-2"></i> Asignar estudiantes
                    </a>
                    
                    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="text-primary hover:text-primary-dark font-medium flex items-center">
                            <i class="fas {{ $clase->activa ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                            {{ $clase->activa ? 'Desactivar clase' : 'Activar clase' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estudiantes asociados -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Estudiantes de la Clase</h2>
    
    @if($clase->estudiantes->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clase->estudiantes as $estudiante)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&background=7705B6&color=fff" alt="{{ $estudiante->user->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->user->dni }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver perfil</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border rounded-lg bg-gray-50">
            <i class="fas fa-user-graduate text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-500">No hay estudiantes asignados a esta clase.</p>
            <a href="{{ route('institucion.clases.asignar-estudiantes', $clase->id) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-user-plus mr-2"></i> Asignar estudiantes
            </a>
        </div>
    @endif
</div>

<!-- Acciones del Pie de Página -->
<div class="mt-6 flex justify-end space-x-3">
    <button onclick="openModalEdit({{ $clase->id }})" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center focus:outline-none focus:ring-2 focus:ring-yellow-400">
        <i class="fas fa-edit mr-2"></i> Editar
    </button>
    
    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="px-4 py-2 {{ $clase->activa ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded flex items-center focus:outline-none focus:ring-2 focus:ring-{{ $clase->activa ? 'red' : 'green' }}-400">
            <i class="fas {{ $clase->activa ? 'fa-ban' : 'fa-check' }} mr-2"></i> {{ $clase->activa ? 'Desactivar' : 'Activar' }}
        </button>
    </form>
    
    <form action="{{ route('institucion.clases.destroy', $clase->id) }}" method="POST" class="inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center focus:outline-none focus:ring-2 focus:ring-red-400">
            <i class="fas fa-trash-alt mr-2"></i> Eliminar
        </button>
    </form>
</div>

<script>
// Script para confirmar eliminación
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas eliminar esta clase? Esta acción no se puede deshacer.')) {
                this.submit();
            }
        });
    });
    
    // Verificar si hay un parámetro para abrir el modal de edición
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('editModal') && urlParams.get('editModal') === 'true') {
        const id = urlParams.get('id') || {{ $clase->id }};
        openModalEdit(id);
    }
});

// Función para abrir el modal de edición
function openModalEdit(id) {
    // Redirigir a la página principal con parámetros para abrir el modal
    window.location.href = "{{ route('institucion.clases.index') }}?editModal=true&id=" + id;
}
</script>
@endsection 