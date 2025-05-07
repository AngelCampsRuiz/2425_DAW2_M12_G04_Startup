@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Profesores</h1>
        <button id="btnCrearProfesor" class="btn-crear bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            Crear Profesor
        </button>
    </div>

    <div id="tabla-profesores">
        @include('admin.profesores.tabla')
    </div>

    <!-- Modal para crear/editar profesor -->
    <div id="modal-profesor" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modal-title" class="text-xl font-semibold">Crear Nuevo Profesor</h2>
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
            
            <form id="form-profesor" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form_method" value="POST">
                <input type="hidden" name="profesor_id" id="profesor_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <p class="password-help text-xs text-gray-500 mt-1 hidden">Dejar en blanco para mantener la contraseña actual</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña <span class="password-required text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI <span class="text-red-500">*</span></label>
                        <input type="text" name="dni" id="dni" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
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
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen de Perfil</label>
                        <input type="file" name="imagen" id="imagen" accept="image/*"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                        <div id="imagen-preview" class="mt-2 hidden">
                            <img id="imagen-preview-img" src="" alt="Vista previa" class="h-24 w-auto object-cover rounded">
                            <button type="button" id="eliminar-imagen" class="text-xs text-red-600 mt-1">Eliminar imagen</button>
                        </div>
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
            
            <p class="mb-6">¿Estás seguro de que deseas eliminar este profesor? Esta acción no se puede deshacer.</p>
            
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
        const btnCrear = document.querySelector('.btn-crear');
        if (btnCrear) {
            btnCrear.addEventListener('click', mostrarFormularioCrear);
        }
        
        // Los botones de editar y eliminar se manejan con delegación de eventos
        document.querySelector('#tabla-profesores').addEventListener('click', function(e) {
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
        const modalClose = document.getElementById('modal-close');
        if (modalClose) {
            modalClose.addEventListener('click', function() {
                document.getElementById('modal-profesor').classList.add('hidden');
            });
        }
        
        const btnCancelar = document.getElementById('btn-cancelar');
        if (btnCancelar) {
            btnCancelar.addEventListener('click', function() {
                document.getElementById('modal-profesor').classList.add('hidden');
            });
        }
        
        const modalEliminarClose = document.getElementById('modal-eliminar-close');
        if (modalEliminarClose) {
            modalEliminarClose.addEventListener('click', function() {
                document.getElementById('modal-eliminar').classList.add('hidden');
            });
        }
        
        const btnCancelarEliminar = document.getElementById('btn-cancelar-eliminar');
        if (btnCancelarEliminar) {
            btnCancelarEliminar.addEventListener('click', function() {
                document.getElementById('modal-eliminar').classList.add('hidden');
            });
        }
        
        // Manejo de la previsualización de la foto
        const inputImagen = document.getElementById('imagen');
        if (inputImagen) {
            inputImagen.addEventListener('change', function(e) {
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
        }
        
        // Eliminar foto
        const btnEliminarImagen = document.getElementById('eliminar-imagen');
        if (btnEliminarImagen) {
            btnEliminarImagen.addEventListener('click', function() {
                document.getElementById('imagen').value = '';
                document.getElementById('imagen-preview').classList.add('hidden');
                document.getElementById('imagen-preview-img').src = '';
                // Agregar campo oculto para indicar que se debe eliminar la foto existente
                const inputEliminarImagen = document.getElementById('eliminar_imagen_actual') || document.createElement('input');
                inputEliminarImagen.type = 'hidden';
                inputEliminarImagen.id = 'eliminar_imagen_actual';
                inputEliminarImagen.name = 'eliminar_imagen_actual';
                inputEliminarImagen.value = '1';
                document.getElementById('form-profesor').appendChild(inputEliminarImagen);
            });
        }
        
        // Manejar envío del formulario
        const formProfesor = document.getElementById('form-profesor');
        if (formProfesor) {
            formProfesor.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (isSubmitting) return;
                
                // Validar contraseñas
                if (!validarContrasenas()) return;
                
                isSubmitting = true;
                const btnGuardar = document.getElementById('btn-guardar');
                btnGuardar.disabled = true;
                btnGuardar.textContent = 'Guardando...';
                
                try {
                    const formData = new FormData(this);
                    const profesorId = document.getElementById('profesor_id').value;
                    const method = document.getElementById('form_method').value;
                    const url = profesorId ? `/admin/profesores/${profesorId}` : '/admin/profesores';
                    
                    console.log(`Enviando formulario a ${url} con método ${method}, ID: ${profesorId || 'nuevo'}`);
                    
                    const response = await fetch(url, {
                        method: 'POST', // Siempre POST, el método real va en _method
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        mostrarMensajeExito(data.message || 'Profesor guardado correctamente');
                        document.getElementById('modal-profesor').classList.add('hidden');
                        limpiarFormulario();
                        console.log('Formulario procesado correctamente');
                        
                        // Recargamos la página después de un breve retraso
                        setTimeout(() => {
                            window.location.href = window.location.pathname;
                        }, 1000);
                    } else {
                        if (data.errors) {
                            mostrarErroresFormulario(data.errors);
                        } else {
                            mostrarMensajeError(data.message || 'Error al procesar la solicitud');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensajeError('Error al procesar la solicitud');
                } finally {
                    isSubmitting = false;
                    btnGuardar.disabled = false;
                    btnGuardar.textContent = 'Guardar';
                }
            });
        }
        
        // Manejar envío del formulario de eliminación
        const formEliminar = document.getElementById('form-eliminar');
        if (formEliminar) {
            formEliminar.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                if (isSubmitting) return;
                isSubmitting = true;
                
                try {
                    const profesorId = document.getElementById('eliminar_id').value;
                    const url = `/admin/profesores/${profesorId}`;
                    
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        mostrarMensajeExito(data.message || 'Profesor eliminado correctamente');
                        document.getElementById('modal-eliminar').classList.add('hidden');
                        console.log('Profesor eliminado correctamente');
                        
                        // Recargamos la página después de un breve retraso
                        setTimeout(() => {
                            window.location.href = window.location.pathname;
                        }, 1000);
                    } else {
                        mostrarMensajeError(data.message || 'Error al eliminar el profesor');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensajeError('Error al eliminar el profesor');
                } finally {
                    isSubmitting = false;
                }
            });
        }
        
        // Botón de eliminar SQL (fallback)
        document.querySelectorAll('.confirmar-eliminar-sql').forEach(btn => {
            btn.addEventListener('click', async function() {
                const profesorId = document.getElementById('eliminar_id').value;
                try {
                    const response = await fetch(`/admin/profesores/eliminar-sql/${profesorId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        mostrarMensajeExito(data.message || 'Profesor eliminado correctamente (SQL)');
                        document.getElementById('eliminarSqlModal').classList.add('hidden');
                        document.getElementById('modal-eliminar').classList.add('hidden');
                        console.log('Profesor eliminado correctamente (SQL)');
                        
                        // Recargamos la página después de un breve retraso
                        setTimeout(() => {
                            window.location.href = window.location.pathname;
                        }, 1000);
                    } else {
                        mostrarMensajeError(data.message || 'Error al eliminar el profesor');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    mostrarMensajeError('Error al eliminar el profesor mediante SQL');
                }
            });
        });
        
        // Cerrar modal de eliminar SQL
        document.querySelectorAll('.cerrar-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('eliminarSqlModal').classList.add('hidden');
            });
        });
    }
    
    // Funciones auxiliares
    function mostrarFormularioCrear() {
        limpiarFormulario();
        document.getElementById('modal-title').textContent = 'Crear Nuevo Profesor';
        document.getElementById('form_method').value = 'POST';
        document.getElementById('profesor_id').value = '';
        document.querySelector('.password-required').classList.remove('hidden');
        document.querySelector('.password-help').classList.add('hidden');
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
        document.getElementById('modal-profesor').classList.remove('hidden');
    }
    
    async function mostrarFormularioEditar(id) {
        try {
            const response = await fetch(`/admin/profesores/${id}/edit`);
            const data = await response.json();
            
            if (response.ok) {
                const profesor = data.profesor;
                document.getElementById('profesor_id').value = profesor.id;
                document.getElementById('nombre').value = profesor.nombre;
                document.getElementById('email').value = profesor.email;
                document.getElementById('dni').value = profesor.dni;
                document.getElementById('telefono').value = profesor.telefono || '';
                document.getElementById('ciudad').value = profesor.ciudad || '';
                document.getElementById('fecha_nacimiento').value = profesor.fecha_nacimiento || '';
                document.getElementById('sitio_web').value = profesor.sitio_web || '';
                document.getElementById('descripcion').value = profesor.descripcion || '';
                
                // Manejar la imagen
                if (profesor.imagen) {
                    document.getElementById('imagen-preview-img').src = `/public/profile_images/${profesor.imagen}`;
                    document.getElementById('imagen-preview').classList.remove('hidden');
                } else {
                    document.getElementById('imagen-preview').classList.add('hidden');
                }
                
                // Configurar el formulario para edición
                document.getElementById('modal-title').textContent = 'Editar Profesor';
                document.getElementById('form_method').value = 'PUT';
                document.querySelector('.password-required').classList.add('hidden');
                document.querySelector('.password-help').classList.remove('hidden');
                document.getElementById('password').required = false;
                document.getElementById('password_confirmation').required = false;
                
                document.getElementById('modal-profesor').classList.remove('hidden');
            } else {
                mostrarMensajeError('Error al cargar los datos del profesor');
            }
        } catch (error) {
            console.error('Error:', error);
            mostrarMensajeError('Error al cargar los datos del profesor');
        }
    }
    
    function mostrarModalEliminar(id) {
        document.getElementById('eliminar_id').value = id;
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }
    
    function limpiarFormulario() {
        document.getElementById('form-profesor').reset();
        document.getElementById('profesor_id').value = '';
        document.getElementById('imagen-preview').classList.add('hidden');
        document.getElementById('imagen-preview-img').src = '';
        document.getElementById('form-errors').classList.add('hidden');
        document.getElementById('error-list').innerHTML = '';
        
        // Eliminar campo oculto de eliminar imagen si existe
        const inputEliminarImagen = document.getElementById('eliminar_imagen_actual');
        if (inputEliminarImagen) {
            inputEliminarImagen.remove();
        }
    }
    
    function validarContrasenas() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password || passwordConfirmation) {
            if (password !== passwordConfirmation) {
                mostrarMensajeError('Las contraseñas no coinciden');
                return false;
            }
            if (password && password.length < 8) {
                mostrarMensajeError('La contraseña debe tener al menos 8 caracteres');
                return false;
            }
        }
        return true;
    }
    
    async function actualizarTabla() {
        // Simplemente recargamos la página completa para garantizar que se ven los cambios
        window.location.href = window.location.pathname;
    }
    
    function mostrarMensajeExito(mensaje) {
        const successMessage = document.getElementById('success-message');
        const successMessageText = document.getElementById('success-message-text');
        successMessageText.textContent = mensaje;
        successMessage.style.display = 'block';
        
        // Nos aseguramos de que el mensaje sea visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // El mensaje se mostrará durante el tiempo que pasa antes de la redirección
        // No lo ocultamos automáticamente ya que la página se recargará
    }
    
    function mostrarMensajeError(mensaje) {
        // Crear un elemento fijo en la parte superior de la pantalla
        const errorAlert = document.createElement('div');
        errorAlert.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50';
        errorAlert.innerHTML = `
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <strong class="font-bold mr-1">¡Error!</strong>
                <span class="block">${mensaje}</span>
            </div>
        `;
        document.body.appendChild(errorAlert);
        
        // Nos aseguramos de que el mensaje sea visible
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        setTimeout(() => {
            errorAlert.remove();
        }, 5000);
    }
    
    function mostrarErroresFormulario(errores) {
        const errorList = document.getElementById('error-list');
        errorList.innerHTML = '';
        
        Object.values(errores).forEach(mensajes => {
            mensajes.forEach(mensaje => {
                const li = document.createElement('li');
                li.textContent = mensaje;
                errorList.appendChild(li);
            });
        });
        
        document.getElementById('form-errors').classList.remove('hidden');
    }
</script>
@endpush 