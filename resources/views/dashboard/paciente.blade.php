@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">¡Bienvenido/a, {{ Auth::user()->name }}!</h1>
        <p class="text-[#49699c] text-base mt-1">Este es tu panel de salud personalizado.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Próxima Cita -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-1 md:col-span-2 lg:col-span-1 flex flex-col justify-between min-h-[200px]">
        <div>
            <h3 class="text-[#0d131c] text-lg font-semibold mb-1">Próxima Cita</h3>
            <p class="text-[#0d131c] text-xl font-bold">No hay citas próximas</p>
            <p class="text-[#49699c] text-sm mt-2">Reserva tu próxima cita con un profesional de la salud.</p>
        </div>
        <div class="mt-auto pt-4">
            <a href="{{ route('paciente.agendarCita.create') }}" class="btn-primary w-full md:w-auto text-sm font-medium py-2.5 px-5 rounded-lg hover:opacity-90 transition-opacity inline-block text-center">
                Reservar Nueva Cita
            </a>
            <a class="block text-center md:text-left text-sm text-primary hover:underline mt-3" href="#">
                Ver todas mis citas
            </a>
        </div>
    </div>

    <!-- Accesos Directos -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-1 md:col-span-2 lg:col-span-1">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Accesos Directos</h3>
        <div class="space-y-3">
            <a href="{{ route('paciente.agendarCita.create') }}" class="btn-primary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:opacity-90 transition-opacity inline-block text-center">
                Reservar Nueva Cita
            </a>
            <button class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors">
                Ver Historial Médico
            </button>
            <a href="{{ route('perfil.edit') }}" class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors inline-block text-center">
                Actualizar Perfil
            </a>
        </div>
    </div>

    <!-- Consejo de Salud -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-1 md:col-span-2 lg:col-span-1 flex flex-col">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-3">Consejo de Salud del Día</h3>
        <div class="flex items-center gap-3 mb-3">
            <div class="text-primary bg-primary-light p-2 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                </svg>
            </div>
            <p class="text-[#49699c] text-sm">¡Mantente hidratado/a! Beber suficiente agua durante el día es crucial para la salud y el bienestar general.</p>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 mt-auto">
            <div class="flex items-center gap-2">
                <span class="material-icons text-blue-600">water_drop</span>
                <span class="text-blue-800 text-sm font-medium">Recomendación diaria: 8 vasos de agua</span>
            </div>
        </div>
    </div>

    <!-- Notificaciones Recientes -->
    <div class="bg-white p-6 rounded-xl shadow-md col-span-1 md:col-span-2 lg:col-span-3">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Notificaciones Recientes</h3>
        <div class="space-y-4">
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-primary bg-primary-light p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM192,208H64V96H192ZM64,80V48H72v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h8v32Z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#0d131c] text-base font-medium">Confirmación de Cita</p>
                    <p class="text-[#49699c] text-sm">Tu cita con el Dr. Ramírez ha sido confirmada para mañana a las 2 PM.</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">Hace 2h</span>
            </div>
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-primary bg-primary-light p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M228.41,198.82,160,88V40h8a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16h8V88L27.59,198.82A16,16,0,0,0,41.15,224H214.85a16,16,0,0,0,13.56-25.18ZM144,91.58V40h-32V91.58l-3.6-6.24,64-36.95-3.6,6.24ZM49.15,208l56.8-99.28,16.41,28.43a8,8,0,0,0,13.83.1l15.36-26.6L206.85,208Z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#0d131c] text-base font-medium">Resultados de Laboratorio Listos</p>
                    <p class="text-[#49699c] text-sm">Tus resultados de laboratorio ya están disponibles para revisar en tu historial médico.</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">Hace 1 día</span>
            </div>
        </div>
        <a class="inline-block text-sm text-primary hover:underline mt-4 font-medium" href="#">Ver todas las notificaciones</a>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('citasChart').getContext('2d');
        const citasChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Programadas', 'Completadas', 'Otras'],
                datasets: [{
                    data: [
                        {{ $totalCitasProgramadas }}, 
                        {{ $totalCitasCompletadas }}, 
                        {{ $totalCitas - $totalCitasProgramadas - $totalCitasCompletadas }}
                    ],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw} (${Math.round(context.parsed)}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection