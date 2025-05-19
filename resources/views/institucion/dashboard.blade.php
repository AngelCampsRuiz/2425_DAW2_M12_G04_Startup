@extends('layouts.institucion')

@section('title', 'Dashboard de Institución')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-purple-50">
    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tarjeta: Total de Docentes -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-purple-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-purple-800 mb-1">Docentes</h3>
                    <p class="text-3xl font-bold text-purple-900">{{ $totalDocentes }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-purple-700">
                <div class="flex items-center">
                    <span class="font-medium">Profesores</span>
                    <a href="{{ route('institucion.docentes.index') }}" class="ml-auto bg-white text-purple-600 hover:text-purple-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todos
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Total de Departamentos -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-blue-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-blue-800 mb-1">Departamentos</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalDepartamentos }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-blue-700">
                <div class="flex items-center">
                    <span class="font-medium">Departamentos</span>
                    <a href="{{ route('institucion.departamentos.index') }}" class="ml-auto bg-white text-blue-600 hover:text-blue-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todos
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Total de Clases -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-green-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-green-800 mb-1">Clases</h3>
                    <p class="text-3xl font-bold text-green-900">{{ $totalClases }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-green-700">
                <div class="flex items-center">
                    <span class="font-medium">Clases</span>
                    <a href="{{ route('institucion.clases.index') }}" class="ml-auto bg-white text-green-600 hover:text-green-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Solicitudes Pendientes -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-amber-100 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium text-amber-800 mb-1">Solicitudes</h3>
                    <p class="text-3xl font-bold text-amber-900">{{ $solicitudesPendientes }}</p>
                </div>
                <div class="bg-white p-3 rounded-lg shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-amber-700">
                <div class="flex items-center">
                    <span class="font-medium">Pendientes</span>
                    <a href="{{ route('institucion.solicitudes.index') }}" class="ml-auto bg-white text-amber-600 hover:text-amber-800 text-xs font-medium px-2 py-1 rounded-full shadow-sm transition-colors duration-200">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 transform transition-all duration-300 hover:shadow-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Acciones Rápidas
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <!-- Crear Docente -->
            <a href="javascript:void(0)" onclick="openModalDocente()" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-indigo-100 hover:border-indigo-300 transition-all duration-300 bg-gradient-to-br from-white to-indigo-50 group">
                <div class="bg-indigo-100 group-hover:bg-indigo-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Docente</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear un nuevo profesor</p>
                </div>
            </a>

            <!-- Crear Departamento -->
            <a href="javascript:void(0)" onclick="openModalDepartamento()" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-blue-100 hover:border-blue-300 transition-all duration-300 bg-gradient-to-br from-white to-blue-50 group">
                <div class="bg-blue-100 group-hover:bg-blue-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Departamento</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear un nuevo departamento</p>
                </div>
            </a>

            <!-- Crear Clase -->
            <a href="javascript:void(0)" onclick="openModalClase()" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-green-100 hover:border-green-300 transition-all duration-300 bg-gradient-to-br from-white to-green-50 group">
                <div class="bg-green-100 group-hover:bg-green-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Clase</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear una nueva clase</p>
                </div>
            </a>

            <!-- Revisar Solicitudes -->
            <a href="{{ route('institucion.solicitudes.index') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-amber-100 hover:border-amber-300 transition-all duration-300 bg-gradient-to-br from-white to-amber-50 group">
                <div class="bg-amber-100 group-hover:bg-amber-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Revisar Solicitudes</h3>
                    <p class="text-sm text-gray-600 mt-1">Ver solicitudes pendientes</p>
                </div>
            </a>
            
            <!-- Estudiantes Pendientes -->
            <a href="{{ route('institucion.estudiantes.pendientes') }}" class="flex items-center p-5 rounded-xl shadow-sm hover:shadow-md border border-purple-100 hover:border-purple-300 transition-all duration-300 bg-gradient-to-br from-white to-purple-50 group">
                <div class="bg-purple-100 group-hover:bg-purple-200 rounded-full p-3 mr-4 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Estudiantes Pendientes</h3>
                    <p class="text-sm text-gray-600 mt-1">Activar nuevos estudiantes</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Modal de Nuevo Docente -->
<div id="modalNuevoDocente" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Crear Nuevo Docente
                </h3>
                <button onclick="closeModalDocente()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formNuevoDocente" action="{{ route('institucion.docentes.store') }}" method="POST" class="p-6">
            @csrf
                <!-- Información Personal -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 rounded-full mr-2 text-indigo-600">1</div>
                        Información Personal
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                            <input type="text" name="nombre" id="nombre" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIF/NIE *</label>
                                <input type="text" name="dni" id="dni" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="text" name="telefono" id="telefono" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-indigo-100 rounded-full mr-2 text-indigo-600">2</div>
                        Información Profesional
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <select name="departamento_id" id="departamento_id" onchange="toggleDepartamentoManual()"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                <option value="">-- Seleccionar Departamento --</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="departamento_manual_container">
                            <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento (si no está en la lista)</label>
                            <input type="text" name="departamento" id="departamento" 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                                <input type="text" name="especialidad" id="especialidad" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                                <select name="cargo" id="cargo" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all">
                                    <option value="">-- Seleccionar Cargo --</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="Jefe de Estudios">Jefe de Estudios</option>
                                    <option value="Director">Director</option>
                                    <option value="Coordinador">Coordinador</option>
                                    <option value="Tutor">Tutor</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600 mb-4">
                    <div class="flex items-center bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Al crear un docente, se generará automáticamente una contraseña temporal que será enviada al correo electrónico proporcionado.</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModalDocente()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="submitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Guardar Docente
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Nuevo Departamento -->
<div id="modalNuevoDepartamento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Crear Nuevo Departamento
                </h3>
                <button onclick="closeModalDepartamento()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formNuevoDepartamento" action="{{ route('institucion.departamentos.store') }}" method="POST" class="p-6">
            @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento *</label>
                            <input type="text" name="nombre" id="nombre" required 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Nombre descriptivo para el departamento</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all"></textarea>
                            <p class="mt-1 text-xs text-gray-500">Una breve descripción de las funciones del departamento</p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="jefe_departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Jefe de Departamento</label>
                            <select name="jefe_departamento_id" id="jefe_departamento_id" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all">
                                <option value="">-- Seleccionar Jefe de Departamento --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">
                                        {{ $docente->user->nombre }} ({{ $docente->especialidad }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Opcional - Puede asignarlo más tarde</p>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Después de crear el departamento, podrás asignar docentes a este departamento desde la vista de detalles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t mt-6">
                    <button type="button" onclick="closeModalDepartamento()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Guardar Departamento
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Nueva Clase -->
<div id="modalNuevaClase" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 backdrop-blur-sm transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 w-full max-w-2xl transform transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 py-4 px-6 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Crear Nueva Clase
                </h3>
                <button onclick="closeModalClase()" class="text-white hover:text-gray-200 focus:outline-none transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

            <form id="formNuevaClase" action="{{ route('institucion.clases.store') }}" method="POST" class="p-6">
            @csrf
                <!-- Información Básica -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full mr-2 text-green-600">1</div>
                        Información Básica
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Clase *</label>
                            <input type="text" name="nombre" id="nombre" required 
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                            <p class="mt-1 text-xs text-gray-500">Ejemplo: "DAW2 - Desarrollo de Aplicaciones Web"</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código de Clase *</label>
                                <input type="text" name="codigo" id="codigo" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Código único para identificar la clase</p>
                            </div>
                            
                            <div>
                                <label for="anyo_academico" class="block text-sm font-medium text-gray-700 mb-1">Año Académico *</label>
                                <input type="text" name="anyo_academico" id="anyo_academico" required 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Ejemplo: "2023-2024"</p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="2" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Asignaciones -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full mr-2 text-green-600">2</div>
                        Asignaciones
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                        <div>
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento *</label>
                            <select name="departamento_id" id="departamento_id" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                <option value="">-- Seleccionar Departamento --</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="tutor_id" class="block text-sm font-medium text-gray-700 mb-1">Tutor de Clase *</label>
                            <select name="tutor_id" id="tutor_id" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm transition-all">
                                <option value="">-- Seleccionar Tutor --</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">{{ $docente->user->nombre }} ({{ $docente->especialidad }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600 mb-4">
                    <div class="flex items-center bg-green-50 p-3 rounded-lg border border-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Después de crear la clase, podrás asignar más docentes y alumnos en la vista de detalles.</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModalClase()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-teal-600 border border-transparent rounded-lg hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-lg">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Guardar Clase
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts para los modales -->
<script>
    // Funciones para el modal de docente
    window.openModalDocente = function() {
        const modal = document.getElementById('modalNuevoDocente');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animación de entrada
            setTimeout(() => {
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
            }, 10);
            
            // Scroll al inicio del modal y focus primer input
            setTimeout(() => {
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
        }
    };
    
    window.closeModalDocente = function() {
        const modal = document.getElementById('modalNuevoDocente');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
                
                const form = document.getElementById('formNuevoDocente');
                if (form) {
                    form.reset();
                }
            }, 200);
        }
    };
    
    window.toggleDepartamentoManual = function() {
        const departamentoSelect = document.getElementById('departamento_id');
        const departamentoManualContainer = document.getElementById('departamento_manual_container');
        
        if (departamentoSelect && departamentoManualContainer) {
            if (departamentoSelect.value) {
                departamentoManualContainer.style.display = 'none';
            } else {
                departamentoManualContainer.style.display = '';
            }
        }
    };
    
    // Funciones para el modal de departamento
    window.openModalDepartamento = function() {
        const modal = document.getElementById('modalNuevoDepartamento');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animación de entrada
            setTimeout(() => {
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
            }, 10);
            
            // Scroll al inicio del modal y focus primer input
            setTimeout(() => {
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
        }
    };
    
    window.closeModalDepartamento = function() {
        const modal = document.getElementById('modalNuevoDepartamento');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
                
                const form = document.getElementById('formNuevoDepartamento');
                if (form) {
                    form.reset();
                }
            }, 200);
        }
    };
    
    // Funciones para el modal de clase
    window.openModalClase = function() {
        const modal = document.getElementById('modalNuevaClase');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Animación de entrada
            setTimeout(() => {
                const modalContent = modal.querySelector('.relative');
                if (modalContent) {
                    modalContent.classList.add('animate-fadeIn');
                }
            }, 10);
            
            // Scroll al inicio del modal y focus primer input
            setTimeout(() => {
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) firstInput.focus();
            }, 300);
        }
    };
    
    window.closeModalClase = function() {
        const modal = document.getElementById('modalNuevaClase');
        if (modal) {
            // Animación de salida
            const modalContent = modal.querySelector('.relative');
            if (modalContent) {
                modalContent.classList.remove('animate-fadeIn');
                modalContent.classList.add('animate-fadeOut');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                
                if (modalContent) {
                    modalContent.classList.remove('animate-fadeOut');
                }
                
                const form = document.getElementById('formNuevaClase');
                if (form) {
                    form.reset();
                }
            }, 200);
        }
    };
    
    // Configuración al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        toggleDepartamentoManual();
        
        // Cerrar modal al hacer clic fuera
        const modalNuevoDocente = document.getElementById('modalNuevoDocente');
        if (modalNuevoDocente) {
            modalNuevoDocente.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModalDocente();
                }
            });
        
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevoDocente.classList.contains('hidden')) {
                    closeModalDocente();
                }
            });
        }
        
        // Cerrar modal al hacer clic fuera
        const modalNuevoDepartamento = document.getElementById('modalNuevoDepartamento');
        if (modalNuevoDepartamento) {
            modalNuevoDepartamento.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModalDepartamento();
                }
            });
        
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevoDepartamento.classList.contains('hidden')) {
                    closeModalDepartamento();
                }
            });
        }
        
        // Cerrar modal al hacer clic fuera
        const modalNuevaClase = document.getElementById('modalNuevaClase');
        if (modalNuevaClase) {
            modalNuevaClase.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModalClase();
                }
            });
        
            // Cerrar con tecla Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modalNuevaClase.classList.contains('hidden')) {
                    closeModalClase();
                }
            });
        }
    });
</script>
@endsection 