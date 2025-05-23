<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'tipo',
        'codigo_estudiante',
        'codigo_tutor'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigo_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }
}