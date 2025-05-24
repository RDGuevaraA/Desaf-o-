@extends('layouts.app')

@section('title', 'Editar Curso')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Editar Curso</h2>

    <form action="{{ route('admin.curso.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre_curso" class="block text-sm font-medium text-gray-700">Nombre del Curso</label>
            <input type="text" name="nombre_curso" id="nombre_curso" value="{{ old('nombre_curso', $curso->nombre_curso) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
            <label for="codigo_tutor" class="block text-sm font-medium text-gray-700">Tutor</label>
            <select name="codigo_tutor" id="codigo_tutor" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Seleccionar Tutor --</option>
                @foreach ($tutores as $tutor)
                    <option value="{{ $tutor->codigo_tutor }}" {{ $tutor->codigo_tutor == $curso->codigo_tutor ? 'selected' : '' }}>
                        {{ $tutor->nombres }} {{ $tutor->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Estudiantes</label>
            <div class="max-h-48 overflow-y-auto border border-gray-300 rounded p-2 space-y-2">
    @foreach ($estudiantes as $estudiante)
        <label class="flex items-center space-x-2">
            <input type="checkbox" name="estudiantes[]" value="{{ $estudiante->codigo_estudiante }}"
                {{ in_array($estudiante->codigo_estudiante, $estudiantesActuales) ? 'checked' : '' }}>
            <span>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</span>
        </label>
    @endforeach
</div>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.home') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection
