<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HealthPlus - Gestión Hospitalaria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
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
<body class="bg-slate-50 text-slate-900" style='font-family: Lexend, "Noto Sans", sans-serif;'>
    <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            @include('components.header_index')
            
            <!-- Contenido dinámico -->
            <main class="flex-1">
                @yield('content')
            </main>
            
            @include('components.footer_index')
        </div>
    </div>
</body>
</html>
