<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $primaryKey = 'codigo_estudiante';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codigo_estudiante',
        'nombres',
        'apellidos',
        'dui',
        'correo',
        'telefono',
        'fecha_nacimiento',
        'fotografia',
        'estado',
        'en_grupo'
    ];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiantes', 'codigo_estudiante', 'curso_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'codigo_estudiante');
    }

    public function asignacionesCodigos()
    {
        return $this->hasMany(AsignacionCodigo::class, 'codigo_estudiante');
    }

    public function generateCodigo()
    {
        $iniciales = substr($this->apellidos, 0, 2);
        $anio = date('y');
        $correlativo = Estudiante::whereYear('created_at', date('Y'))->count() + 1;
        return strtoupper($iniciales) . $anio . str_pad($correlativo, 3, '0', STR_PAD_LEFT);
    }

    public function getSemaforoAttribute()
    {
        $trimestreInicio = now()->month >= 2 ? now()->startOfYear()->addMonths(1) : now()->subYear()->startOfYear()->addMonths(1);
        $trimestreActual = floor((now()->month - 2) / 3) + 1;
        
        $inicioTrimestre = now()->startOfYear()->addMonths(1 + ($trimestreActual - 1) * 3);
        $finTrimestre = $inicioTrimestre->copy()->addMonths(3)->subDay();
        
        $aspectosPositivos = $this->asignacionesCodigos()
            ->whereBetween('fecha', [$inicioTrimestre, $finTrimestre])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'P');
            })->count();
        
        $aspectosLeves = $this->asignacionesCodigos()
            ->whereBetween('fecha', [$inicioTrimestre, $finTrimestre])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'L');
            })->count();
        
        $aspectosGraves = $this->asignacionesCodigos()
            ->whereBetween('fecha', [$inicioTrimestre, $finTrimestre])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'G');
            })->count();
        
        $aspectosMuyGraves = $this->asignacionesCodigos()
            ->whereBetween('fecha', [$inicioTrimestre, $finTrimestre])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'MG');
            })->count();
        
        $inasistencias = $this->asistencias()
            ->whereBetween('fecha', [$inicioTrimestre, $finTrimestre])
            ->where('tipo', 'I')
            ->count();
        
        // Lógica del semáforo
        if ($aspectosMuyGraves >= 1) {
            return 'rojo';
        }
        
        if ($aspectosGraves >= 2 || ($aspectosLeves >= 6 && $aspectosGraves >= 1) || $aspectosLeves >= 12) {
            return 'rojo';
        }
        
        if ($aspectosGraves >= 1 || $aspectosLeves >= 6 || $inasistencias >= 4) {
            return 'amarillo';
        }
        
        if ($aspectosPositivos >= 4 && ($aspectosLeves <= 1 || $inasistencias <= 1)) {
            return 'azul';
        }
        
        if ($aspectosLeves <= 2 && $inasistencias <= 2) {
            return 'verde';
        }
        
        return 'verde'; // Por defecto
    }
}