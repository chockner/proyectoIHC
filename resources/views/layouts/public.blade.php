<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>HealthPlus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    <!-- Header moderno -->
    <x-header />
    <!-- Contenido dinámico -->
    <main class="flex-grow container py-4">
        @yield('content')
    </main>
    <!-- Footer moderno -->
    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
