@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Reportes - {{ $curso->nombre_curso }}</h2>
    <p class="text-gray-600">Genera reportes trimestrales para los estudiantes.</p>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-blue-300 to-yellow-200 text-gray-700 px-6 py-4">
        <h3 class="font-semibold">Reporte Trimestral</h3>
    </div>
    <div class="p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($curso->estudiantes as $estudiante)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-lg" src="{{ $estudiante->fotografia ? asset('storage/'.$estudiante->fotografia) : asset('images/default-profile.png') }}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-md font-medium text-gray-900">{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</div>
                                <div class="text-sm text-gray-500">{{ $estudiante->codigo_estudiante }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- Asegúrate de pasar ambos parámetros: cursoId y codigoEstudiante -->
                        <a href="{{ route('tutor.reporte.individual', ['curso' => $curso->id, 'estudiante' => $estudiante->codigo_estudiante]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 font-medium rounded text-sm">
                            Generar Reporte
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 flex justify-end">
            <!-- Asegúrate de pasar el cursoId para el reporte grupal -->
            <a href="{{ route('tutor.reporte.grupal', $curso->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
                Generar Reporte Grupal
            </a>
        </div>
    </div>
</div>
@endsection