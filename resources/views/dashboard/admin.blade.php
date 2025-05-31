@extends('layouts.dashboard')

@section('content')
    <h2>Panel de Administración</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Doctores</h5>
                    <p class="card-text fs-3">{{ $totalDoctores }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Secretarias</h5>
                    <p class="card-text fs-3">{{ $totalSecretarias }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Pacientes</h5>
                    <p class="card-text fs-3">{{ $totalPacientes }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
