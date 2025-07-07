@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Encabezado y Filtros -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="text-2xl font-bold mb-4">Horarios Médicos</h1>
            </div>
        </div>

        <!-- Filtros y Botón Agregar -->
        <div class="row mb-4 align-items-start">
            <div class="col-md-8">
                <div class="card bg-transparent border-0">
                    <div class="card-body py-2 bg-transparent">
                        {{-- Filtros --}}
                        <form method="GET" action="{{ route('admin.horarios.index') }}" class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Especialidad:</label>
                                <select name="specialty_filter" class="form-select">
                                    <option value="">Todas las especialidades</option>
                                    @foreach ($specialties as $specialty)
                                        <option value="{{ $specialty->id }}"
                                            {{ request('specialty_filter') == $specialty->id ? 'selected' : '' }}>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Turno:</label>
                                <select name="shift_filter" class="form-select">
                                    <option value="">Todos los turnos</option>
                                    <option value="MAÑANA" {{ request('shift_filter') == 'MAÑANA' ? 'selected' : '' }}>
                                        Mañana</option>
                                    <option value="TARDE" {{ request('shift_filter') == 'TARDE' ? 'selected' : '' }}>Tarde
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit"
                                    class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                    data-bs-toggle="tooltip" data-bs-title="Buscar">
                                    <div class="relative">
                                        <span class="material-icons text-slate-600">schedule</span>
                                        <span
                                            class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">search</span>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-transparent border-0">
                    <div class="card-body bg-transparent d-flex flex-column align-items-start">
                        <h5 class="card-title font-bold text-gray-800 mb-2">Acciones</h5>
                        <div class="col-md-4 flex justify-end space-x-2">
                            {{-- Botón Agregar --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.horarios.create') }}"
                                    class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                    data-bs-toggle="tooltip" data-bs-title="Agregar">
                                    <div class="relative">
                                        <span class="material-icons text-green-600">schedule</span>
                                        <span
                                            class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-green-100 text-green-600 rounded-full p-0.4">add</span>
                                    </div>
                                </a>
                            </div>
                            {{-- Botón Editar --}}
                            <div class="flex flex-col items-center">
                                <a href="{{ route('admin.horarios.edit-by-filters') }}"
                                    class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                    data-bs-toggle="tooltip" data-bs-title="Editar">
                                    <div class="relative">
                                        <span class="material-icons text-orange-500">schedule</span>
                                        <span
                                            class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-orange-100 text-orange-600 rounded-full p-0.4">edit</span>
                                    </div>
                                </a>
                            </div>
                            {{-- Botón Eliminar --}}
                            <div class="flex flex-col items-center">
                                <form action="{{ route('admin.horarios.delete-by-filters') }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                        data-form-id="form-horarios-delete" data-bs-toggle="tooltip"
                                        data-bs-title="Eliminar">
                                        <div class="relative">
                                            <span class="material-icons text-red-600">schedule</span>
                                            <span
                                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-red-100 text-red-600 rounded-full p-0.4">delete_outline</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Horarios -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        @foreach (['MAÑANA', 'TARDE'] as $turno)
                            <div class="turno-section mb-4">
                                <h5 class="p-3 bg-light mb-0">Turno {{ $turno }}</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center" style="width: 100px;">Hora</th>
                                                @foreach ($days as $day)
                                                    <th class="text-center">{{ $day }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hours[$turno] as $hour)
                                                <tr>
                                                    <td class="text-center fw-bold bg-light">
                                                        {{ $hour }}</td>
                                                    @foreach ($days as $day)
                                                        <td style="min-width: 200px;">
                                                            @php
                                                                $currentHour = strtotime($hour);
                                                                $matchingSchedules = $schedules->filter(function (
                                                                    $schedule,
                                                                ) use ($day, $currentHour, $turno) {
                                                                    return $schedule->day_of_week == $day &&
                                                                        $schedule->shift == $turno &&
                                                                        strtotime($schedule->start_time) <=
                                                                            $currentHour &&
                                                                        strtotime($schedule->end_time) > $currentHour;
                                                                });
                                                            @endphp

                                                            @foreach ($matchingSchedules as $schedule)
                                                                <div
                                                                    class="schedule-item mb-2 p-2 rounded position-relative">
                                                                    <div class="d-flex justify-content-between">
                                                                        <strong class="text-primary">
                                                                            {{ $schedule->doctor->user->profile->last_name ?? 'Sin nombre' }}
                                                                        </strong>
                                                                        <span class="badge bg-info text-dark">
                                                                            {{ $schedule->doctor->specialty->name ?? 'Sin especialidad' }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="text-end small text-muted">
                                                                        {{ substr($schedule->start_time, 0, 5) }}
                                                                        -
                                                                        {{ substr($schedule->end_time, 0, 5) }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Delegación de eventos para todos los botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            // Obtener el formulario específico para este paciente
            const form = $(this).closest('form');

            // Configurar mensaje
            const message = `
            ¿Está seguro que desea eliminar este horario?
            Esta acción no se puede deshacer.
        `;
            $('#confirmMessage').html(message);

            // Guardar referencia al formulario en el modal
            $('#confirmDeleteModal').data('delete-form', form);

            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();

            // Reproducir sonido
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir sonido:', e));
            }
        });

        // Confirmar eliminación
        $('#btnConfirmDelete').click(function() {
            // Recuperar el formulario guardado
            const form = $('#confirmDeleteModal').data('delete-form');

            // Enviar el formulario específico
            if (form) {
                form.submit();
            }
        });
    </script>
@endsection
