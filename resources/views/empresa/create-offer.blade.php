@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Crear Nueva Oferta</h1>
                <p class="text-gray-600 mt-1">Publica una nueva oferta de prácticas</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('empresa.offers.store') }}" method="POST">
                    @csrf

                    <!-- Título -->
                    <div class="mb-6">
                        <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título de la oferta</label>
                        <input type="text" name="titulo" id="titulo" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                               value="{{ old('titulo') }}" required>
                        @error('titulo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mb-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                  required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Horario -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Horario</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="horario" value="mañana" 
                                       class="form-radio text-primary focus:ring-primary"
                                       {{ old('horario') == 'mañana' ? 'checked' : '' }} required>
                                <span class="ml-2">Mañana</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="horario" value="tarde" 
                                       class="form-radio text-primary focus:ring-primary"
                                       {{ old('horario') == 'tarde' ? 'checked' : '' }}>
                                <span class="ml-2">Tarde</span>
                            </label>
                        </div>
                        @error('horario')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Horas Totales -->
                    <div class="mb-6">
                        <label for="horas_totales" class="block text-sm font-medium text-gray-700 mb-2">Horas Totales</label>
                        <select name="horas_totales" id="horas_totales" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                required>
                            <option value="">Selecciona las horas</option>
                            @foreach([100, 200, 300, 400] as $hours)
                                <option value="{{ $hours }}" {{ old('horas_totales') == $hours ? 'selected' : '' }}>
                                    {{ $hours }} horas
                                </option>
                            @endforeach
                        </select>
                        @error('horas_totales')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="mb-6">
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                        <select name="categoria_id" id="categoria_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subcategoría -->
                    <div class="mb-6">
                        <label for="subcategoria_id" class="block text-sm font-medium text-gray-700 mb-2">Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                required>
                            <option value="">Selecciona una subcategoría</option>
                        </select>
                        @error('subcategoria_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('empresa.dashboard') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Publicar Oferta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');

    // Función para cargar subcategorías
    function loadSubcategorias(categoriaId) {
        console.log('Cargando subcategorías para categoría:', categoriaId);
        subcategoriaSelect.innerHTML = '<option value="">Cargando subcategorías...</option>';
        
        if (categoriaId) {
            fetch(`/empresa/get-subcategorias/${categoriaId}`)
                .then(response => {
                    console.log('Respuesta recibida:', response.status);
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);
                    subcategoriaSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
                    
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(subcategoria => {
                            console.log('Procesando subcategoría:', subcategoria);
                            const option = document.createElement('option');
                            option.value = subcategoria.id;
                            option.textContent = subcategoria.nombre_subcategoria;
                            if (subcategoria.id == "{{ old('subcategoria_id') }}") {
                                option.selected = true;
                            }
                            subcategoriaSelect.appendChild(option);
                        });
                    } else {
                        console.log('No se encontraron subcategorías');
                        subcategoriaSelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
                    }
                })
                .catch(error => {
                    console.error('Error al cargar subcategorías:', error);
                    subcategoriaSelect.innerHTML = '<option value="">Error al cargar subcategorías</option>';
                });
        } else {
            subcategoriaSelect.innerHTML = '<option value="">Primero selecciona una categoría</option>';
        }
    }

    // Cargar subcategorías si hay una categoría seleccionada
    if (categoriaSelect.value) {
        console.log('Categoría inicial seleccionada:', categoriaSelect.value);
        loadSubcategorias(categoriaSelect.value);
    }

    // Evento para cuando cambia la categoría
    categoriaSelect.addEventListener('change', function() {
        console.log('Categoría cambiada a:', this.value);
        loadSubcategorias(this.value);
    });
});
</script>
@endpush
@endsection 