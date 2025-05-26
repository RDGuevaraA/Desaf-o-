@extends('layouts.app')

@section('title', 'Detalles del Curso')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-xl">
    <div class="bg-gradient-to-r from-blue-300 to-yellow-200 text-gray-700 px-6 py-4 rounded-t-xl">
        <h2 class="text-xl font-bold text-gray-800">Detalles del Curso</h2>
    </div>
    <div class="px-6 py-4">
        <h3 class="text-lg font-semibold text-gray-700">Nombre del Curso:</h3>
        <p class="text-gray-800">{{ $curso->nombre_curso }}</p>
    </div>

    <div class="px-6 py-4">
        <h3 class="text-lg font-semibold text-gray-700">Docente:</h3>
        <p class="text-gray-800">
            {{ $curso->tutor->nombres }} {{ $curso->tutor->apellidos }}
        </p>
    </div>

    <div class="px-6 py-4">
        <h3 class="text-lg font-semibold text-gray-700">Fecha de Creación:</h3>
        <p class="text-gray-800">{{ $curso->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="px-6 py-4">
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

    <div class="flex justify-end space-x-2 px-6 py-4">
        <a href="{{ route('admin.home') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
        <a href="{{ route('admin.curso.edit', $curso->id) }}" class="px-5 py-2 text-white rounded bg-yellow-500 hover:bg-yellow-600">Editar</a>
    </div>
</div>
@endsection
