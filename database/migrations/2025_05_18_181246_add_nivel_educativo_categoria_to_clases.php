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
        Schema::table('clases', function (Blueprint $table) {
            // Añadir después de docente_id
            $table->foreignId('nivel_educativo_id')->nullable()->after('docente_id');
            $table->foreignId('categoria_id')->nullable()->after('nivel_educativo_id');
            
            // Añadir restricciones de clave foránea
            $table->foreign('nivel_educativo_id')->references('id')->on('niveles_educativos')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clases', function (Blueprint $table) {
            // Eliminar restricciones de clave foránea
            $table->dropForeign(['nivel_educativo_id']);
            $table->dropForeign(['categoria_id']);
            
            // Eliminar columnas
            $table->dropColumn('nivel_educativo_id');
            $table->dropColumn('categoria_id');
        });
    }
};
