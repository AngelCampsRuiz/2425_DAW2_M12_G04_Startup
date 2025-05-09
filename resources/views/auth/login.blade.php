{{-- EXTENDE LA PLANTILLA PRINCIPAL --}}
    @extends('layouts.app')

{{-- SECCIÓN DE CONTENIDO --}}
    @section('content')
{{-- CONTENEDOR PRINCIPAL CON FONDO GRADIENTE --}}
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
        {{-- TARJETA DE LOGIN --}}
        <div class="w-full max-w-xl bg-white rounded-xl shadow-xl p-4 md:p-0 flex">
            {{-- CONTENEDOR FLEXIBLE PARA LOGO Y FORMULARIO --}}
            <div class="flex flex-col md:flex-row w-full items-center">
                {{-- LOGO DE LA APLICACIÓN --}}
                <div class="w-full md:w-2/5 flex justify-center items-center py-4 md:py-0 md:px-6">
                    <a href="{{ url('/') }}" class="transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-28 md:h-40">
                    </a>
                </div>

                {{-- FORMULARIO DE LOGIN --}}
                <div class="w-full md:w-3/5 flex flex-col justify-center px-2 md:px-6 py-4">
                    {{-- TÍTULO DE LA PÁGINA --}}
                    <h2 class="text-2xl font-bold text-center md:text-left text-gray-800 mb-4">Iniciar sesión</h2>

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        {{-- CAMPO DE EMAIL --}}
                        <div class="mb-3">
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Correo electrónico</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror">
                            
                            {{-- MENSAJES DE ERROR PARA EMAIL --}}
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                            <span id="email-error" class="text-red-500 text-xs"></span>
                        </div>

                        {{-- CAMPO DE CONTRASEÑA --}}
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-medium mb-1">Contraseña</label>
                            <input id="password" type="password" name="password" autocomplete="current-password"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror">
                            
                            {{-- MENSAJES DE ERROR PARA CONTRASEÑA --}}
                            @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                            <span id="password-error" class="text-red-500 text-xs"></span>
                        </div>

                        {{-- CHECKBOX "RECUÉRDAME" --}}
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} 
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Recuérdame
                                </label>
                            </div>
                        </div>

                        {{-- BOTÓN DE INICIO DE SESIÓN --}}
                        <div>
                            <button type="submit" id="submitBtn" class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition font-medium">
                                Iniciar sesión
                            </button>
                        </div>

                        {{-- ENLACE DE REGISTRO --}}
                        <div class="mt-3 text-center">
                            <a href="{{ route('register') }}" class="text-sm text-primary hover:underline">¿No tienes cuenta? Regístrate</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- SCRIPT DE VALIDACIÓN DEL FORMULARIO --}}
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
@endsection