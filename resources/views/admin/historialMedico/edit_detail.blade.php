@extends('layouts.dashboard')
@section('content')
    <div class="container mt-4">
        <h3">Historias Medicas->EditarCita</h3>

            <h3 class="text-center mb-4 fw-bold">EDITAR CITA</h3>
            <hr>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="" method="POST" id="editDoctorForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- INFORMACION BASICA --}}
                {{-- recuerda que deben tener el mismo nombre los id y name que los que estan en el 
                controlador --}}
                {{-- INFORMACION DE LA CITA --}}


                <div class="row mt-4 justify-content-center">
                    <div class="col-md-4 d-flex justify-content-start">
                        <a href="{{ route('admin.historialMedico.show', $historial->id) }}"
                            class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-success" id="btnEdit">Guardar Cambios</button>
                    </div>
                </div>
            </form>
    </div>
@endsection
