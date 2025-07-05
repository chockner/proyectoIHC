@extends('layouts.dashboard')

@section('content')
<div class="bg-[#f8f9fc] min-h-screen">
    <div class="p-6 md:p-10">
        <h1 class="text-[#0d131b] text-2xl md:text-3xl font-bold leading-tight mb-6">Mi Perfil</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Información Personal -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-[#0d131b] text-xl font-semibold leading-tight mb-6">Información Personal</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="document_id">DNI</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        class="w-full rounded-lg border-[#cfd8e7] bg-[#f0f3f7] h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb] disabled:bg-gray-100 disabled:text-gray-500"
                                        name="document_id" 
                                        id="document_id" 
                                        maxlength="8" 
                                        value="{{ old('document_id', Auth::user()->document_id ?? '') }}"
                                        required 
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                                        title="Ingrese exactamente 8 dígitos numéricos"
                                        disabled
                                    />
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-[#6b7f9e] w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M128,56A48,48,0,1,0,176,104,48.05,48.05,0,0,0,128,56Zm0,80A32,32,0,1,1,160,104,32,32,0,0,1,128,136Zm80,104a8,8,0,0,1-8,8H56a8,8,0,0,1,0-16c20.65-16.71,52.38-28,72-28s51.35,11.29,72,28A8,8,0,0,1,208,240Zm-16-56a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16H184A8,8,0,0,1,192,184Z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="first_name">Nombre</label>
                                <input 
                                    type="text"
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="first_name"
                                    id="first_name"
                                    placeholder="Ingrese su nombre"
                                    value="{{ old('first_name', Auth::user()->profile->first_name ?? '') }}"
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="last_name">Apellidos</label>
                                <input 
                                    type="text"
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="last_name"
                                    id="last_name"
                                    placeholder="Ingrese sus apellidos"
                                    value="{{ old('last_name', Auth::user()->profile->last_name ?? '') }}"
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="birthdate">Fecha de Nacimiento</label>
                                <input 
                                    type="date"
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="birthdate"
                                    id="birthdate"
                                    value="{{ old('birthdate', isset(Auth::user()->profile->birthdate) ? Auth::user()->profile->birthdate->format('Y-m-d') : '') }}"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="gender">Género</label>
                                <select 
                                    name="gender" 
                                    id="gender"
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 bg-[image:url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(76,106,154)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e')] placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    required
                                >
                                    <option value="">Seleccione Género</option>
                                    <option value="0" {{ isset(Auth::user()->profile->gender) && Auth::user()->profile->gender == '0' ? 'selected' : '' }}>Masculino</option>
                                    <option value="1" {{ isset(Auth::user()->profile->gender) && Auth::user()->profile->gender == '1' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="civil_status">Estado Civil</label>
                                <select 
                                    name="civil_status" 
                                    id="civil_status"
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 bg-[image:url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(76,106,154)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e')] placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    required
                                >
                                    <option value="">Seleccione Estado Civil</option>
                                    <option value="0" {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '0' ? 'selected' : '' }}>Soltero(a)</option>
                                    <option value="1" {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '1' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="2" {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '2' ? 'selected' : '' }}>Viudo(a)</option>
                                    <option value="3" {{ isset(Auth::user()->profile->civil_status) && Auth::user()->profile->civil_status == '3' ? 'selected' : '' }}>Divorciado(a)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-[#0d131b] text-xl font-semibold leading-tight mb-6">Información de Contacto</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="phone">Teléfono</label>
                                <input 
                                    type="text" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="phone" 
                                    id="phone" 
                                    maxlength="9" 
                                    placeholder="Ingrese su número de teléfono"
                                    value="{{ old('phone', Auth::user()->profile->phone ?? '') }}" 
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
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="email">Correo Electrónico</label>
                                <input 
                                    type="email" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="email" 
                                    id="email"
                                    placeholder="Ingrese su correo electrónico"
                                    value="{{ old('email', Auth::user()->profile->email ?? '') }}" 
                                    required
                                />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="address">Dirección</label>
                                <input 
                                    type="text" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    name="address" 
                                    id="address"
                                    placeholder="Ingrese su dirección"
                                    value="{{ old('address', Auth::user()->profile->address ?? '') }}" 
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="country">País</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        class="w-full rounded-lg border-[#cfd8e7] bg-[#f0f3f7] h-11 placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb] disabled:bg-gray-100 disabled:text-gray-500"
                                        id="country" 
                                        value="Perú" 
                                        disabled
                                    />
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 text-[#6b7f9e] w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M128,56A48,48,0,1,0,176,104,48.05,48.05,0,0,0,128,56Zm0,80A32,32,0,1,1,160,104,32,32,0,0,1,128,136Zm80,104a8,8,0,0,1-8,8H56a8,8,0,0,1,0-16c20.65-16.71,52.38-28,72-28s51.35,11.29,72,28A8,8,0,0,1,208,240Zm-16-56a8,8,0,0,1-8,8H80a8,8,0,0,1,0-16H184A8,8,0,0,1,192,184Z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="region">Región</label>
                                <select 
                                    id="region" 
                                    name="region" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 bg-[image:url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(76,106,154)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e')] placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    required
                                >
                                    <option value="">Seleccione Región</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="province">Provincia</label>
                                <select 
                                    id="province" 
                                    name="province" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 bg-[image:url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(76,106,154)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e')] placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    required 
                                    disabled
                                >
                                    <option value="">Seleccione Provincia</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[#4c6a9a] pb-1.5" for="district">Distrito</label>
                                <select 
                                    id="district" 
                                    name="district" 
                                    class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 bg-[image:url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(76,106,154)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e')] placeholder:text-[#6b7f9e] px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]"
                                    required 
                                    disabled
                                >
                                    <option value="">Seleccione Distrito</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Campos ocultos para almacenar los nombres -->
                        <input type="hidden" name="region_nombre" id="region_nombre">
                        <input type="hidden" name="province_nombre" id="province_nombre">
                        <input type="hidden" name="district_nombre" id="district_nombre">
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <!-- Foto de Perfil -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h2 class="text-[#0d131b] text-xl font-semibold leading-tight mb-4">Foto de Perfil</h2>
                        <div class="flex flex-col items-center">
                            <div class="w-40 h-40 rounded-full bg-center bg-no-repeat bg-cover mb-4 border-2 border-gray-200 overflow-hidden">
                                @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile->profile_picture) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 256 256">
                                            <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <label class="cursor-pointer inline-flex items-center justify-center rounded-lg h-10 px-4 bg-[#eef4ff] text-[#1366eb] text-sm font-medium hover:bg-[#dbe8ff] transition-colors" for="profile_picture">
                                <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M208,56H180.28L166.65,35.56A8,8,0,0,0,160,32H96a8,8,0,0,0-6.65,3.56L75.71,56H48A24,24,0,0,0,24,80V208a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V80A24,24,0,0,0,208,56ZM128,168a32,32,0,1,1,32-32A32,32,0,0,1,128,168Z"></path>
                                </svg>
                                Subir Foto
                            </label>
                            <input accept="image/*" class="hidden" id="profile_picture" name="profile_picture" type="file" />
                            <p class="text-xs text-[#6b7f9e] mt-2">Tamaño máximo: 5MB. JPG, PNG, GIF.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-start gap-3">
                <button type="submit" class="flex items-center justify-center rounded-lg h-11 px-6 bg-[#1366eb] text-white text-sm font-medium hover:bg-[#0f52c6] focus:outline-none focus:ring-2 focus:ring-[#1366eb] focus:ring-offset-2 transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center rounded-lg h-11 px-6 bg-[#e7ecf3] text-[#0d131b] text-sm font-medium hover:bg-[#d8dfea] focus:outline-none focus:ring-2 focus:ring-[#cfd8e7] focus:ring-offset-2 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de ubicación de Perú
    const departamentos = [
        {"id":"01","name":"Amazonas"}, {"id":"02","name":"Áncash"}, {"id":"03","name":"Apurímac"}, 
        {"id":"04","name":"Arequipa"}, {"id":"05","name":"Ayacucho"}, {"id":"06","name":"Cajamarca"}, 
        {"id":"07","name":"Callao"}, {"id":"08","name":"Cusco"}, {"id":"09","name":"Huancavelica"}, 
        {"id":"10","name":"Huánuco"}, {"id":"11","name":"Ica"}, {"id":"12","name":"Junín"}, 
        {"id":"13","name":"La Libertad"}, {"id":"14","name":"Lambayeque"}, {"id":"15","name":"Lima"}, 
        {"id":"16","name":"Loreto"}, {"id":"17","name":"Madre de Dios"}, {"id":"18","name":"Moquegua"}, 
        {"id":"19","name":"Pasco"}, {"id":"20","name":"Piura"}, {"id":"21","name":"Puno"}, 
        {"id":"22","name":"San Martín"}, {"id":"23","name":"Tacna"}, {"id":"24","name":"Tumbes"}, 
        {"id":"25","name":"Ucayali"}
    ];

    const provincias = {
        "01": [{"id":"0101","name":"Chachapoyas"}, {"id":"0102","name":"Bagua"}, {"id":"0103","name":"Bongará"}, {"id":"0104","name":"Condorcanqui"}, {"id":"0105","name":"Luya"}, {"id":"0106","name":"Rodríguez de Mendoza"}, {"id":"0107","name":"Utcubamba"}],
        "02": [{"id":"0201","name":"Huaraz"}, {"id":"0202","name":"Aija"}, {"id":"0203","name":"Antonio Raymondi"}, {"id":"0204","name":"Asunción"}, {"id":"0205","name":"Bolognesi"}, {"id":"0206","name":"Carhuaz"}, {"id":"0207","name":"Carlos Fermín Fitzcarrald"}, {"id":"0208","name":"Casma"}, {"id":"0209","name":"Corongo"}, {"id":"0210","name":"Huari"}, {"id":"0211","name":"Huarmey"}, {"id":"0212","name":"Huaylas"}, {"id":"0213","name":"Mariscal Luzuriaga"}, {"id":"0214","name":"Ocros"}, {"id":"0215","name":"Pallasca"}, {"id":"0216","name":"Pomabamba"}, {"id":"0217","name":"Recuay"}, {"id":"0218","name":"Santa"}, {"id":"0219","name":"Sihuas"}, {"id":"0220","name":"Yungay"}],
        "15": [{"id":"1501","name":"Lima"}, {"id":"1502","name":"Barranca"}, {"id":"1503","name":"Cajatambo"}, {"id":"1504","name":"Canta"}, {"id":"1505","name":"Cañete"}, {"id":"1506","name":"Huaral"}, {"id":"1507","name":"Huarochirí"}, {"id":"1508","name":"Huaura"}, {"id":"1509","name":"Oyón"}, {"id":"1510","name":"Yauyos"}]
    };

    const distritos = {
        "1501": [{"id":"150101","name":"Lima"}, {"id":"150102","name":"Ancón"}, {"id":"150103","name":"Ate"}, {"id":"150104","name":"Barranco"}, {"id":"150105","name":"Breña"}, {"id":"150106","name":"Carabayllo"}, {"id":"150107","name":"Chaclacayo"}, {"id":"150108","name":"Chorrillos"}, {"id":"150109","name":"Cieneguilla"}, {"id":"150110","name":"Comas"}, {"id":"150111","name":"El Agustino"}, {"id":"150112","name":"Independencia"}, {"id":"150113","name":"Jesús María"}, {"id":"150114","name":"La Molina"}, {"id":"150115","name":"La Victoria"}, {"id":"150116","name":"Lince"}, {"id":"150117","name":"Los Olivos"}, {"id":"150118","name":"Lurigancho"}, {"id":"150119","name":"Lurín"}, {"id":"150120","name":"Magdalena del Mar"}, {"id":"150121","name":"Pueblo Libre"}, {"id":"150122","name":"Miraflores"}, {"id":"150123","name":"Pachacámac"}, {"id":"150124","name":"Pucusana"}, {"id":"150125","name":"Puente Piedra"}, {"id":"150126","name":"Punta Hermosa"}, {"id":"150127","name":"Punta Negra"}, {"id":"150128","name":"Rímac"}, {"id":"150129","name":"San Bartolo"}, {"id":"150130","name":"San Borja"}, {"id":"150131","name":"San Isidro"}, {"id":"150132","name":"San Juan de Lurigancho"}, {"id":"150133","name":"San Juan de Miraflores"}, {"id":"150134","name":"San Luis"}, {"id":"150135","name":"San Martín de Porres"}, {"id":"150136","name":"San Miguel"}, {"id":"150137","name":"Santa Anita"}, {"id":"150138","name":"Santa María del Mar"}, {"id":"150139","name":"Santa Rosa"}, {"id":"150140","name":"Santiago de Surco"}, {"id":"150141","name":"Surquillo"}, {"id":"150142","name":"Villa El Salvador"}, {"id":"150143","name":"Villa María del Triunfo"}]
    };

    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const regionNombre = document.getElementById('region_nombre');
    const provinceNombre = document.getElementById('province_nombre');
    const districtNombre = document.getElementById('district_nombre');

    // Cargar departamentos
    departamentos.forEach(depto => {
        const option = document.createElement('option');
        option.value = depto.id;
        option.textContent = depto.name;
        regionSelect.appendChild(option);
    });

    // Evento cambio de región
    regionSelect.addEventListener('change', function() {
        const selectedRegion = this.value;
        const selectedOption = this.options[this.selectedIndex];
        
        // Limpiar provincias y distritos
        provinceSelect.innerHTML = '<option value="">Seleccione Provincia</option>';
        districtSelect.innerHTML = '<option value="">Seleccione Distrito</option>';
        provinceSelect.disabled = true;
        districtSelect.disabled = true;
        
        // Limpiar nombres
        regionNombre.value = selectedOption.textContent;
        provinceNombre.value = '';
        districtNombre.value = '';
        
        if (selectedRegion && provincias[selectedRegion]) {
            provincias[selectedRegion].forEach(prov => {
                const option = document.createElement('option');
                option.value = prov.id;
                option.textContent = prov.name;
                provinceSelect.appendChild(option);
            });
            provinceSelect.disabled = false;
        }
    });

    // Evento cambio de provincia
    provinceSelect.addEventListener('change', function() {
        const selectedProvince = this.value;
        const selectedOption = this.options[this.selectedIndex];
        
        // Limpiar distritos
        districtSelect.innerHTML = '<option value="">Seleccione Distrito</option>';
        districtSelect.disabled = true;
        
        // Limpiar nombre de distrito
        provinceNombre.value = selectedOption.textContent;
        districtNombre.value = '';
        
        if (selectedProvince && distritos[selectedProvince]) {
            distritos[selectedProvince].forEach(dist => {
                const option = document.createElement('option');
                option.value = dist.id;
                option.textContent = dist.name;
                districtSelect.appendChild(option);
            });
            districtSelect.disabled = false;
        }
    });

    // Evento cambio de distrito
    districtSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        districtNombre.value = selectedOption.textContent;
    });

    // Cargar valores guardados si existen
    @if(Auth::user()->profile && Auth::user()->profile->region)
        regionSelect.value = "{{ Auth::user()->profile->region }}";
        regionSelect.dispatchEvent(new Event('change'));
        
        @if(Auth::user()->profile->province)
            setTimeout(() => {
                provinceSelect.value = "{{ Auth::user()->profile->province }}";
                provinceSelect.dispatchEvent(new Event('change'));
                
                @if(Auth::user()->profile->district)
                    setTimeout(() => {
                        districtSelect.value = "{{ Auth::user()->profile->district }}";
                        districtSelect.dispatchEvent(new Event('change'));
                    }, 100);
                @endif
            }, 100);
        @endif
    @endif

    // Preview de imagen
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = document.querySelector('.w-40.h-40');
                imgContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
