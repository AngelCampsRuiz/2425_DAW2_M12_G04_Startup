@extends('layouts.institucion')

@section('title', 'Perfil de Institución')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-6">Información de la Institución</h2>

    <form action="{{ route('institucion.perfil.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información de Usuario -->
            <div>
                <h3 class="text-lg font-medium mb-4 text-gray-800">Información General</h3>
                
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Centro</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $institucion->user->nombre) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $institucion->user->email) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $institucion->user->telefono) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('telefono')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="tipo_institucion" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Institución</label>
                    <select name="tipo_institucion" id="tipo_institucion" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="Colegio" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Colegio' ? 'selected' : '' }}>Colegio</option>
                        <option value="Instituto" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Instituto' ? 'selected' : '' }}>Instituto</option>
                        <option value="Universidad" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Universidad' ? 'selected' : '' }}>Universidad</option>
                        <option value="Centro de FP" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Centro de FP' ? 'selected' : '' }}>Centro de FP</option>
                        <option value="Academia" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Academia' ? 'selected' : '' }}>Academia</option>
                        <option value="Otro" {{ old('tipo_institucion', $institucion->tipo_institucion) == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('tipo_institucion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Información de Institución -->
            <div>
                <h3 class="text-lg font-medium mb-4 text-gray-800">Información de Contacto</h3>
                
                <div class="mb-4">
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $institucion->direccion) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('direccion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="provincia" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                    <input type="text" name="provincia" id="provincia" value="{{ old('provincia', $institucion->provincia) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('provincia')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                    <input type="text" name="codigo_postal" id="codigo_postal" value="{{ old('codigo_postal', $institucion->codigo_postal) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('codigo_postal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="representante_legal" class="block text-sm font-medium text-gray-700 mb-1">Representante Legal</label>
                    <input type="text" name="representante_legal" id="representante_legal" value="{{ old('representante_legal', $institucion->representante_legal) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('representante_legal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="cargo_representante" class="block text-sm font-medium text-gray-700 mb-1">Cargo del Representante</label>
                    <input type="text" name="cargo_representante" id="cargo_representante" value="{{ old('cargo_representante', $institucion->cargo_representante) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('cargo_representante')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                Actualizar Información
            </button>
        </div>
    </form>
</div>

<!-- Cambiar Contraseña -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-xl font-semibold mb-6">Cambiar Contraseña</h2>

    <form action="{{ route('institucion.perfil.password') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña Actual</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50">
                Cambiar Contraseña
            </button>
        </div>
    </form>
</div>
@endsection 