@extends('layouts.public')

@section('content')

{{-- Carrusel de imágenes --}}
<div id="carouselHospital" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/images/pagina-bienvenida/imagen-carrousel-1.jpg" class="d-block w-100" alt="Hospital Imagen 1" style="height: 500px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="/images/pagina-bienvenida/imagen-carrousel-2.jpg" class="d-block w-100" alt="Hospital Imagen 2" style="height: 500px; object-fit: cover;"> 
        </div>
        <div class="carousel-item">
            <img src="/images/pagina-bienvenida/imagen-carrousel-3.jpg" class="d-block w-100" alt="Hospital Imagen 3" style="height: 500px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="/images/pagina-bienvenida/imagen-carrousel-4.webp" class="d-block w-100" alt="Hospital Imagen 3" style="height: 500px; object-fit: cover;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselHospital" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselHospital" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

{{-- Contenido principal --}}
<h2 class="text-center mb-4">Bienvenidos al Hospital Central</h2>

{{-- Sección: Sobre Nosotros --}}
<div class="row mb-4">
    <div class="col-md-12">
        <h4 id="sobre-nosotros">Sobre Nosotros</h4>
        <p>
            Somos un hospital moderno con personal altamente capacitado y tecnología de punta para ofrecer atención integral a nuestros pacientes.
        </p>
    </div>
</div>

{{-- Sección: Especialidades --}}
<div class="row mb-4">
    <div class="col-md-12">
        <h4 id="especialidades">Especialidades</h4>
        <div class="row">
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Cardiología" imagen="images/especialidad-pagina-bienvenida/cardiologia.jpg" />
            </div>
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Pediatría" imagen="images/especialidad-pagina-bienvenida/pediatria.jpg" />
            </div>
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Ginecología" imagen="images/especialidad-pagina-bienvenida/ginecologia.jpeg" />
            </div>
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Dermatología" imagen="images/especialidad-pagina-bienvenida/dermatologia.jpeg" />
            </div>
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Traumatología" imagen="images/especialidad-pagina-bienvenida/traumatologia.jpg" />
            </div>
            <div class="col-md-4 mb-3">
                <x-especialidad-pagina-principal nombre="Medicina General" imagen="images/especialidad-pagina-bienvenida/medicina-general.jpeg" />
            </div>
        </div>
    </div>
</div>


@endsection
