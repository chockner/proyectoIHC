@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Lista de Secretarias</h2>
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
            @foreach ($secretarias as $index => $secretaria)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $secretaria->user->profile->first_name }}</td>
                    <td>{{ $secretaria->user->profile->last_name }}</td>
                    <td>{{ $secretaria->user->email }}</td>
                    <td>{{ $secretaria->user->profile->phone }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-pencil-alt"></i></a> {{-- {{ route('admin.doctor.edit', $doctor->id) }} --}}
                        <form action="#" method="POST" class="d-inline"> {{-- {{ route('admin.doctor.destroy', $doctor->id) }} --}}
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($secretarias->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No hay doctores registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
