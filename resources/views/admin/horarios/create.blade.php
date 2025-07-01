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
            </div>
            <div class="col-md-6">
                <label for="end_time" class="form-label">Hora de Salida:</label>
                <input type="time" name="end_time" id="end_time" class="form-control" required step="3600">
            </div>
        </div>

        <button type="submit" class="btn btn-primary submit-btn" style="display: none;" disabled>Guardar</button>
    </form>
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
        $('.submit-btn').hide().prop('disabled', true);

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
        $('.shift-field, .time-fields, .submit-btn').hide();
        $('#shift, #start_time, #end_time').prop('disabled', true);
        $('.submit-btn').prop('disabled', true);
    });

    // 3. Cuando cambia el día
    $('#day_of_week').change(function() {
        $('.shift-field').toggle($(this).val() !== '');
        $('#shift').prop('disabled', $(this).val() === '');
        $('.time-fields, .submit-btn').hide();
        $('#start_time, #end_time').prop('disabled', true);
        $('.submit-btn').prop('disabled', true);
    });

    // 4. Cuando cambia el turno
    $('#shift').change(function() {
        $('.time-fields').toggle($(this).val() !== '');
        $('#start_time, #end_time').prop('disabled', $(this).val() === '');
        $('.submit-btn').toggle($(this).val() !== '').prop('disabled', $(this).val() === '');
        
        // Sugerir horarios según el turno
        if ($(this).val() === 'MAÑANA') {
            $('#start_time').val('08:00');
            $('#end_time').val('13:00');
        } else if ($(this).val() === 'TARDE') {
            $('#start_time').val('14:00');
            $('#end_time').val('19:00');
        }
    });
});
</script>
@endsection