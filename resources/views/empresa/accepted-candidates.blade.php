@extends('layouts.app')

@section('title', 'Candidatos Aceptados')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar/Menú -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Panel de empresa</h2>
                <div class="border-b border-gray-200 pb-2 mb-4">
                    <div class="flex items-center mb-4">
                        @if(Auth::user()->empresa && Auth::user()->empresa->logo)
                            <img src="{{ asset('storage/' . Auth::user()->empresa->logo) }}" alt="Logo empresa" class="h-12 w-12 rounded-full mr-3 object-cover">
                        @else
                            <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center text-white text-lg font-bold mr-3">
                                {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->nombre }}</p>
                            <p class="text-sm text-gray-600">Empresa</p>
                        </div>
                    </div>
                </div>
                <div>
                    <nav>
                        <ul class="space-y-2">
                            <li><a href="{{ route('empresa.dashboard') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a></li>
                            <li><a href="{{ route('empresa.offers.create') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Crear Oferta
                            </a></li>
                            <li><a href="{{ route('empresa.offers.active') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Ofertas Activas
                            </a></li>
                            <li><a href="{{ route('empresa.offers.inactive') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ofertas Inactivas
                            </a></li>
                            <li><a href="{{ route('empresa.offers.accepted-candidates') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.accepted-candidates' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.accepted-candidates' ? 'text-purple-600' : 'text-green-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Candidatos Aceptados
                            </a></li>
                            <li><a href="{{ route('empresa.convenios') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.convenios' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.convenios' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Convenios
                            </a></li>
                            <li><a href="{{ route('chat.index') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'chat.index' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'chat.index' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Mensajes
                            </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="w-full md:w-3/4 md:pl-6">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Candidatos Aceptados
                </h1>

                <!-- Lista de candidatos aceptados -->
                <div class="space-y-6">
                    @forelse($solicitudes as $solicitud)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <div class="grid grid-cols-1 md:grid-cols-5">
                                <!-- Información del candidato (2 columnas) -->
                                <div class="md:col-span-2 p-5 border-b md:border-b-0 md:border-r border-gray-200 bg-gray-50">
                                    <div class="flex items-center mb-4">
                                        @if($solicitud->estudiante->user->imagen)
                                            <img src="{{ asset('storage/' . $solicitud->estudiante->user->imagen) }}" alt="{{ $solicitud->estudiante->user->nombre }}" class="h-12 w-12 rounded-full mr-4 object-cover border-2 border-green-100">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-green-600 flex items-center justify-center text-white text-lg font-bold mr-4 border-2 border-green-100">
                                                {{ strtoupper(substr($solicitud->estudiante->user->nombre, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-800">{{ $solicitud->estudiante->user->nombre }}</h3>
                                            <p class="text-sm text-gray-600">{{ $solicitud->estudiante->user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Aceptado: <strong>{{ \Carbon\Carbon::parse($solicitud->updated_at)->format('d/m/Y') }}</strong></span>
                                        </div>
                                        @if($solicitud->estudiante->user->telefono)
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span>{{ $solicitud->estudiante->user->telefono }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Información de la oferta (2 columnas) -->
                                <div class="md:col-span-2 p-5 border-b md:border-b-0 md:border-r border-gray-200">
                                    <h3 class="font-semibold text-gray-800 mb-2">{{ $solicitud->publicacion->titulo }}</h3>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Horario: <strong>{{ ucfirst($solicitud->publicacion->horario) }}</strong></span>
                                        </div>
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span>Horas totales: <strong>{{ $solicitud->publicacion->horas_totales }}</strong></span>
                                        </div>
                                        <div class="flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Publicada: <strong>{{ \Carbon\Carbon::parse($solicitud->publicacion->fecha_publicacion)->format('d/m/Y') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Acciones (1 columna) -->
                                <div class="p-5 flex flex-col justify-center items-center bg-gray-50">
                                    <div class="w-full space-y-2">
                                        @if($solicitud->chat)
                                            <a href="{{ route('chat.show', $solicitud->chat->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                Ver Chat
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('empresa.convenios') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Ver Convenios
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 p-8 rounded-lg text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No tienes candidatos aceptados</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Cuando aceptes candidatos para tus ofertas, aparecerán en esta sección para que puedas gestionarlos fácilmente.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $solicitudes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 