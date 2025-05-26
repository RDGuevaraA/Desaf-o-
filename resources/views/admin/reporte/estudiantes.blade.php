@extends('layouts.app')

@section('title', 'Estudiantes del Curso')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-4">Estudiantes de {{ $curso->nombre_curso }}</h2>

<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-400">ESTUDIANTE</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-400">REPORTE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($curso->estudiantes as $estudiante)
        <tr class="border-b-1 border-gray-200">
            <td class="px-6 py-5 text-sm flex items-center gap-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-sm" src="{{ $estudiante->fotografia }}" alt="Foto de {{ $estudiante->nombres }}">
                    </div>
                    <div class="ml-4">
                        <div class="text-md font-medium text-gray-900">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</div>
                        <div class="text-sm text-gray-500">{{ $estudiante->codigo_estudiante }}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-5">
                <a href="{{ route('admin.reporte.estudiante', ['curso' => $curso->id, 'estudiante' => $estudiante->codigo_estudiante]) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium">
                    Generar PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
