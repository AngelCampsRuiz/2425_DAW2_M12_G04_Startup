{{-- HEADER --}}
@extends('layouts.app')

{{-- CONTENIDO --}}
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex flex-wrap">
                <a href="{{ route('admin.publicaciones.index') }}" class="flex-1 bg-purple-200 text-purple-800 font-semibold py-3 px-4 rounded-md text-center mx-1 {{ request()->routeIs('admin.publicaciones.*') ? 'bg-purple-300' : '' }}">
                    OFERTAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    CATEGORÍAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    EMPRESAS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    ALUMNOS
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-800 font-semibold py-3 px-4 rounded-md text-center mx-1">
                    PROFESORES
                </a>
            </div>
        </div>

        <div class="mb-6 flex justify-end">
            @if(request()->routeIs('admin.publicaciones.*') && !request()->routeIs('admin.publicaciones.create'))
                <a href="{{ route('admin.publicaciones.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    AÑADIR
                </a>
            @endif
        </div>

        @yield('admin_content')
    </div>
@endsection
