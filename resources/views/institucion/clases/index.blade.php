@extends('layouts.institucion')

@section('title', 'Gestión de Clases')

@section('content')
<div class="bg-white">
    <!-- Cabecera y botones de acción -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Listado de Clases</h2>
            <p class="text-gray-600 text-sm">Gestiona las clases de tu institución educativa</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('institucion.clases.create') }}" class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-4 rounded inline-flex items-center transition-colors">
                <i class="fas fa-plus mr-2"></i> Nueva Clase
            </a>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="font-medium text-purple-800 mb-1">Total Clases</h3>
            <p class="text-2xl font-bold text-purple-900">{{ $clases->count() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="font-medium text-green-800 mb-1">Clases Activas</h3>
            <p class="text-2xl font-bold text-green-900">{{ $clases->where('activa', true)->count() }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="font-medium text-blue-800 mb-1">Departamentos</h3>
            <p class="text-2xl font-bold text-blue-900">{{ $departamentos->count() ?? 0 }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="font-medium text-yellow-800 mb-1">Estudiantes</h3>
            <p class="text-2xl font-bold text-yellow-900">{{ $estudiantes ?? 0 }}</p>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-1/3">
                <label for="filtro-departamento" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                <select id="filtro-departamento" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                    <option value="">Todos los departamentos</option>
                    @foreach($departamentos ?? [] as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="filtro-docente" class="block text-sm font-medium text-gray-700 mb-1">Docente</label>
                <select id="filtro-docente" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                    <option value="">Todos los docentes</option>
                    @foreach($docentes ?? [] as $docente)
                        <option value="{{ $docente->id }}">{{ $docente->user->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label for="filtro-busqueda" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" id="filtro-busqueda" placeholder="Nombre de la clase..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" oninput="filtrarClases()">
            </div>
        </div>
    </div>

    <!-- Tabla de clases -->
    @if($clases->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay clases registradas</h3>
            <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera clase.</p>
            <div class="mt-6">
                <a href="{{ route('institucion.clases.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark">
                    <i class="fas fa-plus mr-2"></i> Nueva clase
                </a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiantes</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-clases" class="bg-white divide-y divide-gray-200">
                    @foreach($clases as $clase)
                        <tr 
                            data-departamento="{{ $clase->departamento_id ?? '' }}" 
                            data-docente="{{ $clase->docente_id ?? '' }}" 
                            data-nombre="{{ strtolower($clase->nombre) }}" 
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $clase->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $clase->codigo }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($clase->departamento)
                                        <a href="{{ route('institucion.departamentos.show', $clase->departamento_id) }}" class="text-primary hover:text-primary-dark">
                                            {{ $clase->departamento->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Sin departamento</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($clase->docente)
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($clase->docente->user->nombre) }}&background=7705B6&color=fff" alt="{{ $clase->docente->user->nombre }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('institucion.docentes.show', $clase->docente_id) }}" class="text-primary hover:text-primary-dark">
                                                    {{ $clase->docente->user->nombre }}
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Sin asignar</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $clase->estudiantes_count ?? $clase->estudiantes()->count() }} estudiantes
                                </div>
                                @if($clase->capacidad)
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5 mt-1">
                                        @php
                                            $estudiantes = $clase->estudiantes_count ?? $clase->estudiantes()->count();
                                            $porcentaje = min(100, ($estudiantes / $clase->capacidad) * 100);
                                            $colorClase = $porcentaje > 80 ? 'bg-red-600' : ($porcentaje > 50 ? 'bg-yellow-500' : 'bg-green-500');
                                        @endphp
                                        <div class="{{ $colorClase }} h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $estudiantes }}/{{ $clase->capacidad }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full {{ $clase->activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $clase->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('institucion.clases.show', $clase->id) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('institucion.clases.edit', $clase->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('institucion.clases.toggle-active', $clase->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="{{ $clase->activa ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $clase->activa ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas {{ $clase->activa ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                        </button>
                                    </form>
                                    @if($clase->estudiantes()->count() == 0)
                                        <form action="{{ route('institucion.clases.destroy', $clase->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta clase?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function filtrarClases() {
        const departamento = document.getElementById('filtro-departamento').value;
        const docente = document.getElementById('filtro-docente').value;
        const busqueda = document.getElementById('filtro-busqueda').value.toLowerCase();
        
        const filas = document.querySelectorAll('#tabla-clases tr');
        
        filas.forEach(fila => {
            const filaDepartamento = fila.getAttribute('data-departamento');
            const filaDocente = fila.getAttribute('data-docente');
            const filaNombre = fila.getAttribute('data-nombre');
            
            const coincideDepartamento = !departamento || filaDepartamento === departamento;
            const coincideDocente = !docente || filaDocente === docente;
            const coincideBusqueda = !busqueda || filaNombre.includes(busqueda);
            
            if (coincideDepartamento && coincideDocente && coincideBusqueda) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }
</script>
@endpush 