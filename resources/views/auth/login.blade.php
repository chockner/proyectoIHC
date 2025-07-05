@extends('layouts.public')

@section('content')
<main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="bg-white p-8 shadow-card rounded-xl">
            <div class="flex justify-center mb-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-blue-600 hover:text-blue-700 transition-colors">
                    <span class="material-icons text-3xl">local_hospital</span>
                    <h1 class="text-2xl font-bold tracking-tight">HealthPlus</h1>
                </a>
            </div>
            
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <input name="remember" type="hidden" value="true" />
                
                <div class="rounded-md -space-y-px">
                    <div>
                        <label class="sr-only" for="document_id">DNI</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400">person</span>
                            </div>
                            <input 
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 border border-input-border placeholder-placeholder-text text-body-text focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                                id="document_id" 
                                name="document_id" 
                                placeholder="Ingrese su DNI" 
                                required
                                type="text"
                                maxlength="8" 
                                inputmode="numeric" 
                                pattern="\d{8}" 
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                                title="Ingrese exactamente 8 dígitos numéricos"
                            />
                        </div>
                    </div>
                    <div class="pt-4">
                        <label class="sr-only" for="password">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-icons text-gray-400">lock</span>
                            </div>
                            <input 
                                autocomplete="current-password"
                                class="appearance-none rounded-lg relative block w-full px-3 py-3 pl-10 border border-input-border placeholder-placeholder-text text-body-text focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                                id="password" 
                                name="password"
                                placeholder="Ingrese su contraseña" 
                                required
                                type="password" 
                            />
                            <button
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                                id="togglePassword" 
                                type="button">
                                <span class="material-icons text-gray-500 hover:text-gray-700">visibility</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end text-sm">
                    <a class="font-medium text-link-text hover:text-primary-hover" href="#">
                        ¿Olvidó su contraseña?
                    </a>
                </div>
                
                <div>
                    <button
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                        type="submit">
                        Iniciar Sesión
                    </button>
                </div>
                
                <div class="text-center text-sm">
                    <p class="text-body-text">¿No tiene cuenta? 
                        <a class="font-semibold text-link-text hover:text-primary-hover" href="{{ route('register') }}">
                            Regístrese aquí
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<style>
    :root {
        --primary: #0c7ff2;
        --primary-hover: #0069d9;
        --secondary: #6c757d;
        --light: #f8f9fa;
        --dark: #343a40;
        --danger: #dc3545;
        --input-border: #cedbe8;
        --input-focus-border: #80bdff;
        --placeholder-text: #6c757d;
        --heading-text: #212529;
        --body-text: #495057;
        --link-text: #0c7ff2;
    }
    
    .shadow-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    
    .text-primary { color: var(--primary); }
    .bg-primary { background-color: var(--primary); }
    .hover\:bg-primary-hover:hover { background-color: var(--primary-hover); }
    .focus\:ring-primary:focus { --tw-ring-color: var(--primary); }
    .focus\:border-primary:focus { border-color: var(--primary); }
    .text-link-text { color: var(--link-text); }
    .hover\:text-primary-hover:hover { color: var(--primary-hover); }
    .text-body-text { color: var(--body-text); }
    .border-input-border { border-color: var(--input-border); }
    .placeholder-placeholder-text::placeholder { color: var(--placeholder-text); }
</style>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = togglePassword.querySelector('.material-icons');
    
    togglePassword.addEventListener('click', function(e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });
</script>
@endsection
