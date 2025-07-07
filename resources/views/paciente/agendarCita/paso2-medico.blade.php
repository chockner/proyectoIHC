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

        <!-- Buscador de médicos -->
        <div class="mb-6">
            <label class="sr-only" for="search-doctor">Buscar médico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    id="search-doctor" name="search-doctor"
                    placeholder="Buscar médico por nombre (ej. Dr. Carlos, Dra. María...)" type="search" />
            </div>
        </div>

        <!-- Mensaje de "no se encontraron resultados" -->
        <div id="no-results-message" class="hidden text-center py-8">
            <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300">
                <span class="material-icons text-6xl text-gray-400 mb-4">person_search</span>
                <h3 class="text-lg font-medium text-gray-600 mb-2">No se encontraron médicos</h3>
                <p class="text-sm text-gray-500">Intenta con otros términos de búsqueda</p>
            </div>
        </div>

        <!-- Grid de médicos -->
        <form action="{{ route('paciente.agendarCita.seleccionarFechaHora') }}" method="POST" id="medicoForm">
            @csrf
            <input type="hidden" name="specialty_id" value="{{ $especialidad->id }}">
            <input type="hidden" name="doctor_id" id="selectedDoctorId" value="{{ $selectedDoctorId }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="medicos-grid">
                @forelse($medicos as $medico)
                    <div class="group bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer border-2 border-transparent focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 medico-card {{ $selectedDoctorId == $medico->id ? 'selected-doctor' : '' }}"
                        data-medico-id="{{ $medico->id }}" 
                        data-medico-nombre="{{ $medico->user->profile->gender == '0' ? 'Dra.' : 'Dr.' }} {{ $medico->user->profile->first_name ?? 'Médico' }} {{ $medico->user->profile->last_name ?? '' }}"
                        onclick="seleccionarMedico(this, {{ $medico->id }})"
                        role="radio" tabindex="0"
                        aria-checked="{{ $selectedDoctorId == $medico->id ? 'true' : 'false' }}">
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
                                    {{ $medico->user->profile->gender == '0' ? 'Dra.' : 'Dr.' }} {{ $medico->user->profile->first_name ?? 'Médico' }}
                                    {{ $medico->user->profile->last_name ?? '' }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    @switch($especialidad->name)
                                        @case('Cardiología')
                                            {{ $medico->user->profile->gender == '0' ? 'Cardióloga' : 'Cardiólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades
                                            coronarias y arritmias.
                                        @break

                                        @case('Pediatría')
                                            {{ $medico->user->profile->gender == '0' ? 'Pediatra' : 'Pediatra' }} con {{ $medico->experience_years }} años de experiencia en atención integral
                                            infantil.
                                        @break

                                        @case('Dermatología')
                                            {{ $medico->user->profile->gender == '0' ? 'Dermatóloga' : 'Dermatólogo' }} con {{ $medico->experience_years }} años de experiencia en afecciones de la
                                            piel.
                                        @break

                                        @case('Neurología')
                                            {{ $medico->user->profile->gender == '0' ? 'Neuróloga' : 'Neurólogo' }} con {{ $medico->experience_years }} años de experiencia en trastornos del
                                            sistema nervioso.
                                        @break

                                        @case('Ortopedia')
                                            {{ $medico->user->profile->gender == '0' ? 'Ortopedista' : 'Ortopedista' }} con {{ $medico->experience_years }} años de experiencia en traumatología.
                                        @break

                                        @case('Oncología')
                                            {{ $medico->user->profile->gender == '0' ? 'Oncóloga' : 'Oncólogo' }} con {{ $medico->experience_years }} años de experiencia en tratamiento del
                                            cáncer.
                                        @break

                                        @case('Ginecología')
                                            {{ $medico->user->profile->gender == '0' ? 'Ginecóloga' : 'Ginecólogo' }} con {{ $medico->experience_years }} años de experiencia en salud
                                            reproductiva.
                                        @break

                                        @case('Oftalmología')
                                            {{ $medico->user->profile->gender == '0' ? 'Oftalmóloga' : 'Oftalmólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades
                                            oculares.
                                        @break

                                        @case('Psiquiatría')
                                            {{ $medico->user->profile->gender == '0' ? 'Psiquiatra' : 'Psiquiatra' }} con {{ $medico->experience_years }} años de experiencia en salud mental.
                                        @break

                                        @case('Traumatología')
                                            {{ $medico->user->profile->gender == '0' ? 'Traumatóloga' : 'Traumatólogo' }} con {{ $medico->experience_years }} años de experiencia en lesiones.
                                        @break

                                        @case('Endocrinología')
                                            {{ $medico->user->profile->gender == '0' ? 'Endocrinóloga' : 'Endocrinólogo' }} con {{ $medico->experience_years }} años de experiencia en trastornos hormonales.
                                        @break

                                        @case('Gastroenterología')
                                            {{ $medico->user->profile->gender == '0' ? 'Gastroenteróloga' : 'Gastroenterólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades digestivas.
                                        @break

                                        @case('Neumología')
                                            {{ $medico->user->profile->gender == '0' ? 'Neumóloga' : 'Neumólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades respiratorias.
                                        @break

                                        @case('Urología')
                                            {{ $medico->user->profile->gender == '0' ? 'Uróloga' : 'Urólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades urológicas.
                                        @break

                                        @case('Otorrinolaringología')
                                            {{ $medico->user->profile->gender == '0' ? 'Otorrinolaringóloga' : 'Otorrinolaringólogo' }} con {{ $medico->experience_years }} años de experiencia en enfermedades de oído, nariz y garganta.
                                        @break

                                        @case('Medicina Interna')
                                            {{ $medico->user->profile->gender == '0' ? 'Médica Internista' : 'Médico Internista' }} con {{ $medico->experience_years }} años de experiencia en medicina general.
                                        @break

                                        @default
                                            {{ $medico->user->profile->gender == '0' ? 'Especialista' : 'Especialista' }} en {{ $especialidad->name }} con {{ $medico->experience_years }} años de
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
                    <a href="{{ route('paciente.agendarCita.create', ['preserve_state' => true]) }}"
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
                            {{ $selectedDoctorId ? '' : 'disabled' }} id="nextButton">
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

                // Filtro de búsqueda de médicos
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('search-doctor');
                    const noResultsMessage = document.getElementById('no-results-message');
                    const medicosGrid = document.getElementById('medicos-grid');
                    
                    if (searchInput) {
                        searchInput.addEventListener('input', function(e) {
                            const searchTerm = e.target.value.toLowerCase().trim();
                            const cards = document.querySelectorAll('.medico-card');
                            
                            console.log('Buscando médico:', searchTerm); // Debug
                            console.log('Tarjetas de médicos encontradas:', cards.length); // Debug

                            let visibleCards = 0;

                            cards.forEach(card => {
                                const nombre = card.getAttribute('data-medico-nombre');
                                if (nombre) {
                                    const nombreLower = nombre.toLowerCase();
                                    console.log('Comparando médico:', nombreLower, 'con:', searchTerm); // Debug
                                    
                                    if (searchTerm === '' || nombreLower.includes(searchTerm)) {
                                        card.classList.remove('hidden');
                                        visibleCards++;
                                        console.log('Mostrando médico:', nombre); // Debug
                                    } else {
                                        card.classList.add('hidden');
                                        console.log('Ocultando médico:', nombre); // Debug
                                    }
                                }
                            });

                            // Mostrar/ocultar mensaje de "no se encontraron resultados"
                            if (searchTerm !== '' && visibleCards === 0) {
                                noResultsMessage.classList.remove('hidden');
                                medicosGrid.classList.add('hidden');
                            } else {
                                noResultsMessage.classList.add('hidden');
                                medicosGrid.classList.remove('hidden');
                            }
                        });
                    }
                });

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
