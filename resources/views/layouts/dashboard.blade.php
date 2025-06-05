<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    


    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #004080;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #0059b3;
        }
        .topbar {
            background-color: #ffffff;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .main-content {
            padding: 25px;
        }
        .btn-warning {
            background-color: #007bff;
            border: none;
            color: white;
        }
        .btn-warning:hover {
            background-color: #0056b3;
        }

        .accordion-item {
        background-color: #004080; /* Cambia el color de fondo del acordeón */
        border: none; /* Elimina el borde del acordeón */
        }

        .accordion-button {
            background-color: #004080; /* Cambia el color de fondo del botón del acordeón */
            color: white; /* Cambia el color del texto del botón */
            border: none; /* Elimina el borde del botón */
            transition: box-shadow 0.3s ease, transform 0.3s ease; /* Transición suave */
            position: relative; /* Necesario para personalizar la flecha */
        }

        .accordion-button::after {
            content: '\25BC'; /* Define la flecha blanca (Unicode para flecha hacia abajo) */
            color: white !important; /* Cambia el color de la flecha a blanco */
            font-size: 1.2rem; /* Aumenta el tamaño de la flecha */
            transition: transform 0.3s ease; /* Transición suave para la rotación */
        }

        /* Cuando el acordeón está colapsado, rota la flecha hacia la derecha */
        .accordion-button.collapsed::after {
            transform: rotate(0deg); /* Gira la flecha hacia la derecha */
        }

        .accordion-button:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Agrega una sombra al pasar el mouse */
            transform: scale(1.02); /* Aumenta ligeramente el tamaño */
            cursor: pointer; /* Cambia el cursor a "pointer" */
        }

        .accordion-item:hover {
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.2); /* Agrega una sombra al pasar el mouse */
            transform: scale(1.02); /* Aumenta ligeramente el tamaño */
            cursor: pointer; /* Cambia el cursor a "pointer" */
        }

        .accordion-body a {
            display: block;
            padding: 5px 10px; /* Reduce el relleno */
            margin: 2px 0; /* Reduce el margen */
            font-size: 14px; /* Ajusta el tamaño de la fuente si es necesario */
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
                <div class="alert alert-warning mt-4 text-center fw-bold d-flex justify-content-between align-items-center">
                    <span>Antes de continuar, por favor </span>
                    <a href="{{ route('perfil.edit') }}" class="btn btn-warning btn-sm ms-3 fw-bold">
                        Completar perfil.
                    </a>
                </div>
            @else

                <a href="/dashboard">Inicio</a>
                
                {{-- ADMINISTRADOR --}}
                @if (Auth::user()->role->name == 'admin') {{-- Admin --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        {{-- DOCTORES --}}
                        <div class="accordion">
                            <a href="{{ route('admin.doctor.index') }}" class="accordion-header text-white text-decoration-none d-block p-3" style="font-size: 1rem;">
                            Doctores
                            </a>
                        </div>

                        {{-- SECRETARIAS --}}
                        <div class="accordion" id="accordionSecretarias">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingSecretarias">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecretarias" aria-expanded="false" aria-controls="collapseSecretarias">
                                        Secretarias
                                    </button>
                                </h2>
                                <div id="collapseSecretarias" class="accordion-collapse collapse" aria-labelledby="headingSecretarias" data-bs-parent="#accordionSecretarias">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="{{ route('admin.secretaria.index') }}">Ver todos</a>   
                                            <a href="{{ route('admin.secretaria.create') }}">Agregar nuevo</a>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ESPECIALIDADES --}}
                        <div class="accordion" id="accordionEspecialidades">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingEspecialidades">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspecialidades" aria-expanded="false" aria-controls="collapseEspecialidades">
                                        Especialidades
                                    </button>
                                </h2>
                                <div id="collapseEspecialidades" class="accordion-collapse collapse" aria-labelledby="headingEspecialidades" data-bs-parent="#accordionEspecialidades">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="{{ route('admin.especialidad.index') }}">Ver todos</a> 
                                            <a href="{{ route('admin.especialidad.create') }}">Agregar nuevo</a>    
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- PACIENTES --}}
                        <div class="accordion" id="accordionPacientes">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingPacientes">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePacientes" aria-expanded="false" aria-controls="collapsePacientes">
                                        Pacientes
                                    </button>
                                </h2>
                                <div id="collapsePacientes" class="accordion-collapse collapse" aria-labelledby="headingPacientes" data-bs-parent="#accordionPacientes">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="{{ route('admin.paciente.index') }}">Ver todos</a>   
                                            <a href="{{ route('admin.paciente.create') }}">Agregar nuevo</a>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Histias Medicas --}}
                        <div class="accordion" id="accordionHistiasMedicas">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingHistiasMedicas">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistiasMedicas" aria-expanded="false" aria-controls="collapseHistiasMedicas">
                                        Historias Médicas
                                    </button>
                                </h2>
                                <div id="collapseHistiasMedicas" class="accordion-collapse collapse" aria-labelledby="headingHistiasMedicas" data-bs-parent="#accordionHistiasMedicas">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="{{ route('admin.historialMedico.index') }}">Ver todos</a>   
                                            <a href="#">Agregar nuevo</a>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Horarios --}}
                        <div class="accordion" id="accordionHorarios">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingHorarios">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHorarios" aria-expanded="false" aria-controls="collapseHorarios">
                                        Horarios
                                    </button>
                                </h2>
                                <div id="collapseHorarios" class="accordion-collapse collapse" aria-labelledby="headingHorarios" data-bs-parent="#accordionHorarios">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="{{ route('admin.horarios.index') }}">Ver todos</a>   
                                            <a href="#">Agregar nuevo</a>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Citas --}}
                        <div class="accordion" id="accordionCitas">
                            <div class="accordion-item bg-primary">
                                <h2 class="accordion-header" id="headingCitas">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCitas" aria-expanded="false" aria-controls="collapseCitas">
                                        Citas
                                    </button>
                                </h2>
                                <div id="collapseCitas" class="accordion-collapse collapse" aria-labelledby="headingCitas" data-bs-parent="#accordionCitas">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled ps-3">
                                            <a href="#">Ver todos</a>   
                                            <a href="#">Agregar nuevo</a>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- DOCTOR --}}
                @if (Auth::user()->role->name == 'doctor') {{-- Doctor --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="#">Pacientes</a>
                        <a href="#">Citas</a>
                    </div>
                    
                @endif

                {{-- PACIENTE --}}
                @if (Auth::user()->role->name == 'paciente') {{-- Paciente --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="#">Histias Medicas</a>
                        <a href="#">Citas</a>
                    </div>
                @endif

                {{-- SECRETARIA --}}
                @if (Auth::user()->role->name == 'secretaria') {{-- Secretaria --}}
                    <div class="mb-2">
                        <strong>Gestión</strong>
                        <a href="#">Citas</a>
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
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=32" alt="avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item {{ !Auth::user()->profile ? 'bg-warning text-dark fw-bold' : '' }}" href="{{ route('perfil.edit') }}">
                                    Editar perfil
                                </a>
                            </li>
                            
                            <li><hr class="dropdown-divider"></li>
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
                @yield('content')
            </div>
        </div>

    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {

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
        .then(([depts, provs, dists]) => {
            departamentos = depts;
            provincias = provs;
            distritos = dists;

            cargarRegiones();
        });

        function cargarRegiones() {
            departamentos.forEach(dep => {
                const option = new Option(dep.name, dep.id);
                regionSelect.add(option);
            });
        }

        regionSelect.addEventListener('change', function () {
            provinceSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
            districtSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
            districtSelect.disabled = true;

            const depId = this.value;
            const provsFiltradas = provincias.filter(p => p.department_id === depId);

            provsFiltradas.forEach(prov => {
                const option = new Option(prov.name, prov.id);
                provinceSelect.add(option);
            });

            provinceSelect.disabled = false;
        });

        provinceSelect.addEventListener('change', function () {
            districtSelect.innerHTML = '<option value="">Seleccione un distrito</option>';

            const provId = this.value;
            const distsFiltradas = distritos.filter(d => d.province_id === provId);

            distsFiltradas.forEach(dist => {
                const option = new Option(dist.name, dist.name);
                districtSelect.add(option);
            });

            districtSelect.disabled = false;
        });

        // Asignar los nombres a los inputs ocultos al seleccionar región, provincia y distrito
        regionSelect.addEventListener('change', function () {
            const selectedRegion = departamentos.find(dep => dep.id == this.value);
            document.getElementById('region_nombre').value = selectedRegion ? selectedRegion.name : '';
        });

        provinceSelect.addEventListener('change', function () {
            const selectedProvince = provincias.find(prov => prov.id == this.value);
            document.getElementById('province_nombre').value = selectedProvince ? selectedProvince.name : '';
        });

        districtSelect.addEventListener('change', function () {
            document.getElementById('district_nombre').value = this.value;
        });
    });

</script>

</html>
