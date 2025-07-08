<header class="bg-white shadow-md main-header">
    <div class="container mx-auto flex items-center justify-between whitespace-nowrap px-6 py-4">
        <!-- Logo y Nombre -->
        <div class="flex items-center gap-2 text-blue-600">
            <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                <span class="material-icons text-2xl">local_hospital</span>
                <h1 class="text-xl font-bold tracking-tight">HealthPlus</h1>
            </a>
        </div>

        <!-- Navegación para usuarios no autenticados -->
        @guest
            @if (!request()->routeIs('login') && !request()->routeIs('register'))
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
            <div class="flex items-center gap-3">
                @if (request()->routeIs('login'))
                    <!-- Solo en login: mostrar botón Registrarse con estilo principal -->
                    <a href="{{ route('register') }}"
                        class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span class="truncate">Registrarse</span>
                    </a>
                @elseif(request()->routeIs('register'))
                    <!-- Solo en register: mostrar botón Acceder con estilo principal -->
                    <a href="{{ route('login') }}"
                        class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span class="truncate">Acceder</span>
                    </a>
                @else
                    <!-- En home y otras páginas: mostrar ambos botones con estilos alternados -->
                    <a href="{{ route('login') }}"
                        class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-blue-600 text-white text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span class="truncate">Acceder</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex min-w-[90px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-md h-10 px-4 bg-slate-200 text-slate-800 text-sm font-semibold leading-normal tracking-wide shadow-sm hover:bg-slate-300 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <span class="truncate">Registrarse</span>
                    </a>
                @endif
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
                
                <!-- Avatar y Menú de Usuario -->
                <div class="relative group" id="user-menu-container">
                    <button class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" id="user-menu-button">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full overflow-hidden ring-1 ring-slate-200 hover:ring-blue-300 transition-all duration-200">
                                @if(auth()->user()->profile && auth()->user()->profile->photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile->photo_path) }}" 
                                         alt="Foto de perfil de {{ auth()->user()->name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=0c64f2&background=e6f0ff&size=160'">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=0c64f2&background=e6f0ff&size=160" 
                                         alt="Avatar de {{ auth()->user()->name }}"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-semibold text-slate-800 leading-tight">
                                {{ auth()->user()->profile?->first_name ?? auth()->user()->name }}
                            </div>
                            <div class="text-xs text-slate-500 leading-tight">
                                {{ ucfirst(auth()->user()->role->name ?? 'Usuario') }}
                            </div>
                        </div>
                        <div class="hidden md:block text-slate-400 group-hover:text-slate-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <!-- Menú desplegable mejorado -->
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-2 opacity-0 invisible transition-all duration-200 transform origin-top-right scale-95 z-50" id="user-menu-dropdown">
                        <!-- Header del menú -->
                        <div class="px-4 py-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden">
                                    @if(auth()->user()->profile && auth()->user()->profile->photo_path)
                                        <img src="{{ asset('storage/' . auth()->user()->profile->photo_path) }}" 
                                             alt="Foto de perfil"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=0c64f2&background=e6f0ff&size=160'">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=0c64f2&background=e6f0ff&size=160" 
                                             alt="Avatar"
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-slate-800 truncate">
                                        {{ auth()->user()->profile?->first_name ?? auth()->user()->name }}
                                        {{ auth()->user()->profile?->last_name ?? '' }}
                                    </div>
                                    <div class="text-xs text-slate-500 truncate">
                                        {{ auth()->user()->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Opciones del menú -->
                        <div class="py-1">
                            <a href="{{ route('perfil.edit') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                <span class="material-icons text-lg text-slate-400">person</span>
                                <span>Mi Perfil</span>
                            </a>
                            
                            <a href="{{ route('home') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-600' }} transition-colors duration-150">
                                <span class="material-icons text-lg {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-400' }}">home</span>
                                <span>Inicio</span>
                            </a>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-600' }} transition-colors duration-150">
                                <span class="material-icons text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}">dashboard</span>
                                <span>Dashboard</span>
                            </a>
                        </div>
                        
                        <!-- Separador -->
                        <div class="border-t border-slate-100 my-1"></div>
                        
                        <!-- Cerrar sesión -->
                        <div class="px-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150 rounded-lg">
                                    <span class="material-icons text-lg text-red-500">logout</span>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('user-menu-button');
    const menuDropdown = document.getElementById('user-menu-dropdown');
    const menuContainer = document.getElementById('user-menu-container');
    
    if (menuButton && menuDropdown) {
        // Toggle del menú al hacer click
        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = menuDropdown.classList.contains('opacity-100');
            
            if (isVisible) {
                // Ocultar menú
                menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            } else {
                // Mostrar menú
                menuDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                menuDropdown.classList.add('opacity-100', 'visible', 'scale-100');
            }
        });
        
        // Cerrar menú al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!menuContainer.contains(e.target)) {
                menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            }
        });
        
        // Cerrar menú con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                menuDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                menuDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            }
        });
    }
});
</script>
