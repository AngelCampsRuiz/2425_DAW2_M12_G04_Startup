<!-- Sidebar para la empresa -->
@php
use Illuminate\Support\Facades\Auth;
@endphp

<div class="w-full md:w-1/4">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center space-x-4 mb-6">
            @if(auth()->user()->imagen)
                <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-purple-50 border-2 border-purple-200 overflow-hidden">
                    <img src="{{ asset('profile_images/' . auth()->user()->imagen) }}" alt="Logo empresa" class="w-full h-full object-contain">
                    <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                </div>
            @else
                <div class="relative">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                </div>
            @endif
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ auth()->user()->nombre }}</h2>
                <p class="text-indigo-600 font-medium">Empresa</p>
            </div>
        </div>
        <div class="border-t pt-4">
            <p class="text-gray-600 mb-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                CIF: <span class="font-medium text-gray-800 ml-1">{{ auth()->user()->empresa->cif ?? 'No especificado' }}</span>
            </p>
            <p class="text-gray-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Estado: <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-2 py-1 rounded-full text-xs font-medium ml-1 shadow-sm">Activa</span>
            </p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
        <h3 class="font-bold text-lg mb-4 text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            Menú
        </h3>
        <nav>
            <ul class="space-y-2">
                <li><a href="{{ route('empresa.dashboard') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.dashboard' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-14 0l2 2m0 0l7 7 7-7m-14 0l2-2" />
                    </svg>
                    Dashboard
                </a></li>
                <li><a href="{{ route('profile') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'profile' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'profile' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Perfil de empresa
                </a></li>
                <li><a href="{{ route('empresa.calendar') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.calendar' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.calendar' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Calendario
                </a></li>
                <!-- <li><a href="javascript:void(0)" onclick="openSearchCandidatesModal()" class="flex items-center p-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Buscar candidatos
                </a></li> -->
                <li><a href="javascript:void(0)" onclick="openModal()" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.create' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Publicar oferta
                </a></li>
                <li><a href="{{ route('empresa.offers.active') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.active' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ofertas Activas
                </a></li>
                <li><a href="{{ route('empresa.offers.inactive') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.offers.inactive' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ofertas Inactivas
                </a></li>
                <li><a href="{{ route('empresa.convenios') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'empresa.convenios' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'empresa.convenios' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Convenios
                </a></li>
                <li><a href="{{ route('chat.index') }}" class="flex items-center p-2 {{ Route::currentRouteName() == 'chat.index' ? 'bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 border-l-4 border-purple-600' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ Route::currentRouteName() == 'chat.index' ? 'text-purple-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Mensajes
                </a></li>
            </ul>
        </nav>
    </div>
</div>