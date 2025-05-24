@extends('layouts.app')

@section('title', 'Inicio Tutor')

@section('content')
<div class="mb-7">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Bienvenido, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Selecciona un curso para gestionar asistencias y códigos.</p>
</div>

@if($cursos->isEmpty())
<div class="rounded-lg p-6 text-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">No tienes cursos asignados</h3>
    <p class="text-sm text-gray-500">Contacta al administrador para que te asignen a un curso.</p>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($cursos as $curso)
    <div class="bg-gradient-to-tr from-blue-300 to-yellow-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $curso->nombre_curso }}</h3>
            <p class="text-gray-600 mb-5">{{ $curso->estudiantes->count() }} estudiantes</p>
            <a href="{{ route('tutor.estudiantes', $curso->id) }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 shadow-md rounded-sm transition duration-200">
                Gestionar Curso
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection