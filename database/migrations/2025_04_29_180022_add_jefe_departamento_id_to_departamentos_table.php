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
        Schema::table('departamentos', function (Blueprint $table) {
            // Añadir columna jefe_departamento_id
            $table->foreignId('jefe_departamento_id')->nullable()->after('descripcion')
                ->constrained('docentes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departamentos', function (Blueprint $table) {
            // Eliminar la columna y la restricción de clave foránea
            $table->dropForeign(['jefe_departamento_id']);
            $table->dropColumn('jefe_departamento_id');
        });
    }
};
