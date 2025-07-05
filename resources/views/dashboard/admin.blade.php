@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">Panel de Administración</h1>
        <p class="text-[#49699c] text-base mt-1">Gestiona todos los aspectos del sistema de salud.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Doctores -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Doctores</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ \App\Models\Doctor::count() }}</p>
            </div>
            <div class="text-primary bg-primary-light p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.doctor.index') }}" class="text-primary text-sm font-medium hover:underline">Ver todos los doctores →</a>
        </div>
    </div>

    <!-- Total Pacientes -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Pacientes</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ \App\Models\Patient::count() }}</p>
            </div>
            <div class="text-green-600 bg-green-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.paciente.index') }}" class="text-primary text-sm font-medium hover:underline">Ver todos los pacientes →</a>
        </div>
    </div>

    <!-- Total Citas -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Citas</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ \App\Models\Appointment::count() }}</p>
            </div>
            <div class="text-blue-600 bg-blue-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-[#49699c] text-sm font-medium">Citas registradas</span>
        </div>
    </div>

    <!-- Total Especialidades -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Especialidades</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ \App\Models\Specialty::count() }}</p>
            </div>
            <div class="text-purple-600 bg-purple-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.especialidad.index') }}" class="text-primary text-sm font-medium hover:underline">Ver especialidades →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Acciones Rápidas -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Acciones Rápidas</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.doctor.create') }}" class="btn-primary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:opacity-90 transition-opacity inline-block text-center">
                Agregar Nuevo Doctor
            </a>
            <a href="{{ route('admin.secretaria.create') }}" class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors inline-block text-center">
                Agregar Nueva Secretaria
            </a>
            <a href="{{ route('admin.especialidad.create') }}" class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors inline-block text-center">
                Agregar Nueva Especialidad
            </a>
            <a href="{{ route('admin.horarios.create') }}" class="btn-secondary w-full text-sm font-medium py-2.5 px-5 rounded-lg hover:bg-gray-200 transition-colors inline-block text-center">
                Gestionar Horarios
            </a>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h3 class="text-[#0d131c] text-lg font-semibold mb-4">Actividad Reciente</h3>
        <div class="space-y-4">
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-primary bg-primary-light p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M212,152a12,12,0,1,1-12-12A12,12,0,0,1,212,152Zm-4.55,39.29A48.08,48.08,0,0,1,160,232H136a48.05,48.05,0,0,1-48-48V143.49A64,64,0,0,1,32,80V40A16,16,0,0,1,48,24H64a8,8,0,0,1,0,16H48V80a48,48,0,0,0,48.64,48c26.11-.34,47.36-22.25,47.36-48.83V40H128a8,8,0,0,1,0-16h16a16,16,0,0,1,16,16V79.17c0,32.84-24.53,60.29-56,64.31V184a32,32,0,0,0,32,32h24a32.06,32.06,0,0,0,31.22-25,40,40,0,1,1,16.23.27ZM224,152a24,24,0,1,0-24,24A24,24,0,0,0,224,152Z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#0d131c] text-base font-medium">Nuevo Doctor Registrado</p>
                    <p class="text-[#49699c] text-sm">Dr. García se ha unido al sistema de salud.</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">Hace 1h</span>
            </div>
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-green-600 bg-green-100 p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#0d131c] text-base font-medium">Nuevo Paciente Registrado</p>
                    <p class="text-[#49699c] text-sm">María López se ha registrado en el sistema.</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">Hace 2h</span>
            </div>
            <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="text-blue-600 bg-blue-100 p-3 rounded-full mt-0.5">
                    <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px" xmlns="http://www.w3.org/2000/svg">
                        <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-[#0d131c] text-base font-medium">Nueva Cita Programada</p>
                    <p class="text-[#49699c] text-sm">Cita programada para el Dr. Ramírez mañana.</p>
                </div>
                <span class="text-xs text-gray-400 ml-auto whitespace-nowrap">Hace 3h</span>
            </div>
        </div>
    </div>
</div>
@endsection
