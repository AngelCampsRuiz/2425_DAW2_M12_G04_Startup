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
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->foreignId('institucion_id')->nullable()->constrained('instituciones')->onDelete('set null');
            $table->foreignId('docente_id')->nullable()->constrained('docentes')->onDelete('set null');
            $table->string('curso')->nullable(); // Ejemplo: "2º DAW", "4º ESO", etc.
            $table->string('grupo')->nullable(); // Ejemplo: "A", "B", etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['institucion_id']);
            $table->dropForeign(['docente_id']);
            $table->dropColumn(['institucion_id', 'docente_id', 'curso', 'grupo']);
        });
    }
}; 