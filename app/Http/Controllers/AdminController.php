<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Routing\ControllerMiddlewareOptions as Middleware;
use Barryvdh\DomPDF\Facade\Pdf;



class AdminController extends Controller

{
    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function home()
    {
        $cursos = Curso::with('tutor')->get();
        return view('admin.home', compact('cursos'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function createCurso()
    {
        $tutores = Tutor::where('estado', 'contratado')->get();
        $estudiantes = Estudiante::where('estado', 'activo')->where('en_grupo', 'no')->get();
        return view('admin.curso.create', compact('tutores', 'estudiantes'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function storeCurso(Request $request)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:100',
            'codigo_tutor' => 'required|exists:tutores,codigo_tutor',
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:estudiantes,codigo_estudiante'
        ]);

        $curso = Curso::create([
            'nombre_curso' => $request->nombre_curso,
            'codigo_tutor' => $request->codigo_tutor
        ]);

        if ($request->has('estudiantes')) {
            $curso->estudiantes()->attach($request->estudiantes);
            Estudiante::whereIn('codigo_estudiante', $request->estudiantes)
                ->update(['en_grupo' => 'si']);
        }

        return redirect()->route('admin.home')->with('success', 'Curso creado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function showCurso($id)
    {
        $curso = Curso::with(['tutor', 'estudiantes'])->findOrFail($id);
        return view('admin.curso.show', compact('curso'));
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function editCurso($id)
    {
        $curso = Curso::findOrFail($id);
        $tutores = Tutor::where('estado', 'contratado')->get();
        $estudiantesActuales = $curso->estudiantes->pluck('codigo_estudiante')->toArray();
        $estudiantes = Estudiante::where('estado', 'activo')
            ->where(function($query) use ($estudiantesActuales) {
                $query->where('en_grupo', 'no')
                    ->orWhereIn('codigo_estudiante', $estudiantesActuales);
            })->get();
        
        return view('admin.curso.edit', compact('curso', 'tutores', 'estudiantes', 'estudiantesActuales'));
    }








    // PRUEBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
#[Middleware('auth')]
#[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
public function mostrarEstudiantesParaReporte($cursoId)
{
    $curso = Curso::with('estudiantes')->findOrFail($cursoId);
    return view('admin.reporte.estudiantes', compact('curso'));
}


private function calcularSemaforo($leves, $graves, $muyGraves, $inasistencias)
{
    $totalFaltas = $inasistencias->where('tipo', 'I')->count();
    $totalMuyGraves = $muyGraves->count();

    if ($totalMuyGraves > 3 || $totalFaltas > 5) return 'rojo';
    if ($totalMuyGraves > 1 || $totalFaltas > 3) return 'amarillo';
    if ($graves->count() > 0 || $leves->count() > 2) return 'verde';
    return 'azul';
}

#[Middleware('auth')]
#[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
public function generarReporteEstudiante($cursoId, $codigoEstudiante)
{
       $curso = Curso::with(['tutor'])->findOrFail($cursoId);

    $estudiante = Estudiante::with(['asignacionesCodigos.codigo', 'asistencias'])
        ->where('codigo_estudiante', $codigoEstudiante)
        ->firstOrFail();

    $trimestre = floor((date('n') - 2) / 3) + 1;

    $fechaInicio = now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3);
    $fechaFin = (clone $fechaInicio)->addMonths(3)->subDay();

    // Aspectos
    $aspectosPositivos = $estudiante->asignacionesCodigos
        ->where('codigo.tipo', 'P')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

    $aspectosLeves = $estudiante->asignacionesCodigos
        ->where('codigo.tipo', 'L')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

    $aspectosGraves = $estudiante->asignacionesCodigos
        ->where('codigo.tipo', 'G')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

    $aspectosMuyGraves = $estudiante->asignacionesCodigos
        ->where('codigo.tipo', 'MG')
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

    // Inasistencias del trimestre
    $inasistencias = $estudiante->asistencias
        ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

    // Calcular semáforo
    $semaforo = $this->calcularSemaforo($aspectosLeves, $aspectosGraves, $aspectosMuyGraves, $inasistencias);

    // Preparar datos
    $data = [
        'curso' => $curso,
        'estudiante' => $estudiante,
        'trimestre' => $trimestre,
        'fechaInicio' => $fechaInicio,
        'fechaFin' => $fechaFin,
        'aspectosPositivos' => $aspectosPositivos,
        'aspectosLeves' => $aspectosLeves,
        'aspectosGraves' => $aspectosGraves,
        'aspectosMuyGraves' => $aspectosMuyGraves,
        'inasistencias' => $inasistencias,
        'semaforo' => $semaforo,
    ];

    $pdf = PDF::loadView('admin.reporte.estudiante', $data);
    return $pdf->download('reporte_' . $estudiante->nombres . '_' . $estudiante->apellidos . '.pdf');
}








































    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function updateCurso(Request $request, $id)
    {
        $request->validate([
            'nombre_curso' => 'required|string|max:100',
            'codigo_tutor' => 'required|exists:tutores,codigo_tutor',
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:estudiantes,codigo_estudiante'
        ]);

        $curso = Curso::findOrFail($id);
        $curso->update([
            'nombre_curso' => $request->nombre_curso,
            'codigo_tutor' => $request->codigo_tutor
        ]);

        // Actualizar estudiantes
        $estudiantesActuales = $curso->estudiantes->pluck('codigo_estudiante')->toArray();
        $estudiantesNuevos = $request->estudiantes ?? [];
        
        // Estudiantes a remover
        $estudiantesARemover = array_diff($estudiantesActuales, $estudiantesNuevos);
        if (!empty($estudiantesARemover)) {
            Estudiante::whereIn('codigo_estudiante', $estudiantesARemover)
                ->update(['en_grupo' => 'no']);
        }
        
        // Estudiantes a agregar
        $estudiantesAAgregar = array_diff($estudiantesNuevos, $estudiantesActuales);
        if (!empty($estudiantesAAgregar)) {
            Estudiante::whereIn('codigo_estudiante', $estudiantesAAgregar)
                ->update(['en_grupo' => 'si']);
        }
        
        $curso->estudiantes()->sync($request->estudiantes);

        return redirect()->route('admin.home')->with('success', 'Curso actualizado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function destroyCurso($id)
    {
        $curso = Curso::findOrFail($id);
        
        // Marcar estudiantes como sin grupo
        Estudiante::whereIn('codigo_estudiante', $curso->estudiantes->pluck('codigo_estudiante')->toArray())
            ->update(['en_grupo' => 'no']);
        
        $curso->delete();
        
        return redirect()->route('admin.home')->with('success', 'Curso eliminado exitosamente');
    }

    #[Middleware('auth')]
    #[Middleware(\App\Http\Middleware\CheckRole::class.':admin')]
    public function generarReporte($cursoId)
    {
        $curso = Curso::with(['estudiantes.asignacionesCodigos.codigo', 'estudiantes.asistencias'])->findOrFail($cursoId);
        $trimestre = floor((date('n') - 2) / 3) + 1;
        
        $data = [
            'curso' => $curso,
            'trimestre' => $trimestre,
            'fechaInicio' => now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3),
            'fechaFin' => now()->startOfYear()->addMonths(1 + ($trimestre - 1) * 3)->addMonths(3)->subDay()
        ];
        
        $pdf = \PDF::loadView('admin.reporte.trimestral', $data);
        return $pdf->download('reporte_trimestral_'.$curso->nombre_curso.'_trimestre_'.$trimestre.'.pdf');
    }
}