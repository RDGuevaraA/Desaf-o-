<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->string('codigo_estudiante', 15)->primary();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('dui', 10)->unique();
            $table->string('correo')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('fotografia', 255)->nullable();
            $table->enum('estado', ['activo', 'inactivo']);
            $table->enum('en_grupo', ['si', 'no'])->default('no');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
};