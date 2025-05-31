@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Horarios de Médicos</h2>

    <!-- Filtro por Especialidad -->
    <form method="GET" action="{{ route('admin.horarios.index') }}">
        @csrf
        <label for="specialty_filter">Filtrar por Especialidad:</label>
        <select name="specialty_filter" id="specialty_filter" class="form-control">
            <option value="">Todas las Especialidades</option>
            @foreach($specialties as $specialty)
                <option value="{{ $specialty->id }}" {{ request('specialty_filter') == $specialty->id ? 'selected' : '' }}>
                    {{ $specialty->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
    </form>

    <hr>

    <!-- Tabla de Horarios -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hora</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hours as $hour)
                <tr>
                    <td>{{ $hour }}</td>
                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $day)
                        <td>
                            <!-- Mostrar horarios por día -->
                            @foreach($schedules->where('day_of_week', $day)->where('start_time', $hour) as $schedule)
                                <strong>{{ $schedule->doctor->name }}</strong><br>
                                <em>{{ $schedule->doctor->specialty->name }}</em><br>
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
