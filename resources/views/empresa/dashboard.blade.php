{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Panel de Empresa</h1>
                <p class="text-gray-600 mt-1">Gestiona tus ofertas y solicitudes</p>
            </div>
            <a href="{{ route('empresa.offers.create') }}" 
               class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva Oferta
            </a>
        </div>

        <!-- Active Publications Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ofertas Activas</h2>
            @if($activePublications->isEmpty())
                <p class="text-gray-500 text-center py-4">No tienes ofertas activas actualmente.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activePublications as $publication)
                        <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $publication->titulo }}</h3>
                                <div class="flex items-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Activa</span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $publication->descripcion }}</p>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ ucfirst($publication->horario) }} - {{ $publication->horas_totales }} horas
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('empresa.applications.view', $publication->id) }}" 
                                   class="text-primary hover:text-primary-dark font-medium text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver solicitudes ({{ $publication->applications_count }})
                                </a>
                                <form action="{{ route('empresa.offers.toggle', $publication->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Desactivar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Inactive Publications Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ofertas Inactivas</h2>
            @if($inactivePublications->isEmpty())
                <p class="text-gray-500 text-center py-4">No tienes ofertas inactivas.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($inactivePublications as $publication)
                        <div class="border rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $publication->titulo }}</h3>
                                <div class="flex items-center">
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactiva</span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $publication->descripcion }}</p>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ ucfirst($publication->horario) }} - {{ $publication->horas_totales }} horas
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('empresa.applications.view', $publication->id) }}" 
                                   class="text-primary hover:text-primary-dark font-medium text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver solicitudes ({{ $publication->applications_count }})
                                </a>
                                <form action="{{ route('empresa.offers.toggle', $publication->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-primary hover:text-primary-dark font-medium text-sm">
                                        Activar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

