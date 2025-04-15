@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">Mis Conversaciones</h1>
                <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>

        <!-- Lista de chats -->
        <div class="bg-white rounded-lg shadow-sm">
            @if($chats->isEmpty())
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-comments text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No tienes conversaciones</h3>
                    <p class="mt-2 text-gray-500">Aún no has iniciado ninguna conversación.</p>
                </div>
            @else
                <div class="overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($chats as $chat)
                            <a href="{{ route('chat.show', $chat->id) }}" class="block p-6 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-start space-x-6">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden">
                                            @if(auth()->user()->empresa)
                                                @if($chat->solicitud->estudiante->user->imagen)
                                                    <img src="{{ asset('public/profile_images/' . $chat->solicitud->estudiante->user->imagen) }}" 
                                                         alt="Foto de perfil" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xl font-bold text-purple-700">
                                                        {{ strtoupper(substr($chat->solicitud->estudiante->user->nombre, 0, 2)) }}
                                                    </span>
                                                @endif
                                            @else
                                                @if($chat->solicitud->publicacion->empresa->user->imagen)
                                                    <img src="{{ asset('public/profile_images/' . $chat->solicitud->publicacion->empresa->user->imagen) }}" 
                                                         alt="Foto de perfil" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xl font-bold text-purple-700">
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
                                            <i class="fas fa-comment-alt mr-1.5 text-gray-400"></i>
                                            {{ $chat->mensajes->count() }} mensajes
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Añadir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection 