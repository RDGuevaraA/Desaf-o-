@extends('layouts.app')

@section('title', 'Estudiantes del Curso')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-4">Estudiantes de {{ $curso->nombre_curso }}</h2>

<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-sm font-medium">Nombre</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Código</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Reporte</th>
        </tr>
    </thead>
    <tbody>
        @foreach($curso->estudiantes as $estudiante)
        <tr class="border-b">
            <td class="px-6 py-4">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</td>
            <td class="px-6 py-4">{{ $estudiante->codigo_estudiante }}</td>
            <td class="px-6 py-4">
                <a href="{{ route('admin.reporte.estudiante', ['curso' => $curso->id, 'estudiante' => $estudiante->codigo_estudiante]) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    Generar PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
