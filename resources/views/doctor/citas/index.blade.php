@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Citas</h1>
        <div class="mb-4">
            <form action="{{ route('doctor.citas.index') }}" method="GET"
                class="row justify-content-start align-items-center">
                <!-- Selector de fecha -->
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="fecha">Seleccionar fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control"
                        value="{{ request('fecha') ?? now()->toDateString() }}">
                </div>
                <!-- Botón de búsqueda -->
                <div class="col-md-2 mb-3">
                    <button type="submit"
                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                        data-bs-toggle="tooltip" data-bs-title="Buscar">
                        <div class="relative">
                            <span class="material-icons text-gray-500 " style="font-size: 30px;">calendar_today</span>
                            <span
                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-gray-100 text-green-600 rounded-full p-0.4">search</span>
                        </div>
                    </button>
                </div>
                <!-- Botón de limpiar (enlace) -->
                <div class="col-md-2 mb-3">
                    <a href="{{ route('doctor.citas.index') }}" class="btn btn-secondary w-100">
                        Limpiar Filtro
                    </a>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Paciente</th>
                    <th>Fecha Hora</th>
                    <th>Estado Cita</th>
                    <th>Estado Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $index => $cita)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ optional($cita->patient->user->profile)->last_name ?? 'No disponible' }}
                            {{ optional($cita->patient->user->profile)->first_name ?? '' }}</td>
                        <td class="px-6 py-4">{{ $cita->appointment_date }} | {{ $cita->appointment_time }}</td>
                        <td class="px-6 py-4">{{ $cita->status ?? 'No disponible' }}</td>
                        <td class="px-6 py-4">{{ optional($cita->payment)->status ?? 'No disponible' }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- Icono Ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('doctor.citas.show', $cita->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Ver">
                                        <div class="relative">
                                            <span class="material-icons text-blue-600"
                                                style="font-size: 30px;">calendar_today</span>
                                            <span
                                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">visibility</span>
                                        </div>
                                    </a>
                                </div>
                                @if ($cita->status === 'programada')
                                    {{-- Icono Atender --}}
                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('doctor.citas.edit', $cita->id) }}"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                            data-bs-toggle="tooltip" data-bs-title="Atender">
                                            <div class="relative">
                                                <span class="material-icons text-green-500"
                                                    style="font-size: 30px;">calendar_today</span>
                                                <span
                                                    class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-green-100 text-green-600 rounded-full p-0.4">room_service</span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if ($citas->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay citas registradas en este mes.</td>
                    </tr>
                @endif
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
    <style>
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            padding: 8px;
            border-radius: 6px;
        }
    </style>
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
