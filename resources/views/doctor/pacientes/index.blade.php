@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Pacientes</h1>
        <div class="mb-3 flex justify-end">
            <input type="text" id="search" class="form-control" placeholder="Buscar paciente por nombre..."
                autocomplete="off" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');">
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Grupo sanguíneo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $index => $paciente)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $paciente->user->profile->first_name }}</td>
                        <td>{{ $paciente->user->profile->last_name }}</td>
                        <td>{{ $paciente->blood_type }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- Icono Ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('doctor.pacientes.show', $paciente->medicalRecords->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Ver">
                                        <div class="relative">
                                            <span class="material-icons text-blue-600">assist_walker</span>
                                            <span
                                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">visibility</span>
                                        </div>
                                    </a>
                                </div>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{-- Pagination --}}
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Botón Anterior --}}
                <li class="page-item {{ $pacientes->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pacientes->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                {{-- Mostrar siempre la primera página --}}
                <li class="page-item {{ $pacientes->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link"
                        href="{{ $pacientes->url(1) . '&' . http_build_query(request()->except('page')) }}">1</a>
                </li>

                {{-- Rango de páginas alrededor de la actual --}}
                @php
                    $current = $pacientes->currentPage();
                    $last = $pacientes->lastPage();
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
                            href="{{ $pacientes->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
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
                    <li class="page-item {{ $pacientes->currentPage() == $last ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $pacientes->url($last) . '&' . http_build_query(request()->except('page')) }}">{{ $last }}</a>
                    </li>
                @endif
                {{-- Botón Siguiente --}}
                <li class="page-item {{ $pacientes->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $pacientes->nextPageUrl() }}" aria-label="Next">
                        Siguiente
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

        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val(); // Obtener el valor que el usuario escribe

                if (query.length >= 3 || query.length == 0) {
                    $.ajax({
                        url: "{{ route('doctor.pacientes.index') }}", // La ruta para realizar la búsqueda
                        type: "GET",
                        data: {
                            search: query
                        }, // Enviamos el parámetro search
                        success: function(data) {
                            $('tbody').html(
                                data); // Actualizamos solo la tabla con los nuevos resultados
                        }
                    });
                }
            });
        });
    </script>
@endpush
