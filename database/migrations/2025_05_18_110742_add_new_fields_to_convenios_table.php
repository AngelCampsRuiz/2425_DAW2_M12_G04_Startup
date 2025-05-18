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
        Schema::table('convenios', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('convenios', 'oferta_id')) {
                $table->foreignId('oferta_id')->nullable()->after('seguimiento_id')->constrained('publicaciones');
            }
            
            if (!Schema::hasColumn('convenios', 'estudiante_id')) {
                $table->foreignId('estudiante_id')->nullable()->after('oferta_id')->constrained('user');
            }
            
            if (!Schema::hasColumn('convenios', 'fecha_inicio')) {
                $table->date('fecha_inicio')->nullable()->after('estudiante_id');
            }
            
            if (!Schema::hasColumn('convenios', 'fecha_fin')) {
                $table->date('fecha_fin')->nullable()->after('fecha_inicio');
            }
            
            if (!Schema::hasColumn('convenios', 'horario_practica')) {
                $table->string('horario_practica')->nullable()->after('fecha_fin');
            }
            
            if (!Schema::hasColumn('convenios', 'tutor_empresa')) {
                $table->string('tutor_empresa')->nullable()->after('horario_practica');
            }
            
            if (!Schema::hasColumn('convenios', 'tareas')) {
                $table->text('tareas')->nullable()->after('tutor_empresa');
            }
            
            if (!Schema::hasColumn('convenios', 'objetivos')) {
                $table->text('objetivos')->nullable()->after('tareas');
            }
            
            if (!Schema::hasColumn('convenios', 'estado')) {
                $table->enum('estado', ['pendiente', 'activo', 'finalizado'])->default('pendiente')->after('objetivos');
            }
            
            if (!Schema::hasColumn('convenios', 'fecha_creacion')) {
                $table->timestamp('fecha_creacion')->nullable()->after('estado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't need to drop columns that might not exist
        // Just leaving this method empty to avoid errors when rolling back
    }
};
