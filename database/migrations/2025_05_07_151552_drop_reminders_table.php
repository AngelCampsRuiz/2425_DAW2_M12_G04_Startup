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
        Schema::dropIfExists('reminders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Aquí puedes recrear la tabla si es necesario
    }
};
