@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Lista de Pacientes</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $index => $paciente)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $paciente->user->profile->first_name }}</td>
                    <td>{{ $paciente->user->profile->last_name }}</td>
                    <td>{{ $paciente->user->email }}</td>
                    <td>{{ $paciente->user->profile->phone }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Editar</a> {{-- {{ route('admin.doctor.edit', $doctor->id) }} --}}
                        <form action="{{ route('admin.paciente.destroy', $paciente->id) }}" method="POST" class="d-inline"> {{-- {{ route('admin.doctor.destroy', $doctor->id) }} --}}
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($pacientes->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No hay pacientes registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
