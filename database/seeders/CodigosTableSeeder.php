<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Codigo;

class CodigosTableSeeder extends Seeder
{
    public function run()
    {
        // Aspectos positivos (P)
        Codigo::create(['nombre' => 'Completa sus actividades con puntualidad', 'tipo' => 'P']);
        Codigo::create(['nombre' => 'Muestra interés en las clases', 'tipo' => 'P']);
        
        // Aspectos leves (L)
        Codigo::create(['nombre' => 'Platica en clase', 'tipo' => 'L']);
        Codigo::create(['nombre' => 'No trae materiales completos', 'tipo' => 'L']);
        
        // Aspectos graves (G)
        Codigo::create(['nombre' => 'Falta de respeto a compañeros', 'tipo' => 'G']);
        Codigo::create(['nombre' => 'Uso de teléfono en clase', 'tipo' => 'G']);
        
        // Aspectos muy graves (MG)
        Codigo::create(['nombre' => 'Agresión física o verbal', 'tipo' => 'MG']);
        Codigo::create(['nombre' => 'Daño intencional a propiedad ajena', 'tipo' => 'MG']);
    }
}