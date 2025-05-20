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
        // Primero modificamos la tabla de chats existente para añadir un nuevo tipo
        Schema::table('chats', function (Blueprint $table) {
            // Modificar la columna 'tipo' para que acepte el nuevo valor 'docente_empresa'
            // Solo si la columna ya existe
            if (Schema::hasColumn('chats', 'tipo')) {
                // No podemos modificar un enum directamente, así que vamos a convertirlo a string
                $table->string('tipo', 20)->change();
            } else {
                // Si no existe, la creamos
                $table->string('tipo', 20)->default('empresa_estudiante');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si queremos revertir, podríamos restaurar el tipo enum original,
        // pero es mejor dejarlo como string para futuras expansiones
    }
}; 