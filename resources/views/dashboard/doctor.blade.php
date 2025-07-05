@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">Panel del Doctor</h1>
        <p class="text-[#49699c] text-base mt-1">Gestiona tus pacientes y citas médicas.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Citas Hoy -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Citas Hoy</p>
                <p class="text-[#0d131c] text-2xl font-bold">
                    @php
                        $doctorId = Auth::user()->doctor->id ?? 0;
                        echo \App\Models\Appointment::where('doctor_id', $doctorId)
                            ->whereDate('appointment_date', today())
                            ->count();
                    @endphp
                </p>
            </div>
            <div class="text-blue-600 bg-blue-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-[#49699c] text-sm font-medium">Citas programadas</span>
        </div>
    </div>

    <!-- Pacientes Atendidos -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Pacientes Atendidos</p>
                <p class="text-[#0d131c] text-2xl font-bold">
                    @php
                        echo \App\Models\Appointment::where('doctor_id', $doctorId)
                            ->where('status', 'completed')
                            ->distinct('patient_id')
                            ->count();
                    @endphp
                </p>
            </div>
            <div class="text-green-600 bg-green-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-[#49699c] text-sm font-medium">Este mes</span>
        </div>
    </div>

    <!-- Citas Pendientes -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Citas Pendientes</p>
                <p class="text-[#0d131c] text-2xl font-bold">
                    @php
                        echo \App\Models\Appointment::where('doctor_id', $doctorId)
                            ->where('status', 'pending')
                            ->count();
                    @endphp
                </p>
            </div>
            <div class="text-yellow-600 bg-yellow-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-[#49699c] text-sm font-medium">Requieren atención</span>
        </div>
    </div>

    <!-- Historias Clínicas -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Historias Clínicas</p>
                <p class="text-[#0d131c] text-2xl font-bold">
                    @php
                        echo \App\Models\MedicalRecord::where('doctor_id', $doctorId)->count();
                    @endphp
                </p>
            </div>
            <div class="text-purple-600 bg-purple-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-[#49699c] text-sm font-medium">Registros médicos</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Próximas Citas -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Próximas Citas</h3>
        <div class="space-y-4">
            @php
                $proximasCitas = \App\Models\Appointment::with(['patient'])
                    ->where('doctor_id', $doctorId)
                    ->where('appointment_date', '>=', now())
                    ->where('status', 'confirmed')
                    ->orderBy('appointment_date')
                    ->limit(5)
                    ->get();
            @endphp
            
            @forelse($proximasCitas as $cita)
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-primary bg-primary-light p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[#0d131c] text-base font-medium">{{ $cita->patient->name ?? 'Paciente' }}</p>
                    <p class="text-[#49699c] text-sm">{{ \Carbon\Carbon::parse($cita->appointment_date)->format('d/m/Y H:i') }}</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">{{ \Carbon\Carbon::parse($cita->appointment_date)->diffForHumans() }}</span>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="text-gray-400 mb-2">
                    <svg fill="currentColor" height="48" viewBox="0 0 256 256" width="48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                    </svg>
                </div>
                <p class="text-[#49699c] text-sm">No hay citas próximas programadas</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Acciones Rápidas</h3>
        <div class="space-y-3">
            <button class="btn-primary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:opacity-90 transition-opacity">
                Ver Mis Citas
            </button>
            <button class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors">
                Mis Pacientes
            </button>
            <button class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors">
                Historias Clínicas
            </button>
            <button class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors">
                Actualizar Perfil
            </button>
        </div>
    </div>
</div>

<!-- Citas de Hoy -->
<div class="bg-white p-6 rounded-xl shadow-md mt-6">
    <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Citas de Hoy</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 text-sm font-medium text-[#49699c]">Hora</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-[#49699c]">Paciente</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-[#49699c]">Especialidad</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-[#49699c]">Estado</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-[#49699c]">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $citasHoy = \App\Models\Appointment::with(['patient', 'specialty'])
                        ->where('doctor_id', $doctorId)
                        ->whereDate('appointment_date', today())
                        ->orderBy('appointment_date')
                        ->limit(10)
                        ->get();
                @endphp
                
                @forelse($citasHoy as $cita)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-[#0d131c]">
                        {{ \Carbon\Carbon::parse($cita->appointment_date)->format('H:i') }}
                    </td>
                    <td class="py-3 px-4 text-sm text-[#0d131c]">
                        {{ $cita->patient->name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-4 text-sm text-[#0d131c]">
                        {{ $cita->specialty->name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-4">
                        @if($cita->status == 'confirmed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Confirmada
                            </span>
                        @elseif($cita->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($cita->status) }}
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <button class="text-primary hover:text-primary-dark text-sm font-medium">
                            Atender
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-[#49699c] text-sm">
                        No hay citas programadas para hoy
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
