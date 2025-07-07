@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">EDITAR DOCTOR</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST" id="editDoctorForm"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- INFORMACION BASICA --}}
            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACION BASICA</h5>
                <div class="col-md-4">
                    {{-- DNI --}}
                    <div class="md-3 mb-3">
                        <label>DNI</label>
                        <input type="text" class="form-control" name="document_id" id="document_id" maxlength="8"
                            inputmode="numeric" pattern="\d{8}"
                            value="{{ old('document_id', $doctor->user->document_id ?? '') }}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                            title="Ingrese exactamente 8 dígitos numéricos">
                    </div>
                    {{-- NOMBRE --}}
                    <div class="md-3 mb-3">
                        <label>Nombres</label>
                        <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control"
                            name="first_name" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                            value="{{ old('first_name', $doctor->user->profile->first_name ?? '') }}" required>
                    </div>
                    {{-- CODIGO DE LICENCIA --}}
                    <div class="mb-3">
                        <label for="license_code" class="form-label">Código de Licencia</label>
                        <input type="text" class="form-control" name="license_code" id="license_code" maxlength="6"
                            inputmode="numeric" pattern="\d{6}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 6);"
                            value="{{ old('license_code', $doctor->license_code ?? '') }}"
                            title="Ingrese exactamente 6 caracteres numéricos">
                        @error('license_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- APELLIDO --}}
                    <div class="md-3 mb-3">
                        <label>Apellidos</label>
                        <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control"
                            name="last_name" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                            value="{{ old('last_name', $doctor->user->profile->last_name ?? '') }}" required>
                    </div>
                    {{-- ESPECIALIDAD --}}
                    <div class="md-3 mb-3">
                        <label>Especialidad</label>
                        <select name="specialty_id" id="specialty_id" class="form-select" required>
                            <option value="">Selecciona...</option>
                            @foreach ($specialty as $specialty)
                                <option value="{{ $specialty->id }}"
                                    {{ old('specialty_id', $doctor->specialty_id) == $specialty->id ? 'selected' : '' }}>
                                    {{ $specialty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- AÑOS DE EXPERIENCIA --}}
                    <div class="mb-3">
                        <label for="experience_years" class="form-label">Años de Experiencia</label>
                        <input type="text" class="form-control" name="experience_years" id="experience_years"
                            maxlength="2" inputmode="numeric" pattern="\d{2}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 2);"
                            title="Ingrese exactamente 2 caracteres numéricos">
                        @error('experience_years')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <hr>

            {{-- INFORMACION DE CONTACTO --}}
            <div class="row mt-4 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACION DE CONTACTO</h5>
                <div class="col-md-4">
                    {{-- TELEFONO --}}
                    <div class="md-3 mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="9"
                            inputmode="numeric" pattern="9\d{8}"
                            value="{{ old('phone', $doctor->user->profile->phone ?? '') }}" required
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
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- EMAIL --}}
                    <div class="md-3 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $doctor->user->profile->email ?? '') }}" required>
                    </div>
                </div>
            </div>
            <hr>

            {{-- INFORMACION PERSONAL --}}
            <div class="row mt-3 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACION PERSONAL</h5>
                <div class="col-md-4">
                    {{-- FECHA DE NACIMIENTO --}}
                    <div class="md-3 mb-3">
                        <label>Fecha de nacimiento</label>
                        <input type="date" class="form-control" name="birthdate" id="birthdate"
                            value="{{ old('birthdate', isset($doctor->user->profile->birthdate) ? $doctor->user->profile->birthdate->format('Y-m-d') : '') }}"
                            required>
                    </div>
                    {{-- GENERO --}}
                    <div class="md-3 mb-3">
                        <label>Género</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0"
                                {{ old('gender', $doctor->user->profile->gender ?? '') == '0' ? 'selected' : '' }}>
                                Masculino</option>
                            <option value="1"
                                {{ old('gender', $doctor->user->profile->gender ?? '') == '1' ? 'selected' : '' }}>
                                Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- ESTADO CIVIL --}}
                    <div class="md-3 mb-3">
                        <label>Estado civil</label>
                        <select name="civil_status" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0"
                                {{ old('civil_status', $doctor->user->profile->civil_status ?? '') == '0' ? 'selected' : '' }}>
                                Soltero(a)</option>
                            <option value="1"
                                {{ old('civil_status', $doctor->user->profile->civil_status ?? '') == '1' ? 'selected' : '' }}>
                                Casado(a)</option>
                            <option value="2"
                                {{ old('civil_status', $doctor->user->profile->civil_status ?? '') == '2' ? 'selected' : '' }}>
                                Viudo(a)</option>
                            <option value="3"
                                {{ old('civil_status', $doctor->user->profile->civil_status ?? '') == '3' ? 'selected' : '' }}>
                                Divorciado(a)</option>
                        </select>
                    </div>
                    {{-- DIRECCION --}}
                    <div class="md-3 mb-3">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ old('address', $doctor->user->profile->address ?? '') }}" required>
                    </div>
                </div>
            </div>

            <div class="row mt-4 justify-content-center">
                <div class="col-md-4 d-flex justify-content-start">
                    <a href="{{ route('admin.doctor.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
            if (!$('#editDoctorForm')[0].checkValidity()) {
                $('#editDoctorForm')[0].reportValidity();
                return;
            }

            const message = `¿Estás seguro de que deseas editar los datos de este médico?`;
            $('#confirmMessage').html(message);

            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();

            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
            }
        });

        $('#btnConfirmEdit').click(function() {
            $('#editDoctorForm').submit();
        });
    </script>
@endpush
