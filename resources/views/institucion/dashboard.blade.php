@extends('layouts.institucion')

@section('title', 'Dashboard de Institución')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Panel de Control</h1>
    
    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Tarjeta: Total de Docentes -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-5 bg-indigo-600 text-white">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg">Docentes</h2>
                    <i class="fas fa-chalkboard-teacher text-3xl"></i>
                </div>
            </div>
            <div class="p-5">
                <div class="text-4xl font-bold text-gray-800">{{ $totalDocentes }}</div>
                <div class="text-sm text-gray-600 mt-1 font-medium">Total de profesores</div>
                <div class="mt-4">
                    <a href="{{ route('institucion.docentes.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-sm font-medium transition-colors duration-200">
                        Ver todos <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Total de Departamentos -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-5 bg-purple-600 text-white">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg">Departamentos</h2>
                    <i class="fas fa-building text-3xl"></i>
                </div>
            </div>
            <div class="p-5">
                <div class="text-4xl font-bold text-gray-800">{{ $totalDepartamentos }}</div>
                <div class="text-sm text-gray-600 mt-1 font-medium">Total de departamentos</div>
                <div class="mt-4">
                    <a href="{{ route('institucion.departamentos.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg text-sm font-medium transition-colors duration-200">
                        Ver todos <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Total de Clases -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-5 bg-blue-600 text-white">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg">Clases</h2>
                    <i class="fas fa-graduation-cap text-3xl"></i>
                </div>
            </div>
            <div class="p-5">
                <div class="text-4xl font-bold text-gray-800">{{ $totalClases }}</div>
                <div class="text-sm text-gray-600 mt-1 font-medium">Total de clases</div>
                <div class="mt-4">
                    <a href="{{ route('institucion.clases.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors duration-200">
                        Ver todas <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Solicitudes Pendientes -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="p-5 bg-orange-600 text-white">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg">Solicitudes</h2>
                    <i class="fas fa-envelope text-3xl"></i>
                </div>
            </div>
            <div class="p-5">
                <div class="text-4xl font-bold text-gray-800">{{ $solicitudesPendientes }}</div>
                <div class="text-sm text-gray-600 mt-1 font-medium">Solicitudes pendientes</div>
                <div class="mt-4">
                    <a href="{{ route('institucion.solicitudes.index') }}" class="inline-flex items-center px-4 py-2 bg-orange-50 text-orange-700 hover:bg-orange-100 rounded-lg text-sm font-medium transition-colors duration-200">
                        Ver todas <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="mt-10 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-5 border-b pb-3">
            <i class="fas fa-bolt text-amber-500 mr-3 text-xl"></i>
            <h2 class="text-xl font-bold text-gray-800">Acciones Rápidas</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <!-- Crear Docente -->
            <a href="{{ route('institucion.docentes.create') }}" class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md border border-indigo-100 hover:border-indigo-300 transition-all duration-300 flex items-center group">
                <div class="bg-indigo-100 group-hover:bg-indigo-200 rounded-full p-4 mr-4 transition-colors duration-300">
                    <i class="fas fa-user-plus text-indigo-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Docente</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear un nuevo profesor</p>
                </div>
            </a>

            <!-- Crear Departamento -->
            <a href="{{ route('institucion.departamentos.create') }}" class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md border border-purple-100 hover:border-purple-300 transition-all duration-300 flex items-center group">
                <div class="bg-purple-100 group-hover:bg-purple-200 rounded-full p-4 mr-4 transition-colors duration-300">
                    <i class="fas fa-plus-circle text-purple-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Departamento</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear un nuevo departamento</p>
                </div>
            </a>

            <!-- Crear Clase -->
            <a href="{{ route('institucion.clases.create') }}" class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md border border-blue-100 hover:border-blue-300 transition-all duration-300 flex items-center group">
                <div class="bg-blue-100 group-hover:bg-blue-200 rounded-full p-4 mr-4 transition-colors duration-300">
                    <i class="fas fa-school text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Agregar Clase</h3>
                    <p class="text-sm text-gray-600 mt-1">Crear una nueva clase</p>
                </div>
            </a>

            <!-- Revisar Solicitudes -->
            <a href="{{ route('institucion.solicitudes.index') }}" class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md border border-orange-100 hover:border-orange-300 transition-all duration-300 flex items-center group">
                <div class="bg-orange-100 group-hover:bg-orange-200 rounded-full p-4 mr-4 transition-colors duration-300">
                    <i class="fas fa-clipboard-check text-orange-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-base text-gray-800">Revisar Solicitudes</h3>
                    <p class="text-sm text-gray-600 mt-1">Ver solicitudes pendientes</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Información de la Institución -->
    <div class="mt-10 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-5 border-b pb-3">
            <i class="fas fa-university text-gray-700 mr-3 text-xl"></i>
            <h2 class="text-xl font-bold text-gray-800">Información de la Institución</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Nombre:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $institucion->user->nombre }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Código del Centro:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $institucion->codigo_centro }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Tipo de Institución:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $institucion->tipo_institucion }}</span>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Representante Legal:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $institucion->representante_legal }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Cargo del Representante:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $institucion->cargo_representante }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <span class="text-gray-500 font-medium text-sm block mb-1">Estudiantes:</span>
                    <span class="font-semibold text-gray-800 text-base">{{ $totalEstudiantes }}</span>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('institucion.perfil') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors duration-300">
                <i class="fas fa-pencil-alt mr-2"></i> Editar información
            </a>
        </div>
    </div>
</div>
@endsection 