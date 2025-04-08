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
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Registro</h2>
                    
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        {{-- NOMBRE --}}
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre completo</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('name') border-red-500 @enderror">
                                
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CORREO --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                                
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        

                        
                        {{-- AÑADIR ROL --}}
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Registrarme como:</label>
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input type="radio" id="alumno" name="role" value="alumno" checked
                                            class="h-4 w-4 text-primary focus:ring-primary">
                                        <label for="alumno" class="ml-2 block text-sm text-gray-700">Alumno</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="empresa" name="role" value="empresa"
                                            class="h-4 w-4 text-primary focus:ring-primary">
                                        <label for="empresa" class="ml-2 block text-sm text-gray-700">Empresa</label>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- BOTON REGISTER -->
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