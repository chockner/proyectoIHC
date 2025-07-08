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

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <span class="material-icons text-red-600 mr-3">error</span>
                    <div>
                        <h4 class="text-sm font-medium text-red-800">Errores de validación:</h4>
                        <ul class="mt-2 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulario de confirmación y pago -->
        <form action="{{ route('paciente.agendarCita.store') }}" method="POST" enctype="multipart/form-data"
            id="confirmacionForm">
            @csrf
            <input type="hidden" name="specialty_id" value="{{ $especialidad->id }}">
            <input type="hidden" name="doctor_id" value="{{ $medico->id }}">
            <input type="hidden" name="schedule_id" value="{{ $horario->id }}">
            <input type="hidden" name="appointment_date" value="{{ session('agendar_cita.appointment_date') }}">
            <input type="hidden" name="appointment_time" value="{{ session('agendar_cita.appointment_time') }}">
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
                            {{ ucfirst(\Carbon\Carbon::parse(session('agendar_cita.appointment_date'))->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Hora:</p>
                        <p class="font-medium text-gray-700">{{ session('agendar_cita.appointment_time') }}</p>
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
                            type="radio" value="tarjeta" />
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-150"
                            for="onlinePayment">
                            <span class="material-icons mr-3 text-blue-600">credit_card</span>
                            <span class="font-medium text-gray-700">Pago con Tarjeta de Crédito/Débito</span>
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
                            type="radio" value="clinica" />
                        <label
                            class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors duration-150"
                            for="clinicPayment">
                            <span class="material-icons mr-3 text-orange-600">local_hospital</span>
                            <span class="font-medium text-gray-700">Pago en Clínica</span>
                        </label>
                    </div>
                </div>

                <!-- Campos para Pago con Tarjeta -->
                <div id="onlineFields" class="hidden mb-8">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Información de Tarjeta</h4>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <span class="material-icons text-blue-600 mr-3">security</span>
                            <div>
                                <h5 class="text-sm font-medium text-blue-800">Pago Seguro</h5>
                                <p class="text-sm text-blue-700">Sus datos están protegidos con encriptación SSL de 256 bits</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Número de Tarjeta
                            </label>
                            <input type="text" id="card_number" name="card_number" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        <div>
                            <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-2">
                                Titular de la Tarjeta
                            </label>
                            <input type="text" id="card_holder" name="card_holder" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="NOMBRE APELLIDO">
                        </div>
                        <div>
                            <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Vencimiento
                            </label>
                            <input type="text" id="card_expiry" name="card_expiry" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="MM/AA" maxlength="5">
                        </div>
                        <div>
                            <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-2">
                                CVV
                            </label>
                            <input type="text" id="card_cvv" name="card_cvv" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="123" maxlength="4">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="card_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email para Recibo
                        </label>
                        <input type="email" id="card_email" name="card_email" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="su@email.com" value="{{ auth()->user()->email ?? '' }}">
                    </div>
                </div>

                <!-- Campos para Transferencia/Yape/Plin -->
                <div id="transferFields" class="hidden mb-8">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Seleccionar Método de Pago</h4>
                    
                    <!-- Selección específica del método -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div>
                            <input class="sr-only" id="transfer_bancaria" name="transfer_method" type="radio" value="transferencia" />
                            <label for="transfer_bancaria" class="flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors duration-150">
                                <span class="material-icons text-green-600 mb-2">account_balance</span>
                                <span class="text-sm font-medium text-gray-700 text-center">Transferencia Bancaria</span>
                            </label>
                        </div>
                        <div>
                            <input class="sr-only" id="transfer_yape" name="transfer_method" type="radio" value="yape" />
                            <label for="transfer_yape" class="flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors duration-150">
                                <span class="material-icons text-green-600 mb-2">smartphone</span>
                                <span class="text-sm font-medium text-gray-700 text-center">Yape</span>
                            </label>
                        </div>
                        <div>
                            <input class="sr-only" id="transfer_plin" name="transfer_method" type="radio" value="plin" />
                            <label for="transfer_plin" class="flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition-colors duration-150">
                                <span class="material-icons text-green-600 mb-2">payment</span>
                                <span class="text-sm font-medium text-gray-700 text-center">Plin</span>
                            </label>
                        </div>
                    </div>

                    <!-- Información de pago según método seleccionado -->
                    <div id="transferInfo" class="hidden mb-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div id="transferenciaInfo" class="hidden">
                                <h5 class="font-medium text-gray-700 mb-2">Datos bancarios:</h5>
                                <p class="text-sm text-gray-600 mb-1">Banco: Banco de Crédito del Perú</p>
                                <p class="text-sm text-gray-600 mb-1">Cuenta: 193-12345678-0-12</p>
                                <p class="text-sm text-gray-600 mb-1">CCI: 002-193-001234567890-12</p>
                                <p class="text-sm text-gray-600 mb-3">Titular: Hospital SaludIntegra S.A.C.</p>
                            </div>
                            <div id="yapeInfo" class="hidden">
                                <h5 class="font-medium text-gray-700 mb-2">Yape:</h5>
                                <p class="text-sm text-gray-600 mb-1">Número: 999-888-777</p>
                                <p class="text-sm text-gray-600 mb-1">Titular: Hospital SaludIntegra S.A.C.</p>
                                <p class="text-sm text-gray-600">Monto: S/ {{ number_format($costo, 2) }}</p>
                            </div>
                            <div id="plinInfo" class="hidden">
                                <h5 class="font-medium text-gray-700 mb-2">Plin:</h5>
                                <p class="text-sm text-gray-600 mb-1">Número: 999-888-777</p>
                                <p class="text-sm text-gray-600 mb-1">Titular: Hospital SaludIntegra S.A.C.</p>
                                <p class="text-sm text-gray-600">Monto: S/ {{ number_format($costo, 2) }}</p>
                            </div>
                        </div>
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

                const onlineFields = document.getElementById('onlineFields');
                const transferFields = document.getElementById('transferFields');
                const clinicFields = document.getElementById('clinicFields');

                // Ocultar todos los campos
                onlineFields.classList.add('hidden');
                transferFields.classList.add('hidden');
                clinicFields.classList.add('hidden');

                // Limpiar campos de tarjeta si no está seleccionada
                if (!onlinePayment.checked) {
                    document.getElementById('card_number').value = '';
                    document.getElementById('card_holder').value = '';
                    document.getElementById('card_expiry').value = '';
                    document.getElementById('card_cvv').value = '';
                    document.getElementById('card_email').value = '';
                }

                // Limpiar campos de transferencia si no está seleccionada
                if (!transferPayment.checked) {
                    document.getElementById('payment_proof').value = '';
                    document.querySelectorAll('input[name="transfer_method"]').forEach(radio => {
                        radio.checked = false;
                    });
                    document.getElementById('transferInfo').classList.add('hidden');
                }

                // Mostrar campos según selección
                if (onlinePayment.checked) {
                    onlineFields.classList.remove('hidden');
                } else if (transferPayment.checked) {
                    transferFields.classList.remove('hidden');
                } else if (clinicPayment.checked) {
                    clinicFields.classList.remove('hidden');
                }
            }

            // Función para mostrar información específica de transferencia
            function toggleTransferInfo() {
                const transferMethod = document.querySelector('input[name="transfer_method"]:checked');
                const transferInfo = document.getElementById('transferInfo');
                const transferenciaInfo = document.getElementById('transferenciaInfo');
                const yapeInfo = document.getElementById('yapeInfo');
                const plinInfo = document.getElementById('plinInfo');

                // Ocultar toda la información
                transferInfo.classList.add('hidden');
                transferenciaInfo.classList.add('hidden');
                yapeInfo.classList.add('hidden');
                plinInfo.classList.add('hidden');

                if (transferMethod) {
                    transferInfo.classList.remove('hidden');
                    
                    if (transferMethod.value === 'transferencia') {
                        transferenciaInfo.classList.remove('hidden');
                    } else if (transferMethod.value === 'yape') {
                        yapeInfo.classList.remove('hidden');
                    } else if (transferMethod.value === 'plin') {
                        plinInfo.classList.remove('hidden');
                    }
                }
            }

            // Formateo de número de tarjeta
            document.getElementById('card_number').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            });

            // Formateo de fecha de vencimiento
            document.getElementById('card_expiry').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });

            // Solo números para CVV
            document.getElementById('card_cvv').addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9]/gi, '');
            });

            // Event listeners para métodos de transferencia
            document.querySelectorAll('input[name="transfer_method"]').forEach(radio => {
                radio.addEventListener('change', toggleTransferInfo);
            });

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

                // Validación para pago con tarjeta
                if (paymentMethod.value === 'tarjeta') {
                    const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
                    const cardHolder = document.getElementById('card_holder').value;
                    const cardExpiry = document.getElementById('card_expiry').value;
                    const cardCvv = document.getElementById('card_cvv').value;
                    const cardEmail = document.getElementById('card_email').value;

                    if (!cardNumber || cardNumber.length < 13) {
                        e.preventDefault();
                        alert('Por favor ingrese un número de tarjeta válido');
                        return;
                    }

                    if (!cardHolder || cardHolder.length < 3) {
                        e.preventDefault();
                        alert('Por favor ingrese el nombre del titular de la tarjeta');
                        return;
                    }

                    if (!cardExpiry || cardExpiry.length !== 5) {
                        e.preventDefault();
                        alert('Por favor ingrese una fecha de vencimiento válida (MM/AA)');
                        return;
                    }

                    if (!cardCvv || cardCvv.length < 3) {
                        e.preventDefault();
                        alert('Por favor ingrese el código CVV');
                        return;
                    }

                    if (!cardEmail || !cardEmail.includes('@')) {
                        e.preventDefault();
                        alert('Por favor ingrese un email válido para el recibo');
                        return;
                    }
                }

                // Validación para transferencia/yape/plin
                if (paymentMethod.value === 'transfer') {
                    const transferMethod = document.querySelector('input[name="transfer_method"]:checked');
                    if (!transferMethod) {
                        e.preventDefault();
                        alert('Por favor seleccione un método específico de pago');
                        return;
                    }

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

                // Simulación de procesamiento de pago
                if (paymentMethod.value === 'tarjeta') {
                    e.preventDefault();
                    const confirmButton = document.getElementById('confirmButton');
                    const originalText = confirmButton.textContent;
                    
                    confirmButton.disabled = true;
                    confirmButton.textContent = 'Procesando pago...';
                    
                    // Simular procesamiento
                    setTimeout(() => {
                        // Simular éxito del pago
                        alert('¡Pago procesado exitosamente! Su cita ha sido reservada.');
                        // Enviar el formulario directamente sin usar submit()
                        const form = document.getElementById('confirmacionForm');
                        form.submit();
                    }, 2000);
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

            // Estilos para los radio buttons de transferencia
            document.querySelectorAll('input[name="transfer_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remover estilos de todos los labels
                    document.querySelectorAll('input[name="transfer_method"] + label').forEach(label => {
                        label.classList.remove('border-green-500', 'bg-green-50');
                    });

                    // Aplicar estilos al label seleccionado
                    if (this.checked) {
                        this.nextElementSibling.classList.add('border-green-500', 'bg-green-50');
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

            input[name="transfer_method"]:checked+label {
                border-color: #059669;
                background-color: #d1fae5;
                color: #065f46;
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
