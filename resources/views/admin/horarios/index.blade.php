@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Horarios Médicos</h2>
        </div>
    </div>

    <!-- Filtro y Botón Agregar -->
<div class="row mb-4 align-items-center">
    <!-- Columna del Filtro -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('admin.horarios.index') }}" class="row align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Especialidad:</label>
                        <select name="specialty_filter" class="form-select">
                            <option value="">Todas las especialidades</option>
                            @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}" 
                                {{ request('specialty_filter') == $specialty->id ? 'selected' : '' }}>
                                {{ $specialty->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Columna del Botón Agregar -->
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.horarios.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Agregar Horario
        </a>
    </div>
</div>
    

    <!-- Tabla de Horarios -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 100px;">Hora</th>
                            @foreach($days as $day)
                            <th class="text-center">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hours as $hour)
                        <tr>
                            <td class="text-center fw-bold bg-light">{{ $hour }}</td>
                            @foreach($days as $day)
                            <td style="min-width: 200px;">
                                @php
                                    $currentHour = strtotime($hour);
                                    $matchingSchedules = $schedules->filter(function($schedule) use ($day, $currentHour) {
                                        return $schedule->day_of_week == $day && 
                                               strtotime($schedule->start_time) <= $currentHour && 
                                               strtotime($schedule->end_time) > $currentHour;
                                    });
                                @endphp
                                
                                @foreach($matchingSchedules as $schedule)
                                <div class="schedule-item mb-2 p-2 rounded">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-primary">
                                            {{ $schedule->doctor->user->profile->last_name ?? 'Sin nombre' }}
                                        </strong>
                                        <span class="badge bg-info text-dark">
                                            {{ $schedule->doctor->specialty->name ?? 'Sin especialidad' }}
                                        </span>
                                    </div>
                                    <div class="text-end small text-muted">
                                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                    </div>
                                </div>
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .schedule-item {
        background-color: #f8fafc;
        border-left: 3px solid #3b82f6;
        transition: all 0.2s;
    }
    .schedule-item:hover {
        background-color: #eff6ff;
    }
    .table th {
        position: sticky;
        top: 0;
        background-color: #1e293b;
        color: white;
    }
    .table td {
        vertical-align: top;
    }
</style>
@endsection