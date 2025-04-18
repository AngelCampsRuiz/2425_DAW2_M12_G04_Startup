<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('show_telefono')->default(true);
            $table->boolean('show_dni')->default(true);
            $table->boolean('show_ciudad')->default(true);
            $table->boolean('show_direccion')->default(true);
            $table->boolean('show_web')->default(true);
        });
    }

    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn([
                'show_telefono',
                'show_dni',
                'show_ciudad',
                'show_direccion',
                'show_web'
            ]);
        });
    }
}; 