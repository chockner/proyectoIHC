@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section class="relative" id="inicio">
        <div class="min-h-[500px] md:min-h-[600px] bg-cover bg-center flex items-center justify-center text-center"
             style='background-image: linear-gradient(rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 100%), url("https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80");'>
            <div class="px-4 py-16 md:py-24 max-w-3xl mx-auto">
                <h1 class="text-white text-4xl md:text-6xl font-black leading-tight tracking-tighter mb-6">
                    Tu Salud, Nuestra Prioridad
                </h1>
                <h2 class="text-slate-200 text-lg md:text-xl font-normal leading-relaxed mb-10">
                    Brindando atención excepcional con compasión y experiencia. Accede a servicios médicos de clase mundial y profesionales experimentados.
                </h2>
                @guest
                    <a href="{{ route('register') }}" class="flex min-w-[180px] max-w-[480px] mx-auto cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 md:h-14 md:px-8 bg-blue-600 text-white text-base md:text-lg font-bold leading-normal tracking-wide shadow-lg hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500">
                        <span class="truncate">Reservar una Cita</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="flex min-w-[180px] max-w-[480px] mx-auto cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 md:h-14 md:px-8 bg-blue-600 text-white text-base md:text-lg font-bold leading-normal tracking-wide shadow-lg hover:bg-blue-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500">
                        <span class="truncate">Ir al Dashboard</span>
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Servicios Destacados -->
    <section class="py-16 md:py-24 bg-white" id="nosotros">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 text-center mb-4 leading-tight tracking-tight">Servicios Destacados</h2>
            <p class="text-center text-slate-600 mb-12 md:mb-16 max-w-2xl mx-auto">
                Ofrecemos una amplia gama de servicios médicos especializados para satisfacer tus necesidades de salud.
            </p>
            
            @if($featuredSpecialties->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($featuredSpecialties as $specialty)
                        <div class="group flex flex-col bg-slate-50 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                            <div class="w-full h-48 bg-center bg-no-repeat bg-cover bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <span class="material-icons text-6xl text-blue-600">medical_services</span>
                            </div>
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ $specialty->name }}</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Atención especializada en {{ strtolower($specialty->name) }} con profesionales experimentados.
                                </p>
                            </div>
                            <a class="block bg-blue-50 text-blue-600 p-4 text-center font-medium hover:bg-blue-100 transition-colors" href="#especialidades">
                                Saber Más
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">No hay especialidades disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Estadísticas -->
    <section class="py-16 md:py-24 bg-blue-600">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="text-white">
                    <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['total_doctors'] }}</div>
                    <div class="text-blue-100">Médicos Especialistas</div>
                </div>
                <div class="text-white">
                    <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['total_specialties'] }}</div>
                    <div class="text-blue-100">Especialidades Médicas</div>
                </div>
                <div class="text-white">
                    <div class="text-4xl md:text-5xl font-bold mb-2">{{ $stats['total_appointments'] }}</div>
                    <div class="text-blue-100">Citas Atendidas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Especialidades Completas -->
    <section class="py-16 md:py-24 bg-slate-100" id="especialidades">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 text-center mb-4 leading-tight tracking-tight">Explore Nuestras Especialidades</h2>
            <p class="text-center text-slate-600 mb-12 md:mb-16 max-w-2xl mx-auto">
                Descubra la amplitud de nuestra experiencia médica en diversos campos especializados.
            </p>
            
            @if($allSpecialties->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($allSpecialties as $specialty)
                        <div class="group flex flex-col bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                            <div class="w-full h-48 bg-center bg-no-repeat bg-cover bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                <span class="material-icons text-6xl text-slate-600">medical_information</span>
                            </div>
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-semibold text-slate-800 mb-2">{{ $specialty->name }}</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Atención experta en {{ strtolower($specialty->name) }} con tecnología avanzada y profesionales calificados.
                                </p>
                            </div>
                            @guest
                                <a class="block bg-blue-50 text-blue-600 p-4 text-center font-medium hover:bg-blue-100 transition-colors" href="{{ route('register') }}">
                                    Reservar Cita
                                </a>
                            @else
                                <a class="block bg-blue-50 text-blue-600 p-4 text-center font-medium hover:bg-blue-100 transition-colors" href="{{ route('paciente.agendarCita.create') }}">
                                    Reservar Cita
                                </a>
                            @endguest
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">No hay especialidades disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Equipo Médico -->
    <section class="py-16 md:py-24 bg-white" id="equipo-medico">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 text-center mb-4 leading-tight tracking-tight">Nuestro Equipo Médico</h2>
            <p class="text-center text-slate-600 mb-12 md:mb-16 max-w-2xl mx-auto">
                Conozca a nuestros profesionales de la salud dedicados a brindarle la mejor atención.
            </p>
            
            @if($featuredDoctors->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredDoctors as $doctor)
                        <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="material-icons text-2xl text-blue-600">person</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">
                                            Dr. {{ $doctor->user->profile->first_name ?? 'Médico' }} {{ $doctor->user->profile->last_name ?? '' }}
                                        </h3>
                                        <p class="text-slate-600 text-sm">{{ $doctor->specialty->name ?? 'Especialidad' }}</p>
                                    </div>
                                </div>
                                <div class="border-t border-slate-200 pt-4">
                                    <p class="text-slate-600 text-sm leading-relaxed">
                                        Profesional especializado en {{ strtolower($doctor->specialty->name ?? 'medicina') }} con amplia experiencia en el campo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <span class="material-icons mr-2">calendar_month</span>
                            Reservar Cita con Nuestros Médicos
                        </a>
                    @else
                        <a href="{{ route('paciente.agendarCita.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <span class="material-icons mr-2">calendar_month</span>
                            Reservar Cita con Nuestros Médicos
                        </a>
                    @endguest
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">No hay médicos disponibles en este momento.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">¿Listo para Cuidar tu Salud?</h2>
            <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                Únete a miles de pacientes que confían en nosotros para su atención médica. 
                Reserva tu cita hoy mismo y comienza tu camino hacia una mejor salud.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="material-icons mr-2">person_add</span>
                        Registrarse
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-colors">
                        <span class="material-icons mr-2">login</span>
                        Iniciar Sesión
                    </a>
                @else
                    <a href="{{ route('paciente.agendarCita.create') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="material-icons mr-2">calendar_month</span>
                        Reservar Cita
                    </a>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-colors">
                        <span class="material-icons mr-2">dashboard</span>
                        Ir al Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- JavaScript para navegación suave -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navegación suave para enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection
