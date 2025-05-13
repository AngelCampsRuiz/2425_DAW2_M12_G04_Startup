@extends('layouts.institucion')

@section('title', 'Asignar Estudiante a Clase')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Asignar Estudiante a Clase</h1>
    
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('institucion.dashboard') }}" class="text-primary hover:text-primary-dark">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('institucion.solicitudes.index') }}" class="text-primary hover:text-primary-dark">Solicitudes</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('institucion.solicitudes.show', $solicitud->id) }}" class="text-primary hover:text-primary-dark">Detalle</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Asignar a Clase</span>
                </div>
            </li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Información del estudiante -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-user-graduate mr-2 text-primary"></i>Información del Estudiante
            </h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/6 flex justify-center mb-4 md:mb-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($solicitud->estudiante->user->nombre) }}&background=7705B6&color=fff" 
                         class="rounded-full w-24 h-24" alt="{{ $solicitud->estudiante->user->nombre }}">
                </div>
                <div class="md:w-5/6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Nombre completo</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->user->nombre }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Email</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->user->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Teléfono</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->telefono ?: 'No proporcionado' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Edad</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Conocimientos previos</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->conocimientos_previos ?: 'No especificados' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Intereses</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->intereses ?: 'No especificados' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seleccionar clase -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-chalkboard mr-2 text-primary"></i>Seleccionar Clase
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('institucion.solicitudes.asignar-clase.store', $solicitud->id) }}" method="POST">
                @csrf
                
                <!-- Filtros -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por departamento</label>
                        <select id="departamento" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                            <option value="">Todos los departamentos</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="docente" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por docente</label>
                        <select id="docente" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" onchange="filtrarClases()">
                            <option value="">Todos los docentes</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}">{{ $docente->user->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="busqueda" class="block text-sm font-medium text-gray-700 mb-1">Buscar por nombre</label>
                        <input type="text" id="busqueda" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Nombre de la clase" oninput="filtrarClases()">
                    </div>
                </div>

                @if($clases->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    No hay clases disponibles actualmente. Primero debe crear clases para poder asignar estudiantes.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('institucion.solicitudes.show', $solicitud->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Volver a la Solicitud
                        </a>
                        <a href="{{ route('institucion.clases.index', ['openModal' => true]) }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Crear Nueva Clase
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50 text-gray-600 text-sm">
                                <tr>
                                    <th class="py-3 px-4 text-center w-16">Selección</th>
                                    <th class="py-3 px-4 text-left">Nombre de la Clase</th>
                                    <th class="py-3 px-4 text-left">Departamento</th>
                                    <th class="py-3 px-4 text-left">Docente</th>
                                    <th class="py-3 px-4 text-left">Horario</th>
                                    <th class="py-3 px-4 text-left">Capacidad</th>
                                    <th class="py-3 px-4 text-left">Estudiantes</th>
                                </tr>
                            </thead>
                            <tbody id="tablaClases" class="divide-y divide-gray-200">
                                @foreach($clases as $clase)
                                <tr data-departamento="{{ $clase->departamento_id ?? '' }}" data-docente="{{ $clase->docente_id ?? '' }}" data-nombre="{{ strtolower($clase->nombre) }}" class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-center">
                                        <input type="radio" name="clase_id" value="{{ $clase->id }}" class="form-radio h-4 w-4 text-primary focus:ring-primary" required>
                                    </td>
                                    <td class="py-3 px-4">{{ $clase->nombre }}</td>
                                    <td class="py-3 px-4">{{ $clase->departamento ? $clase->departamento->nombre : 'Sin departamento' }}</td>
                                    <td class="py-3 px-4">{{ $clase->docente ? $clase->docente->user->nombre : 'Sin asignar' }}</td>
                                    <td class="py-3 px-4">{{ $clase->horario ?? 'No especificado' }}</td>
                                    <td class="py-3 px-4">{{ $clase->capacidad ?? 'Sin límite' }}</td>
                                    <td class="py-3 px-4">
                                        @if($clase->total_estudiantes && $clase->capacidad)
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                @php
                                                    $porcentaje = min(100, ($clase->total_estudiantes / $clase->capacidad) * 100);
                                                    $colorClase = $porcentaje > 80 ? 'bg-red-600' : ($porcentaje > 50 ? 'bg-yellow-500' : 'bg-green-500');
                                                @endphp
                                                <div class="{{ $colorClase }} h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600 mt-1 inline-block">
                                                {{ $clase->total_estudiantes }}/{{ $clase->capacidad }} estudiantes
                                            </span>
                                        @else
                                            <span class="text-gray-600">{{ $clase->total_estudiantes ?? 0 }} estudiantes</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('institucion.solicitudes.show', $solicitud->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Volver a la Solicitud
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>Asignar a la Clase Seleccionada
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filtrarClases() {
        const departamento = document.getElementById('departamento').value;
        const docente = document.getElementById('docente').value;
        const busqueda = document.getElementById('busqueda').value.toLowerCase();
        
        const filas = document.querySelectorAll('#tablaClases tr');
        
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