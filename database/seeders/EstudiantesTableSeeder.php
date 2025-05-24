<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class EstudiantesTableSeeder extends Seeder
{
    public function run()
    {
        $response = Http::get('https://randomuser.me/api/', [
            'results' => 40,
            'inc' => 'name,email,phone,picture,dob',
            'nat' => 'es'
        ]);

        $users = $response->json()['results'];

        foreach ($users as $user) {
            $estudiante = new Estudiante([
                'nombres' => iconv('UTF-8', 'ASCII//TRANSLIT', $user['name']['first']),
                'apellidos' => iconv('UTF-8', 'ASCII//TRANSLIT', $user['name']['last']),
                
                'dui' => $this->generateDui(),
                'correo' => $user['email'],
                'telefono' => preg_replace('/[^0-9]/', '', $user['phone']),
                'fecha_nacimiento' => Carbon::parse($user['dob']['date'])->format('Y-m-d'),
                'fotografia' => $user['picture']['large'],
                'estado' => 'activo',
                'en_grupo' => 'no'
            ]);

            $estudiante->codigo_estudiante = $this->generateStudentCode($user['name']['last']);
            $estudiante->save();
        }
    }

    private function generateDui()
    {
        return str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT) . '-' . mt_rand(1, 9);
    }

    private function generateStudentCode($apellidos)
    {
        // Asegúrate de sanitizar también para el código del estudiante
        $apellidos = iconv('UTF-8', 'ASCII//TRANSLIT', $apellidos);
        $iniciales = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $apellidos), 0, 2));
        $anio = date('y');
        $correlativo = str_pad(Estudiante::count() + 1, 3, '0', STR_PAD_LEFT);
        
        return $iniciales . $anio . $correlativo;
    }
}