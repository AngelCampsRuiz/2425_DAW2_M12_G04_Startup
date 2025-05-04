@extends('layouts.institucion')

@section('title', 'Editar Docente')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Editar Docente</h1>
    <div class="flex space-x-2">
        <a href="{{ route('institucion.docentes.show', $docente->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            <i class="fas fa-eye mr-2"></i> Ver Detalles
        </a>
        <a href="{{ route('institucion.docentes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver al listado
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('institucion.docentes.update', $docente->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Docente -->
            <div>
                <h3 class="text-lg font-medium mb-4 text-gray-800">Información Personal</h3>
                
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $docente->user->nombre) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $docente->user->email) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIF/NIE *</label>
                    <input type="text" name="dni" id="dni" value="{{ old('dni', $docente->user->dni) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('dni')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $docente->user->telefono) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('telefono')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Información Académica/Profesional -->
            <div>
                <h3 class="text-lg font-medium mb-4 text-gray-800">Información Profesional</h3>
                
                <div class="mb-4">
                    <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                    <select name="departamento_id" id="departamento_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">-- Seleccionar Departamento --</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ old('departamento_id', $docente->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('departamento_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4" id="departamento_manual_container" style="{{ old('departamento_id', $docente->departamento_id) ? 'display: none;' : '' }}">
                    <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento (si no está en la lista)</label>
                    <input type="text" name="departamento" id="departamento" value="{{ old('departamento', $docente->departamento) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('departamento')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad', $docente->especialidad) }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('especialidad')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo *</label>
                    <select name="cargo" id="cargo" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">-- Seleccionar Cargo --</option>
                        <option value="Profesor" {{ old('cargo', $docente->cargo) == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="Jefe de Estudios" {{ old('cargo', $docente->cargo) == 'Jefe de Estudios' ? 'selected' : '' }}>Jefe de Estudios</option>
                        <option value="Director" {{ old('cargo', $docente->cargo) == 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="Coordinador" {{ old('cargo', $docente->cargo) == 'Coordinador' ? 'selected' : '' }}>Coordinador</option>
                        <option value="Tutor" {{ old('cargo', $docente->cargo) == 'Tutor' ? 'selected' : '' }}>Tutor</option>
                        <option value="Otro" {{ old('cargo', $docente->cargo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('cargo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $docente->activo) ? 'checked' : '' }}>
                        <label class="form-check-label ml-2" for="activo">
                            <span class="font-medium">{{ $docente->activo ? 'Docente activo' : 'Docente inactivo' }}</span>
                            <p class="text-sm text-gray-500">
                                {{ $docente->activo ? 'Desactiva esta opción para que el docente no pueda acceder a la plataforma.' : 'Activa esta opción para permitir que el docente acceda a la plataforma.' }}
                            </p>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('institucion.docentes.show', $docente->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition mr-2">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                        <i class="fas fa-save mr-2"></i> Actualizar Docente
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Resetear Contraseña -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-xl font-semibold mb-4">Resetear Contraseña</h2>
    <p class="text-gray-600 mb-4">
        Si el docente ha olvidado su contraseña, puedes generar una nueva contraseña temporal que se enviará a su correo electrónico.
    </p>
    
    <form action="{{ route('institucion.docentes.reset-password', $docente->id) }}" method="POST" id="reset-password-form" class="inline-block">
        @csrf
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
            <i class="fas fa-key mr-2"></i> Generar Nueva Contraseña
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const departamentoSelect = document.getElementById('departamento_id');
        const departamentoManualContainer = document.getElementById('departamento_manual_container');
        
        // Mostrar/ocultar campo de departamento manual
        departamentoSelect.addEventListener('change', function() {
            if (this.value) {
                departamentoManualContainer.style.display = 'none';
            } else {
                departamentoManualContainer.style.display = '';
            }
        });
        
        // Confirmación de reseteo de contraseña
        const resetPasswordForm = document.getElementById('reset-password-form');
        
        if (resetPasswordForm) {
            resetPasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('¿Estás seguro de que deseas resetear la contraseña de este docente? Se enviará una nueva contraseña temporal a su correo electrónico.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endpush 