<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Hospital Central</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1rem 0;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="text-center">
        <h1>Hospital Central</h1>
        <p>Atención médica de calidad para todos</p>
    </header>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <!-- Logo / Marca -->
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Inicio</a>

            <!-- Botón para menú móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del menú -->
            <div class="collapse navbar-collapse" id="navMenu">
                <!-- Navegación izquierda -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white" href="#sobre-nosotros">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#especialidades">Especialidades</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contacto">Contacto</a></li>
                </ul>

                <!-- Botones de acción -->
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-light text-primary fw-semibold">Registrarse</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido dinámico -->
    <main class="container py-4">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white pt-4 pb-3 mt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-6 mb-3">
                    <h5 id="contacto">Contáctanos</h5>
                    <p class="mb-1">📍 Dirección: Calle Salud #123, Ciudad Médica</p>
                    <p class="mb-1">📞 Teléfono: (01) 123-4567</p>
                    <p>✉️ Email: contacto@hospitalcentral.pe</p>
                </div>

                <div class="col-md-6 text-md-end">
                    <h5>Horario de Atención</h5>
                    <p class="mb-1">Lunes a Viernes: 8:00 a.m. – 6:00 p.m.</p>
                    <p>Sábado: 8:00 a.m. – 1:00 p.m.</p>
                </div>
            </div>

            <hr class="bg-secondary">

            <div class="text-center small">
                <p class="mb-0">&copy; {{ date('Y') }} Hospital Central. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
