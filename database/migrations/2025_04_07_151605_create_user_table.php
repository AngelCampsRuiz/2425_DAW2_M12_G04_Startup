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
        // Drop the users table if it exists to avoid having two user tables
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 155)->unique();
            $table->string('password', 255);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('dni', 20)->nullable()->unique();
            $table->boolean('activo')->default(true);
            $table->string('telefono', 20)->nullable()->unique();
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
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
