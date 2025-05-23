@extends('layouts.app')

@section('title', 'Crear Nuevo Curso')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear Nuevo Curso</h2>
    
    <form action="{{ route('admin.curso.create') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nombre_curso" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Curso</label>
            <input type="text" name="nombre_curso" id="nombre_curso" class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="mb-4">
            <label for="codigo_tutor" class="block text-gray-700 text-sm font-bold mb-2">Tutor</label>
            <select name="codigo_tutor" id="codigo_tutor" class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                <option value="">Seleccione un tutor</option>
                @foreach($tutores as $tutor)
                <option value="{{ $tutor->codigo_tutor }}">{{ $tutor->nombres }} {{ $tutor->apellidos }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Estudiantes</label>
            <div class="mb-2">
                <input type="text" id="buscarEstudiante" placeholder="Buscar estudiante..." class="w-full px-3 py-2 border rounded shadow appearance-none focus:outline-none focus:shadow-outline mb-2">
            </div>
            <div class="border rounded p-2 h-64 overflow-y-auto">
                @foreach($estudiantes as $estudiante)
                <div class="flex items-center mb-2 estudiante-item">
                    <input type="checkbox" name="estudiantes[]" id="estudiante_{{ $estudiante->codigo_estudiante }}" value="{{ $estudiante->codigo_estudiante }}" class="mr-2">
                    <label for="estudiante_{{ $estudiante->codigo_estudiante }}">{{ $estudiante->nombres }} {{ $estudiante->apellidos }} ({{ $estudiante->codigo_estudiante }})</label>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('admin.home') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Crear Curso
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('buscarEstudiante').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const estudiantes = document.querySelectorAll('.estudiante-item');
        
        estudiantes.forEach(estudiante => {
            const text = estudiante.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                estudiante.style.display = 'flex';
            } else {
                estudiante.style.display = 'none';
            }
        });
    });
</script>
@endsection