@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-[#D0AAFE] to-[#6821BE]">
    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
        <div class="flex items-center mb-8">
            {{-- LOGO DE LA EMPRESA --}}
                <div class="mr-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
                </div>
            
            {{-- FORMULARIO LOGIN --}}
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Iniciar sesión</h2>
                    
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        {{-- EMAIL --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6] @error('email') border-red-500 @enderror">
                                
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- CONTRASEÑA --}}
                            <div class="mb-6">
                                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-[#7705B6] focus:border-[#7705B6] @error('password') border-red-500 @enderror">
                                
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        
                        {{-- RECORDAR SESIÓN --}}
                            <div class="mb-6 flex items-center">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="h-4 w-4 text-[#7705B6] focus:ring-[#7705B6] border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">Recordar sesión</label>
                            </div>
                        
                        {{-- BOTON DE LOGIN --}}
                            <button type="submit" class="w-full bg-[#7705B6] text-white py-2 px-4 rounded-lg hover:bg-[#5E0490] transition font-medium">
                                Iniciar sesión
                            </button>
                        
                        {{-- ENLACE A REGISTRO --}}
                            <div class="mt-4 text-center">
                                <a href="{{ route('register') }}" class="text-sm text-[#7705B6] hover:underline">¿No tienes cuenta? Regístrate</a>
                            </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@vite(['resources/js/auth/login-validation.js'])
@endsection