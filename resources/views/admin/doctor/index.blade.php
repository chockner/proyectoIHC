@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Lista de Doctores</h2>
        <div class="mb-3">
            <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary">Agregar Doctor</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Especialidad</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($doctores as $index => $doctor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $doctor->user->profile->first_name }}</td>
                        <td>{{ $doctor->user->profile->last_name }}</td>
                        <td>{{ $doctor->specialty->name }}</td>
                        <td>{{ $doctor->user->profile->email }}</td>
                        <td>{{ $doctor->user->profile->phone }}</td>
                        <td>
                            <a href="{{ route('admin.doctor.show', $doctor->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.doctor.destroy', $doctor->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete"
                                    data-form-id="form-{{ $doctor->id }}">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($doctores->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay doctores registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Enlace "First" --}}
                {{-- Enlace "Previous" --}}
                <li class="page-item {{ $doctores->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $doctores->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>

                {{-- Páginas numéricas --}}
                @for ($i = 1; $i <= $doctores->lastPage(); $i++)
                    <li class="page-item {{ $i == $doctores->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $doctores->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Enlace "Next" --}}
                <li class="page-item {{ $doctores->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $doctores->nextPageUrl() }}" aria-label="Next">Siguiente</a>
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
        // Delegación de eventos para todos los botones de eliminar
        $(document).on('click', '.btn-delete', function() {
            // Obtener el formulario específico para este doctor
            const form = $(this).closest('form');

            // Configurar mensaje
            const message = `
            ¿Está seguro que desea eliminar este doctor?
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
