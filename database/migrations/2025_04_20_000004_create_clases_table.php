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
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('docente_id')->nullable()->constrained('docentes')->onDelete('set null');
            $table->string('nombre');
            $table->string('codigo');
            $table->string('nivel'); // ESO, Bachillerato, FP, etc.
            $table->string('curso'); // 1º, 2º, etc.
            $table->string('grupo')->nullable(); // A, B, C, etc.
            $table->text('descripcion')->nullable();
            $table->integer('capacidad')->nullable();
            $table->string('horario')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
