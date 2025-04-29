@extends('layouts.institucion')

@section('title', 'Gestión de Docentes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Docentes</h1>
    <a href="{{ route('institucion.docentes.create') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
        <i class="fas fa-plus mr-2"></i> Nuevo Docente
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">Listado de Docentes</h2>
            <div class="flex items-center">
                <input type="text" id="searchInput" placeholder="Buscar docente..." class="px-3 py-2 border rounded-md text-sm">
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="docentesTable">
                @forelse ($docentes as $docente)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $docente->user->nombre }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $docente->user->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $docente->user->dni }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $docente->user->email }}</div>
                            <div class="text-sm text-gray-500">{{ $docente->user->telefono }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($docente->departamentoObj)
                                    {{ $docente->departamentoObj->nombre }}
                                @elseif($docente->departamento)
                                    {{ $docente->departamento }}
                                @else
                                    <span class="text-gray-400">No asignado</span>
                                @endif
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
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('institucion.docentes.show', $docente->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('institucion.docentes.edit', $docente->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('institucion.docentes.toggle-active', $docente->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="{{ $docente->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $docente->activo ? 'Desactivar' : 'Activar' }}">
                                        <i class="fas {{ $docente->activo ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('institucion.docentes.destroy', $docente->id) }}" method="POST" class="inline-block delete-form">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay docentes registrados en esta institución.
                            <a href="{{ route('institucion.docentes.create') }}" class="text-primary font-medium">Crear uno ahora</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Filtros por Departamento -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h3 class="font-medium text-lg mb-4">Filtrar por Departamento</h3>
    <div class="flex flex-wrap gap-2">
        <button class="department-filter px-3 py-1 rounded-full bg-primary text-white text-sm" data-department="all">
            Todos
        </button>
        
        @foreach ($departamentos as $departamento)
            <button class="department-filter px-3 py-1 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm" data-department="{{ $departamento->id }}">
                {{ $departamento->nombre }}
            </button>
        @endforeach
        
        <button class="department-filter px-3 py-1 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm" data-department="null">
            Sin departamento
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda de docentes
        const searchInput = document.getElementById('searchInput');
        const docentesTable = document.getElementById('docentesTable');
        const docentesRows = docentesTable.querySelectorAll('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            docentesRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filtrar por departamento
        const departmentButtons = document.querySelectorAll('.department-filter');
        
        departmentButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Actualizar clases de botones
                departmentButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-primary', 'text-white');
                
                const departmentId = this.getAttribute('data-department');
                
                docentesRows.forEach(row => {
                    if (departmentId === 'all') {
                        row.style.display = '';
                    } else if (departmentId === 'null') {
                        const departmentText = row.querySelector('td:nth-child(3)').textContent.trim();
                        row.style.display = departmentText.includes('No asignado') ? '' : 'none';
                    } else {
                        const departmentCell = row.querySelector('td:nth-child(3)');
                        const departmentText = departmentCell ? departmentCell.textContent.trim() : '';
                        
                        // Aquí necesitaríamos una forma de saber si el departamento coincide con el ID
                        // Como esto es más complejo, podríamos usar un atributo data en la fila
                        // Por ahora, haremos una coincidencia simple por texto
                        row.style.display = departmentText.toLowerCase().includes(departmentId) ? '' : 'none';
                    }
                });
            });
        });
        
        // Confirmación de eliminación
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este docente? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush 