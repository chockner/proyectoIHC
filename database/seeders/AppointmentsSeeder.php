<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $doctores = Doctor::with('schedules')->get();
        $pacientes = Patient::all();
        $paymentMethods = ['tarjeta', 'transferencia', 'yape', 'plin', 'clinica'];
        $comprobantesEjemplo = [
            'payment_proofs/payment_proof_1751946776_MORALES_ESQUIVEL CHRISTIAN_ANTHONY.jpg',
            'payment_proofs/payment_proof_1751947523_BOUCHER_PROYECTO_DE_TESIS.jpg',
            'payment_proofs/payment_proof_1751947746_PAGO DE POSTULACIÓN A DIRECTIVA - MORALES ESQUIVEL CHRISTIAN ANTHONY - TI.jpg',
        ];
        $diasFuturos = 15;
        $citasPorDoctor = 8;
        $estadosCita = ['programada', 'cancelada', 'completada'];
        $estadoPagoPorCita = [
            'programada' => 'pendiente',
            'cancelada' => 'pendiente',
            'completada' => 'validado',
        ];
        $citasPorPaciente = 3; // Una de cada estado si es posible
        // Primero, asegurar que cada paciente tenga al menos una cita de cada estado
        foreach ($pacientes as $paciente) {
            $slotsUsados = [];
            foreach ($estadosCita as $estadoCita) {
                // Buscar un slot disponible aleatorio
                $slot = null;
                foreach ($doctores->shuffle() as $doctor) {
                    $horarios = $doctor->schedules;
                    if ($horarios->isEmpty()) continue;
                    $carbonToDbDay = [
                        'lunes' => 'LUNES',
                        'martes' => 'MARTES',
                        'miercoles' => 'MIERCOLES',
                        'miércoles' => 'MIERCOLES',
                        'jueves' => 'JUEVES',
                        'viernes' => 'VIERNES',
                        'sabado' => 'SABADO',
                        'sábado' => 'SABADO',
                        'domingo' => 'DOMINGO',
                    ];
                    for ($d = 1; $d <= $diasFuturos; $d++) {
                        $fecha = Carbon::now()->addDays($d);
                        $carbonDay = strtolower($fecha->locale('es')->isoFormat('dddd'));
                        $dbDay = $carbonToDbDay[$carbonDay] ?? null;
                        if (!$dbDay) continue;
                        foreach ($horarios as $horario) {
                            if ($dbDay !== $horario->day_of_week) continue;
                            $start = Carbon::parse($horario->start_time);
                            $end = Carbon::parse($horario->end_time);
                            while ($start < $end) {
                                $key = $doctor->id.'-'.$fecha->toDateString().'-'.$start->format('H:i:s');
                                if (!isset($slotsUsados[$key])) {
                                    $slot = [
                                        'doctor' => $doctor,
                                        'schedule_id' => $horario->id,
                                        'date' => $fecha->toDateString(),
                                        'time' => $start->format('H:i:s'),
                                    ];
                                    $slotsUsados[$key] = true;
                                    break 5;
                                }
                                $start->addMinutes(30);
                            }
                        }
                    }
                }
                if ($slot) {
                    $metodo = Arr::random($paymentMethods);
                    $imagePath = null;
                    if (in_array($metodo, ['transferencia', 'yape', 'plin'])) {
                        $imagePath = Arr::random($comprobantesEjemplo);
                    }
                    $cita = Appointment::create([
                        'patient_id' => $paciente->id,
                        'doctor_id' => $slot['doctor']->id,
                        'schedule_id' => $slot['schedule_id'],
                        'appointment_date' => $slot['date'],
                        'appointment_time' => $slot['time'],
                        'status' => $estadoCita,
                    ]);
                    Payment::create([
                        'appointment_id' => $cita->id,
                        'uploaded_by' => $paciente->user_id,
                        'validated_by' => null,
                        'image_path' => $imagePath,
                        'payment_method' => $metodo,
                        'amount' => 35.00,
                        'status' => $estadoPagoPorCita[$estadoCita],
                        'uploaded_at' => now(),
                        'validated_at' => $estadoCita === 'completada' ? now() : null,
                    ]);
                }
            }
        }
        // Luego, completar el resto de slots para los doctores (citas adicionales aleatorias)
        foreach ($doctores as $doctor) {
            $horarios = $doctor->schedules;
            if ($horarios->isEmpty()) continue;
            $slotsDisponibles = [];
            $carbonToDbDay = [
                'lunes' => 'LUNES',
                'martes' => 'MARTES',
                'miercoles' => 'MIERCOLES',
                'miércoles' => 'MIERCOLES',
                'jueves' => 'JUEVES',
                'viernes' => 'VIERNES',
                'sabado' => 'SABADO',
                'sábado' => 'SABADO',
                'domingo' => 'DOMINGO',
            ];
            for ($d = 1; $d <= $diasFuturos; $d++) {
                $fecha = Carbon::now()->addDays($d);
                $carbonDay = strtolower($fecha->locale('es')->isoFormat('dddd'));
                $dbDay = $carbonToDbDay[$carbonDay] ?? null;
                if (!$dbDay) continue;
                foreach ($horarios as $horario) {
                    if ($dbDay !== $horario->day_of_week) continue;
                    $start = Carbon::parse($horario->start_time);
                    $end = Carbon::parse($horario->end_time);
                    while ($start < $end) {
                        $slotsDisponibles[] = [
                            'date' => $fecha->toDateString(),
                            'time' => $start->format('H:i:s'),
                            'schedule_id' => $horario->id
                        ];
                        $start->addMinutes(30);
                    }
                }
            }
            shuffle($slotsDisponibles);
            $slotsSeleccionados = array_slice($slotsDisponibles, 0, $citasPorDoctor);
            foreach ($slotsSeleccionados as $slot) {
                $paciente = $pacientes->random();
                $estadoCita = Arr::random($estadosCita);
                $metodo = Arr::random($paymentMethods);
                $imagePath = null;
                if (in_array($metodo, ['transferencia', 'yape', 'plin'])) {
                    $imagePath = Arr::random($comprobantesEjemplo);
                }
                $cita = Appointment::create([
                    'patient_id' => $paciente->id,
                    'doctor_id' => $doctor->id,
                    'schedule_id' => $slot['schedule_id'],
                    'appointment_date' => $slot['date'],
                    'appointment_time' => $slot['time'],
                    'status' => $estadoCita,
                ]);
                Payment::create([
                    'appointment_id' => $cita->id,
                    'uploaded_by' => $paciente->user_id,
                    'validated_by' => null,
                    'image_path' => $imagePath,
                    'payment_method' => $metodo,
                    'amount' => 35.00,
                    'status' => $estadoPagoPorCita[$estadoCita],
                    'uploaded_at' => now(),
                    'validated_at' => $estadoCita === 'completada' ? now() : null,
                ]);
            }
        }
    }
}

