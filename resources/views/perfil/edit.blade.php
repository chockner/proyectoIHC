@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-4">Editar Perfil</h3>

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
            <div class="row mt-2">
                <h5>INFORMACION BASICA</h5>
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

            {{-- INFORMACION DE CONTACTO --}}
            <div class="row mt-4">
                <h5>INFORMACION DE CONTACTO</h5>
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

            {{-- INFORMACION PERSONAL --}}
            <div class="row mt-3">
                <h5>INFORMACION PERSONAL</h5>

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
                <div class="col-md-4">
                    {{-- REGION --}}
                    <div class="md-3 mb-3">
                        <label for="region">Región</label>
                        <select id="region" name="region" class="form-select" required>
                            <option value="">Seleccione una región</option>
                        </select>
                    </div>
                    {{-- PROVINCIA --}}
                    <div class="md-3 mb-3">
                        <label for="province">Provincia</label>
                        <select id="province" name="province" class="form-select" required disabled>
                            <option value="">Seleccione una provincia</option>
                        </select>
                    </div>
                    {{-- DISTRITO --}}
                    <div class="md-3 mb-3">
                        <label for="district">Distrito</label>
                        <select id="district" name="district" class="form-select" required disabled>
                            <option value="">Seleccione un distrito</option>
                        </select>
                    </div>
                    {{-- Campos ocultos para almacenar los nombres --}}
                    <input type="hidden" name="region_nombre" id="region_nombre"
                        value="{{ Auth::user()->profile->region ?? '' }}">
                    <input type="hidden" name="province_nombre" id="province_nombre"
                        value="{{ Auth::user()->profile->province ?? '' }}">
                    <input type="hidden" name="district_nombre" id="district_nombre"
                        value="{{ Auth::user()->profile->district ?? '' }}">
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary px-5">Guardar Cambios</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const regionSelect = document.getElementById('region');
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');

            // Obtener los valores actuales del perfil
            const regionActual = @json(Auth::user()->profile->region ?? '');
            const provinciaActual = @json(Auth::user()->profile->province ?? '');
            const distritoActual = @json(Auth::user()->profile->district ?? '');

            if (!regionSelect || !provinceSelect || !districtSelect) return;

            let departamentos = [];
            let provincias = [];
            let distritos = [];

            // Función para normalizar textos
            function normalizarTexto(texto) {
                return texto
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .toUpperCase()
                    .replace(/[^A-Z0-9 ]/g, '');
            }

            Promise.all([
                    fetch('/js/ubigeo_peru_2016_departamentos.json').then(res => res.json()),
                    fetch('/js/ubigeo_peru_2016_provincias.json').then(res => res.json()),
                    fetch('/js/ubigeo_peru_2016_distritos.json').then(res => res.json())
                ])
                .then(([depts, provs, dists]) => {
                    departamentos = depts;
                    provincias = provs;
                    distritos = dists;

                    cargarRegiones();
                    seleccionarUbigeoActual(); // Mover aquí después de cargar todo
                })
                .catch(error => {
                    console.error('Error cargando archivos JSON:', error);
                    alert('Error al cargar datos de ubicación. Por favor recarga la página.');
                });

            function cargarRegiones() {
                // Ordenar departamentos alfabéticamente
                departamentos.sort((a, b) => a.name.localeCompare(b.name));

                // Limpiar y agregar opciones
                regionSelect.innerHTML = '<option value="">Seleccione una región</option>';
                departamentos.forEach(dep => {
                    const option = new Option(dep.name, dep.id);
                    regionSelect.add(option);
                });
            }

            function seleccionarUbigeoActual() {
                if (!regionActual) return;

                const regionNormalizada = normalizarTexto(regionActual);
                const provinciaNormalizada = normalizarTexto(provinciaActual);
                const distritoNormalizada = normalizarTexto(distritoActual);

                // Buscar región actual
                const regionEncontrada = departamentos.find(dep =>
                    normalizarTexto(dep.name) === regionNormalizada
                );

                if (regionEncontrada) {
                    regionSelect.value = regionEncontrada.id;
                    cargarProvincias(regionEncontrada.id, () => {
                        // Buscar provincia actual después de cargar
                        const provinciaEncontrada = provincias.find(prov =>
                            prov.department_id === regionEncontrada.id &&
                            normalizarTexto(prov.name) === provinciaNormalizada
                        );

                        if (provinciaEncontrada) {
                            provinceSelect.value = provinciaEncontrada.id;
                            cargarDistritos(provinciaEncontrada.id, () => {
                                // Buscar distrito actual después de cargar
                                const distritoEncontrado = distritos.find(dist =>
                                    dist.province_id === provinciaEncontrada.id &&
                                    normalizarTexto(dist.name) === distritoNormalizada
                                );

                                if (distritoEncontrado) {
                                    // CORRECCIÓN CLAVE: Usar ID del distrito en lugar del nombre
                                    districtSelect.value = distritoEncontrado.id;
                                }
                            });
                        }
                    });
                }
            }

            // Modificar funciones para aceptar callbacks
            function cargarProvincias(depId, callback) {
                provinceSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
                provinceSelect.disabled = false;

                const provsFiltradas = provincias.filter(p => p.department_id === depId);
                provsFiltradas.sort((a, b) => a.name.localeCompare(b.name));

                provsFiltradas.forEach(prov => {
                    const option = new Option(prov.name, prov.id);
                    provinceSelect.add(option);
                });

                if (callback) callback();
            }

            function cargarDistritos(provId, callback) {
                districtSelect.innerHTML = '<option value="">Seleccione un distrito</option>';
                districtSelect.disabled = false;

                const distsFiltradas = distritos.filter(d => d.province_id === provId);
                distsFiltradas.sort((a, b) => a.name.localeCompare(b.name));

                distsFiltradas.forEach(dist => {
                    // CORRECCIÓN: Usar ID del distrito como valor
                    const option = new Option(dist.name, dist.id);
                    districtSelect.add(option);
                });

                if (callback) callback();
            }

            // Mantener el resto de los event listeners...
            regionSelect.addEventListener('change', function() {
                if (this.value) {
                    cargarProvincias(this.value);
                    // Actualizar campo oculto
                    const region = departamentos.find(d => d.id === this.value);
                    document.getElementById('region_nombre').value = region ? region.name : '';
                } else {
                    provinceSelect.disabled = true;
                    districtSelect.disabled = true;
                }
            });

            provinceSelect.addEventListener('change', function() {
                if (this.value) {
                    cargarDistritos(this.value);
                    // Actualizar campo oculto
                    const provincia = provincias.find(p => p.id === this.value);
                    document.getElementById('province_nombre').value = provincia ? provincia.name : '';
                } else {
                    districtSelect.disabled = true;
                }
            });

            districtSelect.addEventListener('change', function() {
                if (this.value) {
                    // Actualizar campo oculto
                    const distrito = distritos.find(d => d.id === this.value);
                    document.getElementById('district_nombre').value = distrito ? distrito.name : '';
                }
            });
        });
    </script>
@endsection
