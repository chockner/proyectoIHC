@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Doctores</h1>
        <div class="mb-3 flex justify-end">
            <a href="{{ route('admin.doctor.create') }}"
                class="flex items-center gap-2 rounded-md border border-gray-200 bg-white px-4 py-2 shadow-sm hover:shadow-md transition-all duration-150">
                <div class="relative">
                    <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-9 h-9">
                        <path
                            d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                        </path>
                    </svg>
                    <span
                        class="material-icons absolute -top-1 -right-1 bg-green-100 text-green-600 rounded-full text-sm p-0.5">add_circle</span>
                </div>
                <span class="text-green-700 font-medium text-sm">Agregar Médico</span>
            </a>
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
                        <td class="px-6 py-4 ">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 ">{{ $doctor->user->profile->first_name }}</td>
                        <td class="px-6 py-4 ">{{ $doctor->user->profile->last_name }}</td>
                        <td class="px-6 py-4 ">{{ $doctor->specialty->name }}</td>
                        <td class="px-6 py-4 ">{{ $doctor->user->profile->email }}</td>
                        <td class="px-6 py-4 ">{{ $doctor->user->profile->phone }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- icono ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.doctor.show', $doctor->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Ver">
                                        <div class="relative">
                                            <svg class="text-blue-600" fill="currentColor" height="24px"
                                                viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                                                </path>
                                            </svg>
                                            <span
                                                class="material-icons absolute -bottom-1 -right-1 text-xs bg-blue-100 text-blue-600 rounded-full p-0.5">visibility</span>
                                        </div>
                                    </a>
                                </div>
                                {{-- icono editar --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('admin.doctor.edit', $doctor->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Editar">
                                        <div class="relative">
                                            <svg class="text-orange-500" fill="currentColor" height="24px"
                                                viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                                                </path>
                                            </svg>
                                            <span
                                                class="material-icons absolute -bottom-1 -right-1 text-xs bg-orange-100 text-orange-600 rounded-full p-0.5">edit</span>
                                        </div>
                                    </a>
                                </div>
                                {{-- icono eliminar --}}
                                <div class="flex flex-col items-center">
                                    <form action="{{ route('admin.doctor.destroy', $doctor->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2 btn-delete"
                                            data-form-id="form-{{ $doctor->id }}" data-bs-toggle="tooltip"
                                            data-bs-title="Eliminar">
                                            <div class="relative">
                                                <svg class="text-red-500" fill="currentColor" height="24px"
                                                    viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="material-icons absolute -bottom-1 -right-1 text-xs bg-red-100 text-red-600 rounded-full p-0.5">delete_outline</span>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if ($doctores->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay doctores registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $doctores->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $doctores->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                @for ($i = 1; $i <= $doctores->lastPage(); $i++)
                    <li class="page-item {{ $i == $doctores->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $doctores->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
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
@endpush
