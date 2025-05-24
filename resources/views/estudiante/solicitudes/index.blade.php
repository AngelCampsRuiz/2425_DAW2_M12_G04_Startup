@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gray-50">
    {{-- BREADCRUMBS --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490] transition-colors duration-200 flex items-center group">
                    <div class="bg-gray-100 group-hover:bg-purple-100 p-1.5 rounded-lg mr-2 transition-all duration-200">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-[#5e0490] transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
                <span class="text-[#5e0490] font-medium flex items-center">
                    <div class="bg-purple-100 p-1.5 rounded-lg mr-2">
                        <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    Mis Solicitudes
                </span>
            </div>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center">
            <div class="bg-purple-100 p-3 rounded-xl mr-4 shadow-sm">
                <svg class="w-8 h-8 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span class="relative">
                Mis Solicitudes
                <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#5e0490] to-purple-300 rounded-full transform translate-y-1"></span>
            </span>
        </h1>

        {{-- ESTADÍSTICAS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-[#5e0490] hover:shadow-lg group">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-100 p-4 mr-4 group-hover:bg-purple-200 transition-colors duration-300">
                        <svg class="w-7 h-7 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-[#5e0490] transition-colors duration-300">Total</p>
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-[#5e0490] transition-colors duration-300" id="stats-total">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-yellow-400 hover:shadow-lg group">
                <div class="flex items-center">
                    <div class="rounded-full bg-yellow-100 p-4 mr-4 group-hover:bg-yellow-200 transition-colors duration-300">
                        <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-yellow-600 transition-colors duration-300">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-yellow-600 transition-colors duration-300" id="stats-pendientes">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-green-500 hover:shadow-lg group">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-100 p-4 mr-4 group-hover:bg-green-200 transition-colors duration-300">
                        <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-green-600 transition-colors duration-300">Aceptadas</p>
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300" id="stats-aprobadas">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 transform hover:scale-105 transition-transform duration-300 border-t-4 border-red-500 hover:shadow-lg group">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-100 p-4 mr-4 group-hover:bg-red-200 transition-colors duration-300">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-red-600 transition-colors duration-300">Rechazadas</p>
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-red-600 transition-colors duration-300" id="stats-rechazadas">0</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 md:mb-0 flex items-center">
                    <div class="bg-gradient-to-r from-purple-100 to-purple-50 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                    </div>
                    Filtrar por estado
                </h2>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="#" data-estado="todos" class="estado-link px-5 py-2.5 rounded-lg bg-purple-100 text-[#5e0490] font-medium transition-all duration-200 hover:shadow-md flex items-center relative overflow-hidden group">
                        <span class="absolute inset-0 bg-gradient-to-r from-[#5e0490]/5 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <span class="relative flex h-3 w-3 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-[#5e0490]"></span>
                        </span>
                        <span class="relative">Todas</span>
                    </a>
                    <a href="#" data-estado="pendiente" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-yellow-50 hover:text-yellow-700 hover:shadow-md flex items-center group">
                        <span class="h-3 w-3 mr-2 rounded-full bg-yellow-400 group-hover:animate-pulse"></span>
                        Pendientes
                    </a>
                    <a href="#" data-estado="aceptada" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-green-50 hover:text-green-700 hover:shadow-md flex items-center group">
                        <span class="h-3 w-3 mr-2 rounded-full bg-green-500 group-hover:animate-pulse"></span>
                        Aceptadas
                    </a>
                    <a href="#" data-estado="rechazada" class="estado-link px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium transition-all duration-200 hover:bg-red-50 hover:text-red-700 hover:shadow-md flex items-center group">
                        <span class="h-3 w-3 mr-2 rounded-full bg-red-500 group-hover:animate-pulse"></span>
                        Rechazadas
                    </a>
                </div>
            </div>
        </div>

        {{-- TABLA DE SOLICITUDES CON AJAX --}}
        <div id="solicitudes-table" class="overflow-x-auto hidden">
            <div id="solicitudes-data-container" class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all duration-300">
                <div class="min-w-full divide-y divide-gray-200">
                    {{-- Cabecera de la tabla con diseño mejorado --}}
                    <div class="bg-gradient-to-r from-[#5e0490]/10 to-purple-50 px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <div class="bg-white p-2 rounded-lg shadow-sm mr-3">
                                    <svg class="w-5 h-5 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                Listado de Solicitudes
                            </h3>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm bg-white px-3 py-1.5 rounded-lg shadow-sm">
                                    Total: <span id="stats-total" class="font-semibold text-[#5e0490]">0</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido de la tabla --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="group px-6 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</span>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#5e0490] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="group px-6 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Publicación</span>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#5e0490] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="group px-6 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</span>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#5e0490] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="group px-6 py-4 text-left">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</span>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#5e0490] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right">
                                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="solicitudes-tbody">
                                <!-- Aquí se insertarán las filas dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MENSAJE DE NO SOLICITUDES --}}
        <div id="no-solicitudes" class="text-center py-16 hidden">
            <div class="bg-white rounded-xl shadow-sm p-10 max-w-lg mx-auto border border-gray-100">
                <div class="mx-auto h-32 w-32 text-gray-300 mb-6 relative">
                    <div class="absolute inset-0 bg-purple-50 rounded-full animate-pulse opacity-50"></div>
                    <svg class="w-full h-full relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="mt-2 text-xl font-semibold text-gray-800">No hay solicitudes</h3>
                <p class="mt-3 text-gray-500 max-w-md mx-auto leading-relaxed">
                    No se encontraron solicitudes con los filtros seleccionados. Prueba con otro filtro o envía nuevas solicitudes.
                </p>
                <button onclick="window.history.back()" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-[#5e0490] hover:bg-[#4a0372] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5e0490] transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver atrás
                </button>
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

<style>
/* Animaciones y estilos adicionales */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.bg-shimmer {
    background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite linear;
}

.solicitud-row {
    animation: fadeIn 0.3s ease-out;
    border-left: 3px solid transparent;
    transition: all 0.3s ease;
}

.solicitud-row:hover {
    background-color: rgba(94, 4, 144, 0.05);
    border-left: 3px solid #5e0490;
    transform: translateX(3px);
}

.estado-badge {
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.estado-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: inherit;
    opacity: 0.5;
    z-index: -1;
    transform: scale(0);
    border-radius: 9999px;
    transition: all 0.3s ease;
}

.estado-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.estado-badge:hover::before {
    transform: scale(1.5);
}

.action-button {
    transition: all 0.3s ease;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Estilos para los estados */
.estado-pendiente {
    background-color: #FEF3C7;
    color: #92400E;
    box-shadow: 0 1px 2px rgba(146, 64, 14, 0.05);
}

.estado-aceptada {
    background-color: #D1FAE5;
    color: #065F46;
    box-shadow: 0 1px 2px rgba(6, 95, 70, 0.05);
}

.estado-rechazada {
    background-color: #FEE2E2;
    color: #991B1B;
    box-shadow: 0 1px 2px rgba(153, 27, 27, 0.05);
}

/* Glass morphism effects */
.glass-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
}

/* Improved focus styles */
.focus-ring:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(94, 4, 144, 0.3);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c5b5d6;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #5e0490;
}
</style>

<script>
// Función para renderizar cada fila de solicitud
function renderizarFilaSolicitud(solicitud) {
    const fecha = new Date(solicitud.created_at);
    const fechaFormateada = fecha.toLocaleDateString('es-ES');
    const horaFormateada = fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});

    return `
        <tr class="solicitud-row hover:bg-purple-50 transition-all duration-300">
            <td class="px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 relative">
                        <div class="h-12 w-12 rounded-xl object-cover border-2 border-white shadow-lg overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#5e0490]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <img class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                src="${solicitud.publicacion?.empresa?.user?.imagen ?
                                    '/profile_images/' + solicitud.publicacion.empresa.user.imagen :
                                    '/img/company-default.png'}"
                                alt="Logo empresa">
                        </div>
                        <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1 shadow-md">
                            <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 group-hover:text-[#5e0490] transition-colors duration-300">
                            ${solicitud.publicacion?.empresa?.user?.nombre || 'Empresa'}
                        </div>
                        <div class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ${formatTimeSince(solicitud.created_at)}
                        </div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="max-w-md">
                    <div class="text-sm font-medium text-gray-900 mb-1 hover:text-[#5e0490] transition-colors duration-300">
                        ${solicitud.publicacion?.titulo || 'Sin título'}
                    </div>
                    <div class="text-xs text-gray-500 line-clamp-2 bg-gray-50 p-2 rounded-lg">
                        ${solicitud.publicacion?.descripcion ? solicitud.publicacion.descripcion.substring(0, 100) + (solicitud.publicacion.descripcion.length > 100 ? '...' : '') : ''}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center space-x-2">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <svg class="w-4 h-4 text-[#5e0490]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">${fechaFormateada}</div>
                        <div class="text-xs text-gray-500">${horaFormateada}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${getEstadoBadge(solicitud.estado)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end space-x-3">
                    <a href="/estudiante/solicitudes/${solicitud.id}"
                       class="action-button inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-[#5e0490] bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver
                    </a>
                    ${solicitud.estado === 'pendiente' ? `
                        <button onclick="cancelarSolicitud(${solicitud.id})"
                                class="action-button inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Cancelar
                        </button>
                    ` : ''}
                </div>
            </td>
        </tr>
    `;
}

// Función para obtener el badge de estado
function getEstadoBadge(estado) {
    const estados = {
        pendiente: {
            clase: 'estado-pendiente',
            icono: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`,
            texto: 'Pendiente'
        },
        aceptada: {
            clase: 'estado-aceptada',
            icono: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>`,
            texto: 'Aceptada'
        },
        rechazada: {
            clase: 'estado-rechazada',
            icono: `<svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>`,
            texto: 'Rechazada'
        }
    };

    const estadoInfo = estados[estado] || estados.pendiente;

    return `
        <span class="estado-badge inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium ${estadoInfo.clase}">
            ${estadoInfo.icono}
            ${estadoInfo.texto}
        </span>
    `;
}

// Función para formatear el tiempo transcurrido
function formatTimeSince(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);

    if (diffInSeconds < 60) {
        return 'Hace un momento';
    }

    const diffInMinutes = Math.floor(diffInSeconds / 60);
    if (diffInMinutes < 60) {
        return `Hace ${diffInMinutes} ${diffInMinutes === 1 ? 'minuto' : 'minutos'}`;
    }

    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) {
        return `Hace ${diffInHours} ${diffInHours === 1 ? 'hora' : 'horas'}`;
    }

    const diffInDays = Math.floor(diffInHours / 24);
    if (diffInDays < 30) {
        return `Hace ${diffInDays} ${diffInDays === 1 ? 'día' : 'días'}`;
    }

    return date.toLocaleDateString('es-ES');
}

// Agregar efecto de carga con shimmer
document.addEventListener('DOMContentLoaded', function() {
    // Añadir estado de carga mientras se cargan los datos
    const solicitudesTable = document.getElementById('solicitudes-table');
    if (solicitudesTable) {
        solicitudesTable.classList.remove('hidden');
        const tbody = document.getElementById('solicitudes-tbody');
        if (tbody) {
            // Mostrar shimmer de carga
            for (let i = 0; i < 5; i++) {
                const shimmerRow = document.createElement('tr');
                shimmerRow.className = 'animate-pulse shimmer-row';
                shimmerRow.innerHTML = `
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-xl bg-gray-200"></div>
                            <div class="space-y-2">
                                <div class="h-4 w-32 bg-gray-200 rounded"></div>
                                <div class="h-3 w-24 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="space-y-2">
                            <div class="h-4 w-48 bg-gray-200 rounded"></div>
                            <div class="h-3 w-64 bg-gray-200 rounded"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="h-8 w-20 bg-gray-200 rounded"></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="h-6 w-24 bg-gray-200 rounded-full"></div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <div class="h-8 w-16 bg-gray-200 rounded"></div>
                            <div class="h-8 w-20 bg-gray-200 rounded"></div>
                        </div>
                    </td>
                `;
                tbody.appendChild(shimmerRow);
            }

            // Simular tiempo de carga
            setTimeout(() => {
                const shimmerRows = document.querySelectorAll('.shimmer-row');
                shimmerRows.forEach(row => row.remove());
                // Aquí normalmente se cargarían los datos reales
            }, 1500);
        }
    }
});
</script>
@endsection