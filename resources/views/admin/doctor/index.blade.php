@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Lista de Doctores</h2>
    <div class="mb-3">
        <a href="{{ route('admin.doctor.create') }}" class="btn btn-primary" title="Agregar Doctor"><img src="/imagenes/image.png" alt="Agregar Doctor" style="width: 50px; height: 50px;">     Agregar Doctor</a>
    </div>
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
            @foreach ($doctores as $index => $doctor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doctor->user->profile->first_name }}</td>
                    <td>{{ $doctor->user->profile->last_name }}</td>
                    <td>{{ $doctor->specialty->name }}</td>
                    <td>{{ $doctor->user->profile->email }}</td>
                    <td>{{ $doctor->user->profile->phone }}</td>
                    <td>
                        <a href="{{ route('admin.doctor.show', $doctor->id) }}" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a> {{-- {{ route('admin.doctor.show', $doctor->id) }} --}}
                        <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-pencil-alt"></i></a> {{-- {{ route('admin.doctor.edit', $doctor->id) }} --}}
                        <form action="{{ route('admin.doctor.destroy', $doctor->id) }}" method="POST" class="d-inline"> {{-- {{ route('admin.doctor.destroy', $doctor->id) }} --}}
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if ($doctores->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No hay doctores registrados.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Paginación -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{-- Enlace "First" --}}
            {{-- Enlace "Previous" --}}
            <li class="page-item {{ $doctores->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $doctores->previousPageUrl() }}" aria-label="Previous">Anterior</a>
            </li>

            {{-- Páginas numéricas --}}
            @for ($i = 1; $i <= $doctores->lastPage(); $i++)
                <li class="page-item {{ $i == $doctores->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $doctores->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Enlace "Next" --}}
            <li class="page-item {{ $doctores->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $doctores->nextPageUrl() }}" aria-label="Next">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>

@endsection
