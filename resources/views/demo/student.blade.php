@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Banner de demostración -->
    <div class="bg-yellow-100 border-b border-yellow-200 p-4 text-center">
        <p class="text-yellow-800 font-medium">
            <span class="font-bold">Vista de demostración</span> - Así se vería la plataforma si fueras un estudiante. 
            <a href="{{ route('register.alumno') }}" class="text-purple-700 underline font-bold">Regístrate ahora</a> para acceder a todas las funcionalidades.
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
                            <h2 class="text-lg font-bold">Demo Estudiante</h2>
                            <p class="text-gray-600">Estudiante</p>
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-600 mb-2">Centro: <span class="font-medium">Instituto Demo</span></p>
                        <p class="text-gray-600 mb-2">Ciclo: <span class="font-medium">Desarrollo de Aplicaciones Web</span></p>
                        <p class="text-gray-600">Estado: <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Buscando prácticas</span></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Menú</h3>
                    <nav>
                        <ul class="space-y-2">
                            <li><a href="#" class="block p-2 bg-purple-100 text-purple-700 rounded font-medium">Dashboard</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mi perfil</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mis solicitudes</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mis favoritos</a></li>
                            <li><a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">Mensajes</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Ofertas de prácticas destacadas</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(isset($publicaciones) && $publicaciones->count() > 0)
                            @foreach($publicaciones as $publicacion)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-bold text-lg text-gray-800">{{ $publicacion->titulo }}</h3>
                                        <button onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="text-purple-600 hover:text-purple-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-gray-600 mb-3">{{ Str::limit($publicacion->descripcion, 100) }}</p>
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $publicacion->empresa->user->nombre }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">{{ $publicacion->categoria }}</span>
                                        <a href="#" onclick="event.preventDefault(); window.location='{{ route('demo.redirect', ['type' => 'alumno']) }}';" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Ver detalles →</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-center py-8">
                                <p class="text-gray-500">No hay ofertas disponibles en este momento.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tu progreso</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="font-medium text-purple-800 mb-1">Solicitudes enviadas</h3>
                            <p class="text-2xl font-bold text-purple-900">3</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="font-medium text-green-800 mb-1">Entrevistas programadas</h3>
                            <p class="text-2xl font-bold text-green-900">1</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="font-medium text-blue-800 mb-1">Ofertas guardadas</h3>
                            <p class="text-2xl font-bold text-blue-900">5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
