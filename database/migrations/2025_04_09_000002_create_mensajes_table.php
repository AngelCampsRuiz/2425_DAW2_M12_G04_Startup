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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->timestamp('fecha_envio');
            $table->foreignId('chat_id')->constrained('chats');
            $table->foreignId('user_id')->constrained('user');
            $table->string('archivo_adjunto')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
