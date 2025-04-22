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
        Schema::table('user', function (Blueprint $table) {
            // Agregar campos de visibilidad si no existen
            if (!Schema::hasColumn('user', 'show_telefono')) {
                $table->boolean('show_telefono')->default(true);
            }
            if (!Schema::hasColumn('user', 'show_dni')) {
                $table->boolean('show_dni')->default(true);
            }
            if (!Schema::hasColumn('user', 'show_ciudad')) {
                $table->boolean('show_ciudad')->default(true);
            }
            if (!Schema::hasColumn('user', 'show_direccion')) {
                $table->boolean('show_direccion')->default(true);
            }
            if (!Schema::hasColumn('user', 'show_web')) {
                $table->boolean('show_web')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn([
                'show_telefono',
                'show_dni',
                'show_ciudad',
                'show_direccion',
                'show_web'
            ]);
        });
    }
};
