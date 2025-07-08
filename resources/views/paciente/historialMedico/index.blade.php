@extends('layouts.dashboard')

@section('content')

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Mi Historia Medica</h1>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- filtros --}}

        {{-- lista de detalles de historial --}}

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if ($paciente->medicalRecords->details->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Doctor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Especialidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Diagnostico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tratamiento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Notas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($paciente->medicalRecords->details as $cita)
                                <tr class="cita-row">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($cita->appointment->appointment_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{-- @if ($cita->appointment->doctor->user->profile && $cita->doctor->user->profile->profile_photo)
                                                <img class="h-10 w-10 rounded-full object-cover mr-3"
                                                    src="{{ asset('storage/' . $cita->doctor->user->profile->profile_photo) }}"
                                                    alt="Foto del médico">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                    <span class="material-icons text-gray-400">person</span>
                                                </div>
                                            @endif --}}
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    Dr.
                                                    {{ $cita->appointment->doctor->user->profile->first_name ?? 'Médico' }}
                                                    {{ $cita->doctor->user->profile->last_name ?? '' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $cita->appointment->doctor->license_code }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->appointment->doctor->specialty->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $cita->diagnosis }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $cita->treatment }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $cita->notes }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <span class="material-icons text-6xl text-gray-300 mb-4">event_busy</span>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No tienes Historia MEdica</h3>
                    <p class="text-sm text-gray-500 mb-6">Agenda tu primera cita médica para comenzar.</p>
                    <a href="{{ route('paciente.agendarCita.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                        <span class="material-icons mr-2">add</span>
                        Agendar Cita
                    </a>
                </div>
            @endif
        </div>

    </div>
@endsection
