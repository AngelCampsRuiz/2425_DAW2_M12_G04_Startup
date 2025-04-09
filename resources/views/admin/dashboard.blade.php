{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex flex-wrap">
                <a href="{{ route('admin.publicaciones.index') }}" class="flex-1 {{ request()->routeIs('admin.publicaciones.*') ? 'bg-purple-200 text-purple-800' : 'bg-gray-100 text-gray-800' }} font-semibold py-3 px-4 rounded-md text-center mx-1">
                    OFERTAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    CATEGORÍAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    EMPRESAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    ALUMNOS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    PROFESORES
                </a>
            </div>
        </div>

        @if(request()->routeIs('admin.dashboard'))
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-6 text-purple-800">Panel de Administración</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Publicaciones</h3>
                        </div>
                        <p class="text-gray-600">Gestiona las ofertas de prácticas para los estudiantes.</p>
                        <div class="mt-4">
                            <a href="{{ route('admin.publicaciones.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Gestionar publicaciones →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Empresas</h3>
                        </div>
                        <p class="text-gray-600">Administra las empresas colaboradoras con la plataforma.</p>
                        <div class="mt-4">
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium">
                                Gestionar empresas →
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Alumnos</h3>
                        </div>
                        <p class="text-gray-600">Gestiona los perfiles de estudiantes registrados.</p>
                        <div class="mt-4">
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                                Gestionar alumnos →
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Actividad reciente</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva oferta de prácticas añadida</p>
                                <p class="text-gray-500 text-sm">Hace 2 horas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nueva empresa registrada</p>
                                <p class="text-gray-500 text-sm">Hace 1 día</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-2 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-800 font-medium">Nuevo alumno registrado</p>
                                <p class="text-gray-500 text-sm">Hace 3 días</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('admin_content')
    </div>
@endsection
