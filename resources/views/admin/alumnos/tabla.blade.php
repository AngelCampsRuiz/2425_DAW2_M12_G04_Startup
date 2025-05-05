<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Alumnos</h1>
    <button class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        Crear Alumno
    </button>
</div>

<!-- Tabla -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($alumnos as $alumno)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($alumno->imagen)
                                <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('public/profile_images/' . $alumno->imagen) }}" alt="{{ $alumno->nombre }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-800 font-medium text-sm">{{ substr($alumno->nombre, 0, 2) }}</span>
                                </div>
                            @endif
                            <div class="text-sm font-medium text-gray-900">{{ $alumno->nombre }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->dni }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->ciudad ?? 'No especificada' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($alumno->activo)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="btn-editar text-indigo-600 hover:text-indigo-900 mr-3" data-id="{{ $alumno->id }}">
                            Editar
                        </button>
                        <button class="btn-eliminar text-red-600 hover:text-red-900" data-id="{{ $alumno->id }}">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No hay alumnos registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="px-6 py-4 bg-white border-t">
    {{ $alumnos->links() }}
</div> 