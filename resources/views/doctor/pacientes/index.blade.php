@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Pacientes</h1>
        <div class="mb-3 flex justify-end">
            {{-- para filtrar --}}
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Grupo sanguíneo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $index => $paciente)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $paciente->user->profile->first_name }}</td>
                        <td>{{ $paciente->user->profile->last_name }}</td>
                        <td>{{ $paciente->blood_type }}</td>
                        <td>
                            <div class="mb-3 flex justify-center space-x-2">
                                {{-- Icono Ver --}}
                                <div class="flex flex-col items-center">
                                    <a href="{{ route('doctor.pacientes.show', $paciente->medicalRecords->id) }}"
                                        class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                        data-bs-toggle="tooltip" data-bs-title="Ver">
                                        <div class="relative">
                                            <span class="material-icons text-blue-600">assist_walker</span>
                                            <span
                                                class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-blue-100 text-blue-600 rounded-full p-0.4">visibility</span>
                                        </div>
                                    </a>
                                </div>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection
@push('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
