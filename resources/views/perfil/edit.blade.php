@extends('layouts.dashboard')

@section('content')
@php
    $editMode = request('edit') == 1;
    $user = Auth::user();
    $profile = $user->profile;
    
    // Obtener datos específicos por rol
    $patientData = null;
    $doctorData = null;
    $secretaryData = null;
    
    if ($user->role->name == 'paciente') {
        $patientData = $user->patient;
    } elseif ($user->role->name == 'doctor') {
        $doctorData = $user->doctor;
    } elseif ($user->role->name == 'secretaria') {
        $secretaryData = $user->secretary;
    }
@endphp

<div class="max-w-7xl mx-auto mt-8 px-4">
    <!-- Header de la página -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Mi Perfil</h1>
        <p class="text-slate-600">Gestiona tu información personal y profesional</p>
    </div>

    <!-- Foto de perfil y información básica -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- Foto de perfil -->
            <div class="flex flex-col items-center">
                <div class="relative group">
                    <img src="{{ $profile && $profile->photo ? asset('storage/' . $profile->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=0c64f2&background=e6f0ff&size=200' }}" 
                         alt="Foto de perfil de {{ $user->name }}" 
                         class="w-48 h-48 rounded-full object-cover border-4 border-blue-100 shadow-lg cursor-pointer hover:shadow-xl transition-all duration-300"
                         onclick="openImageModal(this.src)"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=0c64f2&background=e6f0ff&size=200'">
                    @if($editMode)
                        <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" class="absolute bottom-2 right-2 z-10">
                            @csrf
                            @method('PUT')
                            <label class="cursor-pointer bg-blue-600 text-white rounded-full p-3 shadow-lg hover:bg-blue-700 transition-all duration-200 hover:scale-110 flex items-center justify-center" style="position: absolute; bottom: 0; right: 0;">
                                <span class="material-icons text-xl">photo_camera</span>
                                <input type="file" name="photo" class="hidden" onchange="this.form.submit()" accept="image/*">
                            </label>
                        </form>
                    @endif
                    <!-- Overlay de hover corregido -->
                    <div class="absolute inset-0 rounded-full transition-all duration-300 flex items-center justify-center pointer-events-none"
                         style="background: rgba(0,0,0,0);"
                         onmouseover="this.style.background='rgba(0,0,0,0.20)'" onmouseout="this.style.background='rgba(0,0,0,0)'">
                        <span class="material-icons text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-2xl">zoom_in</span>
                    </div>
                </div>
                <!-- Información básica debajo de la foto -->
                <div class="text-center mt-4">
                    <h2 class="text-2xl font-bold text-slate-800 mb-1">
                        {{ $profile->first_name ?? $user->name }} {{ $profile->last_name ?? '' }}
                    </h2>
                    <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        <span class="material-icons text-sm">badge</span>
                        {{ ucfirst($user->role->name ?? 'Usuario') }}
                    </div>
                    <div class="text-slate-500 text-sm mt-2">{{ $user->email }}</div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col gap-3 w-full lg:w-auto">
                @if(!$editMode)
                    <button onclick="window.location.href='{{ route('perfil.edit', ['edit' => 1]) }}'" 
                            class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-200 hover:scale-105">
                        <span class="material-icons">edit</span>
                        Editar Perfil
                    </button>
                @else
                    <div class="flex gap-3">
                        <button form="profile-form" type="submit" 
                                class="flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-xl font-semibold shadow-lg hover:bg-green-700 hover:shadow-xl transition-all duration-200 hover:scale-105">
                            <span class="material-icons">save</span>
                            Guardar Cambios
                        </button>
                        <button onclick="window.location.href='{{ route('perfil.edit') }}'" type="button" 
                                class="flex items-center justify-center gap-2 px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold shadow-lg hover:bg-slate-300 hover:shadow-xl transition-all duration-200 hover:scale-105">
                            <span class="material-icons">cancel</span>
                            Cancelar
                        </button>
                    </div>
                @endif
                
                <button onclick="openPasswordModal()" 
                        class="flex items-center justify-center gap-2 px-6 py-3 bg-amber-500 text-white rounded-xl font-semibold shadow-lg hover:bg-amber-600 hover:shadow-xl transition-all duration-200 hover:scale-105">
                    <span class="material-icons">lock</span>
                    Cambiar Contraseña
                </button>
            </div>
        </div>
    </div>

    <!-- Formulario principal -->
    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
        @csrf
        @method('PUT')
        
        <!-- Datos Personales -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-blue-600">person</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Datos Personales</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">DNI</label>
                    @if($editMode)
                        <input type="text" name="document_id" value="{{ old('document_id', $user->document_id ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all bg-gray-100 cursor-not-allowed" 
                               maxlength="8" readonly>
                        <p class="text-xs text-gray-500 mt-1">El DNI no se puede modificar</p>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $user->document_id ?? 'No registrado' }}
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Nombre</label>
                    @if($editMode)
                        <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" 
                               pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                               title="Solo se permiten letras y espacios"
                               oninput="this.value = this.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '')"
                               onblur="validateTextField(this, 'nombre')">
                        <p class="text-xs text-gray-500 mt-1">Solo letras y espacios</p>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $profile->first_name ?? 'No registrado' }}
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Apellidos</label>
                    @if($editMode)
                        <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                               pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                               title="Solo se permiten letras y espacios"
                               oninput="this.value = this.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '')"
                               onblur="validateTextField(this, 'apellidos')">
                        <p class="text-xs text-gray-500 mt-1">Solo letras y espacios</p>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $profile->last_name ?? 'No registrado' }}
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Fecha de Nacimiento</label>
                    @if($editMode)
                        <input type="date" name="birthdate" value="{{ old('birthdate', isset($profile->birthdate) ? $profile->birthdate->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $profile->birthdate ? $profile->birthdate->format('d/m/Y') : 'No registrado' }}
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Género</label>
                    @if($editMode)
                        <select name="gender" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            <option value="">Selecciona...</option>
                            <option value="0" {{ isset($profile->gender) && $profile->gender == '0' ? 'selected' : '' }}>Masculino</option>
                            <option value="1" {{ isset($profile->gender) && $profile->gender == '1' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            @if(isset($profile->gender))
                                {{ $profile->gender == '0' ? 'Masculino' : ($profile->gender == '1' ? 'Femenino' : 'No registrado') }}
                            @else
                                No registrado
                            @endif
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Estado Civil</label>
                    @if($editMode)
                        <select name="civil_status" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                            <option value="">Selecciona...</option>
                            <option value="0" {{ isset($profile->civil_status) && $profile->civil_status == '0' ? 'selected' : '' }}>Soltero(a)</option>
                            <option value="1" {{ isset($profile->civil_status) && $profile->civil_status == '1' ? 'selected' : '' }}>Casado(a)</option>
                            <option value="2" {{ isset($profile->civil_status) && $profile->civil_status == '2' ? 'selected' : '' }}>Viudo(a)</option>
                            <option value="3" {{ isset($profile->civil_status) && $profile->civil_status == '3' ? 'selected' : '' }}>Divorciado(a)</option>
                        </select>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            @php $cs = $profile->civil_status ?? null; @endphp
                            @if($cs === '0') Soltero(a)
                            @elseif($cs === '1') Casado(a)
                            @elseif($cs === '2') Viudo(a)
                            @elseif($cs === '3') Divorciado(a)
                            @else No registrado
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-green-600">contact_phone</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Información de Contacto</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Teléfono</label>
                    @if($editMode)
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                               pattern="9[0-9]{8}"
                               title="Debe ser un número de 9 dígitos que empiece con 9"
                               maxlength="9"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9)"
                               onblur="validatePhoneField(this, 'teléfono')">
                        <p class="text-xs text-gray-500 mt-1">9 dígitos que empiecen con 9 (ej: 912345678)</p>
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $profile->phone ?? 'No registrado' }}
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block text-base font-semibold text-slate-700 mb-2">Dirección</label>
                    @if($editMode)
                        <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                    @else
                        <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                            {{ $profile->address ?? 'No registrado' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información Específica por Rol -->
        @if($user->role->name == 'paciente' && ($patientData || $editMode))
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-red-600">medical_information</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Información Médica</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-base font-semibold text-slate-700 mb-2">Contacto de Emergencia</label>
                        @if($editMode)
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $patientData->emergency_contact ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                   pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                                   title="Solo se permiten letras y espacios"
                                   oninput="this.value = this.value.replace(/[^A-Za-zÁáÉéÍíÓóÚúÑñ\s]/g, '')"
                                   onblur="validateTextField(this, 'contacto de emergencia')">
                            <p class="text-xs text-gray-500 mt-1">Solo letras y espacios</p>
                        @else
                            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                                {{ $patientData->emergency_contact ?? 'No registrado' }}
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-base font-semibold text-slate-700 mb-2">Teléfono de Emergencia</label>
                        @if($editMode)
                            <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $patientData->emergency_phone ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                   pattern="9[0-9]{8}"
                                   title="Debe ser un número de 9 dígitos que empiece con 9"
                                   maxlength="9"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9)"
                                   onblur="validatePhoneField(this, 'teléfono de emergencia')">
                            <p class="text-xs text-gray-500 mt-1">9 dígitos que empiecen con 9 (ej: 912345678)</p>
                        @else
                            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                                {{ $patientData->emergency_phone ?? 'No registrado' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($user->role->name == 'doctor' && ($doctorData || $editMode))
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <span class="material-icons text-purple-600">medical_services</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Información Profesional</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-base font-semibold text-slate-700 mb-2">Código de Licencia</label>
                        @if($editMode)
                            <input type="text" name="license_code" value="{{ old('license_code', $doctorData->license_code ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        @else
                            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                                {{ $doctorData->license_code ?? 'No registrado' }}
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-base font-semibold text-slate-700 mb-2">Años de Experiencia</label>
                        @if($editMode)
                            <input type="number" name="experience_years" value="{{ old('experience_years', $doctorData->experience_years ?? '') }}" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">
                        @else
                            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                                {{ $doctorData->experience_years ?? '0' }} años
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-base font-semibold text-slate-700 mb-2">Biografía Profesional</label>
                        @if($editMode)
                            <textarea name="professional_bio" rows="4" 
                                      class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all">{{ old('professional_bio', $doctorData->professional_bio ?? '') }}</textarea>
                        @else
                            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-base text-slate-700">
                                {{ $doctorData->professional_bio ?? 'No registrado' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </form>

    <!-- Mensaje motivador si el perfil está incompleto -->
    @if(!$editMode && (empty($profile->first_name) || empty($profile->last_name) || empty($profile->phone)))
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-8 text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-icons text-blue-600 text-2xl">person_add</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">¡Completa tu perfil!</h3>
            <p class="text-slate-600 mb-4">Agrega tu información personal para mejorar tu experiencia en el sistema y facilitar la atención médica.</p>
            <button onclick="window.location.href='{{ route('perfil.edit', ['edit' => 1]) }}'" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-200">
                <span class="material-icons">edit</span>
                Completar Perfil
            </button>
        </div>
    @endif
</div>

<!-- Modal para ampliar imagen -->
<div id="imageModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4" id="imageModalBackdrop">
        <div class="relative max-w-4xl max-h-full transform transition-all duration-300 scale-95 opacity-0" id="imageModalContent">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2">
                <span class="material-icons text-3xl">close</span>
            </button>
            <img id="modalImage" src="" alt="Imagen ampliada" class="max-w-full max-h-full rounded-lg shadow-2xl">
        </div>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div id="passwordModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4" id="passwordModalBackdrop">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md relative transform transition-all duration-300 scale-95 opacity-0" id="passwordModalContent">
            <button onclick="closePasswordModal()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors">
                <span class="material-icons text-2xl">close</span>
            </button>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <span class="material-icons text-amber-600">lock</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Cambiar Contraseña</h3>
            </div>
            <form action="{{ route('quick.reset') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-base font-semibold text-slate-700 mb-2">Nueva contraseña</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" required>
                </div>
                <div class="mb-6">
                    <label class="block text-base font-semibold text-slate-700 mb-2">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all" required>
                </div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-amber-500 text-white rounded-xl font-semibold shadow-lg hover:bg-amber-600 hover:shadow-xl transition-all duration-200">
                    <span class="material-icons">save</span>
                    Guardar Contraseña
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Estilos para los modales */
.modal-open {
    overflow: hidden;
}

/* Efecto de backdrop blur mejorado */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

/* Animaciones para los modales */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-fade-in {
    animation: fadeIn 0.3s ease-out;
}

.modal-slide-in {
    animation: slideIn 0.3s ease-out;
}

/* Hover effects para botones */
button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}

/* Estilos específicos para los modales */
#imageModal, #passwordModal {
    background: transparent !important;
    position: fixed;
    inset: 0;
    z-index: 50;
}

#imageModal::before, #passwordModal::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.13);
    pointer-events: none;
    z-index: 1;
    border-radius: 0;
}

#imageModalContent, #passwordModalContent {
    position: relative;
    z-index: 2;
    background: #fff;
}

/* Animación shake para campos con error */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

/* Estilos para campos con error */
input.border-red-500 {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

input.border-red-500:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
}

/* Estilos para campos deshabilitados */
input:disabled {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
    cursor: not-allowed !important;
}

/* Estilos para mensajes de error */
.text-red-500.text-xs {
    font-size: 0.75rem;
    line-height: 1rem;
}

/* Estilos para mensajes de ayuda */
.text-gray-500.text-xs {
    font-size: 0.75rem;
    line-height: 1rem;
}
</style>

<script>
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('imageModalContent');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
        
        // Animar entrada del modal
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Enfocar el botón de cerrar para accesibilidad
        setTimeout(() => {
            modal.querySelector('button[onclick="closeImageModal()"]').focus();
        }, 300);
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('imageModalContent');
        
        // Animar salida del modal
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        }, 300);
    }
    
    function openPasswordModal() {
        const modal = document.getElementById('passwordModal');
        const modalContent = document.getElementById('passwordModalContent');
        
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
        
        // Animar entrada del modal
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Enfocar el primer input para accesibilidad
        setTimeout(() => {
            modal.querySelector('input[type="password"]').focus();
        }, 300);
    }
    
    function closePasswordModal() {
        const modal = document.getElementById('passwordModal');
        const modalContent = document.getElementById('passwordModalContent');
        
        // Animar salida del modal
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        }, 300);
    }
    
    // Cerrar modales con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
            closePasswordModal();
        }
    });
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('imageModalBackdrop').addEventListener('click', function(e) {
        if (event.target === this) {
            closeImageModal();
        }
    });
    
    document.getElementById('passwordModalBackdrop').addEventListener('click', function(e) {
        if (event.target === this) {
            closePasswordModal();
        }
    });

    // Cerrar modal de cancelación al hacer clic fuera
    document.getElementById('cancelModalBackdrop').addEventListener('click', function(event) {
        // Si el clic es directamente en el fondo (no en el contenido)
        if (event.target === this) {
            closeCancelModal();
        }
    });

    // Manejar el envío del formulario de cancelación
    document.getElementById('cancelForm').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        
        // Deshabilitar botón y mostrar estado de carga
        submitButton.disabled = true;
        submitButton.textContent = 'Cancelando...';
        submitButton.classList.add('opacity-75', 'cursor-not-allowed');
        
        // Permitir que el formulario se envíe normalmente
        // El botón se habilitará automáticamente si hay un error
        setTimeout(() => {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
            submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
        }, 5000); // Timeout de seguridad
    });

    // Funciones de validación para campos de texto (solo letras)
    function validateTextField(input, fieldName) {
        const value = input.value.trim();
        const lettersOnly = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;
        
        if (value && !lettersOnly.test(value)) {
            showFieldError(input, `El campo ${fieldName} solo puede contener letras y espacios`);
            return false;
        } else {
            clearFieldError(input);
            return true;
        }
    }

    // Funciones de validación para campos de teléfono
    function validatePhoneField(input, fieldName) {
        const value = input.value.trim();
        const phonePattern = /^9[0-9]{8}$/;
        
        if (value && !phonePattern.test(value)) {
            showFieldError(input, `El ${fieldName} debe tener 9 dígitos y empezar con 9`);
            return false;
        } else {
            clearFieldError(input);
            return true;
        }
    }

    // Mostrar error en campo
    function showFieldError(input, message) {
        // Remover mensaje de error anterior si existe
        clearFieldError(input);
        
        // Agregar clase de error al input
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
        
        // Crear y mostrar mensaje de error
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-xs mt-1 flex items-center';
        errorDiv.innerHTML = `
            <span class="material-icons text-sm mr-1">error</span>
            ${message}
        `;
        errorDiv.id = 'error-' + input.name;
        
        // Insertar después del input
        input.parentNode.appendChild(errorDiv);
        
        // Agregar shake animation
        input.classList.add('animate-shake');
        setTimeout(() => {
            input.classList.remove('animate-shake');
        }, 500);
    }

    // Limpiar error de campo
    function clearFieldError(input) {
        input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
        
        const errorDiv = document.getElementById('error-' + input.name);
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
        
        // Estilos según el tipo
        const styles = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            info: 'bg-blue-500 text-white',
            warning: 'bg-yellow-500 text-white'
        };
        
        notification.className += ` ${styles[type] || styles.info}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="material-icons mr-2">${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'info'}</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remover después de 5 segundos
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // Validar formulario antes de enviar
    document.getElementById('profile-form').addEventListener('submit', function(e) {
        let isValid = true;
        let errorMessages = [];
        
        // Validar campos de texto
        const textFields = this.querySelectorAll('input[pattern*="[A-Za-z"]');
        textFields.forEach(field => {
            if (field.value.trim() && !validateTextField(field, field.getAttribute('title') || 'campo')) {
                isValid = false;
                errorMessages.push(`Campo ${field.getAttribute('title') || 'texto'}: solo letras y espacios`);
            }
        });
        
        // Validar campos de teléfono (hacer opcional)
        const phoneFields = this.querySelectorAll('input[pattern*="9[0-9]"]');
        phoneFields.forEach(field => {
            if (field.value.trim() && !validatePhoneField(field, field.getAttribute('title') || 'teléfono')) {
                // Mostrar advertencia pero no bloquear
                showNotification(`Advertencia: ${field.getAttribute('title') || 'teléfono'} debe tener 9 dígitos empezando con 9`, 'warning');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Por favor, corrige los errores en el formulario: ' + errorMessages.join(', '), 'error');
        } else {
            // Permitir envío del formulario
            showNotification('Enviando formulario...', 'info');
        }
    });
</script>
@endsection
