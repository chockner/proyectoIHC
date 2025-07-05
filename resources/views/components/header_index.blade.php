<header class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto flex items-center justify-between whitespace-nowrap px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-blue-600 hover:text-blue-700 transition-colors">
            <span class="material-icons text-3xl">local_hospital</span>
            <h1 class="text-2xl font-bold tracking-tight">HealthPlus</h1>
        </a>
        
        @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <nav class="hidden md:flex items-center gap-6">
            <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors" href="#inicio">Inicio</a>
            <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors" href="#nosotros">Nosotros</a>
            <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors" href="#especialidades">Especialidades</a>
            <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors" href="#equipo-medico">Equipo Médico</a>
            <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors" href="#contacto">Contacto</a>
        </nav>
        @endif
        
        <div class="flex items-center gap-3">
            @if(!request()->routeIs('login') && !request()->routeIs('register'))
            <a href="{{ route('login') }}" class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <span class="truncate">Acceder</span>
            </a>
            <a href="{{ route('register') }}" class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-slate-200 text-slate-800 text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-slate-300 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <span class="truncate">Registrarse</span>
            </a>
            @else
            @if(request()->routeIs('login'))
            <a href="{{ route('register') }}" class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <span class="truncate">Registrarse</span>
            </a>
            @elseif(request()->routeIs('register'))
            <a href="{{ route('login') }}" class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                <span class="truncate">Iniciar Sesión</span>
            </a>
            @endif
            @endif
            
            @if(!request()->routeIs('login') && !request()->routeIs('register'))
            <button class="md:hidden text-slate-700 hover:text-blue-600">
                <span class="material-icons">menu</span>
            </button>
            @endif
        </div>
    </div>
</header>
