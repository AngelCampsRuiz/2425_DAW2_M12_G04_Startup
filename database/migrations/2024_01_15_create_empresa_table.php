<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('cif', 9)->nullable();
            $table->boolean('show_cif')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}; 