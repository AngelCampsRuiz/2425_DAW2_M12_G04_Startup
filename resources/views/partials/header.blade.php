{{-- HEADER --}}
<header class="bg-gradient-to-r from-[#D0AAFE] to-[#E5D0FF] py-4 px-6 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- LOGO & BRAND -->
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="flex items-center transition-transform hover:scale-105">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" class="h-12">
                <span class="ml-3 text-2xl font-bold text-[#7705B6]">NextGen</span>
            </a>
        </div>

        {{-- NAVIGATION BUTTONS --}}
        <div class="hidden md:flex items-center space-x-6">
            @auth
                <div class="flex items-center space-x-5">
                    <!-- Panel button based on role -->
                    @if(auth()->user()->role->nombre_rol == 'Estudiante')
                        <a href="{{ route('student.dashboard') }}" class="bg-[#7705B6] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Panel Alumno
                        </a>
                    @elseif(auth()->user()->role->nombre_rol == 'Empresa')
                        <a href="{{ route('empresa.dashboard') }}" class="bg-[#7705B6] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Panel Empresa
                        </a>
                    @elseif(auth()->user()->role->nombre_rol == 'Institución')
                        <a href="{{ route('institucion.dashboard') }}" class="bg-[#7705B6] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Panel Institución
                        </a>
                    @elseif(auth()->user()->role->nombre_rol == 'Docente')
                        <a href="{{ route('docente.dashboard') }}" class="bg-[#7705B6] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            Panel Docente
                        </a>
                    @endif

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none bg-white/30 px-4 py-2 rounded-lg hover:bg-white/50 transition-all">
                            <span class="text-[#7705B6] font-medium">{{ auth()->user()->nombre }}</span>
                            <svg class="w-6 h-6 text-[#7705B6]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-20 border border-purple-100 opacity-0 transform -translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm text-gray-500">Conectado como</p>
                                <p class="text-sm font-medium text-[#7705B6] truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mi Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-[#7705B6] text-white px-5 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-[#7705B6] px-5 py-2.5 rounded-lg font-medium border border-[#7705B6] hover:bg-gray-50 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Registrarte
                    </a>
                </div>
            @endauth
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
            <button id="mobileMenuButton" class="text-[#7705B6] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden md:hidden mt-4 bg-white rounded-lg shadow-lg p-4 transition-all duration-300 ease-in-out">
        @auth
            <div class="flex flex-col space-y-3">
                <div class="flex items-center mb-2 pb-2 border-b border-gray-200">
                    <svg class="w-6 h-6 text-[#7705B6] mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-[#7705B6] font-medium">{{ auth()->user()->nombre }}</span>
                </div>
                <!-- Panel button based on role -->
                @if(auth()->user()->role->nombre_rol == 'Estudiante')
                    <a href="{{ route('student.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition text-center">
                        Panel Alumno
                    </a>
                @elseif(auth()->user()->role->nombre_rol == 'Empresa')
                    <a href="{{ route('empresa.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition text-center">
                        Panel Empresa
                    </a>
                @elseif(auth()->user()->role->nombre_rol == 'Institución')
                    <a href="{{ route('institucion.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition text-center">
                        Panel Institución
                    </a>
                @elseif(auth()->user()->role->nombre_rol == 'Docente')
                    <a href="{{ route('docente.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition text-center">
                        Panel Docente
                    </a>
                @endif
                <a href="{{ route('profile') }}" class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mi Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        @else
            <div class="flex flex-col space-y-3">
                <a href="{{ route('login') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition text-center">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="bg-white text-[#7705B6] px-4 py-2 rounded-lg font-medium border border-[#7705B6] hover:bg-gray-50 transition text-center">
                    Registrarte
                </a>
            </div>
        @endauth
    </div>
</header>

<script>
    // User menu toggle
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
    
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>