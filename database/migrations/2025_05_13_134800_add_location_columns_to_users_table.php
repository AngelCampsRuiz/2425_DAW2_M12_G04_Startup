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
            // Verificar si las columnas ya existen
            if (!Schema::hasColumn('user', 'lat')) {
                $table->decimal('lat', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('user', 'lng')) {
                $table->decimal('lng', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('user', 'direccion')) {
                $table->string('direccion')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            // Verificar si las columnas existen antes de intentar eliminarlas
            if (Schema::hasColumn('user', 'lat')) {
                $table->dropColumn('lat');
            }
            if (Schema::hasColumn('user', 'lng')) {
                $table->dropColumn('lng');
            }
            if (Schema::hasColumn('user', 'direccion')) {
                $table->dropColumn('direccion');
            }
        });
    }
};
