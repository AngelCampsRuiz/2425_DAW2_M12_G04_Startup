@extends('layouts.institucion')

@section('title', 'Detalles del Docente')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Detalles del Docente</h1>
    <div class="flex space-x-2">
        <a href="{{ route('institucion.docentes.edit', $docente->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-edit mr-2"></i> Editar
        </a>
        <a href="{{ route('institucion.docentes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Información Básica -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-primary text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información Personal</h2>
                <i class="fas fa-user text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 mr-4">
                    <img class="h-24 w-24 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($docente->user->nombre) }}&background=7705B6&color=fff&size=256" alt="{{ $docente->user->nombre }}">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $docente->user->nombre }}</h3>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <span class="text-gray-600 text-sm block">Email:</span>
                        <span class="font-medium">{{ $docente->user->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">DNI/NIF/NIE:</span>
                        <span class="font-medium">{{ $docente->user->dni }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm block">Teléfono:</span>
                        <span class="font-medium">{{ $docente->user->telefono }}</span>
                    </div>
                    @if($docente->user->fecha_nacimiento)
                    <div>
                        <span class="text-gray-600 text-sm block">Fecha de nacimiento:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($docente->user->fecha_nacimiento)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información Profesional -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-blue-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Información Profesional</h2>
                <i class="fas fa-briefcase text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <span class="text-gray-600 text-sm block">Especialidad:</span>
                    <span class="font-medium">{{ $docente->especialidad }}</span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Cargo:</span>
                    <span class="font-medium">{{ $docente->cargo }}</span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Departamento:</span>
                    <span class="font-medium">
                        @if($docente->departamentoObj)
                            <a href="{{ route('institucion.departamentos.show', $docente->departamentoObj->id) }}" class="text-primary hover:underline">
                                {{ $docente->departamentoObj->nombre }}
                            </a>
                        @elseif($docente->departamento)
                            {{ $docente->departamento }}
                        @else
                            <span class="text-gray-400">No asignado</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-gray-600 text-sm block">Fecha de alta:</span>
                    <span class="font-medium">{{ $docente->created_at->format('d/m/Y') }}</span>
                </div>
                @if($docente->esJefeDepartamento())
                <div>
                    <span class="text-gray-600 text-sm block">Jefe de departamento:</span>
                    <span class="font-medium text-green-600">Sí</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Clases Asignadas -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-5 bg-green-600 text-white">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-lg">Clases Asignadas</h2>
                <i class="fas fa-graduation-cap text-3xl"></i>
            </div>
        </div>
        <div class="p-6">
            @if($docente->clases->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($docente->clases as $clase)
                        <li class="py-2">
                            <a href="{{ route('institucion.clases.show', $clase->id) }}" class="flex justify-between items-center hover:bg-gray-50 p-2 rounded transition">
                                <div>
                                    <span class="font-medium text-gray-800">{{ $clase->nombre }}</span>
                                    <div class="text-xs text-gray-500">
                                        {{ $clase->nivel }} • {{ $clase->curso }} 
                                        @if($clase->grupo) • Grupo {{ $clase->grupo }} @endif
                                    </div>
                                </div>
                                <span class="text-primary">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-info-circle mb-2 text-2xl"></i>
                    <p>No hay clases asignadas a este docente.</p>
                </div>
            @endif
            
            <div class="mt-4 pt-4 border-t">
                <a href="{{ route('institucion.clases.create') }}" class="text-primary hover:text-primary-dark font-medium flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i> Asignar una nueva clase
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estudiantes asociados -->
<div class="mt-6 bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Estudiantes</h2>
    
    @if($docente->estudiantes->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($docente->estudiantes as $estudiante)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($estudiante->user->nombre) }}&background=7705B6&color=fff" alt="{{ $estudiante->user->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $estudiante->user->nombre }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $estudiante->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if($estudiante->clase)
                                        <a href="{{ route('institucion.clases.show', $estudiante->clase->id) }}" class="text-primary hover:underline">
                                            {{ $estudiante->clase->nombre }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">No asignado</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Ver perfil</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border rounded-lg bg-gray-50">
            <i class="fas fa-user-graduate text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-500">No hay estudiantes asignados a este docente.</p>
        </div>
    @endif
</div>

<!-- Acciones -->
<div class="mt-6 flex justify-end space-x-3">
    <a href="{{ route('institucion.docentes.edit', $docente->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
        <i class="fas fa-edit mr-2"></i> Editar Docente
    </a>
    <form action="{{ route('institucion.docentes.toggle-active', $docente->id) }}" method="POST" class="inline-block">
        @csrf
        @method('POST')
        <button type="submit" class="px-4 py-2 {{ $docente->activo ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-md transition">
            <i class="fas {{ $docente->activo ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
            {{ $docente->activo ? 'Desactivar Docente' : 'Activar Docente' }}
        </button>
    </form>
    <form action="{{ route('institucion.docentes.destroy', $docente->id) }}" method="POST" class="inline-block delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
            <i class="fas fa-trash-alt mr-2"></i> Eliminar Docente
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmación de eliminación
        const deleteForm = document.querySelector('.delete-form');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas eliminar este docente? Esta acción no se puede deshacer y eliminará toda la información asociada.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endpush 