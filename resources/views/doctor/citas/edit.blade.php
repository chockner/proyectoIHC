@extends('layouts.dashboard')

@section('content')
    <style>
        .disabled-field {
            background-color: #e9ecef !important;
            opacity: 1;
            cursor: not-allowed;
        }

        .img-comprobante {
            max-width: 200px;
            height: auto;
        }
    </style>

    <div class="container mt-4">
        <h3 class="text-center mb-4 fw-bold">DETALLES DE LA CITA</h3>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (isset($cita) && $cita)
            <div class="row mt-2 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DEL Paciente</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Paciente</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->patient && $cita->patient->user && $cita->patient->user->profile ? $cita->patient->user->profile->first_name . ' ' . $cita->patient->user->profile->last_name : 'No disponible' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vacunas Recibidas</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->vaccination_received ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado de la Cita</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->status ?? 'No disponible' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Sangre</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->blood_type ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alergias</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->patient)->allergies ?? 'No disponible' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha y Hora</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ $cita->appointment_date }} | {{ $cita->appointment_time }}" disabled>
                    </div>


                </div>
            </div>
            <hr>

            <div class="row mt-4 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">INFORMACIÓN DE PAGO</h5>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Método de Pago</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->payment)->payment_method ?? 'No disponible' }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado del Comprobante</label>
                        <input type="text" class="form-control disabled-field"
                            value="{{ optional($cita->payment)->status ?? 'No disponible' }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Comprobante:</label>
                        @if ($cita->payment && $cita->payment->image_path)
                            <div>
                                <img src="{{ asset('storage/' . $cita->payment->image_path) }}" class="img-comprobante"
                                    alt="Comprobante de pago">
                            </div>
                        @else
                            <input type="text" class="form-control disabled-field" value="No disponible" disabled>
                        @endif
                    </div>
                </div>
            </div>
            <hr>

            <div class="row mt-4 justify-content-center">
                <h5 class="text-center mb-4 fw-bold">DETALLES MÉDICOS</h5>
                {{-- formulario para guardar la info de la cita --}}
                <form action="{{ route('doctor.citas.update', $cita->id) }}" method="POST" id="editCitaForm">
                    @csrf
                    @method('PUT')
                    <div class="d-flex justify-content-center align-items-start">
                        <!-- Diagnóstico y Tratamiento en la misma línea -->
                        <div class="col-md-5 mb-3 me-3">
                            <label for="diagnosis" class="form-label fw-bold">Diagnóstico</label>
                            <textarea name="diagnosis" id="diagnosis" class="form-control w-100" rows="6"
                                placeholder="Escriba el diagnóstico aquí..." required></textarea>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="treatment" class="form-label fw-bold">Tratamiento</label>
                            <textarea name="treatment" id="treatment" class="form-control w-100" rows="6"
                                placeholder="Escriba el tratamiento aquí..." required></textarea>
                        </div>
                    </div>

                    <!-- Campo de Notas debajo de los anteriores -->
                    <div class="col-md-10 offset-md-1 mb-3">
                        <label for="notes" class="form-label fw-bold">Notas</label>
                        <textarea name="notes" id="notes" class="form-control w-100" rows="6"
                            placeholder="Escriba las notas aquí..." required></textarea>
                    </div>


                    <div class="row mt-4 justify-content-center">
                        <div class="col-md-4 d-flex justify-content-start">
                            <a href="{{ route('doctor.citas.index') }}" class="btn btn-outline-secondary">Volver a la lista
                                de
                                citas</a>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <button type="button" id="btnEdit"
                                class="action-btn flex items-center justify-center rounded-md border border-gray-200 bg-white p-2"
                                data-bs-toggle="tooltip" data-bs-title="Guardar Cambios">
                                <div class="relative">
                                    <!-- Ícono principal de guardar -->
                                    <span class="material-icons text-green-500" style="font-size: 60px;">save</span>
                                    <!-- Pequeño ícono sobre el ícono de guardar -->
                                    <span
                                        class="material-icons absolute -bottom-0 -right-1.5 text-xs bg-gray-100 text-green-600 rounded-full p-0.4">check_circle</span>
                                </div>
                                {{-- Guardar Cambios --}}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="confirmEditModalLabel">Confirmar Atencion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <p id="confirmMessage"></p>
                                    <div class="alert alert-warning mt-2">
                                        Esta acción puede afectar la consistencia de los datos.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" id="btnConfirmEdit" class="btn btn-warning">Confirmar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Audio para el sonido de alerta -->
                <audio id="alertSound" preload="auto">
                    <source src="https://media.geeksforgeeks.org/wp-content/uploads/20190531135120/beep.mp3"
                        type="audio/mpeg">
                </audio>

            </div>
            <hr>
        @endif

    </div>
@endsection
@push('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Validación del formulario y modal de confirmación
        $('#btnEdit').click(function() {
            if (!$('#editCitaForm')[0].checkValidity()) {
                $('#editCitaForm')[0].reportValidity();
                return;
            }

            const message = `¿Estás seguro de que deseas finalizar esta cita?`;
            $('#confirmMessage').html(message);

            const modal = new bootstrap.Modal(document.getElementById('confirmEditModal'));
            modal.show();

            const alertSound = document.getElementById('alertSound');
            if (alertSound) {
                alertSound.play().catch(e => console.log('Error al reproducir el sonido:', e));
            }
        });

        $('#btnConfirmEdit').click(function() {
            $('#editCitaForm').submit();
        });
    </script>
@endpush
