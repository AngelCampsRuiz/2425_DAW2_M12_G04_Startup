<div id="modalEditarEstudiante" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Editar Estudiante</span>
                </h2>
                <button type="button" onclick="cerrarModalEditarEstudiante()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        
            <form id="formEditarEstudiante" action="/institucion/estudiantes/update-modal" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="estudiante_id" id="editar_estudiante_id">
                
                <!-- Información Personal -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">1</div>
                        Información Personal
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                                <input type="text" name="nombre" id="editar_nombre" required 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="email" id="editar_email" required 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="text" name="telefono" id="editar_telefono" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIE</label>
                                <input type="text" name="dni" id="editar_dni" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="editar_fecha_nacimiento" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                                <input type="text" name="ciudad" id="editar_ciudad" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            </div>
                        </div>
                        
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <input type="text" name="direccion" id="editar_direccion" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                        </div>
                    </div>
                </div>
                
                <!-- Información Académica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full mr-2 text-blue-600">2</div>
                        Información Académica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                            <select name="categoria_id" id="editar_categoria_id" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                <option value="">Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="conocimientos_previos" class="block text-sm font-medium text-gray-700 mb-1">Conocimientos Previos</label>
                            <textarea name="conocimientos_previos" id="editar_conocimientos_previos" rows="3" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"></textarea>
                        </div>
                        
                        <div>
                            <label for="intereses" class="block text-sm font-medium text-gray-700 mb-1">Intereses</label>
                            <textarea name="intereses" id="editar_intereses" rows="3" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="cerrarModalEditarEstudiante()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
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
    function abrirModalEditarEstudiante(estudianteId, nombre, email, telefono, dni, fechaNacimiento, ciudad, direccion, categoriaId, conocimientosPrevios, intereses) {
        document.getElementById('editar_estudiante_id').value = estudianteId;
        document.getElementById('editar_nombre').value = nombre;
        document.getElementById('editar_email').value = email;
        document.getElementById('editar_telefono').value = telefono || '';
        document.getElementById('editar_dni').value = dni || '';
        document.getElementById('editar_fecha_nacimiento').value = fechaNacimiento || '';
        document.getElementById('editar_ciudad').value = ciudad || '';
        document.getElementById('editar_direccion').value = direccion || '';
        document.getElementById('editar_categoria_id').value = categoriaId || '';
        document.getElementById('editar_conocimientos_previos').value = conocimientosPrevios || '';
        document.getElementById('editar_intereses').value = intereses || '';
        
        document.getElementById('modalEditarEstudiante').classList.remove('hidden');
    }
    
    function cerrarModalEditarEstudiante() {
        document.getElementById('modalEditarEstudiante').classList.add('hidden');
    }
</script> 