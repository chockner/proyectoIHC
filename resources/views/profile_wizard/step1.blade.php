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
                    <p class="text-gray-600 text-sm">Paso 1 de 3: Información Personal</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-blue-600">Progreso</span>
                        <span class="text-sm font-medium text-gray-500">33%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 33%"></div>
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
                <form action="{{ route('profile.wizard.step1') }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Nombre y Apellido -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre
                                *</label>
                            <input type="text" name="first_name" id="first_name"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('first_name') border-red-300 @enderror"
                                placeholder="Ingrese su nombre" value="{{ old('first_name') }}"
                                onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"required />
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido
                                *</label>
                            <input type="text" name="last_name" id="last_name"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('last_name') border-red-300 @enderror"
                                placeholder="Ingrese su apellido" value="{{ old('last_name') }}"
                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" onkeyup="this.value = this.value.toUpperCase();"
                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');" required />
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fecha de Nacimiento y Género -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                Nacimiento *</label>
                            <input type="date" name="birthdate" id="birthdate"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('birthdate') border-red-300 @enderror"
                                value="{{ old('birthdate') }}" required />
                            @error('birthdate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Género *</label>
                            <select name="gender" id="gender"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('gender') border-red-300 @enderror"
                                required>
                                <option value="">Seleccione género</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Teléfono y Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono
                                *</label>
                            <input type="tel" name="phone" id="phone"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('phone') border-red-300 @enderror"
                                placeholder="Ej: 999888777" value="{{ old('phone') }}" maxlength="9"
                                inputmode="numeric" pattern="9\d{8}"
                                oninput="this.value = this.value.replace(/\D/g, '');
                                if (this.value.length === 1 && this.value !== '9') {
                                    this.value = '';
                                }
                                if (this.value.length > 9) {
                                    this.value = this.value.slice(0, 9);
                                }
                                "required />
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-300 @enderror"
                                placeholder="ejemplo@correo.com" value="{{ old('email') }}" required />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Estado Civil -->
                    <div>
                        <label for="civil_status" class="block text-sm font-medium text-gray-700 mb-1">Estado
                            Civil</label>
                        <select name="civil_status" id="civil_status"
                            class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('civil_status') border-red-300 @enderror">
                            <option value="">Seleccione estado civil</option>
                            <option value="S" {{ old('civil_status') == 'S' ? 'selected' : '' }}>Soltero/a
                            </option>
                            <option value="C" {{ old('civil_status') == 'C' ? 'selected' : '' }}>Casado/a
                            </option>
                            <option value="V" {{ old('civil_status') == 'V' ? 'selected' : '' }}>Viudo/a</option>
                            <option value="D" {{ old('civil_status') == 'D' ? 'selected' : '' }}>Divorciado/a
                            </option>
                        </select>
                        @error('civil_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Región</label>
                            <input
                                type="text"
                                name="region"
                                id="region"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('region') border-red-300 @enderror"
                                placeholder="Ej: Lima"
                                value="{{ old('region') }}"
                            />
                            @error('region')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                            <input
                                type="text"
                                name="province"
                                id="province"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('province') border-red-300 @enderror"
                                placeholder="Ej: Lima"
                                value="{{ old('province') }}"
                            />
                            @error('province')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
                            <input
                                type="text"
                                name="district"
                                id="district"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('district') border-red-300 @enderror"
                                placeholder="Ej: Miraflores"
                                value="{{ old('district') }}"
                            />
                            @error('district')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div> --}}

                    <!-- Dirección Completa -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección
                            Completa</label>
                        <input type="text" name="address" id="address"
                            class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('address') border-red-300 @enderror"
                            placeholder="Ej: Av. Arequipa 123, Oficina 456" value="{{ old('address') }}" />
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto de Perfil -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil
                            (Opcional)</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('photo') border-red-300 @enderror" />
                        <p class="mt-1 text-sm text-gray-500">Formatos permitidos: JPG, PNG, GIF. Máximo 2MB.</p>
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-6">
                        <div></div> <!-- Espacio vacío para centrar el botón -->
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
