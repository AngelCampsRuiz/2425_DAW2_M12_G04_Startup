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
        Schema::table('chats', function (Blueprint $table) {
            if (!Schema::hasColumn('chats', 'institucion_id')) {
                $table->foreignId('institucion_id')->nullable()->after('estudiante_id');
                $table->foreign('institucion_id')->references('id')->on('instituciones')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            if (Schema::hasColumn('chats', 'institucion_id')) {
                $table->dropForeign(['institucion_id']);
                $table->dropColumn('institucion_id');
            }
        });
    }
};
