@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Citas</h1>

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
                        <td class="px-6 py-4 "> {{ $index + 1 }} </td>
                        <td class="px-6 py-4 "> {{ $cita->patient->user->profile->last_name }}
                            {{ $cita->patient->user->profile->first_name }} </td>
                        <td class="px-6 py-4 "> {{ $cita->appointment_date }} | {{ $cita->appointment_time }} </td>
                        <td class="px-6 py-4 "> {{ $cita->status }} </td>
                        <td class="px-6 py-4 "> {{ $cita->payment->status }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación Inteligente -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{-- Botón Anterior --}}
                <li class="page-item {{ $citas->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $citas->appends(request()->query())->previousPageUrl() }}"
                        aria-label="Anterior">
                        &laquo; Anterior
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
                        Siguiente &raquo;
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
