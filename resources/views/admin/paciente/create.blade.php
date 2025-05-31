@extends('layouts.dashboard')

@section('content')
    <h2>Agregar Paciente</h2>
    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control">
        </div>
        <button class="btn btn-primary">Guardar</button>
    </form>
@endsection
