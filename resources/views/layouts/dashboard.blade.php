<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Control - HealthPlus</title>

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
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* Header - debe estar por encima de todo */
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Sin altura fija */
        }

        /* Sidebar principal - debajo del header */
        .sidebar-container {
            position: fixed;
            left: 0;
            <<<<<<< HEAD top: 80px;
            /* Altura del header */
            height: calc(100vh - 80px);
            =======
            /* top y height serán ajustados dinámicamente por JS */
            >>>>>>>058d3ef2cc22f0eaec1a2c5f56aaa8eeaea6708a width: 280px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e2e8f0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        /* Header del sidebar */
        .sidebar-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            color: #475569;
        }

        .sidebar-header h3 {
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            color: #94a3b8;
            margin: 0.25rem 0 0 0;
        }

        /* Contenido del sidebar con scroll */
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Footer del sidebar (logout) */
        .sidebar-footer {
            padding: 1.5rem 1.5rem;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }

        /* Enlaces del sidebar */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(.4, 0, .2, 1);
            border-left: 3px solid transparent;
            margin: 0.25rem 0;
            border-radius: 0.75rem;
            background: transparent;
            box-shadow: none;
        }

        .sidebar-link:hover {
            background: #f0f7ff;
            color: #0c64f2;
            border-left-color: #0c64f2;
            transform: translateX(2px) scale(1.03);
            box-shadow: 0 1px 4px rgba(12, 100, 242, 0.04);
        }

        .sidebar-link.active {
            background: #e6f0ff;
            color: #0c64f2;
            border-left-color: #0c64f2;
            box-shadow: 0 2px 8px 0 rgba(12, 100, 242, 0.08);
            border-radius: 0.75rem;
            font-weight: 600;
            transform: scale(1.03);
        }

        .sidebar-link.active:hover {
            background: #dbeafe;
            color: #0c64f2;
            box-shadow: 0 4px 16px 0 rgba(12, 100, 242, 0.10);
        }

        .sidebar-link+.sidebar-link {
            margin-top: 0.25rem;
        }

        /* Iconos */
        .sidebar-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .sidebar-link .sidebar-icon {
            color: #64748b;
        }

        .sidebar-link.active .sidebar-icon,
        .sidebar-link:hover .sidebar-icon {
            color: #0c64f2;
        }

        /* Texto de los enlaces */
        .sidebar-text {
            font-size: 1rem;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
        }

        /* Secciones del sidebar */
        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-section-title {
            padding: 0.75rem 1.5rem 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Logout especial */
        .logout-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            color: #dc2626;
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .logout-link:hover {
            background: #fee2e2;
            color: #b91c1c;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }

        .logout-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Contenido principal */
        .main-content-wrapper {
            margin-left: 280px;
            <<<<<<< HEAD margin-top: 80px;
            /* Espacio para el header */
            min-height: calc(100vh - 80px);
            =======
            /* margin-top será ajustado dinámicamente por JS */
            >>>>>>>058d3ef2cc22f0eaec1a2c5f56aaa8eeaea6708a background: #f8fafc;
        }

        .main-content {
            padding: 2rem;
        }

        /* Alertas */
        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 0.75rem;
            padding: 1rem;
            margin: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
        }

        /* Material Icons */
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

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                top: 80px;
                /* Mantener debajo del header */
            }

            .sidebar-container.open {
                transform: translateX(0);
            }

            .main-content-wrapper {
                margin-left: 0;
            }
        }

        /* Animaciones */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .sidebar-link {
            animation: slideIn 0.3s ease forwards;
        }

        .sidebar-link:nth-child(1) {
            animation-delay: 0.1s;
        }

        .sidebar-link:nth-child(2) {
            animation-delay: 0.2s;
        }

        .sidebar-link:nth-child(3) {
            animation-delay: 0.3s;
        }

        .sidebar-link:nth-child(4) {
            animation-delay: 0.4s;
        }

        .sidebar-link:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>
</head>

<body>
    <!-- Header Principal -->
    <header class="main-header" id="main-header">
        <x-header />

    </header>


    <!-- Sidebar Container -->
    <div class="sidebar-container" id="sidebar-container">
        <!-- Header del Sidebar -->
        <div class="sidebar-header">
            <h3>Navegación</h3>
            <p>Acceso rápido a funciones</p>
        </div>

        <!-- Contenido del Sidebar -->
        <div class="sidebar-content">
            @if (
                !Auth::user()->profile ||
                    !Auth::user()->profile->first_name ||
                    !Auth::user()->profile->last_name ||
                    !Auth::user()->profile->email)
                <div class="alert-warning">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-amber-800">Completa tu perfil</span>
                        <a href="{{ route('profile.wizard.step1') }}"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Completar
                        </a>
                    </div>
                </div>
            @else
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="sidebar-icon">
                        <span class="material-icons">grid_view</span>
                    </div>
                    <span class="sidebar-text">Inicio</span>
                </a>

                {{-- ADMINISTRADOR --}}
                @if (Auth::user()->role->name == 'admin')
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Gestión</div>

                        <a href="{{ route('admin.doctor.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.doctor.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    style="width: 20px; height: 20px;">
                                    <path
                                        d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z" />
                                </svg>
                            </div>
                            <span class="sidebar-text">Doctores</span>
                        </a>

                        <a href="{{ route('admin.secretaria.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.secretaria.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">support_agent</span>
                            </div>
                            <span class="sidebar-text">Secretarias</span>
                        </a>

                        <a href="{{ route('admin.especialidad.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.especialidad.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">medical_information</span>
                            </div>
                            <span class="sidebar-text">Especialidades</span>
                        </a>

                        <a href="{{ route('admin.paciente.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.paciente.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">assist_walker</span>
                            </div>
                            <span class="sidebar-text">Pacientes</span>
                        </a>

                        <a href="{{ route('admin.historialMedico.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.historialMedico.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">assignment</span>
                            </div>
                            <span class="sidebar-text">Historias Médicas</span>
                        </a>

                        <a href="{{ route('admin.horarios.index') }}"
                            class="sidebar-link {{ request()->routeIs('admin.horarios.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">schedule</span>
                            </div>
                            <span class="sidebar-text">Horarios</span>
                        </a>
                    </div>
                @endif

                {{-- DOCTOR --}}
                @if (Auth::user()->role->name == 'doctor')
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Gestión Médica</div>

                        <a href="{{ route('doctor.pacientes.index') }}"
                            class="sidebar-link {{ request()->routeIs('doctor.pacientes.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">assist_walker</span>
                            </div>
                            <span class="sidebar-text">Mis Pacientes</span>
                        </a>

                        <a href="{{ route('doctor.citas.index') }}"
                            class="sidebar-link {{ request()->routeIs('doctor.citas.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">calendar_today</span>
                            </div>
                            <span class="sidebar-text">Mis Citas</span>
                        </a>
                    </div>
                @endif

                {{-- PACIENTE --}}
                @if (Auth::user()->role->name == 'paciente')
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Servicios</div>

                        <a href="{{ route('perfil.edit') }}"
                            class="sidebar-link {{ request()->routeIs('perfil.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">person</span>
                            </div>
                            <span class="sidebar-text">Mi Perfil</span>
                        </a>

                        <a href="{{ route('paciente.agendarCita.create') }}"
                            class="sidebar-link {{ request()->routeIs('paciente.agendarCita.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">calendar_month</span>
                            </div>
                            <span class="sidebar-text">Reservar Cita</span>
                        </a>

                        <a href="{{ route('paciente.citas.index') }}"
                            class="sidebar-link {{ request()->routeIs('paciente.citas.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">event_note</span>
                            </div>
                            <span class="sidebar-text">Mis Citas</span>
                        </a>

                        <a href="{{ route('paciente.historialMedico.index') }}"
                            class="sidebar-link {{ request()->routeIs('paciente.historialMedico.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">medical_information</span>
                            </div>
                            <span class="sidebar-text">Historia Médica</span>
                        </a>
                    </div>
                @endif

                {{-- SECRETARIA --}}
                @if (Auth::user()->role->name == 'secretaria')
                    <div class="sidebar-section">
                        <div class="sidebar-section-title">Gestión</div>

                        <a href="{{ route('secretaria.citas.index') }}"
                            class="sidebar-link {{ request()->routeIs('secretaria.citas.*') ? 'active' : '' }}">
                            <div class="sidebar-icon">
                                <span class="material-icons">calendar_today</span>
                            </div>
                            <span class="sidebar-text">Citas</span>
                        </a>
                    </div>
                @endif
            @endif
        </div>

        <!-- Footer del Sidebar (Logout) -->
        <div class="sidebar-footer">
            <a href="{{ route('logout') }}" class="logout-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="logout-icon">
                    <span class="material-icons">logout</span>
                </div>
                <span class="sidebar-text">Cerrar Sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content-wrapper" id="main-content-wrapper">
        <div class="main-content pt-32">
            <!-- Mensajes de éxito/error -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="material-icons text-green-400">check_circle</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="material-icons text-red-400">error</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @hasSection('content')
                <div class="container mx-auto">
                    @yield('content')
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <span class="material-icons text-yellow-400 mr-2">warning</span>
                        <span class="text-yellow-800">No hay contenido definido para esta vista</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>

<script>
    // Auto-hide success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.bg-green-50, .bg-red-50');
        messages.forEach(function(message) {
            setTimeout(function() {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            }, 5000);
        });
    });

    function ajustarLayoutDashboard() {
        const header = document.getElementById('main-header');
        const sidebar = document.getElementById('sidebar-container');
        const mainContent = document.getElementById('main-content-wrapper');
        if (header && sidebar && mainContent) {
            const headerHeight = header.offsetHeight;
            sidebar.style.top = headerHeight + 'px';
            sidebar.style.height = 'calc(100vh - ' + headerHeight + 'px)';
            mainContent.style.marginTop = headerHeight + 'px';
            mainContent.style.minHeight = 'calc(100vh - ' + headerHeight + 'px)';
        }
    }
    window.addEventListener('DOMContentLoaded', ajustarLayoutDashboard);
    window.addEventListener('resize', ajustarLayoutDashboard);
</script>

@stack('scripts')

</html>
