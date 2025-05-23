<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@academia.edu',
            'password' => Hash::make('password'),
            'rol' => 'admin',
            'estado' => 'activo'
        ]);

        // Tutores
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@academia.edu',
            'password' => Hash::make('password'),
            'rol' => 'tutor',
            'estado' => 'activo',
            'dui' => '12345678-9',
            'telefono' => '7777-8888',
            'fecha_nacimiento' => '1980-05-15'
        ]);

        User::create([
            'name' => 'María López',
            'email' => 'maria@academia.edu',
            'password' => Hash::make('password'),
            'rol' => 'tutor',
            'estado' => 'activo',
            'dui' => '98765432-1',
            'telefono' => '7777-9999',
            'fecha_nacimiento' => '1985-08-20'
        ]);
    }
}