@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2>Crear Horario de Médico</h2>

    <form method="POST" action="{{ route('admin.horarios.store') }}">
        @csrf

        <div class="form-group">
            <label for="doctor_id">Médico:</label>
            <select name="doctor_id" id="doctor_id" class="form-control">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->user->profile->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="specialty_id">Especialidad:</label>
            <select name="specialty_id" id="specialty_id" class="form-control">
                @foreach($specialties as $specialty)
                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="day_of_week">Día de la Semana:</label>
            <select name="day_of_week" id="day_of_week" class="form-control">
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="start_time">Hora de Inicio:</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_time">Hora de Salida:</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
