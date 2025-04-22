@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Banner de demostración -->
    <div class="bg-yellow-100 border-b border-yellow-200 p-4 text-center">
        <p class="text-yellow-800 font-medium">
            <span class="font-bold">Vista de demostración</span> - Así se vería la plataforma si fueras una empresa. 
            <a href="{{ route('register.empresa') }}" class="text-purple-700 underline font-bold">Regístrate ahora</a> para acceder a todas las funcionalidades.
        </p>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="bg-white shadow-sm mb-8">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="#" class="text-gray-500 hover:text-[#5e0490]">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-[#5e0490] font-medium">Dashboard</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 text-xl font-bold">
                            DE
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Demo Empresa</h2>
                            <p class="text-gray-600">Empresa</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-600 mb-2">CIF: <span class="font-medium">B12345678</span></p>
                        <p class="text-gray-600 mb-2">Sector: <span class="font-medium">Tecnología</span></p>
                        <p class="text-gray-600">Estado: <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Activa</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Menú</h3>
                    <nav>
                        <ul class="space-y-2">
                            <li><a href="#" class="block p-2 bg-purple-100 text-purple-700 rounded font-medium">Dashboard</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Perfil de empresa</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Publicar oferta</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mensajes</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de empresa</h1>
                    
                    <!-- Estadísticas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-medium text-purple-800 mb-1">Ofertas activas</h3>
                            <p class="text-2xl font-bold text-purple-900">3</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-medium text-green-800 mb-1">Total solicitudes</h3>
                            <p class="text-2xl font-bold text-green-900">15</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-medium text-blue-800 mb-1">Solicitudes pendientes</h3>
                            <p class="text-2xl font-bold text-blue-900">8</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-medium text-yellow-800 mb-1">Ofertas inactivas</h3>
                            <p class="text-2xl font-bold text-yellow-900">2</p>
                        </div>
                    </div>

                    <!-- Ofertas Activas -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Ofertas Activas</h2>
                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Publicar nueva →</a>
                        </div>
                        
                        <div class="border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitudes</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Desarrollador Web Frontend</div>
                                            <div class="text-sm text-gray-500">Creación de interfaces web utilizando React y TailwindCSS...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Mañana</div>
                                            <div class="text-sm text-gray-500">350 horas</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Activa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            6
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-red-600 hover:text-red-900">Desactivar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Desarrollador Backend PHP</div>
                                            <div class="text-sm text-gray-500">Desarrollo de APIs y sistemas backend con Laravel...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Tarde</div>
                                            <div class="text-sm text-gray-500">400 horas</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Activa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            4
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-red-600 hover:text-red-900">Desactivar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Diseñador UX/UI</div>
                                            <div class="text-sm text-gray-500">Diseño de interfaces de usuario y experiencia...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Mañana</div>
                                            <div class="text-sm text-gray-500">300 horas</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Activa
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            5
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-red-600 hover:text-red-900">Desactivar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Ofertas Inactivas -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Ofertas Inactivas</h2>
                        </div>
                        
                        <div class="border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitudes</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Desarrollador Mobile</div>
                                            <div class="text-sm text-gray-500">Desarrollo de aplicaciones móviles con Flutter...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Tarde</div>
                                            <div class="text-sm text-gray-500">350 horas</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactiva
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            3
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900">Activar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">DevOps Engineer</div>
                                            <div class="text-sm text-gray-500">Implementación de infraestructura y CI/CD...</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Mañana</div>
                                            <div class="text-sm text-gray-500">400 horas</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactiva
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            2
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Ver solicitudes</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900">Activar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
