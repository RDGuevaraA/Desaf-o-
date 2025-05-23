<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'tutor'])->default('tutor');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('dui')->nullable()->unique();
            $table->string('telefono')->nullable();
            $table->date('fecha_nacimiento')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'estado', 'dui', 'telefono', 'fecha_nacimiento']);
        });
    }
};