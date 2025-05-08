@extends('layouts.app')

@section('content')
{{-- BREADCRUMBS --}}
<div class="bg-white shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Inicio
            </a>
            <span class="mx-2 text-gray-400">/</span>
            @if(auth()->user()->role_id == 3)
            <a href="{{ route('student.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                Ofertas laborales
            </a>
            @elseif(auth()->user()->role_id == 4)
            <a href="{{ route('institucion.dashboard') }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                Dashboard
            </a>
            @endif
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-purple-700 font-medium">
                @if($user->role_id == 3)
                    <a href="{{ route('profile') }}" class="text-gray-500 hover:text-purple-900 transition-colors duration-200">Perfil de Estudiante</a>
                @elseif($user->role_id == 4)
                    <a href="{{ route('profile') }}" class="text-gray-500 hover:text-purple-900 transition-colors duration-200">Perfil de Institución</a>
                @else
                    Perfil
                @endif
            </span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-purple-700 font-medium">
                Publicaciones Guardadas
            </span>
        </div>
    </div>
</div>
<div class="max-w-4xl mx-auto py-10">

    <h1 class="text-3xl font-bold text-purple-700 mb-8">Publicaciones Guardadas</h1>

    @if($saved->count())
        <div class="grid grid-cols-1 gap-6">
            @foreach($saved as $publicacion)
                <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                    {{-- Imagen de la empresa --}}
                    <div class="flex-shrink-0">
                        @if($publicacion->empresa && $publicacion->empresa->user->imagen)
                            <img src="{{ asset('public/profile_images/' . $publicacion->empresa->user->imagen) }}" alt="Logo empresa" class="w-14 h-14 rounded-full object-cover border-2 border-purple-200">
                        @else
                            {{-- Avatar por defecto --}}
                            <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center border-2 border-purple-200">
                                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-lg text-gray-800">
                                {{ $publicacion->empresa->user->nombre ?? 'Empresa desconocida' }}
                            </span>
                            <span class="text-gray-400 text-sm">• {{ $publicacion->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="font-semibold text-purple-800">{{ $publicacion->titulo }}</div>
                        <div class="text-gray-700">{{ Str::limit($publicacion->descripcion, 120) }}</div>
                    </div>
                    <div>
                        <div class="flex flex-col gap-2 ml-4">
                            <a href="{{ route('publication.show', $publicacion->id) }}" title="Ver publicación"
                               class="bg-[#5e0490]/10 hover:bg-[#5e0490]/20 text-[#5e0490] p-3 rounded-xl transition-colors flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <button type="submit" title="Eliminar de guardados"
                                class="bg-red-100 hover:bg-red-200 text-red-600 p-3 rounded-xl transition-colors flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-8 text-center text-gray-500">
            No tienes publicaciones guardadas activas.
        </div>
    @endif
</div>
<script src="{{ asset('js/savedPublications.js') }}"></script>
@endsection