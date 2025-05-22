@extends('layouts.institucion')

@section('title', 'Convenios Pendientes de Firma')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-teal-50">
    <!-- Cabecera de página con estadísticas -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Convenios Pendientes de Firma
                </h1>
                <p class="text-gray-600 mt-1">Gestiona los convenios que requieren firma institucional</p>
            </div>
            <a href="{{ route('institucion.convenios.firmados') }}" class="bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Ver Firmados
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Listado de convenios con diseño de tarjetas -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($convenios as $convenio)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    <!-- Información del estudiante -->
                    <div class="w-full md:w-1/4 bg-gradient-to-br from-teal-50 to-teal-100 p-6">
                        <div class="flex items-center">
                            @if($convenio->estudiante->imagen)
                                <img class="h-12 w-12 rounded-full mr-4 border-2 border-white shadow-md" src="{{ asset('storage/' . $convenio->estudiante->imagen) }}" alt="{{ $convenio->estudiante->nombre }}">
                            @else
                                <div class="h-12 w-12 rounded-full mr-4 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white font-bold text-lg border-2 border-white shadow-md">
                                    {{ strtoupper(substr($convenio->estudiante->nombre, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $convenio->estudiante->nombre }}</h3>
                                <p class="text-sm text-gray-600">{{ $convenio->estudiante->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-700">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Fecha Aprobación: <strong>{{ $convenio->fecha_aprobacion ? $convenio->fecha_aprobacion->format('d/m/Y') : 'Pendiente' }}</strong></span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Estado: <strong class="text-amber-600">Pendiente de firma</strong></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de la empresa y convenio -->
                    <div class="w-full md:w-2/4 p-6 border-t md:border-t-0 md:border-l md:border-r border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Información de la Empresa
                        </h3>
                        <div class="mb-4">
                            <p class="text-gray-700"><span class="font-medium">Empresa:</span> {{ $convenio->oferta->empresa->nombre }}</p>
                            <p class="text-gray-700 mt-1"><span class="font-medium">Oferta:</span> {{ $convenio->oferta->titulo }}</p>
                            <p class="text-gray-700 mt-1"><span class="font-medium">Tutor Empresa:</span> {{ $convenio->tutor_empresa }}</p>
                        </div>
                        
                        <h3 class="font-bold text-gray-800 mb-3 mt-5 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Fechas del Convenio
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-teal-50 rounded-lg p-3">
                                <p class="text-xs text-teal-600 font-medium">FECHA INICIO</p>
                                <p class="text-lg text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($convenio->fecha_inicio)->format('d/m/Y') }}</p>
                            </div>
                            <div class="bg-teal-50 rounded-lg p-3">
                                <p class="text-xs text-teal-600 font-medium">FECHA FIN</p>
                                <p class="text-lg text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($convenio->fecha_fin)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Acciones -->
                    <div class="w-full md:w-1/4 p-6 bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 mb-3">Acciones</h3>
                            <div class="space-y-3">
                                <a href="{{ route('institucion.convenios.show', $convenio) }}" class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver Detalles
                                </a>
                                
                                <a href="{{ route('institucion.convenios.download', $convenio) }}" class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Descargar PDF
                                </a>
                            </div>
                        </div>
                        
                        <form action="{{ route('institucion.convenios.firmar', $convenio) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Firmar Convenio
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay convenios pendientes de firma</h3>
                <p class="text-gray-500 max-w-md mx-auto">Cuando los docentes aprueben nuevos convenios, aparecerán aquí para que puedas firmarlos.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $convenios->links() }}
    </div>
</div>
@endsection 