<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil - HealthPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shadow-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para botones con iconos */
        .btn-with-icon {
            position: relative;
            padding-left: 3rem !important;
            padding-right: 1.5rem !important;
        }

        .btn-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
        }

        /* Estilos para desplegables */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        select:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex-grow flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl space-y-8">
            <div class="bg-white p-8 shadow-card rounded-xl">
                <!-- Header -->
                <div class="flex justify-center mb-6">
                    <div class="text-blue-600 h-16 w-16">
                        <span class="material-icons text-6xl">local_hospital</span>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Completar Perfil</h2>
                    <p class="text-gray-600 text-sm">Paso 2 de 3: Información Específica</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-600">Progreso</span>
                        <span class="text-sm font-medium text-gray-500">66%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 66%"></div>
                    </div>
                </div>

                <!-- Mensajes de Error -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="material-icons text-red-400">error</span>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-800 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('profile.wizard.step2') }}" method="POST" class="space-y-6">
                    @csrf

                    @if (auth()->user()->role->name === 'doctor')
                        <!-- Campos específicos para Doctor -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Profesional</h3>

                            <!-- Código de Colegiatura -->
                            <div>
                                <label for="license_code" class="block text-sm font-medium text-gray-700 mb-1">Código de
                                    Colegiatura *</label>
                                <input type="text" name="license_code" id="license_code" maxlength="6"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('license_code') border-red-300 @enderror"
                                    placeholder="Ej: 123456" value="{{ old('license_code') }}" required />
                                @error('license_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Especialidad -->
                            <div>
                                <label for="specialty_id"
                                    class="block text-sm font-medium text-gray-700 mb-1">Especialidad *</label>
                                <select name="specialty_id" id="specialty_id"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('specialty_id') border-red-300 @enderror"
                                    required>
                                    <option value="">Seleccione especialidad</option>
                                    @foreach ($specialties ?? [] as $specialty)
                                        <option value="{{ $specialty->id }}"
                                            {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                                            {{ $specialty->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialty_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Años de Experiencia -->
                            <div>
                                <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-1">Años
                                    de Experiencia *</label>
                                <input type="number" name="experience_years" id="experience_years" min="0"
                                    max="50"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('experience_years') border-red-300 @enderror"
                                    placeholder="Ej: 5" value="{{ old('experience_years') }}" required />
                                @error('experience_years')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Biografía Profesional -->
                            <div>
                                <label for="professional_bio"
                                    class="block text-sm font-medium text-gray-700 mb-1">Biografía Profesional</label>
                                <textarea name="professional_bio" id="professional_bio" rows="4"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('professional_bio') border-red-300 @enderror"
                                    placeholder="Describa su experiencia profesional, formación académica, áreas de especialización...">{{ old('professional_bio') }}</textarea>
                                @error('professional_bio')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @elseif(auth()->user()->role->name === 'paciente')
                        <!-- Campos específicos para Paciente -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Médica</h3>

                            <!-- Grupo Sanguíneo -->
                            <div>
                                <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-1">Grupo
                                    Sanguíneo</label>
                                <select name="blood_type" id="blood_type"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('blood_type') border-red-300 @enderror">
                                    <option value="">Seleccione grupo sanguíneo</option>
                                    <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+
                                    </option>
                                    <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-
                                    </option>
                                    <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+
                                    </option>
                                    <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+
                                    </option>
                                    <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-
                                    </option>
                                    <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+
                                    </option>
                                    <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-
                                    </option>
                                </select>
                                @error('blood_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alergias -->
                            <div>
                                <label for="allergies"
                                    class="block text-sm font-medium text-gray-700 mb-1">Alergias</label>
                                <textarea name="allergies" id="allergies" rows="3"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('allergies') border-red-300 @enderror"
                                    placeholder="Liste sus alergias conocidas (medicamentos, alimentos, etc.)">{{ old('allergies') }}</textarea>
                                @error('allergies')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vacunas Recibidas -->
                            <div>
                                <label for="vaccination_received"
                                    class="block text-sm font-medium text-gray-700 mb-1">Vacunas Recibidas</label>
                                <textarea name="vaccination_received" id="vaccination_received" rows="3"
                                    class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('vaccination_received') border-red-300 @enderror"
                                    placeholder="Liste las vacunas que ha recibido y sus fechas">{{ old('vaccination_received') }}</textarea>
                                @error('vaccination_received')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contacto de Emergencia -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contacto de
                                        Emergencia</label>
                                    <input type="text" name="emergency_contact" id="emergency_contact"
                                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('emergency_contact') border-red-300 @enderror"
                                        placeholder="Nombre del contacto" value="{{ old('emergency_contact') }}"
                                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                        onkeyup="this.value = this.value.toUpperCase();"
                                        oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');" />
                                    @error('emergency_contact')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="emergency_phone"
                                        class="block text-sm font-medium text-gray-700 mb-1">Teléfono de
                                        Emergencia</label>
                                    <input type="tel" name="emergency_phone" id="emergency_phone"
                                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('emergency_phone') border-red-300 @enderror"
                                        placeholder="Ej: 999888777" value="{{ old('emergency_phone') }}"
                                        maxlength="9" inputmode="numeric" pattern="9\d{8}"
                                        oninput="this.value = this.value.replace(/\D/g, '');
                                        if (this.value.length === 1 && this.value !== '9') {
                                            this.value = '';
                                        }
                                        if (this.value.length > 9) {
                                            this.value = this.value.slice(0, 9);
                                        }" />
                                    @error('emergency_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Para Secretaria y Admin - No necesitan campos adicionales -->
                        <div class="text-center py-8">
                            <div class="text-green-600 mb-4">
                                <span class="material-icons text-6xl">check_circle</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">¡Perfecto!</h3>
                            <p class="text-gray-600">No se requieren campos adicionales para su rol.</p>
                        </div>
                    @endif

                    <!-- Botones -->
                    <div class="flex justify-between pt-6">
                        <a href="{{ route('profile.wizard.step1') }}"
                            class="btn-with-icon inline-flex items-center justify-center py-3 px-6 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <span
                                class="btn-icon material-icons text-gray-400 group-hover:text-gray-500">arrow_back</span>
                            Atrás
                        </a>

                        <button type="submit"
                            class="btn-with-icon inline-flex items-center justify-center py-3 px-6 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <span
                                class="btn-icon material-icons text-blue-500 group-hover:text-blue-400">arrow_forward</span>
                            Siguiente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
