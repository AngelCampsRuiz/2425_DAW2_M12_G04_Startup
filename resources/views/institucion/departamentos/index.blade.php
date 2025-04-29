@extends('layouts.institucion')

@section('title', 'Gestión de Departamentos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Departamentos</h1>
    <a href="{{ route('institucion.departamentos.create') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
        <i class="fas fa-plus mr-2"></i> Nuevo Departamento
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">Listado de Departamentos</h2>
            <div class="flex items-center">
                <input type="text" id="searchInput" placeholder="Buscar departamento..." class="px-3 py-2 border rounded-md text-sm">
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jefe de Departamento</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docentes</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clases</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="departamentosTable">
                @forelse ($departamentos as $departamento)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-md bg-purple-100 text-purple-500">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $departamento->nombre }}</div>
                                    <div class="text-xs text-gray-500">
                                        <span class="truncate">
                                            {{ Str::limit($departamento->descripcion, 50) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($departamento->jefeDepartamento)
                                    <a href="{{ route('institucion.docentes.show', $departamento->jefeDepartamento->id) }}" class="text-primary hover:underline flex items-center">
                                        <span class="w-8 h-8 rounded-full overflow-hidden inline-block mr-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($departamento->jefeDepartamento->user->nombre) }}&background=7705B6&color=fff" alt="{{ $departamento->jefeDepartamento->user->nombre }}" class="w-full h-full object-cover">
                                        </span>
                                        {{ $departamento->jefeDepartamento->user->nombre }}
                                    </a>
                                @else
                                    <span class="text-gray-400">No asignado</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    {{ $departamento->docentes->count() }} docentes
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    {{ $departamento->clases->count() }} clases
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('institucion.departamentos.edit', $departamento->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('institucion.departamentos.asignar-docentes', $departamento->id) }}" class="text-green-600 hover:text-green-900" title="Asignar Docentes">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                <form action="{{ route('institucion.departamentos.destroy', $departamento->id) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay departamentos registrados en esta institución.
                            <a href="{{ route('institucion.departamentos.create') }}" class="text-primary font-medium">Crear uno ahora</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Resumen -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Total de Departamentos -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                <i class="fas fa-building text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total de Departamentos</div>
                <div class="text-xl font-semibold">{{ $departamentos->count() }}</div>
            </div>
        </div>
    </div>
    
    <!-- Total de Docentes en Departamentos -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Docentes en Departamentos</div>
                <div class="text-xl font-semibold">
                    {{ $departamentos->sum(function($dept) { return $dept->docentes->count(); }) }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Departamentos sin Jefe -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Departamentos sin Jefe</div>
                <div class="text-xl font-semibold">
                    {{ $departamentos->filter(function($dept) { return !$dept->jefeDepartamento; })->count() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda de departamentos
        const searchInput = document.getElementById('searchInput');
        const departamentosTable = document.getElementById('departamentosTable');
        const departamentosRows = departamentosTable.querySelectorAll('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            departamentosRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Confirmación de eliminación
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este departamento? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush 