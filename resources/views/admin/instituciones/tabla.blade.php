<div class="overflow-x-auto">
    <table class="min-w-full bg-white border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2 [&>th]:text-left [&>th]:font-semibold">
                <th>ID</th>
                <th>Nombre</th>
                <th>Código Centro</th>
                <th>Tipo</th>
                <th>Provincia</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Verificada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($instituciones as $institucion)
                <tr class="border-t border-gray-200 hover:bg-gray-50 [&>td]:p-2">
                    <td>{{ $institucion->id }}</td>
                    <td>{{ $institucion->user->nombre }}</td>
                    <td>{{ $institucion->codigo_centro }}</td>
                    <td>{{ $institucion->tipo_institucion }}</td>
                    <td>{{ $institucion->provincia }}</td>
                    <td>{{ $institucion->user->email }}</td>
                    <td>{{ $institucion->user->telefono }}</td>
                    <td>
                        @if($institucion->verificada)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verificada
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Pendiente
                            </span>
                        @endif
                    </td>
                    <td class="w-[180px]">
                        <div class="flex space-x-2">
                            <button class="btn-editar bg-blue-600 text-white rounded px-2 py-1 text-xs flex items-center hover:bg-blue-700 transition-colors" data-id="{{ $institucion->id }}">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </button>
                            
                            <button class="btn-verificar bg-green-600 text-white rounded px-2 py-1 text-xs flex items-center hover:bg-green-700 transition-colors" data-id="{{ $institucion->id }}">
                                @if($institucion->verificada)
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Anular
                                @else
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verificar
                                @endif
                            </button>
                            
                            <button class="btn-eliminar bg-red-600 text-white rounded px-2 py-1 text-xs flex items-center hover:bg-red-700 transition-colors" data-id="{{ $institucion->id }}">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                        
                        <div class="mt-2">
                            <a href="#" class="btn-detalle bg-purple-600 text-white rounded px-2 py-1 text-xs flex items-center justify-center hover:bg-purple-700 transition-colors">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver detalle completo
                            </a>
                        </div>
                        
                        <div class="mt-2">
                            <button class="btn-categorias bg-orange-500 text-white rounded px-2 py-1 text-xs flex items-center justify-center hover:bg-orange-600 transition-colors w-full" data-id="{{ $institucion->id }}">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Gestionar categorías
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="border-t border-gray-200">
                    <td colspan="9" class="p-4 text-center text-gray-500">No hay instituciones registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="mt-4">
    {{ $instituciones->links() }}
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
</script> 