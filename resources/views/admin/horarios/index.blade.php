@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Encabezado y Filtros -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Horarios Médicos</h2>
        </div>
    </div>

    <!-- Filtros y Botón Agregar -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('admin.horarios.index') }}" class="row align-items-end">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <label class="form-label">Turno:</label>
                            <select name="shift_filter" class="form-select">
                                <option value="">Todos los turnos</option>
                                <option value="MAÑANA" {{ request('shift_filter') == 'MAÑANA' ? 'selected' : '' }}>Mañana</option>
                                <option value="TARDE" {{ request('shift_filter') == 'TARDE' ? 'selected' : '' }}>Tarde</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-end">
            <div class="btn-group">
                <a href="{{ route('admin.horarios.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Agregar
                </a>
                <a href="{{ route('admin.horarios.edit-by-filters') }}" class="btn btn-warning text-white">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('admin.horarios.delete-by-filters') }}" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </a>
            </div>
        </div>
    </div>

    <!-- Tabla de Horarios -->
    <div class="card">
        <div class="card-body p-0">
            @foreach(['MAÑANA', 'TARDE'] as $turno)
            <div class="turno-section mb-4">
                <h5 class="p-3 bg-light mb-0">Turno {{ $turno }}</h5>
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
                            @foreach($hours[$turno] as $hour)
                            <tr>
                                <td class="text-center fw-bold bg-light">{{ $hour }}</td>
                                @foreach($days as $day)
                                <td style="min-width: 200px;">
                                    @php
                                        $currentHour = strtotime($hour);
                                        $matchingSchedules = $schedules->filter(function($schedule) use ($day, $currentHour, $turno) {
                                            return $schedule->day_of_week == $day && 
                                                   $schedule->shift == $turno &&
                                                   strtotime($schedule->start_time) <= $currentHour && 
                                                   strtotime($schedule->end_time) > $currentHour;
                                        });
                                    @endphp
                                    
                                    @foreach($matchingSchedules as $schedule)
                                    <div class="schedule-item mb-2 p-2 rounded position-relative">
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
            @endforeach
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
        padding-right: 3.5rem; /* Espacio para botones */
    }
    .schedule-item:hover {
        background-color: #eff6ff;
        transform: translateY(-1px);
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
    .turno-section {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
    }
    .turno-section h5 {
        border-bottom: 1px solid #dee2e6;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endsection