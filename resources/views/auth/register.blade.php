@extends('layouts.public')

@section('content')
<div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="bg-white p-8 shadow-card rounded-xl">
            <!-- Logo y Título -->
            <div class="flex justify-center mb-6">
                <div class="text-blue-600 h-16 w-16">
                    <span class="material-icons text-6xl">local_hospital</span>
                </div>
            </div>
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Crear Cuenta</h2>
                <p class="text-gray-600 text-sm">Únete a HealthPlus y comienza tu camino hacia una mejor salud</p>
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
            <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
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
                            value="{{ old('document_id') }}"
                            required
                        >
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
                            autocomplete="new-password"
                            class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-300 @enderror"
                            placeholder="Ingrese su contraseña"
                            required
                        >
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

                <!-- Campo Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="sr-only">Confirmar Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-icons text-gray-400">lock_reset</span>
                        </div>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            autocomplete="new-password"
                            class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password_confirmation') border-red-300 @enderror"
                            placeholder="Confirme su contraseña"
                            required
                        >
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                            id="togglePasswordConfirmation"
                        >
                            <span class="material-icons text-gray-500 hover:text-gray-700">visibility</span>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Términos y Condiciones -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 @error('terms') border-red-300 @enderror"
                            required
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700 leading-relaxed">
                            He leído y acepto los 
                            <a href="#" class="text-blue-600 hover:text-blue-500 underline font-medium">Términos y Condiciones</a> 
                            y la 
                            <a href="#" class="text-blue-600 hover:text-blue-500 underline font-medium">Política de Privacidad</a>
                        </label>
                    </div>
                </div>
                @error('terms')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Botón de Envío -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                        id="submitButton"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <span class="material-icons text-blue-500 group-hover:text-blue-400">person_add</span>
                        </span>
                        Crear Cuenta
                    </button>
                </div>

                <!-- Enlace de Login -->
                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        ¿Ya tiene cuenta? 
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                            Inicie sesión aquí
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseñas y controlar términos -->
<script>
    // Toggle para contraseña principal
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = togglePassword.querySelector('.material-icons');
    
    togglePassword.addEventListener('click', function(e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });

    // Toggle para confirmación de contraseña
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const eyeIconConfirmation = togglePasswordConfirmation.querySelector('.material-icons');
    
    togglePasswordConfirmation.addEventListener('click', function(e) {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        eyeIconConfirmation.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });

    // Control del botón de envío según el checkbox de términos
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.getElementById('submitButton');
    
    function updateSubmitButton() {
        if (termsCheckbox.checked) {
            submitButton.disabled = false;
            submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        }
    }
    
    // Inicializar estado del botón
    updateSubmitButton();
    
    // Escuchar cambios en el checkbox
    termsCheckbox.addEventListener('change', updateSubmitButton);
</script>

<style>
    .shadow-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
