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
                <form action="{{ route('empresa.offers.store') }}" method="POST" id="offerForm">
                    @csrf
                    
                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif

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
                        <label for="horario" class="block text-sm font-medium text-gray-700 mb-2">Horario</label>
                        <select name="horario" id="horario" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                required>
                            <option value="">Selecciona un horario</option>
                            <option value="mañana" {{ old('horario') == 'mañana' ? 'selected' : '' }}>Mañana</option>
                            <option value="tarde" {{ old('horario') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                        </select>
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
                        <button type="submit" id="submitBtn"
                                class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Publicar Oferta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/create-offer.js') }}"></script>
