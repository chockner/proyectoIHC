@extends('layouts.dashboard')
@section('content')
    <h3>Panel de Historias Médicas</h3>
    <p>En esta sección podrás gestionar las historias médicas de tus pacientes.</p>
    <p>/*EN VER AHI DEBE APARECER LOS DETALLES DE LA CITAS O COSAS QUE SE LLENAN EN ELHISTORIAL/**</p>
    
    <div class="mb -3">
        
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Especialidad</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiales as $index => $historial)
                    <tr>
                        
                        @if (isset($historial->patient->user))
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $historial->patient->user->profile->first_name}}</td>
                            <td>{{ $historial->patient->user->profile->last_name}}</td>

                            <td>
                                <a href="" class="btn btn-sm btn-info">Ver</a> {{-- {{ route('admin.doctor.show', $doctor->id) }} --}}


                @if ($historiales->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay doctores registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection