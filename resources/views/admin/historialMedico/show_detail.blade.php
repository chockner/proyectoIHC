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
            <h5 class="text-center mb-4 fw-bold">INFORMACION DE LA CITA</h5>
            {{--  aqui ve si lo pones como es grande supuestamente asi uno de bajo de otro
            los tres diagnostico tratamiendo y notas. que hagarre de largo uno de bajo de otro --}}
            <p>aqui ve si lo pones como es grande supuestamente asi uno de bajo de otro
                los tres diagnostico tratamiendo y notas. que hagarre de largo uno de bajo de otro</p>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 d-flex justify-content-start">
                <a href="{{ route('admin.historialMedico.show', $historial->id) }}"
                    class="btn btn-outline-secondary">Volver</a>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a href="" class="btn btn-primary">Editar Doctor</a>
            </div>
        </div>
    </div>
@endsection
