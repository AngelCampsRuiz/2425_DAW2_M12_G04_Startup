@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary/20 to-secondary/20 flex flex-col">
    <div class="container mx-auto py-12 px-4">
        <!-- Título y descripción -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-primary mb-2">Ranking del Juego Espacial</h1>
            <p class="text-lg text-gray-600">¡Compite por ser el mejor astronauta del universo!</p>
            
            <div class="mt-6">
                <a href="{{ route('game.error-page') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0 0 10 9.87v4.263a1 1 0 0 0 1.555.832l3.197-2.132a1 1 0 0 0 0-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                    </svg>
                    Jugar Ahora
                </a>
            </div>
        </div>
        
        <!-- Grid de tablas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Mejores puntuaciones -->
            <div class="bg-white/60 rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-primary mb-4">Top 50 Puntuaciones</h2>
                <div class="overflow-y-auto max-h-[500px]">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold">#</th>
                                <th class="py-3 px-4 text-left font-semibold">Jugador</th>
                                <th class="py-3 px-4 text-right font-semibold">Puntuación</th>
                                <th class="py-3 px-4 text-right font-semibold">Obstáculos</th>
                                <th class="py-3 px-4 text-right font-semibold">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topScores as $index => $score)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->player_name }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->score }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->obstacles_avoided }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center">No hay puntuaciones registradas aún. ¡Sé el primero en jugar!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Información de jugadores -->
            <div class="space-y-8">
                <!-- Mejores jugadores -->
                <div class="bg-white/60 rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-primary mb-4">Mejores Jugadores</h2>
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold">#</th>
                                <th class="py-3 px-4 text-left font-semibold">Jugador</th>
                                <th class="py-3 px-4 text-right font-semibold">Mejor Puntuación</th>
                                <th class="py-3 px-4 text-right font-semibold">Total Obstáculos</th>
                                <th class="py-3 px-4 text-right font-semibold">Partidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bestPlayers as $index => $player)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $player->player_name }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $player->max_score }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $player->total_obstacles }}</td>
                                    <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $player->games_played }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center">No hay jugadores registrados aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Puntuaciones recientes -->
                <div class="bg-white/60 rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-primary mb-4">Últimas Partidas</h2>
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold">Jugador</th>
                                <th class="py-3 px-4 text-right font-semibold">Puntuación</th>
                                <th class="py-3 px-4 text-right font-semibold">Obstáculos</th>
                                <th class="py-3 px-4 text-right font-semibold">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentScores as $index => $score)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="py-3 px-4">{{ $score->player_name }}</td>
                                    <td class="py-3 px-4 text-right">{{ $score->score }}</td>
                                    <td class="py-3 px-4 text-right">{{ $score->obstacles_avoided }}</td>
                                    <td class="py-3 px-4 text-right">{{ $score->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-center">No hay partidas registradas aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas generales -->
        <div class="mt-10 bg-white/60 rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-primary mb-6">Estadísticas Generales</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl font-bold text-primary">{{ $topScores->count() }}</div>
                    <div class="text-gray-600">Partidas Jugadas</div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl font-bold text-primary">{{ $bestPlayers->count() }}</div>
                    <div class="text-gray-600">Jugadores Únicos</div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl font-bold text-primary">{{ $topScores->isNotEmpty() ? $topScores->first()->score : 0 }}</div>
                    <div class="text-gray-600">Mejor Puntuación</div>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl font-bold text-primary">{{ $topScores->sum('obstacles_avoided') }}</div>
                    <div class="text-gray-600">Total Obstáculos Esquivados</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 