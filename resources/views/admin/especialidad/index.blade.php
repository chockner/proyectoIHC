@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Lista de Doctores</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($especialidades as $index => $especialidad)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $especialidad->name }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Editar</a> {{-- {{ route('admin.doctor.edit', $doctor->id) }} --}}
                        <form action="#" method="POST" class="d-inline"> {{-- {{ route('admin.doctor.destroy', $doctor->id) }} --}}
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($especialidades->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No hay doctores registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
