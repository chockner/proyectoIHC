<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Personal - HealthPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shadow-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex-grow flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="bg-white p-8 shadow-card rounded-xl">
                <!-- Logo y Título -->
                <div class="flex justify-center mb-6">
                    <div class="text-blue-600 h-16 w-16">
                        <span class="material-icons text-6xl">local_hospital</span>
                    </div>
                </div>
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Acceso Personal</h2>
                    <p class="text-gray-600 text-sm">Acceso exclusivo para personal de HealthPlus</p>
                </div>

                <!-- Mensajes de Error -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <span class="material-icons text-red-400">error</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('login.personal') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Campo DNI -->
                    <div>
                        <label for="document_id" class="sr-only">DNI</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400">person</span>
                            </div>
                            <input
                                type="text"
                                name="document_id"
                                id="document_id"
                                maxlength="8"
                                inputmode="numeric"
                                pattern="\d{8}"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                                title="Ingrese exactamente 8 dígitos numéricos"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('document_id') border-red-300 @enderror"
                                placeholder="Ingrese su DNI"
                                autofocus
                                required
                            />
                        </div>
                        @error('document_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="sr-only">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400">lock</span>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                autocomplete="current-password"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-300 @enderror"
                                placeholder="Ingrese su contraseña"
                                required
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                                id="togglePassword"
                            >
                                <span class="material-icons text-gray-500 hover:text-gray-700">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enlace Olvidé Contraseña -->
                    <div class="flex items-center justify-end text-sm">
                        <a href="{{ route('quick.reset.form') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            ¿Olvidó su contraseña?
                        </a>
                    </div>

                    <!-- Botón de Envío -->
                    <div>
                        <button
                            type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        >
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <span class="material-icons text-blue-500 group-hover:text-blue-400">login</span>
                            </span>
                            Ingresar
                        </button>
                    </div>

                    <!-- Enlace para Pacientes -->
                    <div class="text-center text-sm">
                        <p class="text-gray-600">
                            ¿Es paciente? 
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                                Acceda aquí
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Información de Seguridad -->
                <div class="mt-6 text-center">
                    <small class="text-gray-500">Sistema seguro de gestión hospitalaria</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para mostrar/ocultar contraseña -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = togglePassword.querySelector('.material-icons');
        
        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });

        // Validación del DNI antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const dniInput = document.getElementById('document_id');
            if (!/^\d{8}$/.test(dniInput.value)) {
                e.preventDefault();
                dniInput.focus();
                alert('El DNI debe tener exactamente 8 dígitos numéricos');
            }
        });
    </script>
</body>
</html>