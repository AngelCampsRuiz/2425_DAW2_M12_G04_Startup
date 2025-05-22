<!-- Modal para crear clase -->
<div id="createClaseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-4xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <!-- Cabecera -->
            <div class="bg-gradient-to-r from-green-600 to-teal-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Nueva Clase</span>
                </h3>
                <button type="button" class="text-white hover:text-gray-200 focus:outline-none transition-colors" id="closeCreateModalButton">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Cuerpo del formulario -->
            <form id="createClaseForm" action="{{ route('institucion.clases.store') }}" method="POST" class="space-y-6 p-6" enctype="multipart/form-data">
                @csrf
                
                <!-- Información básica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full mr-2 text-green-600">1</div>
                        Información Básica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="create_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                                <input type="text" name="nombre" id="create_nombre" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all" required>
                            </div>
                            
                            <div>
                                <label for="create_codigo" class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                                <input type="text" name="codigo" id="create_codigo" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="create_grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                            <input type="text" name="grupo" id="create_grupo" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Ej: A, B, C, etc.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Información de nivel y categoría -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full mr-2 text-green-600">2</div>
                        Nivel y Categoría
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="create_nivel_educativo_id" class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo *</label>
                                <select name="nivel_educativo_id" id="create_nivel_educativo_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all" required>
                                    <option value="">Seleccionar nivel</option>
                                    @foreach($nivelesEducativos as $nivel)
                                    <option value="{{ $nivel->id }}">{{ $nivel->nombre_nivel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="create_categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" id="create_categoria_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all" required>
                                    <option value="">Seleccionar categoría</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Información adicional -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full mr-2 text-green-600">3</div>
                        Información Adicional
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="create_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                                <select name="departamento_id" id="create_departamento_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                    <option value="">Seleccionar departamento</option>
                                    @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="create_docente_id" class="block text-sm font-medium text-gray-700 mb-1">Docente Responsable</label>
                                <select name="docente_id" id="create_docente_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                    <option value="">Seleccionar docente</option>
                                    @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">{{ $docente->user->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div>
                                <label for="create_capacidad" class="block text-sm font-medium text-gray-700 mb-1">Capacidad</label>
                                <input type="number" name="capacidad" id="create_capacidad" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all" min="1">
                            </div>
                            
                            <div class="flex items-center pt-5">
                                <input type="checkbox" name="activa" id="create_activa" value="1" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring-green-500 focus:ring-opacity-50" checked>
                                <label for="create_activa" class="ml-2 block text-sm text-gray-700">Clase activa</label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="create_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="create_descripcion" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones del pie de página -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" id="cancelCreateButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-teal-600 border border-transparent rounded-lg hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Crear Clase
                        </div>
                    </button>
                    <!-- Campos ocultos para niveles y curso -->
                    <input type="hidden" name="curso" id="hidden_curso">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Función de prueba para verificar la ruta
function testRoute() {
    fetch('{{ route("institucion.clases.test-route") }}')
        .then(response => response.json())
        .then(data => console.log('Respuesta de prueba:', data))
        .catch(error => console.error('Error en ruta de prueba:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    // Obtener referencias a elementos del DOM
    const modal = document.getElementById('createClaseModal');
    const closeModalButton = document.getElementById('closeCreateModalButton');
    const cancelCreateButton = document.getElementById('cancelCreateButton');
    const createForm = document.getElementById('createClaseForm');
    const nivelSelect = document.getElementById('create_nivel_educativo_id');
    const categoriaSelect = document.getElementById('create_categoria_id');
    
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
    if (cancelCreateButton) {
        cancelCreateButton.addEventListener('click', closeModal);
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
            
            console.log('Nivel seleccionado:', nivelId);
            console.log('Datos disponibles:', window.categoriasPorNivelCreate);
            
            // Si hay categorías para este nivel, añadirlas
            if (window.categoriasPorNivelCreate && window.categoriasPorNivelCreate[nivelId]) {
                const categorias = window.categoriasPorNivelCreate[nivelId];
                console.log('Categorías encontradas:', categorias.length);
                
                if (categorias.length === 0) {
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "No hay categorías disponibles para este nivel";
                    option.disabled = true;
                    categoriaSelect.appendChild(option);
                } else {
                    categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id;
                        // Usar nombre personalizado si existe, o el nombre regular
                        option.textContent = categoria.nombre_personalizado || categoria.nombre;
                        categoriaSelect.appendChild(option);
                        console.log('Categoría agregada:', categoria.id, categoria.nombre_personalizado || categoria.nombre);
                    });
                }
            } else {
                console.warn('No hay datos de categorías para el nivel', nivelId);
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay categorías disponibles";
                option.disabled = true;
                categoriaSelect.appendChild(option);
            }
        });
    }
    
    // Si existe el formulario, añadir evento submit
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            // Esta parte es opcional, se puede usar para validación adicional si es necesario
            const nombre = document.getElementById('create_nombre').value;
            const codigo = document.getElementById('create_codigo').value;
            const nivelEducativo = document.getElementById('create_nivel_educativo_id').value;
            const categoria = document.getElementById('create_categoria_id').value;
            
            // Actualizar campo oculto del curso con el nombre
            document.getElementById('hidden_curso').value = nombre;
            
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

// Función global para abrir el modal de creación
function openCreateModal() {
    console.log('Abriendo modal para crear clase');
    
    // Mostrar el modal
    const modal = document.getElementById('createClaseModal');
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Obtener las categorías por nivel para el selector de categorías
    fetch('{{ route("institucion.clases.get-nivel-categorias") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener datos: ' + response.status + ' ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            
            // Almacenar las categorías por nivel en una variable global
            window.categoriasPorNivelCreate = data.categoriasPorNivel;
            
            // Verificar que se recibieron datos
            if (Object.keys(data.categoriasPorNivel).length === 0) {
                console.warn('No se recibieron categorías por nivel');
            } else {
                console.log('Categorías recibidas para ' + Object.keys(data.categoriasPorNivel).length + ' niveles');
                
                // Para depuración, mostrar las categorías de cada nivel
                for (const [nivelId, categorias] of Object.entries(data.categoriasPorNivel)) {
                    console.log(`Nivel ${nivelId}: ${categorias.length} categorías`);
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar categorías:', error);
            alert('Error al cargar las categorías. Por favor, recarga la página e intenta de nuevo.');
        });
}
</script> 