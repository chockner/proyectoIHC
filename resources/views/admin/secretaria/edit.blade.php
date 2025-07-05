@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h2>Editar Secretaria</h2>
        <form action="{{ route('admin.secretaria.update', $secretaria->id) }}" method="POST" id="editSecretariaForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">Nombres</label>
                <input type="text" name="first_name" id="first_name" class="form-control"
                    onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                    value="{{ $secretaria->user->profile->first_name }}"required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Apellidos</label>
                <input type="text" name="last_name" id="last_name" class="form-control"
                    onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                    value="{{ $secretaria->user->profile->last_name }}" required>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.secretaria.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
            if (!$('#editSecretariaForm')[0].checkValidity()) {
                //si el formulario no es válido, mostrar los mensajes de error
                $('#editSecretariaForm')[0].reportValidity();
                return;
            }
            //confirgurar el mensaje de confirmación
            const message = `¿Es seguro que deseas editar los datos de este médico?`;
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
            $('#editSecretariaForm').submit();
        });
    </script>
@endsection
