@extends('layouts.docente')

@section('title', 'Detalle de Solicitud')

@section('content')
<div class="bg-gray-50 p-6 rounded-xl shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detalle de Solicitud</h1>
            <div class="flex items-center text-sm text-gray-500 mt-1">
                <a href="{{ route('docente.dashboard') }}" class="hover:text-primary">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('docente.solicitudes.index') }}" class="hover:text-primary">Solicitudes</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>Detalle</span>
            </div>
        </div>
    </div>

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

    <!-- Estado de la solicitud y acciones -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Estado de la Solicitud
                    </h2>
                    <div>
                        @if($solicitud->estado == 'pendiente')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        @elseif($solicitud->estado == 'aprobada')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aprobada
                            </span>
                        @elseif($solicitud->estado == 'rechazada')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Rechazada
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Fecha de solicitud</h3>
                        <p class="text-gray-800">{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Fecha de respuesta</h3>
                        <p class="text-gray-800">{{ $solicitud->fecha_respuesta ? $solicitud->fecha_respuesta->format('d/m/Y H:i') : 'Pendiente' }}</p>
                    </div>
                </div>

                @if($solicitud->mensaje_rechazo && $solicitud->estado == 'rechazada')
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Motivo del rechazo</h3>
                                <p class="mt-2 text-sm text-red-700">{{ $solicitud->mensaje_rechazo }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($solicitud->estado == 'pendiente')
                    <div class="flex space-x-4">
                        <form action="{{ route('docente.solicitudes.aprobar', $solicitud->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Aprobar Solicitud
                            </button>
                        </form>

                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="document.getElementById('modal-rechazar').classList.remove('hidden')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Rechazar Solicitud
                        </button>
                    </div>
                @endif
            </div>

            <!-- Detalles del estudiante -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mt-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Información del Estudiante
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Nombre completo</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->user->nombre }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Email</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->user->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Teléfono</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->telefono ?: 'No proporcionado' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Edad</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->edad ?: 'No proporcionada' }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Mensaje del estudiante</h3>
                    <div class="bg-gray-50 rounded-lg p-4 mt-2">
                        <p class="text-gray-800">{{ $solicitud->mensaje ?: 'El estudiante no ha dejado ningún mensaje.' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Conocimientos previos</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->conocimientos_previos ?: 'No especificados' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Intereses</h3>
                        <p class="text-gray-800">{{ $solicitud->estudiante->intereses ?: 'No especificados' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de la clase -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    Información de la Clase
                </h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Nombre de la clase</h3>
                        <p class="text-gray-800">{{ $solicitud->clase->nombre }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Código</h3>
                        <p class="text-gray-800">{{ $solicitud->clase->codigo }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Departamento</h3>
                        <p class="text-gray-800">{{ $solicitud->clase->departamento->nombre }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Total de estudiantes</h3>
                        <p class="text-gray-800">{{ $solicitud->clase->estudiantes()->count() }} estudiantes</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('docente.clases.show', $solicitud->clase->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Ver detalles de la clase
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para rechazar solicitud -->
<div id="modal-rechazar" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('docente.solicitudes.rechazar', $solicitud->id) }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Rechazar Solicitud
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Por favor, indique el motivo por el cual está rechazando esta solicitud. Esta información será visible para el estudiante.
                                </p>
                                <div class="mt-4">
                                    <textarea name="mensaje_rechazo" rows="4" class="shadow-sm block w-full focus:ring-red-500 focus:border-red-500 sm:text-sm border-gray-300 rounded-md" placeholder="Escriba aquí el motivo del rechazo..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Rechazar
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('modal-rechazar').classList.add('hidden')">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 