<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->text('mensaje')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['estudiante_id', 'publicacion_id']);
            $table->index('estado');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}; 