{{-- HEADER --}}
    <header class="bg-[#D0AAFE] py-4 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- LOGO -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                {{-- NOMBRE DE LA EMPRESA --}}
                    <span class="ml-2 text-xl font-bold text-[#7705B6]">NextGen</span>
            </div>
            
            {{-- BOTONES LOGIN/REGISTER --}}
                <div class="flex space-x-4">
                    @auth
                        @if(auth()->user()->rol->nombre == 'alumno')
                            <a href="{{ route('alumno.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                Panel Alumno
                            </a>
                        @elseif(auth()->user()->rol->nombre == 'empresa')
                            <a href="{{ route('empresa.dashboard') }}" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg font-medium hover:bg-[#5E0490] transition">
                                Panel Empresa
                            </a>
                        @endif
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