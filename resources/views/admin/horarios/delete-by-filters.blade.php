@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Eliminar Horarios por Turno</h2>

    <form id="deleteFiltersForm">
        @csrf
        <div class="row mb-4">
            <!-- Especialidad -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="specialty_id" class="form-label">Especialidad:</label>
                    <select name="specialty_id" id="specialty_id" class="form-select" required>
                        <option value="">Seleccione una especialidad</option>
                        @foreach($specialties as $specialty)
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
            <button type="button" id="btnBuscar" class="btn btn-primary" disabled>
                <i class="fas fa-search me-2"></i> Buscar Horarios
            </button>
        </div>
    </form>

    <!-- Formulario de eliminación -->
    <form id="deleteHorariosForm" method="POST" action="{{ route('admin.horarios.bulk-delete') }}" style="display: none;">
        @csrf
        <input type="hidden" name="doctor_id" id="delete_doctor_id">
        <input type="hidden" name="shift" id="delete_shift">

        <div class="card mt-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0" id="tituloHorarios"></h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Seleccione los horarios que desea eliminar. Esta acción no se puede deshacer.
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Día</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="horariosContainer">
                            <!-- Se llena dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.horarios.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i> Eliminar Seleccionados
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
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
                $('#doctor_id').empty().append('<option value="">Seleccione un médico</option>');
                $.each(data, function(key, doctor) {
                    const fullName = doctor.user?.profile?.last_name || 'Nombre no disponible';
                    $('#doctor_id').append(`<option value="${doctor.id}">${fullName}</option>`);
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
        const formData = $('#deleteFiltersForm').serialize();
        
        $.ajax({
            url: '/admin/horarios/get-delete-data',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#delete_doctor_id').val($('#doctor_id').val());
                $('#delete_shift').val($('#shift').val());
                
                // Construir título
                const doctorName = $('#doctor_id option:selected').text();
                const shift = $('#shift').val();
                $('#tituloHorarios').text(`Eliminar horarios de ${doctorName} - Turno ${shift}`);
                
                // Construir tabla de horarios
                $('#horariosContainer').empty();
                
                if (response.horarios.length === 0) {
                    $('#horariosContainer').append(`
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="alert alert-info">
                                    No hay horarios registrados para este médico y turno.
                                </div>
                            </td>
                        </tr>
                    `);
                } else {
                    response.horarios.forEach(horario => {
                        const row = `
                            <tr>
                                <td>${horario.day_of_week}</td>
                                <td>${horario.start_time}</td>
                                <td>${horario.end_time}</td>
                                <td class="text-center">
                                    <input type="checkbox" name="horarios[]" value="${horario.id}" class="form-check-input">
                                </td>
                            </tr>
                        `;
                        $('#horariosContainer').append(row);
                    });
                }
                
                $('#deleteHorariosForm').show();
            },
            error: function(xhr) {
                alert('Error al cargar los horarios. Por favor intente nuevamente.');
                console.error(xhr.responseText);
            }
        });
    });

    // Al enviar el formulario de eliminación
    $('#deleteHorariosForm').submit(function(e) {
        // Verificar si hay horarios seleccionados
        const selectedCount = $('input[name="horarios[]"]:checked').length;
        
        if (selectedCount === 0) {
            alert('Por favor seleccione al menos un horario para eliminar.');
            e.preventDefault();
            return;
        }

        // Confirmar con el usuario
        if (!confirm('¿Está seguro que desea eliminar los ' + selectedCount + ' horarios seleccionados? Esta acción no se puede deshacer.')) {
            e.preventDefault();
        }
    });    
});
</script>
@endsection