@extends('layouts.dashboard')

@section('content')
    <style>
        .disabled-field {
            background-color: #e9ecef !important;
            opacity: 1;
            cursor: not-allowed;
        }
    </style>

    <div class="container mt-4">
        <h3 class="text-center mb-4">Detalles del Doctor</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mt-2">
            <h5>INFORMACIÓN BÁSICA</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->user->document_id ?? '' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombres</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->user->profile->first_name ?? '' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Código de Licencia</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->license_code ?? '' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->user->profile->last_name ?? '' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <select class="form-select disabled-field" disabled>
                        <option value="{{ $doctor->specialty_id }}" selected>{{ $doctor->specialty->name ?? 'No disponible' }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Años de Experiencia</label>
                    <input type="number" class="form-control disabled-field" value="{{ $doctor->experience_years ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <h5>INFORMACIÓN DE CONTACTO</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->user->profile->phone ?? '' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control disabled-field" value="{{ $doctor->user->profile->email ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h5>INFORMACIÓN PERSONAL</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control disabled-field" value="{{ $doctor->user->profile->birthdate ? $doctor->user->profile->birthdate->format('Y-m-d') : '' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Género</label>
                    <select class="form-select disabled-field" disabled>
                        <option value="{{ $doctor->user->profile->gender ?? '' }}" selected>
                            @if ($doctor->user->profile->gender === '0')
                                Masculino
                            @elseif ($doctor->user->profile->gender === '1')
                                Femenino
                            @else
                                No disponible
                            @endif
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Estado Civil</label>
                    <select class="form-select disabled-field" disabled>
                        <option value="{{ $doctor->user->profile->civil_status ?? '' }}" selected>
                            @if ($doctor->user->profile->civil_status === '0')
                                Soltero(a)
                            @elseif ($doctor->user->profile->civil_status === '1')
                                Casado(a)
                            @elseif ($doctor->user->profile->civil_status === '2')
                                Viudo(a)
                            @elseif ($doctor->user->profile->civil_status === '3')
                                Divorciado(a)
                            @else
                                No disponible
                            @endif
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-control disabled-field" value="{{ $doctor->user->profile->address ?? '' }}" disabled>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary">Volver a la lista de doctores</a>
            <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn btn-primary">Editar Doctor</a>
        </div>
    </div>
@endsection