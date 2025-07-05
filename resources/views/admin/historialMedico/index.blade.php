@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">Gestión de Historias Médicas</h1>
        <p class="text-[#49699c] text-base mt-1">Administra los historiales médicos de los pacientes.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="#" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
            </svg>
            Nueva Historia
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Historias</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $historiales->count() }}</p>
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
                <p class="text-[#49699c] text-sm font-medium">Pacientes con Historia</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $historiales->unique('patient_id')->count() }}</p>
            </div>
            <div class="text-green-600 bg-green-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Actualizaciones Recientes</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $historiales->where('updated_at', '>=', now()->subDays(7))->count() }}</p>
            </div>
            <div class="text-purple-600 bg-purple-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,56a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,56Zm64,147.25V197c0,14.25-5.51,26.62-13.46,35.65A61.39,61.39,0,0,1,155,240a8,8,0,0,1-1.07-15.72c48.78-7.22,88.31-36.91,88.79-77.11a8,8,0,0,1,7.65-8.26c.41,0,.82,0,1.23,0a8,8,0,0,1,8,8.21C259.16,176.58,210.48,203.25,192,203.25ZM128,72a32,32,0,1,1-32,32A32,32,0,0,1,128,72Zm0,112a40,40,0,0,0-32.35-62.76,8,8,0,1,0,2.93,15.59A24,24,0,1,1,152,136a8,8,0,0,0,16,0A40,40,0,0,0,128,184Z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Historias Médicas -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-[#0d131c] text-xl font-semibold">Lista de Historias Médicas</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">#</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Paciente</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Correo</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Teléfono</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Última Actualización</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Estado</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($historiales as $index => $historial)
                        @if (isset($historial->patient->user))
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6 text-sm text-[#0d131c] font-medium">
                            {{ $index + 1 }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                    <span class="text-orange-600 font-semibold text-sm">
                                        {{ strtoupper(substr($historial->patient->user->profile->first_name ?? 'H', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-[#0d131c] font-medium">{{ $historial->patient->user->profile->first_name }} {{ $historial->patient->user->profile->last_name }}</p>
                                    <p class="text-[#49699c] text-sm">Historia Médica</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-[#0d131c]">
                            {{ $historial->patient->user->profile->email }}
                        </td>
                        <td class="py-4 px-6 text-sm text-[#0d131c]">
                            {{ $historial->patient->user->profile->phone }}
                        </td>
                        <td class="py-4 px-6 text-sm text-[#0d131c]">
                            {{ $historial->updated_at ? $historial->updated_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activa
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <a href="#" 
                                   class="text-blue-600 hover:text-blue-800 p-1 rounded transition-colors" 
                                   title="Ver detalles">
                                    <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.62,27.65-38.41A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.16,133.16,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.16,133.16,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
                                    </svg>
                                </a>
                                <a href="#" 
                                   class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition-colors" 
                                   title="Editar">
                                    <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M227.31,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.31,64l24-24L216,84.69Z"></path>
                                    </svg>
                                </a>
                                <button type="button" 
                                        class="text-red-600 hover:text-red-800 p-1 rounded transition-colors btn-delete" 
                                        data-form-id="form-{{ $historial->id }}"
                                        title="Eliminar">
                                    <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z"></path>
                                    </svg>
                                </button>
                                <form id="form-{{ $historial->id }}" action="#" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            </td>
                    </tr>
                @endif
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg fill="currentColor" height="64" viewBox="0 0 256 256" width="64" xmlns="http://www.w3.org/2000/svg">
                                <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                            </svg>
                        </div>
                        <p class="text-[#49699c] text-lg font-medium">No hay historias médicas registradas</p>
                        <p class="text-[#49699c] text-sm mt-1">Comienza creando la primera historia médica</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" id="confirmDeleteModal">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg fill="currentColor" class="text-red-600" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-40a8,8,0,0,1-8,8,16,16,0,0,1-16-16V128a8,8,0,0,1,0-16,16,16,0,0,1,16,16v40A8,8,0,0,1,144,176ZM128,88a12,12,0,1,1-12,12A12,12,0,0,1,128,88Z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-[#0d131c]">Confirmar Eliminación</h3>
                    <p class="text-[#49699c] text-sm">Esta acción no se puede deshacer</p>
                </div>
            </div>
            <p id="confirmMessage" class="text-[#0d131c] mb-6"></p>
            <div class="flex gap-3">
                <button type="button" id="btnCancelDelete" class="flex-1 px-4 py-2 text-sm font-medium text-[#0d131c] bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="btnConfirmDelete" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmDeleteModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const btnCancelDelete = document.getElementById('btnCancelDelete');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    let currentForm = null;

    // Mostrar modal de confirmación
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-delete')) {
            currentForm = document.getElementById(e.target.dataset.formId);
            confirmMessage.textContent = '¿Está seguro que desea eliminar esta historia médica? Esta acción no se puede deshacer.';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });

    // Cerrar modal
    btnCancelDelete.addEventListener('click', function() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        currentForm = null;
    });

    // Confirmar eliminación
    btnConfirmDelete.addEventListener('click', function() {
        if (currentForm) {
            currentForm.submit();
        }
    });

    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentForm = null;
        }
    });
});
</script>
@endsection