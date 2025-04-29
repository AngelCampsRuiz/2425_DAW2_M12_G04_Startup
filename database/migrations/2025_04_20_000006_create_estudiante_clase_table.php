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
        if (!Schema::hasTable('estudiante_clase')) {
            Schema::create('estudiante_clase', function (Blueprint $table) {
                $table->id();
                $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
                $table->foreignId('clase_id')->constrained('clases')->onDelete('cascade');
                $table->timestamp('fecha_asignacion')->useCurrent();
                $table->timestamp('fecha_finalizacion')->nullable();
                $table->enum('estado', ['activo', 'finalizado', 'suspendido', 'cancelado'])->default('activo');
                $table->decimal('calificacion', 3, 1)->nullable();
                $table->text('comentarios')->nullable();
                $table->timestamps();
                
                // Índices para optimizar las búsquedas
                $table->index(['estudiante_id', 'clase_id']);
                $table->index('estado');
                
                // Restricción para evitar duplicados
                $table->unique(['estudiante_id', 'clase_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_clase');
    }
};
