@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex">
                    {{-- IMAGEN DE LA EMPRESA --}}
                    <div class="w-1/3">
                        <img src="{{ $publication->empresa->logo_url ?? asset('assets/images/company-default.png') }}" 
                            alt="{{ $publication->empresa->nombre }}"
                            class="w-full h-full object-cover">
                    </div>
                    {{-- INFORMACIÓN DE LA PUBLICACIÓN --}}
                    <div class="w-2/3 p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $publication->titulo }}</h3>
                        <p class="text-primary font-medium mb-2">{{ $publication->empresa->nombre }}</p>
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ ucfirst($publication->horario) }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $publication->horas_totales }} horas totales
                        </div>
                        <p class="text-sm text-gray-600">{{ $publication->descripcion }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 