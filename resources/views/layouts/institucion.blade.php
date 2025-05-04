<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>NextGen - Panel de Institución</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7705B6',
                        'primary-dark': '#5E0490',
                        secondary: '#4A90E2',
                        'secondary-dark': '#3A7BC8'
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Swiper.js para sliders -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        @include('partials.header')

        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Sidebar -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <div class="flex items-center space-x-4 mb-6">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nombre) }}&background=7705B6&color=fff" alt="Usuario" class="w-16 h-16 rounded-full">
                            <div>
                                <h2 class="text-lg font-bold">{{ Auth::user()->nombre }}</h2>
                                <p class="text-gray-600">Institución</p>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-gray-600 mb-2">Email: <span class="font-medium">{{ Auth::user()->email }}</span></p>
                            <p class="text-gray-600">Estado: <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Activa</span></p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-lg mb-4 text-gray-800">Menú</h3>
                        <nav>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('institucion.dashboard') }}" class="block p-2 {{ request()->routeIs('institucion.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded font-medium">
                                        <i class="fas fa-chart-line mr-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('institucion.docentes.index') }}" class="block p-2 {{ request()->routeIs('institucion.docentes.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i> Docentes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('institucion.departamentos.index') }}" class="block p-2 {{ request()->routeIs('institucion.departamentos.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">
                                        <i class="fas fa-building mr-2"></i> Departamentos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('institucion.clases.index') }}" class="block p-2 {{ request()->routeIs('institucion.clases.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">
                                        <i class="fas fa-graduation-cap mr-2"></i> Clases
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('institucion.solicitudes.index') }}" class="flex items-center p-2 {{ request()->routeIs('institucion.solicitudes.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">
                                        <i class="fas fa-envelope mr-2"></i> Solicitudes
                                        @if(Auth::user()->institucion->solicitudesPendientes()->count() > 0)
                                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                {{ Auth::user()->institucion->solicitudesPendientes()->count() }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('institucion.perfil') }}" class="block p-2 {{ request()->routeIs('institucion.perfil') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }} rounded">
                                        <i class="fas fa-user-cog mr-2"></i> Perfil
                                    </a>
                                </li>
                                <li class="pt-4 border-t mt-4">
                                    <a href="{{ route('home') }}" class="block p-2 text-gray-600 hover:bg-gray-100 rounded">
                                        <i class="fas fa-arrow-left mr-2"></i> Volver a Inicio
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left p-2 text-gray-600 hover:bg-gray-100 rounded">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">@yield('title', 'Panel de Institución')</h1>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>
    
    @stack('scripts')
</body>
</html> 