<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionCodigo extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'codigo_id',
        'codigo_estudiante',
        'codigo_tutor'
    ];

    public function codigo()
    {
        return $this->belongsTo(Codigo::class, 'codigo_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'codigo_estudiante');
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'codigo_tutor');
    }
}