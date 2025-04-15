@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- MIGAS DE PAN --}}
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#5e0490]">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-[#5e0490] font-medium">Mis Conversaciones</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6 transform transition-all duration-300 hover:shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-[#5e0490] flex items-center justify-center">
                        <i class="fas fa-comments text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Mis Conversaciones</h1>
                        <p class="text-gray-600">Gestiona tus conversaciones con empresas y estudiantes</p>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-[#5e0490] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>

        <!-- Lista de chats -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden transform transition-all duration-300 hover:shadow-md">
            @if($chats->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-purple-100 mb-4 transform transition-transform duration-300 hover:scale-105">
                        <i class="fas fa-comments text-3xl text-[#5e0490]"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No tienes conversaciones</h3>
                    <p class="mt-2 text-gray-500">Aún no has iniciado ninguna conversación.</p>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach($chats as $chat)
                        <a href="{{ route('chat.show', $chat->id) }}" 
                           class="block p-6 hover:bg-gray-50 transition-colors duration-200 transform hover:scale-[1.01]">
                            <div class="flex items-start space-x-6">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden ring-4 ring-white shadow-lg transform transition-transform duration-300 hover:scale-105">
                                        @if(auth()->user()->empresa)
                                            @if($chat->solicitud->estudiante->user->imagen)
                                                <img src="{{ asset('public/profile_images/' . $chat->solicitud->estudiante->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-[#5e0490]">
                                                    {{ strtoupper(substr($chat->solicitud->estudiante->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @else
                                            @if($chat->solicitud->publicacion->empresa->user->imagen)
                                                <img src="{{ asset('public/profile_images/' . $chat->solicitud->publicacion->empresa->user->imagen) }}" 
                                                     alt="Foto de perfil" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-2xl font-bold text-[#5e0490]">
                                                    {{ strtoupper(substr($chat->solicitud->publicacion->empresa->user->nombre, 0, 2)) }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Información del chat -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            @if(auth()->user()->empresa)
                                                {{ $chat->solicitud->estudiante->user->nombre }}
                                            @else
                                                {{ $chat->solicitud->publicacion->empresa->user->nombre }}
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500">
                                            {{ $chat->updated_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-gray-600 truncate">
                                            {{ $chat->solicitud->publicacion->titulo }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-comment-alt mr-1.5 text-[#5e0490]"></i>
                                        {{ $chat->mensajes->count() }} mensajes
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection 