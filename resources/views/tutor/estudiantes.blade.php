@extends('layouts.app')

@section('title', 'Gestión de Estudiantes')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">{{ $curso->nombre_curso }}</h2>
    <div class="flex justify-between items-center">
        <p class="text-gray-600">{{ $curso->estudiantes->count() }} estudiantes</p>
        <div class="flex space-x-2">
            <a href="{{ route('tutor.reportes', $curso->id) }}" class="bg-yellow-500 hover:bg-yellow-600 font-medium text-white px-6 py-2 rounded-lg transition duration-200">
                Reportes
            </a>
        </div>
    </div>
</div>

@if($puedeTomarAsistencia)
<form action="{{ route('tutor.guardar.asistencia', $curso->id) }}" method="POST">
    @csrf
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-300 to-yellow-200 text-gray-700 px-6 py-4">
            <h3 class="font-semibold text-md">Registro de Asistencia - {{ now()->format('d/m/Y') }}</h3>
        </div>
        <div class="p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($curso->estudiantes as $estudiante)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select name="asistencias[]" class="border rounded px-2 py-1">
                                <option value="A">Asistió</option>
                                <option value="I">Inasistencia</option>
                                <option value="J">Justificado</option>
                            </select>
                            <input type="hidden" name="estudiantes[]" value="{{ $estudiante->codigo_estudiante }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button type="button" onclick="mostrarModalCodigo('{{ $estudiante->codigo_estudiante }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 font-medium rounded text-sm">
                                Asignar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
                    Guardar Asistencias
                </button>
            </div>
        </div>
    </div>
</form>
@else
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
    <p class="font-bold">Atención</p>
    <p>Solo puedes tomar asistencia los sábados entre 8:00am y 11:00am.</p>
</div>
@endif

<!-- Modal para asignar códigos -->
<div id="modalCodigo" class="fixed inset-0 bg-black/50 backdrop-blur-xs flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="bg-gradient-to-r from-blue-300 to-yellow-200 text-gray-700 px-4 py-3 rounded-t-lg">
            <h3 class="font-semibold">Asignar Código</h3>
        </div>
        <form id="formCodigo" method="POST" action="">
            @csrf
            <div class="p-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Código</label>
                    <select id="tipoCodigo" class="border rounded w-full px-3 py-2">
                        <option value="P">Positivo</option>
                        <option value="L">Leve</option>
                        <option value="G">Grave</option>
                        <option value="MG">Muy Grave</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Código</label>
                    <select name="codigo_id" id="selectCodigo" class="border rounded w-full px-3 py-2" required>
                        @foreach($codigos['P'] as $codigo)
                            <option value="{{ $codigo->id }}" data-tipo="P">{{ $codigo->nombre }}</option>
                        @endforeach
                        @foreach($codigos['L'] as $codigo)
                            <option value="{{ $codigo->id }}" data-tipo="L">{{ $codigo->nombre }}</option>
                        @endforeach
                        @foreach($codigos['G'] as $codigo)
                            <option value="{{ $codigo->id }}" data-tipo="G">{{ $codigo->nombre }}</option>
                        @endforeach
                        @foreach($codigos['MG'] as $codigo)
                            <option value="{{ $codigo->id }}" data-tipo="MG">{{ $codigo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="codigoEstudiante" name="codigo_estudiante">
            </div>
            <div class="bg-gray-100 px-4 py-3 rounded-b-lg flex justify-end">
                <button type="button" onclick="cerrarModalCodigo()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
                    Cancelar
                </button>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Asignar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function mostrarModalCodigo(codigoEstudiante) {
        document.getElementById('codigoEstudiante').value = codigoEstudiante;
        document.getElementById('formCodigo').action = "{{ route('tutor.asignar.codigo', $curso->id) }}";
        document.getElementById('modalCodigo').classList.remove('hidden');
    }

    function cerrarModalCodigo() {
        document.getElementById('modalCodigo').classList.add('hidden');
    }

    document.getElementById('tipoCodigo').addEventListener('change', function() {
        const tipo = this.value;
        const selectCodigo = document.getElementById('selectCodigo');
        const options = selectCodigo.options;
        
        for (let i = 0; i < options.length; i++) {
            if (options[i].dataset.tipo === tipo) {
                options[i].style.display = '';
                if (selectCodigo.selectedIndex === -1) {
                    selectCodigo.selectedIndex = i;
                }
            } else {
                options[i].style.display = 'none';
            }
        }
    });

    // Inicializar mostrando solo los positivos
    document.getElementById('tipoCodigo').dispatchEvent(new Event('change'));
</script>
@endsection