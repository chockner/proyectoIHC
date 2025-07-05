@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h2>Detalles del Paciente</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $paciente->user->profile->first_name }} {{ $paciente->user->profile->last_name }}
                </h5>
                <p class="card-text"><strong>Correo:</strong> {{ $paciente->user->email }}</p>
                <p class="card-text"><strong>Teléfono:</strong> {{ $paciente->user->profile->phone }}</p>
                <p class="card-text"><strong>Fecha de Creación:</strong> {{ $paciente->created_at->format('d/m/Y H:i') }}</p>
                <p class="card-text"><strong>Fecha de Actualización:</strong>
                    {{ $paciente->updated_at->format('d/m/Y H:i') }}</p>
                <a href="{{ route('admin.paciente.index') }}" class="btn btn-primary">
                    Volver a la lista de pacientes
                </a>
            </div>
        </div>
    </div>
@endsection
