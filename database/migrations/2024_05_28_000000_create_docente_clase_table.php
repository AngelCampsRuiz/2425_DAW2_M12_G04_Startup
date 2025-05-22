<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Verificar si las tablas necesarias existen
        $docentesExists = Schema::hasTable('docentes');
        $clasesExists = Schema::hasTable('clases');
        
        // Verificar si la tabla ya existe para evitar errores
        if (!Schema::hasTable('docente_clase')) {
            Schema::create('docente_clase', function (Blueprint $table) use ($docentesExists, $clasesExists) {
                $table->id();
                $table->unsignedBigInteger('docente_id');
                $table->unsignedBigInteger('clase_id');
                $table->timestamp('fecha_asignacion')->nullable();
                $table->boolean('es_titular')->default(false);
                $table->string('rol')->nullable();
                $table->timestamps();
                
                // Índices
                $table->index(['docente_id', 'clase_id']);
                
                // Solo agregar claves foráneas si las tablas existen
                if ($docentesExists) {
                    $table->foreign('docente_id')->references('id')->on('docentes');
                }
                
                if ($clasesExists) {
                    $table->foreign('clase_id')->references('id')->on('clases');
                }
            });
            
            echo "Tabla docente_clase creada correctamente.\n";
        } else {
            echo "La tabla docente_clase ya existe.\n";
            
            // Verificar si necesitamos agregar alguna columna
            if (!Schema::hasColumn('docente_clase', 'es_titular')) {
                Schema::table('docente_clase', function (Blueprint $table) {
                    $table->boolean('es_titular')->default(false)->after('fecha_asignacion');
                });
                echo "Columna 'es_titular' agregada a la tabla docente_clase.\n";
            }
            
            if (!Schema::hasColumn('docente_clase', 'rol')) {
                Schema::table('docente_clase', function (Blueprint $table) {
                    $table->string('rol')->nullable()->after('es_titular');
                });
                echo "Columna 'rol' agregada a la tabla docente_clase.\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente_clase');
    }
}; 