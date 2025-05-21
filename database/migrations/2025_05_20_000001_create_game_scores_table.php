<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('game_name');
            $table->integer('score');
            $table->string('difficulty')->default('medium');
            $table->integer('time_spent')->comment('Tiempo en segundos');
            $table->boolean('completed')->default(false);
            $table->timestamps();
            
            // Índices para optimizar las búsquedas
            $table->index(['user_id', 'game_name']);
            $table->index('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_scores');
    }
}; 