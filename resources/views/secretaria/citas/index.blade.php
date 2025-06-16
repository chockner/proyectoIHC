@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Lista de Citas</h2>
    
    <!-- Filtros y Búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('secretaria.citas.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Filtrar por estado:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="programada" {{ request('status') == 'programada' ? 'selected' : '' }}>Programadas</option>
                        <option value="completada" {{ request('status') == 'completada' ? 'selected' : '' }}>Completadas</option>
                        {{-- <option value="cancelada" {{ request('status') == 'cancelada' ? 'selected' : '' }}>Canceladas</option> --}}
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="sort" class="form-label">Ordenar por:</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Fecha</option>
                        {{-- <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Estado</option> --}}
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="order" class="form-label">Orden:</label>
                    <select name="order" id="order" class="form-select">
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                    <a href="{{ route('secretaria.citas.index') }}" class="btn btn-outline-secondary ms-2">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de citas -->
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Doctor</th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($citas as $index => $cita)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cita->doctor->user->profile->last_name}}</td>
                    <td>{{ $cita->patient->user->profile->last_name}}</td>
                    <td>{{ $cita->appointment_date}}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $cita->status === 'programada' ? 'warning' : 
                            ($cita->status === 'completada' ? 'success' : 'danger') 
                        }}">
                            {{ ucfirst($cita->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{-- route('secretaria.citas.show', $cita->id) --}}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{-- route('secretaria.citas.edit', $cita->id) --}}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay citas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación Inteligente -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Botón Anterior --}}
            <li class="page-item {{ $citas->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $citas->appends(request()->query())->previousPageUrl() }}" aria-label="Anterior">
                    &laquo; Anterior
                </a>
            </li>

            {{-- Mostrar siempre la primera página --}}
            <li class="page-item {{ $citas->currentPage() == 1 ? 'active' : '' }}">
                <a class="page-link" href="{{ $citas->url(1) . '&' . http_build_query(request()->except('page')) }}">1</a>
            </li>

            {{-- Rango de páginas alrededor de la actual --}}
            @php
                $current = $citas->currentPage();
                $last = $citas->lastPage();
                $delta = 2;
                $left = $current - $delta;
                $right = $current + $delta;
                
                if ($left < 2) $left = 2;
                if ($right > $last - 1) $right = $last - 1;
            @endphp

            {{-- Separador inicial si hay un salto --}}
            @if($left > 2)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif

            {{-- Páginas intermedias --}}
            @for ($i = $left; $i <= $right; $i++)
                <li class="page-item {{ $i == $current ? 'active' : '' }}">
                    <a class="page-link" href="{{ $citas->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Separador final si hay un salto --}}
            @if($right < $last - 1)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif

            {{-- Mostrar siempre la última página (si es diferente de la primera) --}}
            @if($last > 1)
                <li class="page-item {{ $citas->currentPage() == $last ? 'active' : '' }}">
                    <a class="page-link" href="{{ $citas->url($last) . '&' . http_build_query(request()->except('page')) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Botón Siguiente --}}
            <li class="page-item {{ !$citas->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $citas->appends(request()->query())->nextPageUrl() }}" aria-label="Siguiente">
                    Siguiente &raquo;
                </a>
            </li>
        </ul>
    </nav>
</div>
@endsection