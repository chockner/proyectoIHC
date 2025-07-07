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
                    <span class="material-icons mr-2">edit</span>
                    Editar
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
                        {{ \Carbon\Carbon::parse($cita->appointment_date)->format('l, d \d\e F \d\e Y') }}
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
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Comprobante</h3>
                        <a href="{{ asset('storage/' . $cita->payment->image_path) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <span class="material-icons mr-2 text-sm">visibility</span>
                            Ver Comprobante
                        </a>
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
            <h2 class="text-lg font-semibold text-gray-800">Acciones</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <form action="{{ route('paciente.citas.confirm', $cita->id) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('¿Confirmar que la cita se completó?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                        <span class="material-icons mr-2">check_circle</span>
                        Marcar como Completada
                    </button>
                </form>
                
                <form action="{{ route('paciente.citas.cancel', $cita->id) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('¿Está seguro de que desea cancelar esta cita?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                        <span class="material-icons mr-2">cancel</span>
                        Cancelar Cita
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
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
</style>
@endsection 