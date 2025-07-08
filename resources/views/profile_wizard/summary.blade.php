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
                <!-- Mensajes de error -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <div class="flex items-center">
                            <span class="material-icons text-red-500 mr-2">error</span>
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-[#0d131c] mb-2">Resumen del Perfil</h1>
                    <p class="text-[#49699c]">Revisa la información antes de completar tu perfil</p>
                </div>
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Completar Perfil</h2>
                    <p class="text-gray-600 text-sm">Paso 3 de 3: Confirmar Información</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-600">Progreso</span>
                        <span class="text-sm font-medium text-gray-500">100%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Resumen de Información -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Resumen de Información</h3>
                    
                    <!-- Información Personal -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Información Personal</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Nombre:</span>
                                <span class="font-medium text-gray-800">{{ session('profile_data.first_name') }} {{ session('profile_data.last_name') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Fecha de Nacimiento:</span>
                                <span class="font-medium text-gray-800">{{ session('profile_data.birthdate') }}</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#49699c] mb-1">Género</label>
                                <p class="text-[#0d131c] font-medium">{{ $profileData['gender_text'] ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Teléfono:</span>
                                <span class="font-medium text-gray-800">{{ session('profile_data.phone') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium text-gray-800">{{ session('profile_data.email') }}</span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#49699c] mb-1">Estado Civil</label>
                                <p class="text-[#0d131c] font-medium">{{ $profileData['civil_status_text'] ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Dirección -->
                    @if(session('profile_data.address') || session('profile_data.region'))
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Dirección</h4>
                        <div class="text-sm">
                            <p class="text-gray-800">
                                {{ session('profile_data.address') }}
                                @if(session('profile_data.district') || session('profile_data.province') || session('profile_data.region'))
                                    <br>
                                    {{ session('profile_data.district') }}, {{ session('profile_data.province') }}, {{ session('profile_data.region') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Información Específica por Rol -->
                    @if(auth()->user()->role->name === 'doctor' && session('role_data'))
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Información Profesional</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Código de Colegiatura:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.license_code') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Especialidad:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.specialty_name') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Años de Experiencia:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.experience_years') }}</span>
                            </div>
                        </div>
                        @if(session('role_data.professional_bio'))
                        <div class="mt-3">
                            <span class="text-gray-600">Biografía:</span>
                            <p class="text-gray-800 mt-1">{{ session('role_data.professional_bio') }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if(auth()->user()->role->name === 'paciente' && session('role_data'))
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Información Médica</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if(session('role_data.blood_type'))
                            <div>
                                <span class="text-gray-600">Grupo Sanguíneo:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.blood_type') }}</span>
                            </div>
                            @endif
                            @if(session('role_data.emergency_contact'))
                            <div>
                                <span class="text-gray-600">Contacto de Emergencia:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.emergency_contact') }}</span>
                            </div>
                            @endif
                            @if(session('role_data.emergency_phone'))
                            <div>
                                <span class="text-gray-600">Teléfono de Emergencia:</span>
                                <span class="font-medium text-gray-800">{{ session('role_data.emergency_phone') }}</span>
                            </div>
                            @endif
                        </div>
                        @if(session('role_data.allergies'))
                        <div class="mt-3">
                            <span class="text-gray-600">Alergias:</span>
                            <p class="text-gray-800 mt-1">{{ session('role_data.allergies') }}</p>
                        </div>
                        @endif
                        @if(session('role_data.vaccination_received'))
                        <div class="mt-3">
                            <span class="text-gray-600">Vacunas Recibidas:</span>
                            <p class="text-gray-800 mt-1">{{ session('role_data.vaccination_received') }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Mensaje de Confirmación -->
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="material-icons text-blue-400">info</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800">
                                Revise cuidadosamente toda la información antes de confirmar. 
                                Una vez confirmado, podrá editar su perfil desde el dashboard.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between pt-6">
                    <a href="{{ route('profile.wizard.step2') }}"
                       class="btn-with-icon inline-flex items-center justify-center py-3 px-6 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <span class="btn-icon material-icons text-gray-400 group-hover:text-gray-500">arrow_back</span>
                        Atrás
                    </a>
                    
                    <form action="{{ route('profile.wizard.finish') }}" method="POST" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="btn-with-icon inline-flex items-center justify-center py-3 px-6 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                        >
                            <span class="btn-icon material-icons text-green-500 group-hover:text-green-400">check</span>
                            Confirmar y Completar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 