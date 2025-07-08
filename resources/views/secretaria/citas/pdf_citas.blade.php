<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Citas</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #0d6efd;
            color: white;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
        }

        .bg-warning {
            background-color: #ffc107;
            color: black;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-danger {
            background-color: #dc3545;
            color: white;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Lista de Citas</h2>
    <p style="text-align: center;">Generado el {{ now()->format('d/m/Y') }}</p>

    <div class="contenedor-boton" style="display: flex; justify-content: center; margin-top: 20px;">
        <button class="no-print" onclick="window.print()">Generar PDF</button>
    </div>
    <div class="contenedor-boton" style="display: flex; justify-content: center; margin-top: 20px;">
        {{-- <a href="" >Regresar</a> --}}
        <a class="btn btn-secondary" href="{{ route('secretaria.citas.index') }}" role="button">Regresar</a>

    </div>

    @if ($status || $fecha)
        <p style="text-align: center;">
            <strong>Filtros Aplicados:</strong>
            @if ($status)
                Estado - {{ ucfirst($status) }}
                @if ($fecha)
                    ,
                @endif
            @endif
            @if ($fecha)
                Fecha - {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
            @endif
        </p>
    @else
        <p style="text-align: center;">Sin filtros aplicados</p>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Doctor</th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($citas as $index => $cita)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($cita->doctor->user->profile)->last_name ?? 'No disponible' }}</td>
                    <td>{{ optional($cita->patient->user->profile)->last_name ?? 'No disponible' }}</td>
                    <td>{{ $cita->appointment_date ? \Carbon\Carbon::parse($cita->appointment_date)->format('d/m/Y') : 'No disponible' }}
                    </td>
                    <td>
                        <span
                            class="badge bg-{{ $cita->status === 'programada' ? 'warning' : ($cita->status === 'completada' ? 'success' : 'danger') }}">
                            {{ ucfirst($cita->status ?? 'No disponible') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay citas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function() {
            // Descomentar para mostrar la ventana de impresión automáticamente
            // window.print();
        };
    </script>
</body>

</html>
