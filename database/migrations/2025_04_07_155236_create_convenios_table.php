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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('documento_pdf', 255);
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_aprobacion');
            $table->foreignId('tutor_id')->constrained('tutores');
            $table->foreignId('seguimiento_id')->constrained('seguimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
