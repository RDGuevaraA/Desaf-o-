<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;

class EstudiantesTableSeeder extends Seeder
{
    public function run()
    {
        $estudiantes = [
            ['nombres' => 'Ana', 'apellidos' => 'García', 'dui' => '11111111-1', 'correo' => 'ana@estudiante.edu', 'telefono' => '7777-1111', 'fecha_nacimiento' => '2010-02-10', 'estado' => 'activo'],
            ['nombres' => 'Luis', 'apellidos' => 'Martínez', 'dui' => '22222222-2', 'correo' => 'luis@estudiante.edu', 'telefono' => '7777-2222', 'fecha_nacimiento' => '2011-03-15', 'estado' => 'activo'],
            // Agregar más estudiantes según sea necesario
        ];

        foreach ($estudiantes as $estudiante) {
            $estudianteModel = new Estudiante($estudiante);
            $estudianteModel->codigo_estudiante = $estudianteModel->generateCodigo();
            $estudianteModel->save();
        }
    }
}