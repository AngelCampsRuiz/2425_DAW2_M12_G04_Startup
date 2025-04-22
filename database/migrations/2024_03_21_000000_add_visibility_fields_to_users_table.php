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
        if (Schema::hasTable('user')) {
            Schema::table('user', function (Blueprint $table) {
                $table->boolean('show_telefono')->default(true);
                $table->boolean('show_dni')->default(true);
                $table->boolean('show_ciudad')->default(true);
                $table->boolean('show_direccion')->default(true);
                $table->boolean('show_web')->default(true);
            });
        } elseif (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('show_telefono')->default(true);
                $table->boolean('show_dni')->default(true);
                $table->boolean('show_ciudad')->default(true);
                $table->boolean('show_direccion')->default(true);
                $table->boolean('show_web')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('user')) {
            Schema::table('user', function (Blueprint $table) {
                $table->dropColumn([
                    'show_telefono',
                    'show_dni',
                    'show_ciudad',
                    'show_direccion',
                    'show_web'
                ]);
            });
        } elseif (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'show_telefono',
                    'show_dni',
                    'show_ciudad',
                    'show_direccion',
                    'show_web'
                ]);
            });
        }
    }
};
