<header class="bg-white shadow-sm p-4 lg:px-10 lg:py-5 flex items-center justify-between sticky top-0 z-10">
    <button class="lg:hidden text-[#0d131c]">
        <svg fill="currentColor" height="28" viewBox="0 0 256 256" width="28" xmlns="http://www.w3.org/2000/svg">
            <path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,88H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,176H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z"></path>
        </svg>
    </button>
    <div class="lg:hidden flex items-center gap-2 text-[#0c64f2]">
        <div class="size-7">
            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M44 11.2727C44 14.0109 39.8386 16.3957 33.69 17.6364C39.8386 18.877 44 21.2618 44 24C44 26.7382 39.8386 29.123 33.69 30.3636C39.8386 31.6043 44 33.9891 44 36.7273C44 40.7439 35.0457 44 24 44C12.9543 44 4 40.7439 4 36.7273C4 33.9891 8.16144 31.6043 14.31 30.3636C8.16144 29.123 4 26.7382 4 24C4 21.2618 8.16144 18.877 14.31 17.6364C8.16144 16.3957 4 14.0109 4 11.2727C4 7.25611 12.9543 4 24 4C35.0457 4 44 7.25611 44 11.2727Z" fill="currentColor"></path>
            </svg>
        </div>
        <h2 class="text-lg font-bold">Panel</h2>
    </div>
    <div class="hidden lg:block flex-1"></div>
    <div class="flex items-center gap-4">
        <button class="relative text-[#49699c] hover:text-[#0c64f2]">
            <div data-icon="Bell" data-size="24px" data-weight="regular">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"></path>
                </svg>
            </div>
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
        </button>
        <div class="relative group">
            <button class="flex items-center gap-2">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAXI0hymPzZ6MkOJ-tPhQvZEZPPmL31DJzfzs_juxGj7GP3-NiUu0VU8e8WT7QpNw1_nFhloZWIsSLzZMdhcTAKNSZ-IKyv6k0GRtDsXXqUM_bEHr7_XlH3YvNRT_cO_VPYhzvlZss5jQy_BZ5ii5xmk1rWL87A-nSItE8JSYiehgnEoPcAAtDtGncp_r9uh4RbYeifYgjlOstzKsKp-HxZaU2_bKNNaMlw9imo2OxlTVlmFVxil7H_cDjiNWmwgoySUIn4gSNJ5fH7");'></div>
                <span class="hidden md:inline text-[#0d131c] font-medium">{{ Auth::user()->name ?? 'Usuario' }}</span>
                <div class="text-[#49699c] hidden md:inline">
                    <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,88H202.34a8,8,0,0,1,11.32,13.66Z"></path>
                    </svg>
                </div>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                <a class="block px-4 py-2 text-sm text-[#49699c] hover:bg-[#e6f0ff] hover:text-primary" href="{{ route('perfil.edit') }}">Mi Perfil</a>
                <a class="block px-4 py-2 text-sm text-[#49699c] hover:bg-[#e6f0ff] hover:text-primary" href="#">Configuración</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</header> 