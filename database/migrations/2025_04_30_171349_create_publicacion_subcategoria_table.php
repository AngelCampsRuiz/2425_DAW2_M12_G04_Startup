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
        Schema::create('publicacion_subcategoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publicacion_id');
            $table->unsignedBigInteger('subcategoria_id');
            $table->timestamps();

            // Foreign keys without cascading delete
            $table->foreign('publicacion_id')->references('id')->on('publicaciones');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');
            
            // Prevent duplicate entries
            $table->unique(['publicacion_id', 'subcategoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_subcategoria');
    }
};
