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
        // No es necesario agregar la columna 'activo' a la tabla 'docentes'
        // ya que comprobamos que ya existe esa columna en la tabla
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir cambios ya que no se hizo ninguna modificación
    }
};
