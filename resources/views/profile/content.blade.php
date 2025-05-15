{{-- Contenido del perfil --}}
<div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
    {{-- Header del Perfil con gradiente --}}
    <div class="relative h-64 bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-600">
        <div class="absolute -bottom-20 left-8">
            <div class="w-40 h-40 rounded-full bg-white border-4 border-white shadow-xl flex items-center justify-center overflow-hidden transform transition-transform duration-300 hover:scale-105">
                @if($user->imagen)
                    <img src="{{ asset('public/profile_images/' . $user->imagen) }}"
                         alt="Foto de perfil"
                         class="w-full h-full object-cover"
                         loading="lazy">
                @else
                    <span class="text-6xl font-bold text-purple-600">
                        {{ strtoupper(substr($user->nombre, 0, 2)) }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Contenido Principal --}}
    <div class="pt-24 px-8 pb-8">
        {{-- Información Principal --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $user->nombre }}</h1>
                <div class="flex items-center space-x-4">
                    <p class="text-purple-600 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        {{ $user->email }}
                    </p>
                </div>
            </div>
            @if(auth()->id() == $user->id)
                <div class="flex space-x-4">
                    <button onclick="openEditModal()"
                            class="edit-button px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Editar Perfil</span>
                    </button>

                    <a href="{{ route('chat.index') }}"
                       class="chat-button px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>Ir al Chat</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- Descripción --}}
        @if($user->descripcion)
            <div class="bg-purple-50 rounded-xl p-6 mb-8">
                <p class="text-gray-700 leading-relaxed">{{ $user->descripcion }}</p>
            </div>
        @endif

        {{-- Información Personal --}}
        @include('profile.partials.personal-info', ['user' => $user])

        {{-- Experiencias --}}
        @include('profile.partials.experiences', ['user' => $user])

        {{-- Valoraciones --}}
        @include('profile.partials.ratings', ['valoracionesRecibidas' => $valoracionesRecibidas])
    </div>
</div> 