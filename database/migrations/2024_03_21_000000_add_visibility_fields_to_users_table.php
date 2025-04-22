<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Verificar si la tabla 'user' existe
        if (Schema::hasTable('user')) {
            Schema::table('user', function (Blueprint $table) {
                $table->boolean('show_telefono')->default(true);
                $table->boolean('show_dni')->default(true);
                $table->boolean('show_ciudad')->default(true);
                $table->boolean('show_direccion')->default(true);
                $table->boolean('show_web')->default(true);
            });
        } else {
            // Si la tabla 'user' no existe, crear la tabla 'users' si no existe
            if (!Schema::hasTable('users')) {
                Schema::create('users', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->foreignId('role_id')->nullable()->constrained('roles');
                    $table->boolean('visibilidad')->default(false);
                    $table->rememberToken();
                    $table->timestamps();
                });
            }

            // Añadir los campos de visibilidad a la tabla 'users'
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('show_telefono')->default(true);
                $table->boolean('show_dni')->default(true);
                $table->boolean('show_ciudad')->default(true);
                $table->boolean('show_direccion')->default(true);
                $table->boolean('show_web')->default(true);
            });
        }
    }

    public function down()
    {
        // Verificar si la tabla 'user' existe
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
        } else if (Schema::hasTable('users')) {
            // Si la tabla 'user' no existe, pero 'users' sí, eliminar los campos de 'users'
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
