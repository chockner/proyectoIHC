@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Editar Perfil</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- INFORMACION BASICA --}}
        <div class="row mt-2">
            <h5>INFORMACION BASICA</h5>
            <div class="col-md-4">
                <label>Foto de perfil</label>
                <input type="file" class="form-control" name="photo">
                {{-- @if($profile->photo) --}}
                    <img src="{{ asset('storage/'.$profile->photo) }}" alt="{{ 'foto de '.$profile->last_name }}" class="img-thumbnail mt-2" width="100">
               {{--  @endif --}}

            </div>
            <div class="col-md-4">
                {{-- DNI --}}
                <div class="md-3 mb-3">
                    <label>DNI</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="document_id" 
                        id="document_id" 
                        maxlength="8" 
                        inputmode="numeric" 
                        pattern="\d{8}" 
                        value="{{ old('document_id', optional($profile)->user->document_id ?? '') }}"
                        required 
                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                        title="Ingrese exactamente 8 dígitos numéricos"
                        required
                    >
                </div>
                {{-- NOMBRE --}}
                <div class = "md-3 mb-3">
                    <label>Nombres</label>
                    <input  
                        type="text"
                        onkeyup="this.value = this.value.toUpperCase();"
                        class="form-control"
                        name="first_name"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                        value="{{ old('first_name', optional($profile)->first_name ?? '') }}"
                        required>
                </div>
                {{-- APELLIDO --}}
                <div class="md-3 mb-3">
                    <label>Apellidos</label>
                    <input 
                        type="text"
                        onkeyup="this.value = this.value.toUpperCase();"
                        class="form-control"
                        name="last_name"
                        value="{{ old('last_name', optional($profile)->last_name ?? '') }}"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                        oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"                    
                        required
                    >
                </div>

            </div>
        </div>

        {{-- INFORMACION DE CONTACTO --}}
        <div class="row mt-4">
            <h5>INFORMACION DE CONTACTO</h5>
            <div class="col-md-4">
                {{-- TELEFONO --}}
                <div class="md-3 mb-3">
                    <label>Teléfono</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="phone" 
                        id="phone" 
                        maxlength="9" 
                        inputmode="numeric" 
                        pattern="9\d{8}" 
                        value="{{ old('phone', optional($profile)->phone ?? '') }}" 
                        required 
                        oninput="
                            this.value = this.value.replace(/\D/g, '');
                            if (this.value.length === 1 && this.value !== '9') {
                                this.value = '';
                            }
                            if (this.value.length > 9) {
                                this.value = this.value.slice(0, 9);
                            }
                        " 
                        title="Ingrese un número de 9 dígitos que comience con 9"
                    >
                </div>
            </div>
            <div class="col-md-4">
                {{-- EMAIL --}}
                <div class="md-3 mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', optional($profile)->email ?? '') }}" required>
                </div>

            </div>
        </div>

        {{-- INFORMACION PERSONAL --}}
        <div class="row mt-3">
            <h5>INFORMACION PERSONAL</h5>

            <div class="col-md-4">
                {{-- FECHA DE NACIMIENTO --}}
                <div class="md-3 mb-3">
                    <label>Fecha de nacimiento</label>
                    <input type="date"
                        class="form-control"
                        name="birthdate"
                        id="birthdate"
                        value="{{ old('birthdate', optional($profile->birthdate)->format('Y-m-d') ?? '') }}"
                        required
                    >
                    
                </div>
                {{-- GENERO --}}
                <div class="md-3 mb-3">
                    <label>Género</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="0" {{ $profile->gender == '0' ? 'selected' : '' }}>Masculino</option>
                        <option value="1" {{ $profile->gender == '1' ? 'selected' : '' }}>Femenino</option>
                    </select>
                
                </div>  
                {{-- ESTADO CIVIL --}}
                <div class="md-3 mb-3">
                    <label>Estado civil</label>
                    <select name="civil_status" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="0" {{ $profile->civil_status == '0' ? 'selected' : '' }}>Soltero(a)</option>
                        <option value="1" {{ $profile->civil_status == '1' ? 'selected' : '' }}>Casado(a)</option>
                        <option value="2" {{ $profile->civil_status == '2' ? 'selected' : '' }}>Viudo(a)</option>
                        <option value="3" {{ $profile->civil_status == '3' ? 'selected' : '' }}>Divorciado(a)</option>
                    </select>

                </div>
                {{-- DIRECCION --}}
                <div class="md-3 mb-3">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address', optional($profile)->address ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                {{-- REGION --}}
                <div class="md-3 mb-3">
                    <label for="region">Región</label>
                    <select id="region" name="region" class="form-select" required>
                        <option value="{{ old('region', optional($profile)->region ?? '') }}">Seleccione una región</option>
                    </select>
                </div>
                {{-- PROVINCIA --}}
                <div class="md-3 mb-3">
                    <label for="province">Provincia</label>
                    <select id="province" name="province" class="form-select" required disabled>
                        <option value="{{ old('province', optional($profile)->province ?? '') }}">Seleccione una provincia</option>
                    </select>
                </div>
                {{-- DISTRITO --}}
                <div class="md-3 mb-3">
                    <label for="district">Distrito</label>
                    <select id="district" name="district" class="form-select" required disabled>
                        <option value="{{ old('district', optional($profile)->district ?? '') }}">Seleccione un distrito</option>
                    </select>
                </div>
                {{-- Campos ocultos para almacenar los nombres --}}
                <input type="hidden" name="region_nombre" id="region_nombre">
                <input type="hidden" name="province_nombre" id="province_nombre">
                <input type="hidden" name="district_nombre" id="district_nombre">

                {{-- PAIS --}}
                {{-- <div class="md-3 mb-3">
                    <label>País</label>
                    <input type="text" class="form-control" name="country" value="{{ old('country', optional($profile)->country ?? '') }}">

                </div> --}}
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary px-5">Guardar Cambios</button>
        </div>
    </form>



</div>
@endsection
