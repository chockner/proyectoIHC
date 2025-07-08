@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Detalles de la Cita</h1>
        <div class="flex space-x-2">
            <a href="{{ route('paciente.citas.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                <span class="material-icons mr-2">arrow_back</span>
                Volver
            </a>
            @if($cita->status === 'programada')
                <a href="{{ route('paciente.citas.edit', $cita->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    <span class="material-icons mr-2">schedule</span>
                    Reprogramar
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Información principal de la cita -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Información de la Cita</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Estado de la Cita</h3>
                    <div class="mb-4">
                        @switch($cita->status)
                            @case('programada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <span class="material-icons mr-1 text-sm">schedule</span>
                                    Programada
                                </span>
                                @break
                            @case('completada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="material-icons mr-1 text-sm">check_circle</span>
                                    Completada
                                </span>
                                @break
                            @case('cancelada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <span class="material-icons mr-1 text-sm">cancel</span>
                                    Cancelada
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($cita->status) }}
                                </span>
                        @endswitch
                    </div>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha y Hora</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">
                        {{ ucfirst(\Carbon\Carbon::parse($cita->appointment_date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}
                        <br>
                        <span class="text-blue-600">{{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}</span>
                    </p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Especialidad</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">{{ $cita->doctor->specialty->name }}</p>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Consultorio</h3>
                    <p class="text-lg font-medium text-gray-900">Consultorio {{ $cita->doctor->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del médico -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Información del Médico</h2>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4">
                @if($cita->doctor->user->profile && $cita->doctor->user->profile->profile_photo)
                    <img class="h-20 w-20 rounded-full object-cover" 
                         src="{{ asset('storage/' . $cita->doctor->user->profile->profile_photo) }}" 
                         alt="Foto del médico">
                @else
                    <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="material-icons text-gray-400 text-3xl">person</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Dr. {{ $cita->doctor->user->profile->first_name ?? 'Médico' }} {{ $cita->doctor->user->profile->last_name ?? '' }}
                    </h3>
                    <p class="text-gray-600 mb-2">{{ $cita->doctor->specialty->name }}</p>
                    <p class="text-sm text-gray-500 mb-2">Licencia: {{ $cita->doctor->license_code }}</p>
                    <p class="text-sm text-gray-500">{{ $cita->doctor->experience_years }} años de experiencia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del pago -->
    @if($cita->payment)
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Información del Pago</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Estado del Pago</h3>
                    <div class="mb-4">
                        @switch($cita->payment->status)
                            @case('validado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="material-icons mr-1 text-sm">check_circle</span>
                                    Pagado
                                </span>
                                @break
                            @case('pendiente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <span class="material-icons mr-1 text-sm">schedule</span>
                                    Pendiente de Validación
                                </span>
                                @break
                            @case('rechazado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <span class="material-icons mr-1 text-sm">error</span>
                                    Rechazado
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst($cita->payment->status) }}
                                </span>
                        @endswitch
                    </div>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Método de Pago</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">
                        @switch($cita->payment->payment_method)
                            @case('online')
                                Pago en Línea
                                @break
                            @case('transfer')
                                Transferencia / Yape / Plin
                                @break
                            @case('clinic')
                                Pago en Clínica
                                @break
                            @default
                                {{ ucfirst($cita->payment->payment_method) }}
                        @endswitch
                    </p>
                    
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Monto</h3>
                    <p class="text-2xl font-bold text-gray-900">S/ {{ number_format($cita->payment->amount, 2) }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Pago</h3>
                    <p class="text-lg font-medium text-gray-900 mb-4">
                        {{ $cita->payment->uploaded_at ? \Carbon\Carbon::parse($cita->payment->uploaded_at)->format('d/m/Y H:i') : 'No registrada' }}
                    </p>
                    
                    @if($cita->payment->validated_at)
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Fecha de Validación</h3>
                        <p class="text-lg font-medium text-gray-900 mb-4">
                            {{ \Carbon\Carbon::parse($cita->payment->validated_at)->format('d/m/Y H:i') }}
                        </p>
                    @endif
                    
                    @if($cita->payment->image_path)
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Comprobante de Pago</h3>
                        <div class="space-y-3">
                            <!-- Vista previa del comprobante -->
                            <div class="relative group">
                                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors duration-200 cursor-pointer"
                                     onclick="openComprobanteModal('{{ asset('storage/' . $cita->payment->image_path) }}', '{{ $cita->payment->payment_method }}')"
                                     role="button"
                                     tabindex="0"
                                     onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openComprobanteModal('{{ asset('storage/' . $cita->payment->image_path) }}', '{{ $cita->payment->payment_method }}'); }"
                                     aria-label="Hacer clic para ver el comprobante de pago en pantalla completa">
                                    <div class="flex items-center justify-center">
                                        @php
                                            $fileExtension = pathinfo($cita->payment->image_path, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp
                                        
                                        @if($isImage)
                                            <div style="background: #fff; border-radius: 1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center; height: 14rem; width: 100%; max-width: 350px; margin: 0 auto; border: 1px solid #e5e7eb; position: relative;">
                                                <img src="{{ asset('storage/' . $cita->payment->image_path) }}"
                                                     alt="Vista previa del comprobante"
                                                     class="max-w-full max-h-full object-contain rounded-lg"
                                                     style="background-color: #fff; display: block; margin: 0 auto; z-index: 1; position: relative;"
                                                     onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'text-center text-red-500 text-sm\'>No se pudo cargar la imagen</div>';">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <span class="material-icons text-4xl text-gray-400 mb-2">picture_as_pdf</span>
                                                <p class="text-sm text-gray-600">Comprobante PDF</p>
                                                <p class="text-xs text-gray-500">{{ strtoupper($fileExtension) }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Overlay con información -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-200 rounded-lg flex items-center justify-center">
                                        <div class="bg-white bg-opacity-90 px-3 py-1 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <span class="text-sm font-medium text-gray-700">Hacer clic para ampliar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="flex flex-wrap gap-2">
                                <button onclick="openComprobanteModal('{{ asset('storage/' . $cita->payment->image_path) }}', '{{ $cita->payment->payment_method }}')"
                                        class="inline-flex items-center px-3 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                    <span class="material-icons mr-2 text-sm">zoom_in</span>
                                    Ampliar
                                </button>
                                
                                <a href="{{ asset('storage/' . $cita->payment->image_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                                    <span class="material-icons mr-2 text-sm">open_in_new</span>
                                    Abrir en nueva pestaña
                                </a>
                                
                                <a href="{{ route('paciente.citas.downloadComprobante', $cita->id) }}"
                                   class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                    <span class="material-icons mr-2 text-sm">download</span>
                                    Descargar
                                </a>
                            </div>
                            
                            <!-- Información adicional -->
                            <div class="text-xs text-gray-500">
                                <p>• Haga clic en "Ampliar" para ver el comprobante en pantalla completa</p>
                                <p>• Use "Abrir en nueva pestaña" para ver en el navegador</p>
                                <p>• "Descargar" guardará el archivo en su dispositivo</p>
                                <p>• También puede hacer clic directamente en la imagen para ampliarla</p>
                            </div>
                            
                            <!-- Información de seguridad -->
                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <span class="material-icons text-blue-600 mr-2 text-sm mt-0.5">security</span>
                                    <div class="text-xs text-blue-700">
                                        <p class="font-medium">Información de seguridad:</p>
                                        <p>• Este comprobante es privado y solo visible para usted</p>
                                        <p>• Se recomienda guardar una copia para sus registros</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Acciones -->
    @if($cita->status === 'programada')
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Gestionar Cita</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <button type="button" 
                        onclick="openCancelModal()"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                    <span class="material-icons mr-2">cancel</span>
                    Cancelar Cita
                </button>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start">
                    <span class="material-icons text-blue-600 mr-3 mt-1">info</span>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Información importante:</h4>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• Llegue 15 minutos antes de su cita</li>
                            <li>• Traiga su documento de identidad</li>
                            <li>• Si no puede asistir, cancele con anticipación</li>
                            <li>• El estado de su cita será actualizado por el personal médico</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal para ver comprobante -->
<div id="comprobanteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header del modal -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <span class="material-icons text-blue-600 mr-2">receipt</span>
                    <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Comprobante de Pago</h3>
                </div>
                <button onclick="closeComprobanteModal()" 
                        class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 rounded-full p-1">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <!-- Contenido del modal -->
            <div class="p-4 overflow-auto max-h-[calc(90vh-120px)]">
                <div class="text-center">
                    <div id="modalContent" class="flex justify-center">
                        <!-- El contenido se cargará dinámicamente -->
                    </div>
                    <div id="modalLoading" class="hidden">
                        <div class="flex items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <span class="ml-3 text-gray-600">Cargando comprobante...</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer del modal -->
            <div class="flex items-center justify-between p-4 border-t border-gray-200 bg-gray-50">
                <div class="text-sm text-gray-600">
                    <span id="modalInfo">Comprobante de pago de la cita</span>
                </div>
                <div class="flex space-x-2">
                    <button onclick="downloadFromModal()" 
                            class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                        <span class="material-icons mr-2 text-sm">download</span>
                        Descargar
                    </button>
                    <button onclick="closeComprobanteModal()" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de cancelación -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4" id="cancelModalBackdrop">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="cancelModalContent" tabindex="-1">
            <!-- Contenido del modal -->
            <div class="p-8 text-center">
                <!-- Icono simple -->
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-red-50 flex items-center justify-center">
                    <span class="material-icons text-red-500 text-3xl">cancel</span>
                </div>
                <!-- Título -->
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cancelar Cita</h3>
                <!-- Información de la cita -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-medium">{{ ucfirst(\Carbon\Carbon::parse($cita->appointment_date)->locale('es')->isoFormat('dddd, D [de] MMMM')) }}</span>
                    </p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Dr. {{ $cita->doctor->user->profile->first_name ?? 'Médico' }} {{ $cita->doctor->user->profile->last_name ?? '' }}
                    </p>
                </div>
                <!-- Mensaje de confirmación -->
                <p class="text-sm text-gray-600 mb-6">
                    ¿Está seguro de que desea cancelar esta cita? Esta acción no se puede deshacer.
                </p>
                <!-- Bloque de advertencia -->
                <div class="flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 mb-4 mx-auto text-xs text-blue-700 max-w-xs">
                    <span class="material-icons text-blue-400 text-base">info</span>
                    <span><strong>Importante:</strong> Si ya realizó un pago, deberá contactar con la clínica para solicitar un reembolso.</span>
                </div>
            </div>
            <!-- Botones -->
            <div class="flex gap-3 p-6 pt-0">
                <button onclick="closeCancelModal()" 
                        class="flex-1 px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                    Mantener
                </button>
                <form action="{{ route('paciente.citas.cancel', $cita->id) }}" method="POST" id="cancelForm" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full px-4 py-3 text-sm font-medium text-white bg-red-500 rounded-xl hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.material-icons {
    font-family: 'Material Icons';
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    display: inline-block;
    line-height: 1;
    text-transform: none;
    letter-spacing: normal;
    word-wrap: normal;
    white-space: nowrap;
    direction: ltr;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    -moz-osx-font-smoothing: grayscale;
    font-feature-settings: 'liga';
}

/* Estilos para el modal */
.modal-open {
    overflow: hidden;
}

/* Animaciones para el modal */
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

/* Eliminar overlay negro en hover */
.relative.group .absolute.inset-0 {
    background: transparent !important;
}

/* Estilos para el modal minimalista */
#cancelModalContent {
    position: relative;
    z-index: 2;
    background: #fff;
}

/* Efecto de backdrop blur mejorado */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

/* Hover effects para botones */
button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}

#cancelModal {
    background: transparent !important;
    position: fixed;
    inset: 0;
    z-index: 50;
}
#cancelModal::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.13);
    pointer-events: none;
    z-index: 1;
    border-radius: 0;
}
</style>

@push('scripts')
<script>
// Variables globales para el modal
let currentComprobanteUrl = '';
let currentFileName = '';

// Función para abrir el modal del comprobante
function openComprobanteModal(url, paymentMethod) {
    currentComprobanteUrl = url;
    currentFileName = 'comprobante_cita_' + new Date().getTime();
    
    const modal = document.getElementById('comprobanteModal');
    const modalContent = document.getElementById('modalContent');
    const modalLoading = document.getElementById('modalLoading');
    const modalTitle = document.getElementById('modalTitle');
    const modalInfo = document.getElementById('modalInfo');
    
    // Determinar el tipo de archivo
    const fileExtension = url.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
    
    // Actualizar título e información
    modalTitle.textContent = 'Comprobante de Pago';
    modalInfo.textContent = `Método: ${getPaymentMethodName(paymentMethod)} | Formato: ${fileExtension.toUpperCase()}`;
    
    // Mostrar modal con animación
    modal.classList.remove('hidden');
    modal.classList.add('modal-fade-in');
    document.body.classList.add('modal-open');
    
    // Mostrar indicador de carga
    modalContent.classList.add('hidden');
    modalLoading.classList.remove('hidden');
    
    // Cargar contenido según el tipo de archivo
    if (isImage) {
        const img = new Image();
        img.onload = function() {
            modalLoading.classList.add('hidden');
            modalContent.classList.remove('hidden');
            modalContent.innerHTML = `
                <img src="${url}" 
                     alt="Comprobante de pago" 
                     class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg"
                     style="opacity: 0; transition: opacity 0.3s ease;">
            `;
            // Animar la aparición de la imagen
            setTimeout(() => {
                const imgElement = modalContent.querySelector('img');
                if (imgElement) imgElement.style.opacity = '1';
            }, 100);
        };
        img.onerror = function() {
            modalLoading.classList.add('hidden');
            modalContent.classList.remove('hidden');
            modalContent.innerHTML = `
                <div class="w-full max-w-2xl">
                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-8 text-center">
                        <span class="material-icons text-6xl text-red-400 mb-4">error</span>
                        <h4 class="text-lg font-medium text-red-700 mb-2">Error al cargar</h4>
                        <p class="text-sm text-red-600 mb-4">No se pudo cargar el comprobante</p>
                        <button onclick="closeComprobanteModal()" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-150">
                            Cerrar
                        </button>
                    </div>
                </div>
            `;
        };
        img.src = url;
    } else {
        // Para PDFs y otros archivos
        setTimeout(() => {
            modalLoading.classList.add('hidden');
            modalContent.classList.remove('hidden');
            modalContent.innerHTML = `
                <div class="w-full max-w-2xl">
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <span class="material-icons text-6xl text-gray-400 mb-4">picture_as_pdf</span>
                        <h4 class="text-lg font-medium text-gray-700 mb-2">Comprobante PDF</h4>
                        <p class="text-sm text-gray-500 mb-4">Este archivo se abrirá en una nueva pestaña</p>
                        <a href="${url}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-150">
                            <span class="material-icons mr-2">open_in_new</span>
                            Abrir PDF
                        </a>
                    </div>
                </div>
            `;
        }, 500); // Simular tiempo de carga para PDFs
    }
    
    // Enfocar el botón de cerrar para accesibilidad
    setTimeout(() => {
        modal.querySelector('button[onclick="closeComprobanteModal()"]').focus();
    }, 100);
}

// Función para cerrar el modal
function closeComprobanteModal() {
    const modal = document.getElementById('comprobanteModal');
    modal.classList.add('hidden');
    modal.classList.remove('modal-fade-in');
    document.body.classList.remove('modal-open');
    
    // Limpiar contenido
    document.getElementById('modalContent').innerHTML = '';
}

// Función para descargar comprobante
function downloadComprobante(url, filename) {
    // Usar la ruta segura del servidor
    const downloadUrl = '{{ route("paciente.citas.downloadComprobante", $cita->id) }}';
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.target = '_blank';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Mostrar notificación
    showNotification('Descarga iniciada', 'success');
}

// Función para descargar desde el modal
function downloadFromModal() {
    // Usar la ruta segura del servidor
    const downloadUrl = '{{ route("paciente.citas.downloadComprobante", $cita->id) }}';
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.target = '_blank';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Mostrar notificación
    showNotification('Descarga iniciada', 'success');
}

// Función para obtener nombre del método de pago
function getPaymentMethodName(method) {
    const methods = {
        'online': 'Pago en Línea',
        'transfer': 'Transferencia / Yape / Plin',
        'clinic': 'Pago en Clínica',
        'transferencia': 'Transferencia Bancaria',
        'yape': 'Yape',
        'plin': 'Plin'
    };
    return methods[method] || method;
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
            <span class="material-icons mr-2">${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}</span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Función para manejar errores de descarga
function handleDownloadError() {
    showNotification('Error al descargar el comprobante. Intente nuevamente.', 'error');
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('comprobanteModal');
        if (!modal.classList.contains('hidden')) {
            closeComprobanteModal();
        }
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('comprobanteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeComprobanteModal();
    }
});

// Detectar errores de descarga
window.addEventListener('error', function(event) {
    if (event.target.tagName === 'IMG' && event.target.closest('#comprobanteModal')) {
        handleDownloadError();
    }
});

// Funciones para el modal de cancelación
function openCancelModal() {
    const modal = document.getElementById('cancelModal');
    const modalContent = document.getElementById('cancelModalContent');
    
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
    
    // Animar entrada del modal
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Enfocar el botón de mantener para accesibilidad
    setTimeout(() => {
        modal.querySelector('button[onclick="closeCancelModal()"]').focus();
    }, 300);
}

function closeCancelModal() {
    const modal = document.getElementById('cancelModal');
    const modalContent = document.getElementById('cancelModalContent');
    
    // Animar salida del modal
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.classList.remove('modal-open');
    }, 200);
}

// Cerrar modal de cancelación con Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const cancelModal = document.getElementById('cancelModal');
        if (!cancelModal.classList.contains('hidden')) {
            closeCancelModal();
        }
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
</script>
@endpush
@endsection 