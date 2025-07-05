@extends('layouts.dashboard')

@section('content')
    <h2>Agregar Paciente</h2>
    <form action="{{ route('admin.paciente.store') }}" method="POST" id="createPacienteForm">
        @csrf
        <div class="mb-3">
            <label for="document_id" class="form-label">DNI</label>
            <input type="text" class="form-control" name="document_id" id="document_id" maxlength="8" inputmode="numeric"
                pattern="\d{8}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                title="Ingrese exactamente 8 dígitos numéricos" required>
            @error('document_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">Nombres</label>
            <input type="text" class="form-control" name="first_name" id="first_name"
                onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');">
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Apellidos</label>
            <input type="text" class="form-control" name="last_name" id="last_name"
                onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');">
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="button" class="btn btn-primary submit-btn" id="btnShowModal">Guardar</button>
    </form>
    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmCreateModal" tabindex="-1" aria-labelledby="confirmCreateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="confirmCreateModalLabel">Confirmar Registro de Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <p id="confirmMessage">¿Está seguro que desea registrar este paciente?</p>
                        <div class="alert alert-primary mt-2">
                            Se registrara un nuevo dotor.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnConfirmCreate" class="btn btn-primary">Agregar Doctor</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        //al hacer clic en el botón "Guardar", mostrar el modal de confirmación
        $('#btnShowModal').click(function() {
            //validar el formulario
            if (!$('#createPacienteForm')[0].checkValidity()) {
                //mostrar errores de validación
                $('#createPacienteForm')[0].reportValidity();
                return;
            }
            //construir el mensaje de confirmación
            const message = `
                <strong>Datos del Paciente:</strong><br>
                Nombre: ${$('input[name="name"]').val()}<br>
                Apellido: ${$('input[name="lastname"]').val()}<br>
            `;
            //establecer el mensaje de confirmación
            $('#confirmMessage').html(message);
            //mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmCreateModal'));
            modal.show();
        });

        // confirmar creaciopn desde modal
        $('#btnConfirmCreate').click(function() {
            //validar el formulario
            if ($('#createPacienteForm')[0].checkValidity()) {
                //enviar el formulario
                $('#createPacienteForm').submit();
            } else {
                //mostrar errores de validación
                $('#createPacienteForm')[0].reportValidity();
            }
        });
    </script>
@endsection
