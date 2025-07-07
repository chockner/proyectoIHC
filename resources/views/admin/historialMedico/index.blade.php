@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Panel de Historias Médicas</h1>
        <div class="mb -3">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historiales as $index => $historial)
                        <tr>

                            @if (isset($historial->patient->user))
                                <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 ">{{ $historial->patient->user->profile->first_name }}</td>
                                <td class="px-6 py-4 ">{{ $historial->patient->user->profile->last_name }}</td>
                                <td class="px-6 py-4 ">{{ $historial->patient->user->profile->email }}</td>
                                <td class="px-6 py-4 ">{{ $historial->patient->user->profile->phone }}</td>

                                <td>
                                    <div class="mb-3 flex justity-center space-x-2">
                                        {{-- icono ver --}}
                                        <div class="flex flex-col items-center">
                                            <a href="{{ route('admin.historialMedico.show', $historial->id) }}"
                                                class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                                data-bs-toggle="tooltip" data-bs-title="Ver">
                                                <div class="relative">
                                                    <span class="material-icons text-blue-600">assignment</span>
                                                    <span
                                                        class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">visibility</span>
                                                </div>
                                            </a>
                                        </div>
                                        {{-- icono eliminar --}}
                                        <div class="flex flex-col items-center">
                                            <form action="{{ route('admin.historialMedico.destroy', $historial->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                                    data-form-id="form-{{ $historial->id }}" data-bs-toggle="tooltip"
                                                    data-bs-title="Eliminar">
                                                    <div class="relative">
                                                        <span class="material-icons text-red-600">assignment</span>
                                                        <span
                                                            class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-red-100 text-red-600 rounded-full p-0.4">delete_outline</span>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                    @if ($historiales->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No hay historias medicas registrados.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <!-- Paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{-- Enlace "First" --}}
                    {{-- Enlace "Previous" --}}
                    <li class="page-item {{ $historiales->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $historiales->previousPageUrl() }}">Anterior</a>
                    </li>
                    {{-- Páginas numéricas --}}
                    @for ($i = 1; $i <= $historiales->lastPage(); $i++)
                        <li class="page-item {{ $i == $historiales->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $historiales->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    {{-- Enlace "Next" --}}
                    <li class="page-item {{ $historiales->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $historiales->nextPageUrl() }}">Siguiente</a>
                    </li>
                </ul>
            </nav>
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
    </div>
@endsection
@section('scripts')
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
            ¿Está seguro que desea eliminar este Historial?
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
@endsection
