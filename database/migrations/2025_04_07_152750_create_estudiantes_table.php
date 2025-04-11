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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('centro_educativo', 100);
            $table->string('cv_pdf', 255);
            $table->string('numero_seguridad_social', 50);
            $table->foreign('id')->references('id')->on('user');
            $table->foreignId('titulo_id')->constrained('titulos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
