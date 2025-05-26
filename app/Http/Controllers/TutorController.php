<?php

namespace App\Http\Controllers;

use Illuminate\Routing\ControllerMiddlewareOptions as Middleware;

use App\Models\AsignacionCodigo;
use App\Models\Asistencia;
use App\Models\Codigo;
use App\Models\Curso;
use App\Models\Estudiante;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function home()
    {
        $tutor = auth()->user()->tutor;
        $cursos = $tutor->cursos;
        return view('tutor.home', compact('cursos'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function estudiantes($cursoId)
    {
        $curso = Curso::with('estudiantes')->findOrFail($cursoId);
        $hoy = now();
        
        // Verificar si es sábado entre 8am y 11am
        /*$puedeTomarAsistencia = $hoy->isSaturday() && $hoy->between(
            $hoy->copy()->setTime(8, 0),
            $hoy->copy()->setTime(11, 0)
        );*/

        // Prueba de sábado
        $puedeTomarAsistencia = true;
        
        // Obtener códigos para el combobox
        $codigos = Codigo::all()->groupBy('tipo');
        
        return view('tutor.estudiantes', compact('curso', 'puedeTomarAsistencia', 'codigos'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function guardarAsistencia(Request $request, $cursoId)
    {
        $request->validate([
            'asistencias' => 'required|array',
            'asistencias.*' => 'in:A,I,J',
            'estudiantes' => 'required|array',
            'estudiantes.*' => 'exists:estudiantes,codigo_estudiante'
        ]);

        $hoy = now();
        $tutor = auth()->user()->tutor;

        // Verificar horario permitido (sábados 8-11am)
        /*if (!$hoy->isSaturday() || !$hoy->between(
            $hoy->copy()->setTime(8, 0),
            $hoy->copy()->setTime(11, 0)
        )) {
            return back()->with('error', 'Solo puedes tomar asistencia los sábados entre 8:00am y 11:00am');
        }*/

        // Registrar asistencias
        foreach ($request->estudiantes as $index => $codigoEstudiante) {
            Asistencia::updateOrCreate(
                [
                    'fecha' => $hoy->toDateString(),
                    'codigo_estudiante' => $codigoEstudiante
                ],
                [
                    'tipo' => $request->asistencias[$index],
                    'codigo_tutor' => $tutor->codigo_tutor
                ]
            );
        }

        return back()->with('success', 'Asistencias registradas exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function asignarCodigo(Request $request, $cursoId)
    {
        $request->validate([
            'codigo_id' => 'required|exists:codigos,id',
            'codigo_estudiante' => 'required|exists:estudiantes,codigo_estudiante'
        ]);
        
        $tutor = auth()->user()->tutor;
        
        AsignacionCodigo::create([
            'fecha' => now()->toDateString(),
            'codigo_id' => $request->codigo_id,
            'codigo_estudiante' => $request->codigo_estudiante,
            'codigo_tutor' => $tutor->codigo_tutor
        ]);
        
        return back()->with('success', 'Código asignado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function reportes($cursoId)
    {
        $curso = Curso::with('estudiantes')->findOrFail($cursoId);
        return view('tutor.reportes', compact('curso'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function generarReporteIndividual($cursoId, $codigoEstudiante)
    {
        $curso = Curso::findOrFail($cursoId);
        $estudiante = Estudiante::with(['asignacionesCodigos.codigo', 'asistencias'])
            ->findOrFail($codigoEstudiante);
        
        $trimestre = floor((date('n') - 2) / 3) + 1;
        $fechaInicio = now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3);
        $fechaFin = $fechaInicio->copy()->addMonths(3)->subDay();
        
        $aspectosPositivos = $estudiante->asignacionesCodigos()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'P');
            })->with('codigo')->get();
        
        $aspectosLeves = $estudiante->asignacionesCodigos()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'L');
            })->with('codigo')->get();
        
        $aspectosGraves = $estudiante->asignacionesCodigos()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'G');
            })->with('codigo')->get();
        
        $aspectosMuyGraves = $estudiante->asignacionesCodigos()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->whereHas('codigo', function($query) {
                $query->where('tipo', 'MG');
            })->with('codigo')->get();
        
        $inasistencias = $estudiante->asistencias()
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();
        
        $data = [
            'curso' => $curso,
            'estudiante' => $estudiante,
            'trimestre' => $trimestre,
            'aspectosPositivos' => $aspectosPositivos,
            'aspectosLeves' => $aspectosLeves,
            'aspectosGraves' => $aspectosGraves,
            'aspectosMuyGraves' => $aspectosMuyGraves,
            'inasistencias' => $inasistencias,
            'semaforo' => $estudiante->semaforo
        ];
        
        $pdf = \PDF::loadView('tutor.reporte.individual', $data);
        return $pdf->download('reporte_'.$estudiante->codigo_estudiante.'_trimestre_'.$trimestre.'.pdf');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class . ':tutor')]
    public function generarReporteGrupal($cursoId)
    {
        $curso = Curso::with(['estudiantes.asignacionesCodigos.codigo', 'estudiantes.asistencias'])->findOrFail($cursoId);
        $trimestre = floor((date('n') - 2) / 3) + 1;
        
        $data = [
            'curso' => $curso,
            'trimestre' => $trimestre,
            'fechaInicio' => now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3),
            'fechaFin' => now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3)->addMonths(3)->subDay()
        ];
        
        $pdf = \PDF::loadView('tutor.reporte.grupal', $data);
        return $pdf->download('reporte_grupal_'.$curso->nombre_curso.'_trimestre_'.$trimestre.'.pdf');
    }
}