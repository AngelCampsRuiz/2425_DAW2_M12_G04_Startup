@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gray-50">
    {{-- BREADCRUMBS --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200">
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
        <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
            <svg class="w-8 h-8 mr-3 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Mis Solicitudes
        </h1>
        
        {{-- ESTADÍSTICAS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-[#5e0490]">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-4 mr-4">
                        <svg class="w-7 h-7 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-800" id="stats-total">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-yellow-400">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-4 mr-4">
                        <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-800" id="stats-pendientes">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-green-500">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-4 mr-4">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Aceptadas</p>
                        <p class="text-2xl font-bold text-gray-800" id="stats-aprobadas">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-red-500">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-100 p-4 mr-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rechazadas</p>
                        <p class="text-2xl font-bold text-gray-800" id="stats-rechazadas">0</p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- FILTROS --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filtrar por estado
                </h2>
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="#" data-estado="todos" class="estado-link px-5 py-2.5 rounded-lg bg-purple-100 text-[#5e0490] font-medium transition-all duration-200 hover:shadow-md flex items-center">
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-[#5e0490]"></span>
                        </span>
                        Todas
                    </a>
                    <a href="#" data-estado="pendiente" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-yellow-50 hover:text-yellow-700 hover:shadow-md flex items-center">
                        <span class="h-3 w-3 mr-2 rounded-full bg-yellow-400"></span>
                        Pendientes
                    </a>
                    <a href="#" data-estado="aceptada" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md flex items-center">
                        <span class="h-3 w-3 mr-2 rounded-full bg-green-500"></span>
                        Aceptadas
                    </a>
                    <a href="#" data-estado="rechazada" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-red-50 hover:text-red-700 hover:shadow-md flex items-center">
                        <span class="h-3 w-3 mr-2 rounded-full bg-red-500"></span>
                        Rechazadas
                    </a>
                </div>
            </div>
        </div>
        
        {{-- TABLA DE SOLICITUDES CON AJAX --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- INDICADOR DE CARGA --}}
            <div id="loading-indicator" class="p-8">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                    <div class="h-8 bg-gray-200 rounded-lg w-1/3 animate-pulse"></div>
                    <div class="h-8 bg-gray-200 rounded-lg w-24 animate-pulse"></div>
                </div>
                
                {{-- Skeleton table header --}}
                <div class="mb-4 grid grid-cols-5 gap-4 px-6 py-3 bg-gray-50">
                    <div class="h-4 bg-gray-200 rounded w-2/3 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 rounded w-2/3 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 rounded w-2/3 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 rounded w-2/3 animate-pulse"></div>
                    <div class="h-4 bg-gray-200 rounded w-2/3 animate-pulse"></div>
                </div>
                
                {{-- Skeleton rows --}}
                <div class="space-y-4 px-6 pb-6">
                    {{-- Row 1 --}}
                    <div class="grid grid-cols-5 gap-4 py-4 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full animate-pulse"></div>
                            <div class="ml-3 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-24 animate-pulse"></div>
                                <div class="h-3 bg-gray-200 rounded w-16 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-32 animate-pulse"></div>
                            <div class="h-3 bg-gray-200 rounded w-40 animate-pulse"></div>
                        </div>
                        <div class="h-8 bg-gray-200 rounded w-24 animate-pulse self-center"></div>
                        <div class="h-6 bg-gray-200 rounded-full w-20 animate-pulse self-center"></div>
                        <div class="flex space-x-2 self-center">
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                        </div>
                    </div>
                    
                    {{-- Row 2 --}}
                    <div class="grid grid-cols-5 gap-4 py-4 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full animate-pulse"></div>
                            <div class="ml-3 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-32 animate-pulse"></div>
                                <div class="h-3 bg-gray-200 rounded w-20 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-36 animate-pulse"></div>
                            <div class="h-3 bg-gray-200 rounded w-28 animate-pulse"></div>
                        </div>
                        <div class="h-8 bg-gray-200 rounded w-24 animate-pulse self-center"></div>
                        <div class="h-6 bg-gray-200 rounded-full w-20 animate-pulse self-center"></div>
                        <div class="flex space-x-2 self-center">
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                        </div>
                    </div>
                    
                    {{-- Row 3 --}}
                    <div class="grid grid-cols-5 gap-4 py-4 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full animate-pulse"></div>
                            <div class="ml-3 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-28 animate-pulse"></div>
                                <div class="h-3 bg-gray-200 rounded w-16 animate-pulse"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-40 animate-pulse"></div>
                            <div class="h-3 bg-gray-200 rounded w-32 animate-pulse"></div>
                        </div>
                        <div class="h-8 bg-gray-200 rounded w-24 animate-pulse self-center"></div>
                        <div class="h-6 bg-gray-200 rounded-full w-20 animate-pulse self-center"></div>
                        <div class="flex space-x-2 self-center">
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                            <div class="w-8 h-8 bg-gray-200 rounded-lg animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- CONTENEDOR PARA LA TABLA --}}
            <div id="solicitudes-table" class="overflow-x-auto hidden">
                <div id="solicitudes-data-container">
                    {{-- Aquí se cargará la tabla mediante AJAX --}}
                </div>
            </div>
            
            {{-- MENSAJE DE NO SOLICITUDES --}}
            <div id="no-solicitudes" class="text-center py-16 hidden">
                <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No hay solicitudes</h3>
                <p class="mt-1 text-gray-500 max-w-md mx-auto">
                    No se encontraron solicitudes con los filtros seleccionados. Prueba con otro filtro o envía nuevas solicitudes.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 para alertas modales --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- CARGAR SCRIPT PARA AJAX --}}
<script src="{{ asset('js/estudiante-solicitudes.js') }}"></script>

{{-- Manejar mensajes de éxito --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 relative mb-4">
                            <div class="absolute inset-0 rounded-full bg-green-100"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-16 h-16 text-green-500 animate__animated animate__bounceIn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">¡Operación completada!</h2>
                        <p class="text-gray-600">{{ session('success') }}</p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: '<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Entendido</div>',
                confirmButtonColor: '#5e0490',
                timer: 5000,
                timerProgressBar: true,
                background: 'rgba(255, 255, 255, 0.98)',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                },
                customClass: {
                    confirmButton: 'rounded-xl px-6 py-3 font-medium text-white shadow-lg hover:shadow-purple-500/30 transition-all duration-200',
                    timerProgressBar: 'bg-[#5e0490]'
                }
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 relative mb-4">
                            <div class="absolute inset-0 rounded-full bg-red-100"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-16 h-16 text-red-500 animate__animated animate__shakeX" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">Error</h2>
                        <p class="text-gray-600">{{ session('error') }}</p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: '<div class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Entendido</div>',
                confirmButtonColor: '#e11d48',
                background: 'rgba(255, 255, 255, 0.98)',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                },
                customClass: {
                    confirmButton: 'rounded-xl px-6 py-3 font-medium text-white shadow-lg hover:shadow-red-500/30 transition-all duration-200'
                }
            });
        @endif
    });
</script>
@endsection 