<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('tipo', ['A', 'I', 'J']);
            $table->string('codigo_estudiante', 15);
            $table->string('codigo_tutor', 10);
            $table->foreign('codigo_estudiante')->references('codigo_estudiante')->on('estudiantes');
            $table->foreign('codigo_tutor')->references('codigo_tutor')->on('tutores');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
};