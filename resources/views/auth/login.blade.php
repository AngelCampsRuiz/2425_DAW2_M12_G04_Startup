{{-- EXTENDE LA PLANTILLA PRINCIPAL --}}
    @extends('layouts.app')

{{-- SECCIÓN DE CONTENIDO --}}
    @section('content')
{{-- CONTENEDOR PRINCIPAL CON FONDO GRADIENTE --}}
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-primary/20 to-primary p-4">
        {{-- TARJETA DE LOGIN --}}
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl p-6 md:p-0 transform transition-all duration-300 hover:scale-[1.02]">
            {{-- CONTENEDOR FLEXIBLE PARA LOGO Y FORMULARIO --}}
            <div class="flex flex-col md:flex-row w-full items-center gap-6">
                {{-- LOGO DE LA APLICACIÓN --}}
                <div class="w-full md:w-2/5 flex justify-center items-center py-6 md:py-12 md:px-8 border-b md:border-b-0 md:border-r border-gray-200">
                    <a href="{{ url('/') }}" class="transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-28 md:h-36">
                    </a>
                </div>

                {{-- FORMULARIO DE LOGIN --}}
                <div class="w-full md:w-3/5 flex flex-col justify-center px-4 md:px-10 py-6">
                    {{-- TÍTULO DE LA PÁGINA --}}
                    <h2 class="text-2xl font-bold text-center md:text-left text-gray-800 mb-6">Iniciar sesión</h2>

                    {{-- MENSAJE DE ÉXITO --}}
                    @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                        @csrf

                        {{-- CAMPO DE EMAIL --}}
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Correo electrónico</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('email') border-red-500 @enderror">

                            {{-- MENSAJES DE ERROR PARA EMAIL --}}
                            @error('email')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <span id="email-error" class="text-red-500 text-sm"></span>
                        </div>

                        {{-- CAMPO DE CONTRASEÑA --}}
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" autocomplete="current-password"
                                    class="w-full px-4 py-2.5 pr-12 border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('password') border-red-500 @enderror">
                                <button type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            {{-- MENSAJES DE ERROR PARA CONTRASEÑA --}}
                            @error('password')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <span id="password-error" class="text-red-500 text-sm"></span>
                        </div>

                        {{-- CHECKBOX "RECUÉRDAME" --}}
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary focus:ring-2 focus:ring-primary border-gray-300 rounded transition-all duration-200">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Recuérdame
                                </label>
                            </div>
                        </div>

                        {{-- BOTÓN DE INICIO DE SESIÓN --}}
                        <div>
                            <button type="submit" id="submitBtn"
                                class="w-full bg-primary text-white py-2.5 px-5 rounded-xl hover:bg-primary-dark transition-all duration-200 font-medium text-base shadow-lg hover:shadow-xl">
                                Iniciar sesión
                            </button>
                        </div>

                        {{-- ENLACE DE REGISTRO --}}
                        <div class="mt-4 text-center">
                            <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark hover:underline transition-all duration-200">
                                ¿No tienes cuenta? Regístrate
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- SCRIPT DE VALIDACIÓN DEL FORMULARIO --}}
    <script src="{{ asset('js/auth/login-validation.js') }}"></script>
@endsection