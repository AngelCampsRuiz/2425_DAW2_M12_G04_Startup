@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-[#D0AAFE] to-[#6821BE]">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="flex items-center mb-8">
            {{-- LOGO DE LA EMPRESA --}}
                <div class="mr-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
                </div>
            
            {{-- FORMULARIO --}}
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Registro</h2>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        {{-- NOMBRE --}}
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nombre completo</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6] @error('name') border-red-500 @enderror">
                                
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CORREO --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6] @error('email') border-red-500 @enderror">
                                
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CONTRASEÑA --}}
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6] @error('password') border-red-500 @enderror">
                                
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CONFIRMAR CONTRASEÑA --}}
                            <div class="mb-6">
                                <label for="password-confirm" class="block text-gray-700 text-sm font-medium mb-2">Confirmar contraseña</label>
                                <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6]">
                            </div>
                        
                        {{-- AÑADIR ROL --}}
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Registrarme como:</label>
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input type="radio" id="alumno" name="role" value="alumno" checked
                                            class="h-4 w-4 text-[#7705B6] focus:ring-[#7705B6]">
                                        <label for="alumno" class="ml-2 block text-sm text-gray-700">Alumno</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="empresa" name="role" value="empresa"
                                            class="h-4 w-4 text-[#7705B6] focus:ring-[#7705B6]">
                                        <label for="empresa" class="ml-2 block text-sm text-gray-700">Empresa</label>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- BOTON REGISTER -->
                            <button type="submit" class="w-full bg-[#7705B6] text-white py-2 px-4 rounded-lg hover:bg-[#5E0490] transition font-medium">
                                Registrarme
                            </button>
                        
                        <!-- ENLACE LOGIN -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-sm text-[#7705B6] hover:underline">¿Ya tienes cuenta? Inicia sesión</a>
                            </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@vite(['resources/js/auth/register-validation.js'])
@endsection