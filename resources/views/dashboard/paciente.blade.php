@extends('layouts.dashboard')

@section('content')
    <h2>Panel del Paciente</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total de Citas</h5>
                    <p class="card-text fs-3">{{ $totalCitas }}</p>
                    <small class="opacity-75">Todas las citas registradas</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Citas Programadas</h5>
                    <p class="card-text fs-3">{{ $totalCitasProgramadas }}</p>
                    <small class="opacity-75">Citas pendientes por atender</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Citas Completadas</h5>
                    <p class="card-text fs-3">{{ $totalCitasCompletadas }}</p>
                    <small class="opacity-75">Citas atendidas exitosamente</small>
                </div>
            </div>
        </div>
    </div>

    {{-- <h2>Gráficos</h2>
    <div class="card-body">
        <canvas id="citasChart" with="400" height="400"></canvas>
    </div> --}}

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