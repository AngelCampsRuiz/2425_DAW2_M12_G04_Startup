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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('documento_pdf', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->foreignId('tutor_id')->nullable()->constrained('tutores');
            $table->foreignId('seguimiento_id')->nullable()->constrained('seguimiento');
            $table->foreignId('oferta_id')->constrained('publicaciones');
            $table->foreignId('estudiante_id')->constrained('user');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('horario_practica');
            $table->string('tutor_empresa');
            $table->text('tareas');
            $table->text('objetivos');
            $table->enum('estado', ['pendiente', 'activo', 'finalizado'])->default('pendiente');
            $table->timestamp('fecha_creacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
