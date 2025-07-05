@extends('layouts.dashboard')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
        <h1 class="text-[#0d131c] text-3xl md:text-4xl font-bold">Gestión de Pacientes</h1>
        <p class="text-[#49699c] text-base mt-1">Administra los pacientes registrados en el sistema.</p>
    </div>
    <div class="mt-4 md:mt-0">
        <a href="{{ route('admin.paciente.create') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
                <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
            </svg>
            Agregar Paciente
        </a>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Total Pacientes</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $pacientes->count() }}</p>
            </div>
            <div class="text-primary bg-primary-light p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Activos</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ $pacientes->where('status', 'active')->count() }}</p>
            </div>
            <div class="text-green-600 bg-green-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#49699c] text-sm font-medium">Citas Programadas</p>
                <p class="text-[#0d131c] text-2xl font-bold">{{ \App\Models\Appointment::where('status', 'scheduled')->count() }}</p>
            </div>
            <div class="text-purple-600 bg-purple-100 p-3 rounded-full">
                <svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Pacientes -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-[#0d131c] text-xl font-semibold">Lista de Pacientes</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">#</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Nombre Completo</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Correo</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Teléfono</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Estado</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-[#49699c]">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($pacientes as $index => $paciente)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 text-sm text-[#0d131c] font-medium">
                        {{ $index + 1 }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <span class="text-green-600 font-semibold text-sm">
                                    {{ strtoupper(substr($paciente->user->profile->first_name ?? 'P', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-[#0d131c] font-medium">{{ $paciente->user->profile->first_name }} {{ $paciente->user->profile->last_name }}</p>
                                <p class="text-[#49699c] text-sm">Paciente</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-[#0d131c]">
                        {{ $paciente->user->email }}
                    </td>
                    <td class="py-4 px-6 text-sm text-[#0d131c]">
                        {{ $paciente->user->profile->phone }}
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Activo
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <a href="#" 
                               class="text-yellow-600 hover:text-yellow-800 p-1 rounded transition-colors" 
                               title="Editar">
                                <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M227.31,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.31,64l24-24L216,84.69Z"></path>
                                </svg>
                            </a>
                            <button type="button" 
                                    class="text-red-600 hover:text-red-800 p-1 rounded transition-colors btn-delete" 
                                    data-form-id="form-{{ $paciente->id }}"
                                    title="Eliminar">
                                <svg fill="currentColor" height="16" viewBox="0 0 256 256" width="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z"></path>
                                </svg>
                            </button>
                            <form id="form-{{ $paciente->id }}" action="{{ route('admin.paciente.destroy', $paciente->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg fill="currentColor" height="64" viewBox="0 0 256 256" width="64" xmlns="http://www.w3.org/2000/svg">
                                <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                            </svg>
                        </div>
                        <p class="text-[#49699c] text-lg font-medium">No hay pacientes registrados</p>
                        <p class="text-[#49699c] text-sm mt-1">Comienza agregando el primer paciente al sistema</p>
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
            confirmMessage.textContent = '¿Está seguro que desea eliminar este paciente? Esta acción no se puede deshacer.';
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
