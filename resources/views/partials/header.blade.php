{{-- HEADER --}}
    <header class="bg-[#D0AAFE] py-4 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- LOGO -->
            <div class="flex items-center">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-10">
                </a>
                {{-- NOMBRE DE LA EMPRESA --}}
                    <span class="ml-2 text-xl font-bold text-[#7705B6]">NextGen</span>
            </div>
            
            {{-- BOTONES LOGIN/REGISTER --}}
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <!-- Nombre del usuario -->                            
                            <span class="text-[#7705B6] font-medium">{{ auth()->user()->nombre }}</span>
                            
                            <!-- Botón de panel según rol -->
                            @if(auth()->user()->role->nombre_rol == 'Estudiante')
                                <a href="{{ route('student.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                    Panel Alumno
                                </a>
                            @elseif(auth()->user()->role->nombre_rol == 'Empresa')
                                <a href="{{ route('home') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                    Panel Empresa
                                </a>
                            @endif
                            
                            <!-- Botón de prueba -->
                            <a href="{{ route('test.dashboard') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition">
                                Test Dashboard
                            </a>
                            
                            <!-- Botón de logout -->                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-white text-[#7705B6] px-4 py-2 rounded-lg font-medium border border-[#7705B6] hover:bg-gray-50 transition">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- INICIAR SESIÓN --}}
                            <a href="{{ route('login') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                Iniciar sesión
                            </a>
                        {{-- REGISTRARSE --}}
                            <a href="{{ route('register') }}" class="bg-white text-[#7705B6] px-4 py-2 rounded-lg font-medium border border-[#7705B6] hover:bg-gray-50 transition">
                                Registrarte
                            </a>
                    @endauth
                </div>
        </div>
    </header>