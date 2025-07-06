@extends('layouts.dashboard')

@section('content')

<!--Aqui muestro las citas paginadas del usuario-->
<div class="container mt-4">
    <!-- Botón para agendar una nueva cita alineado a la derecha pero con margen a la derecha con icono de cita con un '+'-->
    <h2><strong>Mis Citas</strong></h2>
    {{-- <p class="text-muted">Aquí puedes ver todas tus citas programadas.</p> --}}

    <div class="mb-3 d-flex justify-content-end">
        <!-- Reservar cita -->
            <a href="{{ route('paciente.agendarCita.create') }}"
                class="btn btn-primary group-hover:bg-[#1A75FF] group-hover:text-white sidebar-link"
                style="display: flex; align-items: center; gap: 10px;">

                <div class="text-[#ffffff] relative">
                    <span class="material-icons text-4xl">calendar_month</span>
                    <span
                        class="material-icons absolute -top-2.5 -right-3 text-1xl p-2.5 text-green-500">add_circle</span>
                </div>
                <h4
                    class="text-[#ffffff] text-lg font-medium leading-tight text-center group-hover:text-[#1A75FF] transition-colors">
                    Reservar cita
                </h4>
            </a>
        <!-- Fin Reservar cita -->
    </div>

    @if ($citas->isEmpty())
        <div class="alert alert-info" role="alert">
            No tienes citas programadas.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Doctor</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->appointment_date}}</td>
                        <td>{{ $cita->appointment_time}}</td>
                        <td>{{ $cita->doctor->user->profile->first_name }}</td>
                        <td>{{ $cita->status }}</td>
                        <td>
                            <a href="{{ route('paciente.citas.show', $cita->id) }}" class="btn btn-info btn-sm">Ver</a>
                            @if ($cita->estado == 'Programada')
                                <a href="{{ route('paciente.citas.edit', $cita->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('paciente.citas.destroy', $cita->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $citas->links() }}
    @endif
</div>


@endsection