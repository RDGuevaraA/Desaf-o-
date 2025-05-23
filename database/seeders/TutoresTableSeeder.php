<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Tutor;
use App\Models\User;

class TutoresTableSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('tutores')) {
            return;
        }

        $tutores = [
            [
                'nombres' => 'Juan',
                'apellidos' => 'Perez',
                'dui' => '12345678-9',
                'correo' => 'juan@academia.edu',
                'telefono' => '7777-8888',
                'fecha_nacimiento' => '1980-05-15',
                'fecha_contratacion' => '2020-01-10',
                'estado' => 'contratado',
                'user_id' => 2
            ],
            [
                'nombres' => 'María',
                'apellidos' => 'Lopez',
                'dui' => '98765432-1',
                'correo' => 'maria@academia.edu',
                'telefono' => '7777-9999',
                'fecha_nacimiento' => '1985-08-20',
                'fecha_contratacion' => '2021-03-15',
                'estado' => 'contratado',
                'user_id' => 3
            ]
        ];

        foreach ($tutores as $tutor) {
            $tutorModel = new Tutor($tutor);
            $tutorModel->codigo_tutor = $tutorModel->generateCodigo();
            $tutorModel->save();
        }
    }
}