<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('codigos', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->enum('tipo', ['P', 'L', 'G', 'MG']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codigos');
    }
};