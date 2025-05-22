<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>NextGen - Chat</title>
    
    @php
    use Illuminate\Support\Facades\Auth;
    @endphp
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-purple-50">
        <!-- Header -->
        @include('partials.header')
        
        <!-- Migas de pan -->
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
                    @php                        $user = auth()->user();                        $dashboardRoute = match($user->role_id) {                            2 => route('empresa.dashboard'),                            3 => route('student.dashboard'),                            4 => route('docente.dashboard'),                            5 => route('institucion.dashboard'),                            default => '#'                        };                        $dashboardName = match($user->role_id) {                            2 => 'Dashboard Empresa',                            3 => 'Dashboard Estudiante',                            4 => 'Dashboard Docente',                            5 => 'Dashboard Institución',                            default => 'Dashboard'                        };
                    @endphp
                    
                    @if($dashboardRoute !== '#')
                    <a href="{{ $dashboardRoute }}" class="text-gray-500 hover:text-purple-700 transition-colors duration-200">
                        {{ $dashboardName }}
                    </a>
                    <span class="mx-2 text-gray-400">/</span>
                    @endif
                    <span class="text-purple-700 font-medium">@yield('title', 'Chat')</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Mensajes de alerta -->
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

            <!-- Contenido principal -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                @yield('content')
            </div>
        </div>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>
    
    @stack('scripts')
</body>
</html> 