@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2>Detalles de secretaria</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información de la secre</h5>

            </div>
        </div>

        <a href="{{ route('admin.secretaria.index') }}" class="btn btn-secondary mt-3">Volver a la lista de secretarias</a>
    @endsection
