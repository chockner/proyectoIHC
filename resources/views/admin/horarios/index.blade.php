@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">Gestión de Horarios</h1>
        <p class="text-[#49699c] text-base mt-1">Administra los horarios médicos del sistema.</p>
    </div>
    <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('admin.horarios.create') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
            </svg>
            Agregar Horario
        </a>
        <a href="{{ route('admin.horarios.edit-by-filters') }}" class="btn-secondary inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M227.31,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.31,64l24-24L216,84.69Z"></path>
            </svg>
            Editar Masivo
        </a>
        <a href="{{ route('admin.horarios.delete-by-filters') }}" class="btn-danger inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z"></path>
            </svg>
            Eliminar Masivo
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Horarios</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $schedules->count() }}</p>
            </div>
            <div class="text-primary bg-primary-light p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Doctores Activos</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $schedules->unique('doctor_id')->count() }}</p>
            </div>
            <div class="text-green-600 bg-green-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Especialidades</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $schedules->unique('doctor_id')->map->doctor->unique('specialty_id')->count() }}</p>
            </div>
            <div class="text-purple-600 bg-purple-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-[#0d131c] text-xl font-semibold mb-4">Filtros</h2>
    <form method="GET" action="{{ route('admin.horarios.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-[#49699c] mb-2">Especialidad</label>
            <select name="specialty_filter" class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]">
                <option value="">Todas las especialidades</option>
                @foreach($specialties as $specialty)
                <option value="{{ $specialty->id }}" {{ request('specialty_filter') == $specialty->id ? 'selected' : '' }}>
                    {{ $specialty->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#49699c] mb-2">Turno</label>
            <select name="shift_filter" class="w-full rounded-lg border-[#cfd8e7] bg-white h-11 px-3.5 text-sm focus:border-[#1366eb] focus:ring-1 focus:ring-[#1366eb]">
                <option value="">Todos los turnos</option>
                <option value="MAÑANA" {{ request('shift_filter') == 'MAÑANA' ? 'selected' : '' }}>Mañana</option>
                <option value="TARDE" {{ request('shift_filter') == 'TARDE' ? 'selected' : '' }}>Tarde</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-[#1366eb] text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-[#0f52c6] transition-colors">
                <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg" class="inline mr-2">
                    <path d="M128,64a64,64,0,1,0,64,64A64.07,64.07,0,0,0,128,64Zm0,112a48,48,0,1,1,48-48A48.05,48.05,0,0,1,128,176Zm48-48a8,8,0,0,1-8-8V88a8,8,0,0,1,16,0v32A8,8,0,0,1,176,128Z"></path>
                </svg>
                Filtrar
            </button>
        </div>
    </form>
</div>

<!-- Tabla de Horarios -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-[#0d131c] text-xl font-semibold">Horarios Médicos</h2>
    </div>
    
    <div class="overflow-x-auto">
        @foreach(['MAÑANA', 'TARDE'] as $turno)
        <div class="mb-6">
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                <h3 class="text-[#0d131c] text-lg font-semibold">Turno {{ $turno }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-center py-4 px-4 text-sm font-medium text-[#49699c] w-24">Hora</th>
                            @foreach($days as $day)
                            <th class="text-center py-4 px-4 text-sm font-medium text-[#49699c] min-w-[200px]">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($hours[$turno] as $hour)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="text-center py-4 px-4 text-sm font-bold text-[#0d131c] bg-gray-50">
                                {{ $hour }}
                            </td>
                            @foreach($days as $day)
                            <td class="py-4 px-4 align-top">
                                @php
                                    $currentHour = strtotime($hour);
                                    $matchingSchedules = $schedules->filter(function($schedule) use ($day, $currentHour, $turno) {
                                        return $schedule->day_of_week == $day && 
                                               $schedule->shift == $turno &&
                                               strtotime($schedule->start_time) <= $currentHour && 
                                               strtotime($schedule->end_time) > $currentHour;
                                    });
                                @endphp
                                
                                @foreach($matchingSchedules as $schedule)
                                <div class="schedule-item mb-3 p-3 rounded-lg border-l-4 border-blue-500 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                                <span class="text-blue-600 font-semibold text-xs">
                                                    {{ strtoupper(substr($schedule->doctor->user->profile->first_name ?? 'D', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-[#0d131c] font-medium text-sm">
                                                    Dr. {{ $schedule->doctor->user->profile->last_name ?? 'Sin nombre' }}
                                                </p>
                                                <p class="text-[#49699c] text-xs">
                                                    {{ $schedule->doctor->specialty->name ?? 'Sin especialidad' }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-[#49699c] bg-white px-2 py-1 rounded">
                                            {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                        </span>
                                    </div>
                                    <div class="flex gap-1">
                                        <button class="text-blue-600 hover:text-blue-800 p-1 rounded transition-colors" title="Ver detalles">
                                            <svg fill="currentColor" height="12" viewBox="0 0 256 256" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.16,133.16,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.16,133.16,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition-colors" title="Editar">
                                            <svg fill="currentColor" height="12" viewBox="0 0 256 256" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M227.31,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.31,64l24-24L216,84.69Z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 p-1 rounded transition-colors" title="Eliminar">
                                            <svg fill="currentColor" height="12" viewBox="0 0 256 256" width="12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('styles')
<style>
    .btn-secondary {
        @apply bg-gray-600 text-white hover:bg-gray-700;
    }
    .btn-danger {
        @apply bg-red-600 text-white hover:bg-red-700;
    }
</style>
@endsection