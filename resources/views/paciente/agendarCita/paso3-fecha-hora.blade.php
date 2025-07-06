@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reservar Cita Médica</h1>
        <h2 class="text-lg sm:text-xl font-semibold text-blue-600 mb-6">
            Paso 3 de 4: Seleccione Fecha y Hora para su cita con
            <span class="text-blue-700">Dr. {{ $medico->user->profile->first_name ?? 'Médico' }}
                {{ $medico->user->profile->last_name ?? '' }}</span>
        </h2>

        <!-- Barra de progreso -->
        <div class="mb-8">
            <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-blue-600" style="width: 75%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span>Especialidad</span>
                <span>Médico</span>
                <span class="font-semibold text-blue-600">Fecha y Hora</span>
                <span>Confirmar</span>
            </div>
        </div>

        <!-- Información del médico seleccionado -->
        <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center gap-4">
                @if ($medico->user->profile && $medico->user->profile->profile_photo)
                    <img alt="Foto del {{ $medico->user->profile->first_name }} {{ $medico->user->profile->last_name }}"
                        class="h-12 w-12 rounded-full object-cover"
                        src="{{ asset('storage/' . $medico->user->profile->profile_photo) }}" />
                @else
                    <span class="material-icons text-4xl text-gray-400 bg-gray-100 rounded-full p-2">person_outline</span>
                @endif
                <div>
                    <p class="text-sm text-gray-700">Médico seleccionado:</p>
                    <p class="text-lg font-semibold text-blue-700">
                        Dr. {{ $medico->user->profile->first_name ?? 'Médico' }}
                        {{ $medico->user->profile->last_name ?? '' }} - {{ $especialidad->name }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario de fecha y hora -->
        <form action="{{ route('paciente.agendarCita.confirmacion') }}" method="POST" id="fechaHoraForm">
            @csrf
            <input type="hidden" name="specialty_id" value="{{ $especialidad->id }}">
            <input type="hidden" name="doctor_id" value="{{ $medico->id }}">
            <input type="hidden" name="schedule_id" id="selectedScheduleId" value="{{ $selectedScheduleId }}">
            <input type="hidden" name="appointment_date" id="selectedDate" value="{{ $selectedDate }}">
            <input type="hidden" name="appointment_time" id="selectedTime" value="{{ $selectedTime }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Calendario -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <button type="button" class="p-2 rounded-full hover:bg-gray-100 text-gray-600" id="prevMonth">
                            <span class="material-icons">chevron_left</span>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-700" id="currentMonthYear"></h3>
                        <button type="button" class="p-2 rounded-full hover:bg-gray-100 text-gray-600" id="nextMonth">
                            <span class="material-icons">chevron_right</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-500 mb-2">
                        <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sá</span><span>Do</span>
                    </div>

                    <div class="grid grid-cols-7 gap-1" id="calendarGrid"></div>
                    
                    <!-- Leyenda del calendario -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-600">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-green-100 border border-green-300 rounded"></div>
                                <span>Disponible</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-blue-100 border border-blue-300 rounded"></div>
                                <span>Hoy</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-gray-100 border border-gray-300 rounded"></div>
                                <span>No disponible</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horarios disponibles -->
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Horarios Disponibles</h3>
                    <p class="text-sm text-blue-600 mb-4" id="selectedDateText">Seleccione una fecha para ver los horarios.
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3" id="timeSlotsContainer">
                        <!-- Los horarios se cargarán dinámicamente -->
                    </div>
                </div>
            </div>

            <!-- Botones de navegación -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-3">
                <a href="{{ route('paciente.agendarCita.seleccionarMedicoPreservado') }}"
                    class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                    Anterior
                </a>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('paciente.agendarCita.limpiarSesion') }}"
                        class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                        Cancelar
                    </a>
                                            <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors duration-150"
                            {{ $selectedDate && $selectedTime ? '' : 'disabled' }} id="nextButton">
                            Siguiente
                        </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function() {
                let currentDate = new Date();
                let selectedDate = null;
                let selectedTime = null;
                let selectedScheduleId = null;

                // Valores preservados de la sesión
                const preservedDate = '{{ $selectedDate }}';
                const preservedTime = '{{ $selectedTime }}';
                const preservedScheduleId = '{{ $selectedScheduleId }}';

                // Días de la semana en español (0 = Domingo, 1 = Lunes, etc.)
                const diasSemana = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
                const diasCortos = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'];

                // Horarios del médico
                const horarios = @json($horarios);

                // Citas existentes
                const citasExistentes = @json($citasExistentes);

                function initCalendar() {
                    updateCalendar();
                }

                function updateCalendar() {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();

                    document.getElementById('currentMonthYear').textContent =
                        new Date(year, month).toLocaleDateString('es-ES', {
                            month: 'long',
                            year: 'numeric'
                        });

                    const firstDay = new Date(year, month, 1);
                    let startDay = firstDay.getDay(); // 0=domingo, 1=lunes, ..., 6=sábado
                    if (startDay === 0) startDay = 7; // Para que domingo sea 7
                    const startDate = new Date(firstDay);
                    startDate.setDate(startDate.getDate() - (startDay - 1)); // Siempre inicia en lunes

                    const calendarGrid = document.getElementById('calendarGrid');
                    calendarGrid.innerHTML = '';

                    console.log('Actualizando calendario para:', year, month);
                    console.log('Horarios disponibles:', horarios);

                    // Generar 6 semanas (42 días) para el calendario
                    for (let i = 0; i < 42; i++) {
                        const date = new Date(startDate);
                        date.setDate(startDate.getDate() + i);

                        const dayElement = document.createElement('div');
                        dayElement.className = 'p-2 text-center text-sm cursor-pointer rounded-lg';
                        dayElement.setAttribute('data-date', date.toISOString().split('T')[0]);

                        // Solo mostrar días del mes actual
                        if (date.getMonth() === month) {
                            const isToday = date.toDateString() === new Date().toDateString();
                            const isPast = date < new Date().setHours(0, 0, 0, 0);
                            const hasSchedule = checkIfDateHasSchedule(date);

                            dayElement.textContent = date.getDate();

                            if (isToday) {
                                dayElement.classList.add('bg-blue-100', 'text-blue-700', 'font-semibold');
                            } else if (isPast) {
                                dayElement.classList.add('text-gray-300', 'cursor-not-allowed');
                            } else if (hasSchedule) {
                                dayElement.classList.add('bg-green-50', 'text-green-700', 'hover:bg-green-100', 'calendar-day', 'available');
                                dayElement.addEventListener('click', () => selectDate(date));
                            } else {
                                dayElement.classList.add('text-gray-500', 'cursor-not-allowed');
                            }
                        } else {
                            // Días de otros meses
                            dayElement.textContent = date.getDate();
                            dayElement.classList.add('text-gray-300');
                        }

                        calendarGrid.appendChild(dayElement);
                    }
                }

                function checkIfDateHasSchedule(date) {
                    const dayOfWeek = diasSemana[date.getDay()];
                    const hasSchedule = horarios.some(horario => horario.day_of_week === dayOfWeek);
                    
                    // Solo mostrar logs en desarrollo
                    if (horarios.length > 0) {
                        console.log(`Verificando ${dayOfWeek} (${date.toDateString()}): ${hasSchedule ? 'SÍ tiene horario' : 'NO tiene horario'}`);
                    }
                    
                    return hasSchedule;
                }

                function selectDate(date) {
                    selectedDate = date;

                    // Actualizar UI del calendario
                    document.querySelectorAll('.calendar-day').forEach(day => {
                        day.classList.remove('selected');
                    });
                    
                    // Encontrar y seleccionar el elemento correcto
                    const dateStr = date.toISOString().split('T')[0];
                    const dayElement = document.querySelector(`[data-date="${dateStr}"]`);
                    if (dayElement) {
                        dayElement.classList.add('selected');
                    }

                    // Actualizar texto de fecha seleccionada
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    document.getElementById('selectedDateText').textContent =
                        `Horarios disponibles para el ${date.toLocaleDateString('es-ES', options)}`;

                    // Cargar horarios disponibles
                    loadAvailableTimeSlots(date);

                    // Actualizar campos ocultos
                    document.getElementById('selectedDate').value = dateStr;
                    
                    console.log('Fecha seleccionada:', dateStr);
                }

                function loadAvailableTimeSlots(date) {
                    const dayOfWeek = diasSemana[date.getDay()];
                    const dateStr = date.toISOString().split('T')[0];

                    console.log(`Cargando horarios para ${dayOfWeek} (${dateStr})`);

                    // Obtener horarios del médico para ese día
                    const daySchedules = horarios.filter(h => h.day_of_week === dayOfWeek);
                    console.log('Horarios encontrados:', daySchedules.length);

                    // Obtener citas existentes para esa fecha
                    const existingAppointments = citasExistentes[dateStr] || [];
                    console.log('Citas existentes:', existingAppointments.length);

                    const container = document.getElementById('timeSlotsContainer');
                    container.innerHTML = '';

                    if (daySchedules.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-sm">No hay horarios disponibles para este día.</p>';
                        return;
                    }

                    let availableSlots = 0;
                    
                    daySchedules.forEach(schedule => {
                        console.log(`Procesando horario: ${schedule.start_time} - ${schedule.end_time}`);
                        
                        const startTime = new Date(`2000-01-01T${schedule.start_time}`);
                        const endTime = new Date(`2000-01-01T${schedule.end_time}`);

                        while (startTime < endTime) {
                            const timeSlot = startTime.toTimeString().substring(0, 5);
                            const timeSlotFull = startTime.toTimeString().substring(0, 8);

                            // Verificar si el horario está ocupado
                            const isOccupied = existingAppointments.some(appointment =>
                                appointment.appointment_time === timeSlotFull
                            );

                            if (!isOccupied) {
                                const slotElement = document.createElement('button');
                                slotElement.type = 'button';
                                slotElement.className =
                                    'p-3 text-sm font-medium border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 time-slot';
                                slotElement.textContent = timeSlot;
                                slotElement.dataset.time = timeSlot;
                                slotElement.dataset.scheduleId = schedule.id;
                                slotElement.setAttribute('data-time', timeSlot);

                                slotElement.addEventListener('click', () => selectTimeSlot(slotElement, timeSlot, schedule.id));

                                container.appendChild(slotElement);
                                availableSlots++;
                                console.log(`Horario disponible agregado: ${timeSlot}`);
                            } else {
                                console.log(`Horario ocupado: ${timeSlot}`);
                            }

                            startTime.setMinutes(startTime.getMinutes() + 30);
                        }
                    });
                    
                    if (availableSlots === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-sm">Todos los horarios para este día están ocupados.</p>';
                    }
                }

                function selectTimeSlot(element, time, scheduleId) {
                    // Remover selección previa
                    document.querySelectorAll('.time-slot').forEach(slot => {
                        slot.classList.remove('selected');
                    });

                    // Seleccionar nuevo horario
                    element.classList.add('selected');

                    selectedTime = time;
                    selectedScheduleId = scheduleId;

                    // Actualizar campos ocultos
                    document.getElementById('selectedTime').value = time;
                    document.getElementById('selectedScheduleId').value = scheduleId;

                    // Habilitar botón siguiente
                    document.getElementById('nextButton').disabled = false;
                }

                // Validación del formulario
                document.getElementById('fechaHoraForm').addEventListener('submit', function(e) {
                    if (!selectedDate || !selectedTime || !selectedScheduleId) {
                        e.preventDefault();
                        alert('Por favor seleccione una fecha y hora');
                    }
                });

                // Inicializar calendario cuando se carga la página
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Inicializando calendario...');
                    console.log('Horarios recibidos:', horarios);
                    console.log('Citas existentes:', citasExistentes);
                    console.log('Valores preservados:', { preservedDate, preservedTime, preservedScheduleId });
                    
                    // Verificar que tenemos datos
                    if (!horarios || horarios.length === 0) {
                        console.warn('No hay horarios disponibles para este médico');
                        document.getElementById('timeSlotsContainer').innerHTML = 
                            '<p class="text-red-500 text-sm">No hay horarios configurados para este médico.</p>';
                    }
                    
                    // Inicializar calendario y listeners solo si existen los botones
                    initCalendar();
                    const prevBtn = document.getElementById('prevMonth');
                    const nextBtn = document.getElementById('nextMonth');
                    if (prevBtn) {
                        prevBtn.addEventListener('click', () => {
                            currentDate.setMonth(currentDate.getMonth() - 1);
                            updateCalendar();
                        });
                    }
                    if (nextBtn) {
                        nextBtn.addEventListener('click', () => {
                            currentDate.setMonth(currentDate.getMonth() + 1);
                            updateCalendar();
                        });
                    }
                    
                    // Restaurar selección preservada si existe
                    if (preservedDate && preservedTime && preservedScheduleId) {
                        console.log('Restaurando selección preservada...');
                        const date = new Date(preservedDate);
                        selectedDate = date;
                        selectedTime = preservedTime;
                        selectedScheduleId = preservedScheduleId;
                        // Actualizar UI
                        updateCalendar();
                        loadAvailableTimeSlots(date);
                        // Marcar fecha y hora como seleccionadas
                        setTimeout(() => {
                            const dateElement = document.querySelector(`[data-date="${preservedDate}"]`);
                            if (dateElement) {
                                dateElement.classList.add('selected');
                            }
                            const timeElement = document.querySelector(`[data-time="${preservedTime}"]`);
                            if (timeElement) {
                                timeElement.classList.add('selected');
                            }
                            // Habilitar botón siguiente
                            document.getElementById('nextButton').disabled = false;
                        }, 100);
                    }
                });
            })();
        </script>

        <style>
            .calendar-day.available {
                background-color: #dcfce7;
                color: #166534;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .calendar-day.available:hover {
                background-color: #bbf7d0;
                color: #15803d;
                transform: scale(1.05);
            }

            .calendar-day.selected {
                background-color: #1e40af;
                color: white;
                font-weight: 600;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .time-slot {
                transition: all 0.2s ease;
            }

            .time-slot:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .time-slot.selected {
                background-color: #1e40af;
                color: white;
                border-color: #1e40af;
                font-weight: 600;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .material-icons {
                font-family: 'Material Icons';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;
                display: inline-block;
                line-height: 1;
                text-transform: none;
                letter-spacing: normal;
                word-wrap: normal;
                white-space: nowrap;
                direction: ltr;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
                -moz-osx-font-smoothing: grayscale;
                font-feature-settings: 'liga';
            }
        </style>
    @endpush
@endsection
