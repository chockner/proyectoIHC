@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reservar Cita Médica</h1>
        <h2 class="text-lg sm:text-xl font-semibold text-blue-600 mb-6">Paso 4 de 4: Confirmación y Pago</h2>

        <!-- Barra de progreso -->
        <div class="mb-8">
            <div class="overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-blue-600" style="width: 100%"></div>
            </div>
            <div class="mt-2 flex justify-between text-xs text-gray-500">
                <span>Especialidad</span>
                <span>Médico</span>
                <span>Fecha y Hora</span>
                <span class="font-semibold text-blue-600">Confirmar</span>
            </div>
        </div>

        <!-- Formulario de confirmación y pago -->
        <form action="{{ route('paciente.agendarCita.store') }}" method="POST" enctype="multipart/form-data"
            id="confirmacionForm">
            @csrf
            <input type="hidden" name="specialty_id" value="{{ $especialidad->id }}">
            <input type="hidden" name="doctor_id" value="{{ $medico->id }}">
            <input type="hidden" name="schedule_id" value="{{ $horario->id }}">
            <input type="hidden" name="appointment_date" value="{{ request('appointment_date') }}">
            <input type="hidden" name="appointment_time" value="{{ request('appointment_time') }}">
            <input type="hidden" name="amount" value="{{ $costo }}">

            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg">
                <!-- Resumen de la cita -->
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Resumen de la Cita</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-8 text-sm">
                    <div>
                        <p class="text-gray-500">Paciente:</p>
                        <p class="font-medium text-gray-700">
                            {{ $paciente->user->profile->first_name ?? 'Paciente' }}
                            {{ $paciente->user->profile->last_name ?? '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Especialidad:</p>
                        <p class="font-medium text-gray-700">{{ $especialidad->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Médico:</p>
                        <p class="font-medium text-gray-700">
                            Dr. {{ $medico->user->profile->first_name ?? 'Médico' }}
                            {{ $medico->user->profile->last_name ?? '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Fecha:</p>
                        <p class="font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse(request('appointment_date'))->format('d \d\e F, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Hora:</p>
                        <p class="font-medium text-gray-700">{{ request('appointment_time') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Costo:</p>
                        <p class="font-medium text-gray-700">S/ {{ number_format($costo, 2) }}</p>
                    </div>
                </div>

                <!-- Método de Pago -->
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Método de Pago</h3>
                <div class="space-y-4 mb-8">
                    <div>
                        <input class="sr-only" id="onlinePayment" name="payment_method" onchange="togglePaymentFields()"
                            type="radio" value="online" />
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-150"
                            for="onlinePayment">
                            <span class="material-icons mr-3 text-blue-600">credit_card</span>
                            <span class="font-medium text-gray-700">Pago en Línea</span>
                        </label>
                    </div>
                    <div>
                        <input class="sr-only" id="transferPayment" name="payment_method" onchange="togglePaymentFields()"
                            type="radio" value="transfer" />
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-150"
                            for="transferPayment">
                            <span class="material-icons mr-3 text-green-600">qr_code_2</span>
                            <span class="font-medium text-gray-700">Transferencia / Yape / Plin (Subir Comprobante)</span>
                        </label>
                    </div>
                    <div>
                        <input class="sr-only" id="clinicPayment" name="payment_method" onchange="togglePaymentFields()"
                            type="radio" value="clinic" />
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-150"
                            for="clinicPayment">
                            <span class="material-icons mr-3 text-orange-600">local_hospital</span>
                            <span class="font-medium text-gray-700">Pago en Clínica</span>
                        </label>
                    </div>
                </div>

                <!-- Campos adicionales según método de pago -->
                <div id="transferFields" class="hidden mb-8">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Información de Pago</h4>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h5 class="font-medium text-gray-700 mb-2">Datos bancarios:</h5>
                        <p class="text-sm text-gray-600 mb-1">Banco: Banco de Crédito del Perú</p>
                        <p class="text-sm text-gray-600 mb-1">Cuenta: 193-12345678-0-12</p>
                        <p class="text-sm text-gray-600 mb-1">CCI: 002-193-001234567890-12</p>
                        <p class="text-sm text-gray-600 mb-3">Titular: Hospital SaludIntegra S.A.C.</p>

                        <h5 class="font-medium text-gray-700 mb-2">Yape / Plin:</h5>
                        <p class="text-sm text-gray-600">Número: 999-888-777</p>
                    </div>

                    <div class="mb-4">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                            Subir Comprobante de Pago
                        </label>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/*,.pdf"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, PDF (máximo 5MB)</p>
                    </div>
                </div>

                <div id="clinicFields" class="hidden mb-8">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <span class="material-icons text-yellow-600 mr-3">info</span>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800">Pago en Clínica</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Su cita será reservada. Deberá realizar el pago directamente en la clínica antes de su
                                    consulta.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Términos y condiciones -->
                <div class="mb-8">
                    <div class="flex items-start">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Acepto los <a href="#" class="text-blue-600 hover:text-blue-500">términos y
                                condiciones</a>
                            y la <a href="#" class="text-blue-600 hover:text-blue-500">política de privacidad</a>
                            del hospital.
                        </label>
                    </div>
                </div>

                <!-- Botones de navegación -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                    <a href="{{ route('paciente.agendarCita.seleccionarFechaHoraPreservado') }}"
                        class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                        Anterior
                    </a>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('paciente.agendarCita.limpiarSesion') }}"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 text-center">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors duration-150"
                            id="confirmButton">
                            Confirmar y Reservar Cita
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function togglePaymentFields() {
                const onlinePayment = document.getElementById('onlinePayment');
                const transferPayment = document.getElementById('transferPayment');
                const clinicPayment = document.getElementById('clinicPayment');

                const transferFields = document.getElementById('transferFields');
                const clinicFields = document.getElementById('clinicFields');

                // Ocultar todos los campos
                transferFields.classList.add('hidden');
                clinicFields.classList.add('hidden');

                // Mostrar campos según selección
                if (transferPayment.checked) {
                    transferFields.classList.remove('hidden');
                } else if (clinicPayment.checked) {
                    clinicFields.classList.remove('hidden');
                }
            }

            // Validación del formulario
            document.getElementById('confirmacionForm').addEventListener('submit', function(e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                const terms = document.getElementById('terms').checked;

                if (!paymentMethod) {
                    e.preventDefault();
                    alert('Por favor seleccione un método de pago');
                    return;
                }

                if (!terms) {
                    e.preventDefault();
                    alert('Debe aceptar los términos y condiciones');
                    return;
                }

                // Si es transferencia, verificar que se subió comprobante
                if (paymentMethod.value === 'transfer') {
                    const paymentProof = document.getElementById('payment_proof').files[0];
                    if (!paymentProof) {
                        e.preventDefault();
                        alert('Debe subir el comprobante de pago');
                        return;
                    }

                    // Verificar tamaño del archivo (5MB máximo)
                    if (paymentProof.size > 5 * 1024 * 1024) {
                        e.preventDefault();
                        alert('El archivo es demasiado grande. Máximo 5MB');
                        return;
                    }
                }
            });

            // Estilos para los radio buttons
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remover estilos de todos los labels
                    document.querySelectorAll('input[name="payment_method"] + label').forEach(label => {
                        label.classList.remove('border-blue-500', 'bg-blue-50');
                    });

                    // Aplicar estilos al label seleccionado
                    if (this.checked) {
                        this.nextElementSibling.classList.add('border-blue-500', 'bg-blue-50');
                    }
                });
            });
        </script>

        <style>
            input[type="radio"]:checked+label {
                border-color: #1e40af;
                background-color: #e0e7ff;
                color: #1e3a8a;
            }

            .material-icons {
                font-family: 'Material Icons';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;
                display: inline-block;
                line-height: 1;
                text-transform: none;
                letter-spacing: normal;
                word-wrap: normal;
                white-space: nowrap;
                direction: ltr;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
                -moz-osx-font-smoothing: grayscale;
                font-feature-settings: 'liga';
            }
        </style>
    @endpush
@endsection
