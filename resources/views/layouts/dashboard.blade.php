<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Control - Hospital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" /> -->
    <link href="ico-secre.ico" rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=home" />

    <style>
        body {
            background-color: #e7e8eb;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
            background-color: #ffffff;
            border: #ddd 2px solid;
        }


        .sidebar a {
            /* color: white; */
            text-decoration: none;
            padding: 12px;
            display: block;
        }

        .sidebar a:hover {
            /* background-color: #0059b3; */
        }

        .topbar {
            background-color: #ffffff;
            padding: 20px;
            border-bottom: 20px solid #ddd;
        }

        .main-content {
            padding: 25px;
        }

        .active-link {
            background-color: #0d6efd;
            /* azul Bootstrap */
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            text-decoration: none;
        }

        .active-link:hover {
            /* background-color: #0b5ed7; */
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

        .material-icons.text-xs {
            font-size: 12px;
            /* Tamaño fijo para el ícono secundario */
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            /* Color predeterminado de texto */
        }

        .sidebar-link svg {
            transition: color 0.3s ease;
            color: #474b4e;
            /* Color azul por defecto del ícono */
        }

        .sidebar-link.active-link svg {
            color: #474b4e;
            /* Cambiar a blanco (o cualquier otro color que resalte) cuando está activo */
        }

        .sidebar-link.active-link {
            /* background-color: #0d6efd; */
            background-color: #c6dcf6;
            /* Fondo azul cuando está activo */
            color: #333;
            /* Color del texto cuando está activo */
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <div class="flex-grow-1">
                <h4 class="text-center mb-4"><strong>Hospital</strong></h4>
                <hr>
                @if (!Auth::user()->profile)
                    <div
                        class="alert alert-warning mt-4 text-center fw-bold d-flex justify-content-between align-items-center">
                        <span>Antes de continuar, por favor </span>
                        <a href="{{ route('perfil.edit') }}" class="btn btn-warning btn-sm ms-3 fw-bold">
                            Completar perfil.
                        </a>
                    </div>
                @else
                    {{-- Primera opción de la sidebar(Dashboard) --}}
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('dashboard') ? 'active-link' : '' }}"
                        style="display: flex; align-items: center; gap: 10px;">

                        <div class="text-[#1A75FF]">
                            <span class="material-icons text-4xl">grid_view</span>
                        </div>
                        <h4
                            class="text-gray-800 text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                            Dashboard</h4>
                    </a>
                    {{-- Fin Primera opción de la sidebar --}}

                    {{-- ADMINISTRADOR --}}
                    @if (Auth::user()->role->name == 'admin')
                        {{-- Admin --}}
                        <div class="mb-2">
                            <strong>Gestión</strong>
                            {{-- DOCTORES --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.doctor.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.doctor.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <!-- Icono SVG (Doctores) -->
                                        <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;">
                                            <path
                                                d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z" />
                                        </svg>
                                        <span>Doctores</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- SECRETARIAS --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.secretaria.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.secretaria.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        {{-- Secretarias --}}
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">support_agent</span>
                                        <span>Secretaria</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- ESPECIALIDADES --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.especialidad.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.especialidad.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">medical_information</span>
                                        <span>Especialidad</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- PACIENTES --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.paciente.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.paciente.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">assist_walker</span>
                                        <span>Pacientes</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- Historias Médicas --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.historialMedico.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.historialMedico.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">assignment</span>
                                        <span>Historias Médicas</span>
                                    </a>
                                </li>

                            </ul>
                            {{-- Horarios --}}
                            <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="{{ route('admin.horarios.index') }}"
                                        class="sidebar-link {{ request()->routeIs('admin.horarios.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">schedule</span>
                                        <span>Horarios</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- Citas --}}
                            {{-- <ul class="list-unstyled ps-3">
                                <li>
                                    <a href="#"
                                        class=" sidebar-link{{ request()->routeIs('admin.citas.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">
                                        <span class="material-icons text-gray-500 text-2xl" fill="currentColor"
                                            style="flex-shrink: 0;">calendar_today</span>
                                        <span>Citas</span>
                                    </a>
                                </li>

                            </ul> --}}
                        </div>
                    @endif

                    {{-- DOCTOR --}}
                    @if (Auth::user()->role->name == 'doctor')
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('doctor.pacientes.index') }}"
                                    class="sidebar-link {{ request()->routeIs('doctor.pacientes.index') ? 'active-link' : '' }}"
                                    style="display: flex; align-items: center; gap: 10px;">
                                    <span class="material-icons text-gray-500 text-2xl"
                                        style="flex-shrink: 0;">assist_walker</span>
                                    <span>Pacientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('doctor.citas.index') }}"
                                    class="sidebar-link {{ request()->routeIs('doctor.citas.index') ? 'active-link' : '' }}"
                                    style="display: flex; align-items: center; gap: 10px;">
                                    <span class="material-icons text-gray-500 text-2xl"
                                        style="flex-shrink: 0;">calendar_today</span>
                                    <span>Citas</span>
                                </a>
                            </li>
                        </ul>
                    @endif

                    {{-- PACIENTE --}}
                    @if (Auth::user()->role->name == 'paciente')
                        {{-- Paciente --}}
                        <div class="mb-2">
                            <strong>Gestión</strong>

                            <ul class="list-unstyled ps-3">
                                <!-- Mi perfil -->
                                <li>
                                    <a href="{{ route('perfil.edit') }}"
                                        class="sidebar-link {{ request()->routeIs('perfil.edit') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">

                                        <div class="text-[#1A75FF]">
                                            <span class="material-icons text-4xl">person</span>
                                        </div>
                                        <h4
                                            class="text-gray-800 text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                                            Mi perfil</h4>
                                    </a>
                                </li>
                                <!-- Fin Mi perfil -->

                                <!-- Reservar cita -->
                                <li>
                                    <a href="{{ route('paciente.agendarCita.create') }}"
                                        class="sidebar-link {{ request()->routeIs('paciente.agendarCita.create') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">

                                        <div class="text-[#1A75FF] relative">
                                            <span class="material-icons text-4xl">calendar_month</span>
                                            <span
                                                class="material-icons absolute -top-2.5 -right-3 text-1xl p-2.5 text-green-500">add_circle</span>
                                        </div>
                                        <h4
                                            class="text-gray-800 text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                                            Reservar cita</h4>
                                    </a>
                                </li>
                                <!-- Fin Reservar cita -->

                                <!-- Mis citas -->
                                <li>
                                    <a href="{{ route('paciente.citas.index') }}"
                                        class="sidebar-link {{ request()->routeIs('paciente.citas.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">

                                        <div class="text-[#1A75FF] relative">
                                            <span class="material-icons text-4xl">calendar_month</span>
                                        </div>
                                        <h4
                                            class="text-gray-800 text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                                            Mis citas</h4>
                                    </a>
                                </li>
                                <!-- Fin Mis citas -->

                                <!-- Historial Medico -->
                                <li>
                                    <a href="{{ route('paciente.historialMedico.index') }}"
                                        class="sidebar-link {{ request()->routeIs('paciente.historialMedico.index') ? 'active-link' : '' }}"
                                        style="display: flex; align-items: center; gap: 10px;">

                                        <div class="text-[#1A75FF]">
                                            <span class="material-icons text-4xl">medical_information</span>
                                        </div>
                                        <h4
                                            class="text-gray-800 text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                                            Historial Médico</h4>
                                    </a>
                                </li>
                                <!-- Fin Historial Médico -->

                                <!-- Notificaciones -->

                                <!-- Fin Notificaciones -->
                            </ul>
                        </div>
                    @endif

                    {{-- SECRETARIA --}}
                    @if (Auth::user()->role->name == 'secretaria')
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('secretaria.citas.index') }}"
                                    class="sidebar-link {{ request()->routeIs('secretaria.citas.index') ? 'active-link' : '' }}"
                                    style="display: flex; align-items: center; gap: 10px;">
                                    <span class="material-icons text-gray-500 text-2xl"
                                        style="flex-shrink: 0;">calendar_today</span>
                                    <span>Citas</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" {{-- class="sidebar-link {{ request()->routeIs('secretaria.reportes.index') ? 'active-link' : '' }}" --}}
                                    style="display: flex; align-items: center; gap: 10px;">
                                    <span class="material-icons text-gray-500 text-2xl"
                                        style="flex-shrink: 0;">assessment</span>
                                    <span>Reportes</span>
                                </a>
                            </li>
                        </ul>
                    @endif

            </div>
            <!-- Cerrar session -->
            <div class="mt-auto">
                <hr class="my-4">
                <a href="{{ route('logout') }}" class="sidebar-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="display: flex; align-items: center; gap: 10px;">
                    <div class="text-[#ff1a1a]">
                        <span class="material-icons text-4xl">logout</span>
                    </div>
                    <h4
                        class="text-[#ff1a1a] text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                        Cerrar sesión</h4>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @endif

        </div>

        <!-- Content -->
        <div class="flex-grow-1">
            <div class="topbar d-flex justify-content-between align-items-center p-3 border-bottom bg-light">
                <span class="fw-bold">Bienvenido al sistema</span>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">{{ now()->format('d/m/Y') }}</span>

                    <!-- Dropdown de usuario -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=32"
                                alt="avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item {{ !Auth::user()->profile ? 'bg-warning text-dark fw-bold' : '' }}"
                                    href="{{ route('perfil.edit') }}">
                                    Editar perfil
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main-content p-4">

                @hasSection('content')
                    @yield('content')
                @else
                    <div class="alert alert-warning">
                        No hay contenido definido para esta vista
                    </div>
                @endif

            </div>
        </div>

    </div>

</body>
@stack('scripts')

</html>
