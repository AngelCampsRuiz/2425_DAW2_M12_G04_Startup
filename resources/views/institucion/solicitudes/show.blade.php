@extends('layouts.institucion')

@section('title', 'Detalle de Solicitud')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalle de Solicitud</h1>
        <div class="flex items-center text-sm text-gray-500 mt-1">
            <a href="{{ route('institucion.dashboard') }}" class="hover:text-primary">Dashboard</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('institucion.solicitudes.index') }}" class="hover:text-primary">Solicitudes</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>Detalle</span>
        </div>
        <div class="text-sm text-gray-600 mt-2">
            Última actualización: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    {{-- Mostrar alertas --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Estado de la solicitud -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-5 py-4 border-b flex justify-between items-center">
                    <div class="flex items-center text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Estado de la Solicitud</span>
                    </div>
                    <div>
                        @if($solicitud->estado == 'pendiente')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        @elseif($solicitud->estado == 'aprobada')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobada</span>
                        @elseif($solicitud->estado == 'rechazada')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>
                        @endif
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Fecha de solicitud:</p>
                            <p class="text-base text-gray-900">{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Fecha de respuesta:</p>
                            <p class="text-base text-gray-900">{{ $solicitud->fecha_respuesta ? $solicitud->fecha_respuesta->format('d/m/Y H:i') : 'Pendiente' }}</p>
                        </div>
                    </div>

                    @if($solicitud->clase)
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded-md mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                            </div>
                            <div>
                                    <h3 class="text-blue-800 font-medium mb-1">Clase asignada</h3>
                                    <p>El estudiante ha sido asignado a la clase <span class="font-medium">{{ $solicitud->clase->nombre }}</span></p>
                            </div>
                        </div>
                    </div>
                    @elseif($solicitud->estado == 'aprobada')
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-md mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                            </div>
                            <div>
                                    <h3 class="text-yellow-800 font-medium mb-1">Pendiente de asignación</h3>
                                    <p>Esta solicitud ha sido aprobada pero aún no se ha asignado una clase al estudiante.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($solicitud->respuesta && $solicitud->estado == 'rechazada')
                        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                            </div>
                            <div>
                                    <h3 class="text-red-800 font-medium mb-1">Motivo del rechazo</h3>
                                    <p>{{ $solicitud->respuesta }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="flex flex-wrap gap-3 mt-6">
                        @if($solicitud->estado == 'pendiente')
                            <form action="{{ route('institucion.solicitudes.aprobar', $solicitud->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Aprobar Solicitud
                                </button>
                            </form>
                            
                            <button onclick="mostrarModalRechazar()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Rechazar Solicitud
                            </button>
                        @elseif($solicitud->estado == 'aprobada' && !$solicitud->clase_id)
                            <a href="{{ route('institucion.solicitudes.asignar-clase', $solicitud->id) }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                Asignar a Clase
                            </a>
                        @endif

                        <a href="{{ route('institucion.solicitudes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                            </svg>
                            Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen del estudiante -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-5 py-4 border-b">
                    <div class="flex items-center text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">Resumen</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex flex-col items-center justify-center mb-6">
                        <div class="w-24 h-24 bg-purple-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-4">
                            {{ strtoupper(substr($solicitud->estudiante->user->nombre, 0, 2)) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $solicitud->estudiante->user->nombre }}</h3>
                        <p class="text-gray-500">{{ $solicitud->estudiante->user->email }}</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                                <span>ID de Solicitud</span>
                            </div>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">{{ $solicitud->id }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>Teléfono</span>
                            </div>
                            <span class="text-gray-900">{{ $solicitud->estudiante->user->telefono ?: 'No proporcionado' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                </svg>
                                <span>Edad</span>
                            </div>
                            <span class="text-gray-900">{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="bg-gray-50 px-5 py-4 border-b">
            <div class="flex items-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="font-medium">Detalles de la Solicitud</span>
                </div>
                            </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Personal</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Nombre completo</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->user->nombre }}</p>
                            </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Email</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->user->email }}</p>
                            </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Teléfono</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->user->telefono ?: 'No proporcionado' }}</p>
                            </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Edad</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</p>
                        </div>
                            </div>
                            </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalles Adicionales</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Mensaje del estudiante</h4>
                            <div class="bg-gray-50 p-4 rounded-lg text-gray-800">
                                {{ $solicitud->mensaje ?: 'El estudiante no ha dejado ningún mensaje.' }}
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Conocimientos previos</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->conocimientos_previos ?: 'No especificados' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Intereses</h4>
                            <p class="text-gray-900">{{ $solicitud->estudiante->intereses ?: 'No especificados' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rechazo de solicitud -->
<div id="modalRechazarSolicitud" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
        <div class="flex flex-col items-center">
            <div class="text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Rechazar Solicitud</h3>
                <p class="text-sm text-gray-500 mb-4">¿Estás seguro de que deseas rechazar esta solicitud? Esta acción no se puede deshacer.</p>
            </div>
            
            <form id="formRechazarSolicitud" action="{{ route('institucion.solicitudes.rechazar', $solicitud->id) }}" method="POST" class="w-full">
                @csrf
                <div class="mb-4">
                    <label for="mensaje_rechazo" class="block text-sm font-medium text-gray-700 mb-1">Mensaje de rechazo (opcional):</label>
                    <textarea id="mensaje_rechazo" name="mensaje_rechazo" rows="3" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                    <p class="mt-1 text-xs text-gray-500">Este mensaje será visible para el estudiante cuando intente acceder a la plataforma.</p>
                </div>
                
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="cerrarModalRechazar()" class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Funciones para el modal de rechazo de solicitud
    function mostrarModalRechazar() {
        const modal = document.getElementById('modalRechazarSolicitud');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }
    
    function cerrarModalRechazar() {
        const modal = document.getElementById('modalRechazarSolicitud');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    // Cerrar el modal al hacer clic fuera de él
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('modalRechazarSolicitud');
        if (modal && !modal.classList.contains('hidden') && event.target === modal) {
            cerrarModalRechazar();
        }
    });
</script>
@endpush
@endsection 