@extends('layouts.institucion')

@section('title', 'Asignar Docentes al Departamento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Asignar Docentes: {{ $departamento->nombre }}</h1>
    <div class="flex space-x-2">
        <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-eye mr-2"></i> Ver Departamento
        </a>
        <a href="{{ route('institucion.departamentos.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('institucion.departamentos.guardar-asignacion-docentes', $departamento->id) }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium">Seleccionar Docentes</h2>
                <div class="flex items-center space-x-2">
                    <button type="button" id="select-all" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                        Seleccionar todos
                    </button>
                    <button type="button" id="deselect-all" class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Deseleccionar todos
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <input type="text" id="search-docentes" placeholder="Buscar docentes..." class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            
            <div class="overflow-y-auto max-h-96 border rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @foreach($docentes as $docente)
                        <div class="docente-item border rounded-lg p-4 relative hover:bg-gray-50 transition">
                            <div class="absolute top-2 right-2">
                                <input type="checkbox" name="docentes[]" value="{{ $docente->id }}" id="docente-{{ $docente->id }}" 
                                       class="w-5 h-5 text-primary focus:ring-primary border-gray-300 rounded"
                                       {{ in_array($docente->id, $docentesAsignados) ? 'checked' : '' }}>
                            </div>
                            
                            <label for="docente-{{ $docente->id }}" class="flex items-start cursor-pointer">
                                <img class="h-12 w-12 rounded-full mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $docente->user->nombre }}">
                                <div>
                                    <div class="font-medium">{{ $docente->user->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $docente->especialidad }}</div>
                                    <div class="text-xs text-gray-400">{{ $docente->cargo }}</div>
                                    
                                    @if($docente->departamento_id && $docente->departamento_id != $departamento->id)
                                        <div class="mt-1 text-xs italic text-yellow-600">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Asignado a otro departamento
                                        </div>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            @if($docentes->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    No hay docentes disponibles en esta institución.
                    <a href="{{ route('institucion.docentes.create') }}" class="text-primary font-medium">Crear uno nuevo</a>
                </div>
            @endif
        </div>
        
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Los docentes que están asignados a otros departamentos serán reasignados a este departamento si los seleccionas.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-2">
            <a href="{{ route('institucion.departamentos.show', $departamento->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                <i class="fas fa-save mr-2"></i> Guardar Asignaciones
            </button>
        </div>
    </form>
</div>

<!-- Resumen Actual -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-medium mb-4">Resumen de Asignación Actual</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border rounded-lg p-4 bg-gray-50">
            <div class="text-sm text-gray-600">Total de docentes en la institución</div>
            <div class="text-2xl font-bold">{{ $docentes->count() }}</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-gray-50">
            <div class="text-sm text-gray-600">Docentes actualmente asignados</div>
            <div class="text-2xl font-bold">{{ count($docentesAsignados) }}</div>
        </div>
        
        <div class="border rounded-lg p-4 bg-gray-50">
            <div class="text-sm text-gray-600">Docentes en otros departamentos</div>
            <div class="text-2xl font-bold">{{ $docentes->filter(function($d) use ($departamento) { return $d->departamento_id && $d->departamento_id != $departamento->id; })->count() }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda de docentes
        const searchInput = document.getElementById('search-docentes');
        const docenteItems = document.querySelectorAll('.docente-item');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            docenteItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Seleccionar/Deseleccionar todos
        const selectAllBtn = document.getElementById('select-all');
        const deselectAllBtn = document.getElementById('deselect-all');
        const checkboxes = document.querySelectorAll('input[name="docentes[]"]');
        
        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (checkbox.closest('.docente-item').style.display !== 'none') {
                    checkbox.checked = true;
                }
            });
        });
        
        deselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (checkbox.closest('.docente-item').style.display !== 'none') {
                    checkbox.checked = false;
                }
            });
        });
    });
</script>
@endpush 