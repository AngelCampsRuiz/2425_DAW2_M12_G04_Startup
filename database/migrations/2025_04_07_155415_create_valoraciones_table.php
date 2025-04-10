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
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('puntuacion');
            $table->text('comentario');
            $table->timestamp('fecha_valoracion');
            $table->enum('tipo', ['alumno_a_empresa', 'empresa_a_alumno']);
            $table->foreignId('emisor_id')->constrained('user');
            $table->foreignId('receptor_id')->constrained('user');
            $table->foreignId('convenio_id')->constrained('convenios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoraciones');
    }
};
