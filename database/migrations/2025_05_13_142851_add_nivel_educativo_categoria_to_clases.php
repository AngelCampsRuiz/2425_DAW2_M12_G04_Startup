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
        Schema::table('clases', function (Blueprint $table) {
            $table->unsignedBigInteger('nivel_educativo_id')->nullable()->after('activa');
            $table->unsignedBigInteger('categoria_id')->nullable()->after('nivel_educativo_id');
            
            $table->foreign('nivel_educativo_id')->references('id')->on('niveles_educativos')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clases', function (Blueprint $table) {
            $table->dropForeign(['nivel_educativo_id']);
            $table->dropForeign(['categoria_id']);
            $table->dropColumn(['nivel_educativo_id', 'categoria_id']);
        });
    }
};
