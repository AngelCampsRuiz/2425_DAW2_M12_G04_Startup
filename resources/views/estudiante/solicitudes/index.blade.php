@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gray-100">
    {{-- BREADCRUMBS --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">Mis Solicitudes</span>
            </div>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mis Solicitudes</h1>
        
        {{-- ESTADÍSTICAS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 mr-4">
                        <svg class="w-6 h-6 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-xl font-bold text-gray-800" id="stats-total">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-3 mr-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendientes</p>
                        <p class="text-xl font-bold text-gray-800" id="stats-pendientes">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-3 mr-4">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Aceptadas</p>
                        <p class="text-xl font-bold text-gray-800" id="stats-aprobadas">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-100 p-3 mr-4">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Rechazadas</p>
                        <p class="text-xl font-bold text-gray-800" id="stats-rechazadas">0</p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- FILTROS --}}
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Filtrar por estado</h2>
                <div class="flex mt-2 md:mt-0">
                    <a href="#" data-estado="todos" class="estado-link px-4 py-2 rounded-lg bg-purple-100 text-[#5e0490] mr-2">
                        Todas
                    </a>
                    <a href="#" data-estado="pendiente" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 mr-2">
                        Pendientes
                    </a>
                    <a href="#" data-estado="aceptada" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 mr-2">
                        Aceptadas
                    </a>
                    <a href="#" data-estado="rechazada" class="estado-link px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Rechazadas
                    </a>
                </div>
            </div>
        </div>
        
        {{-- TABLA DE SOLICITUDES CON AJAX --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            {{-- INDICADOR DE CARGA --}}
            <div id="loading-indicator" class="p-8 flex justify-center items-center">
                <svg class="animate-spin h-10 w-10 text-[#5e0490]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            {{-- CONTENEDOR PARA LA TABLA --}}
            <div id="solicitudes-table" class="overflow-x-auto">
                <div id="solicitudes-data-container">
                    {{-- Aquí se cargará la tabla mediante AJAX --}}
                </div>
            </div>
            
            {{-- MENSAJE DE NO SOLICITUDES --}}
            <div id="no-solicitudes" class="text-center py-10 hidden">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay solicitudes</h3>
                <p class="mt-1 text-sm text-gray-500">
                    No se encontraron solicitudes con los filtros seleccionados.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- CARGAR SCRIPT PARA AJAX --}}
<script src="{{ asset('js/estudiante-solicitudes.js') }}"></script>
@endsection 