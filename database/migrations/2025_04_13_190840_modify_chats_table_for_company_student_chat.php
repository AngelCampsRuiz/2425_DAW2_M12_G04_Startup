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
        Schema::table('chats', function (Blueprint $table) {
            // Verificar si las columnas existen antes de eliminarlas
            if (Schema::hasColumn('chats', 'alumno_id')) {
                $table->dropForeign(['alumno_id']);
                $table->dropColumn('alumno_id');
            }
            if (Schema::hasColumn('chats', 'tutor_id')) {
                $table->dropForeign(['tutor_id']);
                $table->dropColumn('tutor_id');
            }
            
            // Añadir la columna de solicitud_id si no existe
            if (!Schema::hasColumn('chats', 'solicitud_id')) {
                $table->foreignId('solicitud_id')->nullable()->constrained('solicitudes')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            // Eliminar la columna de solicitud_id si existe
            if (Schema::hasColumn('chats', 'solicitud_id')) {
                $table->dropForeign(['solicitud_id']);
                $table->dropColumn('solicitud_id');
            }
            
            // Restaurar las columnas originales si no existen
            if (!Schema::hasColumn('chats', 'alumno_id')) {
                $table->foreignId('alumno_id')->nullable()->constrained('estudiantes');
            }
            if (!Schema::hasColumn('chats', 'tutor_id')) {
                $table->foreignId('tutor_id')->nullable()->constrained('tutores');
            }
        });
    }
};
