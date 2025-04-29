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
        Schema::table('users', function (Blueprint $table) {
            // Añadir columnas para latitud y longitud
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            
            // Si no existe ya la columna direccion, añadirla también
            if (!Schema::hasColumn('users', 'direccion')) {
                $table->string('direccion')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lat', 'lng']);
            
            // Solo eliminar direccion si se añadió en esta migración
            if (Schema::hasColumn('users', 'direccion')) {
                $table->dropColumn('direccion');
            }
        });
    }
};
