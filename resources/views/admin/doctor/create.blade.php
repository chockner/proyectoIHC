@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">AGREGAR DOCTOR</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.doctor.store') }}" method="POST" id="createDoctorForm">
            @csrf

            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN BÁSICA</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="document_id" class="form-label">DNI</label>
                        <input type="text" class="form-control" name="document_id" id="document_id" maxlength="8"
                            inputmode="numeric" pattern="\d{8}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                            title="Ingrese exactamente 8 dígitos numéricos">
                        @error('document_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nombres</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');" required>
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="license_code" class="form-label">Código de Licencia</label>
                        <input type="text" class="form-control" name="license_code" id="license_code" maxlength="6"
                            inputmode="numeric" pattern="\d{6}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 6);"
                            title="Ingrese exactamente 6 caracteres numéricos">
                        @error('license_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');" required>
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="specialty_id" class="form-label">Especialidad</label>
                        <select name="specialty_id" id="specialty_id" class="form-select" required>
                            <option value="">Selecciona...</option>
                            @foreach ($specialty as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                        @error('specialty_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="experience_years" class="form-label">Años de Experiencia</label>
                        <input type="number" class="form-control" name="experience_years" id="experience_years"
                            min="0" max="50" step="1" required title="Ingrese un número entre 0 y 50">
                        @error('experience_years')
                            <div class="text-danger">{{ $message }}</div>
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
                            title="Ingrese un número de 9 dígitos que comience con 9">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
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
                        <input type="date" class="form-control" name="birthdate" id="birthdate" required>
                        @error('birthdate')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Género</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0">Masculino</option>
                            <option value="1">Femenino</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="civil_status" class="form-label">Estado Civil</label>
                        <select name="civil_status" id="civil_status" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0">Soltero(a)</option>
                            <option value="1">Casado(a)</option>
                            <option value="2">Viudo(a)</option>
                            <option value="3">Divorciado(a)</option>
                        </select>
                        @error('civil_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="address" id="address" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="btnShowModal">Guardar</button>
                </div>
            </div>
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
                            <p id="confirmMessage"></p>
                            <div class="alert alert-primary mt-2">
                                Se registrará un nuevo doctor.
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
    </div>
@endsection

@push('scripts')
    <script>
        // Al hacer clic en el botón "Guardar", mostrar el modal de confirmación
        $('#btnShowModal').click(function() {
            // Validar el formulario
            if (!$('#createDoctorForm')[0].checkValidity()) {
                $('#createDoctorForm')[0].reportValidity();
                return;
            }

            // Construir el mensaje de confirmación
            const message = `
            <strong>Datos del Doctor:</strong><br>
            DNI: ${$('#document_id').val()}<br>
            Nombres: ${$('#first_name').val()}<br>
            Apellidos: ${$('#last_name').val()}<br>
            Especialidad: ${$('#specialty_id option:selected').text()}<br>
            Código de Licencia: ${$('#license_code').val()}<br>
            Años de Experiencia: ${$('#experience_years').val()}<br>
            Teléfono: ${$('#phone').val()}<br>
            Correo Electrónico: ${$('#email').val()}<br>
            Fecha de Nacimiento: ${$('#birthdate').val()}<br>
            Género: ${$('#gender option:selected').text()}<br>
            Estado Civil: ${$('#civil_status option:selected').text()}<br>
            Dirección: ${$('#address').val()}
        `;
            // Establecer el mensaje de confirmación
            $('#confirmMessage').html(message);

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('confirmCreateModal'));
            modal.show();
        });

        // Confirmar creación desde el modal
        $('#btnConfirmCreate').click(function() {
            // Validar el formulario
            if ($('#createDoctorForm')[0].checkValidity()) {
                // Enviar el formulario
                $('#createDoctorForm').submit();
            } else {
                // Mostrar errores de validación
                $('#createDoctorForm')[0].reportValidity();
            }
        });
    </script>
@endpush
