<!-- Modal de Nueva Oferta -->
<div id="modalNuevaOferta" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Publicar Nueva Oferta
                </h3>
                <button onclick="closeModal()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="formNuevaOferta" class="p-6">
                @csrf
                <!-- Información básica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">1</div>
                        Información básica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título de la oferta *</label>
                            <input type="text" name="titulo" id="titulo" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Un buen título aumenta la visibilidad de su oferta (máx. 100 caracteres)</p>
                        </div>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                            <textarea name="descripcion" id="descripcion" rows="4" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Incluya detalles sobre tareas, requisitos y beneficios para el estudiante</p>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la práctica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">2</div>
                        Detalles de la práctica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario *</label>
                                <select name="horario" id="horario" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Seleccionar horario</option>
                                    <option value="mañana">Mañana</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="flexible">Flexible</option>
                                </select>
                            </div>

                            <div>
                                <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-1">Horas totales *</label>
                                <input type="number" name="horas_totales" id="horas_totales" min="100" max="400" required
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Entre 100 y 400 horas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorización -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full mr-2 text-purple-600">3</div>
                        Categorización
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" id="categoria_id" required onchange="cargarSubcategorias()"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Seleccionar categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría *</label>
                                <select name="subcategoria_id" id="subcategoria_id" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">Primero seleccione una categoría</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Publicar oferta
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
