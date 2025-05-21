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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('set null');
            $table->string('type'); // 'create', 'update', 'delete'
            $table->string('action');
            $table->string('subject_type'); // Modelo afectado (Empresa, Estudiante, etc.)
            $table->unsignedBigInteger('subject_id')->nullable(); // ID del registro afectado
            $table->string('description');
            $table->json('data')->nullable(); // Datos adicionales en formato JSON
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas frecuentes
            $table->index(['type']);
            $table->index(['subject_type', 'subject_id']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
}; 