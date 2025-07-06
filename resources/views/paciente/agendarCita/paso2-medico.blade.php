@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reservar Cita Médica</h1>
        <h2 class="text-lg sm:text-xl font-semibold text-blue-600 mb-6">Paso 2 de 4: Seleccione un Médico</h2>

        <!-- Barra de progreso -->
        <div class="mb-8">
            <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-blue-600" style="width: 50%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span class="font-semibold text-blue-600">Especialidad</span>
                <span class="font-semibold text-blue-600">Médico</span>
                <span>Fecha y Hora</span>
                <span>Confirmar</span>
            </div>
        </div>

        <!-- Especialidad seleccionada -->
        <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
            <p class="text-sm text-gray-700">Especialidad seleccionada:</p>
            <p class="text-lg font-semibold text-blue-700">{{ $especialidad->name }}</p>
        </div>

        <!-- Grid de médicos -->
        <form action="{{ route('paciente.agendarCita.seleccionarFechaHora') }}" method="POST" id="medicoForm">
            @csrf
            <input type="hidden" name="specialty_id" value="{{ $especialidad->id }}">
            <input type="hidden" name="doctor_id" id="selectedDoctorId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($medicos as $medico)
                    <div class="group bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer border-2 border-transparent focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 medico-card"
                        data-medico-id="{{ $medico->id }}" onclick="seleccionarMedico(this, {{ $medico->id }})"
                        role="radio" tabindex="0">
                        <div class="flex items-start gap-4">
                            @if ($medico->user->profile && $medico->user->profile->profile_photo)
                                <img alt="Foto del {{ $medico->user->profile->first_name }} {{ $medico->user->profile->last_name }}"
                                    class="h-16 w-16 rounded-full object-cover"
                                    src="{{ asset('storage/' . $medico->user->profile->profile_photo) }}" />
                            @else
                                <span
                                    class="material-icons text-5xl text-gray-400 bg-gray-100 rounded-full p-2">person_outline</span>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">
                                    Dr. {{ $medico->user->profile->first_name ?? 'Médico' }}
                                    {{ $medico->user->profile->last_name ?? '' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    @switch($especialidad->name)
                                        @case('Cardiología')
                                            Cardiólogo con {{ $medico->experience_years }} años de experiencia en enfermedades
                                            coronarias y arritmias.
                                        @break

                                        @case('Pediatría')
                                            Pediatra con {{ $medico->experience_years }} años de experiencia en atención integral
                                            infantil.
                                        @break

                                        @case('Dermatología')
                                            Dermatólogo con {{ $medico->experience_years }} años de experiencia en afecciones de la
                                            piel.
                                        @break

                                        @case('Neurología')
                                            Neurólogo con {{ $medico->experience_years }} años de experiencia en trastornos del
                                            sistema nervioso.
                                        @break

                                        @case('Ortopedia')
                                            Ortopedista con {{ $medico->experience_years }} años de experiencia en traumatología.
                                        @break

                                        @case('Oncología')
                                            Oncólogo con {{ $medico->experience_years }} años de experiencia en tratamiento del
                                            cáncer.
                                        @break

                                        @case('Ginecología')
                                            Ginecólogo con {{ $medico->experience_years }} años de experiencia en salud
                                            reproductiva.
                                        @break

                                        @case('Oftalmología')
                                            Oftalmólogo con {{ $medico->experience_years }} años de experiencia en enfermedades
                                            oculares.
                                        @break

                                        @case('Psiquiatría')
                                            Psiquiatra con {{ $medico->experience_years }} años de experiencia en salud mental.
                                        @break

                                        @case('Traumatología')
                                            Traumatólogo con {{ $medico->experience_years }} años de experiencia en lesiones.
                                        @break

                                        @default
                                            Especialista en {{ $especialidad->name }} con {{ $medico->experience_years }} años de
                                            experiencia.
                                    @endswitch
                                </p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        Licencia: {{ $medico->license_code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <span class="material-icons text-6xl text-gray-300 mb-4">medical_services</span>
                            <h3 class="text-lg font-medium text-gray-600 mb-2">No hay médicos disponibles</h3>
                            <p class="text-sm text-gray-500">No hay médicos registrados para esta especialidad en este momento.
                            </p>
                            <a href="{{ route('paciente.agendarCita.create') }}"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Volver a seleccionar especialidad
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Botones de navegación -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <a href="{{ route('paciente.agendarCita.create') }}"
                        class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                        Anterior
                    </a>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('dashboard') }}"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors duration-150"
                            disabled id="nextButton">
                            Siguiente
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @push('scripts')
            <script>
                function seleccionarMedico(element, medicoId) {
                    // Remover selección previa
                    document.querySelectorAll('.medico-card').forEach(card => {
                        card.classList.remove('selected-doctor');
                        card.setAttribute('aria-checked', 'false');
                    });

                    // Seleccionar el nuevo médico
                    element.classList.add('selected-doctor');
                    element.setAttribute('aria-checked', 'true');

                    // Actualizar el campo oculto
                    document.getElementById('selectedDoctorId').value = medicoId;

                    // Habilitar el botón siguiente
                    document.getElementById('nextButton').disabled = false;
                }

                // Validación del formulario
                document.getElementById('medicoForm').addEventListener('submit', function(e) {
                    const selectedId = document.getElementById('selectedDoctorId').value;
                    if (!selectedId) {
                        e.preventDefault();
                        alert('Por favor seleccione un médico');
                    }
                });
            </script>

            <style>
                .selected-doctor {
                    outline: 2px solid #1e40af;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
                    border-color: #1e40af;
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
