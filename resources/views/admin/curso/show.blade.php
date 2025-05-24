@extends('layouts.app')

@section('title', 'Detalles del Curso')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Detalles del Curso</h2>

    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Nombre del Curso:</h3>
        <p class="text-gray-800">{{ $curso->nombre_curso }}</p>
    </div>

    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Docente:</h3>
        <p class="text-gray-800">
            {{ $curso->tutor->nombres }} {{ $curso->tutor->apellidos }}
        </p>
    </div>

    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Fecha de Creación:</h3>
        <p class="text-gray-800">{{ $curso->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Estudiantes Inscritos ({{ $curso->estudiantes->count() }})</h3>
        @if($curso->estudiantes->isEmpty())
            <p class="text-gray-500">No hay estudiantes inscritos en este curso.</p>
        @else
            <ul class="list-disc list-inside text-gray-800">
                @foreach($curso->estudiantes as $estudiante)
                    <li>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="flex justify-end space-x-2">
        <a href="{{ route('admin.home') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
        <a href="{{ route('admin.curso.edit', $curso->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Editar</a>
    </div>
</div>
@endsection
