@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Crear Horario de Médico</h2>

    <form method="POST" action="{{ route('admin.horarios.store') }}" id="scheduleForm">
        @csrf

        <!-- Especialidad -->
        <div class="form-group mb-3">
            <label for="specialty_id" class="form-label">Especialidad:</label>
            <select name="specialty_id" id="specialty_id" class="form-select" required>
                <option value="">Seleccione una especialidad</option>
                @foreach($specialties as $specialty)
                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Médico -->
        <div class="form-group mb-3 doctor-field" style="display: none;">
            <label for="doctor_id" class="form-label">Médico:</label>
            <select name="doctor_id" id="doctor_id" class="form-select" required disabled>
                <option value="">Primero seleccione una especialidad</option>
            </select>
        </div>

        <!-- Día -->
        <div class="form-group mb-3 day-field" style="display: none;">
            <label for="day_of_week" class="form-label">Día de la Semana:</label>
            <select name="day_of_week" id="day_of_week" class="form-select" required disabled>
                <option value="">Primero seleccione un médico</option>
                <option value="LUNES">Lunes</option>
                <option value="MARTES">Martes</option>
                <option value="MIERCOLES">Miércoles</option>
                <option value="JUEVES">Jueves</option>
                <option value="VIERNES">Viernes</option>
                <option value="SABADO">Sabado</option>
            </select>
        </div>

        <!-- Turno -->
        <div class="form-group mb-3 shift-field" style="display: none;">
            <label for="shift" class="form-label">Turno:</label>
            <select name="shift" id="shift" class="form-select" required disabled>
                <option value="">Seleccione un turno</option>
                <option value="MAÑANA">Mañana</option>
                <option value="TARDE">Tarde</option>
            </select>
        </div>

        <!-- Horario -->
        <div class="row mb-3 time-fields" style="display: none;">
            <div class="col-md-6">
                <label for="start_time" class="form-label">Hora de Inicio:</label>
                <input type="time" name="start_time" id="start_time" class="form-control" required step="3600">
                <div class="invalid-feedback">Los minutos deben ser 00</div>
            </div>
            <div class="col-md-6">
                <label for="end_time" class="form-label">Hora de Salida:</label>
                <input type="time" name="end_time" id="end_time" class="form-control" required step="3600">
                <div class="invalid-feedback">Los minutos deben ser 00</div>
            </div>
        </div>

        <button type="button" class="btn btn-primary submit-btn" style="display: none;" id="btnShowModal">Guardar</button>
    </form>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmCreateModal" tabindex="-1" aria-labelledby="confirmCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmCreateModalLabel">Confirmar Creación de Horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-calendar-plus fa-3x text-primary mb-3"></i>
                    <p id="confirmMessage">¿Está seguro que desea crear este nuevo horario?</p>
                    <div class="alert alert-primary mt-2">
                        <i class="fas fa-info-circle me-2"></i>
                        Se creará un nuevo horario para el médico seleccionado.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="button" id="btnConfirmCreate" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Crear Horario
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Verificar si jQuery está cargado
    if (typeof jQuery == 'undefined') {
        console.error('jQuery no está cargado');
        alert('Error: jQuery es requerido. Por favor recarga la página.');
        return;
    }

    // 1. Cuando cambia la especialidad
    $('#specialty_id').change(function() {
        const specialtyId = $(this).val();
        $('.doctor-field, .day-field, .shift-field, .time-fields').hide();
        $('#doctor_id, #day_of_week, #shift, #start_time, #end_time').prop('disabled', true);
        $('#btnShowModal').hide().prop('disabled', true);

        if (!specialtyId) return;

        console.log('Especialidad seleccionada:', specialtyId);
        
        $.ajax({
            url: '/admin/horarios/get-doctors/' + specialtyId,
            type: 'GET',
            success: function(data) {
                console.log('Médicos recibidos:', data);
                $('#doctor_id').empty().append('<option value="">Seleccione un médico</option>');
                
                $.each(data, function(key, doctor) {
                    const fullName = doctor.user?.profile?.last_name || 'Nombre no disponible';
                    $('#doctor_id').append(`<option value="${doctor.id}">${fullName}</option>`);
                });
                
                $('.doctor-field').show();
                $('#doctor_id').prop('disabled', false);
            },
            error: function(xhr) {
                console.error('Error al obtener médicos:', xhr.responseText);
                alert('Error al cargar los médicos. Por favor recarga la página.');
            }
        });
    });

    // 2. Cuando cambia el médico
    $('#doctor_id').change(function() {
        $('.day-field').toggle($(this).val() !== '');
        $('#day_of_week').prop('disabled', $(this).val() === '');
        $('.shift-field, .time-fields').hide();
        $('#shift, #start_time, #end_time').prop('disabled', true);
        $('#btnShowModal').prop('disabled', true).hide();
    });

    // 3. Cuando cambia el día
    $('#day_of_week').change(function() {
        $('.shift-field').toggle($(this).val() !== '');
        $('#shift').prop('disabled', $(this).val() === '');
        $('.time-fields').hide();
        $('#start_time, #end_time').prop('disabled', true);
        $('#btnShowModal').prop('disabled', true).hide();
    });

    // 4. Cuando cambia el turno
    $('#shift').change(function() {
        $('.time-fields').toggle($(this).val() !== '');
        $('#start_time, #end_time').prop('disabled', $(this).val() === '');
        $('#btnShowModal').toggle($(this).val() !== '').prop('disabled', $(this).val() === '');
        
        // Sugerir horarios según el turno
        if ($(this).val() === 'MAÑANA') {
            $('#start_time').val('08:00');
            $('#end_time').val('13:00');
        } else if ($(this).val() === 'TARDE') {
            $('#start_time').val('14:00');
            $('#end_time').val('19:00');
        }
        
        // Agregar validadores de tiempo
        $('#start_time, #end_time').on('change', function() {
            validateTimeInput(this);
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

    // Al hacer clic en el botón Guardar (mostrar modal)
    $('#btnShowModal').click(function() {
        // Validar campos de tiempo
        let isValid = true;
        $('#start_time, #end_time').each(function() {
            if (!validateTimeInput(this)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            alert('Por favor corrija los campos de tiempo. Los minutos deben ser 00.');
            return;
        }
        
        // Construir mensaje de confirmación
        const doctor = $('#doctor_id option:selected').text();
        const day = $('#day_of_week option:selected').text();
        const shift = $('#shift option:selected').text();
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();
        
        const message = `¿Crear horario para ${doctor}?<br>
                         Día: ${day}<br>
                         Turno: ${shift}<br>
                         Horario: ${startTime} - ${endTime}`;
        
        $('#confirmMessage').html(message);
        
        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('confirmCreateModal'));
        modal.show();
    });

    // Confirmar creación desde el modal
    $('#btnConfirmCreate').click(function() {
        // Enviar el formulario
        $('#scheduleForm').submit();
    });
});
</script>
@endsection