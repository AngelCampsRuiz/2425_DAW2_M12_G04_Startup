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
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Registro de Empresa</h2>

        <form method="POST" action="{{ route('register.empresa') }}">
            @csrf

                        {{-- NOMBRE --}}
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre de la Empresa</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
            </div>

                        {{-- CORREO --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
            </div>

                        {{-- CIF --}}
                            <div class="mb-4">
                                <label for="cif" class="block text-gray-700 text-sm font-medium mb-2">CIF</label>
                                <input id="cif" type="text" name="cif" value="{{ old('cif') }}" required
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('cif') border-red-500 @enderror">
            </div>

                        {{-- DIRECCIÓN --}}
                            <div class="mb-4">
                                <label for="direccion" class="block text-gray-700 text-sm font-medium mb-2">Dirección</label>
                                <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" required
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('direccion') border-red-500 @enderror">
            </div>

                        {{-- PROVINCIA --}}
                            <div class="mb-4">
                                <label for="provincia" class="block text-gray-700 text-sm font-medium mb-2">Provincia</label>
                                <select id="provincia" name="provincia" required
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('provincia') border-red-500 @enderror">
                    <option value="">Selecciona una provincia</option>
                    @php
                        $provincias = [
                            'Álava', 'Albacete', 'Alicante', 'Almería', 'Asturias', 'Ávila', 'Badajoz', 'Barcelona',
                            'Burgos', 'Cáceres', 'Cádiz', 'Cantabria', 'Castellón', 'Ciudad Real', 'Córdoba', 'Cuenca',
                            'Gerona', 'Granada', 'Guadalajara', 'Guipúzcoa', 'Huelva', 'Huesca', 'Islas Baleares',
                            'Jaén', 'La Coruña', 'La Rioja', 'Las Palmas', 'León', 'Lérida', 'Lugo', 'Madrid', 'Málaga',
                            'Murcia', 'Navarra', 'Orense', 'Palencia', 'Pontevedra', 'Salamanca', 'Santa Cruz de Tenerife',
                            'Segovia', 'Sevilla', 'Soria', 'Tarragona', 'Teruel', 'Toledo', 'Valencia', 'Valladolid',
                            'Vizcaya', 'Zamora', 'Zaragoza'
                        ];
                        sort($provincias);
                    @endphp
                    @foreach($provincias as $provincia)
                        <option value="{{ $provincia }}" {{ old('provincia') == $provincia ? 'selected' : '' }}>
                            {{ $provincia }}
                        </option>
                    @endforeach
                </select>
            </div>



            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                Registrarme
            </button>
            
            <!-- ENLACE LOGIN -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
                            </form>
                </div>
        </div>
    </div>
</div>
@endsection
