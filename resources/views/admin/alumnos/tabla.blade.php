<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Alumnos</h1>
    <button class="btn-crear bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
        Crear Alumno
    </button>
</div>

<!-- Tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
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
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('profile_images/' . $alumno->imagen) }}" alt="{{ $alumno->nombre }}">
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
                            <div class="flex space-x-3">
                                <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $alumno->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button class="btn-activar {{ $alumno->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $alumno->id }}" data-active="{{ $alumno->activo ? '1' : '0' }}">
                                    @if($alumno->activo)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </button>
                            </div>
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
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $alumnos->links() }}
    </div>
</div>

<!-- Vista móvil -->
<div class="md:hidden space-y-4">
    @forelse($alumnos as $alumno)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    @if($alumno->imagen)
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('profile_images/' . $alumno->imagen) }}" alt="{{ $alumno->nombre }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="text-purple-800 font-medium text-sm">{{ substr($alumno->nombre, 0, 2) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $alumno->nombre }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $alumno->email }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        DNI: {{ $alumno->dni }}
                    </p>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $alumno->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $alumno->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
                <div class="flex space-x-2">
                    <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $alumno->id }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button class="btn-activar {{ $alumno->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $alumno->id }}" data-active="{{ $alumno->activo ? '1' : '0' }}">
                        @if($alumno->activo)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
            No hay alumnos registrados
        </div>
    @endforelse
    <div class="mt-4">
        {{ $alumnos->links() }}
    </div>
</div> 