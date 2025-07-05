@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Lista de Doctores</h2>
        <form action="#" method="POST" id="createEspecialidadForm">
            @csrf
            <div class="row mb-3">
                <label for="name" class="form-label">Nombre de la Especialidad</label>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="name" id="name" required
                            onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary submit-btn" id="btnShowModal">Agregar
                            Especialidad</button>
                    </div>
                </div>
            </div>
        </form>
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
                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            <form action="#" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete"
                                    data-form-id="form-{{ $especialidad->id }}">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($especialidades->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay especialidades registradas.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                {{-- Enlace "Previous" --}}
                <li class="page-item {{ $especialidades->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $especialidades->previousPageUrl() }}" aria-label="Previous">Anterior</a>
                </li>
                {{-- Páginas numéricas --}}
                @for ($i = 1; $i <= $especialidades->lastPage(); $i++)
                    <li class="page-item {{ $i == $especialidades->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $especialidades->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Enlace "Next" --}}
                <li class="page-item {{ $especialidades->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $especialidades->nextPageUrl() }}" aria-label="Next">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
