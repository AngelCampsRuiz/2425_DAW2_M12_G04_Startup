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
    let initialized = false;
    let publicacionId = null;
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded evento disparado');
        
        // Esperar un poco para que todo se cargue completamente
        setTimeout(() => {
            console.log('Iniciando configuración de elementos');
            
            // Inicialización de botones solo una vez
            if (!initialized) {
                try {
                    setupEventListeners();
                    setupSubcategorias();
                    
                    // Dar tiempo adicional para que los selects estén completamente cargados
                    setTimeout(() => {
                        fixSelectStyles();
                        console.log('Estilos de selects aplicados');
                        
                        // Verificación de empresa después de establecer estilos
                        const empresaSelect = document.getElementById('empresa_id');
                        if (empresaSelect) {
                            console.log('Estado de empresa_id después de inicialización:', 
                                'valor:', empresaSelect.value, 
                                'opciones:', empresaSelect.options.length);
                        }
                    }, 200);
                    
                    initialized = true;
                } catch (error) {
                    console.error('Error durante la inicialización:', error);
                }
            }
        }, 100);
    });
    
    // Configura todos los listeners una sola vez
    function setupEventListeners() {
        // Cerrar modales
        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('modal-publicacion').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar').addEventListener('click', function() {
            document.getElementById('modal-publicacion').classList.add('hidden');
        });
        
        document.getElementById('modal-eliminar-close').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        // Delegación de eventos para los botones dinámicos
        document.addEventListener('click', function(e) {
            // Botón Crear
            if (e.target.closest('.btn-crear')) {
                mostrarFormularioCrear();
            }
            
            // Botones Editar
            if (e.target.closest('.btn-editar')) {
                const btn = e.target.closest('.btn-editar');
                const id = btn.getAttribute('data-id');
                mostrarFormularioEditar(id);
            }
            
            // Botones Eliminar
            if (e.target.closest('.btn-eliminar')) {
                const btn = e.target.closest('.btn-eliminar');
                const id = btn.getAttribute('data-id');
                mostrarModalEliminar(id);
            }
            
            // Enlaces de paginación
            if (e.target.closest('.pagination-link')) {
                e.preventDefault();
                const link = e.target.closest('.pagination-link');
                actualizarTabla(link.getAttribute('href'));
            }
        });
        
        // Envío del formulario de crear/editar - Una sola vez
        document.getElementById('form-publicacion').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Verificar que haya una empresa seleccionada
            const empresaSelect = document.getElementById('empresa_id');
            if (empresaSelect && (!empresaSelect.value || empresaSelect.value === "")) {
                // Mostrar error específico para empresa
                const displayElement = document.getElementById('selected-empresa-display');
                if (displayElement) {
                    displayElement.textContent = "ERROR: Debes seleccionar una empresa";
                    displayElement.style.color = 'red';
                    displayElement.style.fontWeight = 'bold';
                }
                
                empresaSelect.style.borderColor = 'red';
                empresaSelect.style.borderWidth = '2px';
                
                // Mostrar mensaje de error general
                mostrarErrores({
                    'empresa_id': ['Debes seleccionar una empresa válida']
                });
                
                console.error('Error de validación: Empresa no seleccionada');
                return false;
            }
            
            // Evitar envíos duplicados
            if (isSubmitting) return;
            isSubmitting = true;
            
            // Registrar lo que se va a enviar
            console.log('Enviando formulario con empresa_id:', empresaSelect.value);
            
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            const method = document.getElementById('form_method').value;
            
            // Deshabilitar botones durante la petición
            document.getElementById('btn-guardar').disabled = true;
            
            fetch(url, {
                method: method === 'PUT' ? 'POST' : 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-publicacion').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTabla();
                } else if (data.errors) {
                    mostrarErrores(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isSubmitting = false;
                document.getElementById('btn-guardar').disabled = false;
            });
        });
        
        // Envío del formulario de eliminar - Una sola vez
        document.getElementById('form-eliminar').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Evitar envíos duplicados
            if (isSubmitting) return;
            isSubmitting = true;
            
            const url = this.getAttribute('action');
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTabla();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isSubmitting = false;
            });
        });
    }
    
    // Funciones principales
    function mostrarFormularioCrear() {
        // Resetear el formulario
        document.getElementById('form-publicacion').reset();
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('publicacion_id').value = '';
        document.getElementById('form_method').value = 'POST';
        
        // Configurar la acción del formulario
        document.getElementById('form-publicacion').setAttribute('action', '{{ route("admin.publicaciones.store") }}');
        
        // Cambiar el título del modal
        document.getElementById('modal-titulo').textContent = 'Crear Nueva Publicación';
        
        // Mostrar el modal
        document.getElementById('modal-publicacion').classList.remove('hidden');
        
        // Forzar estilos después de que el modal es visible
        setTimeout(() => {
            fixSelectStyles();
            
            // Verificar valores de selects
            const empresaSelect = document.getElementById('empresa_id');
            if (empresaSelect) {
                console.log('Estado antes de modificación:', 
                    'valor:', empresaSelect.value, 
                    'opciones:', empresaSelect.options.length);
                
                // Limpiar selección actual
                empresaSelect.selectedIndex = 0;
                
                // Forzar un evento change para actualizar el indicador
                const changeEvent = new Event('change');
                empresaSelect.dispatchEvent(changeEvent);
                
                console.log('Estado después de reset:', 
                    'valor:', empresaSelect.value, 
                    'selectedIndex:', empresaSelect.selectedIndex);
            }
            
            // Resetear el campo de subcategoría
            const categoriaSelect = document.getElementById('categoria_id');
            if (categoriaSelect) {
                categoriaSelect.selectedIndex = 0;
                const changeEvent = new Event('change');
                categoriaSelect.dispatchEvent(changeEvent);
            }
        }, 300);
    }
    
    /**
     * Obtiene los datos de una publicación para editar
     */
    function mostrarFormularioEditar(id) {
        document.getElementById('modal-titulo').textContent = 'Editar Publicación';
        document.getElementById('publicacion_id').value = id;
        document.getElementById('form_method').value = 'PUT';
        document.getElementById('form-publicacion').action = `/admin/publicaciones/${id}`;
        
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
            // La subcategoría se cargará por el evento
            document.getElementById('horario').value = publicacion.horario;
            document.getElementById('horas_totales').value = publicacion.horas_totales;
            document.getElementById('fecha_publicacion').value = publicacion.fecha_publicacion ? publicacion.fecha_publicacion.split('T')[0] : '';
            document.getElementById('descripcion').value = publicacion.descripcion;
            document.getElementById('activa').checked = publicacion.activa ? true : false;
            
            // Disparar evento para cargar subcategorías
            document.dispatchEvent(new CustomEvent('editPublicacion', { 
                detail: {
                    categoria_id: publicacion.categoria_id,
                    subcategoria_id: publicacion.subcategoria_id
                }
            }));
            
            document.getElementById('modal-publicacion').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la publicación');
        });
    }
    
    function mostrarModalEliminar(id) {
        // Configurar el formulario
        document.getElementById('eliminar_id').value = id;
        document.getElementById('form-eliminar').setAttribute('action', `/admin/publicaciones/${id}`);
        
        // Mostrar el modal
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    // Funciones auxiliares para mostrar mensajes y errores
    window.mostrarMensajeExito = function(mensaje) {
        const messageElement = document.getElementById('success-message');
        const messageText = document.getElementById('success-message-text');
        
        messageText.textContent = mensaje;
        messageElement.style.display = 'block';
        
        setTimeout(function() {
            messageElement.style.display = 'none';
        }, 5000);
    };
    
    // Mostrar errores específicos en los campos correspondientes
    function mostrarErroresEnCampos(errores) {
        // Restablecer todos los bordes y mensajes de error
        const campos = ['titulo', 'descripcion', 'empresa_id', 'categoria_id', 'subcategoria_id', 'horario', 'horas_totales', 'fecha_publicacion'];
        campos.forEach(campo => {
            const elemento = document.getElementById(campo);
            if (elemento) {
                elemento.classList.remove('border-red-500');
                
                // Eliminar mensaje de error anterior si existe
                const mensajeAnterior = document.querySelector(`#error-${campo}`);
                if (mensajeAnterior) mensajeAnterior.remove();
            }
        });
        
        // Mostrar errores específicos
        for (const campo in errores) {
            const elemento = document.getElementById(campo);
            if (elemento) {
                elemento.classList.add('border-red-500');
                
                // Crear mensaje de error debajo del campo
                const mensajeError = document.createElement('p');
                mensajeError.id = `error-${campo}`;
                mensajeError.className = 'mt-1 text-sm text-red-600';
                mensajeError.textContent = errores[campo][0];
                
                // Insertar después del elemento o su padre
                if (elemento.parentNode) {
                    elemento.parentNode.appendChild(mensajeError);
                }
                
                // Resaltar visualmente el select de empresa si hay error
                if (campo === 'empresa_id') {
                    console.error('Error en empresa_id:', errores[campo]);
                    elemento.style.borderColor = 'red';
                    elemento.style.borderWidth = '2px';
                }
            }
        }
    }
    
    // Funciones de actualización de tabla
    window.actualizarTabla = function(url = '{{ route('admin.publicaciones.index') }}') {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('tabla-container').innerHTML = data.tabla;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    // Función para cargar subcategorías basadas en la categoría seleccionada
    function setupSubcategorias() {
        const categoriaSelect = document.getElementById('categoria_id');
        const subcategoriaSelect = document.getElementById('subcategoria_id');
        
        if (categoriaSelect && subcategoriaSelect) {
            // Función para resetear el select de subcategorías
            function resetSubcategoriaSelect(text = 'Selecciona primero una categoría') {
                subcategoriaSelect.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = text;
                defaultOption.style.color = 'black';
                defaultOption.style.backgroundColor = 'white';
                defaultOption.setAttribute('style', 'color: black !important; background-color: white !important;');
                subcategoriaSelect.appendChild(defaultOption);
            }
            
            // Función para cargar subcategorías por AJAX
            async function cargarSubcategorias(categoriaId) {
                if (!categoriaId) {
                    resetSubcategoriaSelect();
                    return;
                }
                
                resetSubcategoriaSelect('Cargando subcategorías...');
                
                try {
                    const response = await fetch(`/admin/subcategorias/por-categoria/${categoriaId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Error ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    
                    resetSubcategoriaSelect('Selecciona una subcategoría');
                    
                    if (data.subcategorias && data.subcategorias.length > 0) {
                        data.subcategorias.forEach(subcategoria => {
                            const option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.textContent = subcategoria.nombre_subcategoria;
                            option.style.color = 'black';
                            option.style.backgroundColor = 'white';
                            option.setAttribute('style', 'color: black !important; background-color: white !important;');
                            subcategoriaSelect.appendChild(option);
                        });
                    } else {
                        resetSubcategoriaSelect('No hay subcategorías disponibles');
                    }
                } catch (error) {
                    console.error('Error al cargar subcategorías:', error);
                    resetSubcategoriaSelect('Error al cargar subcategorías');
                }
            }
            
            // Evento al cambiar la categoría
            categoriaSelect.addEventListener('change', function() {
                cargarSubcategorias(this.value);
            });
            
            // Si ya hay una categoría seleccionada, cargar sus subcategorías
            if (categoriaSelect.value) {
                cargarSubcategorias(categoriaSelect.value);
            }
            
            // Cuando se abre el modal para editar, cargar las subcategorías
            document.addEventListener('editPublicacion', function(e) {
                if (e.detail && e.detail.categoria_id) {
                    setTimeout(() => {
                        cargarSubcategorias(e.detail.categoria_id);
                        // Seleccionar la subcategoría después de cargar las opciones
                        setTimeout(() => {
                            if (e.detail.subcategoria_id) {
                                subcategoriaSelect.value = e.detail.subcategoria_id;
                            }
                        }, 500);
                    }, 100);
                }
            });
        }
    }

    // Función para aplicar estilos a los select
    function fixSelectStyles() {
        try {
            // Verificar que los elementos existan antes de intentar acceder
            const selects = document.querySelectorAll('#modal-publicacion select');
            if (!selects || selects.length === 0) {
                console.log("No se encontraron selects o el modal no está visible");
                return;
            }
            
            // Aplicar estilos a todos los select
            selects.forEach(select => {
                // Aplicar estilo al select
                select.style.backgroundColor = 'white';
                select.style.webkitAppearance = 'menulist';
                select.style.appearance = 'menulist';
                
                // Aplicar estilos a las opciones
                if (select.options && select.options.length > 0) {
                    Array.from(select.options).forEach(option => {
                        option.style.backgroundColor = 'white';
                        option.style.padding = '8px';
                    });
                }
            });
            
            // Verificación específica para empresa_id
            const empresaSelect = document.getElementById('empresa_id');
            if (empresaSelect) {
                // Asegurar que el estilo del select de empresa sea visible
                empresaSelect.style.backgroundColor = 'white';
                empresaSelect.style.webkitAppearance = 'menulist';
                empresaSelect.style.appearance = 'menulist';
                console.log("Empresa select encontrado y estilos aplicados");
                
                // Revisar el valor seleccionado
                logEmpresaSelection();
            } else {
                console.log("Empresa select no encontrado");
            }
        } catch (error) {
            console.error("Error en fixSelectStyles:", error);
        }
    }
    
    // Función para registrar la selección de empresa
    function logEmpresaSelection() {
        try {
            const empresaSelect = document.getElementById('empresa_id');
            if (empresaSelect) {
                console.log("Empresa seleccionada:", empresaSelect.value);
                console.log("Texto de la opción:", empresaSelect.options[empresaSelect.selectedIndex]?.text || "No hay opción seleccionada");
            }
        } catch (error) {
            console.error("Error al registrar selección de empresa:", error);
        }
    }

    window.mostrarErrores = function(errores) {
        // Llamar a la nueva función para mantener compatibilidad
        mostrarErroresEnCampos(errores);
        
        // También mostrar errores en el contenedor general
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        errorsList.innerHTML = '';
        
        for (const key in errores) {
            errores[key].forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorsList.appendChild(li);
            });
        }
        
        errorsDiv.classList.remove('hidden');
    };

    // Cerrar modales al hacer clic fuera de ellos
    document.querySelectorAll('#formModal, #eliminarModal, #eliminarSqlModal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    });

    // Cuando se abre el modal para crear o editar, aplicar los estilos a los select
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar estilos a los select cuando se carga la página
        document.querySelectorAll('.btn-crear, .btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                // Esperar a que el modal se abra
                setTimeout(function() {
                    fixSelectStyles();
                }, 200);
            });
        });
        
        // Cuando cambia el valor de empresa_id, registrar la selección
        document.body.addEventListener('change', function(event) {
            if (event.target && event.target.id === 'empresa_id') {
                logEmpresaSelection();
            }
        });
        
        // Agregar un observer para detectar cambios en el formulario
        const modalContent = document.querySelector('#modal-publicacion .modal-content');
        if (modalContent) {
            const observer = new MutationObserver(function() {
                fixSelectStyles();
            });
            observer.observe(modalContent, { childList: true, subtree: true });
        }
    });

    // Función para preparar el formulario antes de enviarlo
    function prepareFormSubmit(e) {
        e.preventDefault();
        
        // Verificar que la empresa esté seleccionada
        const empresaSelect = document.getElementById('empresa_id');
        if (!empresaSelect.value) {
            // Resaltar error
            empresaSelect.classList.add('border-red-500');
            const feedbackEl = document.getElementById('empresa-feedback');
            if (feedbackEl) {
                feedbackEl.textContent = 'Debes seleccionar una empresa';
                feedbackEl.classList.add('text-red-500');
            }
            
            // Forzar la selección de la primera empresa si hay opciones disponibles
            if (empresaSelect.options.length > 1) {
                empresaSelect.selectedIndex = 1;
                console.log("Seleccionando automáticamente la primera empresa:", empresaSelect.value);
            } else {
                console.error("No hay empresas disponibles para seleccionar");
                return false;
            }
        }
        
        // Continuar con el envío normal
        submitForm(e.target);
        return false;
    }

    // Al abrir el modal para crear
    document.querySelector('.btn-crear').addEventListener('click', function() {
        resetForm();
        document.getElementById('modal-title').textContent = 'Crear Publicación';
        document.getElementById('form-publicacion').dataset.action = 'create';
        document.getElementById('modal-publicacion').classList.remove('hidden');
        document.getElementById('modal-publicacion').classList.add('block');
        
        // Asegurarse de que los selects sean visibles
        setTimeout(function() {
            fixSelectStyles();
            
            // Asegurar que haya una empresa seleccionada por defecto
            const empresaSelect = document.getElementById('empresa_id');
            if (empresaSelect && empresaSelect.options.length > 1 && !empresaSelect.value) {
                empresaSelect.selectedIndex = 1; // Seleccionar la primera empresa real
                console.log("Empresa seleccionada por defecto:", empresaSelect.value);
            }
        }, 200);
    });

    // Asociar el evento submit al formulario directamente con la nueva función
    document.getElementById('form-publicacion').addEventListener('submit', prepareFormSubmit);

    // Función para cargar los datos de una publicación en el formulario para editar
    function editPublication(id) {
        resetForm();
        document.getElementById('modal-titulo').textContent = 'Editar Publicación';
        document.getElementById('form-publicacion').dataset.action = 'edit';
        document.getElementById('form-publicacion').dataset.publicacionId = id;
        
        // Aplicar estilos directamente antes de mostrar el modal
        const empresaSelect = document.getElementById('empresa_id');
        if (empresaSelect) {
            // Aplicar estilos directamente
            empresaSelect.style.backgroundColor = 'white';
            empresaSelect.style.webkitAppearance = 'menulist';
            empresaSelect.style.appearance = 'menulist';
            
            // Aplicar estilos a las opciones
            Array.from(empresaSelect.options).forEach(option => {
                option.style.backgroundColor = 'white';
                option.style.padding = '8px';
            });
        }
        
        // Mostrar el modal
        const modal = document.getElementById('modal-publicacion');
        modal.classList.remove('hidden');
        modal.classList.add('block');
        
        // Aplicar estilos inmediatamente después de mostrar el modal
        fixSelectStyles();
        
        fetch(`/admin/publicaciones/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const publicacion = data.publicacion;
            
            console.log('Datos de publicación recibidos:', publicacion);
            
            document.getElementById('titulo').value = publicacion.titulo;
            
            // Cargar la empresa_id si existe
            if (publicacion.empresa_id && empresaSelect) {
                console.log('Empresa ID a seleccionar:', publicacion.empresa_id);
                console.log('Nombre empresa:', publicacion.empresa?.user?.nombre || 'No disponible');
                
                // Asegurarse de que la opción existe en el select antes de seleccionarla
                const empresaOption = Array.from(empresaSelect.options).find(option => option.value == publicacion.empresa_id);
                
                if (empresaOption) {
                    empresaSelect.value = publicacion.empresa_id;
                    console.log(`Empresa seleccionada correctamente: ${publicacion.empresa_id}`);
                } else {
                    console.warn(`La empresa con ID ${publicacion.empresa_id} no existe en el select.`);
                    // Seleccionar la primera opción disponible como fallback
                    if (empresaSelect.options.length > 1) {
                        empresaSelect.selectedIndex = 1;
                        console.log("Seleccionando la primera empresa disponible:", empresaSelect.value);
                    }
                }
            }
            
            // Resto del código
            document.getElementById('categoria_id').value = publicacion.categoria_id;
            document.getElementById('horario').value = publicacion.horario || 'mañana';
            document.getElementById('horas_totales').value = publicacion.horas_totales;
            document.getElementById('fecha_publicacion').value = publicacion.fecha_publicacion ? publicacion.fecha_publicacion.split('T')[0] : '';
            document.getElementById('descripcion').value = publicacion.descripcion;
            document.getElementById('activa').checked = publicacion.activa ? true : false;
            
            // Disparar evento para cargar subcategorías
            document.dispatchEvent(new CustomEvent('editPublicacion', { 
                detail: {
                    categoria_id: publicacion.categoria_id,
                    subcategoria_id: publicacion.subcategoria_id
                }
            }));
            
            // Aplicar estilos nuevamente después de cargar los datos
            setTimeout(() => {
                fixSelectStyles();
                
                // Forzar estilos a empresa_id nuevamente
                if (empresaSelect) {
                    // Si hay un id de empresa pero no se seleccionó correctamente
                    if (publicacion.empresa_id && empresaSelect.value !== publicacion.empresa_id.toString()) {
                        console.log("Corrigiendo selección de empresa:", publicacion.empresa_id);
                        empresaSelect.value = publicacion.empresa_id;
                    }
                    
                    // Aplicar estilos directamente
                    empresaSelect.style.backgroundColor = 'white';
                    empresaSelect.style.webkitAppearance = 'menulist';
                    empresaSelect.style.appearance = 'menulist';
                    
                    // Aplicar estilos a las opciones
                    Array.from(empresaSelect.options).forEach(option => {
                        option.style.backgroundColor = 'white';
                        option.style.padding = '8px';
                    });
                    
                    // Imprimir la opción seleccionada para depuración
                    const selectedOption = empresaSelect.options[empresaSelect.selectedIndex];
                    console.log("Empresa seleccionada:", 
                        "ID:", empresaSelect.value, 
                        "Texto:", selectedOption ? selectedOption.text : "No seleccionada");
                }
            }, 300);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la publicación');
        });
    }

    // Función para resetear el formulario
    function resetForm() {
        document.getElementById('form-publicacion').reset();
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('error-list').innerHTML = '';
        
        // Limpiar mensajes de error específicos
        const campos = ['titulo', 'descripcion', 'empresa_id', 'categoria_id', 'subcategoria_id', 'horario', 'horas_totales', 'fecha_publicacion'];
        campos.forEach(campo => {
            const elemento = document.getElementById(campo);
            if (elemento) {
                elemento.classList.remove('border-red-500');
                
                // Eliminar mensaje de error anterior si existe
                const mensajeAnterior = document.querySelector(`#error-${campo}`);
                if (mensajeAnterior) mensajeAnterior.remove();
            }
        });
        
        // Establecer fecha actual
        document.getElementById('fecha_publicacion').value = new Date().toISOString().split('T')[0];
        
        // Resetear el select de subcategoría
        const subcategoriaSelect = document.getElementById('subcategoria_id');
        if (subcategoriaSelect) {
            subcategoriaSelect.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Selecciona primero una categoría';
            defaultOption.style.backgroundColor = 'white';
            defaultOption.style.color = 'black';
            defaultOption.style.padding = '8px';
            subcategoriaSelect.appendChild(defaultOption);
        }
    }

    // Asegurar que las empresas son visibles en el modal
    document.addEventListener('DOMContentLoaded', function() {
        // Escuchar cambios en cualquier modal que pueda abrirse
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const node = mutation.target;
                    if (node.classList.contains('block') && !node.classList.contains('hidden')) {
                        console.log('Modal abierto detectado, aplicando estilos...');
                        // Aplicar estilos a selects inmediatamente
                        setTimeout(function() {
                            const selects = node.querySelectorAll('select');
                            selects.forEach(function(select) {
                                // Forzar estilos en el select
                                select.style.backgroundColor = 'white';
                                select.style.webkitAppearance = 'menulist';
                                select.style.appearance = 'menulist';
                                
                                // Forzar estilos en cada opción
                                Array.from(select.options).forEach(option => {
                                    option.style.backgroundColor = 'white';
                                    option.style.padding = '8px';
                                });
                            });
                        }, 100);
                    }
                }
            });
        });
        
        // Observar cambios en modales
        const modales = document.querySelectorAll('.fixed.inset-0');
        modales.forEach(function(modal) {
            observer.observe(modal, { attributes: true });
        });
        
        // Agregar listener para botón de crear
        document.querySelectorAll('.btn-crear').forEach(function(btn) {
            btn.addEventListener('click', function() {
                console.log('Botón crear clickeado');
                mostrarFormularioCrear();
            });
        });
    });
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