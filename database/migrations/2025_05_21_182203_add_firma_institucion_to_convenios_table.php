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
        Schema::table('convenios', function (Blueprint $table) {
            $table->boolean('firmado_institucion')->default(false);
            $table->unsignedBigInteger('firmado_por_institucion')->nullable();
            $table->timestamp('fecha_firma_institucion')->nullable();
            $table->foreign('firmado_por_institucion')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            $table->dropForeign(['firmado_por_institucion']);
            $table->dropColumn(['firmado_institucion', 'firmado_por_institucion', 'fecha_firma_institucion']);
        });
    }
};
