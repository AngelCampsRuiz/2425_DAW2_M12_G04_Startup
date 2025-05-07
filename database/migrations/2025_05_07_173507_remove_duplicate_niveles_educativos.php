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
        // Primero obtenemos todos los niveles educativos agrupados por nombre
        $niveles = DB::table('niveles_educativos')
            ->select('nombre_nivel', DB::raw('MIN(id) as id_to_keep'), DB::raw('COUNT(*) as count'))
            ->groupBy('nombre_nivel')
            ->having('count', '>', 1)
            ->get();
        
        // Para cada nivel duplicado, mantenemos el de ID más bajo y eliminamos los otros
        foreach ($niveles as $nivel) {
            // Obtenemos todos los IDs de este nivel excepto el que queremos mantener
            $duplicateIds = DB::table('niveles_educativos')
                ->where('nombre_nivel', $nivel->nombre_nivel)
                ->where('id', '!=', $nivel->id_to_keep)
                ->pluck('id');
            
            // Actualizar referencias en tabla institucion_nivel_educativo
            foreach ($duplicateIds as $duplicateId) {
                DB::table('institucion_nivel_educativo')
                    ->where('nivel_educativo_id', $duplicateId)
                    ->update(['nivel_educativo_id' => $nivel->id_to_keep]);
                
                // Actualizar referencias en tabla institucion_categoria
                DB::table('institucion_categoria')
                    ->where('nivel_educativo_id', $duplicateId)
                    ->update(['nivel_educativo_id' => $nivel->id_to_keep]);
                
                // Actualizar referencias en tabla categorias
                DB::table('categorias')
                    ->where('nivel_educativo_id', $duplicateId)
                    ->update(['nivel_educativo_id' => $nivel->id_to_keep]);
            }
            
            // Eliminamos los niveles duplicados
            DB::table('niveles_educativos')
                ->whereIn('id', $duplicateIds)
                ->delete();
        }
        
        // Añadir índice único en nombre_nivel para prevenir futuros duplicados
        Schema::table('niveles_educativos', function (Blueprint $table) {
            $table->unique('nombre_nivel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('niveles_educativos', function (Blueprint $table) {
            $table->dropUnique(['nombre_nivel']);
        });
    }
};
