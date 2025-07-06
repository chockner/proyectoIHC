@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Detalles del la cita medica</h1>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mt-2 justify-content-center">
            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN BASICA</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Doctor</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->appointment->doctor->user->profile->last_name ?? '' }} {{ $historial->appointment->doctor->user->profile->first_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->appointment->doctor->specialty->name ?? '' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Paciente</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->appointment->patient->user->profile->last_name ?? '' }} {{ $historial->appointment->patient->user->profile->first_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha y Hora</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->appointment->appointment_date ?? '' }} | {{ $historial->appointment->appointment_time ?? '' }}"
                        disabled>
                </div>
            </div>

        </div>
        <hr>

        <div class="row mt-4 justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE LA CITA</h5>
                        <div class="row g-3">
                            <!-- Diagnóstico -->
                            <div class="col-12 mb-3">
                                <label for="diagnosis" class="form-label fw-bold">Diagnóstico</label>
                                <textarea name="diagnosis" id="diagnosis" class="form-control disabled-field" rows="5" disabled>{{ $historial->diagnosis ?? '' }}</textarea>
                            </div>
                            <hr>
                            <!-- Tratamiento -->
                            <div class="col-12 mb-3">
                                <label for="treatment" class="form-label fw-bold">Tratamiento</label>
                                <textarea name="treatment" id="treatment" class="form-control disabled-field" rows="5" disabled>{{ $historial->treatment ?? '' }}</textarea>
                            </div>
                            <hr>
                            <!-- Notas -->
                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label fw-bold">Notas</label>
                                <textarea name="notes" id="notes" class="form-control disabled-field" rows="5" disabled>{{ $historial->notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 d-flex justify-content-start">
                <a href="{{ route('admin.historialMedico.show', $historial->id) }}"
                    class="btn btn-outline-secondary">Volver</a>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a href="{{ route('admin.historialMedico.edit_detail', $historial->id) }}" class="btn btn-primary">Editar
                    Cita</a>
            </div>
        </div>
    </div>
@endsection
