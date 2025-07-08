@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Detalles de la Historia Médica</h1>

        <div class="mb-3">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historiales as $index => $detalle)
                        <tr>
                            <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 ">{{ $detalle->appointment->doctor->user->profile->last_name }}</td>
                            <td class="px-6 py-4 ">{{ $detalle->appointment->doctor->specialty->name }}</td>
                            <td class="px-6 py-4 ">{{ $detalle->appointment->appointment_date }} </td>
                            <td class="px-6 py-4 ">{{ $detalle->appointment->appointment_time }} </td>
                            <td class="px-6 py-4 ">{{ $detalle->appointment->status }}</td>
                            <td>
                                <div class="mb-3 flex justity-center space-x-2">
                                    {{-- icono ver --}}
                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('admin.historialMedico.show_detail', $detalle->id) }}"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                            data-bs-toggle="tooltip" data-bs-title="Ver">
                                            <div class="relative">
                                                <span class="material-icons text-blue-600">assignment</span>
                                                <span
                                                    class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.5">visibility</span>
                                            </div>
                                        </a>
                                    </div>
                                    {{-- icono editar --}}
                                    <div class="flex flex-col items-center">
                                        <a href="{{ route('admin.historialMedico.edit_detail', $detalle->id) }}"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                            data-bs-toggle="tooltip" data-bs-title="Editar">
                                            <div class="relative">
                                                <span class="material-icons text-orange-500">assignment</span>
                                                <span
                                                    class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-orange-100 text-orange-600 rounded-full p-0.5">edit</span>
                                            </div>
                                        </a>
                                    </div>
                                    {{-- icono eliminar --}}
                                    <div class="flex flex-col items-center">
                                        <form action={{-- "{{ route('admin.historialMedico.destroy', $detalle->id) }}" --}} method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                                data-form-id="form-{{ $detalle->id }}" data-bs-toggle="tooltip"
                                                data-bs-title="Eliminar">
                                                <div class="relative">
                                                    <span class="material-icons text-red-600">assignment</span>
                                                    <span
                                                        class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-red-100 text-red-600 rounded-full p-0.5">delete</span>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($historiales->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay detalles disponibles para esta historia médica.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- Pagination --}}
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Botón Anterior --}}
                    <li class="page-item {{ $historiales->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $historiales->previousPageUrl() }}"
                            aria-label="Previous">Anterior</a>
                    </li>
                    {{-- Mostrar siempre la primera página --}}
                    <li class="page-item {{ $historiales->currentPage() == 1 ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $historiales->url(1) . '&' . http_build_query(request()->except('page')) }}">1</a>
                    </li>

                    {{-- Rango de páginas alrededor de la actual --}}
                    @php
                        $current = $historiales->currentPage();
                        $last = $historiales->lastPage();
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
                                href="{{ $historiales->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
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
                        <li class="page-item {{ $historiales->currentPage() == $last ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $historiales->url($last) . '&' . http_build_query(request()->except('page')) }}">{{ $last }}</a>
                        </li>
                    @endif
                    {{-- Botón Siguiente --}}
                    <li class="page-item {{ $historiales->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $historiales->nextPageUrl() }}" aria-label="Next">
                            Siguiente
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <a href="{{ route('admin.historialMedico.index') }}" class="btn btn-primary">Volver al Panel</a>


    </div>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <p id="confirmMessage"></p>
                        <div class="alert alert-danger mt-2">
                            Esta acción no se puede deshacer
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnConfirmDelete" class="btn btn-danger">Confirmar Eliminación</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio para el sonido de alerta -->
    <audio id="alertSound" preload="auto">
        <source src="https://media.geeksforgeeks.org/wp-content/uploads/20190531135120/beep.mp3" type="audio/mpeg">
    </audio>
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

        // Delegación de eventos para todos los botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            // Obtener el formulario específico para este doctor
            const form = $(this).closest('form');

            // Configurar mensaje
            const message = `
        ¿Está seguro que desea eliminar campo?
        Esta acción no se puede deshacer.
    `;
            $('#confirmMessage').html(message);

            // Guardar referencia al formulario en el modal
            $('#confirmDeleteModal').data('delete-form', form);

            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();

            // Reproducir sonido
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir sonido:', e));
            }
        });

        // Confirmar eliminación
        $('#btnConfirmDelete').click(function() {
            // Recuperar el formulario guardado
            const form = $('#confirmDeleteModal').data('delete-form');

            // Enviar el formulario específico
            if (form) {
                form.submit();
            }
        });
    </script>
@endpush
