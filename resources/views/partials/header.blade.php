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

                            <!-- Botón de panel según rol -->
                            @if(auth()->user()->role->nombre_rol == 'Estudiante')
                                <a href="{{ route('student.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                    Panel Alumno
                                </a>
                            @elseif(auth()->user()->role->nombre_rol == 'Empresa')
                                <a href="{{ route('empresa.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                    Panel Empresa
                                </a>
                            @endif

                            <!-- Dropdown -->
                            <div class="relative">
                                <!-- Icono de usuario -->
                                <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                                    <span class="text-[#7705B6] font-medium">{{ auth()->user()->nombre }}</span>
                                    <svg class="w-6 h-6 text-[#7705B6]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
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

    <script src="{{ asset('js/perfil.js') }}"></script>