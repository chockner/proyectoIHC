@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">EDITAR CITA</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.historialMedico.update_detail', $historial->id) }}" method="POST" id="editHistorialForm"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN BASICA</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <input id="doctor_nombre" type="text" class="form-control disabled-field"
                            value="{{ $historial->appointment->doctor->user->profile->last_name ?? '' }} {{ $historial->appointment->doctor->user->profile->first_name ?? '' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Especialidad</label>
                        <input id="especialidad_id" type="text" class="form-control disabled-field"
                            value="{{ $historial->appointment->doctor->specialty->name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Paciente</label>
                        <input id="nombre_paciente" type="text" class="form-control disabled-field"
                            value="{{ $historial->appointment->patient->user->profile->last_name ?? '' }} {{ $historial->appointment->patient->user->profile->first_name ?? '' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha y Hora</label>
                        <input id="fechayhora" type="text" class="form-control disabled-field"
                            value="{{ $historial->appointment->appointment_date ?? '' }} | {{ $historial->appointment->appointment_time ?? '' }}"
                            disabled>
                    </div>
                </div>

            </div>
            <hr>

            <div class="row mt-4 justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card bg-transparent border-0">
                        <div class="card-body">
                            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE LA CITA</h5>
                            <div class="row g-3">
                                <!-- Diagnóstico -->
                                <div class="col-12 mb-3">
                                    <label for="diagnosis" class="form-label fw-bold">Diagnóstico</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="10">{{ $historial->diagnosis ?? '' }}</textarea>
                                </div>
                                <hr>
                                <!-- Tratamiento -->
                                <div class="col-12 mb-3">
                                    <label for="treatment" class="form-label fw-bold">Tratamiento</label>
                                    <textarea name="treatment" id="treatment" class="form-control" rows="10">{{ $historial->treatment ?? '' }}</textarea>
                                </div>
                                <hr>
                                <!-- Notas -->
                                <div class="col-12 mb-3">
                                    <label for="notes" class="form-label fw-bold">Notas</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="10">{{ $historial->notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="{{ route('admin.historialMedico.show', $historial->id) }}"
                        class="btn btn-outline-secondary">Cancelar</a>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-success" id="btnEdit">Guardar Cambios</button>
                </div>
            </div>
        </form>

        <!-- Modal de confirmación -->
        <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="confirmEditModalLabel">Confirmar Edición</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <p id="confirmMessage"></p>
                            <div class="alert alert-warning mt-2">
                                Esta acción puede afectar la consistencia de los datos.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnConfirmEdit" class="btn btn-warning">Confirmar Edición</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio para el sonido de alerta -->
        <audio id="alertSound" preload="auto">
            <source src="https://media.geeksforgeeks.org/wp-content/uploads/20190531135120/beep.mp3" type="audio/mpeg">
        </audio>
    </div>
@endsection
@push('scripts')
    <script>
        // Validación del formulario y modal de confirmación
        $('#btnEdit').click(function() {
            // Validar el formulario
            if (!$('#editHistorialForm')[0].checkValidity()) {
                $('#editHistorialForm')[0].reportValidity();
                return;
            }

            // Construir el mensaje de confirmación
            const message = `
            <strong>Datos de la Cita:</strong><br>
            Doctor: ${$('#doctor_nombre').val()}<br>
            Paciente: ${$('#nombre_paciente').val()}<br>
            Especialidad: ${$('#especialidad_id').val()}<br>
            Fecha y Hora: ${$('#fechayhora').val()}<br>
            Diagnóstico: ${$('#diagnosis').val()}<br>
            Tratamiento: ${$('#treatment').val()}<br>
            Notas: ${$('#notes').val()}<br>
        `;
            $('#confirmMessage').html(message);

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();

            // Reproducir el sonido de alerta
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
            }
        });

        // Confirmar edición desde el modal
        $('#btnConfirmEdit').click(function() {
            $('#editHistorialForm').submit();
        });
    </script>
@endpush
