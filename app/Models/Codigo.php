<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo'
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionCodigo::class, 'codigo_id');
    }
}