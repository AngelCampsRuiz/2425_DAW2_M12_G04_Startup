<!-- Encabezado y botón crear -->
<div class="flex justify-between items-center p-6 border-b">
    <h1 class="text-2xl font-semibold text-gray-800">Instituciones Educativas</h1>
    <button id="btn-crear-institucion" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nueva Institución
    </button>
</div>

<!-- Tabla para pantallas medianas y grandes -->
<div class="hidden md:block">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código Centro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verificada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($instituciones as $institucion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($institucion->user && $institucion->user->imagen)
                                    <img class="h-10 w-10 rounded-full object-cover mr-3" src="{{ asset('public/profile_images/' . $institucion->user->imagen) }}" alt="{{ $institucion->user->nombre }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <span class="text-purple-800 font-medium text-sm">{{ $institucion->user ? substr($institucion->user->nombre, 0, 2) : 'IN' }}</span>
                                    </div>
                                @endif
                                <div class="text-sm font-medium text-gray-900">{{ $institucion->user ? $institucion->user->nombre : 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $institucion->codigo_centro }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $institucion->tipo_institucion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $institucion->user ? $institucion->user->ciudad : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($institucion->verificada)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Verificada
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($institucion->user && $institucion->user->activo)
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
                            <div class="flex space-x-2">
                                <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $institucion->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                
                                <button class="btn-verificar {{ $institucion->verificada ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $institucion->id }}">
                                    @if($institucion->verificada)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </button>
                                
                                <button class="btn-cambiar-estado {{ $institucion->user && $institucion->user->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $institucion->id }}" data-active="{{ $institucion->user && $institucion->user->activo ? 1 : 0 }}">
                                    @if($institucion->user && $institucion->user->activo)
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </button>
                                
                                <button class="btn-categorias text-orange-600 hover:text-orange-900" data-id="{{ $institucion->id }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No hay instituciones registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $instituciones->links() }}
    </div>
</div>

<!-- Vista móvil -->
<div class="md:hidden space-y-4 p-4">
    @forelse($instituciones as $institucion)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    @if($institucion->user && $institucion->user->imagen)
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('public/profile_images/' . $institucion->user->imagen) }}" alt="{{ $institucion->user->nombre }}">
                    @else
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="text-purple-800 font-medium text-sm">{{ $institucion->user ? substr($institucion->user->nombre, 0, 2) : 'IN' }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $institucion->user ? $institucion->user->nombre : 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $institucion->codigo_centro }} - {{ $institucion->tipo_institucion }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $institucion->user ? $institucion->user->ciudad : 'N/A' }}
                    </p>
                    <div class="flex space-x-2 mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $institucion->verificada ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $institucion->verificada ? 'Verificada' : 'Pendiente' }}
                        </span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $institucion->user && $institucion->user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $institucion->user && $institucion->user->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="btn-editar text-indigo-600 hover:text-indigo-900" data-id="{{ $institucion->id }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button class="btn-cambiar-estado {{ $institucion->user && $institucion->user->activo ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" data-id="{{ $institucion->id }}" data-active="{{ $institucion->user && $institucion->user->activo ? 1 : 0 }}">
                        @if($institucion->user && $institucion->user->activo)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
            No hay instituciones registradas
        </div>
    @endforelse
    <div class="mt-4">
        {{ $instituciones->links() }}
    </div>
</div>

<script>
    // Convertir enlaces de paginación a AJAX
    document.querySelectorAll('.pagination a').forEach(link => {
        link.classList.add('pagination-link');
        link.addEventListener('click', function(e) {
            e.preventDefault();
            actualizarTabla(this.getAttribute('href'));
        });
    });

    // Añadir el manejador para cambiar el estado de activación
    document.addEventListener('DOMContentLoaded', function() {
        asignarEventosTabla();
    });

    function asignarEventosTabla() {
        // Asignar eventos a botones de cambiar estado
        document.querySelectorAll('.btn-cambiar-estado').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const activo = this.getAttribute('data-active') === '1' ? 'desactivar' : 'activar';
                
                if (confirm(`¿Está seguro que desea ${activo} esta institución?`)) {
                    // Mostrar indicador de carga
                    this.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                    
                    // Enviar solicitud AJAX para cambiar estado
                    fetch(`/admin/instituciones/${id}/cambiar-estado`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Actualizar la tabla con los nuevos datos
                            actualizarTabla(window.location.href);
                        } else {
                            alert('Error: ' + data.message);
                            // Restaurar botón
                            this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al procesar la solicitud');
                        // Restaurar botón
                        this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                    });
                }
            });
        });
        
        // Asignar eventos a botones de verificar
        document.querySelectorAll('.btn-verificar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                // Mostrar indicador de carga
                this.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                
                // Hacer petición para cambiar estado de verificación
                fetch(`/admin/instituciones/${id}/verificar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Actualizar tabla
                        actualizarTabla(window.location.href);
                    } else {
                        alert('Error: ' + data.message);
                        // Restaurar botón
                        this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    }
                })
                .catch(error => {
                    console.error('Error al cambiar verificación:', error);
                    // Restaurar botón
                    this.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                });
            });
        });
        
        // Asignar eventos a botones de editar
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                if (typeof window.editarInstitucion === 'function') {
                    window.editarInstitucion(this.getAttribute('data-id'));
                }
            });
        });
        
        // Asignar eventos a botones de categorías
        document.querySelectorAll('.btn-categorias').forEach(btn => {
            btn.addEventListener('click', function() {
                if (typeof window.abrirModalCategorias === 'function') {
                    window.abrirModalCategorias(this.getAttribute('data-id'));
                }
            });
        });
    }
</script> 