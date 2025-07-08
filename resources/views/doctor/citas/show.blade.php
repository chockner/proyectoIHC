@extends('layouts.dashboard')

@section('content')
    <style>
        .disabled-field {
            background-color: #e9ecef !important;
            opacity: 1;
            cursor: not-allowed;
        }

        .img-comprobante {
            max-width: 200px;
            height: auto;
        }
    </style>

    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">DETALLES DE LA CITA</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mt-2 justify-content-center">
            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE LA CITA</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Nombre del Doctor</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($appointment->doctor->user->profile)->first_name ?? '' }} {{ optional($appointment->doctor->user->profile)->last_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del Paciente</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($appointment->patient->user->profile)->first_name ?? '' }} {{ optional($appointment->patient->user->profile)->last_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado de la Cita</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $appointment->status ?? 'No disponible' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($appointment->doctor->specialty)->name ?? 'No disponible' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha y Hora</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $appointment->appointment_date }} | {{ $appointment->appointment_time }}" disabled>
                </div>
            </div>
        </div>
        <hr>

        <div class="row mt-4 justify-content-center">
            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE PAGO</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Método de Pago</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($appointment->payment)->payment_method ?? 'No disponible' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado del Comprobante</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($appointment->payment)->status ?? 'No disponible' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Comprobante:</label>
                    @if ($appointment->payment && $appointment->payment->image_path)
                        <div>
                            <img src="{{ asset('storage/' . $appointment->payment->image_path) }}" class="img-comprobante"
                                alt="Comprobante de pago">
                        </div>
                    @else
                        <input type="text" class="form-control disabled-field" value="No disponible" disabled>
                    @endif
                </div>
            </div>
        </div>
        <hr>

        @if ($appointment->status === 'completada')
            <div class="row mt-4 justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card bg-transparent border-0">
                        <div class="card-body">
                            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE LA CITA</h5>
                            <div class="row g-3">
                                <!-- Diagnóstico -->
                                <div class="col-12 mb-3">
                                    <label for="diagnosis" class="form-label fw-bold">Diagnóstico</label>
                                    <textarea name="diagnosis" id="diagnosis" class="form-control disabled-field" rows="5" disabled>{{ $appointment->medicalRecordDetail->diagnosis ?? '' }}</textarea>
                                </div>
                                <hr>
                                <!-- Tratamiento -->
                                <div class="col-12 mb-3">
                                    <label for="treatment" class="form-label fw-bold">Tratamiento</label>
                                    <textarea name="treatment" id="treatment" class="form-control disabled-field" rows="5" disabled>{{ $appointment->medicalRecordDetail->treatment ?? '' }}</textarea>
                                </div>
                                <hr>
                                <!-- Notas -->
                                <div class="col-12 mb-3">
                                    <label for="notes" class="form-label fw-bold">Notas</label>
                                    <textarea name="notes" id="notes" class="form-control disabled-field" rows="5" disabled>{{ $appointment->medicalRecordDetail->notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif

        <div class="row mt-4 justify-content-center">
            <div class="col-md-4 d-flex justify-content-start">
                <a href="{{ route('doctor.citas.index') }}" class="btn btn-outline-secondary">Volver a la lista de
                    citas</a>
            </div>
            @if ($appointment->status === 'pendiente')
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="{{ route('doctor.citas.edit', $appointment->id) }}" class="btn btn-primary">Atender Cita</a>
                </div>
            @endif
        </div>
    </div>
@endsection
