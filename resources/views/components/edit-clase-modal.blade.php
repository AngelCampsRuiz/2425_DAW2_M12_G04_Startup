<!-- Modal para editar clase - Completamente rediseñado -->
<div id="editClaseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-4xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <!-- Cabecera -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Editar Clase</span>
                </h3>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none transition-colors" id="closeModalButton">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Cuerpo del formulario -->
            <form id="editClaseForm" method="POST" class="space-y-6 p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Información básica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">1</div>
                        Información Básica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                                <input type="text" name="nombre" id="nombre" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all" required>
                            </div>
                            
                            <div>
                                <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                                <input type="text" name="codigo" id="codigo" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                            <input type="text" name="grupo" id="grupo" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Ej: A, B, C, etc.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Información de nivel y categoría -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">2</div>
                        Nivel y Categoría
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nivel_educativo_id" class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo *</label>
                                <select name="nivel_educativo_id" id="nivel_educativo_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all" required>
                                    <option value="">Seleccionar nivel</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" id="categoria_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all" required>
                                    <option value="">Seleccionar categoría</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Información adicional -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">3</div>
                        Información Adicional
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                <select name="departamento_id" id="departamento_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                    <option value="">Seleccionar departamento</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente Responsable</label>
                                <select name="docente_id" id="docente_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                    <option value="">Seleccionar docente</option>
                                </select>
                            </div>
                        
                            <div>
                                <label for="capacidad" class="block text-sm font-medium text-gray-700 mb-1">Capacidad</label>
                                <input type="number" name="capacidad" id="capacidad" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all" min="1">
                            </div>
                            
                            <div class="flex items-center pt-5">
                                <input type="checkbox" name="activa" id="activa" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50">
                                <label for="activa" class="ml-2 block text-sm text-gray-700">Clase activa</label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones del pie de página -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="cancelEditButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar Cambios
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a elementos del DOM
    const modal = document.getElementById('editClaseModal');
    const closeModalButton = document.getElementById('closeModalButton');
    const cancelEditButton = document.getElementById('cancelEditButton');
    const editForm = document.getElementById('editClaseForm');
    const nivelSelect = document.getElementById('nivel_educativo_id');
    const categoriaSelect = document.getElementById('categoria_id');
    
    // Función para cerrar el modal
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Evento click para cerrar el modal
    if (closeModalButton) {
        closeModalButton.addEventListener('click', closeModal);
    }
    
    // Evento click para el botón cancelar
    if (cancelEditButton) {
        cancelEditButton.addEventListener('click', closeModal);
    }
    
    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Cerrar modal al hacer clic fuera del contenido
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Si existe el select de nivel educativo, añadir evento para actualizar categorías
    if (nivelSelect) {
        nivelSelect.addEventListener('change', function() {
            const nivelId = this.value;
            
            // Limpiar el select de categorías
            categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
            
            if (!nivelId) return;
            
            // Si hay categorías para este nivel, añadirlas
            if (window.categoriasPorNivel && window.categoriasPorNivel[nivelId]) {
                window.categoriasPorNivel[nivelId].forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nombre_personalizado || categoria.nombre_categoria;
                    categoriaSelect.appendChild(option);
                });
            }
        });
    }
    
    // Si existe el formulario, añadir evento submit
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            // Esta parte es opcional, se puede usar para validación adicional si es necesario
            const nombre = document.getElementById('nombre').value;
            const codigo = document.getElementById('codigo').value;
            const nivelEducativo = document.getElementById('nivel_educativo_id').value;
            const categoria = document.getElementById('categoria_id').value;
            
            if (!nombre || !codigo || !nivelEducativo || !categoria) {
                e.preventDefault();
                alert('Por favor, complete todos los campos obligatorios.');
                return false;
            }
            
            // Si todo está bien, el formulario se enviará normalmente
            return true;
        });
    }
});

// Función global para abrir el modal de edición
function openEditModal(claseId) {
    console.log('Abriendo modal para editar clase ID:', claseId);
    
    // Mostrar el modal
    const modal = document.getElementById('editClaseModal');
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Establecer la acción del formulario con el prefijo correcto usando la ruta de institución
    const form = document.getElementById('editClaseForm');
    form.action = `/institucion/clases/${claseId}`;
    
    // Obtener los datos de la clase - importante usar la ruta correcta
    fetch(`/institucion/clases/${claseId}/get-data`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener datos: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            
            // Almacenar las categorías por nivel en una variable global
            window.categoriasPorNivel = data.categoriasPorNivel;
            
            // Rellenar los campos del formulario
            document.getElementById('nombre').value = data.clase.nombre || '';
            document.getElementById('codigo').value = data.clase.codigo || '';
            document.getElementById('grupo').value = data.clase.grupo || '';
            document.getElementById('capacidad').value = data.clase.capacidad || '';
            document.getElementById('descripcion').value = data.clase.descripcion || '';
            document.getElementById('activa').checked = data.clase.activa ? true : false;
            
            // Poblar y seleccionar nivel educativo
            const nivelSelect = document.getElementById('nivel_educativo_id');
            nivelSelect.innerHTML = '<option value="">Seleccionar nivel</option>';
            
            data.nivelesEducativos.forEach(nivel => {
                const option = document.createElement('option');
                option.value = nivel.id;
                option.textContent = nivel.nombre_nivel;
                option.selected = nivel.id == data.clase.nivel_educativo_id;
                nivelSelect.appendChild(option);
            });
            
            // Poblar y seleccionar categoría
            const categoriaSelect = document.getElementById('categoria_id');
            categoriaSelect.innerHTML = '<option value="">Seleccionar categoría</option>';
            
            if (data.clase.nivel_educativo_id && data.categoriasPorNivel[data.clase.nivel_educativo_id]) {
                data.categoriasPorNivel[data.clase.nivel_educativo_id].forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id;
                    option.textContent = categoria.nombre_personalizado || categoria.nombre_categoria;
                    option.selected = categoria.id == data.clase.categoria_id;
                    categoriaSelect.appendChild(option);
                });
            }
            
            // Poblar y seleccionar departamento
            const departamentoSelect = document.getElementById('departamento_id');
            departamentoSelect.innerHTML = '<option value="">Seleccionar departamento</option>';
            
            data.departamentos.forEach(departamento => {
                const option = document.createElement('option');
                option.value = departamento.id;
                option.textContent = departamento.nombre;
                option.selected = departamento.id == data.clase.departamento_id;
                departamentoSelect.appendChild(option);
            });
            
            // Poblar y seleccionar docente
            const docenteSelect = document.getElementById('docente_id');
            docenteSelect.innerHTML = '<option value="">Seleccionar docente</option>';
            
            data.docentes.forEach(docente => {
                const option = document.createElement('option');
                option.value = docente.id;
                option.textContent = docente.user.nombre;
                option.selected = docente.id == data.clase.docente_id;
                docenteSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar datos de la clase. Por favor, inténtelo de nuevo.');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
}
</script>

<style>
/* Estilos para el modal */
#editClaseModal {
    transition: opacity 0.3s ease-in-out;
}

#editClaseModal .rounded-lg {
    border-radius: 0.5rem;
}

#editClaseModal input:focus, 
#editClaseModal select:focus, 
#editClaseModal textarea:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
}

#editClaseModal .bg-gray-50 {
    background-color: #f9fafb;
}
</style> 