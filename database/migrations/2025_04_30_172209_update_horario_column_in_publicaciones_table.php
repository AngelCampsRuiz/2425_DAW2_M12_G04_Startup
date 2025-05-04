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
        // Primero modificamos la columna para permitir el nuevo valor
        DB::statement("ALTER TABLE publicaciones MODIFY horario ENUM('mañana', 'tarde', 'flexible') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertimos a la configuración original
        DB::statement("ALTER TABLE publicaciones MODIFY horario ENUM('mañana', 'tarde') NOT NULL");
    }
};
