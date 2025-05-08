{{-- EXTENDE LA PLANTILLA PRINCIPAL --}}
    @extends('layouts.app')

{{-- SECCIÓN DE CONTENIDO --}}
    @section('content')
{{-- CONTENEDOR PRINCIPAL CON FONDO GRADIENTE --}}
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
        {{-- TARJETA DE LOGIN --}}
            <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
                {{-- LOGO DE LA APLICACIÓN --}}
                    <div class="flex justify-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-24 mb-6">
                        </a>
                    </div>

                {{-- TÍTULO DE LA PÁGINA --}}
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar sesión</h2>

                {{-- FORMULARIO DE LOGIN --}}
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        {{-- CAMPO DE EMAIL --}}
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                                
                                {{-- MENSAJES DE ERROR PARA EMAIL --}}
                                    @error('email')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    <span id="email-error" class="text-red-500 text-xs"></span>
                            </div>

                        {{-- CAMPO DE CONTRASEÑA --}}
                            <div class="mb-6">
                                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                                <input id="password" type="password" name="password" autocomplete="current-password"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror">
                                
                                {{-- MENSAJES DE ERROR PARA CONTRASEÑA --}}
                                    @error('password')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                    <span id="password-error" class="text-red-500 text-xs"></span>
                            </div>

                        {{-- CHECKBOX "RECUÉRDAME" --}}
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} 
                                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                                        Recuérdame
                                    </label>
                                </div>
                            </div>

                        {{-- BOTÓN DE INICIO DE SESIÓN --}}
                            <div class="flex items-center justify-between">
                                <button type="submit" id="submitBtn" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                                    Iniciar sesión
                                </button>
                            </div>

                        {{-- ENLACE DE REGISTRO --}}
                            <div class="mt-4 text-center">
                                <a href="{{ route('register') }}" class="text-sm text-primary hover:underline">¿No tienes cuenta? Regístrate</a>
                            </div>
                    </form>
            </div>
    </div>

{{-- SCRIPT DE VALIDACIÓN DEL FORMULARIO --}}
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
@endsection