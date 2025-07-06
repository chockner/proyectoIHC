@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Lista de Doctores</h2>
        <form action="{{ route('admin.especialidad.store') }}" method="POST" id="createEspecialidadForm">
            @csrf
            <div class="row mb-3">

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
            </div>
        </form>
        <!-- Modal de confirmación -->
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
                                Se registrará un nueva especialidad.
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
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($especialidades as $index => $especialidad)
                    <tr>
                        <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 ">{{ $especialidad->name }}</td>
                        <td>
                            <div class="mb-3 flex justity-center space-x-2">
                                {{-- icono ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="#" class="btn btn-sm btn-info">Ver</a>
                                </div>
                                {{-- icono editar --}}
                                <div class="flex flex-col items-center">
                                    <button type="button" class="btn btn-warning btn-edit"
                                        data-especialidad-id="{{ $especialidad->id }}"
                                        data-especialidad-name="{{ $especialidad->name }}">
                                        Editar
                                    </button>

                                </div>
                                {{-- icono eliminar --}}
                                <div class="flex flex-col items-center">
                                    <form action="{{ route('admin.especialidad.destroy', $especialidad->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-delete"
                                            data-form-id="form-{{ $especialidad->id }}">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach

                @if ($especialidades->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay especialidades registradas.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Enlace "Previous" --}}
                <li class="page-item {{ $especialidades->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $especialidades->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                {{-- Páginas numéricas --}}
                @for ($i = 1; $i <= $especialidades->lastPage(); $i++)
                    <li class="page-item {{ $i == $especialidades->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $especialidades->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                {{-- Enlace "Next" --}}
                <li class="page-item {{ $especialidades->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $especialidades->nextPageUrl() }}" aria-label="Next">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Modal de confirmación eliminar -->
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
@section('scripts')
    <script>
        // Al hacer clic en el botón "Guardar", mostrar el modal de confirmación
        $('#btnShowModal').click(function() {
            // Validar el formulario
            if (!$('#createEspecialidadForm')[0].checkValidity()) {
                $('#createEspecialidadForm')[0].reportValidity();
                return;
            }
            // Construir el mensaje de confirmación
            const message = `
            <strong>¿Está seguro de que desea registrar esta especialidad?</strong><br>
                Nombre de la Especialidad: ${$('#name').val()}<br>
            `;
            // Establecer el mensaje de confirmación
            $('#confirmMessageCreate').html(message);
            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmCreateModal'));
            modal.show();
        });

        // Confirmar creación desde el modal
        $('#btnConfirmCreate').click(function() {
            // Validar el formulario
            if ($('#createEspecialidadForm')[0].checkValidity()) {
                // Enviar el formulario
                $('#createEspecialidadForm').submit();
            } else {
                // Mostrar errores de validación
                $('#createEspecialidadForm')[0].reportValidity();
            }
        });

        /* eliminar */
        // Delegación de eventos para todos los botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            // Obtener el formulario específico para este doctor
            const form = $(this).closest('form');

            // Configurar mensaje
            const message = `
            ¿Está seguro que desea eliminar este doctor?
            Esta acción no se puede deshacer.
        `;
            $('#confirmMessageDelete').html(message);

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

        /* editar */
        // Editar especialidad
        $(document).on('click', '.btn-edit', function() {
            const especialidadId = $(this).data('especialidad-id');
            const especialidadName = $(this).data('especialidad-name');

            // Rellenar el formulario con los datos de la especialidad
            $('#editEspecialidadName').val(especialidadName);

            // Aquí generamos la URL de actualización sin el :id
            const updateUrl = '{{ route('admin.especialidad.update', ['id' => ':id']) }}'.replace(':id',
                especialidadId);

            // Ahora, actualizamos la acción del formulario con la URL completa
            $('#editEspecialidadForm').attr('action', updateUrl);

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();
        });


        // Confirmar la edición
        $('#btnConfirmEdit').click(function() {
            $('#editEspecialidadForm').submit();
        });
    </script>
@endsection
