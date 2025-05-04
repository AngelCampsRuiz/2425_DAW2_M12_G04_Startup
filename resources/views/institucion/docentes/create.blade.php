@extends('layouts.institucion')

@section('title', 'Crear Nuevo Docente')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Crear Nuevo Docente</h1>
    <a href="{{ route('institucion.docentes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
        <i class="fas fa-arrow-left mr-2"></i> Volver al listado
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('institucion.docentes.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información del Docente -->
            <div>
                <h3 class="text-lg font-medium mb-4 text-gray-800">Información Personal</h3>
                
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIF/NIE *</label>
                    <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('dni')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required 
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
                            <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('departamento_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4" id="departamento_manual_container" style="{{ old('departamento_id') ? 'display: none;' : '' }}">
                    <label for="departamento" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Departamento (si no está en la lista)</label>
                    <input type="text" name="departamento" id="departamento" value="{{ old('departamento') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('departamento')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="especialidad" class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad') }}" required 
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
                        <option value="Profesor" {{ old('cargo') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="Jefe de Estudios" {{ old('cargo') == 'Jefe de Estudios' ? 'selected' : '' }}>Jefe de Estudios</option>
                        <option value="Director" {{ old('cargo') == 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="Coordinador" {{ old('cargo') == 'Coordinador' ? 'selected' : '' }}>Coordinador</option>
                        <option value="Tutor" {{ old('cargo') == 'Tutor' ? 'selected' : '' }}>Tutor</option>
                        <option value="Otro" {{ old('cargo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('cargo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-6">
            <p class="text-sm text-gray-600 mb-4">
                <i class="fas fa-info-circle mr-1"></i> Al crear un docente, se generará automáticamente una contraseña temporal que será enviada al correo electrónico proporcionado. El docente deberá cambiarla en su primer inicio de sesión.
            </p>
            
            <div class="flex justify-end">
                <a href="{{ route('institucion.docentes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition mr-2">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                    <i class="fas fa-save mr-2"></i> Guardar Docente
                </button>
            </div>
        </div>
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
    });
</script>
@endpush 