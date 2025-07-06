@extends('layouts.dashboard')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="progress">
                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="step">
                    <h4>Pasos para registrar la cita médica</h4>

                    {{-- Primer formulario: turno, especialidad, médico --}}
                    <form id="paso1Form">
                        @csrf
                        <div class="row mb-4">
                            <!-- Turno -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shift" class="form-label">Turno:</label>
                                    <select name="shift" id="shift" class="form-select" required>
                                        <option value="">Seleccione un turno</option>
                                        <option value="MAÑANA" {{ old('shift') == 'MAÑANA' ? 'selected' : '' }}>Mañana
                                        </option>
                                        <option value="TARDE" {{ old('shift') == 'TARDE' ? 'selected' : '' }}>Tarde
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Especialidad -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="specialty_id" class="form-label">Especialidad:</label>
                                    <select name="specialty_id" id="specialty_id" class="form-select" required disabled>
                                        <option value="">Primero seleccione un turno</option>
                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}"
                                                {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                                {{ $specialty->name }}
                                            </option>
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
                        </div>

                        {{-- Botón Siguiente, inicialmente bloqueado --}}
                        <div class="d-flex justify-content-center">
                            <button type="button" id="btnPaso2" class="btn btn-primary" disabled>Siguiente</button>
                        </div>
                    </form>

                    {{-- Segundo formulario: seleccionar fecha y hora --}}
                    <form id="paso2Form" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha" class="form-label">Fecha de cita:</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora" class="form-label">Hora de cita:</label>
                                    <select id="hora" name="hora" class="form-select" required disabled>
                                        <option value="">Seleccione una hora</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{-- Botón Atrás --}}
                            <button type="button" id="btnAtras1" class="btn btn-secondary">Atrás</button>

                            {{-- Botón Siguiente --}}
                            <button type="button" id="btnPaso3" class="btn btn-primary">Siguiente</button>
                        </div>
                    </form>

                    {{-- Tercer formulario: método de pago y foto de comprobante --}}
                    <form id="paso3Form" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="metodo_pago" class="form-label">Método de pago:</label>
                                    <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                        <option value="">Seleccione un método de pago</option>
                                        <option value="Yape">Yape</option>
                                        <option value="Plin">Plin</option>
                                        <option value="efectivo">Efectivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="comprobante" class="form-label">Subir comprobante de pago:</label>
                                    <input type="file" id="comprobante" name="comprobante" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{-- Botón Atrás --}}
                            <button type="button" id="btnAtras2" class="btn btn-secondary">Atrás</button>
                            <button type="submit" class="btn btn-success">Confirmar cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Deshabilitar el botón "Siguiente" al inicio
            let isFormComplete = false;
            let doctorSchedules = [];
            let selectedHours = []; // Para almacenar las horas ya seleccionadas

            // Obtener los horarios del doctor
            function getDoctorSchedules() {
                const doctorId = $('#doctor_id').val();
                const shift = $('#shift').val(); // Obtener el turno seleccionado

                if (doctorId && shift) {
                    $.ajax({
                        url: '/paciente/agendar-cita/horarios/get-schedules/' + doctorId + '/' + shift,
                        type: 'GET',
                        success: function(data) {
                            doctorSchedules = data.schedules; // Guardamos los horarios
                            console.log('Horarios del doctor:', doctorSchedules); // Log de los horarios
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al obtener los horarios:', error);
                        }
                    });
                }
            }

            function formatTime(timeString) {
                const time = new Date(timeString);
                const hours = time.getHours();
                const minutes = time.getMinutes();
                return `${hours}:${minutes < 10 ? '0' + minutes : minutes}`; // Formato 08:00
            }

            const daysOfWeek = [
                "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO", "DOMINGO"
            ];

            // Generar las horas disponibles en rangos de 30 minutos
            function generateAvailableHours(startTime, endTime) {
                let availableHours = [];

                // Convertir las horas de string (HH:mm) a Date
                let start = startTime.split(':');
                let end = endTime.split(':');

                let startDate = new Date();
                startDate.setHours(parseInt(start[0]), parseInt(start[1]), 0, 0); // Hora de inicio

                let endDate = new Date();
                endDate.setHours(parseInt(end[0]), parseInt(end[1]), 0, 0); // Hora de fin

                // Generar intervalos de 30 minutos
                while (startDate < endDate) {
                    let hours = startDate.getHours().toString().padStart(2, '0');
                    let minutes = startDate.getMinutes().toString().padStart(2, '0');
                    availableHours.push(`${hours}:${minutes}`);
                    startDate.setMinutes(startDate.getMinutes() + 30); // Incrementa en 30 minutos
                }

                return availableHours;
            }

            // Verificar si la fecha seleccionada es válida para el doctor
            function validateDate() {
                const fecha = $('#fecha').val(); // La fecha seleccionada por el usuario

                const dayOfWeekIndex = new Date(fecha).getDay(); // 0 - Domingo, 1 - Lunes, ..., 6 - Sábado

                // Convertir el índice del día al nombre del día en español
                const selectedDay = daysOfWeek[dayOfWeekIndex];
                // Log del día seleccionado

                // Verificar si el día seleccionado está en los horarios del doctor
                const isValidDay = doctorSchedules.some(schedule => schedule.day_of_week === selectedDay);

                console.log('Día válido:', isValidDay); // Log de la validación
                return isValidDay;
            }

            // Actualiza el estado del botón "Siguiente" y la barra de progreso
            function updateNextButtonState() {
                const shift = $('#shift').val();
                const specialtyId = $('#specialty_id').val();
                const doctorId = $('#doctor_id').val();
                const fecha = $('#fecha').val(); // Fecha seleccionada
                const hora = $('#hora').val(); // Hora seleccionada

                if (shift && specialtyId && doctorId) {
                    $('#btnPaso2').prop('disabled', false);
                } else {
                    $('#btnPaso2').prop('disabled', true);
                }
                if (fecha && hora) {
                    $('#btnPaso3').prop('disabled', false);
                } else {
                    $('#btnPaso3').prop('disabled', true);
                }
            }

            // Cambios en el turno
            $('#shift').change(function() {
                const shift = $(this).val();
                if (shift) {
                    $('#specialty_id').prop('disabled', false);
                    $('#doctor_id').prop('disabled', true).empty().append(
                        '<option value="">Seleccione un médico</option>');
                    updateNextButtonState();
                } else {
                    $('#specialty_id').prop('disabled', true);
                    $('#doctor_id').prop('disabled', true).empty().append(
                        '<option value="">Seleccione un turno primero</option>');
                    updateNextButtonState();
                }
            });

            // Cambios en la especialidad
            $('#specialty_id').change(function() {
                const specialtyId = $(this).val();
                const shift = $('#shift').val();

                if (specialtyId && shift) {
                    $.ajax({
                        url: '/paciente/agendar-cita/horarios/get-doctors/' + specialtyId + '/' +
                            shift,
                        type: 'GET',
                        success: function(data) {
                            $('#doctor_id').empty().append(
                                '<option value="">Seleccione un médico</option>');
                            $.each(data, function(key, doctor) {
                                const fullName = doctor.user?.profile?.last_name ||
                                    'Nombre no disponible';
                                $('#doctor_id').append(
                                    `<option value="${doctor.id}">${fullName}</option>`
                                );
                            });
                            $('#doctor_id').prop('disabled', false);
                            updateNextButtonState();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al cargar los médicos:', error);
                        }
                    });
                } else {
                    $('#doctor_id').prop('disabled', true).empty().append(
                        '<option value="">Seleccione un turno y especialidad primero</option>');
                    updateNextButtonState();
                }
            });

            // Selección de fecha y validación
            // Cambios en la selección de fecha
            $('#fecha').change(function() {
                console.log('Fecha seleccionada:', $('#fecha').val()); // Log de la fecha seleccionada

                // Asegurarnos de que los horarios estén cargados antes de validar la fecha
                const doctorId = $('#doctor_id').val();
                const shift = $('#shift').val(); // Obtener el turno seleccionado

                if (doctorId && shift) {
                    // Llamamos a la función getDoctorSchedules para obtener los horarios antes de validar la fecha
                    getDoctorSchedules();

                    // Esperamos un poco para asegurarnos de que los datos estén cargados
                    setTimeout(function() {
                        const isValid = validateDate(); // Validamos la fecha seleccionada

                        if (isValid) {
                            // Si es válida, mostramos las horas disponibles
                            $('#hora').empty().append(
                                '<option value="">Seleccione una hora</option>');
                            $('#hora').prop('disabled', false); // Habilitamos el campo de hora

                            // Limpiar las horas ya seleccionadas
                            selectedHours = [];

                            // Encontrar el horario correspondiente al día seleccionado
                            const selectedDate = new Date($('#fecha').val());
                            const selectedDay = daysOfWeek[selectedDate.getDay()];

                            // Filtrar los horarios para el día seleccionado
                            const selectedSchedule = doctorSchedules.filter(schedule => schedule
                                .day_of_week === selectedDay);

                            if (selectedSchedule.length > 0) {
                                // Generar las horas disponibles por cada intervalo de horarios del día
                                selectedSchedule.forEach(schedule => {
                                    const availableHours = generateAvailableHours(schedule
                                        .start_time, schedule.end_time);

                                    // Agregar las horas disponibles al select de horas
                                    availableHours.forEach(hour => {
                                        if (!selectedHours.includes(
                                                hour
                                            )) { // Validar que la hora no haya sido seleccionada previamente
                                            $('#hora').append(
                                                `<option value="${hour}">${hour}</option>`
                                            );
                                        }
                                    });
                                });
                            }
                        } else {
                            // Si no es válida, mostramos el mensaje de error
                            alert('La fecha seleccionada no es válida para el médico.');
                            $('#hora').prop('disabled', true); // Deshabilitamos el campo de hora
                        }
                        updateNextButtonState(); // Actualizamos el estado del botón
                    }, 500); // Esperamos medio segundo para asegurar que los horarios estén cargados
                } else {
                    alert('Por favor, selecciona un médico y turno primero.');
                }
            });

            // Cuando se selecciona una hora, la agregamos a las horas ya seleccionadas
            $('#hora').change(function() {
                const selectedHour = $(this).val();
                if (selectedHour && !selectedHours.includes(selectedHour)) {
                    selectedHours.push(selectedHour); // Agregar la hora seleccionada al array
                }
                updateNextButtonState(); // Actualizamos el estado del botón "Siguiente"
            });


            // Cambios en el médico
            $('#doctor_id').change(function() {
                updateNextButtonState();
            });

            // Avanzar al siguiente formulario
            $('#btnPaso2').click(function() {
                // Mostrar el formulario de fecha y hora
                $('#paso2Form').show();

                // Bloquear el formulario anterior
                $('#paso1Form input, #paso1Form select').prop('disabled', true);

                // Actualizar barra de progreso solo cuando se hace clic en "Siguiente"
                $('#progressBar').css('width', '50%').attr('aria-valuenow', 50).text('50%');

                // Ocultar el formulario actual (paso 1)
                /* $('#paso1Form').hide(); */
                $('#btnPaso2').hide();
            });

            // Volver al formulario anterior
            $('#btnAtras1').click(function() {
                // Mostrar el formulario de turno, especialidad y médico
                $('#paso1Form').show();

                // Ocultar el formulario de fecha y hora
                $('#paso2Form').hide();

                // Bloquear el formulario de turno, especialidad y médico
                $('#paso1Form input, #paso1Form select').prop('disabled', false);

                // Actualizar barra de progreso
                $('#progressBar').css('width', '25%').attr('aria-valuenow', 25).text('25%');

                $('#btnPaso2').show();
            });

            $('#btnAtras2').click(function() {
                // Mostrar el formulario de turno, especialidad y médico
                $('#paso2Form').show();
                $('#btnAtras1').show();

                // Ocultar el formulario de fecha y hora
                $('#paso3Form').hide();

                // Bloquear el formulario de turno, especialidad y médico
                $('#paso2Form input, #paso2Form select').prop('disabled', false);

                // Actualizar barra de progreso
                $('#progressBar').css('width', '50%').attr('aria-valuenow', 50).text('50%');

                $('#btnPaso3').show();
            });

            $('#btnAtras3')

            // Confirmar el pago y foto de comprobante
            $('#btnPaso3').click(function() {
                $('#paso3Form').show();
                $('#paso2Form').show();
                $('#btnPaso3').hide();
                $('#btnAtras1').hide();
                $('#progressBar').css('width', '75%').attr('aria-valuenow', 75).text('75%');
            });
        });
    </script>
@endsection
