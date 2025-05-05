@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.publicaciones.tabla')
    </div>

    <!-- Modal Crear/Editar Publicación -->
    <div id="modal-publicacion" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-titulo" class="text-xl font-semibold">Crear Nueva Publicación</h2>
                <button id="modal-close" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mensajes de error del formulario -->
            <div id="form-errors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 hidden" role="alert">
                <strong class="font-bold">¡Hay errores en el formulario!</strong>
                <ul id="error-list" class="mt-2 list-disc list-inside"></ul>
            </div>
            
            <form id="form-publicacion" method="POST">
                @csrf
                <input type="hidden" id="publicacion_id" name="publicacion_id" value="">
                <input type="hidden" id="form_method" name="_method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required maxlength="100">
                    </div>
                    
                    <div class="mb-4">
                        <label for="empresa_id" class="block text-sm font-medium text-gray-700">Empresa <span class="text-red-500">*</span></label>
                        <select name="empresa_id" id="empresa_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 select-visible"
                                style="background-color: white !important; -webkit-appearance: menulist !important; appearance: menulist !important;"
                                required>
                            <option value="" style="background-color: white !important; padding: 8px !important;">Selecciona una empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" style="background-color: white !important; padding: 8px !important;">
                                    {{ $empresa->user ? $empresa->user->nombre : 'Empresa ID: '.$empresa->id }}
                                </option>
                            @endforeach
                        </select>
                        <div id="empresa-feedback" class="mt-1 text-sm"></div>
                    </div>
                    
                    <div>
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="categoria_id" id="categoria_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 bg-white text-black"
                                style="color: black !important; background-color: white !important;"
                                required>
                            <option value="" style="color: black !important; background-color: white !important;">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" style="color: black !important; background-color: white !important;">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_id" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 bg-white text-black"
                                style="color: black !important; background-color: white !important;"
                                required>
                            <option value="" style="color: black !important; background-color: white !important;">Selecciona primero una categoría</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                        <select name="horario" id="horario" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 bg-white text-black"
                                style="color: black !important; background-color: white !important;"
                                required>
                            <option value="mañana" style="color: black !important; background-color: white !important;">Mañana</option>
                            <option value="tarde" style="color: black !important; background-color: white !important;">Tarde</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-1">Horas Totales</label>
                        <input type="number" name="horas_totales" id="horas_totales" 
                               class="w-fulsl rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required min="1">
                    </div>
                    
                    <div>
                        <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Publicación</label>
                        <input type="date" name="fecha_publicacion" id="fecha_publicacion" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required value="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="activa" id="activa" value="1" checked
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <label for="activa" class="ml-2 text-sm font-medium text-gray-700">Publicación Activa</label>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="6" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                              required></textarea>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" id="btn-cancelar" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-guardar" class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Confirmación Eliminar -->
    <div id="modal-eliminar" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Confirmar Eliminación</h2>
                <button id="modal-eliminar-close" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar esta publicación? Esta acción no se puede deshacer.</p>
            
            <form id="form-eliminar" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="eliminar_id" name="eliminar_id" value="">
                
                <div class="flex justify-end">
                    <button type="button" id="btn-cancelar-eliminar" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div id="eliminarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h2 class="text-xl font-bold text-red-600 mb-4">Confirmar eliminación</h2>
            <p class="text-gray-600 mb-4">¿Estás seguro de que deseas eliminar esta publicación? Esta acción no se puede deshacer.</p>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 font-medium cerrar-modal">Cancelar</button>
                <button type="button" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded text-white font-medium confirmar-eliminar">Eliminar</button>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar SQL -->
    <div id="eliminarSqlModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h2 class="text-xl font-bold text-purple-600 mb-4">Confirmar eliminación SQL</h2>
            <p class="text-gray-600 mb-4">Esta opción eliminará directamente el registro de la base de datos. Use solo en caso de que la eliminación normal no funcione.</p>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-gray-800 font-medium cerrar-modal">Cancelar</button>
                <button type="button" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded text-white font-medium confirmar-eliminar-sql">Eliminar SQL</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Variable de control para evitar duplicación
    let isSubmitting = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        setupEventListeners();
        setupSubcategorias();
    });
    
    function setupEventListeners() {
        // Delegación de eventos para los botones dinámicos
        document.addEventListener('click', function(e) {
            // Botones Eliminar
            if (e.target.closest('.btn-eliminar')) {
                const btn = e.target.closest('.btn-eliminar');
                const id = btn.getAttribute('data-id');
                mostrarModalEliminar(id);
            }
        });
        
        // Configurar el formulario de eliminación
        document.getElementById('form-eliminar').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (isSubmitting) return;
            isSubmitting = true;
            
            const id = document.getElementById('eliminar_id').value;
            const url = `/admin/publicaciones/${id}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                    mostrarMensajeExito(data.message || 'Publicación eliminada correctamente');
                    window.location.reload(); // Recargar la página después de eliminar
                } else {
                    alert(data.message || 'Error al eliminar la publicación');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la publicación');
            })
            .finally(() => {
                isSubmitting = false;
            });
        });
        
        // Configurar botones de cerrar modal
        document.getElementById('modal-eliminar-close').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });

        // Botones para crear y editar
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-crear')) {
                mostrarFormularioCrear();
            }
            
            if (e.target.closest('.btn-editar')) {
                const btn = e.target.closest('.btn-editar');
                const id = btn.getAttribute('data-id');
                mostrarFormularioEditar(id);
            }
        });

        // Evento change para el select de categoría
        const categoriaSelect = document.getElementById('categoria_id');
        if (categoriaSelect) {
            categoriaSelect.addEventListener('change', function() {
                cargarSubcategorias();
            });
        }
    }
    
    function cargarSubcategorias() {
        const categoriaId = document.getElementById('categoria_id');
        if (!categoriaId) return;
        
        const subcategoriasSelect = document.getElementById('subcategoria_id');
        if (!subcategoriasSelect) return;
        
        if (!categoriaId.value) {
            subcategoriasSelect.innerHTML = '<option value="">Selecciona primero una categoría</option>';
            return;
        }
        
        subcategoriasSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
        subcategoriasSelect.disabled = true;
        
        fetch(`/admin/publicaciones/subcategorias/${categoriaId.value}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            subcategoriasSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
            data.forEach(subcategoria => {
                const option = document.createElement('option');
                option.value = subcategoria.id;
                option.textContent = subcategoria.nombre_subcategoria;
                subcategoriasSelect.appendChild(option);
            });
            subcategoriasSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            subcategoriasSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
            subcategoriasSelect.disabled = false;
        });
    }
    
    function mostrarFormularioCrear() {
        document.getElementById('modal-titulo').textContent = 'Crear Nueva Publicación';
        document.getElementById('form-publicacion').reset();
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('publicacion_id').value = '';
        document.getElementById('form_method').value = 'POST';
        document.getElementById('form-publicacion').setAttribute('action', '{{ route("admin.publicaciones.store") }}');
        document.getElementById('modal-publicacion').classList.remove('hidden');
    }
    
    function mostrarFormularioEditar(id) {
        document.getElementById('modal-titulo').textContent = 'Editar Publicación';
        document.getElementById('publicacion_id').value = id;
        document.getElementById('form_method').value = 'PUT';
        document.getElementById('form-publicacion').setAttribute('action', `/admin/publicaciones/${id}`);
        
        fetch(`/admin/publicaciones/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const publicacion = data.publicacion;
            
            document.getElementById('titulo').value = publicacion.titulo;
            document.getElementById('empresa_id').value = publicacion.empresa_id;
            document.getElementById('categoria_id').value = publicacion.categoria_id;
            document.getElementById('horario').value = publicacion.horario;
            document.getElementById('horas_totales').value = publicacion.horas_totales;
            document.getElementById('fecha_publicacion').value = publicacion.fecha_publicacion ? publicacion.fecha_publicacion.split('T')[0] : '';
            document.getElementById('descripcion').value = publicacion.descripcion;
            document.getElementById('activa').checked = publicacion.activa;
            
            // Disparar el evento change para cargar las subcategorías
            cargarSubcategorias();
            
            // Esperar a que se carguen las subcategorías y luego seleccionar la correcta
            setTimeout(() => {
                document.getElementById('subcategoria_id').value = publicacion.subcategoria_id;
            }, 500);
            
            document.getElementById('modal-publicacion').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la publicación');
        });
    }
    
    function mostrarModalEliminar(id) {
        document.getElementById('eliminar_id').value = id;
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    function mostrarMensajeExito(mensaje) {
        const messageElement = document.getElementById('success-message');
        const messageText = document.getElementById('success-message-text');
        
        messageText.textContent = mensaje;
        messageElement.style.display = 'block';
        
        setTimeout(function() {
            messageElement.style.display = 'none';
        }, 5000);
    }
</script>

<style>
/* =========== ESTILOS PARA ASEGURAR VISIBILIDAD DE BOTONES =========== */
/* Asegurar que los botones de acción siempre estén visibles */
.btn-editar, .btn-eliminar {
    display: inline-block !important;
    line-height: 1 !important;
    height: 24px !important;
    width: 24px !important;
    min-height: 24px !important;
    min-width: 24px !important;
    border-radius: 4px !important;
    padding: 0 !important;
    text-align: center !important;
}

.btn-editar {
    background-color: #3b82f6 !important;
    margin-right: 8px !important;
}

.btn-eliminar {
    background-color: #ef4444 !important;
}

/* Forzar estilo en los iconos SVG */
.btn-editar svg, .btn-eliminar svg {
    display: block !important;
    height: 18px !important;
    width: 18px !important;
    min-height: 18px !important;
    min-width: 18px !important;
    margin: 3px auto !important;
    color: white !important;
    stroke: white !important;
}

/* Estilo para el contenedor de botones */
td .flex.justify-center.space-x-2 {
    display: flex !important;
    gap: 8px !important; 
    min-width: 70px !important;
}

/* Estilos específicos para las celdas de la tabla */
td.whitespace-nowrap:last-child {
    width: 100px !important;
    min-width: 100px !important;
    max-width: 100px !important;
    text-align: center !important;
    padding: 8px !important;
}

/* Forzar ancho mínimo de celda para todas las columnas */
td.whitespace-nowrap {
    min-width: 80px !important;
}

/* Estilos para las tarjetas en móvil */
.md\\:hidden .btn-editar,
.md\\:hidden .btn-eliminar {
    width: 36px !important;
    height: 36px !important;
    min-width: 36px !important;
    min-height: 36px !important;
}

.md\\:hidden .btn-editar svg,
.md\\:hidden .btn-eliminar svg {
    height: 24px !important;
    width: 24px !important;
    min-height: 24px !important;
    min-width: 24px !important;
    margin: 6px auto !important;
}

/* =========== ESTILOS PARA SELECTS =========== */
/* Estilos generales para los selects */
select.rounded-md option {
    background-color: white !important;
    padding: 8px !important;
}

select {
    background-color: white !important;
    -webkit-appearance: menulist !important;
    appearance: menulist !important;
    border: 1px solid #d1d5db !important;
}

/* Cuando los selects están enfocados */
select:focus {
    background-color: white !important;
    border-color: #8b5cf6 !important;
}

/* Cuando los selects están deshabilitados */
select:disabled {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
}

/* Forzar visibilidad de los elementos del select */
#empresa_id, #categoria_id, #subcategoria_id, #horario {
    background-color: white !important;
    border: 1px solid #d1d5db !important;
    -webkit-appearance: menulist !important;
    appearance: menulist !important;
}

#empresa_id option, #categoria_id option, #subcategoria_id option, #horario option {
    background-color: white !important;
    padding: 8px !important;
}

/* Estilos para asegurar que los selects siempre sean visibles */
.select-visible,
.select-visible option {
    background-color: white !important;
}

/* Reglas específicas para selects */
select.w-full,
select.w-full option {
    background-color: white !important;
}

/* Forzar modo de selección nativo */
@media screen and (-webkit-min-device-pixel-ratio:0) {
    select,
    select:focus,
    select:hover {
        -webkit-appearance: menulist !important;
        appearance: menulist !important;
    }
}

/* Reglas para Firefox */
@-moz-document url-prefix() {
    select {
        -moz-appearance: menulist !important;
        text-indent: 0.01px;
        text-overflow: '';
    }
}
</style>
@endpush 