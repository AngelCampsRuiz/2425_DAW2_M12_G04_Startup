@extends('admin.dashboard')

@section('admin_content')
    <!-- Mensaje de éxito -->
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert" style="display: none;">
        <span id="success-message-text" class="block sm:inline"></span>
    </div>

    <!-- Filtros -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl shadow-md p-6 mb-8 border border-purple-100">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex items-center mb-4 md:mb-0">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h3 class="text-lg font-semibold text-purple-800">Filtros de búsqueda</h3>
            </div>
            <button id="reset-filtros" class="inline-flex items-center px-4 py-2 bg-white border border-purple-200 rounded-lg font-medium text-sm text-purple-700 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reiniciar filtros
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="relative">
                <label for="filtro_nombre" class="block text-sm font-medium text-purple-700 mb-2">Nombre</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_nombre" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por nombre...">
                </div>
            </div>
            
            <div class="relative">
                <label for="filtro_email" class="block text-sm font-medium text-purple-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_email" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por email...">
                </div>
            </div>

            <div class="relative">
                <label for="filtro_codigo_centro" class="block text-sm font-medium text-purple-700 mb-2">Código Centro</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <input type="text" id="filtro_codigo_centro" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Buscar por código...">
                </div>
            </div>

            <div class="relative">
                <label for="filtro_ciudad" class="block text-sm font-medium text-purple-700 mb-2">Ciudad</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <select id="filtro_ciudad" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas las ciudades</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad }}">{{ $ciudad }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Temporalmente deshabilitado: la columna tipo_institucion no existe en la base de datos --}}
            <div class="relative" style="display: none;">
                <label for="filtro_tipo_institucion" class="block text-sm font-medium text-purple-700 mb-2">Tipo de Institución</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <select id="filtro_tipo_institucion" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todos los tipos</option>
                        @foreach($tipos_institucion as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label for="filtro_estado" class="block text-sm font-medium text-purple-700 mb-2">Estado</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <select id="filtro_estado" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative">
                <label for="filtro_verificada" class="block text-sm font-medium text-purple-700 mb-2">Verificación</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <select id="filtro_verificada" class="pl-10 w-full rounded-lg border-purple-200 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50 appearance-none bg-white">
                        <option value="">Todas</option>
                        <option value="1">Verificadas</option>
                        <option value="0">Pendientes</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenedor de la tabla -->
    <div id="tabla-instituciones-container" class="bg-white rounded-lg shadow overflow-hidden">
        @include('admin.instituciones.tabla')
    </div>

    <!-- Modal de Creación/Edición -->
    <div id="modal-institucion" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modal-titulo" class="text-xl font-semibold text-gray-700">Nueva Institución</h3>
                <button id="modal-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 max-h-[70vh] overflow-y-auto p-2">
                <form id="form-institucion" action="{{ route('admin.instituciones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="form_method" name="_method" value="POST">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Datos del Usuario -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-700 mb-3">Datos de Usuario</h4>
                            
                            <div class="mb-3">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Dejar en blanco para mantener la actual (solo en edición)</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div class="mb-3">
                                <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIF</label>
                                <input type="text" id="dni" name="dni" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <input type="text" id="ciudad" name="ciudad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="sitio_web" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                                <input type="url" id="sitio_web" name="sitio_web" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            
                            <div class="mb-3">
                                <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen de Perfil</label>
                                <input type="file" id="imagen" name="imagen" class="mt-1 block w-full" accept="image/*">
                                <div id="imagen-actual-container" class="hidden mt-2">
                                    <p class="text-sm">Imagen actual:</p>
                                    <img id="imagen-actual" src="" alt="Imagen actual" class="mt-1 h-20 w-20 object-cover rounded">
                                    <div class="mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="eliminar_imagen_actual" class="rounded border-gray-300 text-purple-600">
                                            <span class="ml-2 text-sm text-gray-600">Eliminar imagen actual</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="activo" checked class="rounded border-gray-300 text-purple-600">
                                    <span class="ml-2 text-sm text-gray-600">Cuenta Activa</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Datos de la Institución -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-700 mb-3">Datos de la Institución</h4>
                            
                            <div class="mb-3">
                                <label for="codigo_centro" class="block text-sm font-medium text-gray-700">Código de Centro</label>
                                <input type="text" id="codigo_centro" name="codigo_centro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tipo_institucion" class="block text-sm font-medium text-gray-700">Tipo de Institución</label>
                                <select id="tipo_institucion" name="tipo_institucion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Educación Primaria">Educación Primaria</option>
                                    <option value="Educación Secundaria">Educación Secundaria</option>
                                    <option value="Formación Profesional">Formación Profesional</option>
                                    <option value="Universidad">Universidad</option>
                                    <option value="Centro de Educación Especial">Centro de Educación Especial</option>
                                    <option value="Centro de Educación de Adultos">Centro de Educación de Adultos</option>
                                    <option value="Escuela de Idiomas">Escuela de Idiomas</option>
                                    <option value="Escuela de Arte">Escuela de Arte</option>
                                    <option value="Conservatorio">Conservatorio</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="representante_legal" class="block text-sm font-medium text-gray-700">Representante Legal</label>
                                <input type="text" id="representante_legal" name="representante_legal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="cargo_representante" class="block text-sm font-medium text-gray-700">Cargo del Representante</label>
                                <input type="text" id="cargo_representante" name="cargo_representante" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="flex items-center">
                                    <input type="checkbox" name="verificada" class="rounded border-gray-300 text-purple-600">
                                    <span class="ml-2 text-sm text-gray-600">Institución Verificada</span>
                                </label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Niveles Educativos</label>
                                <div class="bg-white p-2 rounded border border-gray-300 max-h-40 overflow-y-auto">
                                    @foreach($nivelesEducativos as $nivel)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="nivel_{{ $nivel->id }}" name="niveles_educativos[]" value="{{ $nivel->id }}" class="rounded border-gray-300 text-purple-600">
                                        <label for="nivel_{{ $nivel->id }}" class="ml-2 text-sm text-gray-700">{{ $nivel->nombre_nivel }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" id="btn-cancelar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="modal-eliminar" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-medium text-gray-700">Confirmar Eliminación</h3>
                <button id="modal-eliminar-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 mb-6">
                <p class="text-sm text-gray-700">¿Estás seguro que deseas eliminar esta institución? Esta acción no se puede deshacer.</p>
            </div>
            <form id="form-eliminar" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" id="eliminar_id" name="id">
                <div class="flex justify-end space-x-3">
                    <button type="button" id="btn-cancelar-eliminar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">Eliminar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Gestión de Categorías -->
    <div id="modal-categorias" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-4/5 lg:w-4/5 xl:w-3/4 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 id="modal-categorias-titulo" class="text-xl font-semibold text-gray-700">Gestionar Categorías</h3>
                <button id="modal-categorias-close" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-4 max-h-[75vh] overflow-y-auto p-2">
                <div id="contenedor-categorias-institucion">
                    <div id="lista-niveles-educativos" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Niveles Educativos de la Institución</h4>
                        <div id="niveles-container" class="flex flex-wrap gap-2 mb-4">
                            <!-- Aquí se cargarán dinámicamente los niveles educativos -->
                        </div>
                    </div>

                    <div id="categorias-por-nivel" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Categorías por Nivel Educativo</h4>
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div id="no-categorias" class="hidden text-gray-500 text-sm">
                                Esta institución no tiene categorías asociadas.
                            </div>
                            <div id="categorias-container">
                                <!-- Aquí se cargarán dinámicamente las categorías por nivel -->
                            </div>
                        </div>
                    </div>

                    <div id="agregar-categorias" class="mb-6">
                        <h4 class="text-lg font-medium text-gray-700 mb-3">Agregar Nuevas Categorías</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <form id="form-agregar-categoria">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="nueva-categoria-nivel" class="block text-sm font-medium text-gray-700 mb-1">Nivel Educativo</label>
                                        <select id="nueva-categoria-nivel" class="w-full rounded-md border-gray-300 shadow-sm" required>
                                            <option value="">Seleccione un nivel</option>
                                            <!-- Opciones cargadas dinámicamente -->
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nueva-categoria-id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                                        <select id="nueva-categoria-id" class="w-full rounded-md border-gray-300 shadow-sm" required disabled>
                                            <option value="">Seleccione primero un nivel</option>
                                            <!-- Opciones cargadas dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="nueva-categoria-activo" class="rounded border-gray-300 text-purple-600" checked>
                                        <span class="ml-2 text-sm text-gray-700">Activo</span>
                                    </label>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Agregar Categoría</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="mensaje-cargando-categorias" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-purple-600"></div>
                    <p class="mt-2 text-gray-600">Cargando categorías...</p>
                </div>
                <div id="error-categorias" class="hidden bg-red-50 text-red-700 p-4 rounded-lg mb-4">
                    <p class="font-medium">Error al cargar las categorías:</p>
                    <p id="error-categorias-mensaje"></p>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-4 border-t pt-4">
                <button id="btn-cancelar-categorias" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">Cerrar</button>
                <button id="btn-guardar-categorias" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition-colors">Guardar Cambios</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para actualizar la tabla mediante AJAX
            window.actualizarTabla = function(url = null) {
                // Obtener valores de filtros
                const filtro_nombre = document.getElementById('filtro_nombre').value;
                const filtro_email = document.getElementById('filtro_email').value;
                const filtro_codigo_centro = document.getElementById('filtro_codigo_centro').value;
                const filtro_ciudad = document.getElementById('filtro_ciudad').value;
                // Temporalmente deshabilitado
                // const filtro_tipo_institucion = document.getElementById('filtro_tipo_institucion').value;
                const filtro_tipo_institucion = ""; // Valor vacío por defecto
                const filtro_estado = document.getElementById('filtro_estado').value;
                const filtro_verificada = document.getElementById('filtro_verificada').value;
                
                // Construir URL con parámetros
                const params = new URLSearchParams();
                if (filtro_nombre) params.append('nombre', filtro_nombre);
                if (filtro_email) params.append('email', filtro_email);
                if (filtro_codigo_centro) params.append('codigo_centro', filtro_codigo_centro);
                if (filtro_ciudad) params.append('ciudad', filtro_ciudad);
                if (filtro_tipo_institucion) params.append('tipo_institucion', filtro_tipo_institucion);
                if (filtro_estado) params.append('estado', filtro_estado);
                if (filtro_verificada) params.append('verificada', filtro_verificada);
                
                // Determinar la URL
                let fetchUrl = url || '{{ route("admin.instituciones.index") }}';
                
                // Si no hay url específica, añadir los parámetros a la URL actual
                if (!url) {
                    fetchUrl = `${fetchUrl}?${params.toString()}`;
                } else if (url.includes('?')) {
                    // Si la URL ya tiene parámetros, añadir los nuevos
                    fetchUrl = `${url}&${params.toString()}`;
                } else {
                    // Si la URL no tiene parámetros, añadirlos
                    fetchUrl = `${url}?${params.toString()}`;
                }
                
                // Mostrar indicador de carga
                document.getElementById('tabla-instituciones-container').innerHTML = `
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-700"></div>
                    </div>
                `;
                
                // Realizar petición AJAX
                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabla-instituciones-container').innerHTML = data.tabla;
                    
                    // Convertir enlaces de paginación a AJAX
                    document.querySelectorAll('.pagination a').forEach(link => {
                        link.classList.add('pagination-link');
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            actualizarTabla(this.getAttribute('href'));
                        });
                    });
                    
                    // Volver a asignar eventos a los botones
                    asignarEventosTabla();
                })
                .catch(error => {
                    console.error('Error al cargar tabla:', error);
                    document.getElementById('tabla-instituciones-container').innerHTML = `
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-6">
                            <strong class="font-bold">Error:</strong>
                            <span class="block sm:inline">Ha ocurrido un error al cargar los datos.</span>
                        </div>
                    `;
                });
            }
            
            // Eventos para los campos de filtro
            document.getElementById('filtro_nombre').addEventListener('input', debounce(actualizarTabla, 500));
            document.getElementById('filtro_email').addEventListener('input', debounce(actualizarTabla, 500));
            document.getElementById('filtro_codigo_centro').addEventListener('input', debounce(actualizarTabla, 500));
            document.getElementById('filtro_ciudad').addEventListener('change', actualizarTabla);
            // Temporalmente deshabilitado
            // document.getElementById('filtro_tipo_institucion').addEventListener('change', actualizarTabla);
            document.getElementById('filtro_estado').addEventListener('change', actualizarTabla);
            document.getElementById('filtro_verificada').addEventListener('change', actualizarTabla);
            
            // Botón para reiniciar filtros
            document.getElementById('reset-filtros').addEventListener('click', function() {
                document.getElementById('filtro_nombre').value = '';
                document.getElementById('filtro_email').value = '';
                document.getElementById('filtro_codigo_centro').value = '';
                document.getElementById('filtro_ciudad').value = '';
                // document.getElementById('filtro_tipo_institucion').value = '';
                document.getElementById('filtro_estado').value = '';
                document.getElementById('filtro_verificada').value = '';
                actualizarTabla();
            });
            
            // Función debounce para evitar muchas peticiones seguidas
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
            
            // Función para asignar eventos a los botones de la tabla
            function asignarEventosTabla() {
                // Botón de crear institución
                document.getElementById('btn-crear-institucion')?.addEventListener('click', function() {
                    // Limpiar el formulario
                    document.getElementById('form-institucion').reset();
                    document.getElementById('form_method').value = 'POST';
                    document.getElementById('form-institucion').action = '{{ route("admin.instituciones.store") }}';
                    document.getElementById('modal-titulo').textContent = 'Nueva Institución';
                    
                    // Si hay imagen previa, ocultarla
                    document.getElementById('imagen-actual-container').classList.add('hidden');
                    
                    // Mostrar modal
                    document.getElementById('modal-institucion').classList.remove('hidden');
                });
                
                // Botones de editar institución
                document.querySelectorAll('.btn-editar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        document.getElementById('modal-titulo').textContent = 'Editar Institución';
                        
                        // Mostrar indicador de carga en el formulario
                        const formContent = document.getElementById('form-institucion').innerHTML;
                        const loadingIndicator = `
                            <div class="flex justify-center items-center py-12">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-700"></div>
                            </div>
                        `;
                        document.getElementById('form-institucion').innerHTML = loadingIndicator;
                        
                        // Mostrar modal
                        document.getElementById('modal-institucion').classList.remove('hidden');
                        
                        // Cargar datos de la institución
                        fetch(`{{ url('admin/instituciones') }}/${id}/edit`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Restaurar el formulario original
                            document.getElementById('form-institucion').innerHTML = formContent;
                            
                            // Establecer método PUT para actualización
                            document.getElementById('form_method').value = 'PUT';
                            document.getElementById('form-institucion').action = `{{ url('admin/instituciones') }}/${id}`;
                            
                            // Completar formulario con datos
                            if (data.institucion && data.institucion.user) {
                                // Datos de usuario
                                document.getElementById('nombre').value = data.institucion.user.nombre || '';
                                document.getElementById('email').value = data.institucion.user.email || '';
                                document.getElementById('dni').value = data.institucion.user.dni || '';
                                document.getElementById('ciudad').value = data.institucion.user.ciudad || '';
                                document.getElementById('telefono').value = data.institucion.user.telefono || '';
                                document.getElementById('descripcion').value = data.institucion.user.descripcion || '';
                                document.getElementById('sitio_web').value = data.institucion.user.sitio_web || '';
                                
                                // Establecer estado activo
                                const checkboxActivo = document.querySelector('input[name="activo"]');
                                if (checkboxActivo) {
                                    checkboxActivo.checked = data.institucion.user.activo ? true : false;
                                }
                                
                                // Mostrar imagen actual si existe
                                if (data.institucion.user.imagen) {
                                    document.getElementById('imagen-actual').src = `{{ asset('public/profile_images') }}/${data.institucion.user.imagen}`;
                                    document.getElementById('imagen-actual-container').classList.remove('hidden');
                                } else {
                                    document.getElementById('imagen-actual-container').classList.add('hidden');
                                }
                                
                                // Datos de institución
                                document.getElementById('codigo_centro').value = data.institucion.codigo_centro || '';
                                
                                // Establecer tipo de institución
                                const selectTipo = document.getElementById('tipo_institucion');
                                if (selectTipo && data.institucion.tipo_institucion) {
                                    Array.from(selectTipo.options).forEach(option => {
                                        if (option.value === data.institucion.tipo_institucion) {
                                            option.selected = true;
                                        }
                                    });
                                }
                                
                                document.getElementById('direccion').value = data.institucion.direccion || '';
                                document.getElementById('codigo_postal').value = data.institucion.codigo_postal || '';
                                document.getElementById('representante_legal').value = data.institucion.representante_legal || '';
                                document.getElementById('cargo_representante').value = data.institucion.cargo_representante || '';
                                
                                // Establecer verificada
                                const checkboxVerificada = document.querySelector('input[name="verificada"]');
                                if (checkboxVerificada) {
                                    checkboxVerificada.checked = data.institucion.verificada ? true : false;
                                }
                                
                                // Marcar niveles educativos seleccionados
                                const nivelesSeleccionados = data.niveles_seleccionados || [];
                                document.querySelectorAll('input[name="niveles_educativos[]"]').forEach(checkbox => {
                                    checkbox.checked = nivelesSeleccionados.includes(parseInt(checkbox.value));
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error al cargar institución:', error);
                            // Mostrar mensaje de error
                            document.getElementById('form-institucion').innerHTML = `
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-6">
                                    <strong class="font-bold">Error:</strong>
                                    <span class="block sm:inline">Ha ocurrido un error al cargar los datos. Intente nuevamente.</span>
                                </div>
                            `;
                        });
                    });
                });
                
                // Botones de verificar institución
                document.querySelectorAll('.btn-verificar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        
                        // Hacer petición para cambiar estado de verificación
                        fetch(`{{ url('admin/instituciones') }}/${id}/verificar`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                // Mostrar mensaje de éxito
                                document.getElementById('success-message-text').textContent = data.message;
                                document.getElementById('success-message').style.display = 'block';
                                
                                // Actualizar tabla
                                actualizarTabla();
                                
                                // Ocultar mensaje después de 3 segundos
                                setTimeout(() => {
                                    document.getElementById('success-message').style.display = 'none';
                                }, 3000);
                            }
                        })
                        .catch(error => {
                            console.error('Error al cambiar verificación:', error);
                        });
                    });
                });
                
                // Botones de eliminar institución
                document.querySelectorAll('.btn-eliminar').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        document.getElementById('eliminar_id').value = id;
                        document.getElementById('form-eliminar').action = `{{ url('admin/instituciones') }}/${id}`;
                        document.getElementById('modal-eliminar').classList.remove('hidden');
                    });
                });
                
                // Botón cerrar modal de eliminación
                document.getElementById('modal-eliminar-close')?.addEventListener('click', function() {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                });
                
                // Botón cancelar eliminación
                document.getElementById('btn-cancelar-eliminar')?.addEventListener('click', function() {
                    document.getElementById('modal-eliminar').classList.add('hidden');
                });
                
                // Botón cerrar modal de institución
                document.getElementById('modal-close')?.addEventListener('click', function() {
                    document.getElementById('modal-institucion').classList.add('hidden');
                });
                
                // Botón cancelar formulario
                document.getElementById('btn-cancelar')?.addEventListener('click', function() {
                    document.getElementById('modal-institucion').classList.add('hidden');
                });
                
                // Botones de categorías
                document.querySelectorAll('.btn-categorias').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        
                        // Mostrar modal
                        document.getElementById('modal-categorias').classList.remove('hidden');
                        document.getElementById('contenedor-categorias-institucion').classList.add('hidden');
                        document.getElementById('mensaje-cargando-categorias').classList.remove('hidden');
                        document.getElementById('error-categorias').classList.add('hidden');
                        
                        // Cargar categorías
                        fetch(`{{ url('admin/instituciones') }}/${id}/categorias`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                // Implementar lógica para mostrar categorías
                                // Esta parte requeriría una implementación más detallada
                            } else {
                                throw new Error(data.message || 'Error al cargar categorías');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('mensaje-cargando-categorias').classList.add('hidden');
                            document.getElementById('error-categorias').classList.remove('hidden');
                            document.getElementById('error-categorias-mensaje').textContent = error.message || 'Error al cargar las categorías. Intente nuevamente.';
                        });
                    });
                });
                
                // Botón cerrar modal de categorías
                document.getElementById('modal-categorias-close')?.addEventListener('click', function() {
                    document.getElementById('modal-categorias').classList.add('hidden');
                });
                
                // Botón cancelar categorías
                document.getElementById('btn-cancelar-categorias')?.addEventListener('click', function() {
                    document.getElementById('modal-categorias').classList.add('hidden');
                });
            }
            
            // Inicializar asignación de eventos
            asignarEventosTabla();
            
            // Manejar envío del formulario vía AJAX
            document.getElementById('form-institucion').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const actionUrl = this.action;
                const method = document.getElementById('form_method').value.toUpperCase();
                
                // Mostrar indicador de carga en formulario
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.textContent;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Guardando...
                `;
                submitBtn.disabled = true;
                
                // Configurar opciones fetch según el método
                const fetchOptions = {
                    method: method === 'PUT' ? 'POST' : method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                };
                
                fetch(actionUrl, fetchOptions)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar mensaje de éxito
                            document.getElementById('success-message-text').textContent = data.message || 'Institución guardada correctamente';
                            document.getElementById('success-message').style.display = 'block';
                            
                            // Cerrar modal
                            document.getElementById('modal-institucion').classList.add('hidden');
                            
                            // Actualizar tabla
                            actualizarTabla();
                            
                            // Ocultar mensaje después de 3 segundos
                            setTimeout(() => {
                                document.getElementById('success-message').style.display = 'none';
                            }, 3000);
                        } else if (data.errors) {
                            // Mostrar errores de validación
                            let errorsHtml = '<ul class="list-disc pl-5 text-sm text-red-600">';
                            for (const field in data.errors) {
                                data.errors[field].forEach(error => {
                                    errorsHtml += `<li>${error}</li>`;
                                });
                            }
                            errorsHtml += '</ul>';
                            
                            // Insertar mensajes de error al principio del formulario
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-4';
                            errorDiv.innerHTML = `
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Se encontraron los siguientes errores:</h3>
                                        ${errorsHtml}
                                    </div>
                                </div>
                            `;
                            
                            // Remover mensajes de error anteriores
                            const previousError = this.querySelector('.bg-red-50');
                            if (previousError) {
                                previousError.remove();
                            }
                            
                            this.insertBefore(errorDiv, this.firstChild);
                        }
                    })
                    .catch(error => {
                        console.error('Error al guardar institución:', error);
                        // Mostrar mensaje de error general
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-4';
                        errorDiv.innerHTML = `
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Error al guardar la institución</h3>
                                    <p class="text-sm text-red-700">Ha ocurrido un error al procesar la solicitud. Intente nuevamente.</p>
                                </div>
                            </div>
                        `;
                        
                        // Remover mensajes de error anteriores
                        const previousError = this.querySelector('.bg-red-50');
                        if (previousError) {
                            previousError.remove();
                        }
                        
                        this.insertBefore(errorDiv, this.firstChild);
                    })
                    .finally(() => {
                        // Restaurar botón
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    });
            });
        });
    </script>
    @endpush
@endsection 