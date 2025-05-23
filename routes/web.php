<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\CodigoController;

// Rutas de autenticación
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de administrador
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');
    
    // Rutas para cursos
    Route::prefix('admin/cursos')->group(function () {
        Route::get('/crear', [AdminController::class, 'createCurso'])->name('admin.curso.create');
        Route::post('/crear', [AdminController::class, 'storeCurso']);
        Route::get('/{id}', [AdminController::class, 'showCurso'])->name('admin.curso.show');
        Route::get('/{id}/editar', [AdminController::class, 'editCurso'])->name('admin.curso.edit');
        Route::put('/{id}', [AdminController::class, 'updateCurso'])->name('admin.curso.update');
        Route::delete('/{id}', [AdminController::class, 'destroyCurso'])->name('admin.curso.destroy');
    });
    
    // Rutas para reportes
    Route::get('/admin/reporte/{cursoId}', [AdminController::class, 'generarReporte'])->name('admin.reporte.trimestral');
    
    // Rutas para códigos (aspectos)
    Route::resource('codigos', CodigoController::class)->except(['show']);
});

// Rutas de tutor
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':tutor'])->group(function () {
    Route::get('/tutor/home', [TutorController::class, 'home'])->name('tutor.home');
    
    // Rutas para gestión de estudiantes
    Route::prefix('tutor/cursos')->group(function () {
        Route::get('/{cursoId}/estudiantes', [TutorController::class, 'estudiantes'])->name('tutor.estudiantes');
        Route::post('/{cursoId}/asistencias', [TutorController::class, 'guardarAsistencia'])->name('tutor.guardar.asistencia');
        Route::post('/{cursoId}/codigos', [TutorController::class, 'asignarCodigo'])->name('tutor.asignar.codigo');
        
        // Rutas para reportes
        //og Route::get('/{cursoId}/reportes', [TutorController::class, 'reportes'])->name('tutor.reportes');
        Route::get('/{cursoId}/reportes', [TutorController::class, 'reportes'])->name('tutor.reportes');
        //og Route::get('/{cursoId}/reporte/{codigoEstudiante}', [TutorController::class, 'generarReporteIndividual'])->name('tutor.reporte.individual');
        Route::get('/tutor/cursos/{curso}/reporte/{estudiante}', [TutorController::class, 'generarReporteIndividual'])->name('tutor.reporte.individual');
        //og Route::get('/{cursoId}/reporte-grupal', [TutorController::class, 'generarReporteGrupal'])->name('tutor.reporte.grupal');
        Route::get('/tutor/cursos/{curso}/reporte-grupal', [TutorController::class, 'generarReporteGrupal'])->name('tutor.reporte.grupal');
    });
});