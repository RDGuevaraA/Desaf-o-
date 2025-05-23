<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'tutores';
    
    use HasFactory;

    protected $primaryKey = 'codigo_tutor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codigo_tutor',
        'nombres',
        'apellidos',
        'dui',
        'correo',
        'telefono',
        'fecha_nacimiento',
        'fecha_contratacion',
        'estado',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'codigo_tutor');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'codigo_tutor');
    }

    public function asignacionesCodigos()
    {
        return $this->hasMany(AsignacionCodigo::class, 'codigo_tutor');
    }

    public function generateCodigo()
    {
        $iniciales = substr($this->apellidos, 0, 2);
        $correlativo = Tutor::where('apellidos', 'like', substr($this->apellidos, 0, 1) . '%')->count() + 1;
        return strtoupper($iniciales) . str_pad($correlativo, 3, '0', STR_PAD_LEFT);
    }
}