@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">EDITAR SECRETARIA</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.secretaria.update', $secretaria->id) }}" method="POST" id="editSecretariaForm">
            @csrf
            @method('PUT')

            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN BÁSICA</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="document_id" class="form-label">DNI</label>
                        <input type="text" class="form-control" name="document_id" id="document_id" maxlength="8"
                            inputmode="numeric" pattern="\d{8}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                            value="{{ old('document_id', $secretaria->user->document_id ?? '') }}"
                            title="Ingrese exactamente 8 dígitos numéricos">
                        @error('document_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                            value="{{ old('first_name', $secretaria->user->profile->first_name ?? '') }}" required>
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                            value="{{ old('last_name', $secretaria->user->profile->last_name ?? '') }}" required>
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>

            <div class="row mt-4 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE CONTACTO</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="9"
                            inputmode="numeric" pattern="9\d{8}" required
                            oninput="
                                this.value = this.value.replace(/\D/g, '');
                                if (this.value.length === 1 && this.value !== '9') {
                                    this.value = '';
                                }
                                if (this.value.length > 9) {
                                    this.value = this.value.slice(0, 9);
                                }
                            "
                            value="{{ old('phone', $secretaria->user->profile->phone ?? '') }}"
                            title="Ingrese un número de 9 dígitos que comience con 9">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email', $secretaria->user->profile->email ?? '') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>

            <div class="row mt-3 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN PERSONAL</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="birthdate" id="birthdate"
                            value="{{ old('birthdate', isset($secretaria->user->profile->birthdate) ? $secretaria->user->profile->birthdate->format('Y-m-d') : '') }}"
                            required>
                        @error('birthdate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Género</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0"
                                {{ old('gender', $secretaria->user->profile->gender ?? '') == '0' ? 'selected' : '' }}>
                                Masculino</option>
                            <option value="1"
                                {{ old('gender', $secretaria->user->profile->gender ?? '') == '1' ? 'selected' : '' }}>
                                Femenino</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="civil_status" class="form-label">Estado Civil</label>
                        <select name="civil_status" id="civil_status" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0"
                                {{ old('civil_status', $secretaria->user->profile->civil_status ?? '') == '0' ? 'selected' : '' }}>
                                Soltero(a)</option>
                            <option value="1"
                                {{ old('civil_status', $secretaria->user->profile->civil_status ?? '') == '1' ? 'selected' : '' }}>
                                Casado(a)</option>
                            <option value="2"
                                {{ old('civil_status', $secretaria->user->profile->civil_status ?? '') == '2' ? 'selected' : '' }}>
                                Viudo(a)</option>
                            <option value="3"
                                {{ old('civil_status', $secretaria->user->profile->civil_status ?? '') == '3' ? 'selected' : '' }}>
                                Divorciado(a)</option>
                        </select>
                        @error('civil_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="address" id="address"
                            value="{{ old('address', $secretaria->user->profile->address ?? '') }}" required>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="{{ route('admin.secretaria.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-success" id="btnEdit">Guardar Cambios</button>
                </div>
            </div>
        </form>

        <!-- Modal de confirmación -->
        <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel"
            aria-hidden="true">
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
    </div>
@endsection
@push('scripts')
    <script>
        // Validación del formulario y modal de confirmación
        $('#btnEdit').click(function() {
            // Validar el formulario
            if (!$('#editSecretariaForm')[0].checkValidity()) {
                $('#editSecretariaForm')[0].reportValidity();
                return;
            }

            // Construir el mensaje de confirmación
            const message = `
            <strong>Datos de la Cita:</strong><br>
            DNI: ${$('#document_id').val()}<br>
            Nombres: ${$('#first_name').val()}<br>
            Apellidos: ${$('#last_name').val()}<br>
            Teléfono: ${$('#phone').val()}<br>
            Correo Electrónico: ${$('#email').val()}<br>
            Fecha de Nacimiento: ${$('#birthdate').val()}<br>
            Género: ${$('#gender option:selected').text()}<br>
            Estado Civil: ${$('#civil_status option:selected').text()}<br>
            Dirección: ${$('#address').val()}
        `;
            $('#confirmMessage').html(message);

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();

            // Reproducir el sonido de alerta
            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
            }
        });

        // Confirmar edición desde el modal
        $('#btnConfirmEdit').click(function() {
            $('#editSecretariaForm').submit();
        });
    </script>
@endpush
