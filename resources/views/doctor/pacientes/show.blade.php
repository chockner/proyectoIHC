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
        <h1 class="text-2xl font-bold mb-4">Detalles de la Historia Médica</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mt-2 justify-content-center">
            <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DEL PACIENTE</h5>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Nombre del Paciente</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->first()->appointment->patient->user->profile->first_name ?? '' }} {{ $historial->first()->appointment->patient->user->profile->last_name ?? '' }}"
                        disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo de Sangre</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->first()->appointment->patient->blood_type ?? 'No disponible' }}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Alergias</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->first()->appointment->patient->allergies ?? 'No disponible' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Vacunas Recibidas</label>
                    <input type="text" class="form-control disabled-field"
                        value="{{ $historial->first()->appointment->patient->vaccination_received ?? 'No disponible' }}"
                        disabled>
                </div>
            </div>
        </div>
        <hr>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-4 d-flex justify-content-start">
                <a href="{{ route('doctor.pacientes.index') }}" class="btn btn-outline-secondary">Volver a la lista de
                    pacientes</a>
            </div>
        </div>

        <div class="mt-5">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Fecha y Hora</th>
                        <th>Diagnóstico</th>
                        <th>Tratamiento</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historial as $index => $historia)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $historia->appointment->doctor->user->profile->first_name ?? '' }}
                                {{ $historia->appointment->doctor->user->profile->last_name ?? '' }}</td>
                            <td class="px-6 py-4">{{ $historia->appointment->doctor->specialty->name ?? 'No disponible' }}
                            </td>
                            <td class="px-6 py-4">{{ $historia->appointment->appointment_date ?? '' }} |
                                {{ $historia->appointment->appointment_time ?? '' }}</td>
                            <td class="px-6 py-4">{{ $historia->diagnosis ?? 'No disponible' }}</td>
                            <td class="px-6 py-4">{{ $historia->treatment ?? 'No disponible' }}</td>
                            <td class="px-6 py-4">{{ $historia->notes ?? 'No disponible' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay historia médica registrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($historial->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $historial->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $historial->previousPageUrl() }}"
                                aria-label="Previous">Anterior</a>
                        </li>
                        <li class="page-item {{ $historial->currentPage() == 1 ? 'active' : '' }}">
                            <a class="page-link" href="{{ $historial->url(1) }}">1</a>
                        </li>
                        @php
                            $current = $historial->currentPage();
                            $last = $historial->lastPage();
                            $delta = 2;
                            $left = $current - $delta;
                            $right = $current + $delta;
                            if ($left < 2) {
                                $left = 2;
                            }
                            if ($right > $last - 1) {
                                $right = $last - 1;
                            }
                        @endphp
                        @if ($left > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        @for ($i = $left; $i <= $right; $i++)
                            <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                <a class="page-link" href="{{ $historial->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($right < $last - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        @if ($last > 1)
                            <li class="page-item {{ $historial->currentPage() == $last ? 'active' : '' }}">
                                <a class="page-link" href="{{ $historial->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif
                        <li class="page-item {{ $historial->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $historial->nextPageUrl() }}" aria-label="Next">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        /* en caso necesites scripts */
    </script>
@endpush
