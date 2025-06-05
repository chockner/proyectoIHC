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
                            <td>{{ $historial->patient->user->profile->email}}</td>
                            <td>{{ $historial->patient->user->profile->phone}}</td>

                            <td>
                                <a href="" class="btn btn-sm btn-info" title="Ver"><i class="fas fa-eye"></i></a> {{-- {{ route('admin.doctor.show', $doctor->id) }} --}}
                                <a href="" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-pencil-alt"></i></a> {{-- {{ route('admin.doctor.edit', $doctor->id) }} --}}
                                <form action="" method="POST" class="d-inline"> {{-- {{ route('admin.doctor.destroy', $doctor->id) }} --}}
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach

                @if ($historiales->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay doctores registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection