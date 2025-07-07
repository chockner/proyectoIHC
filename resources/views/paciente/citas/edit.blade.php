@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Reprogramar Cita</h1>
        <a href="{{ route('paciente.citas.show', $cita->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
            <span class="material-icons mr-2">arrow_back</span>
            Volver
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Información actual de la cita -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Información Actual de la Cita</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Especialidad</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">{{ $cita->doctor->specialty->name }}</p>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Médico</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">
                        Dr. {{ $cita->doctor->user->profile->first_name ?? 'Médico' }} {{ $cita->doctor->user->profile->last_name ?? '' }}
                    </p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha Actual</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">
                        {{ \Carbon\Carbon::parse($cita->appointment_date)->format('l, d \d\e F \d\e Y') }}
                    </p>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Hora Actual</h3>
                    <p class="text-lg font-medium text-gray-900">{{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de reprogramación -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Seleccionar Nueva Fecha y Hora</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('paciente.citas.update', $cita->id) }}" method="POST" id="reprogramarForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Calendario -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Seleccionar Fecha</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" class="p-2 rounded-full hover:bg-gray-200 text-gray-600" id="prevMonth">
                                    <span class="material-icons">chevron_left</span>
                                </button>
                                <h4 class="text-lg font-semibold text-gray-700" id="currentMonthYear"></h4>
                                <button type="button" class="p-2 rounded-full hover:bg-gray-200 text-gray-600" id="nextMonth">
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
                                    <div class="flex items-center gap-1">
                                        <div class="w-3 h-3 bg-blue-500 border border-blue-600 rounded"></div>
                                        <span>Seleccionado</span>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="appointment_date" id="selectedDate" value="{{ $cita->appointment_date }}">
                        </div>
                    </div>

                    <!-- Horarios disponibles -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Seleccionar Hora</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-600 mb-4" id="selectedDateText">
                                Horarios disponibles para el {{ \Carbon\Carbon::parse($cita->appointment_date)->format('l, d \d\e F \d\e Y') }}
                            </p>
                            <div class="grid grid-cols-2 gap-3" id="timeSlotsContainer">
                                <!-- Los horarios se cargarán dinámicamente -->
                            </div>
                            <input type="hidden" name="appointment_time" id="selectedTime" value="{{ $cita->appointment_time }}">
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('paciente.citas.show', $cita->id) }}" 
                       class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors duration-150"
                            id="submitButton" disabled>
                        Reprogramar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        // Protección contra múltiples inicializaciones
        if (window.calendarInitialized) {
            console.log('⚠️ Calendario ya inicializado, saltando...');
            return;
        }
        window.calendarInitialized = true;
        
        let currentDate = new Date();
        let selectedDate = '{{ $cita->appointment_date }}';
        let selectedTime = '{{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}';
        
        // Días de la semana en español (0 = Domingo, 1 = Lunes, etc.)
        const diasSemana = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
        const diasCortos = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'];

        // Horarios del médico (pasados desde el controlador)
        const horarios = @json($horarios);
        const citasExistentes = @json($citasExistentes);

        function initCalendar() {
            updateCalendar();
            // Cargar horarios para la fecha actual de la cita
            loadAvailableTimeSlots(new Date(selectedDate));
        }
        
        function preselectCurrentTime() {
            console.log('🔍 Preseleccionando hora:', selectedTime);
            const timeSlots = document.querySelectorAll('.time-slot');
            console.log('📅 Slots encontrados:', timeSlots.length);
            
            timeSlots.forEach((slot, index) => {
                const slotText = slot.textContent.trim();
                console.log(`Slot ${index}: "${slotText}" vs "${selectedTime}"`);
                
                if (slotText === selectedTime) {
                    console.log('✅ ¡Hora encontrada! Preseleccionando...');
                    slot.classList.remove('border-gray-300', 'bg-white', 'text-gray-700');
                    slot.classList.add('bg-blue-500', 'text-white', 'border-blue-500', 'selected');
                    return;
                }
            });
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
            let startDay = firstDay.getDay();
            if (startDay === 0) startDay = 7;
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - (startDay - 1));

            const calendarGrid = document.getElementById('calendarGrid');
            calendarGrid.innerHTML = '';

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
                    const isSelected = date.toISOString().split('T')[0] === selectedDate;

                    dayElement.textContent = date.getDate();

                    if (isToday) {
                        dayElement.classList.add('bg-blue-100', 'text-blue-700', 'font-semibold');
                    } else if (isPast) {
                        dayElement.classList.add('text-gray-300', 'cursor-not-allowed');
                                            } else if (hasSchedule) {
                            dayElement.classList.add('bg-green-50', 'text-green-700', 'hover:bg-green-100', 'calendar-day', 'available');
                            
                            if (isSelected) {
                                dayElement.classList.add('bg-blue-500', 'text-white', 'font-semibold', 'selected');
                            }
                            
                            dayElement.addEventListener('click', function(e) {
                                selectDate(date);
                            });
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
            return hasSchedule;
        }

        function selectDate(date) {
            selectedDate = date.toISOString().split('T')[0];

            // Actualizar UI del calendario
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('bg-blue-500', 'text-white', 'font-semibold', 'selected');
            });
            
            // Encontrar y seleccionar el elemento correcto
            const dateStr = date.toISOString().split('T')[0];
            const dayElement = document.querySelector(`[data-date="${dateStr}"]`);
            if (dayElement) {
                dayElement.classList.add('bg-blue-500', 'text-white', 'font-semibold', 'selected');
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

            // Actualizar campo oculto
            document.getElementById('selectedDate').value = dateStr;
            
            // Limpiar selección de hora al cambiar de día (excepto si es la fecha actual de la cita)
            if (dateStr !== '{{ $cita->appointment_date }}') {
                selectedTime = null;
                document.getElementById('selectedTime').value = '';
            }
            
            updateSubmitButton();
        }

        function loadAvailableTimeSlots(date) {
            const dayOfWeek = diasSemana[date.getDay()];
            const dateStr = date.toISOString().split('T')[0];

            // Obtener horarios del médico para ese día
            const daySchedules = horarios.filter(h => h.day_of_week === dayOfWeek);

            // Obtener citas existentes para esa fecha (excluyendo la cita actual)
            const existingAppointments = citasExistentes[dateStr] || [];

            const container = document.getElementById('timeSlotsContainer');
            container.innerHTML = '';

            if (daySchedules.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm">No hay horarios disponibles para este día.</p>';
                return;
            }

            let availableSlots = 0;
            
            daySchedules.forEach(schedule => {
                const startTime = new Date(`2000-01-01T${schedule.start_time}`);
                const endTime = new Date(`2000-01-01T${schedule.end_time}`);

                while (startTime < endTime) {
                    const timeSlot = startTime.toTimeString().substring(0, 5);
                    const timeSlotFull = startTime.toTimeString().substring(0, 8);

                    // Verificar si el horario está ocupado (excluyendo la cita actual)
                    const isOccupied = existingAppointments.some(appointment =>
                        appointment.appointment_time === timeSlotFull
                    );

                    if (!isOccupied) {
                        const slotElement = document.createElement('button');
                        slotElement.type = 'button';
                        slotElement.className = 'p-3 text-sm font-medium border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 time-slot';
                        slotElement.textContent = timeSlot;
                        
                        // Si es el horario actual de la cita, marcarlo como seleccionado
                        if (timeSlot === selectedTime) {
                            console.log('🎯 Marcando hora como seleccionada durante creación:', timeSlot);
                            slotElement.classList.add('bg-blue-500', 'text-white', 'border-blue-500', 'selected');
                        }
                        
                        slotElement.addEventListener('click', function() {
                            selectTimeSlot(slotElement, timeSlot);
                        });

                        container.appendChild(slotElement);
                        availableSlots++;
                    }

                    startTime.setMinutes(startTime.getMinutes() + 30);
                }
            });
            
            if (availableSlots === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm">Todos los horarios para este día están ocupados.</p>';
            }
            
            // Preseleccionar la hora actual si estamos en la fecha de la cita
            if (dateStr === '{{ $cita->appointment_date }}') {
                preselectCurrentTime();
            }
        }



        function selectTimeSlot(element, time) {
            // Remover selección previa
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('bg-blue-500', 'text-white', 'border-blue-500', 'selected');
                slot.classList.add('border-gray-300', 'bg-white', 'text-gray-700');
            });

            // Seleccionar nuevo horario
            element.classList.remove('border-gray-300', 'bg-white', 'text-gray-700');
            element.classList.add('bg-blue-500', 'text-white', 'border-blue-500', 'selected');

            selectedTime = time;
            document.getElementById('selectedTime').value = time;
            
            updateSubmitButton();
        }

        function updateSubmitButton() {
            const submitButton = document.getElementById('submitButton');
            const hasDate = selectedDate && selectedDate !== '{{ $cita->appointment_date }}';
            const hasTime = selectedTime && selectedTime !== '{{ $cita->appointment_time }}';
            
            if (hasDate || hasTime) {
                submitButton.disabled = false;
                submitButton.textContent = 'Reprogramar Cita';
            } else {
                submitButton.disabled = true;
                submitButton.textContent = 'Seleccione nueva fecha u hora';
            }
        }

        // Event listeners
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });

        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Inicializando calendario...');
            console.log('📅 Fecha seleccionada:', selectedDate);
            console.log('⏰ Hora seleccionada:', selectedTime);
            
            // Establecer el mes actual al mes de la cita
            const citaDate = new Date(selectedDate);
            currentDate = new Date(citaDate.getFullYear(), citaDate.getMonth(), 1);
            
            initCalendar();
        });
    })();
</script>

<style>
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

/* Estilos para el calendario */
.calendar-day {
    transition: all 0.2s ease;
}

.calendar-day:hover {
    transform: scale(1.05);
}

.calendar-day.selected {
    background-color: #1d4ed8 !important;
    color: white !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 4px rgba(29, 78, 216, 0.3) !important;
    border: 2px solid #1e40af !important;
}

/* Estilos para los slots de tiempo */
.time-slot {
    transition: all 0.2s ease;
}

.time-slot:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.time-slot.selected {
    background-color: #1d4ed8 !important;
    color: white !important;
    border-color: #1e40af !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 4px rgba(29, 78, 216, 0.3) !important;
    transform: translateY(-1px) !important;
}
</style>
@endpush
@endsection 