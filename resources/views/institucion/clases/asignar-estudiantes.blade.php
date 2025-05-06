@extends('layouts.app')

@section('title', 'Asignar Estudiantes a la Clase: ' . $clase->nombre)

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Asignar Estudiantes a la Clase: {{ $clase->nombre }}
        </h1>
        <p class="text-gray-600 mt-1">{{ $clase->nivel }} · {{ $clase->curso }}{{ $clase->grupo ? ' · Grupo ' . $clase->grupo : '' }}</p>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Seleccione los estudiantes que desea asignar a esta clase. Los estudiantes asignados tendrán acceso a los materiales y actividades de esta clase.
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('institucion.clases.guardar-asignacion-estudiantes', $clase->id) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Lista de Estudiantes</h2>
                <div class="flex items-center space-x-2">
                    <input type="text" id="searchInput" placeholder="Buscar estudiante..." class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <button type="button" id="selectAllBtn" class="text-sm text-blue-600 hover:text-blue-800">Seleccionar todos</button>
                    <button type="button" id="deselectAllBtn" class="text-sm text-red-600 hover:text-red-800">Deseleccionar todos</button>
                </div>
            </div>
        </div>

        @if($estudiantes->count() > 0)
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase Actual</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="estudiantesTable">
                            @foreach($estudiantes as $estudiante)
                                <tr>
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->id }}" 
                                            {{ in_array($estudiante->id, $estudiantesAsignados) ? 'checked' : '' }} 
                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-800 mr-3">
                                                <span class="font-semibold">{{ substr($estudiante->user->nombre, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $estudiante->user->dni }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $estudiante->user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($estudiante->clase && $estudiante->clase->id != $clase->id)
                                            <div class="flex items-center">
                                                <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                                    {{ $estudiante->clase->nombre }}
                                                </span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    (Se moverá a esta clase)
                                                </span>
                                            </div>
                                        @elseif($estudiante->clase && $estudiante->clase->id == $clase->id)
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                Esta clase
                                            </span>
                                        @else
                                            <span class="text-gray-400">Sin asignar</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg border p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No hay estudiantes disponibles</h3>
                <p class="text-gray-500">No hay estudiantes registrados en su institución que puedan ser asignados a esta clase.</p>
            </div>
        @endif

        <div class="bg-gray-50 px-6 py-4 border-t mt-6 flex justify-end space-x-3">
            <a href="{{ route('institucion.clases.show', $clase->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar Asignación
                </div>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Búsqueda de estudiantes
        const searchInput = document.getElementById('searchInput');
        const estudiantesTable = document.getElementById('estudiantesTable');
        const estudiantesRows = estudiantesTable.querySelectorAll('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            estudiantesRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Seleccionar/Deseleccionar todos
        const selectAllBtn = document.getElementById('selectAllBtn');
        const deselectAllBtn = document.getElementById('deselectAllBtn');
        const checkboxes = document.querySelectorAll('input[name="estudiantes[]"]');
        
        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (checkbox.closest('tr').style.display !== 'none') {
                    checkbox.checked = true;
                }
            });
        });
        
        deselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (checkbox.closest('tr').style.display !== 'none') {
                    checkbox.checked = false;
                }
            });
        });
    });
</script>
@endpush 