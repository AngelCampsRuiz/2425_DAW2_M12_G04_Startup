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
        Schema::table('solicitudes', function (Blueprint $table) {
            if (!Schema::hasColumn('solicitudes', 'respuesta_empresa')) {
                $table->text('respuesta_empresa')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            if (Schema::hasColumn('solicitudes', 'respuesta_empresa')) {
                $table->dropColumn('respuesta_empresa');
            }
        });
    }
};
