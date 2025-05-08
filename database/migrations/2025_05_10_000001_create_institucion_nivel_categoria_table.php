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
        // Tabla pivote para relacionar instituciones con niveles educativos
        Schema::create('institucion_nivel_educativo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->foreignId('nivel_educativo_id')->constrained('niveles_educativos')->onDelete('cascade');
            $table->timestamps();
            
            // Índice único para evitar duplicados con un nombre más corto
            $table->unique(['institucion_id', 'nivel_educativo_id'], 'inst_nivel_edu_unique');
        });

        // Tabla pivote para relacionar instituciones con categorías (ciclos/cursos)
        Schema::create('institucion_categoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('nivel_educativo_id')->nullable()->constrained('niveles_educativos')->onDelete('set null');
            $table->string('nombre_personalizado')->nullable(); // Para permitir que la institución personalice el nombre
            $table->text('descripcion')->nullable(); // Descripción del ciclo/curso en esta institución
            $table->boolean('activo')->default(true); // Si el curso está actualmente activo
            $table->timestamps();
            
            // Índice único con un nombre más corto
            $table->unique(['institucion_id', 'categoria_id', 'nivel_educativo_id'], 'inst_cat_nivel_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucion_categoria');
        Schema::dropIfExists('institucion_nivel_educativo');
    }
}; 