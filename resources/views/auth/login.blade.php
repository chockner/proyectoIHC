@extends('layouts.public')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="document_id" class="form-label mt-2">Documento de Identidad</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="document_id" 
                    id="document_id" 
                    maxlength="8" 
                    inputmode="numeric" 
                    pattern="\d{8}" 
                    {{-- value="{{ old('document_id', optional($profile)->document_id ?? '') }}" --}}
                    {{-- required --}} 
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                    title="Ingrese exactamente 8 dígitos numéricos"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <small>¿Olvidaste tu contraseña?</small>
        </div>
    </div>
</div>
@endsection
