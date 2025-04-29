@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Encabezado del Dashboard -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Dashboard de Empresa
            </h1>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-[#7705B6] mb-4">Bienvenido/a, {{ $user->nombre }}</h2>
                        <p class="text-gray-600">Este es tu panel de control donde podrás gestionar tus ofertas de prácticas y ver los estudiantes interesados.</p>
                    </div>

                    <!-- Tarjetas de Información -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-[#7705B6] mb-2">Ofertas Publicadas</h3>
                            <p class="text-3xl font-bold">0</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-[#7705B6] mb-2">Estudiantes Interesados</h3>
                            <p class="text-3xl font-bold">0</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-[#7705B6] mb-2">Prácticas Activas</h3>
                            <p class="text-3xl font-bold">0</p>
                        </div>
                    </div>

                    <!-- Información de la Empresa -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-xl font-semibold text-[#7705B6] mb-4">Información de la Empresa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">CIF</p>
                                <p class="font-medium">{{ $empresa->cif ?? 'No disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Dirección</p>
                                <p class="font-medium">{{ $empresa->direccion ?? 'No disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Provincia</p>
                                <p class="font-medium">{{ $empresa->provincia ?? 'No disponible' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-semibold text-[#7705B6] mb-4">Acciones Rápidas</h3>
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="bg-[#7705B6] text-white px-4 py-2 rounded-lg hover:bg-[#5E0490] transition">
                                Publicar Nueva Oferta
                            </a>
                            <a href="#" class="bg-white text-[#7705B6] border border-[#7705B6] px-4 py-2 rounded-lg hover:bg-purple-50 transition">
                                Ver Candidatos
                            </a>
                            <a href="#" class="bg-white text-[#7705B6] border border-[#7705B6] px-4 py-2 rounded-lg hover:bg-purple-50 transition">
                                Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
