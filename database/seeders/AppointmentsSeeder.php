<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\schedule;
use App\Models\MedicalRecordDetail;
use App\Models\MedicalRecord;
use App\Models\Payment;
use App\Models\Secretary;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $doctor = Doctor::findOrFail($i);

            for ($j = 1; $j <= 40; $j++) {
                $schedule = Schedule::findOrFail($j);

                for ($k = 1; $k <= 10; $k++) {
                    $paciente = Patient::findOrFail($k);

                    // Genera una fecha aleatoria entre 1 y 30 días hacia adelante, pero solo días laborables (lunes a viernes)
                    $appointmentDate = $this->generateWeekdayDate();

                    // Generar un número aleatorio entre 0 y 20 para representar los intervalos de media hora
                    $randomInterval = rand(0, 20);

                    // Sumar las horas y minutos correspondientes a la hora aleatoria
                    $appointmentTime = now()->setTime(8, 0) // Comienza desde las 08:00
                                            ->addMinutes($randomInterval * 30) // Sumar intervalos de 30 minutos
                                            ->format('H:i:s'); // Formato de hora de 24 horas                

                    // Crear la cita
                    $cita = Appointment::create([
                        'patient_id' => $paciente->id,
                        'doctor_id' => $doctor->id,
                        'schedule_id' => $schedule->id,
                        'appointment_date' => $appointmentDate,
                        'appointment_time' => $appointmentTime,
                        'status' => 'programada', // Estado inicial de la cita
                    ]);

                    // Crear el pago
                    Payment::create([
                        'appointment_id' => $cita->id,
                        'uploaded_by' => $paciente->user_id, 
                        'validated_by' => null,
                        'image_path' => null,
                        'payment_method' => 'TARJETA',
                        'amount' => 30,
                        'status' => 'pendiente',
                        'uploaded_at' => now(), // Fecha de subida del comprobante de pago
                        'validated_at' => null, // Aún no validado
                    ]);

                    /* citas pasadas */

                    // Genera una fecha aleatoria en el pasado dentro de los últimos 30 días, pero solo días laborables (lunes a viernes)
                    $appointmentPastDate = $this->generatePastWeekdayDate();

                    // Crear la cita (en el pasado)
                    $cita = Appointment::create([
                        'patient_id' => $paciente->id,
                        'doctor_id' => $doctor->id,
                        'schedule_id' => $schedule->id,
                        'appointment_date' => $appointmentPastDate,
                        'appointment_time' => $appointmentTime,
                        'status' => 'completada', // Estado de cita ya terminada
                    ]);

                    // Crear el pago (suponemos que ya fue pagado)
                    Payment::create([
                        'appointment_id' => $cita->id,
                        'uploaded_by' => $paciente->user_id, 
                        'validated_by' => Secretary::inRandomOrder()->first()->id, // Asignar aleatoriamente una secretaria
                        'image_path' => null,
                        'payment_method' => 'TARJETA',
                        'amount' => 30,
                        'status' => 'validado', // Ya pagado porque la cita fue terminada
                        'validated_at' => now(), // Fecha de validación del pago
                        'uploaded_at' => now(), // Fecha de subida del comprobante de pago
                    ]);

                    // Crear detalle del historial médico (ahora que la cita ya está terminada)
                    $medicalRecord = MedicalRecord::where('patient_id', $paciente->id)->first();
                    if ($medicalRecord) {
                        MedicalRecordDetail::create([
                            'medical_record_id' => $medicalRecord->id,
                            'appointment_id' => $cita->id,
                            'diagnosis' => 'Consulta médica realizada con el doctor ' . $doctor->name,
                            'treatment' => 'Tratamiento aplicado y consultas realizadas con éxito.',
                            'notes' => 'Detalles de la consulta médica realizada.',
                        ]);
                    }
                }
            }
        }
    }

    private function generateWeekdayDate()
    {
        $randomDays = rand(1, 30); // Número de días aleatorios entre 1 y 30

        // Genera una fecha en el futuro
        $date = now()->addDays($randomDays);

        // Si el día es sábado (6) o domingo (7), sumar días hasta que sea lunes
        while ($date->isWeekend()) {
            $date = $date->addDay(); // Sumar un día hasta que caiga en lunes a viernes
        }

        return $date;
    }

    private function generatePastWeekdayDate()
    {
        $randomDays = rand(1, 30); // Número de días aleatorios entre 1 y 30

        // Genera una fecha en el pasado, restando los días aleatorios
        $date = now()->subDays($randomDays);

        // Si el día es sábado (6) o domingo (7), restar días hasta que sea lunes
        while ($date->isWeekend()) {
            $date = $date->subDay(); // Restar un día hasta que caiga en lunes a viernes
        }

        return $date;
    }
}

