@extends('layouts.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Mis Citas</h1>
            <a href="{{ route('paciente.agendarCita.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                <span class="material-icons mr-2">add</span>
                Nueva Cita
            </a>
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

        <!-- Filtros -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Estado:</label>
                    <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="">Todos</option>
                        <option value="programada">Programada</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Especialidad:</label>
                    <select id="specialtyFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                        <option value="">Todas</option>
                        @foreach ($citas->pluck('doctor.specialty.name')->unique() as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Lista de citas -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if ($citas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Médico
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Especialidad
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pago
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($citas as $cita)
                                <tr class="cita-row" data-status="{{ $cita->status }}"
                                    data-specialty="{{ $cita->doctor->specialty->name }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($cita->appointment_date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($cita->appointment_time)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($cita->doctor->user->profile && $cita->doctor->user->profile->profile_photo)
                                                <img class="h-10 w-10 rounded-full object-cover mr-3"
                                                    src="{{ asset('storage/' . $cita->doctor->user->profile->profile_photo) }}"
                                                    alt="Foto del médico">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                    <span class="material-icons text-gray-400">person</span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    Dr. {{ $cita->doctor->user->profile->first_name ?? 'Médico' }}
                                                    {{ $cita->doctor->user->profile->last_name ?? '' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $cita->doctor->license_code }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $cita->doctor->specialty->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($cita->status)
                                            @case('programada')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Programada
                                                </span>
                                            @break

                                            @case('completada')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Completada
                                                </span>
                                            @break

                                            @case('cancelada')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Cancelada
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($cita->status) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($cita->payment)
                                            @switch($cita->payment->status)
                                                @case('validado')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Pagado
                                                    </span>
                                                @break

                                                @case('pendiente')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pendiente
                                                    </span>
                                                @break

                                                @case('rechazado')
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Rechazado
                                                    </span>
                                                @break

                                                @default
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst($cita->payment->status) }}
                                                    </span>
                                            @endswitch
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Sin pago
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('paciente.citas.show', $cita->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <span class="material-icons text-sm">visibility</span>
                                            </a>
                                            @if ($cita->status === 'programada')
                                                <a href="{{ route('paciente.citas.edit', $cita->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    <span class="material-icons text-sm">edit</span>
                                                </a>
                                                <form action="{{ route('paciente.citas.cancel', $cita->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('¿Está seguro de que desea cancelar esta cita?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <span class="material-icons text-sm">cancel</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $citas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <span class="material-icons text-6xl text-gray-300 mb-4">event_busy</span>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No tienes citas programadas</h3>
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

    @push('scripts')
        <script>
            // Filtros
            document.getElementById('statusFilter').addEventListener('change', filterCitas);
            document.getElementById('specialtyFilter').addEventListener('change', filterCitas);

            function filterCitas() {
                const statusFilter = document.getElementById('statusFilter').value;
                const specialtyFilter = document.getElementById('specialtyFilter').value;
                const rows = document.querySelectorAll('.cita-row');

                rows.forEach(row => {
                    const status = row.dataset.status;
                    const specialty = row.dataset.specialty;

                    const statusMatch = !statusFilter || status === statusFilter;
                    const specialtyMatch = !specialtyFilter || specialty === specialtyFilter;

                    if (statusMatch && specialtyMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        </script>

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
    @endpush
@endsection
