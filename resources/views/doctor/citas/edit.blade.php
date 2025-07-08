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

        @if (isset($cita) && $cita)
            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DEL Paciente</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Paciente</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->patient && $cita->patient->user && $cita->patient->user->profile ? $cita->patient->user->profile->first_name . ' ' . $cita->patient->user->profile->last_name : 'No disponible' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vacunas Recibidas</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->vaccination_received ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado de la Cita</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->status ?? 'No disponible' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Sangre</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->blood_type ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alergias</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->allergies ?? 'No disponible' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha y Hora</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->appointment_date }} | {{ $cita->appointment_time }}" disabled>
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
                            value="{{ optional($cita->payment)->payment_method ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado del Comprobante</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->payment)->status ?? 'No disponible' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Comprobante:</label>
                        @if ($cita->payment && $cita->payment->image_path)
                            <div>
                                <img src="{{ asset('storage/' . $cita->payment->image_path) }}" class="img-comprobante"
                                    alt="Comprobante de pago">
                            </div>
                        @else
                            <input type="text" class="form-control disabled-field" value="No disponible" disabled>
                        @endif
                    </div>
                </div>
            </div>
            <hr>

            <div class="row mt-4 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">DETALLES MÉDICOS</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="diagnosis" class="form-label fw-bold">Diagnóstico</label>
                        <textarea name="diagnosis" id="diagnosis" class="form-control disabled-field" rows="4">{{ optional($cita->medicalRecordDetail)->diagnosis ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="treatment" class="form-label fw-bold">Tratamiento</label>
                        <textarea name="treatment" id="treatment" class="form-control disabled-field" rows="4">{{ optional($cita->medicalRecordDetail)->treatment ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Notas</label>
                        <textarea name="notes" id="notes" class="form-control disabled-field" rows="4">{{ optional($cita->medicalRecordDetail)->notes ?? '' }}</textarea>
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
            <div class="col-md-4 d-flex justify-content-end">
                <a href="{{ route('doctor.citas.update', $cita->id) }}" class="btn btn-primary">Guardar Cambios</a>
            </div>
        </div>
    </div>
@endsection
