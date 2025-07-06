@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Secretarias</h1>
        <div class="mb-3 flex justify-end">
            <a href="{{ route('admin.secretaria.create') }}"
                class="flex items-center gap-2 rounded-md border border-gray-200 bg-white px-4 py-2 shadow-sm hover:shadow-md transition-all duration-150">
                <div class="relative">
                    <span
                        class="material-icons text-pink-500 text-4xl opacity-75 group-hover:opacity-100 transition-opacity duration-200">
                        support_agent
                    </span>
                    <span
                        class="material-icons text-green-500 text-base absolute -top-1 -right-1 bg-white rounded-full p-0.5 shadow-md border border-slate-100 group-hover:scale-110 transition-transform duration-200">
                        add_circle_outline
                    </span>
                </div>
                <span>Agregar Secretaria</span>
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
                        <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 ">{{ $secretaria->user->profile->first_name }}</td>
                        <td class="px-6 py-4 ">{{ $secretaria->user->profile->last_name }}</td>
                        <td class="px-6 py-4 ">{{ $secretaria->user->profile->email }}</td>
                        <td class="px-6 py-4 ">{{ $secretaria->user->profile->phone }}</td>
                        <td>
                            <div class="mb-3 flex justity-center space-x-2">
                                {{-- icono ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.secretaria.show', $secretaria->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 ">
                                        <div class="relative">
                                            <span
                                                class="material-icons text-pink-500 text-3xl opacity-75 group-hover:opacity-100 transition-opacity duration-200">support_agent</span>
                                            <span
                                                class="material-icons text-blue-500 text-base absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-md border border-slate-100 group-hover:scale-110 transition-transform duration-200">visibility</span>
                                        </div>
                                    </a>
                                    <span>Ver</span>
                                </div>
                                {{-- icono editar --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.secretaria.edit', $secretaria->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 ">
                                        <div class="relative">
                                            <span
                                                class="material-icons text-pink-500 text-3xl opacity-75 group-hover:opacity-100 transition-opacity duration-200">support_agent</span>
                                            <span
                                                class="material-icons text-yellow-500 text-base absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-md border border-slate-100 group-hover:scale-110 transition-transform duration-200">edit</span>
                                        </div>
                                    </a>
                                    <span>Editar</span>
                                </div>
                                {{-- icono eliminar --}}
                                <form action="{{ route('admin.secretaria.destroy', $secretaria->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                        data-form-id="form-{{ $secretaria->id }}">
                                        <div class="relative">
                                            <span
                                                class="material-icons text-pink-500 text-3xl opacity-75 group-hover:opacity-100 transition-opacity duration-200">support_agent</span>
                                            <span
                                                class="material-icons text-red-500 text-base absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-md border border-slate-100 group-hover:scale-110 transition-transform duration-200">delete</span>
                                        </div>
                                    </button>
                                    <span>Eliminar</span>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if ($secretarias->isEmpty())
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
                <li class="page-item {{ $secretarias->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $secretarias->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                {{-- Enlaces de páginas --}}
                @foreach ($secretarias->getUrlRange(1, $secretarias->lastPage()) as $page => $url)
                    <li class="page-item {{ $secretarias->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                {{-- Enlace "Next" --}}
                <li class="page-item {{ $secretarias->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $secretarias->nextPageUrl() }}" aria-label="Next">Siguiente</a>
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
            ¿Está seguro que desea eliminar esta secretaria?
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
