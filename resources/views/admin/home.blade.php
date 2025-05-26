@extends('layouts.app')

@section('title', 'Inicio Administrador')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Bienvenido, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600">Gestión de cursos de la academia</p>
    <div class="flex justify-end items-center mb-4">
        <a href="{{ route('admin.curso.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 font-medium rounded transition duration-200">
            Crear Nuevo Curso
        </a>
    </div>
</div>


@if($cursos->isEmpty())
<div class="rounded-lg p-6 text-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">Aún no hay cursos creados</h3>
    <p class="text-sm text-gray-500">Para comenzar puedes hacer click en Crear Nuevo Curso.</p>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($cursos as $curso)
    <div class="bg-gradient-to-tr from-blue-300 to-yellow-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $curso->nombre_curso }}</h3>
            <p class="text-gray-700 mb-2"><strong>Tutor:</strong> {{ $curso->tutor->nombres }} {{ $curso->tutor->apellidos }}</p>
            <p class="text-gray-700 mb-5">{{ $curso->estudiantes->count() }} estudiantes</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.curso.show', $curso->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm font-medium">
                    Ver
                </a>
                <a href="{{ route('admin.curso.edit', $curso->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium">
                    Editar
                </a>
                <form action="{{ route('admin.curso.destroy', $curso->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm font-medium">
                        Eliminar
                    </button>
                </form>
            <a href="{{ route('admin.reporte.estudiantes', $curso->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm font-medium">
                    Reporte
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection