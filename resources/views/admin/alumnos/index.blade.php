@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.alumnos.tabla')
    </div>

    <!-- Modal Crear/Editar Alumno -->
    <div id="modal-alumno" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-titulo" class="text-xl font-semibold">Crear Nuevo Alumno</h2>
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
            
            <form id="form-alumno" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="alumno_id" name="alumno_id" value="">
                <input type="hidden" id="form_method" name="_method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password" id="password" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                        <p class="password-help text-xs text-gray-500 mt-1 hidden">Dejar en blanco para mantener la contraseña actual</p>
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIE <span class="text-red-500">*</span></label>
                        <input type="text" name="dni" id="dni" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               required>
                    </div>
                    
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="sitio_web" class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
                        <input type="url" name="sitio_web" id="sitio_web" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                               placeholder="https://...">
                    </div>
                    
                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Fotografía</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <div id="imagen-preview" class="mt-2 hidden">
                            <img id="imagen-preview-img" src="" alt="Vista previa" class="h-24 w-auto object-cover rounded">
                            <button type="button" id="eliminar-imagen" class="text-xs text-red-600 mt-1">Eliminar imagen</button>
                        </div>
                    </div>
                    
                    <div id="activo-container" class="col-span-2 flex items-center hidden">
                        <input type="checkbox" name="activo" id="activo" value="1"
                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <label for="activo" class="ml-2 text-sm font-medium text-gray-700">Cuenta Activa</label>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"></textarea>
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
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar este alumno? Esta acción no se puede deshacer.</p>
            
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
    });
    
    function setupEventListeners() {
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
        });
        
        // Cerrar modales
        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('modal-alumno').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar').addEventListener('click', function() {
            document.getElementById('modal-alumno').classList.add('hidden');
        });
        
        document.getElementById('modal-eliminar-close').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        document.getElementById('btn-cancelar-eliminar').addEventListener('click', function() {
            document.getElementById('modal-eliminar').classList.add('hidden');
        });
        
        // Manejo de la previsualización de la foto
        document.getElementById('imagen').addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagen-preview-img').src = e.target.result;
                    document.getElementById('imagen-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Eliminar foto
        document.getElementById('eliminar-imagen').addEventListener('click', function() {
            document.getElementById('imagen').value = '';
            document.getElementById('imagen-preview').classList.add('hidden');
            document.getElementById('imagen-preview-img').src = '';
            // Agregar campo oculto para indicar que se debe eliminar la foto existente
            const inputEliminarImagen = document.getElementById('eliminar_imagen_actual') || document.createElement('input');
            inputEliminarImagen.type = 'hidden';
            inputEliminarImagen.id = 'eliminar_imagen_actual';
            inputEliminarImagen.name = 'eliminar_imagen_actual';
            inputEliminarImagen.value = '1';
            document.getElementById('form-alumno').appendChild(inputEliminarImagen);
        });
        
        // Envío del formulario
        document.getElementById('form-alumno').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Evitar envíos duplicados
            if (isSubmitting) return;
            isSubmitting = true;
            
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            const method = document.getElementById('form_method').value;
            
            // Incluir método PUT para ediciones
            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }
            
            // Deshabilitar botones durante la petición
            document.getElementById('btn-guardar').disabled = true;
            
            fetch(url, {
                method: 'POST', // Siempre POST para enviar archivos
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modal-alumno').classList.add('hidden');
                    mostrarMensajeExito(data.message);
                    actualizarTablaAlumnos();
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
        
        // Envío del formulario de eliminar
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
                    actualizarTablaAlumnos();
                } else {
                    alert(data.message || 'Error al eliminar el alumno');
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
    
    function mostrarFormularioCrear() {
        // Resetear el formulario
        document.getElementById('form-alumno').reset();
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('alumno_id').value = '';
        document.getElementById('form_method').value = 'POST';
        
        // Configurar la acción del formulario
        document.getElementById('form-alumno').setAttribute('action', '{{ route("admin.alumnos.store") }}');
        
        // Configurar campo de contraseña como obligatorio
        document.querySelector('.password-required').classList.remove('hidden');
        document.querySelector('.password-help').classList.add('hidden');
        document.getElementById('password').setAttribute('required', 'required');
        document.getElementById('password_confirmation').setAttribute('required', 'required');
        
        // Resetear campo de foto
        document.getElementById('imagen-preview').classList.add('hidden');
        document.getElementById('imagen-preview-img').src = '';
        
        // Eliminar campo oculto de eliminar foto si existe
        const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
        if (eliminarImagenInput) {
            eliminarImagenInput.remove();
        }
        
        // Ocultar el checkbox de activo para nuevos alumnos
        document.getElementById('activo-container').classList.add('hidden');
        
        // Cambiar el título del modal
        document.getElementById('modal-titulo').textContent = 'Crear Nuevo Alumno';
        
        // Mostrar el modal
        document.getElementById('modal-alumno').classList.remove('hidden');
    }
    
    function mostrarFormularioEditar(id) {
        document.getElementById('modal-titulo').textContent = 'Editar Alumno';
        document.getElementById('alumno_id').value = id;
        document.getElementById('form_method').value = 'PUT';
        document.getElementById('form-alumno').action = `/admin/alumnos/${id}`;
        
        // Configurar campo de contraseña como opcional
        document.querySelector('.password-required').classList.add('hidden');
        document.querySelector('.password-help').classList.remove('hidden');
        document.getElementById('password').removeAttribute('required');
        document.getElementById('password_confirmation').removeAttribute('required');
        
        // Mostrar el checkbox de activo para alumnos existentes
        document.getElementById('activo-container').classList.remove('hidden');
        
        // Eliminar campo oculto de eliminar foto si existe
        const eliminarImagenInput = document.getElementById('eliminar_imagen_actual');
        if (eliminarImagenInput) {
            eliminarImagenInput.remove();
        }
        
        fetch(`/admin/alumnos/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const alumno = data.alumno;
            
            document.getElementById('nombre').value = alumno.nombre || '';
            document.getElementById('email').value = alumno.email || '';
            document.getElementById('password').value = ''; // No mostrar contraseña
            document.getElementById('dni').value = alumno.dni || '';
            document.getElementById('telefono').value = alumno.telefono || '';
            document.getElementById('ciudad').value = alumno.ciudad || '';
            document.getElementById('fecha_nacimiento').value = alumno.fecha_nacimiento ? alumno.fecha_nacimiento.split('T')[0] : '';
            document.getElementById('sitio_web').value = alumno.sitio_web || '';
            document.getElementById('descripcion').value = alumno.descripcion || '';
            document.getElementById('activo').checked = alumno.activo ? true : false;
            
            // Cargar y mostrar foto si existe
            if (alumno.imagen) {
                document.getElementById('imagen-preview-img').src = `/public/profile_images/${alumno.imagen}`;
                document.getElementById('imagen-preview').classList.remove('hidden');
            } else {
                document.getElementById('imagen-preview').classList.add('hidden');
                document.getElementById('imagen-preview-img').src = '';
            }
            
            document.getElementById('modal-alumno').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos del alumno');
        });
    }
    
    function mostrarModalEliminar(id) {
        // Configurar el formulario
        document.getElementById('eliminar_id').value = id;
        document.getElementById('form-eliminar').setAttribute('action', `/admin/alumnos/${id}`);
        
        // Mostrar el modal
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    function mostrarModalEliminarSQL(id) {
        const modal = document.getElementById('eliminarSqlModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        const btnConfirmar = modal.querySelector('.confirmar-eliminar-sql');
        btnConfirmar.onclick = function() {
            eliminarAlumnoSQL(id);
        };
        
        const btnCerrar = modal.querySelector('.cerrar-modal');
        btnCerrar.onclick = function() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };
    }
    
    function eliminarAlumnoSQL(id) {
        if (isSubmitting) return;
        isSubmitting = true;
        
        fetch(`/admin/alumnos/eliminar-sql/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('eliminarSqlModal').classList.add('hidden');
            document.getElementById('eliminarSqlModal').classList.remove('flex');
            
            if (data.success) {
                mostrarMensajeExito(data.message);
                actualizarTablaAlumnos();
            } else {
                alert(data.message || 'Error al eliminar el alumno mediante SQL');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        })
        .finally(() => {
            isSubmitting = false;
        });
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
    
    function mostrarErrores(errores) {
        const errorsDiv = document.getElementById('form-errors');
        const errorsList = document.getElementById('error-list');
        
        errorsList.innerHTML = '';
        
        for (const key in errores) {
            errores[key].forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorsList.appendChild(li);
            });
            
            // Resaltar campo con error
            const campo = document.getElementById(key);
            if (campo) {
                campo.classList.add('border-red-500');
            }
        }
        
        errorsDiv.classList.remove('hidden');
    }
    
    function actualizarTablaAlumnos(url = '{{ route("admin.alumnos.index") }}') {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.tabla) {
                document.getElementById('tabla-container').innerHTML = data.tabla;
            } else {
                console.error('No se recibió contenido HTML para la tabla');
            }
        })
        .catch(error => {
            console.error('Error al actualizar la tabla:', error);
        });
    }
</script>

<style>
/* Asegurar que los botones de acción siempre estén visibles */
.btn-editar, .btn-eliminar {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-height: 32px !important;
    min-width: 32px !important;
}

/* Aplicar estilos a los campos de formulario con error */
.border-red-500 {
    border-color: #f56565 !important;
}

/* Estilos para las tarjetas en móvil */
@media (max-width: 768px) {
    .md\:hidden .btn-editar,
    .md\:hidden .btn-eliminar {
        width: 40px !important;
        height: 40px !important;
    }
}
</style>
@endpush 