@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Editar Paciente</h2>
        <form action="{{ route('admin.paciente.update', $paciente->id) }}" method="POST" id="editPacienteForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="{{ old('first_name', $paciente->user->profile->first_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="{{ old('last_name', $paciente->user->profile->last_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $paciente->user->profile->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $paciente->user->profile->phone) }}" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.paciente.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="button" class="btn btn-success" id="btnEdit">Guardar Cambios</button>

            </div>
        </form>
    </div>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmEditModalLabel">Confirmar Edición</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <p id="confirmMessage"></p>
                        <div class="alert alert-warning mt-2">
                            Esta acción puede afectar la consistencia de los datos.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnConfirmEdit" class="btn btn-warning">Confirmar Edición</button>
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
        $('#btnEdit').click(function() {
            //validar el formulario
            if (!$('#editPacienteForm')[0].checkValidity()) {
                //si el formulario no es válido, mostrar los mensajes de error
                $('#editPacienteForm')[0].reportValidity();
                return;
            }
            //confirgurar el mensaje de confirmación
            const message = `¿Es seguro que deseas editar los datos de este paciente?`;
            $('#confirmMessage').html(message);

            //mostrar el modal de confirmación
            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();

            //reproducir el sonido de alerta
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
            }
        });

        //confirmar la edición
        $('#btnConfirmEdit').click(function() {
            //enviar el formulario
            $('#editPacienteForm').submit();
        });
    </script>
@endsection
