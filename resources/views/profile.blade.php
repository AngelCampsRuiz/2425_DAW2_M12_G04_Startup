{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @section('content')
        <div class="profile-container">
            @php
                $user = auth()->user()->load('tutor');
            @endphp

            <div class="profile-card">
                <img src="{{ asset('path/to/profile/image.jpg') }}" alt="Profile Picture" class="profile-image">
                <div class="profile-info">
                    <h2>{{ $user->nombre }}</h2>
                    <p>{{ $user->email }}</p>
                    @if($user->role_id == 3)
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                        <p>Soy un chico muy comprometido con el trabajo, me gusta el ping pong y beber palincă con los chavales en el parque.</p>
                        <a href="{{ asset('path/to/CV_MarioPalamari.pdf') }}" class="cv-link">CV_MarioPalamari.pdf</a>
                    @elseif($user->role_id == 2)
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                        <p>Soy un chico muy comprometido con el trabajo, me gusta el ping pong y beber palincă con los chavales en el parque.</p>
                        <a href="{{ $user->sitio_web }}" class="cv-link">{{ $user->sitio_web }}</a>
                    @elseif($user->role_id == 4)
                        <p>Trabajo en: {{ $user->tutor->centro_asignado }}</p>
                        <p>Soy un chico muy comprometido con el trabajo, me gusta el ping pong y beber palincă con los chavales en el parque.</p>
                        <a href="{{ asset('path/to/CV_MarioPalamari.pdf') }}" class="cv-link">CV_MarioPalamari.pdf</a>
                    @elseif($user->role_id == 1)
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                    @endif
                </div>
                @if(auth()->id() == $user->id)
                    <div class="profile-actions">
                        <button class="edit-button">
                            <i class="fas fa-edit mr-1"></i>
                        </button>
                        <button class="delete-button">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @if($user->role_id == 2 || $user->role_id == 3)
            <h1>Comentarios</h1>
        @elseif($user->role_id == 4)
            <h1>Alumnos</h1>
        @endif

        <div>
            {{-- @foreach ($comentarios as $comentario)
                <div>
                </div>
            @endforeach --}}
        </div>
    @endsection