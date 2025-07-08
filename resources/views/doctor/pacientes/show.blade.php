@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Detalles de la Historia Médica</h1>

        {{-- aqui informacion basica del paciente, solo nombre y apellido y alergias y esas vainas --}}
        <p>
            aqui informacion basica del paciente, solo nombre y apellido y alergias y esas vainas
            divs y asi
        </p>
        <div class="mb-3">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Fecha y Hora</th>
                        <th>Diagnostico</th>
                        <th>Tratamiento</th>
                        <th>Notas</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($historial as $index => $historia)
                        <tr>
                            <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 ">{{ $historia->appointment->doctor->user->profile->first_name }}
                                {{ $historia->appointment->doctor->user->profile->last_name }}
                            </td>
                            <td class="px-6 py-4 ">{{ $historia->appointment->doctor->specialty->name }}</td>
                            <td class="px-6 py-4 ">{{ $historia->appointment->appointment_date }} |
                                {{ $historia->appointment->appointment_time }}</td>
                            <td class="px-6 py-4 ">{{ $historia->diagnosis }}</td>
                            <td class="px-6 py-4 ">{{ $historia->treatment }}</td>
                            <td class="px-6 py-4 ">{{ $historia->notes }}</td>
                        </tr>
                    @endforeach
                    @if ($historial->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay Historia Medica registrada.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- Pagination --}}
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Botón Anterior --}}
                    <li class="page-item {{ $historial->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $historial->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                    </li>
                    {{-- Mostrar siempre la primera página --}}
                    <li class="page-item {{ $historial->currentPage() == 1 ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $historial->url(1) . '&' . http_build_query(request()->except('page')) }}">1</a>
                    </li>

                    {{-- Rango de páginas alrededor de la actual --}}
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
                                href="{{ $historial->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
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
                        <li class="page-item {{ $historial->currentPage() == $last ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $historial->url($last) . '&' . http_build_query(request()->except('page')) }}">{{ $last }}</a>
                        </li>
                    @endif
                    {{-- Botón Siguiente --}}
                    <li class="page-item {{ $historial->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $historial->nextPageUrl() }}" aria-label="Next">
                            Siguiente
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        /* en caso necesites scripts */
    </script>
@endpush
