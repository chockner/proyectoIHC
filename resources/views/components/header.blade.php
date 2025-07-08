<header class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto flex items-center justify-between whitespace-nowrap px-6 py-4">
        <!-- Logo y Nombre -->
        <div class="flex items-center gap-3 text-blue-600">
            <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <span class="material-icons text-3xl">local_hospital</span>
                <h1 class="text-2xl font-bold tracking-tight">HealthPlus</h1>
            </a>
        </div>

        <!-- Navegación para usuarios no autenticados -->
        @guest
            <nav class="hidden md:flex items-center gap-6">
                <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                    href="{{ route('home') }}#inicio">Inicio</a>
                <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                    href="{{ route('home') }}#nosotros">Nosotros</a>
                <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                    href="{{ route('home') }}#especialidades">Especialidades</a>
                <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                    href="{{ route('home') }}#equipo-medico">Equipo Médico</a>
                <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                    href="{{ route('home') }}#contacto">Contacto</a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <span class="truncate">Acceder</span>
                </a>
                <a href="{{ route('register') }}"
                    class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-slate-200 text-slate-800 text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-slate-300 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    <span class="truncate">Registrarse</span>
                </a>
                <button class="md:hidden text-slate-700 hover:text-blue-600">
                    <span class="material-icons">menu</span>
                </button>
            </div>
        @else
            <!-- Navegación para usuarios autenticados -->
            @if (request()->routeIs('home'))
                <nav class="hidden md:flex items-center gap-6">
                    <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                        href="{{ route('home') }}#inicio">Inicio</a>
                    <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                        href="{{ route('home') }}#nosotros">Nosotros</a>
                    <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                        href="{{ route('home') }}#especialidades">Especialidades</a>
                    <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                        href="{{ route('home') }}#equipo-medico">Equipo Médico</a>
                    <a class="text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors"
                        href="{{ route('home') }}#contacto">Contacto</a>
                </nav>
            @endif

            <!-- Usuario autenticado -->
            <div class="flex items-center gap-4">
                {{-- <button class="relative text-slate-600 hover:text-blue-600">
                    <span class="material-icons">notifications</span>
                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button> --}}
                <div class="relative group">
                    <button class="flex items-center gap-2">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                            style="background-image: url('{{ auth()->user()->profile?->photo_path ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=0c64f2&background=e6f0ff' }}')">
                        </div>
                        <span class="hidden md:inline text-slate-800 font-medium">{{ auth()->user()->name }}</span>
                        <div class="text-slate-600 hidden md:inline">
                            <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,88H202.34a8,8,0,0,1,11.32,13.66Z">
                                </path>
                            </svg>
                        </div>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                        <a class="block px-4 py-2 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600"
                            href="#">Mi Perfil</a>
                        <a class="block px-4 py-2 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600"
                            href="#">Configuración</a>
                        <a class="block px-4 py-2 text-sm {{ request()->routeIs('home') ? 'text-blue-600 font-medium' : 'text-slate-600' }} hover:bg-blue-50 hover:text-blue-600"
                            href="{{ route('home') }}">Inicio</a>
                        <a class="block px-4 py-2 text-sm {{ request()->routeIs('dashboard') ? 'text-blue-600 font-medium' : 'text-slate-600' }} hover:bg-blue-50 hover:text-blue-600"
                            href="{{ route('dashboard') }}">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</header>
