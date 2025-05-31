@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h2>Editar Doctor</h2>
        <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">Nombre</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $doctor->user->profile->first_name }}" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Apellido</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $doctor->user->profile->last_name }}" required>
            </div>
            <div class="mb-3">
                <label for="specialty_id" class="form-label">Especialidad</label>
                <select name="specialty_id" id="specialty_id" class="form-select" required>
                    @foreach ($specialty as $specialty)
                        <option value="{{ $specialty->id }}" {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>
                            {{ $specialty->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    <div>
        
        <a href="{{ route('admin.doctor.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>


@endsection

