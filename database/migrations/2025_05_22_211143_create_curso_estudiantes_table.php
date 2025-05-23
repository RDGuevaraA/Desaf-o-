<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('curso_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos');
            $table->string('codigo_estudiante', 15);
            $table->foreign('codigo_estudiante')->references('codigo_estudiante')->on('estudiantes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('curso_estudiantes');
    }
};