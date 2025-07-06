@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reservar Cita Médica</h1>
        <h2 class="text-lg sm:text-xl font-semibold text-blue-600 mb-6">Paso 1 de 4: Seleccione una Especialidad</h2>

        <!-- Barra de progreso -->
        <div class="mb-8">
            <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-blue-600" style="width: 25%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span class="font-semibold text-blue-600">Especialidad</span>
                <span>Médico</span>
                <span>Fecha y Hora</span>
                <span>Confirmar</span>
            </div>
        </div>

        <!-- Buscador -->
        <div class="mb-6">
            <label class="sr-only" for="search-specialty">Buscar especialidad</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-icons text-gray-400">search</span>
                </div>
                <input
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    id="search-specialty" name="search-specialty"
                    placeholder="Buscar especialidad (ej. Cardiología, Pediatría...)" type="search" />
            </div>
        </div>

        <!-- Grid de especialidades -->
        <form action="{{ route('paciente.agendarCita.seleccionarMedico') }}" method="POST" id="especialidadForm">
            @csrf
            <input type="hidden" name="specialty_id" id="selectedSpecialtyId">

            <!-- Mensaje de "no se encontraron resultados" -->
            <div id="no-results-message" class="hidden text-center py-8">
                <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300">
                    <span class="material-icons text-6xl text-gray-400 mb-4">search_off</span>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No se encontraron especialidades</h3>
                    <p class="text-sm text-gray-500">Intenta con otros términos de búsqueda</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="especialidades-grid">
                @foreach ($especialidades as $especialidad)
                    <div class="group bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer border-2 border-transparent focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500 especialidad-card"
                        data-especialidad-id="{{ $especialidad->id }}" data-especialidad-nombre="{{ $especialidad->name }}"
                        onclick="seleccionarEspecialidad(this, {{ $especialidad->id }})" role="radio" tabindex="0">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="material-icons text-3xl text-blue-600">
                                @switch($especialidad->name)
                                    @case('Cardiología')
                                        favorite_border
                                    @break

                                    @case('Pediatría')
                                        child_care
                                    @break

                                    @case('Dermatología')
                                        spa
                                    @break

                                    @case('Neurología')
                                        psychology
                                    @break

                                    @case('Ortopedia')
                                        healing
                                    @break

                                    @case('Oncología')
                                        biotech
                                    @break

                                    @case('Ginecología')
                                        pregnant_woman
                                    @break

                                    @case('Oftalmología')
                                        visibility
                                    @break

                                    @case('Psiquiatría')
                                        psychology_alt
                                    @break

                                    @case('Traumatología')
                                        accessibility
                                    @break

                                    @default
                                        medical_services
                                @endswitch
                            </span>
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-700">
                                {{ $especialidad->name }}</h3>
                        </div>
                        <p class="text-sm text-gray-600">
                            @switch($especialidad->name)
                                @case('Cardiología')
                                    Especialistas en afecciones cardíacas y del sistema cardiovascular. Ofrecemos diagnósticos y
                                    tratamientos avanzados.
                                @break

                                @case('Pediatría')
                                    Atención integral para bebés, niños y adolescentes. Enfoque en el bienestar y desarrollo.
                                @break

                                @case('Dermatología')
                                    Diagnóstico y tratamiento de afecciones de la piel, cabello y uñas. Dermatología cosmética y
                                    médica.
                                @break

                                @case('Neurología')
                                    Atención para trastornos del sistema nervioso, incluyendo cerebro, médula espinal y nervios.
                                @break

                                @case('Ortopedia')
                                    Tratamiento de problemas del sistema musculoesquelético, incluyendo huesos, articulaciones,
                                    ligamentos y tendones.
                                @break

                                @case('Oncología')
                                    Atención integral del cáncer, desde el diagnóstico y tratamiento hasta el apoyo a la
                                    supervivencia.
                                @break

                                @case('Ginecología')
                                    Atención especializada en salud reproductiva femenina, embarazo y parto.
                                @break

                                @case('Oftalmología')
                                    Diagnóstico y tratamiento de enfermedades de los ojos y trastornos de la visión.
                                @break

                                @case('Psiquiatría')
                                    Tratamiento de trastornos mentales y emocionales con enfoque integral.
                                @break

                                @case('Traumatología')
                                    Especialistas en lesiones y traumatismos del sistema musculoesquelético.
                                @break

                                @default
                                    Atención médica especializada con los más altos estándares de calidad.
                            @endswitch
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Botones de navegación -->
            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
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
        </form>
    </div>

    @push('scripts')
        <script>
            function seleccionarEspecialidad(element, especialidadId) {
                // Remover selección previa
                document.querySelectorAll('.especialidad-card').forEach(card => {
                    card.classList.remove('selected-specialty');
                    card.setAttribute('aria-checked', 'false');
                });

                // Seleccionar la nueva especialidad
                element.classList.add('selected-specialty');
                element.setAttribute('aria-checked', 'true');

                // Actualizar el campo oculto
                document.getElementById('selectedSpecialtyId').value = especialidadId;

                // Habilitar el botón siguiente
                document.getElementById('nextButton').disabled = false;
            }

            // Filtro de búsqueda
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-specialty');
                const noResultsMessage = document.getElementById('no-results-message');
                const especialidadesGrid = document.getElementById('especialidades-grid');
                
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase().trim();
                        const cards = document.querySelectorAll('.especialidad-card');
                        
                        console.log('Buscando:', searchTerm); // Debug
                        console.log('Tarjetas encontradas:', cards.length); // Debug

                        let visibleCards = 0;

                        cards.forEach(card => {
                            const nombre = card.getAttribute('data-especialidad-nombre');
                            if (nombre) {
                                const nombreLower = nombre.toLowerCase();
                                console.log('Comparando:', nombreLower, 'con:', searchTerm); // Debug
                                
                                if (searchTerm === '' || nombreLower.includes(searchTerm)) {
                                    card.classList.remove('hidden');
                                    visibleCards++;
                                    console.log('Mostrando:', nombre); // Debug
                                } else {
                                    card.classList.add('hidden');
                                    console.log('Ocultando:', nombre); // Debug
                                }
                            }
                        });

                        // Mostrar/ocultar mensaje de "no se encontraron resultados"
                        if (searchTerm !== '' && visibleCards === 0) {
                            noResultsMessage.classList.remove('hidden');
                            especialidadesGrid.classList.add('hidden');
                        } else {
                            noResultsMessage.classList.add('hidden');
                            especialidadesGrid.classList.remove('hidden');
                        }
                    });
                }
            });

            // Validación del formulario
            document.getElementById('especialidadForm').addEventListener('submit', function(e) {
                const selectedId = document.getElementById('selectedSpecialtyId').value;
                if (!selectedId) {
                    e.preventDefault();
                    alert('Por favor seleccione una especialidad');
                }
            });
        </script>

        <style>
            .selected-specialty {
                outline: 2px solid #1e40af;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
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
