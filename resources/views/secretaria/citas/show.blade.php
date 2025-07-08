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
                        value="{{ optional($cita->doctor->user->profile)->first_name ?? '' }} {{ optional($cita->doctor->user->profile)->last_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre del Paciente</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($cita->patient->user->profile)->first_name ?? '' }} {{ optional($cita->patient->user->profile)->last_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado de la Cita</label>
                    <input type="text" class="form-control disabled-field" value="{{ $cita->status ?? 'No disponible' }}"
                        disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ optional($cita->doctor->specialty)->name ?? 'No disponible' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha y Hora</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $cita->appointment_date ?? '' }} | {{ $cita->appointment_time ?? '' }}" disabled>
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
                @if ($cita->status === 'programada')
                    @if ($cita->payment->status === 'pendiente')
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ route('secretaria.citas.validate', $cita->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success w-100">Validar</button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('secretaria.citas.reject', $cita->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger w-100">Rechazar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
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

        <div class="row mt-5 justify-content-center">
            <div class="col-md-4 d-flex justify-content-start">
                <a href="{{ route('secretaria.citas.index') }}" class="btn btn-outline-secondary">Volver a la lista de
                    citas</a>
            </div>
        </div>
    </div>
@endsection
