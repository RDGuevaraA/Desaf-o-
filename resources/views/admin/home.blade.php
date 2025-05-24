@extends('layouts.app')

@section('title', 'Inicio Administrador')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Bienvenido, {{ Auth::user()->name }}</h2>
    <div class="flex justify-between items-center mb-4">
        <p class="text-gray-600">Gestión de cursos de la academia</p>
        <a href="{{ route('admin.curso.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
            Crear Nuevo Curso
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($cursos as $curso)
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $curso->nombre_curso }}</h3>
            <p class="text-gray-600 mb-2"><strong>Tutor:</strong> {{ $curso->tutor->nombres }} {{ $curso->tutor->apellidos }}</p>
            <p class="text-gray-600 mb-4">{{ $curso->estudiantes->count() }} estudiantes</p>
            <div class="flex space-x-2">
                <a href="{{ route('admin.curso.show', $curso->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    Ver
                </a>
                <a href="{{ route('admin.curso.edit', $curso->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                    Editar
                </a>
                <form action="{{ route('admin.curso.destroy', $curso->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                        Eliminar
                    </button>
                </form>
                <a href="{{ route('admin.reporte.estudiantes', $curso->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                    Reporte
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection