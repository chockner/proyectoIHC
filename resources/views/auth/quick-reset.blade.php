@extends('layouts.public')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Restablecer Contraseña Rápidamente</h3>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('quick.reset') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="document_id" class="form-label">Documento de Identidad (DNI)</label>
                    <input type="text" class="form-control" name="document_id" id="document_id" maxlength="8"
                        inputmode="numeric" pattern="\d{8}" required>
                </div>

                <div class="mb-3">
                    <label for="first_name" class="form-label">Nombre(s)</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Apellido(s)</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></small>
            </div>
        </div>
    </div>
@endsection
