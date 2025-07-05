<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Hospital</title>
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

    @stack('scripts')
    <style>
        body {
            background-color: #e7e8eb;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            /* color: #eae9f0; */
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
            padding: 15px;
            border-bottom: 2px solid #ddd;
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
            background-color: #0b5ed7;
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

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            /* Color predeterminado de texto */
        }

        .sidebar-link svg {
            transition: color 0.3s ease;
            color: #0d6efd;
            /* Color azul por defecto del ícono */
        }

        .sidebar-link.active-link svg {
            color: #ffffff;
            /* Cambiar a blanco (o cualquier otro color que resalte) cuando está activo */
        }

        .sidebar-link.active-link {
            background-color: #0d6efd;
            /* Fondo azul cuando está activo */
            color: #ffffff;
            /* Color del texto cuando está activo */
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h4>Hospital</h4>
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
                <a href="/dashboard" class="{{ request()->routeIs('dashboard') ? 'active-link' : '' }}">Inicio</a>

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
                                    <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        style="width: 20px; height: 20px; flex-shrink: 0;">
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
                                    class="{{ request()->routeIs('admin.secretaria.index') ? 'active-link' : '' }}">
                                    Secretarias
                                </a>
                            </li>
                        </ul>
                        {{-- ESPECIALIDADES --}}
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('admin.especialidad.index') }}"
                                    class="{{ request()->routeIs('admin.especialidad.index') ? 'active-link' : '' }}">
                                    Especialidades
                                </a>
                            </li>
                        </ul>
                        {{-- PACIENTES --}}
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('admin.paciente.index') }}"
                                    class="{{ request()->routeIs('admin.paciente.index') ? 'active-link' : '' }}">
                                    Pacientes
                                </a>
                            </li>
                        </ul>
                        {{-- Histias Medicas --}}
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('admin.historialMedico.index') }}"
                                    class="{{ request()->routeIs('admin.historialMedico.index') ? 'active-link' : '' }}">
                                    Historias Medicas
                                </a>
                            </li>

                        </ul>
                        {{-- Horarios --}}
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="{{ route('admin.horarios.index') }}"
                                    class="{{ request()->routeIs('admin.horarios.index') ? 'active-link' : '' }}">
                                    Horarios
                                </a>
                            </li>
                        </ul>
                        {{-- Citas --}}
                        <ul class="list-unstyled ps-3">
                            <li>
                                <a href="#" {{-- <a href="{{ route('admin.citas.index') }}" --}} {{-- class="{{ request()->routeIs('admin.citas.index') ? 'active-link' : '' }}" --}}>
                                    Citas
                                </a>
                            </li>

                        </ul>
                    </div>
                @endif

                {{-- DOCTOR --}}
                @if (Auth::user()->role->name == 'doctor')
                    {{-- Doctor --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="#">Pacientes</a>
                        <a href="#">Citas</a>
                    </div>
                @endif

                {{-- PACIENTE --}}
                @if (Auth::user()->role->name == 'paciente')
                    {{-- Paciente --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="#">Histias Medicas</a>
                        <a href="{{ route('paciente.agendarCita.create') }}">Agendar Cita</a>
                    </div>
                @endif

                {{-- SECRETARIA --}}
                @if (Auth::user()->role->name == 'secretaria')
                    {{-- Secretaria --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="{{ route('secretaria.citas.index') }}">Citas</a> {{-- {{ route('secretaria.citas.index') }} --}}
                        <a href="#">Reportes</a>
                    </div>
                @endif

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
                                <form action="{{ route('logout') }}" method="POST">
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
@yield('scripts')

</html>
