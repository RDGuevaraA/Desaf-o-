<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_curso',
        'codigo_tutor'
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'curso_estudiantes', 'curso_id', 'codigo_estudiante');
    }
}