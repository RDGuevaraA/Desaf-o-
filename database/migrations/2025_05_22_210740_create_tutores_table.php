<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tutores', function (Blueprint $table) {
            $table->string('codigo_tutor', 10)->primary();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('dui', 10)->unique();
            $table->string('correo')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_contratacion');
            $table->enum('estado', ['contratado', 'despedido', 'renuncia']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutores');
    }
};