@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
        <div class="flex justify-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-24 mb-6">
            </a>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar sesión</h2>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <span id="email-error" class="text-red-500 text-xs"></span>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                <input id="password" type="password" name="password" autocomplete="current-password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror">
                
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                <span id="password-error" class="text-red-500 text-xs"></span>
            </div>

            <!-- Remember Me -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} 
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Recuérdame
                    </label>
                </div>
            </div>

            <!-- Login Button -->
            <div class="flex items-center justify-between">
                <button type="submit" id="submitBtn" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                    Iniciar sesión
                </button>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-sm text-primary hover:underline">¿No tienes cuenta? Regístrate</a>
            </div>
        </form>
    </div>
</div>

{{-- Scripts de validación --}}
<script src="{{ asset('js/auth/login-validation.js') }}"></script>
@endsection