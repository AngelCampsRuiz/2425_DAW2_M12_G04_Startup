@extends('layouts.app')

@section('content')
<!-- 
Sound credits:
These are fallback URLs for sound effects in case the local files aren't available.
You can download these sounds and place them in your /public/sounds/ directory.

Background music: https://freesound.org/people/DirtyJewbs/sounds/159392/
Explosion sound: https://freesound.org/people/cabled_mess/sounds/350972/
Power-up sound: https://freesound.org/people/Beetlemuse/sounds/528956/
Level up sound: https://freesound.org/people/plasterbrain/sounds/464902/
-->

<div class="min-h-screen bg-gradient-to-br from-purple-800/30 to-indigo-900/30 flex flex-col">
    <!-- Contenido principal -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="text-center relative max-w-5xl w-full">
            
            <!-- Frase divertida -->
            <div class="mb-6">
                <p class="text-2xl md:text-3xl font-bold text-purple-700 mb-2 drop-shadow-sm">¡Ups! Parece que te has perdido en el espacio</p>
                <p class="text-lg md:text-xl text-indigo-700">"No te preocupes, hasta los astronautas se pierden a veces... ¡pero siempre encuentran su camino de vuelta!"</p>
            </div>
            
            <!-- Canvas para el juego - Ahora más grande -->
            <div class="relative">
                <canvas id="gameCanvas" class="border-4 border-indigo-700/50 rounded-xl shadow-[0_0_30px_rgba(79,70,229,0.5)] mx-auto w-full max-w-5xl" width="1100" height="650"></canvas>
                
                <!-- Overlay de instrucciones -->
                <div id="instructions" class="absolute inset-0 bg-gradient-to-br from-violet-900/95 to-indigo-900/95 text-white flex flex-col items-center justify-center rounded-xl shadow-2xl">
                    {{-- <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white drop-shadow-md">¡Ayuda al cohete a escapar!</h2> --}}
                    <div class="max-w-lg w-full px-4">
                        <p class="text-xl mb-3 font-semibold text-yellow-200">Controles:</p>
                        <ul class="text-lg mb-5 space-y-2 bg-black/20 p-4 rounded-lg">
                            <li class="flex items-center"><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2">⬅️</span><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2">➡️</span>: Mover nave</li>
                            <li class="flex items-center"><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2">⬆️</span><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2">⬇️</span>: Subir/bajar</li>
                            <li class="flex items-center"><span class="inline-flex justify-center items-center bg-indigo-700 rounded px-2 h-8 mr-2 text-sm font-bold">Espacio</span>: Disparar</li>
                            <li class="flex items-center"><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2 font-bold">P</span>: Pausar</li>
                            <li class="flex items-center"><span class="inline-flex justify-center items-center bg-indigo-700 rounded w-8 h-8 mr-2 font-bold">M</span>: Activar/desactivar sonido</li>
                        </ul>
                        <p class="text-xl mb-3 font-semibold text-yellow-200">Power-Ups:</p>
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-indigo-800/70 p-3 rounded-lg shadow-md border border-indigo-600">
                                <span class="block text-green-300 font-bold flex items-center"><span class="bg-green-700 p-1 rounded mr-2">🛡️</span> Escudo</span>
                                <span class="text-sm">Invencibilidad temporal</span>
                            </div>
                            <div class="bg-indigo-800/70 p-3 rounded-lg shadow-md border border-indigo-600">
                                <span class="block text-red-300 font-bold flex items-center"><span class="bg-red-700 p-1 rounded mr-2">❤️</span> Vida extra</span>
                                <span class="text-sm">Aumenta tus vidas</span>
                            </div>
                            <div class="bg-indigo-800/70 p-3 rounded-lg shadow-md border border-indigo-600">
                                <span class="block text-blue-300 font-bold flex items-center"><span class="bg-blue-700 p-1 rounded mr-2">⚡</span> Velocidad</span>
                                <span class="text-sm">Aumenta tu velocidad</span>
                            </div>
                            <div class="bg-indigo-800/70 p-3 rounded-lg shadow-md border border-indigo-600">
                                <span class="block text-yellow-300 font-bold flex items-center"><span class="bg-yellow-600 p-1 rounded mr-2">×2</span> Multiplicador</span>
                                <span class="text-sm">Duplica los puntos</span>
                            </div>
                        </div>
                    </div>
                    <button id="startButton" class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black font-bold rounded-full transition-all transform hover:scale-105 focus:ring-4 focus:ring-yellow-300 shadow-lg">
                        ¡COMENZAR!
                    </button>
                </div>

                <!-- Overlay de Game Over con formulario -->
                <div id="gameOverScreen" class="hidden absolute inset-0 bg-gradient-to-br from-violet-900/95 to-indigo-900/95 text-white flex flex-col items-center justify-center rounded-xl shadow-2xl">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white drop-shadow-lg">¡GAME OVER!</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-8 w-full max-w-md px-4">
                        <div class="bg-indigo-800/80 p-4 rounded-lg text-center shadow-md border border-indigo-700">
                            <span class="block text-lg text-gray-300">Puntuación</span>
                            <span id="finalScore" class="text-3xl font-bold text-yellow-300">0</span>
                        </div>
                        <div class="bg-indigo-800/80 p-4 rounded-lg text-center shadow-md border border-indigo-700">
                            <span class="block text-lg text-gray-300">Obstáculos</span>
                            <span id="finalObstacles" class="text-3xl font-bold text-blue-300">0</span>
                        </div>
                        <div class="bg-indigo-800/80 p-4 rounded-lg text-center shadow-md border border-indigo-700">
                            <span class="block text-lg text-gray-300">Nivel</span>
                            <span id="finalLevel" class="text-3xl font-bold text-green-300">1</span>
                        </div>
                        <div class="bg-indigo-800/80 p-4 rounded-lg text-center shadow-md border border-indigo-700">
                            <span class="block text-lg text-gray-300">Tiempo</span>
                            <span id="finalTime" class="text-3xl font-bold text-purple-300">00:00</span>
                        </div>
                    </div>
                    
                    <!-- Formulario para guardar puntuación -->
                    <form id="scoreForm" action="{{ url('/save-score') }}" method="GET" class="w-full max-w-md px-4 mb-6">
                        <input type="hidden" id="scoreInput" name="score" value="0">
                        <input type="hidden" id="obstaclesInput" name="obstacles_avoided" value="0">
                        <div class="mb-4">
                            <input type="text" id="playerName" name="player_name" placeholder="Tu nombre" 
                                class="w-full px-4 py-3 bg-white text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-inner text-center text-lg">
                        </div>
                        <button type="submit" id="saveScoreBtn" class="w-full px-6 py-3 bg-gradient-to-r from-secondary to-secondary-dark text-white font-bold rounded-full hover:bg-secondary-dark transition-all transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Guardar puntuación
                        </button>
                    </form>
                    
                    <button id="restartFromOverBtn" class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-400 text-black font-bold rounded-full hover:bg-primary/10 transition-all transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Jugar de nuevo
                    </button>
                </div>
            </div>
            
            <!-- Controles del juego -->
            <div class="mt-4 text-primary flex justify-center gap-4 md:gap-6 items-center bg-white/80 p-3 rounded-xl border border-indigo-300 shadow-md max-w-3xl mx-auto">
                <div>
                    <p class="text-xl md:text-2xl font-bold mb-1 text-indigo-800">Puntuación: <span id="score" class="text-indigo-600 text-2xl md:text-3xl">0</span></p>
                    <p class="text-base md:text-lg text-indigo-800">Obstáculos: <span id="obstaclesAvoided" class="text-indigo-600">0</span></p>
                </div>
                <div class="flex flex-col items-center py-1 px-3 bg-indigo-700 rounded-lg text-white">
                    <span class="font-bold text-lg md:text-xl">Nivel</span>
                    <span id="levelDisplay" class="text-2xl md:text-3xl font-bold">1</span>
                </div>
                <div class="hidden md:block">
                    <div id="livesContainer" class="flex"></div>
                </div>
            </div>

            <!-- Botones de control -->
            <div class="mt-4 flex justify-center gap-2 md:gap-4 flex-wrap">
                <button id="restartButton" class="px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-full hover:from-indigo-700 hover:to-indigo-900 transition-all transform hover:scale-105 shadow-lg flex items-center text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reiniciar
                </button>
                <a href="/" class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-full hover:from-indigo-700 hover:to-indigo-900 transition-all transform hover:scale-105 shadow-lg text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Volver
                </a>
                <a href="{{ route('game.ranking') }}" class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-full hover:from-purple-700 hover:to-purple-900 transition-all transform hover:scale-105 shadow-lg text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Ranking
                </a>
            </div>
            
            <!-- Tabla de clasificación - más compacta -->
            <div class="mt-6 py-4 px-4 md:px-6 bg-white/80 rounded-xl shadow-lg border border-indigo-300 max-w-3xl mx-auto">
                <h2 class="text-xl md:text-2xl font-bold text-indigo-800 mb-3 flex items-center justify-center">
                    <svg class="w-5 h-5 md:w-6 md:h-6 mr-1 md:mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Ranking de Jugadores
                </h2>
                <div class="overflow-hidden rounded-lg border border-indigo-200">
                    <table id="rankingTable" class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-indigo-700 to-indigo-900 text-white">
                            <tr>
                                <th class="py-2 px-2 md:py-3 md:px-4 text-left font-semibold">#</th>
                                <th class="py-2 px-2 md:py-3 md:px-4 text-left font-semibold">Jugador</th>
                                <th class="py-2 px-2 md:py-3 md:px-4 text-right font-semibold">Puntuación</th>
                                <th class="py-2 px-2 md:py-3 md:px-4 text-right font-semibold">Obstáculos</th>
                            </tr>
                        </thead>
                        <tbody id="rankingBody">
                            @if(isset($topScores) && count($topScores) > 0)
                                @foreach($topScores as $index => $score)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-indigo-50' : 'bg-white' }} hover:bg-indigo-100 transition-colors">
                                        <td class="py-2 px-2 md:py-3 md:px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }} border-b border-indigo-100">
                                            @if($index == 0)
                                                <span class="inline-flex items-center justify-center bg-yellow-400 text-yellow-800 w-6 h-6 rounded-full">1</span>
                                            @elseif($index == 1)
                                                <span class="inline-flex items-center justify-center bg-gray-300 text-gray-700 w-6 h-6 rounded-full">2</span>
                                            @elseif($index == 2)
                                                <span class="inline-flex items-center justify-center bg-amber-600 text-amber-100 w-6 h-6 rounded-full">3</span>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td class="py-2 px-2 md:py-3 md:px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }} border-b border-indigo-100">{{ $score->player_name }}</td>
                                        <td class="py-2 px-2 md:py-3 md:px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }} border-b border-indigo-100">{{ $score->score }}</td>
                                        <td class="py-2 px-2 md:py-3 md:px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }} border-b border-indigo-100">{{ $score->obstacles_avoided }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-indigo-500 font-medium">Aún no hay puntuaciones. ¡Sé el primero en jugar!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const scoreElement = document.getElementById('score');
    const obstaclesAvoidedElement = document.getElementById('obstaclesAvoided');
    const restartButton = document.getElementById('restartButton');
    const startButton = document.getElementById('startButton');
    const instructions = document.getElementById('instructions');
    const gameOverScreen = document.getElementById('gameOverScreen');
    const finalScore = document.getElementById('finalScore');
    const finalObstacles = document.getElementById('finalObstacles');
    const scoreForm = document.getElementById('scoreForm');
    const playerNameInput = document.getElementById('playerName');
    const scoreInput = document.getElementById('scoreInput');
    const obstaclesInput = document.getElementById('obstaclesInput');
    const restartFromOverBtn = document.getElementById('restartFromOverBtn');
    
    // Game state
    let score = 0;
    let obstaclesAvoided = 0;
    let gameOver = false;
    let gameStarted = false;
    let level = 1;
    let lives = 3;
    let isInvincible = false;
    let invincibleTimer = 0;
    let gameTime = 0;
    let isPaused = false;
    
    // Initialize UI
    document.getElementById('levelDisplay').textContent = level;
    updateLivesDisplay();
    
    // Game settings
    const GAME_SETTINGS = {
        spawnRate: 0.02,
        obstacleSpeed: 3,
        powerUpChance: 0.005,
        levelUpTime: 30, // seconds
        invincibilityTime: 2 // seconds
    };
    
    // Sound effects
    const sounds = {
        explosion: new Audio('/sounds/350972.wav'),
        powerup: new Audio('/sounds/528956.wav'),
        background: new Audio('/sounds/159392.wav'),
        levelUp: new Audio('/sounds/464902.flac')
    };
    
    // Mute state
    let isMuted = true; // Start muted to avoid autoplay issues
    
    // Try to preload sounds
    try {
        Object.values(sounds).forEach(sound => {
            sound.load();
            sound.volume = 0.5;
        });
        
        // Loop background music
        sounds.background.loop = true;
    } catch (e) {
        console.error('Error loading sounds:', e);
    }
    
    // Function to play a sound
    function playSound(soundName) {
        if (!isMuted && sounds[soundName]) {
            try {
                sounds[soundName].currentTime = 0;
                sounds[soundName].play().catch(e => console.log('Error playing sound:', e));
            } catch (e) {
                console.error('Error playing sound:', e);
            }
        }
    }
    
    // Cohete (player ship)
    const rocket = {
        x: canvas.width / 2,
        y: canvas.height - 80, // Ajustado para el canvas más alto
        width: 50, // Aumentado un poco para mejor visibilidad
        height: 75, // Aumentado proporcionalmente
        speed: 8, // Aumentado para un mejor control
        rotation: 0,
        boosting: false,
        thrusterAnimation: 0
    };
    
    // Obstáculos (obstacles)
    let obstacles = [];
    const obstacleTypes = [
        // Asteroids
        { width: 60, height: 60, color: '#7705B6', points: 1, type: 'asteroid', health: 1, speed: 1 },
        { width: 40, height: 40, color: '#4A90E2', points: 2, type: 'asteroid', health: 1, speed: 1.2 },
        { width: 80, height: 80, color: '#5E0490', points: 3, type: 'asteroid', health: 2, speed: 0.8 },
        // Enemy ships
        { width: 50, height: 30, color: '#E53935', points: 5, type: 'enemy', health: 1, speed: 1.5, shootsBack: true }
    ];
    
    // Power-ups
    const powerUpTypes = [
        { type: 'shield', color: '#4CAF50', duration: 10, effect: () => {
            isInvincible = true;
            invincibleTimer = GAME_SETTINGS.invincibilityTime * 60; // 60 frames per second
        }},
        { type: 'extraLife', color: '#F44336', effect: () => {
            lives = Math.min(lives + 1, 5); // Max 5 lives
        }},
        { type: 'speedBoost', color: '#2196F3', duration: 5, effect: () => {
            rocket.speed = 10; // Increase speed
            setTimeout(() => { rocket.speed = 6; }, 5000); // Reset after 5 seconds
        }},
        { type: 'scoreMultiplier', color: '#FFC107', duration: 8, effect: () => {
            // Apply 2x score multiplier for 8 seconds
            const originalPoints = obstacleTypes.map(t => t.points);
            obstacleTypes.forEach(t => { t.points *= 2; });
            setTimeout(() => {
                obstacleTypes.forEach((t, i) => { t.points = originalPoints[i]; });
            }, 8000);
        }}
    ];
    
    let powerUps = [];
    
    // Projectiles (bullets)
    let projectiles = [];
    let enemyProjectiles = [];
    
    // Partículas (particles)
    let particles = [];
    
    // Control de teclas
    const keys = {};
    
    // Event listeners
    window.addEventListener('keydown', (e) => {
        keys[e.key] = true;
        
        // Prevent default behavior for arrow keys and spacebar when game is active
        if ((e.key === 'ArrowUp' || e.key === 'ArrowDown' || 
             e.key === 'ArrowLeft' || e.key === 'ArrowRight' || 
             e.key === ' ') && (gameStarted || document.activeElement !== document.body)) {
            e.preventDefault();
        }
        
        // Pause game with 'p' key
        if (e.key === 'p' && gameStarted && !gameOver) {
            isPaused = !isPaused;
            if (!isPaused) {
                // Resume game
                gameLoop();
            }
        }
        
        // Fire with spacebar
        if (e.key === ' ' && gameStarted && !gameOver && !isPaused) {
            fireProjectile();
        }
        
        // Toggle sound with 'm' key
        if (e.key === 'm') {
            isMuted = !isMuted;
            if (!isMuted) {
                sounds.background.play().catch(e => console.log('Error playing background music:', e));
            } else {
                sounds.background.pause();
            }
        }
    });
    
    window.addEventListener('keyup', (e) => {
        keys[e.key] = false;
        
        // Stop boosting when up arrow is released
        if (e.key === 'ArrowUp') {
            rocket.boosting = false;
        }
    });
    
    // Touch controls for mobile
    let touchStartX = 0;
    let touchStartY = 0;
    
    canvas.addEventListener('touchstart', (e) => {
        if (!gameStarted) {
            // Start game on first touch
            instructions.style.display = 'none';
            gameStarted = true;
            if (!isMuted) {
                sounds.background.play().catch(e => console.log('Error playing background music:', e));
            }
            return;
        }
        
        const touch = e.touches[0];
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
        
        // Fire on touch
        fireProjectile();
        
        e.preventDefault();
    });
    
    canvas.addEventListener('touchmove', (e) => {
        if (!gameStarted || gameOver || isPaused) return;
        
        const touch = e.touches[0];
        const diffX = touch.clientX - touchStartX;
        const diffY = touch.clientY - touchStartY;
        
        // Move rocket based on touch movement
        rocket.x += diffX * 0.1;
        rocket.y += diffY * 0.1;
        
        // Boost if moving upwards
        rocket.boosting = diffY < 0;
        
        // Update touch position
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
        
        e.preventDefault();
    });
    
    canvas.addEventListener('touchend', () => {
        rocket.boosting = false;
    });
    
    // Fire projectile from rocket
    function fireProjectile() {
        projectiles.push({
            x: rocket.x,
            y: rocket.y - rocket.height / 2,
            width: 4,
            height: 15,
            color: '#FF6B6B',
            speed: 10
        });
    }
    
    // Actualizar valores del formulario cuando se muestra la pantalla de Game Over
    function showGameOver() {
        finalScore.textContent = score;
        finalObstacles.textContent = obstaclesAvoided;
        
        // Update new statistics
        document.getElementById('finalLevel').textContent = level;
        
        // Format time as MM:SS
        const minutes = Math.floor(gameTime / 60);
        const seconds = Math.floor(gameTime % 60);
        document.getElementById('finalTime').textContent = 
            `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        
        // Actualizar valores del formulario
        scoreInput.value = score;
        obstaclesInput.value = obstaclesAvoided;
        
        gameOverScreen.classList.remove('hidden');
        
        // Stop background music
        sounds.background.pause();
    }
    
    // Evento para validar el formulario antes de enviar
    scoreForm.addEventListener('submit', function(e) {
        if (!playerNameInput.value.trim()) {
            e.preventDefault();
            alert('Por favor, ingresa tu nombre');
            return false;
        }
        return true;
    });
    
    // Función para crear partículas
    function createParticles(x, y, color, count = 10, speed = 8) {
        for (let i = 0; i < count; i++) {
            particles.push({
                x: x,
                y: y,
                vx: (Math.random() - 0.5) * speed,
                vy: (Math.random() - 0.5) * speed,
                radius: Math.random() * 3 + 1,
                color: color,
                alpha: 1
            });
        }
    }
    
    // Función para crear obstáculos
    function createObstacle() {
        const type = obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
        return {
            x: Math.random() * (canvas.width - type.width),
            y: -type.height,
            width: type.width,
            height: type.height,
            color: type.color,
            points: type.points,
            type: type.type,
            health: type.health,
            speed: type.speed * GAME_SETTINGS.obstacleSpeed * (1 + (level - 1) * 0.1),
            shootsBack: type.shootsBack || false,
            shootTimer: Math.random() * 100 + 50
        };
    }
    
    // Function to create power-ups
    function createPowerUp() {
        const type = powerUpTypes[Math.floor(Math.random() * powerUpTypes.length)];
        return {
            x: Math.random() * (canvas.width - 30),
            y: -30,
            width: 30,
            height: 30,
            color: type.color,
            type: type.type,
            effect: type.effect,
            speed: 2,
            rotation: 0
        };
    }
    
    // Check if it's time to level up
    function checkLevelUp() {
        if (gameTime >= GAME_SETTINGS.levelUpTime * level) {
            level++;
            playSound('levelUp');
            
            // Create level up notification
            createFloatingText(`¡Nivel ${level}!`, canvas.width / 2, canvas.height / 2, '#FFC107', 36);
            
            // Increase difficulty with level
            GAME_SETTINGS.spawnRate += 0.002;
            GAME_SETTINGS.obstacleSpeed += 0.2;
            
            // Update level display in the HUD
            document.getElementById('levelDisplay').textContent = level;
        }
    }
    
    // Floating text for notifications
    let floatingTexts = [];
    
    function createFloatingText(text, x, y, color, size, duration = 60) {
        floatingTexts.push({ text, x, y, color, size, alpha: 1, duration, timer: 0 });
    }
    
    // Función para dibujar el cohete
    function drawRocket() {
        ctx.save();
        ctx.translate(rocket.x, rocket.y);
        ctx.rotate(rocket.rotation);
        
        // Draw invincibility shield if active
        if (isInvincible) {
            ctx.globalAlpha = 0.5 + Math.sin(Date.now() * 0.01) * 0.2;
            ctx.strokeStyle = '#4CAF50';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.arc(0, 0, rocket.width * 0.8, 0, Math.PI * 2);
            ctx.stroke();
            ctx.globalAlpha = 1;
        }
        
        // Cuerpo del cohete
        ctx.fillStyle = '#7705B6';
        ctx.beginPath();
        ctx.moveTo(0, -rocket.height/2);
        ctx.lineTo(-rocket.width/2, rocket.height/2);
        ctx.lineTo(rocket.width/2, rocket.height/2);
        ctx.closePath();
        ctx.fill();
        
        // Ventana
        ctx.fillStyle = '#4A90E2';
        ctx.beginPath();
        ctx.arc(0, 0, rocket.width/4, 0, Math.PI * 2);
        ctx.fill();
        
        // Llamas (enhanced with animation)
        if (rocket.boosting) {
            rocket.thrusterAnimation = (rocket.thrusterAnimation + 0.2) % 1;
        } else {
            rocket.thrusterAnimation = 0;
        }
        
        const flameHeight = 30 + Math.sin(Date.now() * 0.01) * 10;
        const gradient = ctx.createLinearGradient(0, rocket.height/2, 0, rocket.height/2 + flameHeight);
        gradient.addColorStop(0, '#FF6B6B');
        gradient.addColorStop(0.5, '#FFC107');
        gradient.addColorStop(1, 'rgba(255, 107, 107, 0)');
        ctx.fillStyle = gradient;
        
        ctx.beginPath();
        ctx.moveTo(-rocket.width/2, rocket.height/2);
        ctx.quadraticCurveTo(0, rocket.height/2 + flameHeight * (1 + rocket.thrusterAnimation * 0.5), 
                           rocket.width/2, rocket.height/2);
        ctx.closePath();
        ctx.fill();
        
        ctx.restore();
    }
    
    // Draw lives indicator
    function drawLives() {
        ctx.fillStyle = '#F44336';
        for(let i = 0; i < lives; i++) {
            ctx.beginPath();
            ctx.moveTo(20 + i * 20, 20);
            ctx.lineTo(10 + i * 20, 30);
            ctx.lineTo(20 + i * 20, 40);
            ctx.lineTo(30 + i * 20, 30);
            ctx.closePath();
            ctx.fill();
        }
        
        // Also update the lives in the HUD container
        updateLivesDisplay();
    }
    
    // Update the lives display in the UI
    function updateLivesDisplay() {
        const livesContainer = document.getElementById('livesContainer');
        livesContainer.innerHTML = '';
        
        for(let i = 0; i < lives; i++) {
            const heart = document.createElement('div');
            heart.className = 'text-red-500 mx-1';
            heart.innerHTML = '❤️';
            heart.style.fontSize = '24px';
            livesContainer.appendChild(heart);
        }
    }
    
    // Función para dibujar obstáculos
    function drawObstacles() {
        obstacles.forEach(obstacle => {
            ctx.save();
            ctx.translate(obstacle.x + obstacle.width/2, obstacle.y + obstacle.height/2);
            
            if (obstacle.type === 'asteroid') {
                // Draw asteroid with some texture
                const gradient = ctx.createRadialGradient(0, 0, 0, 0, 0, obstacle.width/2);
                gradient.addColorStop(0, lightenColor(obstacle.color, 20));
                gradient.addColorStop(1, obstacle.color);
                
                ctx.fillStyle = gradient;
                ctx.beginPath();
                
                // Create irregular shape for asteroid
                const segments = 8;
                const variation = obstacle.width * 0.2;
                
                for (let i = 0; i < segments; i++) {
                    const angle = (i / segments) * Math.PI * 2;
                    const radius = obstacle.width/2 + (Math.sin(angle * 3) * variation);
                    const x = Math.cos(angle) * radius;
                    const y = Math.sin(angle) * radius;
                    
                    if (i === 0) {
                        ctx.moveTo(x, y);
                    } else {
                        ctx.lineTo(x, y);
                    }
                }
                
                ctx.closePath();
                ctx.fill();
                
                // Add some crater details
                ctx.fillStyle = darkenColor(obstacle.color, 20);
                for (let i = 0; i < 3; i++) {
                    const craterX = (Math.random() - 0.5) * obstacle.width * 0.6;
                    const craterY = (Math.random() - 0.5) * obstacle.height * 0.6;
                    const craterSize = Math.random() * obstacle.width * 0.2 + obstacle.width * 0.05;
                    
                    ctx.beginPath();
                    ctx.arc(craterX, craterY, craterSize, 0, Math.PI * 2);
                    ctx.fill();
                }
            } else if (obstacle.type === 'enemy') {
                // Draw enemy ship
            ctx.fillStyle = obstacle.color;
                
                // Ship body
                ctx.beginPath();
                ctx.moveTo(0, -obstacle.height/2);
                ctx.lineTo(-obstacle.width/2, obstacle.height/2);
                ctx.lineTo(obstacle.width/2, obstacle.height/2);
                ctx.closePath();
                ctx.fill();
                
                // Window
                ctx.fillStyle = '#FFEB3B';
                ctx.beginPath();
                ctx.arc(0, 0, obstacle.width/5, 0, Math.PI * 2);
                ctx.fill();
                
                // Wings
                ctx.fillStyle = darkenColor(obstacle.color, 20);
                ctx.beginPath();
                ctx.moveTo(-obstacle.width/2, obstacle.height/4);
                ctx.lineTo(-obstacle.width * 0.8, obstacle.height/2);
                ctx.lineTo(-obstacle.width/2, obstacle.height/2);
                ctx.closePath();
                ctx.fill();
                
                ctx.beginPath();
                ctx.moveTo(obstacle.width/2, obstacle.height/4);
                ctx.lineTo(obstacle.width * 0.8, obstacle.height/2);
                ctx.lineTo(obstacle.width/2, obstacle.height/2);
                ctx.closePath();
                ctx.fill();
            }
            
            ctx.restore();
        });
    }
    
    // Draw power-ups
    function drawPowerUps() {
        powerUps.forEach(powerUp => {
            ctx.save();
            ctx.translate(powerUp.x + powerUp.width/2, powerUp.y + powerUp.height/2);
            
            // Rotate the power-up
            powerUp.rotation = (powerUp.rotation + 0.02) % (Math.PI * 2);
            ctx.rotate(powerUp.rotation);
            
            // Draw power-up based on type
            ctx.fillStyle = powerUp.color;
            
            // Draw a gem-like shape
            ctx.beginPath();
            ctx.moveTo(0, -powerUp.height/2);
            ctx.lineTo(-powerUp.width/2, 0);
            ctx.lineTo(0, powerUp.height/2);
            ctx.lineTo(powerUp.width/2, 0);
            ctx.closePath();
            ctx.fill();
            
            // Add a glowing effect
            ctx.shadowColor = powerUp.color;
            ctx.shadowBlur = 10;
            ctx.strokeStyle = '#FFFFFF';
            ctx.lineWidth = 2;
            ctx.stroke();
            ctx.shadowBlur = 0;
            
            // Draw an icon based on power-up type
            ctx.fillStyle = '#FFFFFF';
            if (powerUp.type === 'shield') {
                ctx.beginPath();
                ctx.arc(0, 0, powerUp.width/4, 0, Math.PI * 2);
                ctx.fill();
            } else if (powerUp.type === 'extraLife') {
                ctx.beginPath();
                ctx.arc(0, 0, powerUp.width/4, 0, Math.PI * 2);
                ctx.fill();
                ctx.fillStyle = powerUp.color;
                ctx.beginPath();
                ctx.arc(0, 0, powerUp.width/8, 0, Math.PI * 2);
                ctx.fill();
            } else if (powerUp.type === 'speedBoost') {
                // Draw lightning bolt
                ctx.beginPath();
                ctx.moveTo(-powerUp.width/8, -powerUp.height/6);
                ctx.lineTo(0, 0);
                ctx.lineTo(-powerUp.width/8, powerUp.height/6);
                ctx.fill();
            } else if (powerUp.type === 'scoreMultiplier') {
                // Draw ×2 symbol
                ctx.font = 'bold ' + (powerUp.width/3) + 'px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('×2', 0, 0);
            }
            
            ctx.restore();
        });
    }
    
    // Draw projectiles
    function drawProjectiles() {
        // Player projectiles
        projectiles.forEach(projectile => {
            ctx.fillStyle = projectile.color;
            ctx.fillRect(projectile.x - projectile.width/2, projectile.y, projectile.width, projectile.height);
            
            // Add a glow effect
            ctx.shadowColor = projectile.color;
            ctx.shadowBlur = 5;
            ctx.fillRect(projectile.x - projectile.width/2, projectile.y, projectile.width, projectile.height);
            ctx.shadowBlur = 0;
        });
        
        // Enemy projectiles
        enemyProjectiles.forEach(projectile => {
            ctx.fillStyle = '#FF5722';
            ctx.fillRect(projectile.x - projectile.width/2, projectile.y, projectile.width, projectile.height);
            
            // Add a glow effect
            ctx.shadowColor = '#FF5722';
            ctx.shadowBlur = 5;
            ctx.fillRect(projectile.x - projectile.width/2, projectile.y, projectile.width, projectile.height);
            ctx.shadowBlur = 0;
        });
    }
    
    // Function to draw floating text
    function drawFloatingTexts() {
        floatingTexts.forEach(text => {
            ctx.globalAlpha = text.alpha;
            ctx.font = `bold ${text.size}px Arial`;
            ctx.fillStyle = text.color;
            ctx.textAlign = 'center';
            ctx.fillText(text.text, text.x, text.y);
            ctx.globalAlpha = 1;
        });
    }
    
    // Helper functions for colors
    function lightenColor(color, percent) {
        const num = parseInt(color.slice(1), 16);
        const amt = Math.round(2.55 * percent);
        const R = (num >> 16) + amt;
        const G = (num >> 8 & 0x00FF) + amt;
        const B = (num & 0x0000FF) + amt;
        
        return '#' + (
            0x1000000 + 
            (R < 255 ? (R < 0 ? 0 : R) : 255) * 0x10000 + 
            (G < 255 ? (G < 0 ? 0 : G) : 255) * 0x100 + 
            (B < 255 ? (B < 0 ? 0 : B) : 255)
        ).toString(16).slice(1);
    }
    
    function darkenColor(color, percent) {
        return lightenColor(color, -percent);
    }
    
    // Función para dibujar partículas
    function drawParticles() {
        particles.forEach(particle => {
            ctx.globalAlpha = particle.alpha;
            ctx.fillStyle = particle.color;
            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
            ctx.fill();
        });
        ctx.globalAlpha = 1;
    }
    
    // Función para actualizar el juego
    function update() {
        if (!gameStarted || gameOver || isPaused) return;
        
        // Update game time for level progression
        gameTime += 1/60; // Assuming 60 FPS
        
        // Check for level up
        checkLevelUp();
        
        // Update invincibility
        if (isInvincible) {
            invincibleTimer--;
            if (invincibleTimer <= 0) {
                isInvincible = false;
            }
        }
        
        // Movimiento del cohete
        if (keys['ArrowLeft']) {
            rocket.x -= rocket.speed;
            rocket.rotation = -0.1;
        } else if (keys['ArrowRight']) {
            rocket.x += rocket.speed;
            rocket.rotation = 0.1;
        } else {
            rocket.rotation = 0;
        }
        
        if (keys['ArrowUp']) {
            rocket.y -= rocket.speed;
            rocket.boosting = true;
            createParticles(rocket.x, rocket.y + rocket.height/2, '#FF6B6B', 2, 4);
        } else if (keys['ArrowDown']) {
            rocket.y += rocket.speed;
            rocket.boosting = false;
        } else {
            rocket.boosting = false;
        }
        
        // Límites del canvas
        rocket.x = Math.max(rocket.width/2, Math.min(canvas.width - rocket.width/2, rocket.x));
        rocket.y = Math.max(rocket.height/2, Math.min(canvas.height - rocket.height/2, rocket.y));
        
        // Actualizar partículas
        particles = particles.filter(particle => {
            particle.x += particle.vx;
            particle.y += particle.vy;
            particle.alpha -= 0.02;
            return particle.alpha > 0;
        });
        
        // Actualizar proyectiles del jugador
        projectiles = projectiles.filter(projectile => {
            projectile.y -= projectile.speed;
            
            // Colisiones con obstáculos
            let hitObstacle = false;
            
            obstacles.forEach((obstacle, index) => {
                if (projectile.x > obstacle.x && 
                    projectile.x < obstacle.x + obstacle.width &&
                    projectile.y > obstacle.y && 
                    projectile.y < obstacle.y + obstacle.height) {
                    
                    // Reduce enemy health
                    obstacle.health--;
                    
                    // Create explosion particles
                    createParticles(projectile.x, projectile.y, '#FFEB3B', 5, 6);
                    
                    // If obstacle is destroyed
                    if (obstacle.health <= 0) {
                        // Add points
                        score += obstacle.points;
                        scoreElement.textContent = score;
                        
                        // Create large explosion
                        createParticles(
                            obstacle.x + obstacle.width/2, 
                            obstacle.y + obstacle.height/2, 
                            obstacle.color, 
                            20, 
                            8
                        );
                        
                        // Remove obstacle
                        obstacles.splice(index, 1);
                        
                        // Update obstacles avoided
                        obstaclesAvoided++;
                        obstaclesAvoidedElement.textContent = obstaclesAvoided;
                        
                        // Create floating score text
                        createFloatingText(
                            '+' + obstacle.points, 
                            obstacle.x + obstacle.width/2, 
                            obstacle.y, 
                            '#FFC107', 
                            24
                        );
                        
                        // Play explosion sound
                        playSound('explosion');
                        
                        // Small chance to drop a power-up when destroying an enemy
                        if (Math.random() < 0.2) {
                            powerUps.push(Object.assign(
                                createPowerUp(), 
                                {
                                    x: obstacle.x + obstacle.width/2 - 15,
                                    y: obstacle.y + obstacle.height/2 - 15
                                }
                            ));
                        }
                    }
                    
                    hitObstacle = true;
                }
            });
            
            return projectile.y > 0 && !hitObstacle;
        });
        
        // Actualizar proyectiles enemigos
        enemyProjectiles = enemyProjectiles.filter(projectile => {
            projectile.y += projectile.speed;
            
            // Colisión con el jugador
            if (!isInvincible && 
                projectile.x > rocket.x - rocket.width/2 && 
                projectile.x < rocket.x + rocket.width/2 &&
                projectile.y > rocket.y - rocket.height/2 && 
                projectile.y < rocket.y + rocket.height/2) {
                
                // Player hit by enemy projectile
                lives--;
                
                // Create explosion particles
                createParticles(rocket.x, rocket.y, '#FF5722', 15, 8);
                
                // Check game over
                if (lives <= 0) {
                    gameOver = true;
                    createParticles(rocket.x, rocket.y, '#FF5722', 30, 10);
                    showGameOver();
                } else {
                    // Temporary invincibility
                    isInvincible = true;
                    invincibleTimer = GAME_SETTINGS.invincibilityTime * 60;
                }
                
                return false;
            }
            
            return projectile.y < canvas.height;
        });
        
        // Actualizar power-ups
        powerUps = powerUps.filter(powerUp => {
            powerUp.y += powerUp.speed;
            
            // Colisión con el jugador
            if (rocket.x + rocket.width/2 > powerUp.x &&
                rocket.x - rocket.width/2 < powerUp.x + powerUp.width &&
                rocket.y + rocket.height/2 > powerUp.y &&
                rocket.y - rocket.height/2 < powerUp.y + powerUp.height) {
                
                // Apply power-up effect
                powerUp.effect();
                
                // Create power-up collected particles
                createParticles(
                    powerUp.x + powerUp.width/2, 
                    powerUp.y + powerUp.height/2, 
                    powerUp.color, 
                    15, 
                    6
                );
                
                // Create notification
                let powerUpName = '';
                switch(powerUp.type) {
                    case 'shield': powerUpName = '¡Escudo activado!'; break;
                    case 'extraLife': powerUpName = '¡Vida extra!'; break;
                    case 'speedBoost': powerUpName = '¡Velocidad aumentada!'; break;
                    case 'scoreMultiplier': powerUpName = '¡Puntuación x2!'; break;
                }
                
                createFloatingText(
                    powerUpName, 
                    canvas.width / 2, 
                    canvas.height / 2, 
                    powerUp.color, 
                    24
                );
                
                // Play power-up sound
                playSound('powerup');
                
                return false;
            }
            
            return powerUp.y < canvas.height;
        });
        
        // Update floating texts
        floatingTexts = floatingTexts.filter(text => {
            text.y -= 1;
            text.timer++;
            
            if (text.timer > text.duration * 0.7) {
                text.alpha -= 0.05;
            }
            
            return text.alpha > 0;
        });
        
        // Generar obstáculos
        if (Math.random() < GAME_SETTINGS.spawnRate * (1 + (level - 1) * 0.1)) {
            obstacles.push(createObstacle());
        }
        
        // Generar power-ups
        if (Math.random() < GAME_SETTINGS.powerUpChance) {
            powerUps.push(createPowerUp());
        }
        
        // Actualizar obstáculos
        obstacles = obstacles.filter(obstacle => {
            obstacle.y += obstacle.speed;
            
            // Enemy ships can shoot
            if (obstacle.shootsBack && obstacle.type === 'enemy') {
                obstacle.shootTimer--;
                if (obstacle.shootTimer <= 0 && obstacle.y > 0 && obstacle.y < canvas.height - 100) {
                    // Reset timer
                    obstacle.shootTimer = Math.random() * 100 + 100;
                    
                    // Create enemy projectile
                    enemyProjectiles.push({
                        x: obstacle.x + obstacle.width/2,
                        y: obstacle.y + obstacle.height,
                        width: 4,
                        height: 12,
                        speed: 5
                    });
                }
            }
            
            // Detectar colisiones con el jugador
            if (!isInvincible && 
                rocket.x + rocket.width/2 > obstacle.x &&
                rocket.x - rocket.width/2 < obstacle.x + obstacle.width &&
                rocket.y + rocket.height/2 > obstacle.y &&
                rocket.y - rocket.height/2 < obstacle.y + obstacle.height) {
                
                // Create explosion particles
                createParticles(
                    (rocket.x + obstacle.x + obstacle.width/2) / 2, 
                    (rocket.y + obstacle.y + obstacle.height/2) / 2, 
                    obstacle.color, 
                    20, 
                    8
                );
                
                // Reducir vidas
                lives--;
                
                // Play explosion sound
                playSound('explosion');
                
                if (lives <= 0) {
                gameOver = true;
                    showGameOver();
                } else {
                    // Temporary invincibility
                    isInvincible = true;
                    invincibleTimer = GAME_SETTINGS.invincibilityTime * 60;
                }
                
                // Remove the obstacle that hit the player
                return false;
            }
            
            // Contar obstáculos esquivados si pasaron completamente la pantalla
            if (obstacle.y > canvas.height) {
                obstaclesAvoided++;
                score += obstacle.points;
                obstaclesAvoidedElement.textContent = obstaclesAvoided;
                scoreElement.textContent = score;
            }
            
            return obstacle.y < canvas.height;
        });
    }
    
    // Función para dibujar el juego
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Fondo espacial
        drawBackground();
        
        // Dibujar elementos del juego
        drawPowerUps();
        drawObstacles();
        drawProjectiles();
        drawRocket();
        drawParticles();
        drawFloatingTexts();
        
        // HUD (Heads-Up Display)
        drawHUD();
    }
    
    // Dibujar fondo con estrellas y nebulosas
    function drawBackground() {
        // Fondo degradado
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, '#0a0a30');
        gradient.addColorStop(0.3, '#191970');
        gradient.addColorStop(1, '#333399');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Estrellas con parpadeo
        const time = Date.now() * 0.001;
        ctx.fillStyle = '#FFFFFF';
        
        for (let i = 0; i < 150; i++) { // Aumentar cantidad de estrellas
            const x = (Math.sin(i * 5 + time * 0.5) * 0.5 + 0.5) * canvas.width;
            const y = (Math.cos(i * 7 + time * 0.3) * 0.5 + 0.5) * canvas.height;
            const size = 0.5 + Math.sin(time + i) * 0.5;
            
            ctx.globalAlpha = 0.5 + Math.sin(time * 2 + i) * 0.3;
            ctx.fillRect(x, y, size, size);
        }
        
        // Nebulosas de colores
        for (let i = 0; i < 4; i++) { // Aumentar cantidad de nebulosas
            const x = (Math.sin(time * 0.3 + i * 2) * 0.4 + 0.5) * canvas.width;
            const y = (Math.cos(time * 0.2 + i * 3) * 0.4 + 0.5) * canvas.height;
            
            const nebulaGradient = ctx.createRadialGradient(x, y, 0, x, y, 200); // Aumentar tamaño
            
            // Different colors for each nebula
            if (i === 0) {
                nebulaGradient.addColorStop(0, 'rgba(255, 0, 127, 0.2)');
                nebulaGradient.addColorStop(1, 'rgba(255, 0, 127, 0)');
            } else if (i === 1) {
                nebulaGradient.addColorStop(0, 'rgba(0, 255, 255, 0.1)');
                nebulaGradient.addColorStop(1, 'rgba(0, 255, 255, 0)');
            } else if (i === 2) {
                nebulaGradient.addColorStop(0, 'rgba(255, 255, 0, 0.1)');
                nebulaGradient.addColorStop(1, 'rgba(255, 255, 0, 0)');
            } else {
                nebulaGradient.addColorStop(0, 'rgba(148, 0, 211, 0.1)');
                nebulaGradient.addColorStop(1, 'rgba(148, 0, 211, 0)');
            }
            
            ctx.fillStyle = nebulaGradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }
        
        ctx.globalAlpha = 1;
    }
    
    // Draw HUD (Heads-Up Display)
    function drawHUD() {
        // Draw lives
        drawLives();
        
        // Draw level indicator
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 20px Arial';
        ctx.textAlign = 'right';
        ctx.fillText(`Nivel: ${level}`, canvas.width - 20, 30);
        
        // If paused, show pause screen
        if (isPaused) {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#FFFFFF';
            ctx.font = 'bold 36px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('PAUSA', canvas.width / 2, canvas.height / 2 - 20);
            
            ctx.font = '20px Arial';
            ctx.fillText('Presiona "P" para continuar', canvas.width / 2, canvas.height / 2 + 20);
        }
        
        // Controls/info text
        if (gameStarted && !gameOver && !isPaused) {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.font = '14px Arial';
            ctx.textAlign = 'left';
            ctx.fillText('P: Pausar | M: Sonido | Espacio: Disparar', 20, canvas.height - 20);
        }
    }
    
    // Bucle del juego
    function gameLoop() {
        if (!isPaused) {
        update();
        draw();
        requestAnimationFrame(gameLoop);
        }
    }
    
    // Función para reiniciar el juego
    function restartGame() {
        score = 0;
        obstaclesAvoided = 0;
        gameOver = false;
        obstacles = [];
        particles = [];
        projectiles = [];
        enemyProjectiles = [];
        powerUps = [];
        floatingTexts = [];
        lives = 3;
        level = 1;
        gameTime = 0;
        isInvincible = false;
        
        // Reset game settings
        GAME_SETTINGS.spawnRate = 0.02;
        GAME_SETTINGS.obstacleSpeed = 3;
        
        // Posicionar el cohete correctamente en el canvas redimensionado
        rocket.x = canvas.width / 2;
        rocket.y = canvas.height - 80;
        rocket.rotation = 0;
        rocket.boosting = false;
        
        // Update UI elements
        scoreElement.textContent = '0';
        obstaclesAvoidedElement.textContent = '0';
        document.getElementById('levelDisplay').textContent = '1';
        updateLivesDisplay();
        
        instructions.style.display = 'flex';
        gameOverScreen.classList.add('hidden');
        gameStarted = false;
        isPaused = false;
        
        // Restart background music if not muted
        if (!isMuted) {
            sounds.background.currentTime = 0;
            sounds.background.play().catch(e => console.log('Error playing background music:', e));
        }
    }
    
    // Event listeners para los botones
    startButton.addEventListener('click', () => {
        instructions.style.display = 'none';
        gameStarted = true;
        
        // Start background music if not muted
        if (!isMuted) {
            sounds.background.play().catch(e => console.log('Error playing background music:', e));
        }
    });
    
    restartButton.addEventListener('click', restartGame);
    restartFromOverBtn.addEventListener('click', restartGame);
    
    // Crear botón de silencio
    const muteButton = document.createElement('button');
    muteButton.textContent = '🔇';
    muteButton.className = 'absolute top-4 right-4 bg-white bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center text-white';
    canvas.parentNode.appendChild(muteButton);
    
    muteButton.addEventListener('click', () => {
        isMuted = !isMuted;
        muteButton.textContent = isMuted ? '🔇' : '🔊';
        
        if (isMuted) {
            sounds.background.pause();
        } else if (gameStarted && !gameOver) {
            sounds.background.play().catch(e => console.log('Error playing background music:', e));
        }
    });
    
    // Iniciar el juego
    gameLoop();
});
</script>
@endpush
@endsection 