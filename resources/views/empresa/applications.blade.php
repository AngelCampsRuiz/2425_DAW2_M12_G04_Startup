@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Solicitudes</h1>
                    <p class="text-gray-600 mt-1">{{ $publication->titulo }}</p>
                </div>
                <a href="{{ route('empresa.dashboard') }}" 
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver al panel
                </a>
            </div>
        </div>

        <!-- Publication Details Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Detalles de la Oferta</h2>
                    <div class="space-y-3">
                        <p class="text-gray-600"><span class="font-medium">Horario:</span> {{ ucfirst($publication->horario) }}</p>
                        <p class="text-gray-600"><span class="font-medium">Horas totales:</span> {{ $publication->horas_totales }}</p>
                        <p class="text-gray-600"><span class="font-medium">Categoría:</span> {{ $publication->categoria->nombre }}</p>
                        <p class="text-gray-600"><span class="font-medium">Subcategoría:</span> {{ $publication->subcategoria->nombre }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                    <p class="text-gray-600">{{ $publication->descripcion }}</p>
                </div>
            </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Solicitudes Recibidas</h2>

            @if($applications->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay solicitudes</h3>
                    <p class="mt-1 text-sm text-gray-500">Aún no has recibido solicitudes para esta oferta.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($applications as $application)
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <img src="{{ $application->student->avatar_url ?? asset('assets/images/default-avatar.png') }}" 
                                             alt="{{ $application->student->user->nombre }}"
                                             class="h-12 w-12 rounded-full object-cover">
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-800">
                                                {{ $application->student->user->nombre }}
                                            </h3>
                                            <p class="text-gray-600">{{ $application->student->centro_estudios }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Fecha de solicitud</p>
                                            <p class="font-medium">{{ $application->created_at->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Estado</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $application->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($application->estado === 'aceptada' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($application->estado) }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($application->mensaje)
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500">Mensaje del estudiante</p>
                                            <p class="mt-1 text-gray-700">{{ $application->mensaje }}</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-6 flex flex-col space-y-2">
                                    @if($application->student->cv_pdf)
                                        <a href="{{ asset('storage/' . $application->student->cv_pdf) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            Ver CV
                                        </a>
                                    @endif

                                    @if($application->estado === 'pendiente')
                                        <form action="{{ route('empresa.applications.update', [$publication->id, $application->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="accept"
                                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark">
                                                Aceptar
                                            </button>
                                            <button type="submit" name="action" value="reject"
                                                    class="w-full mt-2 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                                Rechazar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 