@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Detalles del Doctor</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Información del Doctor</h5>
            <p class="card-text"><strong>Nombre:</strong> {{ $doctor->user->profile->first_name }}</p>
            <p class="card-text"><strong>Apellido:</strong> {{ $doctor->user->profile->last_name }}</p>
            <p class="card-text"><strong>Especialidad:</strong> {{ $doctor->specialty->name }}</p>
            <p class="card-text"><strong>Correo:</strong> {{ $doctor->user->profile->email }}</p>
            <p class="card-text"><strong>Teléfono:</strong> {{ $doctor->user->profile->phone }}</p>
            <p class="card-text"><strong>CODIGO:</strong> {{ $doctor->license_code}}</p>
        </div>
    </div>

    <a href="{{ route('admin.doctor.index') }}" class="btn btn-secondary mt-3">Volver a la lista de doctores</a>
@endsection
