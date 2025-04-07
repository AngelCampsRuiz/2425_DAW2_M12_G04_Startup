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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 155);
            $table->string('password', 255);
            $table->string('pais', 50);
            $table->date('fecha_nacimiento');
            $table->string('ciudad', 100);
            $table->string('dni', 20);
            $table->string('sitio_web', 255);
            $table->boolean('activo');
            $table->string('telefono', 20);
            $table->foreignId('role_id')->constrained('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
