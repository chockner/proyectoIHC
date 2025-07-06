@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 mt-4">
                <div class="step">
                    <h4>Pasos para registrar la cita médica</h4>
                    <p>Segundo paso, elige la fecha y hora para la cita</p>

                    <p>Turno: {{ $shift }}</p>
                    <p>Especialidad: {{ $specialtyId }}</p>
                    <p>Médico: {{ $doctorId }}</p>

                    {{-- Aquí podrías agregar más lógica para elegir la fecha y hora --}}


                    {{-- Formulario para seleccionar la fecha y la hora --}}
                    <!-- Fecha -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="form-label">Fecha:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time" class="form-label">Hora:</label>
                            <select name="time" id="time" class="form-select" required disabled>
                                <option value="">Seleccione una fecha primero</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de navegación --}}
            <div class="col-12 text-center mt-4">
                <a href="{{ route('paciente.agendarCita.create') }}" class="btn btn-secondary">
                    Atrás
                </a>

                <button type="submit" class="btn btn-primary">
                    Siguiente
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Cargar horas disponibles cuando se seleccione la fecha
            $('#date').change(function() {
                const doctorId =
                    {{ session('datos_cita.doctor_id') }}; // Obtenemos el doctor seleccionado de la sesión
                const shift =
                    '{{ session('datos_cita.shift') }}'; // Obtenemos el turno seleccionado de la sesión
                const date = $(this).val(); // Obtenemos la fecha seleccionada

                if (doctorId && date) {
                    // Hacemos la llamada AJAX para obtener las horas disponibles
                    $.ajax({
                        url: '/paciente/agendar-cita/horarios/get-available-times/' + doctorId +
                            '/' + shift + '/' + date,
                        type: 'GET',
                        success: function(data) {
                            $('#time').empty().append(
                                '<option value="">Seleccione una hora</option>');
                            $.each(data, function(key, timeSlot) {
                                $('#time').append(
                                    `<option value="${timeSlot}">${timeSlot}</option>`
                                );
                            });
                            $('#time').prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al cargar las horas: ', error);
                        }
                    });
                } else {
                    $('#time').prop('disabled', true).empty().append(
                        '<option value="">Seleccione una fecha primero</option>');
                }
            });
        });
    </script>
@endsection
