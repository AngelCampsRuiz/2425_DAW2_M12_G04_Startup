@extends('admin.dashboard')

@section('admin_content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-6">Editar Publicación</h2>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Hay errores en el formulario!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.publicaciones.update', $publicacion) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $publicacion->titulo) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                           required maxlength="100">
                    @error('titulo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="empresa_id" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <select name="empresa_id" id="empresa_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                            required>
                        <option value="">Selecciona una empresa</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}" {{ old('empresa_id', $publicacion->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('empresa_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select name="categoria_id" id="categoria_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                            required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $publicacion->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre_categoria }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-1">Subcategoría</label>
                    <select name="subcategoria_id" id="subcategoria_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                            required>
                        <option value="">Selecciona una subcategoría</option>
                        @foreach($subcategorias as $subcategoria)
                            <option value="{{ $subcategoria->id }}" {{ old('subcategoria_id', $publicacion->subcategoria_id) == $subcategoria->id ? 'selected' : '' }}>
                                {{ $subcategoria->nombre_subcategoria }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategoria_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="horario" class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                    <select name="horario" id="horario" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                            required>
                        <option value="mañana" {{ old('horario', $publicacion->horario) == 'mañana' ? 'selected' : '' }}>Mañana</option>
                        <option value="tarde" {{ old('horario', $publicacion->horario) == 'tarde' ? 'selected' : '' }}>Tarde</option>
                    </select>
                    @error('horario')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-1">Horas Totales</label>
                    <input type="number" name="horas_totales" id="horas_totales" value="{{ old('horas_totales', $publicacion->horas_totales) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                           required min="1">
                    @error('horas_totales')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Publicación</label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" value="{{ old('fecha_publicacion', $publicacion->fecha_publicacion ? date('Y-m-d', strtotime($publicacion->fecha_publicacion)) : '') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                           required>
                    @error('fecha_publicacion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="activa" id="activa" value="1" {{ old('activa', $publicacion->activa) ? 'checked' : '' }} 
                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    <label for="activa" class="ml-2 text-sm font-medium text-gray-700">Publicación Activa</label>
                    @error('activa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="6" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"
                          required>{{ old('descripcion', $publicacion->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.publicaciones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
@endsection 