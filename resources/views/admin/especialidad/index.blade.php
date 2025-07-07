@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Especialidades</h1>

        <form action="{{ route('admin.especialidad.store') }}" method="POST" id="createEspecialidadForm">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" required
                        onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                        placeholder="Nombre de la Especialidad">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-primary" id="btnShowModal">Guardar</button>
                </div>
            </div>
        </form>
        <!-- Modal de confirmación para creación -->
        <div class="modal fade" id="confirmCreateModal" tabindex="-1" aria-labelledby="confirmCreateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="confirmCreateModalLabel">Confirmar Registro de Especialidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <p id="confirmMessageCreate"></p>
                            <div class="alert alert-primary mt-2">
                                Se registrará una nueva especialidad.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnConfirmCreate" class="btn btn-primary">Agregar Especialidad</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($especialidades as $index => $especialidad)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $especialidad->name }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- Icono Editar --}}
                                <div class="flex flex-col items-center">
                                    <button type="button"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-edit"
                                        data-especialidad-id="{{ $especialidad->id }}"
                                        data-especialidad-name="{{ $especialidad->name }}" data-bs-toggle="tooltip"
                                        data-bs-title="Editar">
                                        <div class="relative">
                                            <span class="material-icons text-orange-500">medical_information</span>
                                            <span
                                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-orange-100 text-orange-600 rounded-full p-0.4">edit</span>
                                        </div>
                                    </button>
                                </div>
                                {{-- Icono Eliminar --}}
                                <div class="flex flex-col items-center">
                                    <form action="{{ route('admin.especialidad.destroy', $especialidad->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                            data-form-id="form-{{ $especialidad->id }}" data-bs-toggle="tooltip"
                                            data-bs-title="Eliminar">
                                            <div class="relative">
                                                <span class="material-icons text-red-600">medical_information</span>
                                                <span
                                                    class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-red-100 text-red-600 rounded-full p-0.4">delete_outline</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if ($especialidades->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No hay especialidades registradas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $especialidades->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $especialidades->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                @for ($i = 1; $i <= $especialidades->lastPage(); $i++)
                    <li class="page-item {{ $i == $especialidades->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $especialidades->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $especialidades->hasMorePages() ? '' : 'disabled' }}>
                    <a class="page-link"
                    href="{{ $especialidades->nextPageUrl() }}" aria-label="Next">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Modal de confirmación para eliminación -->
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
                        <p id="confirmMessageDelete"></p>
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
    <!-- Modal de edición -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmEditModalLabel">Confirmar Edición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEspecialidadForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editEspecialidadName" class="form-label">Nombre de la Especialidad</label>
                            <input type="text" class="form-control" id="editEspecialidadName" name="name"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Confirmar Edición</button>
                    </div>
                </form>
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

        // Confirmación de creación
        $('#btnShowModal').click(function() {
            if (!$('#createEspecialidadForm')[0].checkValidity()) {
                $('#createEspecialidadForm')[0].reportValidity();
                return;
            }
            const message = `
            <strong>¿Está seguro de que desea registrar esta especialidad?</strong><br>
            Nombre de la Especialidad: ${$('#name').val()}<br>
        `;
            $('#confirmMessageCreate').html(message);
            const modal = new bootstrap.Modal(document.getElementById('confirmCreateModal'));
            modal.show();
        });

        $('#btnConfirmCreate').click(function() {
            if ($('#createEspecialidadForm')[0].checkValidity()) {
                $('#createEspecialidadForm').submit();
            } else {
                $('#createEspecialidadForm')[0].reportValidity();
            }
        });

        // Confirmación de eliminación
        $(document).on('click', '.btn-delete', function() {
            const form = $(this).closest('form');
            const message = `
            ¿Está seguro que desea eliminar esta especialidad?
            Esta acción no se puede deshacer.
        `;
            $('#confirmMessageDelete').html(message);
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

        // Editar especialidad
        $(document).on('click', '.btn-edit', function() {
            const especialidadId = $(this).data('especialidad-id');
            const especialidadName = $(this).data('especialidad-name');
            $('#editEspecialidadName').val(especialidadName);
            const updateUrl = '{{ route('admin.especialidad.update', ['id' => ':id']) }}'.replace(':id',
                especialidadId);
            $('#editEspecialidadForm').attr('action', updateUrl);
            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir sonido:', e));
            }
        });

        $('#btnConfirmEdit').click(function() {
            if ($('#editEspecialidadForm')[0].checkValidity()) {
                $('#editEspecialidadForm').submit();
            } else {
                $('#editEspecialidadForm')[0].reportValidity();
            }
        });
    </script>
@endpush
