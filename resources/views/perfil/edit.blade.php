@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">EDITAR PERFIL</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
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
                            value="{{ old('document_id', Auth::user()->document_id ?? '') }}" required
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                            title="Ingrese exactamente 8 dígitos numéricos" required>
                    </div>
                    {{-- NOMBRE --}}
                    <div class = "md-3 mb-3">
                        <label>Nombres</label>
                        <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control"
                            name="first_name" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                            value="{{ old('first_name', Auth::user()->profile->first_name ?? '') }}" required>
                    </div>

                </div>
                <div class="col-md-4">

                    {{-- APELLIDO --}}
                    <div class="md-3 mb-3">
                        <label>Apellidos</label>
                        <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control"
                            name="last_name" value="{{ old('last_name', Auth::user()->profile->last_name ?? '') }}"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');" required>
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
                            value="{{ old('phone', Auth::user()->profile->phone ?? '') }}" required
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
                            value="{{ old('email', Auth::user()->profile->email ?? '') }}" required>
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
                            value="{{ old('birthdate', isset(Auth::user()->profile->birthdate) ? Auth::user()->profile->birthdate->format('Y-m-d') : '') }}"
                            required>
                    </div>
                    {{-- GENERO --}}
                    <div class="md-3 mb-3">
                        <label>Género</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="0"
                                {{ isset(Auth::user()->profile->gender) && Auth::user()->profile->gender == '0' ? 'selected' : '' }}>
                                Masculino</option>
                            <option value="1"
                                {{ isset(Auth::user()->profile->gender) && Auth::user()->profile->gender == '1' ? 'selected' : '' }}>
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
                                {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '0' ? 'selected' : '' }}>
                                Soltero(a)</option>
                            <option value="1"
                                {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '1' ? 'selected' : '' }}>
                                Casado(a)</option>
                            <option value="2"
                                {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '2' ? 'selected' : '' }}>
                                Viudo(a)</option>
                            <option value="3"
                                {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '3' ? 'selected' : '' }}>
                                Divorciado(a)</option>
                        </select>
                    </div>
                    {{-- DIRECCION --}}
                    <div class="md-3 mb-3">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ old('address', Auth::user()->profile->address ?? '') }}" required>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary px-5">Guardar Cambios</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    {{-- modal --}}
@endpush
