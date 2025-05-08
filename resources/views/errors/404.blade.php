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
        
        if (gameOver) {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            ctx.fillStyle = '#FFFFFF';
            ctx.font = 'bold 48px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('¡Game Over!', canvas.width/2, canvas.height/2 - 40);
            ctx.font = '24px Arial';
            ctx.fillText(`Puntuación: ${score}`, canvas.width/2, canvas.height/2 + 20);
            ctx.fillText(`Obstáculos esquivados: ${obstaclesAvoided}`, canvas.width/2, canvas.height/2 + 60);
        }
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
        gameStarted = false;
    }
    
    // Event listeners para los botones
    startButton.addEventListener('click', () => {
        instructions.style.display = 'none';
        gameStarted = true;
    });
    
    restartButton.addEventListener('click', restartGame);
    
    // Iniciar el juego
    gameLoop();
});
</script>
@endpush
@endsection 