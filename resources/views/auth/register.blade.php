@extends('layouts.public')

@section('content')
<main class="flex flex-1 justify-center py-10 sm:py-16">
    <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl sm:p-8">
        <div class="mb-6 flex flex-col items-center">
            <a href="{{ route('home') }}" class="mb-4 text-5xl text-[#0c7ff2] hover:text-blue-600 transition-colors">
                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 4C12.9543 4 4 7.25611 4 11.2727C4 14.0109 8.16144 16.3957 14.31 17.6364C8.16144 18.877 4 21.2618 4 24C4 26.7382 8.16144 29.123 14.31 30.3636C8.16144 31.6043 4 33.9891 4 36.7273C4 40.7439 12.9543 44 24 44C35.0457 44 44 40.7439 44 36.7273C44 33.9891 39.8386 31.6043 33.69 30.3636C39.8386 29.123 44 26.7382 44 24C44 21.2618 39.8386 18.877 33.69 17.6364C39.8386 16.3957 44 14.0109 44 11.2727C44 7.25611 35.0457 4 24 4Z" fill="currentColor"></path>
                    <path clip-rule="evenodd" d="M24 12C22.8954 12 22 12.8954 22 14V22H14C12.8954 22 12 22.8954 12 24C12 25.1046 12.8954 26 14 26H22V34C22 35.1046 22.8954 36 24 36C25.1046 36 26 35.1046 26 34V26H34C35.1046 26 36 25.1046 36 24C36 22.8954 35.1046 22 34 22H26V14C26 12.8954 25.1046 12 24 12Z" fill="rgb(248,250,252)" fill-rule="evenodd"></path>
                </svg>
            </a>
            <h2 class="mb-2 text-center text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Crear nueva Cuenta
            </h2>
        </div>

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block pb-1.5 text-sm font-medium text-slate-700" for="document_id">
                    DNI
                </label>
                <input
                    class="form-input block w-full rounded-lg border-slate-300 bg-slate-50 p-3 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-[#0c7ff2] focus:ring-[#0c7ff2]"
                    id="document_id" 
                    name="document_id" 
                    placeholder="Ingrese su número de DNI"
                    type="text"
                    maxlength="8" 
                    inputmode="numeric" 
                    pattern="\d{8}" 
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                    title="Ingrese exactamente 8 dígitos numéricos"
                    required
                />
            </div>
            
            <div class="relative">
                <label class="block pb-1.5 text-sm font-medium text-slate-700" for="password">
                    Crear Contraseña
                </label>
                <input
                    class="form-input block w-full rounded-lg border-slate-300 bg-slate-50 p-3 pr-10 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-[#0c7ff2] focus:ring-[#0c7ff2]"
                    id="password" 
                    name="password"
                    placeholder="Mínimo 8 caracteres" 
                    type="password"
                    required
                />
                <button
                    class="absolute inset-y-0 right-0 top-7 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                    type="button">
                    <span class="material-icons text-xl">visibility_off</span>
                </button>
            </div>
            
            <div class="relative">
                <label class="block pb-1.5 text-sm font-medium text-slate-700" for="password_confirmation">
                    Confirmar Contraseña
                </label>
                <input
                    class="form-input block w-full rounded-lg border-slate-300 bg-slate-50 p-3 pr-10 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-[#0c7ff2] focus:ring-[#0c7ff2]"
                    id="password_confirmation" 
                    name="password_confirmation"
                    placeholder="Repita su contraseña" 
                    type="password"
                    required
                />
                <button
                    class="absolute inset-y-0 right-0 top-7 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                    type="button">
                    <span class="material-icons text-xl">visibility_off</span>
                </button>
            </div>
            
            <div class="flex items-start">
                <div class="flex h-5 items-center">
                    <input
                        class="h-4 w-4 rounded border-slate-300 bg-slate-50 text-[#0c7ff2] checked:border-[#0c7ff2] checked:bg-[#0c7ff2] checked:bg-[image:var(--checkbox-tick-svg)] focus:ring-2 focus:ring-[#0c7ff2] focus:ring-offset-2 focus:ring-offset-white"
                        id="terms" 
                        name="terms" 
                        type="checkbox"
                        required
                    />
                </div>
                <div class="ml-3 text-sm">
                    <label class="font-normal text-slate-600" for="terms">
                        He leído y acepto los
                        <a class="font-medium text-[#0c7ff2] hover:underline" href="#">
                            Términos y Condiciones
                        </a>
                        y la
                        <a class="font-medium text-[#0c7ff2] hover:underline" href="#">
                            Política de Privacidad
                        </a>.
                    </label>
                </div>
            </div>
            
            <div class="hidden rounded-md bg-red-50 p-3 text-sm text-red-600" id="error-message-area">
                Por favor, complete todos los campos obligatorios y acepte los términos.
            </div>
            
            <button
                class="flex w-full cursor-pointer items-center justify-center rounded-lg bg-[#0c7ff2] px-5 py-3 text-base font-semibold text-white shadow-md transition-colors hover:bg-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#0c7ff2] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                type="submit">
                <span>Registrarme</span>
            </button>
            
            <div class="mt-6 text-center text-sm text-slate-600">
                ¿Ya tiene una cuenta?
                <a class="font-medium text-[#0c7ff2] hover:underline" href="{{ route('login') }}">
                    Inicie Sesión
                </a>
            </div>
        </form>
    </div>
</main>

<style>
    :root {
        --checkbox-tick-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(248,250,252)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e');
    }
    
    .form-input:focus {
        outline: 2px solid #0c7ff2 !important;
        outline-offset: 1px !important;
        border-color: transparent !important;
    }
</style>

<script>
    // Basic form validation and button enable/disable
    const form = document.querySelector('form');
    const dniInput = document.getElementById('document_id');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');
    const registerButton = form.querySelector('button[type="submit"]');
    const errorMessageArea = document.getElementById('error-message-area');
    
    function validateForm() {
        const dniFilled = dniInput.value.trim() !== '';
        const passwordFilled = passwordInput.value.trim() !== '';
        const confirmPasswordFilled = confirmPasswordInput.value.trim() !== '';
        const passwordsMatch = passwordInput.value === confirmPasswordInput.value;
        const termsAccepted = termsCheckbox.checked;
        let isValid = dniFilled && passwordFilled && confirmPasswordFilled && passwordsMatch && termsAccepted;
        
        registerButton.disabled = !isValid;
        
        if (!isValid && (dniInput.value || passwordInput.value || confirmPasswordInput.value || termsCheckbox.checked)) {
            errorMessageArea.classList.remove('hidden');
            let errorText = 'Por favor corrija lo siguiente:';
            if (!dniFilled) errorText += '<br>- El DNI es obligatorio.';
            if (!passwordFilled) errorText += '<br>- La contraseña es obligatoria.';
            if (!confirmPasswordFilled) errorText += '<br>- Por favor confirme su contraseña.';
            else if (!passwordsMatch && confirmPasswordFilled) errorText += '<br>- Las contraseñas no coinciden.';
            if (!termsAccepted) errorText += '<br>- Debe aceptar los Términos y Condiciones y la Política de Privacidad.';
            errorMessageArea.innerHTML = errorText;
        } else {
            errorMessageArea.classList.add('hidden');
            errorMessageArea.textContent = '';
        }
        return isValid;
    }
    
    [dniInput, passwordInput, confirmPasswordInput, termsCheckbox].forEach(input => {
        input.addEventListener('input', validateForm);
        input.addEventListener('change', validateForm);
    });
    
    // Password visibility toggle
    const passwordToggleButtons = document.querySelectorAll('.relative button[type="button"]');
    passwordToggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const input = button.previousElementSibling;
            const icon = button.querySelector('.material-icons');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        });
    });
</script>
@endsection
