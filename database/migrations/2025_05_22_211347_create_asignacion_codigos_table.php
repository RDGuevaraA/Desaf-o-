<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asignacion_codigos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('codigo_id')->constrained('codigos');
            $table->string('codigo_estudiante', 15);
            $table->string('codigo_tutor', 10);
            $table->foreign('codigo_estudiante')->references('codigo_estudiante')->on('estudiantes');
            $table->foreign('codigo_tutor')->references('codigo_tutor')->on('tutores');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asignacion_codigos');
    }
};