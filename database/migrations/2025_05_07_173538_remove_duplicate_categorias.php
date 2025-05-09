<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero obtenemos todas las categorías duplicadas agrupadas por nombre y nivel educativo
        $categorias = DB::table('categorias')
            ->select('nombre_categoria', 'nivel_educativo_id', DB::raw('MIN(id) as id_to_keep'), DB::raw('COUNT(*) as count'))
            ->groupBy('nombre_categoria', 'nivel_educativo_id')
            ->having('count', '>', 1)
            ->get();
        
        // Para cada categoría duplicada, mantenemos la de ID más bajo y eliminamos las otras
        foreach ($categorias as $categoria) {
            // Obtenemos todos los IDs de esta categoría excepto el que queremos mantener
            $duplicateIds = DB::table('categorias')
                ->where('nombre_categoria', $categoria->nombre_categoria)
                ->where('nivel_educativo_id', $categoria->nivel_educativo_id)
                ->where('id', '!=', $categoria->id_to_keep)
                ->pluck('id');
            
            // Actualizar referencias en tabla institucion_categoria
            foreach ($duplicateIds as $duplicateId) {
                DB::table('institucion_categoria')
                    ->where('categoria_id', $duplicateId)
                    ->update(['categoria_id' => $categoria->id_to_keep]);
                
                // Actualizar referencias en publicaciones
                DB::table('publicaciones')
                    ->where('categoria_id', $duplicateId)
                    ->update(['categoria_id' => $categoria->id_to_keep]);
                
                // Actualizar referencias en subcategorías
                DB::table('subcategorias')
                    ->where('categoria_id', $duplicateId)
                    ->update(['categoria_id' => $categoria->id_to_keep]);
                
                // Actualizar otras referencias si las hay
            }
            
            // Eliminamos las categorías duplicadas
            DB::table('categorias')
                ->whereIn('id', $duplicateIds)
                ->delete();
        }
        
        // Añadir índice único compuesto para prevenir futuros duplicados
        Schema::table('categorias', function (Blueprint $table) {
            $table->unique(['nombre_categoria', 'nivel_educativo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropUnique(['nombre_categoria', 'nivel_educativo_id']);
        });
    }
};
