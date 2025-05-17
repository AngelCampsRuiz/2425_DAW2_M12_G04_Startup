@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary/20 to-secondary/20 flex flex-col">
    <!-- Contenido principal -->
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="text-center px-4 relative max-w-4xl w-full">
            
            <!-- Frase divertida -->
            <div class="mb-8">
                <p class="text-2xl font-bold text-primary mb-2">¡Ups! Parece que te has perdido en el espacio</p>
                <p class="text-lg text-gray-600">"No te preocupes, hasta los astronautas se pierden a veces... ¡pero siempre encuentran su camino de vuelta!"</p>
            </div>
            
            <!-- Canvas para el juego -->
            <div class="relative">
                <canvas id="gameCanvas" class="border-4 border-primary/30 rounded-xl shadow-2xl" width="800" height="400"></canvas>
                
                <!-- Overlay de instrucciones -->
                <div id="instructions" class="absolute inset-0 bg-primary/90 text-white flex flex-col items-center justify-center rounded-xl">
                    <h2 class="text-3xl font-bold mb-4">¡Ayuda al cohete a escapar!</h2>
                    <p class="text-xl mb-6">Usa las flechas del teclado para moverte</p>
                    <button id="startButton" class="px-8 py-3 bg-white text-primary font-bold rounded-full hover:bg-primary/10 transition-all transform hover:scale-105">
                        ¡Comenzar!
                    </button>
                </div>
                
                <!-- Overlay de Game Over con formulario -->
                <div id="gameOverScreen" class="hidden absolute inset-0 bg-primary/90 text-white flex flex-col items-center justify-center rounded-xl">
                    <h2 class="text-3xl font-bold mb-2">¡Game Over!</h2>
                    <p class="text-xl mb-4">Puntuación: <span id="finalScore">0</span></p>
                    <p class="text-xl mb-6">Obstáculos esquivados: <span id="finalObstacles">0</span></p>
                    
                    <!-- Formulario para guardar puntuación -->
                    <form id="scoreForm" action="{{ url('/save-score') }}" method="GET" class="w-3/4 mb-6">
                        <input type="hidden" id="scoreInput" name="score" value="0">
                        <input type="hidden" id="obstaclesInput" name="obstacles_avoided" value="0">
                        <div class="mb-4">
                            <input type="text" id="playerName" name="player_name" placeholder="Tu nombre" 
                                class="w-full px-4 py-2 bg-white text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-secondary">
                        </div>
                        <button type="submit" id="saveScoreBtn" class="px-6 py-2 bg-secondary text-white font-bold rounded-full hover:bg-secondary-dark transition-all transform hover:scale-105">
                            Guardar puntuación
                        </button>
                    </form>
                    
                    <button id="restartFromOverBtn" class="px-6 py-2 bg-white text-primary font-bold rounded-full hover:bg-primary/10 transition-all transform hover:scale-105">
                        Jugar de nuevo
                    </button>
                </div>
            </div>
            
            <!-- Controles del juego -->
            <div class="mt-6 text-primary">
                <p class="text-2xl font-bold mb-2">Puntuación: <span id="score" class="text-secondary">0</span></p>
                <p class="text-lg">Obstáculos esquivados: <span id="obstaclesAvoided" class="text-secondary">0</span></p>
            </div>

            <!-- Botones de control -->
            <div class="mt-8 flex justify-center gap-4">
                <button id="restartButton" class="px-6 py-3 bg-primary text-white rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 shadow-lg">
                    Reiniciar Juego
                </button>
                <a href="/" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Volver a casa
                </a>
            </div>
            
            <!-- Tabla de clasificación -->
            <div class="mt-10 py-6 px-8 bg-white/60 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold text-primary mb-6">Ranking de Jugadores</h2>
                <div class="overflow-hidden">
                    <table id="rankingTable" class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold">#</th>
                                <th class="py-3 px-4 text-left font-semibold">Jugador</th>
                                <th class="py-3 px-4 text-right font-semibold">Puntuación</th>
                                <th class="py-3 px-4 text-right font-semibold">Obstáculos</th>
                            </tr>
                        </thead>
                        <tbody id="rankingBody">
                            @if(isset($topScores) && count($topScores) > 0)
                                @foreach($topScores as $index => $score)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                        <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->player_name }}</td>
                                        <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->score }}</td>
                                        <td class="py-3 px-4 text-right {{ $index < 3 ? ($index == 0 ? 'font-bold text-yellow-500' : ($index == 1 ? 'font-bold text-gray-500' : 'font-bold text-amber-700')) : '' }}">{{ $score->obstacles_avoided }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-4 px-4 text-center">Aún no hay puntuaciones. ¡Sé el primero en jugar!</td>
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
    
    let score = 0;
    let obstaclesAvoided = 0;
    let gameOver = false;
    let gameStarted = false;
    
    // Cohete
    const rocket = {
        x: canvas.width / 2,
        y: canvas.height - 50,
        width: 40,
        height: 60,
        speed: 6,
        rotation: 0
    };
    
    // Obstáculos
    let obstacles = [];
    const obstacleTypes = [
        { width: 60, height: 20, color: '#7705B6', points: 1 },
        { width: 40, height: 40, color: '#4A90E2', points: 2 },
        { width: 80, height: 15, color: '#5E0490', points: 3 }
    ];
    
    // Partículas
    let particles = [];
    
    // Control de teclas
    const keys = {};
    
    // Event listeners
    window.addEventListener('keydown', (e) => {
        keys[e.key] = true;
    });
    
    window.addEventListener('keyup', (e) => {
        keys[e.key] = false;
    });
    
    // Actualizar valores del formulario cuando se muestra la pantalla de Game Over
    function showGameOver() {
        finalScore.textContent = score;
        finalObstacles.textContent = obstaclesAvoided;
        
        // Actualizar valores del formulario
        scoreInput.value = score;
        obstaclesInput.value = obstaclesAvoided;
        
        gameOverScreen.classList.remove('hidden');
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
    function createParticles(x, y, color) {
        for (let i = 0; i < 10; i++) {
            particles.push({
                x: x,
                y: y,
                vx: (Math.random() - 0.5) * 8,
                vy: (Math.random() - 0.5) * 8,
                radius: Math.random() * 3,
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
            points: type.points
        };
    }
    
    // Función para dibujar el cohete
    function drawRocket() {
        ctx.save();
        ctx.translate(rocket.x, rocket.y);
        ctx.rotate(rocket.rotation);
        
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
        
        // Llamas
        const gradient = ctx.createLinearGradient(0, rocket.height/2, 0, rocket.height/2 + 30);
        gradient.addColorStop(0, '#FF6B6B');
        gradient.addColorStop(1, 'rgba(255, 107, 107, 0)');
        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.moveTo(-rocket.width/2, rocket.height/2);
        ctx.lineTo(0, rocket.height/2 + 30);
        ctx.lineTo(rocket.width/2, rocket.height/2);
        ctx.closePath();
        ctx.fill();
        
        ctx.restore();
    }
    
    // Función para dibujar obstáculos
    function drawObstacles() {
        obstacles.forEach(obstacle => {
            ctx.fillStyle = obstacle.color;
            ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
        });
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
        if (!gameStarted || gameOver) return;
        
        // Movimiento del cohete
        if (keys['ArrowLeft']) {
            rocket.x -= rocket.speed;
            rocket.rotation = -0.1;
        }
        if (keys['ArrowRight']) {
            rocket.x += rocket.speed;
            rocket.rotation = 0.1;
        }
        if (keys['ArrowUp']) {
            rocket.y -= rocket.speed;
            createParticles(rocket.x, rocket.y + rocket.height/2, '#FF6B6B');
        }
        if (keys['ArrowDown']) {
            rocket.y += rocket.speed;
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
        
        // Actualizar obstáculos
        if (Math.random() < 0.02) {
            obstacles.push(createObstacle());
        }
        
        obstacles = obstacles.filter(obstacle => {
            obstacle.y += 3;
            
            // Detectar colisiones
            if (rocket.x + rocket.width/2 > obstacle.x &&
                rocket.x - rocket.width/2 < obstacle.x + obstacle.width &&
                rocket.y < obstacle.y + obstacle.height &&
                rocket.y + rocket.height > obstacle.y) {
                gameOver = true;
                createParticles(rocket.x, rocket.y, '#7705B6');
                showGameOver();
            }
            
            // Contar obstáculos esquivados
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
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, '#7705B6');
        gradient.addColorStop(1, '#4A90E2');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Estrellas
        ctx.fillStyle = '#FFFFFF';
        for (let i = 0; i < 100; i++) {
            const x = Math.random() * canvas.width;
            const y = Math.random() * canvas.height;
            const size = Math.random() * 2;
            ctx.fillRect(x, y, size, size);
        }
        
        drawRocket();
        drawObstacles();
        drawParticles();
    }
    
    // Bucle del juego
    function gameLoop() {
        update();
        draw();
        requestAnimationFrame(gameLoop);
    }
    
    // Función para reiniciar el juego
    function restartGame() {
        score = 0;
        obstaclesAvoided = 0;
        gameOver = false;
        obstacles = [];
        particles = [];
        rocket.x = canvas.width / 2;
        rocket.y = canvas.height - 50;
        rocket.rotation = 0;
        scoreElement.textContent = '0';
        obstaclesAvoidedElement.textContent = '0';
        instructions.style.display = 'flex';
        gameOverScreen.classList.add('hidden');
        gameStarted = false;
    }
    
    // Event listeners para los botones
    startButton.addEventListener('click', () => {
        instructions.style.display = 'none';
        gameStarted = true;
    });
    
    restartButton.addEventListener('click', restartGame);
    restartFromOverBtn.addEventListener('click', restartGame);
    
    // Iniciar el juego
    gameLoop();
});
</script>
@endpush
@endsection 