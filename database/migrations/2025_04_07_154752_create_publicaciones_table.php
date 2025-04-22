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
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('descripcion');
            $table->enum('horario', ['mañana', 'tarde']);
            $table->integer('horas_totales')->default(300);
            $table->boolean('activa')->default(true);
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('subcategoria_id');
            $table->timestamp('fecha_publicacion')->nullable();
            $table->timestamps();

            // Añadir índice único compuesto para prevenir duplicados
            // Esto evita que una empresa cree ofertas con el mismo título en 24 horas
            // El límite de caracteres es necesario porque MySQL limita tamaño de índices
            $table->unique(['empresa_id', 'titulo'], 'uq_emp_titulo_publicacion');
            
            $table->foreign('empresa_id')
                  ->references('id')
                  ->on('empresas')
                  ->onDelete('cascade');

            $table->foreign('categoria_id')
                  ->references('id')
                  ->on('categorias')
                  ->onDelete('restrict');

            $table->foreign('subcategoria_id')
                  ->references('id')
                  ->on('subcategorias')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};
