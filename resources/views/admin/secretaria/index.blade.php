@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Lista de Secretarias</h2>
        <div class="mb-3 flex justify-end">
            <a href="{{ route('admin.secretaria.create') }}"
                class="flex items-center gap-2 rounded-md border border-gray-200 bg-white px-4 py-2 shadow-sm hover:shadow-md transition-all duration-150">
                <div class="relative">
                    <span class="material-icons text-4xl">support_agent</span>
                    <span
                        class="material-icons absolute -top-1 -right-1 bg-green-100 text-green-600 rounded-full text-sm p-0.5">add_circle</span>
                </div>
                <span class="text-green-700 font-medium text-sm">Agregar Secretaria</span>
            </a>
        </div>
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
                @foreach ($secretarias as $index => $secretaria)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $secretaria->user->profile->first_name }}</td>
                        <td>{{ $secretaria->user->profile->last_name }}</td>
                        <td>{{ $secretaria->user->profile->email }}</td>
                        <td>{{ $secretaria->user->profile->phone }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- Icono Ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.secretaria.show', $secretaria->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Ver">
                                        <div class="relative">
                                            <span class="material-icons h-6 w-6 text-2xl text-blue-600">support_agent</span>
                                            <span
                                                class="material-icons absolute -bottom-1 -right-1 text-xs bg-blue-100 text-blue-600 rounded-full p-0.5">visibility</span>
                                        </div>
                                    </a>
                                </div>
                                {{-- Icono Editar --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.secretaria.edit', $secretaria->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Editar">
                                        <div class="relative">
                                            <span class="material-icons h-6 w-6 text-2xl text-blue-600">support_agent</span>
                                            <span
                                                class="material-icons absolute -bottom-1 -right-1 text-xs bg-orange-100 text-orange-600 rounded-full p-0.5">edit</span>
                                        </div>
                                    </a>
                                </div>
                                {{-- Icono Eliminar --}}
                                <div class="flex flex-col items-center">
                                    <form action="{{ route('admin.secretaria.destroy', $secretaria->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                            data-form-id="form-{{ $secretaria->id }}"
                                            data-bs-toggle="tooltip" data-bs-title="Eliminar">
                                            <div class="relative">
                                                <span class="material-icons h-6 w-6 text-2xl text-red-500">support_agent</span>
                                                <span
                                                    class="material-icons absolute -bottom-1 -right-1 text-xs bg-red-100 text-red-600 rounded-full p-0.5">delete</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if ($secretarias->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay secretarias registradas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $secretarias->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $secretarias->previousPageUrl() }}">Anterior</a>
                </li>
                @for ($i = 1; $i <= $secretarias->lastPage(); $i++)
                    <li class="page-item {{ $i == $secretarias->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $secretarias->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $secretarias->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $secretarias->nextPageUrl() }}">Siguiente</a>
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
@endsection
@section('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Delegación de eventos para todos los botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            const form = $(this).closest('form');
            const message = `
                ¿Está seguro que desea eliminar esta secretaria?
                Esta acción no se puede deshacer.
            `;
            $('#confirmMessage').html(message);
            $('#confirmDeleteModal').data('delete-form', form);
            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir sonido:', e));
            }
        });

        $('#btnConfirmDelete').click(function() {
            const form = $('#confirmDeleteModal').data('delete-form');
            if (form) {
                form.submit();
            }
        });
    </script>
@endsection