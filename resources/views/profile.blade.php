{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @section('content')
        <div class="profile-container">

            <div class="profile-card">
                <img src="{{ asset('path/to/profile/image.jpg') }}" alt="Profile Picture" class="profile-image">
                <div class="profile-info">
                    <h2>{{ $user->nombre }}</h2>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->descripcion }}</p>
                    @if($user->role_id == 3)
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                        <a href="{{ asset('cv/' . $user->estudiante->cv_pdf) }}" class="cv-link" target="_blank">{{ $user->estudiante->cv_pdf }}</a>
                    @elseif($user->role_id == 2)
                        <p>Grado superior en Desarrollo de Aplicaciones Web</p>
                        <a href="{{ $user->sitio_web }}" class="cv-link" target="_blank">{{ $user->sitio_web }}</a>
                    @elseif($user->role_id == 4)
                        {{-- <p>Especialidad: {{ $user->nombre_categoria }}</p> --}}
                        <p>Trabajo en: <a href="{{ asset($user->sitio_web) }}" class="cv-link" target="_blank">{{ $user->tutor->centro_asignado }}</a></p>
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
            <h1>asd --</h1>
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