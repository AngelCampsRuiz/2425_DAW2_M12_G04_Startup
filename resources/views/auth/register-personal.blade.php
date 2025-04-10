@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-2xl">
        <div class="flex items-center mb-8">
            {{-- LOGO DE LA EMPRESA --}}
                <div class="mr-6">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-48">
                    </a>
                </div>
            
            {{-- FORMULARIO --}}
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Información Personal</h2>
                    <p class="text-gray-600 mb-4">Paso 2 de 3: Completa tu información personal</p>

                    <form id="registerPersonalForm" method="POST" action="{{ route('register.personal.post') }}">
                        @csrf
                        
                        {{-- NOMBRE (readonly, from session) --}}
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre completo</label>
                                <input id="name" type="text" value="{{ session('registration_data.name') }}" readonly
                                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:ring-primary focus:border-primary">
                            </div>

                        {{-- CORREO (readonly, from session) --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" value="{{ session('registration_data.email') }}" readonly
                                    class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:ring-primary focus:border-primary">
                            </div>
                            
                        {{-- FECHA DE NACIMIENTO --}}
                            <div class="mb-4">
                                <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-medium mb-2">Fecha de nacimiento</label>
                                <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                                    max="" min="1900-01-01"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('fecha_nacimiento') border-red-500 @enderror">
                                <p class="text-gray-500 text-xs mt-1">Debes tener al menos 16 años para registrarte</p>
                                @error('fecha_nacimiento')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- PROVINCIA --}}
                            <div class="mb-4">
                                <label for="provincia" class="block text-gray-700 text-sm font-medium mb-2">Provincia</label>
                                <select id="provincia" name="provincia"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia') border-red-500 @enderror">
                                    <option value="">Selecciona una provincia</option>
                                </select>
                                @error('provincia')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CIUDAD --}}
                            <div class="mb-4">
                                <label for="ciudad" class="block text-gray-700 text-sm font-medium mb-2">Ciudad</label>
                                <select id="ciudad" name="ciudad" disabled
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('ciudad') border-red-500 @enderror">
                                    <option value="">Selecciona una ciudad</option>
                                </select>
                                @error('ciudad')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- DNI --}}
                            <div class="mb-4">
                                <label for="dni" class="block text-gray-700 text-sm font-medium mb-2">DNI/NIE</label>
                                <input id="dni" type="text" name="dni" value="{{ old('dni') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('dni') border-red-500 @enderror">
                                @error('dni')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- TELÉFONO --}}
                            <div class="mb-4">
                                <label for="telefono" class="block text-gray-700 text-sm font-medium mb-2">Teléfono</label>
                                <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('telefono') border-red-500 @enderror">
                                @error('telefono')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                        <!-- BOTÓN CONTINUAR -->
                            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                                Continuar
                            </button>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
