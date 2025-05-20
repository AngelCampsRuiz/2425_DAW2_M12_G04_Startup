{{-- HEADER --}}
@auth
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endauth
<header class="bg-gradient-to-r from-[#D0AAFE] to-[#E5D0FF] py-4 px-6 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <!-- LOGO & BRAND - Redirige al panel según el rol -->
        <div class="flex items-center">
            @auth
                @php
                    $dashboardRoute = '';
                    $dashboardIcon = '';
                    $roleName = '';
                    switch(auth()->user()->role->nombre_rol) {
                        case 'Estudiante':
                            $roleName = 'Panel Alumno';
                            $dashboardRoute = route('student.dashboard');
                            $dashboardIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>';
                            break;
                        case 'Empresa':
                            $roleName = 'Panel Empresa';
                            $dashboardRoute = route('empresa.dashboard');
                            $dashboardIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>';
                            break;
                        case 'Institución':
                            $roleName = 'Panel Institución';
                            $dashboardRoute = route('institucion.dashboard');
                            $dashboardIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>';
                            break;
                        case 'Docente':
                            $roleName = 'Panel Docente';
                            $dashboardRoute = route('docente.dashboard');
                            $dashboardIcon = '<path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998a12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998a12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>';
                            break;
                        case 'Administrador':
                            $roleName = 'Panel Administrador';
                            $dashboardRoute = route('admin.dashboard');
                            $dashboardIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>';
                            break;
                        default:
                            $dashboardRoute = route('home');
                            $roleName = 'Inicio';
                            $dashboardIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />';
                            break;
                    }
                @endphp
                <a href="{{ $dashboardRoute }}" class="group flex items-center transition-all duration-300">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" class="h-12 transition-transform duration-300 group-hover:scale-110">
                        @if($dashboardRoute != url('/'))
                            <div class="absolute -bottom-6 left-0 right-0 h-1 bg-[#7705B6] transform translate-y-1 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"></div>
                        @endif
                    </div>
                    <div class="ml-3 flex flex-col">
                        <span class="text-2xl font-bold text-[#7705B6] transition-all duration-300 group-hover:text-[#5E0490]">NextGen</span>
                        @if($dashboardRoute != url('/'))
                            <span class="text-xs text-[#7705B6]/70 transition-all duration-300 group-hover:text-[#5E0490]">
                                Ir a mi panel
                                <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </a>
            @else
                <a href="{{ url('/') }}" class="flex items-center transition-transform hover:scale-105">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="NextGen Logo" class="h-12">
                    <span class="ml-3 text-2xl font-bold text-[#7705B6]">NextGen</span>
                </a>
            @endauth
        </div>

        <!-- Agrupa campana, user dropdown y hamburguesa -->
        <div class="flex items-center space-x-2">
            @auth
            <!-- Campana de notificaciones -->
            <div class="relative flex items-center">
                <button id="notificationButton" class="focus:outline-none bg-white/30 px-3 py-2 rounded-lg hover:bg-white/50 transition-all flex items-center">
                    <svg class="w-6 h-6 text-[#7705B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notificationCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full" style="display:none;">
                        0
                    </span>
                </button>
                <!-- Dropdown de notificaciones -->
                <div id="notificationDropdown" class="hidden absolute right-0 top-10 w-80 bg-white rounded-lg shadow-lg z-50">
                    <div class="p-4 border-b font-bold text-[#7705B6]">Notificaciones</div>
                    <div id="notificationList" class="max-h-60 overflow-y-auto">
                        <!-- Aquí se cargarán las notificaciones -->
                    </div>
                </div>
            </div>
            @endauth

            <!-- Botones de usuario (solo en desktop) -->
            <div class="hidden md:flex items-center space-x-6">
                @auth
                    <div class="flex items-center space-x-5">
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
                                <a href="{{ $dashboardRoute }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                    <svg class="w-5 h-5 mr-2 text-[#9333EA]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        {!! $dashboardIcon !!}
                                    </svg>
                                    {{ $roleName }}
                                </a>
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Mi Perfil
                                </a>
                                <a href="{{ route('chat.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Mis Conversaciones
                                    <span class="notification-badge ml-2 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                                </a>
                                @if(auth()->user()->role->nombre_rol === 'Estudiante')
                                <a href="{{ route('estudiante.solicitudes.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#7705B6]">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Mis Solicitudes
                                </a>
                                @endif
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

            <!-- Botón hamburguesa (solo en móvil) -->
            <div class="md:hidden">
                <button id="mobileMenuButton" class="text-[#7705B6] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
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
                <a href="{{ $dashboardRoute }}" class="bg-[#7705B6] text-white px-4 py-2.5 rounded-lg font-medium hover:bg-[#5E0490] transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        {!! $dashboardIcon !!}
                    </svg>
                    {{ $roleName }}
                </a>
                <a href="{{ route('profile') }}" class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mi Perfil
                </a>
                <a href="{{ route('chat.index') }}" class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Mis Conversaciones
                    <span class="notification-badge ml-2 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                </a>
                @if(auth()->user()->role->nombre_rol === 'Estudiante')
                <a href="{{ route('estudiante.solicitudes.index') }}" class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Mis Solicitudes
                </a>
                @endif
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
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="{{ asset('js/notificacion.js') }}"></script>