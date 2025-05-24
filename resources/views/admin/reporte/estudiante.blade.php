<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Trimestral {{ $estudiante->nombres }} {{ $estudiante->apellidos }}</title>
    <style>
        /* body { font-family: DejaVu Sans, sans-serif; }
        h1, h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f0f0f0; } */

          body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .info { margin-bottom: 20px; }
        .semaforo { 
            width: 70px; 
            height: 70px; 
            border-radius: 50%; 
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .azul { background-color: #3b82f6; }
        .verde { background-color: #10b981; }
        .amarillo { background-color: #f59e0b; }
        .rojo { background-color: #ef4444; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
     <div class="header">
        <h1>UNIVERSIDAD DON BOSCO</h1>
        <h2>Reporte de Trimestre #{{ $trimestre }}</h2>
    </div>

    <div class="info">
        <p><strong>Tutor:</strong> {{ $curso->tutor->nombres }} {{ $curso->tutor->apellidos }}</p>
        <p><strong>Grupo:</strong> {{ $curso->nombre_curso }}</p>
        <p><strong>Estudiante:</strong> {{ $estudiante->nombres }} {{ $estudiante->apellidos }}</p>
        <p><strong>Carnet:</strong> {{ $estudiante->codigo_estudiante }}</p>
    </div>
     <div class="semaforo {{ $semaforo }}">
        @switch($semaforo)
            @case('azul') @break
            @case('verde') @break
            @case('amarillo') @break
            @case('rojo') @break
        @endswitch
    </div>

    <h3>Aspectos positivos</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aspectosPositivos as $index => $aspecto)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($aspecto->fecha)->format('d/m/Y') }}</td>
                <td>{{ $aspecto->codigo->nombre }}</td>
            </tr>
            @endforeach
            @if($aspectosPositivos->isEmpty())
            <tr>
                <td colspan="3">No hay aspectos positivos registrados</td>
            </tr>
            @endif
        </tbody>
    </table>

    <h3>Aspectos a mejorar</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $todosAspectos = $aspectosLeves->concat($aspectosGraves)->concat($aspectosMuyGraves)->sortBy('fecha');
            @endphp
            @foreach($todosAspectos as $index => $aspecto)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($aspecto->fecha)->format('d/m/Y') }}</td>
                <td>{{ $aspecto->codigo->nombre }}</td>
                <td>
                    @switch($aspecto->codigo->tipo)
                        @case('L') Leve @break
                        @case('G') Grave @break
                        @case('MG') Muy Grave @break
                    @endswitch
                </td>
            </tr>
            @endforeach
            @if($todosAspectos->isEmpty())
            <tr>
                <td colspan="4">No hay aspectos a mejorar registrados</td>
            </tr>
            @endif
        </tbody>
    </table>

    <h3>Registro de Inasistencia</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inasistencias as $index => $inasistencia)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $inasistencia->fecha->format('d/m/Y') }}</td>
                <td>
                    @switch($inasistencia->tipo)
                        @case('A') Asistió @break
                        @case('I') Inasistencia @break
                        @case('J') Justificada @break
                    @endswitch
                </td>
            </tr>
            @endforeach
            @if($inasistencias->isEmpty())
            <tr>
                <td colspan="3">No hay inasistencias registradas</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Aquí agrega más secciones como aspectos positivos, inasistencias, semáforo, etc. -->

</body>
</html>
