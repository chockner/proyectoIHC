@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h2>Editar Horarios por Turno</h2>

        <form id="editFiltersForm">
            @csrf
            <div class="row mb-4">
                <!-- Especialidad -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="specialty_id" class="form-label">Especialidad:</label>
                        <select name="specialty_id" id="specialty_id" class="form-select" required>
                            <option value="">Seleccione una especialidad</option>
                            @foreach ($specialties as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Médico -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="doctor_id" class="form-label">Médico:</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required disabled>
                            <option value="">Primero seleccione una especialidad</option>
                        </select>
                    </div>
                </div>

                <!-- Turno -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="shift" class="form-label">Turno:</label>
                        <select name="shift" id="shift" class="form-select" required disabled>
                            <option value="">Primero seleccione un médico</option>
                            <option value="MAÑANA">Mañana</option>
                            <option value="TARDE">Tarde</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" id="btnBuscar" class="btn btn-primary" disabled>Buscar Horarios</button>
            </div>
        </form>

        <!-- Formulario de edición (se muestra dinámicamente) -->
        <form id="editHorariosForm" method="POST" action="{{ route('admin.horarios.bulk-update') }}"
            style="display: none;">
            @csrf
            <input type="hidden" name="doctor_id" id="edit_doctor_id">
            <input type="hidden" name="shift" id="edit_shift">

            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="tituloHorarios"></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Hora de Entrada</th>
                                    <th>Hora de Salida</th>
                                </tr>
                            </thead>
                            <tbody id="horariosContainer">
                                <!-- Se llena dinámicamente -->
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.horarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="button" class="btn btn-success" id="btnEdit">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmEditModalLabel">Confirmar Edición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                        <p id="confirmMessage"></p>
                        <div class="alert alert-warning mt-2">
                            Esta acción puede afectar la consistencia de los datos.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancelar
                    </button>
                    <button type="button" id="btnConfirmEdit" class="btn btn-warning">Confirmar Edición</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio para el sonido de alerta -->
    <audio id="alertSound" preload="auto">
        <source src="https://media.geeksforgeeks.org/wp-content/uploads/20190531135120/beep.mp3" type="audio/mpeg">
    </audio>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Cargar médicos cuando se selecciona especialidad
            $('#specialty_id').change(function() {
                const specialtyId = $(this).val();
                $('#doctor_id').empty().prop('disabled', true);
                $('#shift').prop('disabled', true);
                $('#btnBuscar').prop('disabled', true);

                if (!specialtyId) {
                    $('#doctor_id').html('<option value="">Primero seleccione una especialidad</option>');
                    return;
                }

                $.ajax({
                    url: '/admin/horarios/get-doctors/' + specialtyId,
                    type: 'GET',
                    success: function(data) {
                        $('#doctor_id').empty().append(
                            '<option value="">Seleccione un médico</option>');
                        $.each(data, function(key, doctor) {
                            const fullName = doctor.user?.profile?.last_name ||
                                'Nombre no disponible';
                            $('#doctor_id').append(
                                `<option value="${doctor.id}">${fullName}</option>`);
                        });
                        $('#doctor_id').prop('disabled', false);
                    }
                });
            });

            // Habilitar turno cuando se selecciona médico
            $('#doctor_id').change(function() {
                if ($(this).val()) {
                    $('#shift').prop('disabled', false);
                } else {
                    $('#shift').prop('disabled', true);
                    $('#btnBuscar').prop('disabled', true);
                }
            });

            // Habilitar botón buscar cuando se selecciona turno
            $('#shift').change(function() {
                $('#btnBuscar').prop('disabled', !$(this).val());
            });

            // Buscar horarios existentes
            $('#btnBuscar').click(function() {
                const formData = $('#editFiltersForm').serialize();

                $.ajax({
                    url: '/admin/horarios/get-edit-data',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#edit_doctor_id').val($('#doctor_id').val());
                        $('#edit_shift').val($('#shift').val());

                        // Construir título
                        const doctorName = $('#doctor_id option:selected').text();
                        const shift = $('#shift').val();
                        $('#tituloHorarios').text(
                            `Editar horarios de ${doctorName} - Turno ${shift}`);

                        // Construir tabla de horarios
                        $('#horariosContainer').empty();

                        // Verificar si hay horarios
                        if (response.horarios.length === 0) {
                            $('#horariosContainer').append(`
                    <tr>
                        <td colspan="3" class="text-center py-4">
                            <div class="alert alert-info">
                                No hay horarios registrados para este médico y turno.
                                <a href="{{ route('admin.horarios.create') }}" class="alert-link">
                                    ¿Desea crear nuevos horarios?
                                </a>
                            </div>
                        </td>
                    </tr>
                `);
                        } else {
                            // Solo mostrar días con horarios existentes
                            response.horarios.forEach(horario => {
                                const row = `
                        <tr>
                            <td>${horario.day_of_week}</td>
                            <td>
                                <input type="time" name="horarios[${horario.day_of_week}][start_time]" 
                                    class="form-control time-input" value="${horario.start_time}" required>
                                <input type="hidden" name="horarios[${horario.day_of_week}][day_of_week]" value="${horario.day_of_week}">
                                <div class="invalid-feedback">Los minutos deben ser 00</div>
                            </td>
                            <td>
                                <input type="time" name="horarios[${horario.day_of_week}][end_time]" 
                                    class="form-control time-input" value="${horario.end_time}" required>
                                <div class="invalid-feedback">Los minutos deben ser 00</div>
                            </td>
                        </tr>
                    `;
                                $('#horariosContainer').append(row);
                            });

                            // Agregar validación en tiempo real para los campos de tiempo
                            $('.time-input').on('change', function() {
                                validateTimeInput(this);
                            });
                        }

                        $('#editHorariosForm').show();
                    },
                    error: function(xhr) {
                        alert('Error al cargar los horarios. Por favor intente nuevamente.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // Función para validar campos de tiempo (minutos deben ser 00)
            function validateTimeInput(input) {
                const timeValue = $(input).val();
                if (timeValue) {
                    const minutes = timeValue.split(':')[1];
                    if (minutes !== '00') {
                        $(input).addClass('is-invalid');
                        return false;
                    } else {
                        $(input).removeClass('is-invalid');
                        return true;
                    }
                }
                return false;
            }

            // Al hacer clic en el botón Guardar Cambios
            $('#btnEdit').click(function() {
                // Validar todos los campos de tiempo
                let isValid = true;
                $('.time-input').each(function() {
                    if (!validateTimeInput(this)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    alert('Por favor corrija los campos de tiempo. Los minutos deben ser 00.');
                    return;
                }

                // Configurar mensaje en el modal
                const message = '¿Está seguro de que desea editar los horarios de este médico?';
                $('#confirmMessage').text(message);

                // Mostrar modal de confirmación
                const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
                modal.show();

                // Reproducir sonido de alerta
                const alertSound = document.getElementById('alertSound');
                if (alertSound) {
                    alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
                }
            });

            // Confirmar edición desde el modal
            $('#btnConfirmEdit').click(function() {
                // Enviar el formulario
                $('#editHorariosForm').submit();
            });
        });
    </script>
@endpush
