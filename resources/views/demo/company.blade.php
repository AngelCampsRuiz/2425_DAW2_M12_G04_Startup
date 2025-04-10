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
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mis ofertas</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Candidatos</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mensajes</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de empresa</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-medium text-purple-800 mb-1">Convenios gestionados</h3>
                            <p class="text-2xl font-bold text-purple-900">{{ $stats['totalConvenios'] }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-medium text-green-800 mb-1">Alumnos contratados</h3>
                            <p class="text-2xl font-bold text-green-900">{{ $stats['alumnosContratados'] }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-medium text-blue-800 mb-1">Ofertas activas</h3>
                            <p class="text-2xl font-bold text-blue-900">{{ $stats['ofertasActivas'] }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-medium text-yellow-800 mb-1">Candidatos recibidos</h3>
                            <p class="text-2xl font-bold text-yellow-900">{{ $stats['candidatosRecibidos'] }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Últimas ofertas publicadas</h2>
                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Ver todas →</a>
                        </div>
                        
                        <div class="border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidatos</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Desarrollador Web Frontend</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">Desarrollo Web</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            12
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Editar</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-red-600 hover:text-red-900">Desactivar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Desarrollador Backend PHP</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">Desarrollo Backend</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            8
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-900 mr-3">Editar</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-red-600 hover:text-red-900">Desactivar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-800">Candidatos recientes</h2>
                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Ver todos →</a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-bold mr-4">
                                        AS
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Ana Sánchez</h3>
                                        <p class="text-sm text-gray-600">Desarrollador Web Frontend</p>
                                        <div class="flex mt-2">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm mr-4">Ver perfil</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm">Contactar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start">
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-bold mr-4">
                                        JL
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-800">Jorge López</h3>
                                        <p class="text-sm text-gray-600">Desarrollador Backend PHP</p>
                                        <div class="flex mt-2">
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm mr-4">Ver perfil</a>
                                            <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'empresa']) }}';" class="text-purple-600 hover:text-purple-800 text-sm">Contactar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
