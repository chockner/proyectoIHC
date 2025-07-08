@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Lista de Citas</h2>

        <!-- Filtros y Búsqueda -->
        <div class="card mb-4" style="background: transparent; border: none;">
            <div class="card-body">
                <style>
                    .action-btn {
                        width: 45px;
                        height: 45px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border: 1px solid #e2e8f0;
                        background-color: #ffffff;
                        border-radius: 0.375rem;
                        padding: 0;
                    }

                    .action-btn-container {
                        display: flex;
                        gap: 10px;
                    }
                </style>
                <form method="GET" action="{{ route('secretaria.citas.index') }}" class="row g-3">
                    <!-- Filtro de estado -->
                    <div class="col-md-3">
                        <label for="status" class="form-label">Filtrar por estado:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="programada" {{ request('status') == 'programada' ? 'selected' : '' }}>Programadas
                            </option>
                            <option value="completada" {{ request('status') == 'completada' ? 'selected' : '' }}>Completadas
                            </option>
                            <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Canceladas
                            </option>
                        </select>
                    </div>

                    <!-- Filtro de fecha -->
                    <div class="col-md-3">
                        <label for="fecha" class="form-label">Seleccionar fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            value="{{ request('fecha') ?? '' }}">
                    </div>

                    <!-- Botones -->
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="action-btn-container">
                            <button type="submit" class="action-btn" data-bs-toggle="tooltip" data-bs-title="Buscar">
                                <div class="relative">
                                    <span class="material-icons text-slate-600">calendar_today</span>
                                    <span
                                        class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">search</span>
                                </div>
                            </button>
                            <a href="{{ route('secretaria.citas.index') }}" class="action-btn" data-bs-toggle="tooltip"
                                data-bs-title="Limpiar">
                                <div class="relative">
                                    <span class="material-icons text-slate-600">clear</span>
                                </div>
                            </a>
                            <a href="{{ route('secretaria.citas.exportPdf') . '?' . http_build_query(request()->query()) }}"
                                class="action-btn" data-bs-toggle="tooltip" data-bs-title="Exportar a PDF">
                                <div class="relative">
                                    <span class="material-icons text-slate-600">picture_as_pdf</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de citas -->
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Doctor</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($citas as $index => $cita)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($cita->doctor->user->profile)->last_name ?? 'No disponible' }}</td>
                        <td>{{ optional($cita->patient->user->profile)->last_name ?? 'No disponible' }}</td>
                        <td>{{ $cita->appointment_date ?? 'No disponible' }}</td>
                        <td>
                            <span
                                class="badge bg-{{ $cita->status === 'programada' ? 'warning' : ($cita->status === 'completada' ? 'success' : 'danger') }}">
                                {{ ucfirst($cita->status ?? 'No disponible') }}
                            </span>
                        </td>
                        <td>
                            @if ($cita->status === 'programada')
                                @if ($cita->payment && $cita->payment->status === 'pendiente')
                                    <a href="{{ route('secretaria.citas.show', $cita->id) }}" class="btn btn-sm action-btn"
                                        data-bs-toggle="tooltip" data-bs-title="Validar">
                                        <span class="material-icons text-green-600"
                                            style="material-icons; vertical-align: middle;">check_circle</span>
                                    </a>
                                @elseif ($cita->payment && $cita->payment->status === 'validado')
                                    <span class="text-success fw-bold">Comprobante Validado</span>
                                @elseif ($cita->payment && $cita->payment->status === 'rechazado')
                                    <span class="text-danger fw-bold">Comprobante rechazado</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay citas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación Inteligente -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{-- Botón Anterior --}}
                <li class="page-item {{ $citas->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $citas->appends(request()->query())->previousPageUrl() }}"
                        aria-label="Anterior">
                        « Anterior
                    </a>
                </li>

                {{-- Mostrar siempre la primera página --}}
                <li class="page-item {{ $citas->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link"
                        href="{{ $citas->url(1) . '&' . http_build_query(request()->except('page')) }}">1</a>
                </li>

                {{-- Rango de páginas alrededor de la actual --}}
                @php
                    $current = $citas->currentPage();
                    $last = $citas->lastPage();
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

                {{-- Separador inicial si hay un salto --}}
                @if ($left > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                {{-- Páginas intermedias --}}
                @for ($i = $left; $i <= $right; $i++)
                    <li class="page-item {{ $i == $current ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $citas->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Separador final si hay un salto --}}
                @if ($right < $last - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                {{-- Mostrar siempre la última página (si es diferente de la primera) --}}
                @if ($last > 1)
                    <li class="page-item {{ $citas->currentPage() == $last ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $citas->url($last) . '&' . http_build_query(request()->except('page')) }}">{{ $last }}</a>
                    </li>
                @endif

                {{-- Botón Siguiente --}}
                <li class="page-item {{ !$citas->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $citas->appends(request()->query())->nextPageUrl() }}"
                        aria-label="Siguiente">
                        Siguiente »
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@push('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
