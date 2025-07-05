<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Control - HealthPlus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    @stack('scripts')
    <style>
        .btn-primary {
            background-color: #0c64f2;
            color: white;
        }
        .btn-secondary {
            background-color: #e7ecf4;
            color: #0d131c;
        }
        .text-primary {
            color: #0c64f2;
        }
        .bg-primary-light {
            background-color: #e6f0ff;
        }
        .icon-active {
            color: #0c64f2;
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
</head>

<body class="bg-[#f8f9fc]" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-[#e7ecf4] p-6 space-y-6 sticky top-0 h-screen">
            <div class="flex justify-center mb-2">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-blue-600 hover:text-blue-700 transition-colors">
                    <span class="material-icons text-3xl">local_hospital</span>
                    <h1 class="text-2xl font-bold tracking-tight">HealthPlus</h1>
                </a>
            </div>

            @if (!Auth::user()->profile)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">Antes de continuar, por favor </span>
                    <a href="{{ route('perfil.edit') }}" class="btn-primary text-sm font-medium py-1 px-3 rounded mt-2 inline-block">
                        Completar perfil.
                    </a>
                </div>
            @else
                <nav class="flex flex-col space-y-2 flex-grow">
                    <a href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#0d131c] font-medium {{ request()->routeIs('dashboard') ? 'bg-[#e6f0ff] text-primary' : 'text-[#49699c] hover:text-primary' }}">
                        <div class="{{ request()->routeIs('dashboard') ? 'icon-active' : '' }}" data-icon="House" data-size="24px" data-weight="fill">
                            <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                <path d="M224,115.55V208a16,16,0,0,1-16,16H168a16,16,0,0,1-16-16V168a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v40a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V115.55a16,16,0,0,1,5.17-11.78l80-75.48.11-.11a16,16,0,0,1,21.53,0,1.14,1.14,0,0,0,.11.11l80,75.48A16,16,0,0,1,224,115.55Z"></path>
                            </svg>
                        </div>
                        <span>Inicio</span>
                    </a>

                    <a href="{{ route('perfil.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('perfil.edit') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                        <div data-icon="User" data-size="24px" data-weight="regular">
                            <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                            </svg>
                        </div>
                        <span>Mi Perfil</span>
                    </a>

                {{-- ADMINISTRADOR --}}
                @if (Auth::user()->role->name == 'admin')
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold text-[#0d131c] mb-2">Gestión del Sistema</h3>
                            <a href="{{ route('admin.doctor.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.doctor.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z"></path>
                                    </svg>
                                    <span>Doctores</span>
                                </a>
                            <a href="{{ route('admin.secretaria.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.secretaria.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                </svg>
                                <span>Secretarias</span>
                            </a>
                            <a href="{{ route('admin.especialidad.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.especialidad.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                                </svg>
                                <span>Especialidades</span>
                            </a>
                            <a href="{{ route('admin.paciente.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.paciente.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                </svg>
                                <span>Pacientes</span>
                            </a>
                            <a href="{{ route('admin.historialMedico.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.historialMedico.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"></path>
                                </svg>
                                <span>Historias Médicas</span>
                            </a>
                            <a href="{{ route('admin.horarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('admin.horarios.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                                </svg>
                                <span>Horarios</span>
                            </a>
                    </div>
                @endif

                {{-- DOCTOR --}}
                @if (Auth::user()->role->name == 'doctor')
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold text-[#0d131c] mb-2">Gestión Médica</h3>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                </svg>
                                <span>Mis Pacientes</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                                </svg>
                                <span>Mis Citas</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"></path>
                                </svg>
                                <span>Historias Clínicas</span>
                            </a>
                    </div>
                @endif

                {{-- PACIENTE --}}
                @if (Auth::user()->role->name == 'paciente')
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold text-[#0d131c] mb-2">Servicios</h3>
                            <a href="{{ route('paciente.agendarCita.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('paciente.agendarCita.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
                                </svg>
                                <span>Reservar Cita</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                                </svg>
                                <span>Historial Médico</span>
                            </a>
                    </div>
                @endif

                {{-- SECRETARIA --}}
                @if (Auth::user()->role->name == 'secretaria')
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold text-[#0d131c] mb-2">Gestión</h3>
                            <a href="{{ route('secretaria.citas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium {{ request()->routeIs('secretaria.citas.*') ? 'bg-[#e6f0ff] text-primary' : '' }}">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                                </svg>
                                <span>Gestionar Citas</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#e6f0ff] text-[#49699c] hover:text-primary font-medium">
                                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"></path>
                                </svg>
                                <span>Reportes</span>
                            </a>
                    </div>
                @endif
                </nav>
            @endif

            <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-100 text-red-600 hover:text-red-700 font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div data-icon="SignOut" data-size="24px" data-weight="regular">
                    <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M112,216a8,8,0,0,1-8,8H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h56a8,8,0,0,1,0,16H48V208h56A8,8,0,0,1,112,216Zm109.66-90.34L188,92,174.34,78.34a8,8,0,0,0-11.32,11.32L176.69,103H104a8,8,0,0,0,0,16h72.69l-13.67,13.66a8,8,0,0,0,11.32,11.32L188,128l33.66-33.66A8,8,0,0,0,221.66,125.66Z"></path>
                    </svg>
        </div>
                <span>Cerrar Sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm p-4 lg:px-10 lg:py-5 flex items-center justify-between sticky top-0 z-10">
                <button class="lg:hidden text-[#0d131c]">
                    <svg fill="currentColor" height="28" viewBox="0 0 256 256" width="28" xmlns="http://www.w3.org/2000/svg">
                        <path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,88H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,176H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z"></path>
                    </svg>
                </button>
                <div class="lg:hidden flex items-center gap-2 text-[#0c64f2]">
                    <div class="size-7">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M44 11.2727C44 14.0109 39.8386 16.3957 33.69 17.6364C39.8386 18.877 44 21.2618 44 24C44 26.7382 39.8386 29.123 33.69 30.3636C39.8386 31.6043 44 33.9891 44 36.7273C44 40.7439 35.0457 44 24 44C12.9543 44 4 40.7439 4 36.7273C4 33.9891 8.16144 31.6043 14.31 30.3636C8.16144 29.123 4 26.7382 4 24C4 21.2618 8.16144 18.877 14.31 17.6364C8.16144 16.3957 4 14.0109 4 11.2727C4 7.25611 12.9543 4 24 4C35.0457 4 44 7.25611 44 11.2727Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold">Panel</h2>
                </div>
                <div class="hidden lg:block flex-1"></div>
                <div class="flex items-center gap-4">
                    <button class="relative text-[#49699c] hover:text-[#0c64f2]">
                        <div data-icon="Bell" data-size="24px" data-weight="regular">
                            <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"></path>
                            </svg>
                        </div>
                        <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>
                    <div class="relative group">
                        <button class="flex items-center gap-2">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-200 flex items-center justify-center">
                                @if(Auth::user()->profile && Auth::user()->profile->profile_image)
                                    <img src="{{ asset('storage/' . Auth::user()->profile->profile_image) }}" alt="Foto de perfil" class="w-full h-full rounded-full object-cover">
                                @else
                                    <span class="text-gray-500 text-lg font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <span class="hidden md:inline text-[#0d131c] font-medium">{{ Auth::user()->name ?? 'Usuario' }}</span>
                            <div class="text-[#49699c] hidden md:inline">
                                <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,88H202.34a8,8,0,0,1,11.32,13.66Z"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                            <a class="block px-4 py-2 text-sm text-[#49699c] hover:bg-[#e6f0ff] hover:text-primary" href="{{ route('perfil.edit') }}">Mi Perfil</a>
                            <a class="block px-4 py-2 text-sm text-[#49699c] hover:bg-[#e6f0ff] hover:text-primary" href="#">Configuración</a>
                            <a class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-10 space-y-8">
                @hasSection('content')
                    @yield('content')
                @else
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                        No hay contenido definido para esta vista
                    </div>
                @endif
            </main>
        </div>
    </div>

@yield('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');

        if (!regionSelect || !provinceSelect || !districtSelect) return;

        let departamentos = [];
        let provincias = [];
        let distritos = [];

        Promise.all([
                fetch('/js/ubigeo_peru_2016_departamentos.json').then(res => res.json()),
                fetch('/js/ubigeo_peru_2016_provincias.json').then(res => res.json()),
                fetch('/js/ubigeo_peru_2016_distritos.json').then(res => res.json())
            ])
                .then(([deptos, provs, dists]) => {
                    departamentos = deptos;
                provincias = provs;
                distritos = dists;

                    // Llenar departamentos
                    regionSelect.innerHTML = '<option value="">Seleccione un departamento</option>';
                    departamentos.forEach(depto => {
                        const option = document.createElement('option');
                        option.value = depto.id;
                        option.textContent = depto.nombre;
                        regionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error cargando datos de ubigeo:', error);
                });

            regionSelect.addEventListener('change', function() {
                const selectedDepto = this.value;
                
                // Limpiar provincias y distritos
            provinceSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
            districtSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
                
                if (selectedDepto) {
                    const filteredProvincias = provincias.filter(prov => prov.departamento_id === selectedDepto);
                    
                    filteredProvincias.forEach(prov => {
                        const option = document.createElement('option');
                        option.value = prov.id;
                        option.textContent = prov.nombre;
                        provinceSelect.appendChild(option);
                    });
                }
            });

            provinceSelect.addEventListener('change', function() {
                const selectedProv = this.value;
                
                // Limpiar distritos
            districtSelect.innerHTML = '<option value="">Seleccione un distrito</option>';

                if (selectedProv) {
                    const filteredDistritos = distritos.filter(dist => dist.provincia_id === selectedProv);
                    
                    filteredDistritos.forEach(dist => {
                        const option = document.createElement('option');
                        option.value = dist.id;
                        option.textContent = dist.nombre;
                        districtSelect.appendChild(option);
                    });
                }
        });
    });
</script>
</body>

</html>
