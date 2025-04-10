@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Solicitudes para: {{ $publication->titulo }}</h1>
            <p class="text-gray-600 mt-1">Gestiona las solicitudes de los estudiantes</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            @if($solicitudes->isEmpty())
                <p class="text-gray-500 text-center py-4">No hay solicitudes para esta oferta.</p>
            @else
                <div class="space-y-6">
                    @foreach($solicitudes as $solicitud)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $solicitud->estudiante->user->name }}
                                    </h3>
                                    <p class="text-gray-600">{{ $solicitud->estudiante->centro_educativo }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm 
                                    @if($solicitud->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($solicitud->estado === 'aceptada') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </div>

                            @if($solicitud->mensaje)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">Mensaje del estudiante:</h4>
                                    <p class="text-gray-600 mt-1">{{ $solicitud->mensaje }}</p>
                                </div>
                            @endif

                            @if($solicitud->estado === 'pendiente')
                                <form action="{{ route('empresa.applications.update', ['publication' => $publication->id, 'application' => $solicitud->id]) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Respuesta:</label>
                                        <textarea name="respuesta_empresa" rows="2" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <button type="submit" name="estado" value="rechazada" 
                                                class="px-4 py-2 border border-red-500 text-red-500 rounded-md hover:bg-red-50">
                                            Rechazar
                                        </button>
                                        <button type="submit" name="estado" value="aceptada" 
                                                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">
                                            Aceptar
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 